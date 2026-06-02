<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Models\PesananTiket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class MemberDashboardController extends Controller
{
    private function member(): Member
    {
        return Auth::guard('member')->user();
    }

    public function dashboard()
    {
        $member  = $this->member();
        $pesanan = PesananTiket::where('id_member', $member->id_member)
                    ->with('details.tiket')
                    ->latest()
                    ->limit(5)
                    ->get();

        $totalTransaksi = PesananTiket::where('id_member', $member->id_member)
                           ->where('status_pembayaran', 'lunas')
                           ->count();

        return view('member.dashboard', compact('member', 'pesanan', 'totalTransaksi'));
    }

    public function riwayat()
    {
        $member  = $this->member();
        $pesanan = PesananTiket::where('id_member', $member->id_member)
                    ->with('details.tiket')
                    ->latest()
                    ->paginate(10);

        return view('member.riwayat', compact('member', 'pesanan'));
    }

    public function profil()
    {
        $member = $this->member();
        return view('member.profil', compact('member'));
    }

    public function updateProfil(Request $request)
    {
        $member = $this->member();

        $request->validate([
            'nama_lengkap' => 'required|string|max:100',
            'no_telepon'   => 'nullable|string|max:20',
        ], [
            'nama_lengkap.required' => 'Nama lengkap wajib diisi.',
        ]);

        $member->update([
            'nama_lengkap' => $request->nama_lengkap,
            'no_telepon'   => $request->no_telepon,
        ]);

        return back()->with('success', 'Profil berhasil diperbarui.');
    }

    public function updatePassword(Request $request)
    {
        $member = $this->member();

        $request->validate([
            'current_password' => 'required|string',
            'password'         => 'required|string|min:6|confirmed',
        ], [
            'current_password.required' => 'Password saat ini wajib diisi.',
            'password.required'         => 'Password baru wajib diisi.',
            'password.min'              => 'Password baru minimal 6 karakter.',
            'password.confirmed'        => 'Konfirmasi password tidak cocok.',
        ]);

        if (!Hash::check($request->current_password, $member->password)) {
            return back()->withErrors(['current_password' => 'Password saat ini salah.']);
        }

        $member->update(['password' => Hash::make($request->password)]);

        return back()->with('success', 'Password berhasil diperbarui.');
    }
}
