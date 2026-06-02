SET FOREIGN_KEY_CHECKS=0;

DROP TABLE IF EXISTS `admin`;
CREATE TABLE `admin` (
  `id_admin` int NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `nama` varchar(100) DEFAULT NULL,
  `jabatan` varchar(100) DEFAULT NULL,
  `foto` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_admin`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

INSERT INTO `admin` VALUES 
('1', 'admin', '$2y$12$p.twgJyZ2RUKPi3C/GVDbuQS696CoXmCluau80lwoBzjQOhgc8Tk.', '2026-04-30 14:27:00', 'Moh Abi Syamsul', 'CEO', 'admin/6a04873222f69_1778681650.jpg'),
('2', 'abi', '$2y$12$p.twgJyZ2RUKPi3C/GVDbuQS696CoXmCluau80lwoBzjQOhgc8Tk.', '2026-05-13 21:56:11', '', '', NULL);

DROP TABLE IF EXISTS `cache`;
CREATE TABLE `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` bigint NOT NULL,
  PRIMARY KEY (`key`),
  KEY `cache_expiration_index` (`expiration`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `cache_locks`;
CREATE TABLE `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` bigint NOT NULL,
  PRIMARY KEY (`key`),
  KEY `cache_locks_expiration_index` (`expiration`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `failed_jobs`;
CREATE TABLE `failed_jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`),
  KEY `failed_jobs_connection_queue_failed_at_index` (`connection`,`queue`,`failed_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `galeri`;
CREATE TABLE `galeri` (
  `id_galeri` int NOT NULL AUTO_INCREMENT,
  `judul_foto` varchar(150) NOT NULL,
  `gambar` varchar(255) NOT NULL,
  `id_admin` int DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_galeri`),
  KEY `id_admin` (`id_admin`),
  CONSTRAINT `galeri_ibfk_1` FOREIGN KEY (`id_admin`) REFERENCES `admin` (`id_admin`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

INSERT INTO `galeri` VALUES 
('1', 'omakkk ada bocah 1b maen kesini', 'galeri/69f30c1856d8e_1777536024.jpeg', '1', '2026-04-30 15:00:24'),
('2', 'Kolam Renang Kids Park', 'galeri/kolam_renang.webp', '1', '2026-05-28 08:09:09'),
('3', 'Area Playground Seru', 'galeri/playground.webp', '1', '2026-05-28 08:09:09'),
('4', 'Sepeda Udara (Sky Bikes)', 'galeri/sky_bikes.webp', '1', '2026-05-28 08:09:09'),
('5', 'Rainbow Slide Raksasa', 'galeri/rainbow_slide.webp', '1', '2026-05-28 08:09:09'),
('6', 'Bianglala Keluarga', 'galeri/bianglala.webp', '1', '2026-05-28 08:09:09'),
('7', 'Food Court & Kuliner', 'galeri/food_court.webp', '1', '2026-05-28 08:09:09'),
('8', 'Gerbang Masuk Kids Park', 'galeri/entrance.webp', '1', '2026-05-28 08:09:09'),
('9', 'Zona VR & Arcade', 'galeri/vr_zone.webp', '1', '2026-05-28 08:09:09');

DROP TABLE IF EXISTS `job_batches`;
CREATE TABLE `job_batches` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `jobs`;
CREATE TABLE `jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` smallint unsigned NOT NULL,
  `reserved_at` int unsigned DEFAULT NULL,
  `available_at` int unsigned NOT NULL,
  `created_at` int unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `kontak`;
CREATE TABLE `kontak` (
  `id_kontak` int NOT NULL AUTO_INCREMENT,
  `alamat` text,
  `nomor_telepon` varchar(20) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `maps` text,
  `jam_operasional` varchar(200) DEFAULT NULL,
  `id_admin` int DEFAULT NULL,
  `instagram` varchar(255) DEFAULT NULL,
  `tiktok` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_kontak`),
  KEY `id_admin` (`id_admin`),
  CONSTRAINT `kontak_ibfk_1` FOREIGN KEY (`id_admin`) REFERENCES `admin` (`id_admin`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

INSERT INTO `kontak` VALUES 
('1', 'Jl. Jenderal Ahmad Yani No.54B, Lemahabang, Kec. Indramayu, Kabupaten Indramayu, Jawa Barat 45212.', '081234567890', 'kidspark@email.com', 'https://maps.google.com', 'Weekday (Senin - Jumat): 09.00 - 17.00 WIB Weekend (Sabtu & Minggu) 08.00 - 17.00', '1', NULL, NULL);

DROP TABLE IF EXISTS `layanan`;
CREATE TABLE `layanan` (
  `id_layanan` int NOT NULL AUTO_INCREMENT,
  `nama_layanan` varchar(100) NOT NULL,
  `deskripsi` text,
  `icon` varchar(50) DEFAULT 'star',
  `gambar` varchar(255) DEFAULT NULL,
  `id_admin` int DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_layanan`),
  KEY `id_admin` (`id_admin`),
  CONSTRAINT `layanan_ibfk_1` FOREIGN KEY (`id_admin`) REFERENCES `admin` (`id_admin`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

INSERT INTO `layanan` VALUES 
('1', 'Kolam Renang & Water Playground', 'Kolam renang khusus anak dengan air bersih dan aman, dilengkapi perosotan air warna-warni, pancuran, dan ember tumpah raksasa.', 'water', 'layanan/waterpark.png', '1', '2026-05-28 09:35:18'),
('2', 'Indoor Playground & Mandi Bola', 'Area bermain dalam ruangan yang luas, aman, dan ber-AC, dilengkapi dengan mandi bola raksasa, seluncuran, jembatan tali, dan mainan edukatif.', 'play_arrow', 'layanan/playground.png', '1', '2026-05-28 09:35:18'),
('3', 'Gazebo Santai & Rest Area', 'Fasilitas pondokan kayu/gazebo nyaman di area rindang untuk orang tua beristirahat sambil memantau aktivitas anak bermain.', 'park', 'layanan/gazebo.png', '1', '2026-05-28 09:35:18');

DROP TABLE IF EXISTS `members`;
CREATE TABLE `members` (
  `id_member` bigint unsigned NOT NULL AUTO_INCREMENT,
  `nama_lengkap` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `no_telepon` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `no_member` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tier` enum('Bronze','Silver','Gold','Platinum') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Bronze',
  `total_kunjungan` int NOT NULL DEFAULT '0',
  `total_belanja` decimal(12,2) NOT NULL DEFAULT '0.00',
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `foto` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_member`),
  UNIQUE KEY `members_email_unique` (`email`),
  UNIQUE KEY `members_no_member_unique` (`no_member`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `members` VALUES 
('1', 'abi', 'abi@gmail.com', '$2y$12$7NfDc6ZIAu20k9aWseyl8ekdsIE7iM0zhVRzrcpuD/fZJ5jtAVKVm', NULL, 'KP-M-00001', 'Bronze', '0', '0.00', '1', NULL, NULL, NULL, '2026-06-02 05:00:55', '2026-06-02 05:00:55'),
('2', 'winesa', 'win@gmail.com', '$2y$12$tIYk.pfTlLQNmJL9V2aEzu0KdMyt1yj2fVIfE0LnX.kcbTDXvJ34C', NULL, 'KP-M-00002', 'Bronze', '0', '0.00', '0', NULL, NULL, NULL, '2026-06-02 05:06:56', '2026-06-02 05:06:56');

DROP TABLE IF EXISTS `password_reset_tokens`;
CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `pesanan_tiket`;
CREATE TABLE `pesanan_tiket` (
  `id_pesanan` bigint unsigned NOT NULL AUTO_INCREMENT,
  `kode_booking` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_member` bigint unsigned DEFAULT NULL,
  `nama_pengunjung` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_pengunjung` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `telepon_pengunjung` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tanggal_kunjungan` date NOT NULL,
  `total_bayar` decimal(10,2) NOT NULL,
  `bukti_pembayaran` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status_pembayaran` enum('pending','menunggu_konfirmasi','lunas','batal') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `status_kunjungan` enum('belum_hadir','sudah_hadir') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'belum_hadir',
  `kunjungan_validated_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_pesanan`),
  UNIQUE KEY `pesanan_tiket_kode_booking_unique` (`kode_booking`),
  KEY `pesanan_tiket_id_member_foreign` (`id_member`),
  CONSTRAINT `pesanan_tiket_id_member_foreign` FOREIGN KEY (`id_member`) REFERENCES `members` (`id_member`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `pesanan_tiket` VALUES 
('1', 'KP-20260528-59XZ', NULL, 'Ahmad Budi', 'ahmad@test.com', '081298765432', '2026-05-28', '30000.00', NULL, 'lunas', 'sudah_hadir', '2026-05-28 09:24:35', '2026-05-28 09:18:47', '2026-05-28 09:24:35'),
('2', 'KP-20260531-1FIY', NULL, 'abi ganteng', 'mabi@gmail.com', '085314668835', '2026-05-31', '60000.00', 'bukti_bayar/6a1c300205363_1780232194.png', 'batal', 'belum_hadir', NULL, '2026-05-31 12:55:01', '2026-05-31 13:11:33'),
('3', 'KP-20260601-OGJO', NULL, 'Adit', 'adit@test.com', '081234567890', '2026-06-01', '60000.00', NULL, 'pending', 'belum_hadir', NULL, '2026-06-01 16:51:08', '2026-06-01 16:51:08');

DROP TABLE IF EXISTS `pesanan_tiket_detail`;
CREATE TABLE `pesanan_tiket_detail` (
  `id_detail` bigint unsigned NOT NULL AUTO_INCREMENT,
  `id_pesanan` bigint unsigned NOT NULL,
  `id_tiket` int NOT NULL,
  `jumlah` int NOT NULL,
  `subtotal` decimal(10,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_detail`),
  KEY `pesanan_tiket_detail_id_pesanan_foreign` (`id_pesanan`),
  KEY `pesanan_tiket_detail_id_tiket_foreign` (`id_tiket`),
  CONSTRAINT `pesanan_tiket_detail_id_pesanan_foreign` FOREIGN KEY (`id_pesanan`) REFERENCES `pesanan_tiket` (`id_pesanan`) ON DELETE CASCADE,
  CONSTRAINT `pesanan_tiket_detail_id_tiket_foreign` FOREIGN KEY (`id_tiket`) REFERENCES `tiket` (`id_tiket`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `pesanan_tiket_detail` VALUES 
('1', '1', '1', '1', '30000.00', '2026-05-28 09:18:47', '2026-05-28 09:18:47'),
('2', '2', '4', '1', '60000.00', '2026-05-31 12:55:01', '2026-05-31 12:55:01'),
('3', '3', '1', '2', '60000.00', '2026-06-01 16:51:08', '2026-06-01 16:51:08');

DROP TABLE IF EXISTS `promosi`;
CREATE TABLE `promosi` (
  `id_promosi` int NOT NULL AUTO_INCREMENT,
  `judul_promosi` varchar(150) NOT NULL,
  `deskripsi` text,
  `tanggal_mulai` date DEFAULT NULL,
  `tanggal_selesai` date DEFAULT NULL,
  `id_admin` int DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_promosi`),
  KEY `id_admin` (`id_admin`),
  CONSTRAINT `promosi_ibfk_1` FOREIGN KEY (`id_admin`) REFERENCES `admin` (`id_admin`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

INSERT INTO `promosi` VALUES 
('1', 'Promo Liburan Sekolah', 'Dapatkan diskon 20% untuk semua tiket selama liburan sekolah!', '2025-06-01', '2025-06-30', '1', '2026-04-30 14:27:00'),
('2', 'ada jokowi dateng', 'dibayarin jokowi', '2026-04-30', '2026-05-02', '1', '2026-04-30 14:58:47');

DROP TABLE IF EXISTS `tiket`;
CREATE TABLE `tiket` (
  `id_tiket` int NOT NULL AUTO_INCREMENT,
  `jenis_tiket` varchar(100) NOT NULL,
  `harga` decimal(10,2) NOT NULL,
  `deskripsi` text,
  `id_admin` int DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_tiket`),
  KEY `id_admin` (`id_admin`),
  CONSTRAINT `tiket_ibfk_1` FOREIGN KEY (`id_admin`) REFERENCES `admin` (`id_admin`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

INSERT INTO `tiket` VALUES 
('1', 'Tiket Anak (Weekday)', '30000.00', 'Berlaku untuk anak usia 3-12 tahun, hari Senin-Jumat', '1', '2026-04-30 14:27:00'),
('2', 'Tiket Dewasa (Weekday)', '50000.00', 'Berlaku untuk usia 13 tahun ke atas, hari Senin-Jumat', '1', '2026-04-30 14:27:00'),
('3', 'Tiket Anak (Weekend)', '40000.00', 'Berlaku untuk anak usia 3-12 tahun, hari Sabtu-Minggu', '1', '2026-04-30 14:27:00'),
('4', 'Tiket Dewasa (Weekend)', '60000.00', 'Berlaku untuk usia 13 tahun ke atas, hari Sabtu-Minggu', '1', '2026-04-30 14:27:00');

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

SET FOREIGN_KEY_CHECKS=1;
