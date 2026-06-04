# AGENTS.md — Kids Park Web Information System

> **Dokumen ini digunakan sebagai panduan bagi AI agents, developer, dan kontributor yang bekerja pada proyek ini.**

---

## Project Overview

| Atribut | Detail |
|---------|--------|
| **Nama Proyek** | Sistem Informasi Promosi dan Layanan Kids Park |
| **Tipe** | Web Application (Full-Stack) |
| **Framework** | Laravel 13 |
| **Stack** | PHP 8.3+, Laravel, MySQL, Blade Templates, Vite |
| **Database** | MySQL 5.7+ / MariaDB 10+ |
| **Server** | Apache (Laragon) |
| **Tim** | Kelompok 9 - D4 SIKC POLINDRA |
| **Mitra** | Kids Park, Indramayu |
| **Dokumen Referensi** | BRD, SRD, PRD, SKPL (lihat `doc/`) |

---

## Repository Structure

```
kidspark/
├── AGENTS.md                          # Dokumen ini
├── README.md                          # Instruksi setup
├── workflow.md                        # Development workflow guide
├── kidspark_db.sql                    # SQL dump database
├── composer.json                      # PHP dependencies
├── package.json                       # Node dependencies
├── vite.config.js                     # Vite bundler config
├── .env                               # Environment variables
│
├── app/
│   ├── Helpers/
│   │   └── AppHelper.php             # formatRupiah()
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Controller.php                 # Base controller
│   │   │   ├── PublicController.php            # Landing page
│   │   │   ├── PublicTicketController.php      # Pemesanan tiket
│   │   │   ├── MemberAuthController.php        # Auth member
│   │   │   ├── MemberDashboardController.php   # Dashboard member
│   │   │   └── Admin/
│   │   │       ├── AuthController.php          # Login/logout admin
│   │   │       ├── DashboardController.php     # Dashboard admin
│   │   │       ├── LayananController.php       # CRUD layanan
│   │   │       ├── TiketController.php         # CRUD tiket
│   │   │       ├── PromosiController.php       # CRUD promosi
│   │   │       ├── GaleriController.php        # Upload/hapus galeri
│   │   │       ├── KontakController.php        # Edit kontak
│   │   │       ├── ProfilController.php        # Edit profil admin
│   │   │       ├── PesananController.php       # Kelola pesanan tiket
│   │   │       └── MemberController.php        # Kelola member
│   │   └── Middleware/
│   │       ├── AdminAuth.php                   # Guard admin
│   │       └── MemberAuth.php                  # Guard member
│   ├── Models/
│   │   ├── Admin.php                  # username, password, nama, jabatan, foto
│   │   ├── Member.php                 # Tier system, diskon, progress
│   │   ├── Layanan.php               # nama_layanan, deskripsi, icon, gambar
│   │   ├── Tiket.php                 # jenis_tiket, harga, deskripsi
│   │   ├── Promosi.php               # judul, tanggal_mulai, tanggal_selesai
│   │   ├── Galeri.php                # judul_foto, gambar
│   │   ├── Kontak.php                # alamat, telepon, email, maps
│   │   ├── PesananTiket.php          # Pesanan tiket (kode_booking, status)
│   │   ├── PesananTiketDetail.php    # Detail tiket per pesanan
│   │   └── User.php                  # Default Laravel (tidak dipakai)
│   └── Providers/
│
├── resources/
│   ├── views/
│   │   ├── welcome.blade.php         # Landing page publik
│   │   ├── layouts/
│   │   │   ├── app.blade.php        # Layout publik/member
│   │   │   └── admin.blade.php      # Layout admin panel
│   │   ├── admin/
│   │   │   ├── login.blade.php
│   │   │   ├── dashboard.blade.php
│   │   │   ├── layanan/  tiket/  promosi/  galeri/  kontak/  profil/
│   │   │   ├── pesanan/ (index, show, validasi)
│   │   │   └── member/ (index, show, create, edit)
│   │   ├── member/
│   │   │   ├── login.blade.php  register.blade.php
│   │   │   ├── dashboard.blade.php
│   │   │   ├── riwayat.blade.php
│   │   │   └── profil.blade.php
│   │   └── tiket/
│   │       ├── beli.blade.php    bayar.blade.php
│   │       ├── status.blade.php  cari.blade.php
│   ├── css/
│   │   └── app.css
│   └── js/
│       └── app.js
│
├── routes/
│   ├── web.php                        # Semua route definitions
│   └── console.php
│
├── database/
│   ├── migrations/                    # Skema tabel
│   ├── seeders/
│   └── database.sqlite               # SQLite fallback
│
├── public/
│   ├── index.php                      # Entry point
│   ├── assets/                        # Aset statis
│   ├── favicon.ico
│   └── storage → ../storage/app/public  # Symlink
│
├── config/                            # Konfigurasi Laravel
├── storage/                           # Uploads, logs, sessions
├── doc/                               # Dokumentasi proyek
│   ├── BRD.md                         # Business Requirements Document
│   ├── SRD.md                         # Software Requirements Document
│   ├── PRD.md                         # Product Requirements Document
│   ├── SKPL_UPDATE.md                 # Spesifikasi Kebutuhan PL
│   └── SCRIPT_VIDEO_PRESENTASI.md     # Skrip video
└── vendor/                            # Composer packages (gitignored)
```

