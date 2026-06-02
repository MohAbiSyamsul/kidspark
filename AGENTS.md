# AGENTS.md — Kids Park Web Information System

> **Dokumen ini digunakan sebagai panduan bagi AI agents, developer, dan kontributor yang bekerja pada proyek ini.**

---

## Project Overview

| Atribut | Detail |
|---------|--------|
| **Nama Proyek** | Sistem Informasi Promosi dan Layanan Kids Park |
| **Tipe** | Web Application (Prototype) |
| **Stack** | PHP Native, MySQL, HTML5, CSS3, JavaScript |
| **Tim** | Kelompok 9 - D4 SIKC POLINDRA |
| **Mitra** | Kids Park, Indramayu |
| **Dokumen Referensi** | SRS (GL01-SRS-KP-2025), BRD (GL01-BRD-KP-2025), SKPL (GL01-SKPL-OO) |

---

## Repository Structure

```
kidspark/
├── index.php                  # Halaman utama publik (single page)
├── database.sql               # Schema + seed data database
├── README.md                  # Instruksi setup
├── AGENTS.md                  # Dokumen ini
│
├── includes/
│   ├── config.php             # Konfigurasi DB, BASE_URL, konstanta
│   └── functions.php          # Helper functions (formatRupiah, sanitize, dll)
│
├── admin/
│   ├── login.php              # Autentikasi admin
│   ├── logout.php             # Destroy session
│   ├── dashboard.php          # Ringkasan statistik
│   ├── layanan.php            # CRUD layanan
│   ├── tiket.php              # CRUD harga tiket
│   ├── promosi.php            # CRUD promosi
│   ├── galeri.php             # Upload/hapus foto galeri
│   ├── kontak.php             # Edit kontak & maps
│   └── includes/
│       ├── header.php         # Layout header + sidebar (semua halaman admin)
│       └── footer.php         # Penutup layout admin
│
└── assets/
    ├── css/
    │   ├── style.css          # CSS halaman publik
    │   └── admin.css          # CSS admin panel
    ├── js/
    │   ├── main.js            # JS halaman publik
    │   └── admin.js           # JS admin panel
    └── uploads/
        ├── .htaccess          # Blokir eksekusi PHP di folder uploads
        └── galeri/            # Foto galeri yang diupload (auto-created)
```

---

## Database Schema

```sql
-- 6 tabel utama
admin       (id_admin PK, username UNIQUE, password, created_at)
layanan     (id_layanan PK, nama_layanan, deskripsi, icon, id_admin FK, created_at)
tiket       (id_tiket PK, jenis_tiket, harga DECIMAL, deskripsi, id_admin FK, created_at)
promosi     (id_promosi PK, judul_promosi, deskripsi, tanggal_mulai DATE, tanggal_selesai DATE, id_admin FK, created_at)
galeri      (id_galeri PK, judul_foto, gambar VARCHAR(255), id_admin FK, created_at)
kontak      (id_kontak PK, alamat TEXT, nomor_telepon, email, maps TEXT, jam_operasional, id_admin FK)
```

**Relasi:** Semua tabel konten memiliki FK `id_admin` → `admin.id_admin` (one-to-many).

---

## Key Configuration

### `includes/config.php`
```php
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');           // Kosong untuk XAMPP, 'root' untuk Laragon
define('DB_NAME', 'kidspark_db');
define('BASE_URL', '/kidspark'); // Sesuaikan nama folder deployment
define('UPLOAD_PATH', __DIR__ . '/../assets/uploads/');
define('UPLOAD_URL', BASE_URL . '/assets/uploads/');
```

---

## Authentication

- **Mekanisme:** PHP Session (`$_SESSION['admin_id']`, `$_SESSION['admin_username']`)
- **Password hashing:** `password_hash()` dengan `PASSWORD_BCRYPT`
- **Verifikasi:** `password_verify($input, $storedHash)`
- **Default credentials:** `admin` / `admin123`
- **Guard:** Fungsi `requireLogin()` di setiap halaman admin — redirect ke `/admin/login.php` jika belum login

> ⚠️ **Catatan:** Hash password default di `database.sql` mungkin perlu di-regenerate. Jalankan `reset_pass.php` saat setup awal atau update manual via phpMyAdmin.

---

## Helper Functions (`includes/functions.php`)

| Fungsi | Kegunaan |
|--------|----------|
| `formatRupiah($angka)` | Format angka ke format rupiah: `Rp 30.000` |
| `sanitize($data)` | Strip tags + escape untuk input DB |
| `redirect($path)` | Redirect relatif ke BASE_URL |
| `isLoggedIn()` | Cek apakah sesi admin aktif |
| `requireLogin()` | Guard — redirect jika belum login |
| `uploadGambar($file, $folder)` | Validasi + pindahkan file upload ke `assets/uploads/{folder}/` |
| `deleteFile($filename)` | Hapus file fisik dari server |
| `isPromoAktif($mulai, $selesai)` | Cek apakah promosi masih aktif berdasarkan tanggal hari ini |
| `alert($type, $message)` | Simpan alert ke session |
| `showAlert()` | Render alert dari session dan hapus setelahnya |

---

## CRUD Pattern

Semua halaman admin menggunakan pola yang sama:

```
POST action=tambah  → INSERT ke database
POST action=edit    → UPDATE berdasarkan ID
POST action=hapus   → DELETE berdasarkan ID
GET  ?edit={id}     → Tampilkan form edit pre-filled
```

Setelah operasi POST, selalu `redirect()` untuk mencegah form resubmission (PRG pattern).

---

## File Upload (Galeri)

