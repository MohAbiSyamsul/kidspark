# Business Requirements Document (BRD)
**Sistem Informasi Promosi dan Layanan Kids Park**

| Atribut | Detail |
|---------|--------|
| **Kode Dokumen** | GL01-BRD-KP-2025 |
| **Versi** | 2.0 |
| **Tanggal** | Juni 2025 |
| **Status** | Final |
| **Tim** | Kelompok 9 — D4 SIKC POLINDRA |
| **Mitra Bisnis** | Kids Park, Indramayu |

---

## 1. RINGKASAN EKSEKUTIF

### 1.1 Latar Belakang
Kids Park merupakan taman wisata anak yang berlokasi di Jl. Jenderal Ahmad Yani No.54B, Indramayu, Jawa Barat. Saat ini, pengelolaan informasi promosi dan layanan masih dilakukan secara konvensional (brosur fisik, media sosial tanpa integrasi), sementara penjualan tiket hanya tersedia secara on-site (langsung di loket). Hal ini menyebabkan:

- Jangkauan informasi promosi terbatas pada area sekitar lokasi.
- Tidak ada data terpusat mengenai jumlah pengunjung, pendapatan, dan tren kunjungan.
- Pelanggan tidak memiliki insentif untuk berkunjung kembali (tidak ada program loyalitas).
- Antrian panjang di loket pada jam/hari sibuk.

### 1.2 Tujuan Proyek
Membangun **Sistem Informasi berbasis web** yang berfungsi sebagai:
1. **Platform promosi digital** — menampilkan layanan, harga tiket, galeri foto, dan informasi kontak.
2. **Kanal penjualan tiket daring** — pengunjung dapat memesan dan membayar tiket sebelum datang.
3. **Sistem keanggotaan (Membership)** — memberikan insentif loyalitas berupa diskon berdasarkan tingkatan.
4. **Panel manajemen terpusat** — admin dapat mengelola seluruh konten, memverifikasi pesanan, memvalidasi kunjungan, dan mengelola member.

### 1.3 Ruang Lingkup Proyek
| Dalam Lingkup (In-Scope) | Di Luar Lingkup (Out-of-Scope) |
|---|---|
| Landing page publik responsif | Integrasi payment gateway otomatis |
| CRUD konten (layanan, tiket, promosi, galeri, kontak) | Aplikasi mobile native (Android/iOS) |
| Pemesanan tiket daring + upload bukti bayar | Sistem reservasi fasilitas/gazebo |
| Konfirmasi pembayaran manual oleh admin | Multi-bahasa (i18n) |
| Validasi kehadiran pengunjung (scan kode booking) | Sistem keuangan/akuntansi lengkap |
| Membership dengan tier (Bronze → Platinum) | Integrasi pihak ketiga (OTA, Traveloka) |
| Dashboard statistik admin | Fitur ulasan/rating pengunjung |
| Manajemen member oleh admin | Notifikasi email/SMS otomatis |

---

## 2. IDENTIFIKASI STAKEHOLDER

### 2.1 Daftar Stakeholder

| # | Stakeholder | Peran | Kepentingan |
|---|-------------|-------|-------------|
| 1 | **Pengelola Kids Park** | Pemilik bisnis, decision maker | Meningkatkan pendapatan dan jangkauan promosi |
| 2 | **Admin/Operator** | Pengguna panel admin harian | Mengelola konten, konfirmasi pesanan, validasi kunjungan |
| 3 | **Pengunjung Publik** | Calon pelanggan | Mendapatkan informasi wisata dan memesan tiket secara mudah |
| 4 | **Member** | Pelanggan terdaftar | Mendapatkan keuntungan loyalitas (diskon, riwayat) |
| 5 | **Tim Developer (Kelompok 9)** | Pengembang sistem | Memastikan sistem memenuhi kebutuhan mitra |
| 6 | **Dosen Pembimbing** | Penilai akademik | Mengevaluasi kualitas dan kelengkapan proyek |

### 2.2 Analisis Kebutuhan Stakeholder

