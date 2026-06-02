<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PublicController;
use App\Http\Controllers\PublicTicketController;
use App\Http\Controllers\MemberAuthController;
use App\Http\Controllers\MemberDashboardController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\LayananController;
use App\Http\Controllers\Admin\TiketController;
use App\Http\Controllers\Admin\PromosiController;
use App\Http\Controllers\Admin\GaleriController;
use App\Http\Controllers\Admin\KontakController;
use App\Http\Controllers\Admin\ProfilController;
use App\Http\Controllers\Admin\PesananController;
use App\Http\Controllers\Admin\MemberController;

// ── Halaman Publik ────────────────────────────────────────────────
Route::get('/', [PublicController::class, 'index'])->name('home');

// ── Member Auth ───────────────────────────────────────────────────
Route::prefix('member')->name('member.')->group(function () {
    Route::get('/login',    [MemberAuthController::class, 'showLogin'])->name('login');
    Route::post('/login',   [MemberAuthController::class, 'login'])->name('login.post');
    Route::get('/register', [MemberAuthController::class, 'showRegister'])->name('register');
    Route::post('/register',[MemberAuthController::class, 'register'])->name('register.post');
    Route::post('/logout',  [MemberAuthController::class, 'logout'])->name('logout');

    // Protected member area
    Route::middleware('member.auth')->group(function () {
        Route::get('/dashboard', [MemberDashboardController::class, 'dashboard'])->name('dashboard');
        Route::get('/riwayat',   [MemberDashboardController::class, 'riwayat'])->name('riwayat');
        Route::get('/profil',    [MemberDashboardController::class, 'profil'])->name('profil');
        Route::put('/profil',    [MemberDashboardController::class, 'updateProfil'])->name('profil.update');
        Route::put('/profil/password', [MemberDashboardController::class, 'updatePassword'])->name('profil.password');
    });
});

// ── Pembelian Tiket Publik ─────────────────────────────────────────
Route::get('/tiket/beli',                [PublicTicketController::class, 'beli'])->name('tiket.beli');
Route::post('/tiket/beli',               [PublicTicketController::class, 'store'])->name('tiket.store');
Route::get('/tiket/bayar/{kode_booking}', [PublicTicketController::class, 'bayar'])->name('tiket.bayar');
Route::post('/tiket/bayar/{kode_booking}',[PublicTicketController::class, 'uploadBukti'])->name('tiket.upload_bukti');
Route::get('/tiket/status/{kode_booking}',[PublicTicketController::class, 'status'])->name('tiket.status');
Route::get('/tiket/cari',                [PublicTicketController::class, 'cari'])->name('tiket.cari');