---

## Database Schema

### 9 Tabel Utama

```sql
admin (
    id_admin PK, username UNIQUE, password, nama, jabatan, foto, created_at
)

members (
    id_member PK, nama_lengkap, email UNIQUE, password, no_telepon,
    no_member UNIQUE, tier ENUM, total_kunjungan, total_belanja,
    is_active, foto, created_at, updated_at
)

layanan (
    id_layanan PK, nama_layanan, deskripsi, icon, gambar,
    id_admin FK→admin, created_at
)

tiket (
    id_tiket PK, jenis_tiket, harga DECIMAL, deskripsi,
    id_admin FK→admin, created_at
)

promosi (
    id_promosi PK, judul_promosi, deskripsi, tanggal_mulai DATE,
    tanggal_selesai DATE, id_admin FK→admin, created_at
)

galeri (
    id_galeri PK, judul_foto, gambar, id_admin FK→admin, created_at
)

kontak (
    id_kontak PK, alamat, nomor_telepon, email, maps, jam_operasional,
    instagram, tiktok, id_admin FK→admin
)

pesanan_tiket (
    id_pesanan PK, kode_booking UNIQUE, id_member FK→members(ON DELETE SET NULL),
    nama_pengunjung, email_pengunjung, telepon_pengunjung, tanggal_kunjungan,
    total_bayar, bukti_pembayaran, status_pembayaran ENUM, status_kunjungan ENUM,
    kunjungan_validated_at, created_at, updated_at
)

pesanan_tiket_detail (
    id_detail PK, id_pesanan FK→pesanan_tiket(CASCADE),
    id_tiket FK→tiket(CASCADE), jumlah, subtotal, created_at, updated_at
)
```

### Relasi
- `admin` → 1:N ke `layanan`, `tiket`, `promosi`, `galeri`, `kontak`
- `members` → 1:N ke `pesanan_tiket`
- `pesanan_tiket` → 1:N ke `pesanan_tiket_detail`
- `tiket` → 1:N ke `pesanan_tiket_detail`

---

## Key Configuration

### Environment (`.env`)
```
APP_NAME="Kids Park"
APP_ENV=local
APP_DEBUG=true
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_DATABASE=kidspark_db
DB_USERNAME=root
DB_PASSWORD=
BCRYPT_ROUNDS=12
SESSION_DRIVER=file
```

### Auto-loaded Helper
```php
// composer.json → autoload.files
"app/Helpers/AppHelper.php"   // formatRupiah($angka)
```

---

## Authentication

### Dual-Guard System

| Aspek | Admin Guard | Member Guard |
|-------|------------|-------------|
| **Guard name** | `admin` | `member` |
| **Middleware** | `admin.auth` | `member.auth` |
| **Model** | `App\Models\Admin` | `App\Models\Member` |
| **Login field** | `username` | `email` |
| **Password** | Bcrypt (12 rounds) | Bcrypt (12 rounds) |
| **Login URL** | `/admin/login` | `/member/login` |
| **After login** | `/admin/dashboard` | `/member/dashboard` |

### Default Credentials
- **Admin:** `admin` / `admin123`

### Member Registration Flow
1. User mengisi form registrasi → `is_active = false`
2. Admin approve via panel → `is_active = true`
3. Member bisa login

---

## Membership Tier System

