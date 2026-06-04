# Product Requirements Document (PRD)
**Sistem Informasi Promosi dan Layanan Kids Park**

| Atribut | Detail |
|---------|--------|
| **Kode Dokumen** | GL01-PRD-KP-2025 |
| **Versi** | 2.0 |
| **Tanggal** | Juni 2025 |
| **Status** | Final |
| **Tim** | Kelompok 9 — D4 SIKC POLINDRA |
| **Mitra** | Kids Park, Indramayu |

---

## 1. VISI PRODUK

### 1.1 Problem Statement
Kids Park Indramayu mengalami beberapa permasalahan operasional:

1. **Informasi tidak terpusat** — Promosi dan informasi layanan tersebar di berbagai media sosial tanpa satu portal resmi yang konsisten.
2. **Penjualan tiket konvensional** — Penjualan hanya di loket menyebabkan antrian panjang, terutama pada akhir pekan dan musim liburan.
3. **Tidak ada program loyalitas** — Tidak ada insentif bagi pelanggan untuk berkunjung kembali secara berulang.
4. **Data pengunjung tidak terkelola** — Pengelola tidak memiliki data akurat tentang jumlah pengunjung, pendapatan, dan tren kunjungan.

### 1.2 Solusi yang Ditawarkan
Membangun **platform web all-in-one** yang menggabungkan:
- Website promosi resmi dengan konten yang dikelola secara mandiri (CMS)
- Sistem pemesanan tiket daring untuk mengurangi antrian loket
- Program membership dengan tier-based loyalty rewards
- Dashboard analitik untuk pengambilan keputusan berbasis data

### 1.3 Target Pengguna

| Persona | Deskripsi | Kebutuhan Utama |
|---------|-----------|-----------------|
| **Keluarga Muda** | Orang tua usia 25–40 tahun, anak usia 3–12 tahun | Informasi lengkap, foto galeri, harga transparan, pemesanan tiket mudah via smartphone |
| **Pengelola/Pemilik** | Owner Kids Park | Dashboard statistik, ringkasan pendapatan, kontrol konten |
| **Admin/Operator** | Staff yang ditugaskan mengelola sistem | Antarmuka CRUD sederhana, konfirmasi pesanan, validasi tiket di pintu masuk |
| **Pelanggan Setia (Member)** | Pengunjung yang sering datang | Diskon tier, riwayat kunjungan, tracking progress membership |

---

## 2. SPESIFIKASI FITUR

### 2.1 Modul Halaman Publik (Landing Page)

**Deskripsi:** Halaman utama yang menjadi wajah digital Kids Park, menampilkan seluruh informasi penting dalam format single-page dengan navigasi smooth-scroll.

#### 2.1.1 Section-section Halaman Publik

| # | Section | Konten | Sumber Data |
|---|---------|--------|-------------|
| 1 | **Hero** | Banner utama dengan tagline, tombol CTA "Beli Tiket" dan "Jelajahi" | Statis |
| 2 | **Tentang** | Deskripsi singkat Kids Park | Statis |
| 3 | **Layanan** | Daftar layanan dengan ikon, nama, deskripsi, dan gambar | Tabel `layanan` |
| 4 | **Harga Tiket** | Kartu harga per jenis tiket (Anak/Dewasa, Weekday/Weekend) | Tabel `tiket` |
| 5 | **Promosi** | Daftar promosi aktif/berakhir dengan badge status | Tabel `promosi` |
| 6 | **Galeri** | Grid foto dokumentasi (max 8 terbaru) | Tabel `galeri` |
| 7 | **Kontak** | Alamat, telepon, email, jam operasional, embed Google Maps | Tabel `kontak` |

#### 2.1.2 Fitur UX Landing Page
- **Smooth scroll** — Navigasi anchor-link dengan scroll halus antar section
- **Active nav highlight** — Menu navigasi menyala sesuai posisi scroll (IntersectionObserver)
- **Fade-in animation** — Elemen muncul dengan animasi saat masuk viewport
- **Responsive design** — Hamburger menu untuk layar < 768px
- **Floating CTA** — Tombol "Beli Tiket" yang selalu terlihat

