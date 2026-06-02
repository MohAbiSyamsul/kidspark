<?php

namespace App\Http\Controllers;

use App\Models\Layanan;
use App\Models\Tiket;
use App\Models\Promosi;
use App\Models\Galeri;
use App\Models\Kontak;

class PublicController extends Controller
{
    public function index()
    {
        $layanan = Layanan::orderBy('id_layanan')->get();
        $tiket   = Tiket::orderBy('harga')->get();
        $promosi = Promosi::orderBy('created_at', 'desc')->get();
        $galeri  = Galeri::orderBy('created_at', 'desc')->limit(8)->get();
        $kontak  = Kontak::first();

        $icon_map = [
            'water'       => '🏊',
            'play_arrow'  => '🎪',
            'star'        => '⭐',
            'park'        => '🌿',
            'local_cafe'  => '🍦',
            'sports'      => '⚽',
        ];

        return view('welcome', compact('layanan', 'tiket', 'promosi', 'galeri', 'kontak', 'icon_map'));
    }
}