| Tier | Kunjungan | Diskon | Warna | Ikon |
|------|:---------:|:------:|-------|------|
| Bronze | 0–4 | 0% | #cd7f32 | 🥉 |
| Silver | 5–14 | 5% | #9e9e9e | 🥈 |
| Gold | 15–29 | 10% | #FFD700 | 🥇 |
| Platinum | 30+ | 15% | #4ECDC4 | 💎 |

### Key Model Methods (Member.php)
```php
Member::computeTier(int $kunjungan): string   // Hitung tier dari kunjungan
Member::generateNoMember(): string            // "KP-M-00001"
$member->diskon                                // Accessor: 0, 5, 10, atau 15
$member->tier_progress                         // ['percent', 'next', 'remaining']
```

---

## Routing Overview

### Public Routes
| Method | URI | Action |
|--------|-----|--------|
| GET | `/` | Landing page |
| GET | `/tiket/beli` | Form beli tiket (member only) |
| POST | `/tiket/beli` | Proses pemesanan |
| GET/POST | `/tiket/bayar/{kode}` | Halaman bayar + upload bukti |
| GET | `/tiket/status/{kode}` | Status pesanan |
| GET | `/tiket/cari` | Cari kode booking |

### Member Routes (`/member/*`, middleware: `member.auth`)
| Method | URI | Action |
|--------|-----|--------|
| GET/POST | `/member/login` | Login |
| GET/POST | `/member/register` | Registrasi |
| GET | `/member/dashboard` | Dashboard member |
| GET | `/member/riwayat` | Riwayat pesanan |
| GET/PUT | `/member/profil` | Edit profil |
| PUT | `/member/profil/password` | Ganti password |

### Admin Routes (`/admin/*`, middleware: `admin.auth`)
| Method | URI | Action |
|--------|-----|--------|
| GET | `/admin/dashboard` | Dashboard statistik |
| CRUD | `/admin/layanan` | Kelola layanan |
| CRUD | `/admin/tiket` | Kelola tiket |
| CRUD | `/admin/promosi` | Kelola promosi |
| GET/POST/DEL | `/admin/galeri` | Upload/hapus galeri |
| GET/PUT | `/admin/kontak` | Edit kontak |
| GET/PUT | `/admin/profil` | Edit profil admin |
| GET/POST | `/admin/pesanan` | Kelola pesanan tiket |
| GET/POST | `/admin/validasi` | Validasi kunjungan |
| Resource | `/admin/member` | CRUD member |

---

## CRUD Pattern

Semua modul admin mengikuti pola yang sama:

```
GET    /admin/{modul}              → index (list + form tambah)
POST   /admin/{modul}              → store (simpan baru)
GET    /admin/{modul}/{id}/edit    → edit (form edit pre-filled)
PUT    /admin/{modul}/{id}         → update (simpan perubahan)
DELETE /admin/{modul}/{id}         → destroy (hapus + file cleanup)
```

Setelah operasi POST/PUT/DELETE, selalu `redirect()` dengan flash message (PRG pattern).

---

## Ticket Ordering Flow

```
Member Login → Pilih Tiket & Qty → Isi Data → Generate Kode Booking
    → Redirect ke Halaman Bayar → Upload Bukti → Status: menunggu_konfirmasi
    → Admin Konfirmasi → Status: lunas
    → Pengunjung Datang → Admin Validasi → Status: sudah_hadir
    → total_kunjungan++ → Tier di-recalculate
```

### Status Pembayaran
- `pending` → `menunggu_konfirmasi` → `lunas`
- `pending`/`menunggu_konfirmasi` → `batal`

### Kode Booking Format
- Pattern: `KP-YYYYMMDD-XXXX` (contoh: `KP-20260528-59XZ`)

---

## File Upload

| Parameter | Nilai |
|-----------|-------|
| Allowed types | JPG, JPEG, PNG, WEBP |
| Max size | 5 MB |
| Naming | `uniqid() . '_' . time() . '.ext'` |
| Storage | Laravel Storage (`public` disk) |
| Folders | `galeri/`, `layanan/`, `admin/`, `bukti_bayar/` |
| Access URL | `/storage/uploads/{folder}/{filename}` |
| Cleanup | File dihapus saat record DB dihapus |

---

## Business Rules