---

### 2.2 Modul Pemesanan Tiket

**Deskripsi:** Sistem pemesanan tiket end-to-end yang memungkinkan member membeli tiket secara daring.

#### 2.2.1 Alur Pemesanan (User Journey)

```
┌──────────────────────────────────────────────────────────┐
│ 1. PILIH TIKET                                            │
│    ├─ Member login (wajib)                                │
│    ├─ Pilih jenis tiket & kuantitas                       │
│    ├─ Isi nama pengunjung, email, telepon                 │
│    ├─ Pilih tanggal kunjungan (≥ hari ini)                │
│    └─ Lihat ringkasan + diskon member (jika ada)          │
├──────────────────────────────────────────────────────────┤
│ 2. PEMBAYARAN                                             │
│    ├─ Sistem generate kode booking (KP-YYYYMMDD-XXXX)     │
│    ├─ Tampilkan rincian tagihan & nomor rekening           │
│    ├─ Member transfer ke rekening Kids Park                │
│    └─ Upload foto bukti transfer                          │
├──────────────────────────────────────────────────────────┤
│ 3. KONFIRMASI                                             │
│    ├─ Admin menerima notifikasi pesanan baru               │
│    ├─ Admin cek bukti bayar → Konfirmasi / Tolak           │
│    └─ Status berubah: lunas / batal                        │
├──────────────────────────────────────────────────────────┤
│ 4. KUNJUNGAN                                              │
│    ├─ Pengunjung datang → tunjukkan kode booking           │
│    ├─ Admin scan/input kode di halaman Validasi            │
│    ├─ Sistem verifikasi: tiket lunas & belum dipakai       │
│    └─ Status: sudah_hadir, kunjungan_validated_at = now()  │
├──────────────────────────────────────────────────────────┤
│ 5. POST-KUNJUNGAN                                         │
│    ├─ total_kunjungan member bertambah                     │
│    ├─ Tier di-recalculate (bisa naik tier)                 │
│    └─ Diskon lebih besar untuk pembelian berikutnya        │
└──────────────────────────────────────────────────────────┘
```

#### 2.2.2 Status Pesanan

| Status | Deskripsi | Warna Badge |
|--------|-----------|-------------|
| `pending` | Pesanan dibuat, belum ada bukti bayar | Abu-abu |
| `menunggu_konfirmasi` | Bukti bayar sudah diupload, menunggu verifikasi admin | Kuning |
| `lunas` | Admin telah mengonfirmasi pembayaran | Hijau |
| `batal` | Pesanan dibatalkan oleh admin | Merah |

#### 2.2.3 Kode Booking Format
- **Pattern:** `KP-YYYYMMDD-XXXX`
- **Contoh:** `KP-20260528-59XZ`
- **YYYY:** Tahun kunjungan
- **MMDD:** Bulan dan tanggal kunjungan
- **XXXX:** 4 karakter random alfanumerik (unik)

---

### 2.3 Modul Membership

**Deskripsi:** Sistem keanggotaan bertingkat yang memberikan insentif kepada pelanggan setia.

#### 2.3.1 Registrasi & Aktivasi

| Langkah | Aktor | Aksi |
|---------|-------|------|
| 1 | Calon Member | Mengisi form registrasi (nama, email, telepon, password) |
| 2 | Sistem | Membuat akun dengan `is_active = false`, generate `no_member` |
| 3 | Admin | Melihat member baru di panel, toggle aktifkan |
| 4 | Member | Dapat login dan menggunakan fitur member |

#### 2.3.2 Tier System

| Tier | Syarat | Diskon Tiket | Benefit |
|------|--------|:------------:|---------|
| 🥉 Bronze | 0–4 kunjungan | 0% | Dashboard personal, riwayat pesanan |
| 🥈 Silver | 5–14 kunjungan | 5% | Semua Bronze + diskon 5% |
| 🥇 Gold | 15–29 kunjungan | 10% | Semua Silver + diskon 10% |
| 💎 Platinum | 30+ kunjungan | 15% | Semua Gold + diskon 15% |

