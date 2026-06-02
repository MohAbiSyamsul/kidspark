<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ProfilController extends Controller
{
    public function index()
    {
        $admin = Auth::user();
        return view('admin.profil.index', compact('admin'));
    }

    public function update(Request $request)
    {
        $admin = Auth::user();

        $request->validate([
            'nama'    => 'nullable|string|max:100',
            'jabatan' => 'nullable|string|max:100',
            'foto'    => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $data = [
            'nama'    => $request->nama,
            'jabatan' => $request->jabatan,
        ];

        if ($request->hasFile('foto')) {
            // Hapus foto lama jika ada
            if ($admin->foto) {
                Storage::disk('public')->delete('uploads/profil/' . $admin->foto);
            }
            $file     = $request->file('foto');
            $filename = uniqid() . '_' . time() . '.' . $file->getClientOriginalExtension();
            $file->storeAs('uploads/profil', $filename, 'public');
            $data['foto'] = $filename;
        }

        $admin->update($data);
        return redirect()->route('admin.profil.index')->with('success', 'Profil berhasil diperbarui.');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'password_lama' => 'required',
            'password_baru' => 'required|min:6|confirmed',
        ], [
            'password_lama.required' => 'Password lama wajib diisi.',
            'password_baru.required' => 'Password baru wajib diisi.',
            'password_baru.min'      => 'Password minimal 6 karakter.',
            'password_baru.confirmed'=> 'Konfirmasi password tidak cocok.',
        ]);

        $admin = Auth::user();
        if (!Hash::check($request->password_lama, $admin->password)) {
            return back()->withErrors(['password_lama' => 'Password lama tidak cocok.']);
        }

        $admin->update(['password' => Hash::make($request->password_baru)]);
        return redirect()->route('admin.profil.index')->with('success', 'Password berhasil diubah.');
    }
}