1. **Promosi status:** "Aktif" jika `CURDATE()` antara `tanggal_mulai` dan `tanggal_selesai`; "Berakhir" jika sudah lewat.
2. **Harga tiket:** Harus > 0.
3. **Tanggal promosi:** `tanggal_selesai` ≥ `tanggal_mulai`.
4. **Kontak:** Hanya 1 record (UPDATE if exists, INSERT if not).
5. **Galeri:** Hanya upload dan hapus (tidak ada edit).
6. **Member baru:** `is_active = false`, butuh approval admin.
7. **Tier:** Otomatis berdasarkan `total_kunjungan`.
8. **Diskon:** Otomatis dipotong saat pemesanan tiket.
9. **Pemesanan tiket:** Wajib login member.
10. **Tiket tervalidasi:** Tidak bisa divalidasi ulang.

---

## Security Checklist

- [x] Password hashing Bcrypt (12 rounds)
- [x] CSRF token pada setiap form (`@csrf`)
- [x] Eloquent ORM (prepared statements, anti SQL injection)
- [x] Blade `{{ }}` auto-escape (anti XSS)
- [x] Middleware auth terpisah (admin & member)
- [x] Validasi file upload (tipe & ukuran)
- [x] Session regeneration saat login
- [x] Session invalidation saat logout
- [ ] HTTPS (konfigurasi di level server/hosting)
- [ ] Rate limiting login (rekomendasi production)

---

## Design Tokens (CSS Variables)

```css
--primary: #FF6B35    /* Orange utama */
--secondary: #4ECDC4  /* Teal/cyan */
--accent: #FFE66D     /* Kuning */
--dark: #1a1a2e       /* Background gelap */
--text: #2d3748       /* Teks utama */
--radius: 16px        /* Border radius card */
```

---

## Frontend Architecture

### Halaman Publik
- Single-page dengan section-based navigation (`#beranda`, `#layanan`, `#tiket`, `#promosi`, `#galeri`, `#kontak`)
- Smooth scroll + active nav highlight (IntersectionObserver)
- Fade-in animation
- Responsive hamburger menu

### Admin Panel
- Layout: Fixed sidebar (260px) + scrollable main
- Active sidebar state via `$current_page` variable
- Modal konfirmasi hapus (JavaScript)

### Member Area
- Clean card-based layout
- Tier progress bar
- Sidebar navigasi (Dashboard, Riwayat, Profil)

---

## Setup Instructions

### Prasyarat
- PHP 8.3+, Composer 2.x
- MySQL 5.7+ / MariaDB 10+
- Node.js 18+
- Laragon atau XAMPP

### Langkah Setup

```bash
# 1. Clone/extract ke www/htdocs
cd c:\laragon\www\kidspark

# 2. Install dependencies
composer install
npm install

# 3. Setup environment
copy .env.example .env
# Edit DB_PASSWORD sesuai instalasi

# 4. Generate key + migrate
php artisan key:generate
php artisan migrate

# 5. (Opsional) Import data awal
mysql -u root kidspark_db < kidspark_db.sql

# 6. Storage symlink
php artisan storage:link

# 7. Build assets
npm run dev      # Development
npm run build    # Production
```

### Akses

| URL | Keterangan |
|-----|------------|
| `http://kidspark.test/` | Halaman publik |
| `http://kidspark.test/member/login` | Login member |
| `http://kidspark.test/admin/login` | Login admin |

---

## Known Limitations & Future Improvements

| Keterbatasan | Rekomendasi |
|-------------|------------|
| Pembayaran manual (upload bukti) | Payment gateway (Midtrans/Xendit) |
| Tidak ada notifikasi email | Laravel Mail + queue |
| Single admin account | Multi-admin + role management |
| Tidak ada resize gambar | GD Library compress/resize |
| Tidak ada laporan ekspor | PDF/Excel export |
| Tidak ada rate limiting login | Laravel Throttle middleware |
| Tidak ada backup otomatis | Scheduled backup database |
| Tidak ada audit log | Tabel `admin_log` untuk audit trail |

---

## Team & Contact

| NIM | Nama | Role |
|-----|------|------|
| 2507037 | Moh Abi Syamsul | Project Lead, Backend |
| 2507076 | Alifah Nibras | Frontend, UI/UX |
| 2507112 | Winesa | Dokumentasi, QA |

**Institusi:** D4 Sistem Informasi Kota Cerdas — Teknik Informatika — POLINDRA
**Alamat:** Jl. Lohbener Lama No. 8, Indramayu 45252

---

*Dokumen ini diperbarui terakhir: Juni 2025 | Versi 2.0*
