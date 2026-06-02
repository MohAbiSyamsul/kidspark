<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PesananTiket extends Model
{
    protected $table = 'pesanan_tiket';
    protected $primaryKey = 'id_pesanan';

    protected $fillable = [
        'kode_booking',
        'id_member',
        'nama_pengunjung',
        'email_pengunjung',
        'telepon_pengunjung',
        'tanggal_kunjungan',
        'total_bayar',
        'bukti_pembayaran',
        'status_pembayaran',
        'status_kunjungan',
        'kunjungan_validated_at',
    ];

    protected $casts = [
        'tanggal_kunjungan' => 'date',
        'total_bayar' => 'decimal:2',
        'kunjungan_validated_at' => 'datetime',
    ];

    public function details()
    {
        return $this->hasMany(PesananTiketDetail::class, 'id_pesanan', 'id_pesanan');
    }

    public function member()
    {
        return $this->belongsTo(Member::class, 'id_member', 'id_member');
    }
}