| Stakeholder | Kebutuhan Bisnis | Prioritas |
|---|---|---|
| Pengelola | Dashboard ringkasan statistik (jumlah pengunjung, pendapatan) | Tinggi |
| Pengelola | Mengetahui promosi mana yang masih aktif/sudah berakhir | Sedang |
| Admin | Antarmuka CRUD yang intuitif dan cepat | Tinggi |
| Admin | Konfirmasi pesanan tiket dan validasi kunjungan | Tinggi |
| Admin | Mengelola akun member (approve, toggle aktif) | Sedang |
| Pengunjung | Informasi layanan, harga, dan galeri yang lengkap | Tinggi |
| Pengunjung | Proses pemesanan tiket yang sederhana | Tinggi |
| Member | Dashboard personal dengan info tier dan riwayat | Sedang |
| Member | Diskon otomatis berdasarkan tier saat beli tiket | Tinggi |

---

## 3. KEBUTUHAN BISNIS

### 3.1 Tujuan Bisnis (Business Objectives)

| # | Tujuan | Indikator Keberhasilan (KPI) |
|---|--------|------------------------------|
| BO-1 | Meningkatkan jangkauan promosi Kids Park | Website dapat diakses secara publik, konten terbaru selalu tersedia |
| BO-2 | Menyediakan kanal penjualan tiket daring | Minimal 1 transaksi tiket daring berhasil dilakukan |
| BO-3 | Meningkatkan loyalitas pengunjung | Minimal 5 member terdaftar dengan status aktif |
| BO-4 | Menyediakan data terpusat untuk pengambilan keputusan | Dashboard admin menampilkan statistik real-time |
| BO-5 | Mengurangi antrian loket fisik | Sistem validasi kunjungan via kode booking berfungsi |

### 3.2 Aturan Bisnis (Business Rules)

| ID | Aturan Bisnis | Implementasi |
|---|---|---|
| BR-01 | Harga tiket harus lebih dari 0 | Validasi server-side pada form tiket |
| BR-02 | Promosi berstatus "Aktif" jika tanggal hari ini berada dalam rentang mulai–selesai | Badge otomatis pada halaman promosi |
| BR-03 | Tanggal selesai promosi tidak boleh sebelum tanggal mulai | Validasi form pada CRUD promosi |
| BR-04 | Kontak hanya memiliki 1 record | UPDATE jika sudah ada, INSERT jika belum |
| BR-05 | Galeri hanya mendukung upload dan hapus (tidak ada edit) | Tidak ada form edit untuk galeri |
| BR-06 | Member baru berstatus `is_active = false`, harus disetujui admin | Flow registrasi → pending → admin approve |
| BR-07 | Tier member ditentukan berdasarkan total kunjungan | Bronze (0–4), Silver (5–14), Gold (15–29), Platinum (30+) |
| BR-08 | Diskon member otomatis: Bronze 0%, Silver 5%, Gold 10%, Platinum 15% | Dipotong saat kalkulasi total bayar pemesanan tiket |
| BR-09 | Pemesanan tiket membutuhkan login member | Redirect ke login member jika belum login |
| BR-10 | Tiket yang sudah divalidasi tidak dapat divalidasi ulang | Pengecekan status `sudah_hadir` sebelum proses |
| BR-11 | File upload hanya JPG, JPEG, PNG, WEBP; maks 5MB | Validasi server-side pada form upload |
| BR-12 | Pembayaran metode transfer manual (upload bukti) | Status: pending → menunggu_konfirmasi → lunas/batal |

### 3.3 Asumsi dan Ketergantungan

**Asumsi:**
- Pihak Kids Park memiliki rekening bank untuk menerima transfer pembayaran.
- Admin memiliki kemampuan dasar mengoperasikan komputer dan browser.
- Server/hosting memiliki dukungan PHP 8.1+ dan MySQL.

**Ketergantungan:**
- Ketersediaan koneksi internet untuk akses sistem.
- Laragon/XAMPP atau hosting web untuk deployment.
- Browser modern (Chrome, Firefox, Safari, Edge) pada sisi pengguna.

---

## 4. FITUR PRODUK

### 4.1 Peta Fitur (Feature Map)

