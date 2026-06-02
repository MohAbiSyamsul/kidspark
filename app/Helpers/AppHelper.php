<?php

if (!function_exists('formatRupiah')) {
    function formatRupiah($angka): string
    {
        return 'Rp ' . number_format((float)$angka, 0, ',', '.');
    }
}
