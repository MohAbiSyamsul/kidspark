<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kontak extends Model
{
    protected $table = 'kontak';
    protected $primaryKey = 'id_kontak';
    public $timestamps = false;

    protected $fillable = [
        'alamat', 'nomor_telepon', 'email', 'instagram', 'tiktok', 'maps', 'jam_operasional', 'id_admin',
    ];
}
