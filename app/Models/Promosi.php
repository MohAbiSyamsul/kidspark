<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Promosi extends Model
{
    protected $table = 'promosi';
    protected $primaryKey = 'id_promosi';

    protected $fillable = ['judul_promosi', 'deskripsi', 'tanggal_mulai', 'tanggal_selesai', 'id_admin'];

    protected $casts = [
        'tanggal_mulai'   => 'date',
        'tanggal_selesai' => 'date',
    ];

    const UPDATED_AT = null;

    public function isAktif(): bool
    {
        $today = now()->toDateString();
        return $today >= $this->tanggal_mulai->toDateString()
            && $today <= $this->tanggal_selesai->toDateString();
    }

    public function getRouteKeyName(): string { return 'id_promosi'; }
}
