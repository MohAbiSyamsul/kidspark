<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tiket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TiketController extends Controller
{
    public function index()
    {
        $data      = Tiket::orderBy('harga')->get();
        $edit_data = null;
        return view('admin.tiket.index', compact('data', 'edit_data'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'jenis_tiket' => 'required|string|max:100',
            'harga'       => 'required|numeric|min:1',
        ], [
            'jenis_tiket.required' => 'Jenis tiket wajib diisi.',
            'harga.required'       => 'Harga wajib diisi.',
            'harga.min'            => 'Harga harus lebih dari 0.',
        ]);

        Tiket::create([
            'jenis_tiket' => $request->jenis_tiket,
            'harga'       => $request->harga,
            'deskripsi'   => $request->deskripsi,
            'id_admin'    => Auth::id(),
        ]);

        return redirect()->route('admin.tiket.index')->with('success', 'Tiket berhasil ditambahkan.');
    }

    public function edit(Tiket $tiket)
    {
        $data = Tiket::orderBy('harga')->get();
        return view('admin.tiket.index', ['data' => $data, 'edit_data' => $tiket]);
    }

    public function update(Request $request, Tiket $tiket)
    {
        $request->validate([
            'jenis_tiket' => 'required|string|max:100',
            'harga'       => 'required|numeric|min:1',
        ]);

        $tiket->update([
            'jenis_tiket' => $request->jenis_tiket,
            'harga'       => $request->harga,
            'deskripsi'   => $request->deskripsi,
        ]);

        return redirect()->route('admin.tiket.index')->with('success', 'Tiket berhasil diperbarui.');
    }

    public function destroy(Tiket $tiket)
    {
        $tiket->delete();
        return redirect()->route('admin.tiket.index')->with('success', 'Tiket berhasil dihapus.');
    }
}
