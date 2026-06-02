<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tiket extends Model
{
    protected $table = 'tiket';
    protected $primaryKey = 'id_tiket';

    protected $fillable = ['jenis_tiket', 'harga', 'deskripsi', 'id_admin'];

    protected $casts = ['harga' => 'decimal:2'];

    const UPDATED_AT = null;

    public function getRouteKeyName(): string { return 'id_tiket'; }
}
