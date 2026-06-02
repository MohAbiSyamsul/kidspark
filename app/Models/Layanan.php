<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Layanan extends Model
{
    protected $table = 'layanan';
    protected $primaryKey = 'id_layanan';

    protected $fillable = ['nama_layanan', 'deskripsi', 'icon', 'gambar', 'id_admin'];

    const UPDATED_AT = null;

    public function getRouteKeyName(): string { return 'id_layanan'; }
}
