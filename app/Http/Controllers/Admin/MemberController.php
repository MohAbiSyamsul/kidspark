<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Member;
use App\Models\PesananTiket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class MemberController extends Controller
{
    public function index(Request $request)
    {
        $query = Member::withCount([
            'pesanan as total_pesanan_lunas' => fn($q) => $q->where('status_pembayaran', 'lunas'),
        ])->orderBy('total_kunjungan', 'desc');

        if ($request->filled('search')) {
            $s = $request->search;
            $query->where(function ($q) use ($s) {
                $q->where('nama_lengkap', 'like', "%$s%")
                  ->orWhere('email', 'like', "%$s%")
                  ->orWhere('no_member', 'like', "%$s%");
            });
        }

        if ($request->filled('tier')) {
            $query->where('tier', $request->tier);
        }

        $members = $query->paginate(15)->withQueryString();

        $stats = [
            'total'    => Member::count(),
            'active'   => Member::where('is_active', true)->count(),
            'bronze'   => Member::where('tier', 'Bronze')->count(),
            'silver'   => Member::where('tier', 'Silver')->count(),
            'gold'     => Member::where('tier', 'Gold')->count(),
            'platinum' => Member::where('tier', 'Platinum')->count(),
        ];

        return view('admin.member.index', compact('members', 'stats'));
    }

    public function create()
    {
        return view('admin.member.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_lengkap'   => 'required|string|max:100',
            'email'          => 'required|email|max:100|unique:members,email',
            'no_telepon'     => 'nullable|string|max:20',
            'password'       => 'required|string|min:6|confirmed',
            'total_kunjungan'=> 'nullable|integer|min:0',
        ], [
            'nama_lengkap.required' => 'Nama lengkap wajib diisi.',
            'email.unique'          => 'Email sudah terdaftar.',
            'password.required'     => 'Password wajib diisi.',
            'password.min'          => 'Password minimal 6 karakter.',
            'password.confirmed'    => 'Konfirmasi password tidak cocok.',
        ]);

        $kunjungan = (int) $request->input('total_kunjungan', 0);
        $tier = Member::computeTier($kunjungan);

        Member::create([
            'nama_lengkap'    => $request->nama_lengkap,
            'email'           => $request->email,
            'no_telepon'      => $request->no_telepon,
            'password'        => Hash::make($request->password),
            'no_member'       => Member::generateNoMember(),
            'tier'            => $tier,
            'total_kunjungan' => $kunjungan,
            'total_belanja'   => 0,
            'is_active'       => $request->boolean('is_active', true),
        ]);

        return redirect()->route('admin.member.index')
            ->with('success', 'Member baru berhasil ditambahkan.');
    }

    public function show(Member $member)
    {
        $pesanan = PesananTiket::where('id_member', $member->id_member)
                    ->with('details.tiket')
                    ->latest()
                    ->paginate(10);

        return view('admin.member.show', compact('member', 'pesanan'));
    }

    public function edit(Member $member)
    {
        return view('admin.member.edit', compact('member'));
    }

    public function update(Request $request, Member $member)
    {
        $request->validate([
            'nama_lengkap'    => 'required|string|max:100',
            'email'           => 'required|email|max:100|unique:members,email,' . $member->id_member . ',id_member',
            'no_telepon'      => 'nullable|string|max:20',
            'total_kunjungan' => 'required|integer|min:0',
        ], [
            'nama_lengkap.required'    => 'Nama lengkap wajib diisi.',
            'email.unique'             => 'Email sudah digunakan member lain.',
            'total_kunjungan.required' => 'Total kunjungan wajib diisi.',
        ]);

        $kunjungan = (int) $request->total_kunjungan;
        $tier = Member::computeTier($kunjungan);

        $member->update([
            'nama_lengkap'    => $request->nama_lengkap,
            'email'           => $request->email,
            'no_telepon'      => $request->no_telepon,
            'total_kunjungan' => $kunjungan,
            'tier'            => $tier,
            'is_active'       => $request->boolean('is_active'),
        ]);

        // Update password if provided
        if ($request->filled('password')) {
            $request->validate(['password' => 'string|min:6|confirmed']);
            $member->update(['password' => Hash::make($request->password)]);
        }

        return redirect()->route('admin.member.index')
            ->with('success', 'Data member berhasil diperbarui.');
    }

    public function destroy(Member $member)
    {
        $member->delete();
        return redirect()->route('admin.member.index')
            ->with('success', 'Member berhasil dihapus.');
    }

    /**
     * Toggle active status
     */
    public function toggleActive(Member $member)
    {
        $member->update(['is_active' => !$member->is_active]);
        $status = $member->is_active ? 'diaktifkan' : 'dinonaktifkan';
        return back()->with('success', "Member {$member->nama_lengkap} berhasil {$status}.");
    }
}
