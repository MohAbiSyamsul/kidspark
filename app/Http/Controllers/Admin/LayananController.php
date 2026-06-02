<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Layanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class LayananController extends Controller
{
    public function index(Request $request)
    {
        $data      = Layanan::orderBy('id_layanan')->get();
        $edit_data = $request->has('edit') ? Layanan::findOrFail($request->edit) : null;
        return view('admin.layanan.index', compact('data', 'edit_data'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_layanan' => 'required|string|max:100',
            'gambar'       => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
        ], [
            'nama_layanan.required' => 'Nama layanan wajib diisi.',
            'gambar.image'          => 'File harus berupa gambar.',
            'gambar.mimes'          => 'Format gambar harus JPG, JPEG, PNG, atau WEBP.',
            'gambar.max'            => 'Ukuran gambar maksimal 5MB.',
        ]);

        $filename = null;
        if ($request->hasFile('gambar')) {
            $file     = $request->file('gambar');
            $filename = 'layanan/' . uniqid() . '_' . time() . '.' . $file->getClientOriginalExtension();
            $file->storeAs('uploads', $filename, 'public');
        }

        Layanan::create([
            'nama_layanan' => $request->nama_layanan,
            'deskripsi'    => $request->deskripsi,
            'icon'         => $request->icon ?? 'star',
            'gambar'       => $filename,
            'id_admin'     => Auth::id(),
        ]);

        return redirect()->route('admin.layanan.index')->with('success', 'Layanan berhasil ditambahkan.');
    }

    public function edit(Layanan $layanan)
    {
        $data = Layanan::orderBy('id_layanan')->get();
        return view('admin.layanan.index', ['data' => $data, 'edit_data' => $layanan]);
    }

    public function update(Request $request, Layanan $layanan)
    {
        $request->validate([
            'nama_layanan' => 'required|string|max:100',
            'gambar'       => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
        ], [
            'nama_layanan.required' => 'Nama layanan wajib diisi.',
            'gambar.image'          => 'File harus berupa gambar.',
            'gambar.mimes'          => 'Format gambar harus JPG, JPEG, PNG, atau WEBP.',
            'gambar.max'            => 'Ukuran gambar maksimal 5MB.',
        ]);

        $data = [
            'nama_layanan' => $request->nama_layanan,
            'deskripsi'    => $request->deskripsi,
            'icon'         => $request->icon ?? 'star',
        ];

        if ($request->hasFile('gambar')) {
            if ($layanan->gambar) {
                Storage::disk('public')->delete('uploads/' . $layanan->gambar);
            }
            $file     = $request->file('gambar');
            $filename = 'layanan/' . uniqid() . '_' . time() . '.' . $file->getClientOriginalExtension();
            $file->storeAs('uploads', $filename, 'public');
            $data['gambar'] = $filename;
        }

        $layanan->update($data);

        return redirect()->route('admin.layanan.index')->with('success', 'Layanan berhasil diperbarui.');
    }

    public function destroy(Layanan $layanan)
    {
        if ($layanan->gambar) {
            Storage::disk('public')->delete('uploads/' . $layanan->gambar);
        }
        $layanan->delete();
        return redirect()->route('admin.layanan.index')->with('success', 'Layanan berhasil dihapus.');
    }
}
