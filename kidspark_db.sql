-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: May 01, 2026 at 04:39 AM
-- Server version: 8.4.3
-- PHP Version: 8.3.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `kidspark_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id_admin` int NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `nama` varchar(100) DEFAULT NULL,
  `jabatan` varchar(100) DEFAULT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id_admin`, `username`, `password`, `nama`, `jabatan`, `foto`, `created_at`) VALUES
(1, 'admin', '$2y$10$ZuF590Q37/3b/xMsFN1I3.ef3S83n1kLnFmk.Yt1UMWqVa8fDVRMi', NULL, NULL, NULL, '2026-04-30 07:27:00');

-- --------------------------------------------------------

--
-- Table structure for table `galeri`
--

CREATE TABLE `galeri` (
  `id_galeri` int NOT NULL,
  `judul_foto` varchar(150) NOT NULL,
  `gambar` varchar(255) NOT NULL,
  `id_admin` int DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `galeri`
--

INSERT INTO `galeri` (`id_galeri`, `judul_foto`, `gambar`, `id_admin`, `created_at`) VALUES
(1, 'omakkk ada bocah 1b maen kesini', 'galeri/69f30c1856d8e_1777536024.jpeg', 1, '2026-04-30 08:00:24');

-- --------------------------------------------------------

--
-- Table structure for table `kontak`
--

CREATE TABLE `kontak` (
  `id_kontak` int NOT NULL,
  `alamat` text,
  `nomor_telepon` varchar(20) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `instagram` varchar(255) DEFAULT NULL,
  `tiktok` varchar(255) DEFAULT NULL,
  `maps` text,
  `jam_operasional` varchar(200) DEFAULT NULL,
  `id_admin` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `kontak`
--

INSERT INTO `kontak` (`id_kontak`, `alamat`, `nomor_telepon`, `email`, `instagram`, `tiktok`, `maps`, `jam_operasional`, `id_admin`) VALUES
(1, 'Jl. Jenderal Ahmad Yani No.54B, Lemahabang, Kec. Indramayu, Kabupaten Indramayu, Jawa Barat 45212.', '081234567890', 'kidspark@email.com', 'https://www.instagram.com/kidspark', 'https://www.tiktok.com/@kidspark', 'https://maps.google.com', 'Weekday (Senin - Jumat): 09.00 - 17.00 WIB Weekend (Sabtu & Minggu) 08.00 - 17.00', 1);

-- --------------------------------------------------------

--
-- Table structure for table `layanan`
--

CREATE TABLE `layanan` (
  `id_layanan` int NOT NULL,
  `nama_layanan` varchar(100) NOT NULL,
  `deskripsi` text,
  `icon` varchar(50) DEFAULT 'star',
  `id_admin` int DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `layanan`
--

INSERT INTO `layanan` (`id_layanan`, `nama_layanan`, `deskripsi`, `icon`, `id_admin`, `created_at`) VALUES
(1, 'Kolam Renang', 'Kolam renang bersih dan aman untuk anak-anak dengan berbagai wahana air yang menyenangkan.', 'water', 1, '2026-04-30 07:27:00'),
(2, 'Playground', 'Area bermain outdoor dan indoor dengan berbagai permainan edukatif dan menyenangkan.', 'play_arrow', 1, '2026-04-30 07:27:00'),
(3, 'mushola', 'apake', 'star', 1, '2026-05-01 03:55:08');

-- --------------------------------------------------------

--
-- Table structure for table `promosi`
--

CREATE TABLE `promosi` (
  `id_promosi` int NOT NULL,
  `judul_promosi` varchar(150) NOT NULL,
  `deskripsi` text,
  `tanggal_mulai` date DEFAULT NULL,
  `tanggal_selesai` date DEFAULT NULL,
  `id_admin` int DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `promosi`
--

INSERT INTO `promosi` (`id_promosi`, `judul_promosi`, `deskripsi`, `tanggal_mulai`, `tanggal_selesai`, `id_admin`, `created_at`) VALUES
(1, 'Promo Liburan Sekolah', 'Dapatkan diskon 20% untuk semua tiket selama liburan sekolah!', '2025-06-01', '2025-06-30', 1, '2026-04-30 07:27:00'),
(2, 'ada jokowi dateng', 'dibayarin jokowi', '2026-04-30', '2026-05-02', 1, '2026-04-30 07:58:47');

-- --------------------------------------------------------

--
-- Table structure for table `tiket`
--

CREATE TABLE `tiket` (
  `id_tiket` int NOT NULL,
  `jenis_tiket` varchar(100) NOT NULL,
  `harga` decimal(10,2) NOT NULL,
  `deskripsi` text,
  `id_admin` int DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `tiket`
--

INSERT INTO `tiket` (`id_tiket`, `jenis_tiket`, `harga`, `deskripsi`, `id_admin`, `created_at`) VALUES
(1, 'Tiket Anak (Weekday)', 30000.00, 'Berlaku untuk anak usia 3-12 tahun, hari Senin-Jumat', 1, '2026-04-30 07:27:00'),
(2, 'Tiket Dewasa (Weekday)', 50000.00, 'Berlaku untuk usia 13 tahun ke atas, hari Senin-Jumat', 1, '2026-04-30 07:27:00'),
(3, 'Tiket Anak (Weekend)', 40000.00, 'Berlaku untuk anak usia 3-12 tahun, hari Sabtu-Minggu', 1, '2026-04-30 07:27:00'),
(4, 'Tiket Dewasa (Weekend)', 60000.00, 'Berlaku untuk usia 13 tahun ke atas, hari Sabtu-Minggu', 1, '2026-04-30 07:27:00');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id_admin`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `galeri`
--
ALTER TABLE `galeri`
  ADD PRIMARY KEY (`id_galeri`),
  ADD KEY `id_admin` (`id_admin`);