// ── Admin Auth ────────────────────────────────────────────────────
Route::prefix('admin')->name('admin.')->group(function () {

    Route::get('/login',  [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');
    Route::post('/logout',[AuthController::class, 'logout'])->name('logout');

    // ── Admin Panel (requires auth) ───────────────────────────────
    Route::middleware('admin.auth')->group(function () {

        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        // Layanan
        Route::get('/layanan',               [LayananController::class, 'index'])->name('layanan.index');
        Route::post('/layanan',              [LayananController::class, 'store'])->name('layanan.store');
        Route::get('/layanan/{layanan}/edit',[LayananController::class, 'edit'])->name('layanan.edit');
        Route::put('/layanan/{layanan}',     [LayananController::class, 'update'])->name('layanan.update');
        Route::delete('/layanan/{layanan}',  [LayananController::class, 'destroy'])->name('layanan.destroy');

        // Tiket
        Route::get('/tiket',             [TiketController::class, 'index'])->name('tiket.index');
        Route::post('/tiket',            [TiketController::class, 'store'])->name('tiket.store');
        Route::get('/tiket/{tiket}/edit',[TiketController::class, 'edit'])->name('tiket.edit');
        Route::put('/tiket/{tiket}',     [TiketController::class, 'update'])->name('tiket.update');
        Route::delete('/tiket/{tiket}',  [TiketController::class, 'destroy'])->name('tiket.destroy');

        // Promosi
        Route::get('/promosi',                [PromosiController::class, 'index'])->name('promosi.index');
        Route::post('/promosi',               [PromosiController::class, 'store'])->name('promosi.store');
        Route::get('/promosi/{promosi}/edit', [PromosiController::class, 'edit'])->name('promosi.edit');
        Route::put('/promosi/{promosi}',      [PromosiController::class, 'update'])->name('promosi.update');
        Route::delete('/promosi/{promosi}',   [PromosiController::class, 'destroy'])->name('promosi.destroy');

        // Galeri
        Route::get('/galeri',             [GaleriController::class, 'index'])->name('galeri.index');
        Route::post('/galeri',            [GaleriController::class, 'store'])->name('galeri.store');
        Route::delete('/galeri/{galeri}', [GaleriController::class, 'destroy'])->name('galeri.destroy');

        // Kontak
        Route::get('/kontak', [KontakController::class, 'index'])->name('kontak.index');
        Route::put('/kontak', [KontakController::class, 'update'])->name('kontak.update');

        // Profil
        Route::get('/profil',          [ProfilController::class, 'index'])->name('profil.index');
        Route::put('/profil',          [ProfilController::class, 'update'])->name('profil.update');
        Route::put('/profil/password', [ProfilController::class, 'updatePassword'])->name('profil.password');

        // Pesanan Tiket
        Route::get('/pesanan',                     [PesananController::class, 'index'])->name('pesanan.index');
        Route::get('/pesanan/{id}',                [PesananController::class, 'show'])->name('pesanan.show');
        Route::post('/pesanan/{id}/konfirmasi',    [PesananController::class, 'confirm'])->name('pesanan.confirm');
        Route::post('/pesanan/{id}/batal',         [PesananController::class, 'cancel'])->name('pesanan.cancel');
        Route::get('/validasi',                    [PesananController::class, 'validasi'])->name('pesanan.validasi');
        Route::post('/validasi',                   [PesananController::class, 'prosesValidasi'])->name('pesanan.proses_validasi');

        // Member Management
        Route::get('/member',                      [MemberController::class, 'index'])->name('member.index');
        Route::get('/member/create',               [MemberController::class, 'create'])->name('member.create');
        Route::post('/member',                     [MemberController::class, 'store'])->name('member.store');
        Route::get('/member/{member}',             [MemberController::class, 'show'])->name('member.show');
        Route::get('/member/{member}/edit',        [MemberController::class, 'edit'])->name('member.edit');
        Route::put('/member/{member}',             [MemberController::class, 'update'])->name('member.update');
        Route::delete('/member/{member}',          [MemberController::class, 'destroy'])->name('member.destroy');
        Route::post('/member/{member}/toggle',     [MemberController::class, 'toggleActive'])->name('member.toggle');
    });
});

// Route sementara untuk mereset dan memigrasi ulang database di Railway
Route::get('/debug/db-reset', function() {
    try {
        \Illuminate\Support\Facades\Schema::disableForeignKeyConstraints();
        $tablesObj = \Illuminate\Support\Facades\DB::select('SHOW TABLES');
        $tables = [];
        foreach ($tablesObj as $tableObj) {
            $tables[] = current((array)$tableObj);
        }
        foreach ($tables as $table) {
            \Illuminate\Support\Facades\Schema::drop($table);
        }
        \Illuminate\Support\Facades\Schema::enableForeignKeyConstraints();

        // Run migrations dengan force
        \Illuminate\Support\Facades\Artisan::call('migrate', ['--force' => true]);

        // Buat symlink storage jika belum ada
        try {
            \Illuminate\Support\Facades\Artisan::call('storage:link');
        } catch (\Exception $e) {
            // Abaikan jika symlink sudah ada
        }

        return "<h1>✅ Database Berhasil Direset!</h1><p>Semua tabel telah dihapus, dimigrasi ulang dengan data SQL terbaru, dan symbolic link storage telah dibuat.</p>";
    } catch (\Exception $e) {
        return "<h1>❌ Error:</h1><p>" . $e->getMessage() . "</p>";
    }
});