- **Allowed types:** JPG, JPEG, PNG, WEBP
- **Max size:** 5MB
- **Naming:** `uniqid() . '_' . time() . '.ext'` (mencegah konflik nama)
- **Storage path:** `assets/uploads/galeri/{filename}`
- **Security:** `.htaccess` di folder uploads memblokir eksekusi PHP
- **Cleanup:** File fisik dihapus bersamaan saat record database dihapus

---

## Frontend Architecture

### Halaman Publik (`index.php`)
- Single-page dengan section-based navigation (`#beranda`, `#layanan`, `#tiket`, `#promosi`, `#galeri`, `#kontak`)
- Smooth scroll + active nav highlight berdasarkan scroll position
- Fade-in animation menggunakan IntersectionObserver
- Responsive dengan hamburger menu untuk mobile

### Design Tokens (CSS Variables)
```css
--primary: #FF6B35    /* Orange utama */
--secondary: #4ECDC4  /* Teal/cyan */
--accent: #FFE66D     /* Kuning */
--dark: #1a1a2e       /* Background gelap (hero, tiket section) */
--text: #2d3748       /* Teks utama */
--radius: 16px        /* Border radius card */
```

### Admin Panel
- Layout: Fixed sidebar (260px) + scrollable main content
- Sidebar navigasi: Dashboard → Layanan → Tiket → Promosi → Galeri → Kontak
- Active state sidebar ditentukan oleh variabel `$current_page`
- Modal konfirmasi hapus (JavaScript) sebelum submit form DELETE

---

## Business Rules

1. **Promosi status:** Badge "Aktif" jika `CURDATE()` antara `tanggal_mulai` dan `tanggal_selesai`; badge "Berakhir" jika sudah lewat.
2. **Validasi tiket:** `harga` harus > 0.
3. **Validasi promosi:** `tanggal_selesai` tidak boleh sebelum `tanggal_mulai`.
4. **Kontak:** Hanya ada 1 record kontak (UPDATE jika sudah ada, INSERT jika belum).
5. **Galeri:** Tidak ada fitur edit — hanya upload baru dan hapus.

---

## Error Handling Conventions

- Form validation di sisi server (PHP), bukan hanya client-side
- Alert/flash message disimpan di `$_SESSION['alert']` dan ditampilkan via `showAlert()`
- Jenis alert: `success` (hijau) atau `error` (merah)
- Query menggunakan **prepared statements** (`$conn->prepare()`) untuk mencegah SQL injection

---

## Security Checklist

- [x] Password di-hash dengan bcrypt sebelum disimpan
- [x] Prepared statements digunakan untuk semua query dengan input user
- [x] `htmlspecialchars()` pada semua output ke HTML
- [x] Folder uploads dilindungi dari eksekusi PHP via `.htaccess`
- [x] Session admin dihapus sepenuhnya saat logout
- [x] Validasi tipe dan ukuran file saat upload
- [ ] HTTPS (konfigurasi di level server/hosting, bukan kode)
- [ ] Rate limiting pada form login (rekomendasi untuk production)

---

## Setup Instructions

### Prasyarat
- PHP 7.4+
- MySQL 5.7+ / MariaDB 10+
- Apache/Nginx (atau XAMPP/Laragon untuk lokal)

### Langkah Setup
```bash
# 1. Clone/ekstrak project
# 2. Taruh folder kidspark di htdocs/www

# 3. Import database
mysql -u root -p < database.sql
# Atau via phpMyAdmin: buat DB 'kidspark_db', lalu import database.sql

# 4. Sesuaikan config
# Edit includes/config.php:
# - DB_PASS sesuai instalasi
# - BASE_URL sesuai nama folder

# 5. Reset password admin (opsional, jika login gagal)
# Buat file reset_pass.php:
# <?php
# require_once 'includes/config.php';
# $hash = password_hash('admin123', PASSWORD_BCRYPT);
# $conn->query("UPDATE admin SET password='$hash' WHERE username='admin'");
# echo "Done: " . $hash;
# ?>
# Akses sekali, lalu HAPUS file tersebut.
```

### Akses
| URL | Keterangan |
|-----|------------|
| `http://localhost/kidspark/` | Halaman publik |
| `http://localhost/kidspark/admin/login.php` | Login admin |
| `http://localhost/kidspark/admin/dashboard.php` | Dashboard (butuh login) |

---

## Known Limitations & Future Improvements

| Keterbatasan Saat Ini | Rekomendasi Perbaikan |
|----------------------|----------------------|
| Tidak ada sistem booking tiket | Integrasikan payment gateway (Midtrans/Xendit) |
| Tidak ada fitur pencarian | Tambahkan search di galeri dan layanan |
| Admin hanya satu akun | Sistem multi-user dengan role management |
| Tidak ada resize otomatis gambar | Tambahkan GD Library untuk compress/resize |
| Tidak ada backup otomatis | Tambahkan scheduled backup database |
| Tidak ada logging aktivitas admin | Buat tabel `admin_log` untuk audit trail |

---

## Team & Contact

| NIM | Nama | Role |
|-----|------|------|
| 2507037 | Moh Abi Syamsul | Project Lead, Backend |
| 2507076 | Alifah Nibras | Frontend, UI/UX |
| 2507112 | Winesa | Dokumentasi, QA |

**Institusi:** Program Studi D4 Sistem Informasi Kota Cerdas  
**Jurusan:** Teknik Informatika — POLINDRA  
**Alamat:** Jl. Lohbener Lama No. 8, Indramayu 45252

---

*Dokumen ini diperbarui terakhir: Mei 2025 | Versi 1.0.0*
