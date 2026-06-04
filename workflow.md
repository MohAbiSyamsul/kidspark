# Kids Park — Development Workflow

> Panduan lengkap workflow development untuk Sistem Informasi Promosi dan Layanan Kids Park (Laravel 13)

---

## 📋 Table of Contents

1. [Project Overview](#-project-overview)
2. [Environment Setup](#-environment-setup)
3. [Development Workflow](#-development-workflow)
4. [Architecture & Directory Structure](#-architecture--directory-structure)
5. [Database Management](#-database-management)
6. [Authentication Workflow](#-authentication-workflow)
7. [CRUD Pattern](#-crud-pattern)
8. [Ticket Ordering Workflow](#-ticket-ordering-workflow)
9. [Membership System Workflow](#-membership-system-workflow)
10. [File Upload Workflow](#-file-upload-workflow)
11. [Testing Workflow](#-testing-workflow)
12. [Git Workflow](#-git-workflow)
13. [Deployment Workflow](#-deployment-workflow)
14. [Troubleshooting](#-troubleshooting)

---

## 📌 Project Overview

| Aspek | Detail |
|-------|--------|
| **Nama Proyek** | Kids Park Web Information System |
| **Framework** | Laravel 13 |
| **Stack** | PHP 8.3+, Laravel, MySQL, Blade, Vite |
| **Database** | MySQL 5.7+ / MariaDB 10+ |
| **Server** | Apache (Laragon) |
| **Node Version** | 18+ (untuk Vite) |
| **PHP Version** | 8.3+ |
| **Modul** | Publik, Member, Admin |

---

## 🚀 Environment Setup

### Prerequisites

```
- PHP 8.3+
- Composer 2.x
- MySQL / MariaDB
- Node.js 18+
- Git
- Laragon (atau XAMPP)
```

### Initial Setup

```bash
# 1. Clone / extract project
cd c:\laragon\www\kidspark

# 2. Install PHP dependencies
composer install

# 3. Install Node dependencies
npm install

# 4. Copy environment file
copy .env.example .env
# Sesuaikan DB_PASSWORD (kosong untuk Laragon tanpa password, 'root' jika ada)

# 5. Generate app key
php artisan key:generate

# 6. Buat database
# Buka phpMyAdmin/HeidiSQL → Buat DB 'kidspark_db'
# Atau via CLI:
mysql -u root -e "CREATE DATABASE IF NOT EXISTS kidspark_db"

# 7. Migrate database
php artisan migrate

# 8. (Opsional) Import data awal dari SQL dump
mysql -u root kidspark_db < kidspark_db.sql

# 9. Create storage symlink
php artisan storage:link

# 10. Build/watch assets
npm run dev        # Development (watch mode)
npm run build      # Production build
```

### Akses URL

| URL | Keterangan |
|-----|------------|
| `http://kidspark.test/` | Halaman publik (Laragon auto-vhost) |
| `http://kidspark.test/member/login` | Login member |
| `http://kidspark.test/admin/login` | Login admin |
| `http://kidspark.test/admin/dashboard` | Dashboard admin |
| `http://127.0.0.1:8000/` | Jika pakai `php artisan serve` |

### Default Credentials

| Role | Username/Email | Password |
|------|---------------|----------|
| Admin | `admin` | `admin123` |

---

## 💻 Development Workflow

### Daily Development Cycle

```
1. Start Services
   ├─ Laragon → Start All (Apache + MySQL)
   ├─ npm run dev                   # Watch mode Vite
   └─ (Opsional) php artisan serve  # Jika tidak pakai Laragon vhost

2. Code → Test → Commit
   ├─ Buat/edit file sesuai modul
   ├─ Test di browser
   ├─ git add . && git commit -m "feat: deskripsi"
   └─ git push origin branch-name

3. End of Day
   ├─ git push semua perubahan
   └─ npm run build (opsional, cek production)
```

### Development Commands Cheatsheet

```bash
# ── Server ──────────────────────────────────
php artisan serve                    # Start dev server port 8000
php artisan serve --port=8001        # Ganti port

# ── Database ────────────────────────────────
php artisan migrate                  # Jalankan migration
php artisan migrate:rollback         # Rollback terakhir
php artisan migrate:refresh --seed   # Reset + seed
php artisan migrate:status           # Lihat status migration

# ── Cache Management ───────────────────────
php artisan cache:clear              # Hapus cache
php artisan config:clear             # Hapus config cache
php artisan route:clear              # Hapus route cache
php artisan view:clear               # Hapus compiled views
php artisan optimize:clear           # Hapus semua cache

# ── Generate ────────────────────────────────
php artisan make:model Nama -m       # Model + migration
php artisan make:controller NamaController
php artisan make:middleware NamaMiddleware
php artisan make:seeder NamaSeeder

# ── Assets ──────────────────────────────────
npm run dev                          # Vite watch mode
npm run build                        # Production build

# ── Debugging ───────────────────────────────
php artisan tinker                   # REPL interaktif
php artisan route:list               # Lihat semua routes
```

---

## 🏗 Architecture & Directory Structure

### MVC Pattern

```
Request → routes/web.php → Middleware → Controller → Model ↔ Database
                                            ↓
                                      View (Blade) → Response
```

### Directory Map

```
kidspark/
├── app/
│   ├── Helpers/
│   │   └── AppHelper.php              # Global helper: formatRupiah()
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Controller.php         # Base controller
│   │   │   ├── PublicController.php        # GET / (landing page)
│   │   │   ├── PublicTicketController.php  # Pemesanan tiket
│   │   │   ├── MemberAuthController.php    # Login/register member
│   │   │   ├── MemberDashboardController.php  # Dashboard member
│   │   │   └── Admin/
│   │   │       ├── AuthController.php      # Login/logout admin
│   │   │       ├── DashboardController.php # Dashboard admin
│   │   │       ├── LayananController.php   # CRUD layanan
│   │   │       ├── TiketController.php     # CRUD tiket
│   │   │       ├── PromosiController.php   # CRUD promosi
│   │   │       ├── GaleriController.php    # Upload/hapus galeri
│   │   │       ├── KontakController.php    # Edit kontak
│   │   │       ├── ProfilController.php    # Edit profil admin
│   │   │       ├── PesananController.php   # Kelola pesanan
│   │   │       └── MemberController.php    # Kelola member
│   │   └── Middleware/
│   │       ├── AdminAuth.php              # Proteksi route admin
│   │       └── MemberAuth.php             # Proteksi route member
│   ├── Models/
│   │   ├── Admin.php                  # username, password, nama, jabatan, foto
│   │   ├── Member.php                 # Tier system, diskon, progress
│   │   ├── Layanan.php               # nama_layanan, deskripsi, icon, gambar
│   │   ├── Tiket.php                 # jenis_tiket, harga, deskripsi
│   │   ├── Promosi.php               # judul, tanggal_mulai, tanggal_selesai
│   │   ├── Galeri.php                # judul_foto, gambar
│   │   ├── Kontak.php                # alamat, telepon, email, maps
│   │   ├── PesananTiket.php          # kode_booking, status, total_bayar
│   │   └── PesananTiketDetail.php    # tiket qty per pesanan
│   └── Providers/
│
├── resources/views/
│   ├── welcome.blade.php             # Landing page publik
│   ├── layouts/
│   │   ├── app.blade.php            # Layout publik/member
│   │   └── admin.blade.php          # Layout admin (sidebar + header)
│   ├── admin/                        # Semua view admin
│   ├── member/                       # Dashboard, profil, riwayat member
│   └── tiket/                        # Beli, bayar, status, cari
│
├── routes/web.php                    # Definisi semua route
├── database/migrations/              # Skema database
├── public/                           # Entry point + aset statis
├── config/                           # Konfigurasi Laravel
├── storage/                          # File upload, logs, sessions
└── doc/                              # Dokumentasi proyek
```

---

## 🗄 Database Management

### Current Tables

| Tabel | Kolom Utama | Relasi |
|-------|-------------|--------|
| `admin` | id_admin, username, password, nama, jabatan, foto | 1:N ke layanan, tiket, dll |
| `members` | id_member, nama_lengkap, email, password, no_member, tier | 1:N ke pesanan_tiket |
| `layanan` | id_layanan, nama_layanan, deskripsi, icon, gambar | FK id_admin |
| `tiket` | id_tiket, jenis_tiket, harga, deskripsi | FK id_admin; 1:N ke detail |
| `promosi` | id_promosi, judul_promosi, tanggal_mulai, tanggal_selesai | FK id_admin |
| `galeri` | id_galeri, judul_foto, gambar | FK id_admin |
| `kontak` | id_kontak, alamat, telepon, email, maps, jam_operasional | FK id_admin |
| `pesanan_tiket` | id_pesanan, kode_booking, id_member, status_pembayaran | FK id_member |
| `pesanan_tiket_detail` | id_detail, id_pesanan, id_tiket, jumlah, subtotal | FK id_pesanan, id_tiket |

### Migration Commands

```bash
# Lihat status
php artisan migrate:status

# Jalankan pending migrations
php artisan migrate

# Rollback batch terakhir
php artisan migrate:rollback

# Reset semua + migrate ulang
php artisan migrate:refresh

# Reset + migrate + seed
php artisan migrate:refresh --seed

# Buat migration baru
php artisan make:migration create_nama_table
php artisan make:migration add_kolom_to_nama_table
```

### Backup & Restore

```bash
# Export
mysqldump -u root kidspark_db > kidspark_db_backup.sql

# Import
mysql -u root kidspark_db < kidspark_db.sql

# Atau via export_db.php (tersedia di public/)
# Akses: http://kidspark.test/export_db.php
```

---

## 🔐 Authentication Workflow

### Dual-Guard System

```
┌────────────────────────────────────────────┐
│           AUTHENTICATION FLOW              │
├─────────────────┬──────────────────────────┤
│   ADMIN GUARD   │     MEMBER GUARD         │
├─────────────────┼──────────────────────────┤
│ Login Field:    │ Login Field:             │
│   username      │   email                  │
│                 │                          │
│ Middleware:     │ Middleware:              │
│   admin.auth    │   member.auth            │
│                 │                          │
│ Session Guard:  │ Session Guard:           │
│   auth:admin    │   auth:member            │
│                 │                          │
│ Redirect:       │ Redirect:               │
│   /admin/login  │   /member/login          │
│                 │                          │
│ After Login:    │ After Login:             │
│   /admin/       │   /member/dashboard      │
│   dashboard     │   (atau intended URL)    │
└─────────────────┴──────────────────────────┘
```

### Admin Auth Flow

```
[/admin/login GET] → tampilkan form
        ↓
[/admin/login POST] → validasi username + password
        ↓
    ┌──── valid? ────┐
    │                │
   YES              NO
    │                │
Auth::guard('admin')  return back()
  ->login($admin)     ->withErrors()
    │
redirect('/admin/dashboard')
```

### Member Auth Flow (dengan Approval)

```
[/member/register GET] → form registrasi
        ↓
[/member/register POST] → validasi data
        ↓
Member::create([is_active => false])
        ↓
"Akun menunggu konfirmasi admin"
        ↓
[Admin: /admin/member → toggle active]
        ↓
[/member/login POST]
        ↓
    ┌── is_active? ──┐
    │                │
   YES              NO
    │                │
Auth::guard('member')  "Akun belum
  ->login($member)      dikonfirmasi"
    │
redirect('/member/dashboard')
```

---

## ✏️ CRUD Pattern

### Standard Admin CRUD Flow

Setiap modul admin (Layanan, Tiket, Promosi) mengikuti pola yang sama:

```
┌─ INDEX (/admin/{modul}) ──────────────────────────┐
│  GET  → Controller@index                           │
│  Tampilkan: tabel data + form tambah               │
│  Fitur: pagination, search (jika ada)              │
└────────────────────────────────────────────────────┘
         ↓
┌─ STORE (/admin/{modul}) ──────────────────────────┐
│  POST → Controller@store                           │
│  Validasi → simpan ke DB → redirect dengan flash   │
└────────────────────────────────────────────────────┘
         ↓
┌─ EDIT (/admin/{modul}/{id}/edit) ─────────────────┐
│  GET  → Controller@edit                            │
│  Tampilkan: form pre-filled dengan data existing   │
└────────────────────────────────────────────────────┘
         ↓
┌─ UPDATE (/admin/{modul}/{id}) ────────────────────┐
│  PUT   → Controller@update                         │
│  Validasi → update DB → redirect dengan flash      │
└────────────────────────────────────────────────────┘
         ↓
┌─ DESTROY (/admin/{modul}/{id}) ───────────────────┐
│  DELETE → Controller@destroy                       │
│  Konfirmasi JS → hapus file (jika ada) → hapus DB  │
│  → redirect dengan flash                           │
└────────────────────────────────────────────────────┘
```

### Controller Template

```php
// app/Http/Controllers/Admin/LayananController.php
public function index()
{
    $layanan = Layanan::orderBy('id_layanan', 'desc')->get();
    return view('admin.layanan.index', compact('layanan'));
}

public function store(Request $request)
{
    $request->validate([...]);
    Layanan::create([...]);
    return redirect()->route('admin.layanan.index')
        ->with('success', 'Layanan berhasil ditambahkan.');
}

public function edit(Layanan $layanan)
{
    return view('admin.layanan.edit', compact('layanan'));
}

public function update(Request $request, Layanan $layanan)
{
    $request->validate([...]);
    $layanan->update([...]);
    return redirect()->route('admin.layanan.index')
        ->with('success', 'Layanan berhasil diperbarui.');
}

public function destroy(Layanan $layanan)
{
    // Hapus file jika ada
    if ($layanan->gambar) {
        Storage::disk('public')->delete('uploads/' . $layanan->gambar);
    }
    $layanan->delete();
    return redirect()->route('admin.layanan.index')
        ->with('success', 'Layanan berhasil dihapus.');
}
```

---

## 🎫 Ticket Ordering Workflow

### End-to-End Flow

```
MEMBER                          SYSTEM                          ADMIN
  │                               │                               │
  ├─ Login ──────────────────────→│                               │
  │                               │                               │
  ├─ GET /tiket/beli ────────────→│                               │
  │←── Form pilih tiket ─────────│                               │
  │                               │                               │
  ├─ POST /tiket/beli ───────────→│                               │
  │    (tiket_qty[], data diri)   │                               │
  │                               ├─ Validate input               │
  │                               ├─ Calculate total              │
  │                               ├─ Apply member discount        │
  │                               ├─ Generate kode_booking        │
  │                               ├─ Save pesanan_tiket           │
  │                               ├─ Save pesanan_tiket_detail    │
  │←── Redirect /tiket/bayar ────│                               │
  │                               │                               │
  ├─ Upload bukti bayar ─────────→│                               │
  │                               ├─ Save file                   │
  │                               ├─ Status → menunggu_konfirmasi│
  │                               │                               │
  │                               │──── Pesanan muncul ──────────→│
  │                               │                               ├─ Cek bukti
  │                               │←── POST /konfirmasi ─────────│
  │                               ├─ Status → lunas              │
  │                               ├─ Update member total_belanja │
  │                               │                               │
  │ === HARI KUNJUNGAN ===        │                               │
  │                               │                               │
  ├─ Tunjukkan kode booking ─────────────────────────────────────→│
  │                               │←── GET /validasi ────────────│
  │                               │    (input kode_booking)       │
  │                               ├─ Verify: lunas + belum_hadir │
  │                               │←── POST /validasi ───────────│
  │                               ├─ Status → sudah_hadir        │
  │                               ├─ kunjungan_validated_at=now  │
  │                               ├─ member.total_kunjungan++    │
  │                               ├─ Re-compute tier             │
  │                               │                               │
  │ === SELESAI ===               │                               │
```

### Discount Calculation

```php
// Di PublicTicketController@store
$diskon_persen = $member->diskon;         // Accessor: 0, 5, 10, atau 15
$diskon_nominal = $total * ($diskon_persen / 100);
$final = $total - $diskon_nominal;
```

---

## 👑 Membership System Workflow

### Tier Progression

```
                    ┌─────────────┐
                    │   REGISTER  │
                    │ is_active=0 │
                    └──────┬──────┘
                           │ Admin Approve
                    ┌──────▼──────┐
                    │   BRONZE    │ 0-4 kunjungan, 0% disc
                    └──────┬──────┘
                           │ 5 kunjungan
                    ┌──────▼──────┐
                    │   SILVER    │ 5-14 kunjungan, 5% disc
                    └──────┬──────┘
                           │ 15 kunjungan
                    ┌──────▼──────┐
                    │    GOLD     │ 15-29 kunjungan, 10% disc
                    └──────┬──────┘
                           │ 30 kunjungan
                    ┌──────▼──────┐
                    │  PLATINUM   │ 30+ kunjungan, 15% disc
                    └─────────────┘
```

### Key Functions (Member Model)

```php
// Compute tier from kunjungan count
Member::computeTier(int $kunjungan): string

// Generate unique member number
Member::generateNoMember(): string  // "KP-M-00001"

// Accessor: diskon percentage
$member->diskon  // 0, 5, 10, or 15

// Accessor: progress to next tier
$member->tier_progress  // ['percent' => 60, 'next' => 'Silver', 'remaining' => 2]
```

---

## 📁 File Upload Workflow

### Upload Process

```
User selects file
        ↓
Client-side validation (accept attribute)
        ↓
Server-side validation:
  ├─ Is image? (mimes: jpg, jpeg, png, webp)
  ├─ Max size: 5MB (5120 KB)
  └─ Required? (depends on context)
        ↓
Generate unique filename:
  uniqid() . '_' . time() . '.' . extension
        ↓
Store via Laravel Storage:
  $file->storeAs('uploads/{folder}', $filename, 'public')
        ↓
Save relative path to DB:
  "{folder}/{filename}"
        ↓
Access via URL:
  /storage/uploads/{folder}/{filename}
```

### Upload Folders

| Folder | Konten | Controller |
|--------|--------|------------|
| `uploads/galeri/` | Foto galeri | GaleriController |
| `uploads/layanan/` | Gambar layanan | LayananController |
| `uploads/admin/` | Foto profil admin | ProfilController |
| `uploads/bukti_bayar/` | Bukti pembayaran | PublicTicketController |

---

## 🧪 Testing Workflow

```bash
# Jalankan semua tests
php artisan test

# Test file spesifik
php artisan test tests/Feature/LayananTest.php

# Test dengan filter
php artisan test --filter=LoginTest

# Test dengan output verbose
php artisan test --verbose

# Test dengan coverage
php artisan test --coverage
```

---

## 🌿 Git Workflow

### Branch Strategy

```
main (production)
 └─ develop (integration)
     ├─ feature/nama-fitur
     ├─ bugfix/nama-bug
     └─ hotfix/nama-hotfix
```

### Commit Convention

```
feat: add member dashboard page
fix: resolve login redirect loop
docs: update BRD document
style: format blade templates
refactor: simplify tier calculation
test: add layanan CRUD tests
chore: update npm dependencies
```

### Standard Flow

```bash
# Mulai fitur baru
git checkout develop
git pull origin develop
git checkout -b feature/nama-fitur

# Development...
git add .
git commit -m "feat: deskripsi perubahan"

# Push
git push origin feature/nama-fitur

# Setelah review, merge ke develop
git checkout develop
git merge feature/nama-fitur
git push origin develop

# Cleanup
git branch -d feature/nama-fitur
```

---

## 🚀 Deployment Workflow

### Production Build

```bash
# 1. Build assets
npm run build

# 2. Optimize Laravel
php artisan config:cache
php artisan route:cache
php artisan view:cache
composer install --optimize-autoloader --no-dev

# 3. Set environment
# .env: APP_ENV=production, APP_DEBUG=false

# 4. Run migrations
php artisan migrate --force
```

### Railway / Cloud Deployment

```bash
# Database reset route tersedia (HANYA untuk development):
# GET /debug/db-reset
# ⚠️ HAPUS route ini di production!
```

---

## 🛠 Troubleshooting

### Database Connection Error
```bash
# 1. Cek .env
DB_HOST=127.0.0.1
DB_DATABASE=kidspark_db
DB_USERNAME=root
DB_PASSWORD=

# 2. Clear config cache
php artisan config:clear

# 3. Pastikan MySQL aktif di Laragon
```

### Storage/Upload Error
```bash
# 1. Buat symlink storage
php artisan storage:link

# 2. Pastikan folder writable
# Windows: klik kanan storage → Properties → Security
```

### Vite Assets Not Loading
```bash
npm install
npm run dev
php artisan view:clear
```

### Auth/Session Issues
```bash
php artisan config:clear
php artisan cache:clear
# Cek config/auth.php → guards & providers
```

### Migration Conflict
```bash
php artisan migrate:status
php artisan migrate:rollback
# Edit migration file, lalu:
php artisan migrate
```

---

## 👥 Team Checklist

### Before Starting Work
- [ ] `git pull origin develop`
- [ ] `composer install && npm install`
- [ ] `php artisan migrate`
- [ ] `npm run dev`

### While Developing
- [ ] Follow PSR-12 code style
- [ ] Meaningful commit messages
- [ ] Server-side validation on all forms
- [ ] Use Blade `{{ }}` for output (XSS prevention)
- [ ] Use Eloquent ORM (no raw queries)

### Before Committing
- [ ] Test all affected features in browser
- [ ] `npm run build` (check production build)
- [ ] No `.env` or `vendor/` in commit

---

*Last Updated: Juni 2025 | Team: Kelompok 9 - D4 SIKC POLINDRA*
