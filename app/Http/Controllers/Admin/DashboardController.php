<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Layanan;
use App\Models\Tiket;
use App\Models\Promosi;
use App\Models\Galeri;
use App\Models\PesananTiket;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Artisan;

class DashboardController extends Controller
{
    public function index()
    {
        // Auto-migration check
        if (!Schema::hasTable('pesanan_tiket') || !Schema::hasColumn('layanan', 'gambar') || !Schema::hasTable('members')) {
            try {
                Artisan::call('migrate', ['--force' => true]);
            } catch (\Exception $e) {
                // Silently ignore or log error
            }
        }

        $total_layanan = Layanan::count();
        $total_tiket   = Tiket::count();
        $total_promosi = Promosi::count();
        $total_galeri  = Galeri::count();
        $promo_aktif   = Promosi::whereDate('tanggal_mulai', '<=', now())
                                 ->whereDate('tanggal_selesai', '>=', now())
                                 ->count();

        $recent_promosi = Promosi::orderBy('created_at', 'desc')->limit(5)->get();

        // Ticket Purchase Stats (if table exists)
        $revenue = 0;
        $validated_today = 0;
        $pending_confirmation = 0;

        if (Schema::hasTable('pesanan_tiket')) {
            $revenue = PesananTiket::where('status_pembayaran', 'lunas')->sum('total_bayar');
            $validated_today = PesananTiket::where('status_kunjungan', 'sudah_hadir')
                ->whereDate('kunjungan_validated_at', now()->toDateString())
                ->count();
            $pending_confirmation = PesananTiket::where('status_pembayaran', 'menunggu_konfirmasi')->count();
        }

        return view('admin.dashboard', compact(
            'total_layanan', 'total_tiket', 'total_promosi',
            'total_galeri', 'promo_aktif', 'recent_promosi',
            'revenue', 'validated_today', 'pending_confirmation'
        ));
    }
}
