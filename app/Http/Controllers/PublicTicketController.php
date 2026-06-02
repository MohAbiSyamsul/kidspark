<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Models\Tiket;
use App\Models\Kontak;
use App\Models\PesananTiket;
use App\Models\PesananTiketDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PublicTicketController extends Controller
{
    private function activeMember(): ?Member
    {
        return Auth::guard('member')->user();
    }

    public function beli()
    {
        $member = $this->activeMember();

        // If not logged in as member, redirect to member login
        if (!$member) {
            return redirect()->route('member.login')
                ->with('info', 'Silakan login sebagai member untuk membeli tiket.');
        }

        if (!$member->is_active) {
            return redirect()->route('member.dashboard')
                ->with('error', 'Akun member Anda tidak aktif. Hubungi pengelola.');
        }

        $tiket  = Tiket::orderBy('harga')->get();
        $kontak = Kontak::first();
        return view('tiket.beli', compact('tiket', 'kontak', 'member'));
    }

    public function store(Request $request)
    {
        $member = $this->activeMember();
        if (!$member) {
            return redirect()->route('member.login')
                ->with('info', 'Silakan login sebagai member untuk membeli tiket.');
        }

        $request->validate([
            'nama_pengunjung'    => 'required|string|max:100',
            'email_pengunjung'   => 'required|email|max:100',
            'telepon_pengunjung' => 'required|string|max:20',
            'tanggal_kunjungan'  => 'required|date|after_or_equal:today',
            'tiket_qty'          => 'required|array',
        ], [
            'nama_pengunjung.required'    => 'Nama lengkap wajib diisi.',
            'email_pengunjung.required'   => 'Alamat email wajib diisi.',
            'email_pengunjung.email'      => 'Format email tidak valid.',
            'telepon_pengunjung.required' => 'Nomor WhatsApp wajib diisi.',
            'tanggal_kunjungan.required'  => 'Tanggal kunjungan wajib diisi.',
            'tanggal_kunjungan.after_or_equal' => 'Tanggal kunjungan tidak boleh di masa lalu.',
        ]);

        $qty_items   = $request->input('tiket_qty', []);
        $total_qty   = 0;
        $total_bayar = 0;
        $items_to_save = [];

        foreach ($qty_items as $id_tiket => $qty) {
            $qty = intval($qty);
            if ($qty > 0) {
                $tiket = Tiket::find($id_tiket);
                if ($tiket) {
                    $total_qty   += $qty;
                    $subtotal     = $tiket->harga * $qty;
                    $total_bayar += $subtotal;
                    $items_to_save[] = [
                        'id_tiket' => $tiket->id_tiket,
                        'harga'    => $tiket->harga,
                        'jumlah'   => $qty,
                        'subtotal' => $subtotal,
                    ];
                }
            }
        }

        if ($total_qty <= 0) {
            return redirect()->back()->withInput()->with('error', 'Silakan pilih minimal 1 tiket untuk dibeli.');
        }

        // Apply member discount
        $diskon_persen = $member->diskon; // 0, 5, 10, or 15
        $diskon_nominal = $total_bayar * ($diskon_persen / 100);
        $total_bayar_final = $total_bayar - $diskon_nominal;

        try {
            DB::beginTransaction();

            do {
                $kode_booking = 'KP-' . date('Ymd', strtotime($request->tanggal_kunjungan)) . '-' . strtoupper(Str::random(4));
            } while (PesananTiket::where('kode_booking', $kode_booking)->exists());

            $pesanan = PesananTiket::create([
                'kode_booking'       => $kode_booking,
                'id_member'          => $member->id_member,
                'nama_pengunjung'    => $request->nama_pengunjung,
                'email_pengunjung'   => $request->email_pengunjung,
                'telepon_pengunjung' => $request->telepon_pengunjung,
                'tanggal_kunjungan'  => $request->tanggal_kunjungan,
                'total_bayar'        => $total_bayar_final,
                'status_pembayaran'  => 'pending',
                'status_kunjungan'   => 'belum_hadir',
            ]);

            foreach ($items_to_save as $item) {
                PesananTiketDetail::create([
                    'id_pesanan' => $pesanan->id_pesanan,
                    'id_tiket'   => $item['id_tiket'],
                    'jumlah'     => $item['jumlah'],
                    'subtotal'   => $item['subtotal'],
                ]);
            }

            DB::commit();

            $msg = 'Pesanan berhasil dibuat!';
            if ($diskon_persen > 0) {
                $msg .= " Diskon {$diskon_persen}% member ({$member->tier}) telah diterapkan.";
            }
            $msg .= ' Silakan selesaikan pembayaran.';

            return redirect()->route('tiket.bayar', $kode_booking)->with('success', $msg);
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withInput()->with('error', 'Terjadi kesalahan sistem: ' . $e->getMessage());
        }
    }

    public function bayar($kode_booking)
    {
        $pesanan = PesananTiket::where('kode_booking', $kode_booking)->firstOrFail();

        if ($pesanan->status_pembayaran === 'lunas') {
            return redirect()->route('tiket.status', $kode_booking);
        }

        $kontak = Kontak::first();
        return view('tiket.bayar', compact('pesanan', 'kontak'));
    }

    public function uploadBukti(Request $request, $kode_booking)
    {
        $pesanan = PesananTiket::where('kode_booking', $kode_booking)->firstOrFail();

        $request->validate([
            'bukti_pembayaran' => 'required|image|mimes:jpg,jpeg,png,webp|max:5120',
        ], [
            'bukti_pembayaran.required' => 'Pilih file bukti pembayaran terlebih dahulu.',
            'bukti_pembayaran.image'    => 'File harus berupa gambar.',
            'bukti_pembayaran.mimes'    => 'Format gambar tidak didukung. Gunakan JPG, PNG, atau WEBP.',
            'bukti_pembayaran.max'      => 'Ukuran file maksimal 5MB.',
        ]);

        if ($pesanan->bukti_pembayaran) {
            Storage::disk('public')->delete('uploads/' . $pesanan->bukti_pembayaran);
        }

        $file     = $request->file('bukti_pembayaran');
        $filename = uniqid() . '_' . time() . '.' . $file->getClientOriginalExtension();
        $file->storeAs('uploads/bukti_bayar', $filename, 'public');

        $pesanan->update([
            'bukti_pembayaran' => 'bukti_bayar/' . $filename,
            'status_pembayaran' => 'menunggu_konfirmasi',
        ]);

        return redirect()->route('tiket.status', $kode_booking)
            ->with('success', 'Bukti pembayaran berhasil diunggah! Mohon tunggu konfirmasi admin.');
    }

    public function status($kode_booking)
    {
        $pesanan = PesananTiket::with('details.tiket', 'member')
                    ->where('kode_booking', $kode_booking)
                    ->firstOrFail();
        return view('tiket.status', compact('pesanan'));
    }

    public function cari(Request $request)
    {
        $kode = $request->input('kode_booking');
        if ($kode) {
            $pesanan = PesananTiket::where('kode_booking', trim($kode))->first();
            if ($pesanan) {
                return redirect()->route('tiket.status', $pesanan->kode_booking);
            }
            return redirect()->back()->with('error', 'Kode Booking tidak ditemukan. Silakan periksa kembali.');
        }
        return view('tiket.cari');
    }
}
