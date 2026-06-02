<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Jika tabel admin belum ada, berarti database kosong (seperti di Railway).
        // Kita import otomatis struktur tabel dasar dari file kidspark_db.sql
        if (!Schema::hasTable('admin')) {
            $sqlPath = base_path('kidspark_db.sql');
            if (file_exists($sqlPath)) {
                $sql = file_get_contents($sqlPath);
                DB::unprepared($sql);
            }
        }
    }

    public function down(): void
    {
        // Kosongkan karena ini adalah tabel basis data awal
    }
};