#### 2.3.3 Dashboard Member
- **Informasi tier** — Tier saat ini dengan warna dan ikon
- **Progress bar** — Persentase progres menuju tier berikutnya
- **Statistik** — Total kunjungan, total belanja, jumlah transaksi lunas
- **Riwayat pesanan** — 5 pesanan terbaru (dengan link detail)
- **Profil** — Edit nama, telepon, dan ganti password

---

### 2.4 Modul Admin Panel

**Deskripsi:** Dashboard pengelolaan terpusat untuk administrator.

#### 2.4.1 Dashboard Statistik

| Statistik | Sumber | Keterangan |
|-----------|--------|------------|
| Total Layanan | `COUNT(layanan)` | Jumlah layanan terdaftar |
| Total Jenis Tiket | `COUNT(tiket)` | Jumlah varian tiket |
| Total Promosi | `COUNT(promosi)` | Jumlah promosi (aktif + nonaktif) |
| Total Galeri | `COUNT(galeri)` | Jumlah foto di galeri |
| Promo Aktif | Filter `tanggal_mulai ≤ today ≤ tanggal_selesai` | Promosi yang sedang berjalan |
| Total Pendapatan | `SUM(total_bayar) WHERE status=lunas` | Akumulasi pendapatan tiket |
| Validasi Hari Ini | `COUNT WHERE validated_at = today` | Pengunjung yang datang hari ini |
| Menunggu Konfirmasi | `COUNT WHERE status=menunggu_konfirmasi` | Pesanan belum diverifikasi |

#### 2.4.2 Modul CRUD Admin

| Modul | Create | Read | Update | Delete | Catatan Khusus |
|-------|:------:|:----:|:------:|:------:|----------------|
| Layanan | ✅ | ✅ | ✅ | ✅ | Upload gambar opsional |
| Tiket | ✅ | ✅ | ✅ | ✅ | Harga harus > 0 |
| Promosi | ✅ | ✅ | ✅ | ✅ | Validasi rentang tanggal |
| Galeri | ✅ | ✅ | ❌ | ✅ | Hanya upload & hapus |
| Kontak | ❌ | ✅ | ✅ | ❌ | Hanya 1 record, edit saja |
| Pesanan | ❌ | ✅ | ✅* | ❌ | *Hanya update status |
| Member | ✅ | ✅ | ✅ | ✅ | Toggle aktif/nonaktif |
| Profil Admin | ❌ | ✅ | ✅ | ❌ | Edit nama, jabatan, foto, password |

#### 2.4.3 Kelola Pesanan Tiket
- **Daftar pesanan** — Filter berdasarkan status, pencarian kode booking/nama/telepon, pagination
- **Detail pesanan** — Rincian tiket, data pengunjung, bukti bayar, info member (jika ada)
- **Konfirmasi pembayaran** — Ubah status menjadi `lunas`
- **Batalkan pesanan** — Ubah status menjadi `batal`

#### 2.4.4 Validasi Kunjungan
- **Input kode booking** — Admin mengetikkan atau scan kode
- **Verifikasi** — Sistem mengecek: (a) kode valid, (b) status lunas, (c) belum digunakan
- **Opsi "Bayar & Masuk"** — Untuk walk-in: langsung set lunas + sudah_hadir
- **Update member** — total_kunjungan++, tier di-recalculate

#### 2.4.5 Manajemen Member
- **Daftar member** — Tabel dengan filter aktif/nonaktif
- **Detail member** — Info lengkap + riwayat pesanan
- **Toggle aktif** — Approve/suspend akun member
- **Tambah member** — Admin bisa membuat akun member secara manual
- **Edit member** — Ubah data member
- **Hapus member** — Hapus akun member

---

## 3. DESAIN UI/UX

### 3.1 Design Tokens