```
┌──────────────────────────────────────────────────────────────┐
│                    KIDS PARK WEB SYSTEM                       │
├──────────────────┬──────────────────┬────────────────────────┤
│   Halaman Publik │   Area Member    │     Panel Admin        │
├──────────────────┼──────────────────┼────────────────────────┤
│ • Hero Section   │ • Registrasi     │ • Dashboard Statistik  │
│ • Tentang        │ • Login/Logout   │ • CRUD Layanan         │
│ • Daftar Layanan │ • Dashboard Tier │ • CRUD Tiket           │
│ • Harga Tiket    │ • Riwayat Pesanan│ • CRUD Promosi         │
│ • Promosi        │ • Edit Profil    │ • Upload/Hapus Galeri  │
│ • Galeri Foto    │ • Ganti Password │ • Edit Kontak & Maps   │
│ • Kontak & Maps  │ • Beli Tiket     │ • Konfirmasi Pesanan   │
│ • Smooth Scroll  │   (member-only)  │ • Validasi Kunjungan   │
│ • Responsive     │                  │ • Manajemen Member     │
│                  │                  │ • Edit Profil Admin    │
└──────────────────┴──────────────────┴────────────────────────┘
```

### 4.2 Prioritas Fitur

| Prioritas | Fitur | Justifikasi |
|-----------|-------|-------------|
| **P1 — Harus** | Landing page publik | Fungsi utama promosi |
| **P1 — Harus** | CRUD Layanan, Tiket, Promosi, Galeri, Kontak | Fungsi dasar CMS |
| **P1 — Harus** | Autentikasi Admin | Keamanan panel admin |
| **P1 — Harus** | Dashboard Admin | Ringkasan data bisnis |
| **P1 — Harus** | Pemesanan tiket daring | Kanal penjualan baru |
| **P1 — Harus** | Konfirmasi pesanan oleh admin | Validasi pembayaran |
| **P2 — Seharusnya** | Validasi kunjungan (scan kode booking) | Otomasi proses check-in |
| **P2 — Seharusnya** | Membership dengan tier & diskon | Program loyalitas |
| **P2 — Seharusnya** | Dashboard member | Self-service pelanggan |
| **P3 — Bisa** | Manajemen member oleh admin | Kontrol akun pelanggan |
| **P3 — Bisa** | Edit profil admin | Personalisasi akun |

---

## 5. ANALISIS RISIKO

| # | Risiko | Dampak | Probabilitas | Mitigasi |
|---|--------|--------|-------------|----------|
| R-1 | Pembayaran manual rawan penipuan | Tinggi | Sedang | Admin memverifikasi bukti transfer secara visual |
| R-2 | Server down menghambat pemesanan | Tinggi | Rendah | Monitoring uptime, backup berkala |
| R-3 | Member mendaftar dengan data palsu | Sedang | Sedang | Approval manual oleh admin sebelum aktif |
| R-4 | Serangan SQL Injection / XSS | Tinggi | Rendah | Prepared statements, htmlspecialchars, CSRF token |
| R-5 | Kapasitas storage penuh (upload gambar) | Sedang | Rendah | Limitasi ukuran file (5MB), monitoring disk |

---

## 6. TIMELINE DAN MILESTONE

| Fase | Aktivitas | Durasi | Deliverable |
|------|----------|--------|-------------|
| **Fase 1** | Analisis kebutuhan, pembuatan dokumen (BRD, SRD, SKPL) | 2 minggu | Dokumen BRD, SRD, SKPL |
| **Fase 2** | Desain database, wireframe, arsitektur sistem | 1 minggu | ERD, wireframe, AGENTS.md |
| **Fase 3** | Pengembangan modul publik + admin CMS | 3 minggu | Landing page, CRUD admin |
| **Fase 4** | Pengembangan modul tiket + membership | 2 minggu | Pemesanan tiket, dashboard member |
| **Fase 5** | Testing, bug fixing, dokumentasi | 1 minggu | Test plan, video presentasi |
| **Fase 6** | Deployment dan serah terima | 1 minggu | Sistem live, dokumentasi final |

---

## 7. PERSETUJUAN

| Peran | Nama | Tanda Tangan | Tanggal |
|-------|------|-------------|---------|
| Project Lead | Moh Abi Syamsul (2507037) | _____________ | _______ |
| Frontend/UI | Alifah Nibras (2507076) | _____________ | _______ |
| QA/Dokumentasi | Winesa (2507112) | _____________ | _______ |
| Dosen Pembimbing | _________________ | _____________ | _______ |

---

*Dokumen ini terakhir diperbarui: Juni 2025 | Versi 2.0*
*Program Studi D4 Sistem Informasi Kota Cerdas — Teknik Informatika — POLINDRA*
