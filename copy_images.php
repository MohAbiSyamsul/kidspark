<?php
// Script sementara untuk copy gambar ke public/assets/img
// Jalankan sekali lalu hapus

$srcDir = 'C:/Users/USER/.gemini/antigravity/brain/6fcfef6b-5206-4e6f-969f-80c71aba2bdf/';
$destDir = __DIR__ . '/public/assets/img/';

if (!is_dir($destDir)) {
    mkdir($destDir, 0755, true);
}

$files = [
    'hero_kidspark_1780376946899.png'  => 'hero_kidspark.png',
    'promo_discount_1780376970095.png' => 'promo_banner.png',
    'kids_swimming_1780376986977.png'  => 'kids_swimming.png',
    'playground_kids_1780377009946.png'=> 'playground_kids.png',
];

foreach ($files as $src => $dest) {
    $from = $srcDir . $src;
    $to   = $destDir . $dest;
    if (file_exists($from)) {
        copy($from, $to);
        echo "✅ Copied: $dest<br>";
    } else {
        echo "❌ Not found: $from<br>";
    }
}

echo "<br><strong>Done! Hapus file ini (copy_images.php) setelah dijalankan.</strong>";