| Token | Nilai | Penggunaan |
|-------|-------|------------|
| `--primary` | `#FF6B35` | Orange utama (CTA, header, aksen) |
| `--secondary` | `#4ECDC4` | Teal/cyan (badge, highlight) |
| `--accent` | `#FFE66D` | Kuning (dekorasi, sparkle) |
| `--dark` | `#1a1a2e` | Background gelap (hero, section tiket) |
| `--text` | `#2d3748` | Warna teks utama |
| `--radius` | `16px` | Border radius kartu |

### 3.2 Layout Patterns

**Halaman Publik:**
- Full-width single-page layout
- Sticky navigation bar di atas
- Section-based content dengan background bergantian
- Footer dengan informasi kontak

**Admin Panel:**
- Fixed sidebar (260px) + scrollable main content
- Top header dengan nama admin + logout
- Card-based dashboard statistik
- Table-based data management
- Modal konfirmasi untuk aksi hapus

**Member Area:**
- Clean card-based layout
- Sidebar navigasi (Dashboard, Riwayat, Profil)
- Progress bar tier yang visual

### 3.3 Responsive Breakpoints

| Breakpoint | Target | Layout |
|-----------|--------|--------|
| ≥1024px | Desktop | Full sidebar + multi-column grid |
| 768–1023px | Tablet | Collapsed sidebar, 2-column grid |
| <768px | Mobile | Hamburger menu, single column, stacked cards |

---

## 4. METRIK KEBERHASILAN

### 4.1 Kriteria Penerimaan (Acceptance Criteria)

| # | Kriteria | Status |
|---|---------|--------|
| AC-1 | Landing page menampilkan semua section (layanan, tiket, promosi, galeri, kontak) | ✅ |
| AC-2 | Admin dapat login dan mengakses dashboard | ✅ |
| AC-3 | Admin dapat melakukan CRUD pada semua modul konten | ✅ |
| AC-4 | Member dapat mendaftar, login, dan melihat dashboard | ✅ |
| AC-5 | Member dapat memesan tiket dan mendapatkan kode booking | ✅ |
| AC-6 | Member dapat mengupload bukti pembayaran | ✅ |
| AC-7 | Admin dapat mengkonfirmasi pesanan | ✅ |
| AC-8 | Admin dapat memvalidasi kunjungan dengan kode booking | ✅ |
| AC-9 | Diskon tier diterapkan otomatis saat pemesanan | ✅ |
| AC-10 | Tier member naik otomatis berdasarkan total kunjungan | ✅ |
| AC-11 | Halaman responsif di mobile, tablet, dan desktop | ✅ |
| AC-12 | Semua form memiliki validasi server-side | ✅ |

### 4.2 Known Limitations

| # | Limitasi | Rekomendasi Perbaikan |
|---|---------|----------------------|
| 1 | Pembayaran manual (upload bukti) | Integrasi payment gateway (Midtrans/Xendit) |
| 2 | Tidak ada notifikasi email/push | Implementasi email notification (Laravel Mail) |
| 3 | Single admin account | Multi-user admin dengan role management |
| 4 | Tidak ada resize otomatis gambar | GD Library untuk compress/resize |
| 5 | Tidak ada laporan ekspor | Ekspor PDF/Excel untuk laporan keuangan |
| 6 | Tidak ada rate limiting login | Implementasi throttling untuk keamanan |

---

## 5. RENCANA RILIS

### 5.1 Versi Rilis

| Versi | Fitur | Target |
|-------|-------|--------|
| **v1.0** | Landing page + CMS Admin (CRUD layanan, tiket, promosi, galeri, kontak) | Sprint 1–3 |
| **v1.5** | Pemesanan tiket daring + konfirmasi admin | Sprint 4 |
| **v2.0** | Membership system (registrasi, tier, diskon) + validasi kunjungan + manajemen member | Sprint 5–6 |
| **v2.1** *(future)* | Payment gateway, email notifikasi, laporan PDF | Backlog |

---

*Dokumen ini terakhir diperbarui: Juni 2025 | Versi 2.0*
*Program Studi D4 Sistem Informasi Kota Cerdas — Teknik Informatika — POLINDRA*