--
-- Indexes for table `kontak`
--
ALTER TABLE `kontak`
  ADD PRIMARY KEY (`id_kontak`),
  ADD KEY `id_admin` (`id_admin`);

--
-- Indexes for table `layanan`
--
ALTER TABLE `layanan`
  ADD PRIMARY KEY (`id_layanan`),
  ADD KEY `id_admin` (`id_admin`);

--
-- Indexes for table `promosi`
--
ALTER TABLE `promosi`
  ADD PRIMARY KEY (`id_promosi`),
  ADD KEY `id_admin` (`id_admin`);

--
-- Indexes for table `tiket`
--
ALTER TABLE `tiket`
  ADD PRIMARY KEY (`id_tiket`),
  ADD KEY `id_admin` (`id_admin`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id_admin` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `galeri`
--
ALTER TABLE `galeri`
  MODIFY `id_galeri` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `kontak`
--
ALTER TABLE `kontak`
  MODIFY `id_kontak` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `layanan`
--
ALTER TABLE `layanan`
  MODIFY `id_layanan` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `promosi`
--
ALTER TABLE `promosi`
  MODIFY `id_promosi` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tiket`
--
ALTER TABLE `tiket`
  MODIFY `id_tiket` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `galeri`
--
ALTER TABLE `galeri`
  ADD CONSTRAINT `galeri_ibfk_1` FOREIGN KEY (`id_admin`) REFERENCES `admin` (`id_admin`);

--
-- Constraints for table `kontak`
--
ALTER TABLE `kontak`
  ADD CONSTRAINT `kontak_ibfk_1` FOREIGN KEY (`id_admin`) REFERENCES `admin` (`id_admin`);

--
-- Constraints for table `layanan`
--
ALTER TABLE `layanan`
  ADD CONSTRAINT `layanan_ibfk_1` FOREIGN KEY (`id_admin`) REFERENCES `admin` (`id_admin`);

--
-- Constraints for table `promosi`
--
ALTER TABLE `promosi`
  ADD CONSTRAINT `promosi_ibfk_1` FOREIGN KEY (`id_admin`) REFERENCES `admin` (`id_admin`);

--
-- Constraints for table `tiket`
--
ALTER TABLE `tiket`
  ADD CONSTRAINT `tiket_ibfk_1` FOREIGN KEY (`id_admin`) REFERENCES `admin` (`id_admin`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
