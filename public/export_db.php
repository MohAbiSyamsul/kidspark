<?php
// Script untuk mengekspor database lokal ke kidspark_db.sql secara otomatis

require_once __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

try {
    // Ambil koneksi PDO
    $pdo = DB::getPdo();
    
    // Matikan check foreign key saat dump
    $sql = "SET FOREIGN_KEY_CHECKS=0;\n\n";
    
    // Dapatkan semua nama tabel menggunakan query raw SQL agar kompatibel di Laravel 11
    $tablesObj = DB::select('SHOW TABLES');
    $tables = [];
    foreach ($tablesObj as $tableObj) {
        $tables[] = current((array)$tableObj);
    }
    
    foreach ($tables as $table) {
        // Jangan ekspor tabel migrations & sessions milik Laravel agar tidak bentrok
        if (in_array($table, ['migrations', 'sessions'])) {
            continue;
        }
        
        // Hapus tabel jika sudah ada
        $sql .= "DROP TABLE IF EXISTS `$table`;\n";
        
        // Dapatkan query CREATE TABLE
        $createObj = DB::select("SHOW CREATE TABLE `$table`")[0];
        $createSql = $createObj->{'Create Table'};
        $sql .= $createSql . ";\n\n";
        
        // Dapatkan semua data dari tabel tersebut
        $rows = DB::table($table)->get();
        if ($rows->count() > 0) {
            $sql .= "INSERT INTO `$table` VALUES \n";
            $inserts = [];
            foreach ($rows as $row) {
                $values = [];
                foreach ((array)$row as $val) {
                    if (is_null($val)) {
                        $values[] = "NULL";
                    } else {
                        $values[] = $pdo->quote($val);
                    }
                }
                $inserts[] = "(" . implode(", ", $values) . ")";
            }
            $sql .= implode(",\n", $inserts) . ";\n\n";
        }
    }
    
    $sql .= "SET FOREIGN_KEY_CHECKS=1;\n";
    
    // Tulis ke file kidspark_db.sql di root directory
    $outputPath = __DIR__ . '/../kidspark_db.sql';
    file_put_contents($outputPath, $sql);
    
    echo "<h1>✅ Sukses!</h1>";
    echo "<p>Database lokal berhasil diekspor ke: <strong>kidspark_db.sql</strong></p>";
    echo "<p>Silakan lakukan Git Commit & Push sekarang, lalu jalankan reset database di live server.</p>";
    
} catch (\Exception $e) {
    echo "<h1>❌ Error!</h1>";
    echo "<p>" . $e->getMessage() . "</p>";
}
