<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PesananTiketDetail extends Model
{
    protected $table = 'pesanan_tiket_detail';
    protected $primaryKey = 'id_detail';

    protected $fillable = [
        'id_pesanan',
        'id_tiket',
        'jumlah',
        'subtotal',
    ];

    protected $casts = [
        'subtotal' => 'decimal:2',
    ];

    public function pesanan()
    {
        return $this->belongsTo(PesananTiket::class, 'id_pesanan', 'id_pesanan');
    }

    public function tiket()
    {
        return $this->belongsTo(Tiket::class, 'id_tiket', 'id_tiket');
    }
}
