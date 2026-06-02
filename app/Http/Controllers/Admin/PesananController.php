<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Member;
use App\Models\PesananTiket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PesananController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->input('status', 'all');
        $search = $request->input('search');

        $query = PesananTiket::with('member')->orderBy('created_at', 'desc');

        if ($status !== 'all') {
            $query->where('status_pembayaran', $status);
        }

        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('kode_booking', 'like', '%' . $search . '%')
                  ->orWhere('nama_pengunjung', 'like', '%' . $search . '%')
                  ->orWhere('telepon_pengunjung', 'like', '%' . $search . '%');
            });
        }

        $pesanan = $query->paginate(15)->withQueryString();

        return view('admin.pesanan.index', compact('pesanan', 'status', 'search'));
    }

    public function show($id)
    {
        $pesanan = PesananTiket::with('details.tiket', 'member')->findOrFail($id);
        return view('admin.pesanan.show', compact('pesanan'));
    }

    public function confirm($id)
    {
        $pesanan = PesananTiket::findOrFail($id);
        $pesanan->update(['status_pembayaran' => 'lunas']);

        // Update member total_belanja if linked
        $this->updateMemberStats($pesanan);

        return redirect()->route('admin.pesanan.show', $id)
            ->with('success', 'Pembayaran berhasil dikonfirmasi. Tiket aktif.');
    }

    public function cancel($id)
    {
        $pesanan = PesananTiket::findOrFail($id);
        $pesanan->update(['status_pembayaran' => 'batal']);

        return redirect()->route('admin.pesanan.show', $id)
            ->with('success', 'Pesanan berhasil dibatalkan.');
    }

    public function validasi(Request $request)
    {
        $kode   = trim($request->input('kode_booking'));
        $pesanan = null;
        $error  = null;

        if ($kode) {
            $pesanan = PesananTiket::with('details.tiket', 'member')->where('kode_booking', $kode)->first();
            if (!$pesanan) {
                $error = 'Kode Booking tidak ditemukan. Pastikan format benar (contoh: KP-YYYYMMDD-XXXX).';
            }
        }

        return view('admin.pesanan.validasi', compact('pesanan', 'error', 'kode'));
    }

    public function prosesValidasi(Request $request)
    {
        $request->validate([
            'id_pesanan' => 'required|exists:pesanan_tiket,id_pesanan',
            'action'     => 'nullable|string'
        ]);

        $pesanan = PesananTiket::with('details')->findOrFail($request->id_pesanan);

        if ($request->input('action') === 'bayar_dan_masuk') {
            if ($pesanan->status_kunjungan === 'sudah_hadir') {
                return redirect()->back()->with('error', 'Gagal validasi: Tiket sudah pernah digunakan!');
            }

            $pesanan->update([
                'status_pembayaran'      => 'lunas',
                'status_kunjungan'       => 'sudah_hadir',
                'kunjungan_validated_at' => now(),
            ]);

            $this->updateMemberStats($pesanan);
            $this->updateMemberVisit($pesanan);

            return redirect()->route('admin.pesanan.validasi', ['kode_booking' => $pesanan->kode_booking])
                             ->with('success', 'PEMBAYARAN & MASUK BERHASIL! Selamat Datang, ' . $pesanan->nama_pengunjung . ' (' . $pesanan->details->sum('jumlah') . ' Orang).');
        }

        if ($pesanan->status_pembayaran !== 'lunas') {
            return redirect()->back()->with('error', 'Gagal validasi: Pembayaran tiket belum lunas!');
        }

        if ($pesanan->status_kunjungan === 'sudah_hadir') {
            return redirect()->back()->with('error', 'Gagal validasi: Tiket sudah pernah digunakan pada ' . $pesanan->kunjungan_validated_at->format('d M Y H:i') . ' WIB!');
        }

        $pesanan->update([
            'status_kunjungan'       => 'sudah_hadir',
            'kunjungan_validated_at' => now(),
        ]);

        $this->updateMemberVisit($pesanan);

        return redirect()->route('admin.pesanan.validasi', ['kode_booking' => $pesanan->kode_booking])
                         ->with('success', 'VALIDASI BERHASIL! Selamat Datang, ' . $pesanan->nama_pengunjung . ' (' . $pesanan->details->sum('jumlah') . ' Orang).');
    }

    /**
     * Update member total_belanja when payment confirmed.
     */
    private function updateMemberStats(PesananTiket $pesanan): void
    {
        if (!$pesanan->id_member) return;
        $member = Member::find($pesanan->id_member);
        if (!$member) return;

        $member->increment('total_belanja', $pesanan->total_bayar);
        $newTier = Member::computeTier($member->fresh()->total_kunjungan);
        $member->update(['tier' => $newTier]);
    }

    /**
     * Increment member total_kunjungan when visit is validated.
     */
    private function updateMemberVisit(PesananTiket $pesanan): void
    {
        if (!$pesanan->id_member) return;
        $member = Member::find($pesanan->id_member);
        if (!$member) return;

        $member->increment('total_kunjungan');
        $newTier = Member::computeTier($member->fresh()->total_kunjungan);
        $member->update(['tier' => $newTier]);
    }
}
