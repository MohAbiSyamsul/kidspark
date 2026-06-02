<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Galeri extends Model
{
    protected $table = 'galeri';
    protected $primaryKey = 'id_galeri';

    protected $fillable = ['judul_foto', 'gambar', 'id_admin'];

    const UPDATED_AT = null; // tabel galeri tidak punya kolom updated_at

    public function getRouteKeyName(): string { return 'id_galeri'; }
}
