<?php

namespace App\Http\Controllers;

use App\Models\Member;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class MemberAuthController extends Controller
{
    // ── REGISTER ─────────────────────────────────────────────────────

    public function showRegister()
    {
        if (Auth::guard('member')->check()) {
            return redirect()->route('member.dashboard');
        }
        return view('member.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'nama_lengkap' => 'required|string|max:100',
            'email'        => 'required|email|max:100|unique:members,email',
            'no_telepon'   => 'nullable|string|max:20',
            'password'     => 'required|string|min:6|confirmed',
        ], [
            'nama_lengkap.required' => 'Nama lengkap wajib diisi.',
            'email.required'        => 'Email wajib diisi.',
            'email.unique'          => 'Email sudah terdaftar. Silakan login.',
            'password.required'     => 'Password wajib diisi.',
            'password.min'          => 'Password minimal 6 karakter.',
            'password.confirmed'    => 'Konfirmasi password tidak cocok.',
        ]);

        $member = Member::create([
            'nama_lengkap'  => $request->nama_lengkap,
            'email'         => $request->email,
            'no_telepon'    => $request->no_telepon,
            'password'      => Hash::make($request->password),
            'no_member'     => Member::generateNoMember(),
            'tier'          => 'Bronze',
            'total_kunjungan' => 0,
            'total_belanja' => 0,
            'is_active'     => false,
        ]);

        return redirect()->route('member.login')
            ->with('success', 'Akun member Anda telah dibuat dan menunggu konfirmasi admin. Silakan login kembali setelah akun disetujui.');
    }

    // ── LOGIN ─────────────────────────────────────────────────────────

    public function showLogin()
    {
        if (Auth::guard('member')->check()) {
            return redirect()->route('member.dashboard');
        }
        return view('member.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required|string',
        ], [
            'email.required'    => 'Email wajib diisi.',
            'password.required' => 'Password wajib diisi.',
        ]);

        $member = Member::where('email', $request->email)->first();

        if (!$member || !Hash::check($request->password, $member->password)) {
            return back()->withErrors(['login' => 'Email atau password salah.'])->withInput($request->only('email'));
        }

        if (!$member->is_active) {
            return back()->withErrors(['login' => 'Akun Anda belum dikonfirmasi oleh admin. Mohon tunggu konfirmasi sebelum login.'])->withInput($request->only('email'));
        }

        Auth::guard('member')->login($member, $request->boolean('remember'));
        $request->session()->regenerate();

        // Redirect to intended page or dashboard
        return redirect()->intended(route('member.dashboard'))
            ->with('success', 'Selamat datang kembali, ' . $member->nama_lengkap . '!');
    }

    // ── LOGOUT ────────────────────────────────────────────────────────

    public function logout(Request $request)
    {
        Auth::guard('member')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('member.login')->with('success', 'Anda berhasil keluar.');
    }
}
