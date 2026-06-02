<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kontak;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KontakController extends Controller
{
    public function index()
    {
        $kontak = Kontak::first();
        return view('admin.kontak.index', compact('kontak'));
    }

    public function update(Request $request)
    {
        $data = [
            'alamat'          => $request->alamat,
            'nomor_telepon'   => $request->nomor_telepon,
            'email'           => $request->email,
            'instagram'       => $request->instagram,
            'tiktok'          => $request->tiktok,
            'maps'            => $request->maps,
            'jam_operasional' => $request->jam_operasional,
        ];

        $existing = Kontak::first();
        if ($existing) {
            $existing->update($data);
        } else {
            Kontak::create(array_merge($data, ['id_admin' => Auth::id()]));
        }

        return redirect()->route('admin.kontak.index')->with('success', 'Informasi kontak berhasil diperbarui.');
    }
}
