<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('members')) {
            Schema::create('members', function (Blueprint $table) {
                $table->id('id_member');
                $table->string('nama_lengkap', 100);
                $table->string('email', 100)->unique();
                $table->string('password', 255);
                $table->string('no_telepon', 20)->nullable();
                $table->string('no_member', 20)->unique(); // e.g. KP-M-00001
                $table->enum('tier', ['Bronze', 'Silver', 'Gold', 'Platinum'])->default('Bronze');
                $table->integer('total_kunjungan')->default(0);
                $table->decimal('total_belanja', 12, 2)->default(0);
                $table->boolean('is_active')->default(true);
                $table->string('foto', 255)->nullable();
                $table->timestamp('email_verified_at')->nullable();
                $table->rememberToken();
                $table->timestamps();
            });
        }

        // Add id_member FK to pesanan_tiket
        if (Schema::hasTable('pesanan_tiket') && !Schema::hasColumn('pesanan_tiket', 'id_member')) {
            Schema::table('pesanan_tiket', function (Blueprint $table) {
                $table->unsignedBigInteger('id_member')->nullable()->after('kode_booking');
                $table->foreign('id_member')->references('id_member')->on('members')->onDelete('set null');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('pesanan_tiket') && Schema::hasColumn('pesanan_tiket', 'id_member')) {
            Schema::table('pesanan_tiket', function (Blueprint $table) {
                $table->dropForeign(['id_member']);
                $table->dropColumn('id_member');
            });
        }
        Schema::dropIfExists('members');
    }
};
