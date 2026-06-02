<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Galeri;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class GaleriController extends Controller
{
    public function index()
    {
        $data = Galeri::orderBy('created_at', 'desc')->get();
        return view('admin.galeri.index', compact('data'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul_foto' => 'required|string|max:150',
            'gambar'     => 'required|image|mimes:jpg,jpeg,png,webp|max:5120',
        ], [
            'judul_foto.required' => 'Judul foto wajib diisi.',
            'gambar.required'     => 'Pilih file gambar terlebih dahulu.',
            'gambar.image'        => 'File harus berupa gambar.',
            'gambar.mimes'        => 'Format file tidak didukung. Gunakan JPG, PNG, atau WEBP.',
            'gambar.max'          => 'Ukuran file maksimal 5MB.',
        ]);

        $file     = $request->file('gambar');
        $filename = uniqid() . '_' . time() . '.' . $file->getClientOriginalExtension();
        $file->storeAs('uploads/galeri', $filename, 'public');

        Galeri::create([
            'judul_foto' => $request->judul_foto,
            'gambar'     => 'galeri/' . $filename,
            'id_admin'   => Auth::id(),
        ]);

        return redirect()->route('admin.galeri.index')->with('success', 'Foto berhasil ditambahkan ke galeri.');
    }

    public function destroy(Galeri $galeri)
    {
        Storage::disk('public')->delete('uploads/' . $galeri->gambar);
        $galeri->delete();
        return redirect()->route('admin.galeri.index')->with('success', 'Foto berhasil dihapus dari galeri.');
    }
}
