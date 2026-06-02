<?php

namespace Database\Seeders;

use App\Models\Layanan;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class LayananSeeder extends Seeder
{
    public function run(): void
    {
        // Define paths
        $brainPath = 'C:\\Users\\USER\\.gemini\\antigravity\\brain\\d5216a90-b5cb-4c35-8312-106656d2ed86\\';
        $destDir = storage_path('app/public/uploads/layanan');

        // Ensure directory exists
        if (!File::exists($destDir)) {
            File::makeDirectory($destDir, 0755, true, true);
        }

        // 1. Waterpark Image
        $srcWaterpark = $brainPath . 'layanan_waterpark_1779960804655.png';
        if (File::exists($srcWaterpark)) {
            File::copy($srcWaterpark, $destDir . DIRECTORY_SEPARATOR . 'waterpark.png');
        }

        // 2. Playground Image
        $srcPlayground = $brainPath . 'layanan_playground_1779960834226.png';
        if (File::exists($srcPlayground)) {
            File::copy($srcPlayground, $destDir . DIRECTORY_SEPARATOR . 'playground.png');
        }

        // 3. Gazebo Image
        $srcGazebo = $brainPath . 'layanan_gazebo_1779960853737.png';
        if (File::exists($srcGazebo)) {
            File::copy($srcGazebo, $destDir . DIRECTORY_SEPARATOR . 'gazebo.png');
        }

        // Truncate/delete existing layanan
        Layanan::truncate();

        // Seed new premium facilities
        Layanan::create([
            'nama_layanan' => 'Kolam Renang & Water Playground',
            'deskripsi'    => 'Kolam renang khusus anak dengan air bersih dan aman, dilengkapi perosotan air warna-warni, pancuran, dan ember tumpah raksasa.',
            'icon'         => 'water',
            'gambar'       => 'layanan/waterpark.png',
            'id_admin'     => 1,
        ]);

        Layanan::create([
            'nama_layanan' => 'Indoor Playground & Mandi Bola',
            'deskripsi'    => 'Area bermain dalam ruangan yang luas, aman, dan ber-AC, dilengkapi dengan mandi bola raksasa, seluncuran, jembatan tali, dan mainan edukatif.',
            'icon'         => 'play_arrow',
            'gambar'       => 'layanan/playground.png',
            'id_admin'     => 1,
        ]);

        Layanan::create([
            'nama_layanan' => 'Gazebo Santai & Rest Area',
            'deskripsi'    => 'Fasilitas pondokan kayu/gazebo nyaman di area rindang untuk orang tua beristirahat sambil memantau aktivitas anak bermain.',
            'icon'         => 'park',
            'gambar'       => 'layanan/gazebo.png',
            'id_admin'     => 1,
        ]);
    }
}
