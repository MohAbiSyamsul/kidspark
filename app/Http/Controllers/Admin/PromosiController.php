<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Promosi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PromosiController extends Controller
{
    public function index()
    {
        $data      = Promosi::orderBy('created_at', 'desc')->get();
        $edit_data = null;
        return view('admin.promosi.index', compact('data', 'edit_data'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul_promosi'  => 'required|string|max:150',
            'tanggal_mulai'  => 'required|date',
            'tanggal_selesai'=> 'required|date|gte:tanggal_mulai',
        ], [
            'judul_promosi.required'   => 'Judul promosi wajib diisi.',
            'tanggal_mulai.required'   => 'Tanggal mulai wajib diisi.',
            'tanggal_selesai.required' => 'Tanggal selesai wajib diisi.',
            'tanggal_selesai.gte'      => 'Tanggal selesai tidak boleh sebelum tanggal mulai.',
        ]);

        Promosi::create([
            'judul_promosi'  => $request->judul_promosi,
            'deskripsi'      => $request->deskripsi,
            'tanggal_mulai'  => $request->tanggal_mulai,
            'tanggal_selesai'=> $request->tanggal_selesai,
            'id_admin'       => Auth::id(),
        ]);

        return redirect()->route('admin.promosi.index')->with('success', 'Promosi berhasil ditambahkan.');
    }

    public function edit(Promosi $promosi)
    {
        $data = Promosi::orderBy('created_at', 'desc')->get();
        return view('admin.promosi.index', ['data' => $data, 'edit_data' => $promosi]);
    }

    public function update(Request $request, Promosi $promosi)
    {
        $request->validate([
            'judul_promosi'  => 'required|string|max:150',
            'tanggal_mulai'  => 'required|date',
            'tanggal_selesai'=> 'required|date|gte:tanggal_mulai',
        ], [
            'tanggal_selesai.gte' => 'Tanggal selesai tidak boleh sebelum tanggal mulai.',
        ]);

        $promosi->update([
            'judul_promosi'  => $request->judul_promosi,
            'deskripsi'      => $request->deskripsi,
            'tanggal_mulai'  => $request->tanggal_mulai,
            'tanggal_selesai'=> $request->tanggal_selesai,
        ]);

        return redirect()->route('admin.promosi.index')->with('success', 'Promosi berhasil diperbarui.');
    }

    public function destroy(Promosi $promosi)
    {
        $promosi->delete();
        return redirect()->route('admin.promosi.index')->with('success', 'Promosi berhasil dihapus.');
    }
}
