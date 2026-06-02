<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('pesanan_tiket')) {
            Schema::create('pesanan_tiket', function (Blueprint $table) {
                $table->id('id_pesanan');
                $table->string('kode_booking', 20)->unique();
                $table->string('nama_pengunjung', 100);
                $table->string('email_pengunjung', 100);
                $table->string('telepon_pengunjung', 20);
                $table->date('tanggal_kunjungan');
                $table->decimal('total_bayar', 10, 2);
                $table->string('bukti_pembayaran', 255)->nullable();
                $table->enum('status_pembayaran', ['pending', 'menunggu_konfirmasi', 'lunas', 'batal'])->default('pending');
                $table->enum('status_kunjungan', ['belum_hadir', 'sudah_hadir'])->default('belum_hadir');
                $table->timestamp('kunjungan_validated_at')->nullable();
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('pesanan_tiket_detail')) {
            Schema::create('pesanan_tiket_detail', function (Blueprint $table) {
                $table->id('id_detail');
                // Use unsignedBigInteger for the foreign key matching the auto-increment id_pesanan (bigint)
                $table->unsignedBigInteger('id_pesanan');
                $table->integer('id_tiket');
                $table->integer('jumlah');
                $table->decimal('subtotal', 10, 2);
                $table->timestamps();

                $table->foreign('id_pesanan')->references('id_pesanan')->on('pesanan_tiket')->onDelete('cascade');
                $table->foreign('id_tiket')->references('id_tiket')->on('tiket')->onDelete('cascade');
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('pesanan_tiket_detail');
        Schema::dropIfExists('pesanan_tiket');
    }
};
