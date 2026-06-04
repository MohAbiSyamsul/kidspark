# 🎬 Script Video Presentasi Proyek
## Sistem Informasi Promosi dan Layanan Kids Park
### Kelompok 9 — D4 SIKC POLINDRA

---

> **Durasi Target:** 10–12 menit
> **Format:** MP4, Resolusi minimal 720p
> **Ketentuan:** Wajah presenter tampil di pembukaan dan penutupan

**Panduan Simbol:**
- 🎥 = Instruksi kamera/visual
- 🖥️ = Screen recording / tampilan layar
- 🗣️ = Narasi yang dibacakan
- ⏱️ = Estimasi durasi segmen

---

## BAGIAN 1: PEMBUKAAN & PERKENALAN KELOMPOK
⏱️ **Durasi: ±1,5 menit**

---

🎥 *Kamera menghadap presenter (salah satu atau semua anggota). Background rapi. Bisa pakai virtual background bertema Kids Park/playground.*

🗣️ **Presenter (Abi):**

> "Assalamu'alaikum Warahmatullahi Wabarakatuh.
> Selamat [pagi/siang/sore], Bapak/Ibu dosen dan teman-teman sekalian.
>
> Perkenalkan, kami dari **Kelompok 9**, Program Studi **D4 Sistem Informasi Kota Cerdas**, Jurusan Teknik Informatika, **Politeknik Negeri Indramayu**.
>
> Pada kesempatan kali ini, kami akan mempresentasikan proyek kami yang berjudul **'Sistem Informasi Promosi dan Layanan Kids Park'**.
>
> Sebelumnya, izinkan kami memperkenalkan anggota kelompok kami:"

🎥 *Tampilkan setiap anggota (bisa split screen atau bergantian)*

🗣️

> - "**Moh Abi Syamsul** — NIM 2507037, sebagai Project Lead dan Backend Developer."
> - "**Alifah Nibras** — NIM 2507076, sebagai Frontend Developer dan UI/UX Designer."
> - "**Winesa** — NIM 2507112, sebagai bagian Dokumentasi dan Quality Assurance."

🗣️ **Presenter:**

> "Proyek ini kami kerjakan bekerja sama dengan mitra kami, yaitu **Kids Park**, sebuah tempat bermain dan rekreasi keluarga yang berlokasi di **Indramayu**."

---

## BAGIAN 2: PENJELASAN SISTEM
⏱️ **Durasi: ±2,5 menit**

---

### 2.1 Latar Belakang & Permasalahan

🎥 *Bisa tampilkan slide atau tetap face cam*

🗣️ **Presenter:**

> "Kids Park adalah tempat rekreasi keluarga yang menyediakan fasilitas kolam renang dan playground untuk anak-anak di Indramayu. Namun, saat ini Kids Park masih mengandalkan promosi secara konvensional, seperti mulut ke mulut dan media sosial sederhana.
>
> Dari hasil analisis kami, terdapat beberapa permasalahan utama:
>
> **Pertama**, informasi mengenai layanan, harga tiket, dan promosi belum terpusat dalam satu platform yang mudah diakses oleh pengunjung.
>
> **Kedua**, proses pembelian tiket masih dilakukan secara langsung di lokasi, sehingga menyebabkan antrean dan kurang efisien.
>
> **Ketiga**, pengelolaan data promosi, galeri, dan kontak masih dilakukan secara manual oleh pengelola."

### 2.2 Tujuan & Solusi

🗣️

> "Berdasarkan permasalahan tersebut, kami membangun sebuah **Sistem Informasi berbasis Web** yang bertujuan untuk:
>
> 1. Menyediakan **halaman publik** yang informatif dan menarik untuk mempromosikan layanan Kids Park.
> 2. Menyediakan fitur **pembelian tiket secara online** agar pengunjung tidak perlu antre.
> 3. Menyediakan **sistem keanggotaan (membership)** dengan fitur tier dan diskon untuk meningkatkan loyalitas pengunjung.
> 4. Menyediakan **panel admin** yang memudahkan pengelola dalam mengelola konten website, pesanan tiket, dan data member."

### 2.3 Teknologi yang Digunakan

🎥 *Tampilkan slide atau grafik sederhana berisi tech stack*

🗣️

> "Untuk membangun sistem ini, kami menggunakan teknologi sebagai berikut:
>
> - **Backend:** Framework **Laravel** dengan bahasa pemrograman PHP.
> - **Database:** MySQL / MariaDB untuk penyimpanan data.
> - **Frontend:** HTML5, CSS3, dan JavaScript vanilla, dengan Google Fonts dan Material Icons.
> - **Arsitektur:** Menggunakan pola **MVC** (Model-View-Controller) yang disediakan oleh Laravel.
> - **Server Lokal:** Laragon untuk pengembangan lokal.
>
> Sistem ini terdiri dari **10 model data**, **lebih dari 40 route**, dan **3 area utama**, yaitu halaman publik, area member, dan panel admin."

---

## BAGIAN 3: PENJELASAN FITUR
⏱️ **Durasi: ±2 menit**

---

🎥 *Bisa gunakan slide atau langsung transition ke screen recording*

🗣️ **Presenter:**

> "Sebelum masuk ke demo, izinkan kami menjelaskan fitur-fitur utama dari sistem kami secara singkat."

### 3.1 Fitur Halaman Publik

🗣️

> "**Halaman Publik** merupakan halaman utama yang dapat diakses oleh siapa saja. Halaman ini bersifat **single-page** dengan navigasi berbasis section, yang meliputi:
>
> - **Beranda** — Hero section dengan informasi selamat datang dan tombol beli tiket.
> - **Layanan** — Menampilkan fasilitas yang tersedia di Kids Park, lengkap dengan gambar dan deskripsi.
> - **Harga Tiket** — Daftar jenis tiket beserta harganya.
> - **Promosi** — Informasi promo dan event yang sedang berlangsung, lengkap dengan status aktif atau berakhir.
> - **Galeri** — Koleksi foto kegiatan dan fasilitas Kids Park.
> - **Kontak & Lokasi** — Informasi alamat, telepon, email, media sosial, jam operasional, serta embed Google Maps."

### 3.2 Fitur Pembelian Tiket Online

🗣️

> "Fitur unggulan kami adalah **Pembelian Tiket Online**. Pengunjung dapat:
>
> - Memilih jenis dan jumlah tiket melalui interface yang interaktif.
> - Mengisi data pengunjung dan tanggal kunjungan.
> - Melihat ringkasan pembelian secara real-time.
> - Melakukan pembayaran dengan upload bukti transfer.
> - Mendapatkan **kode booking** dan **QR Code** sebagai tiket digital.
> - Mengecek status tiket kapan saja melalui fitur **Cek Tiket**."

### 3.3 Fitur Membership

🗣️

> "Kami juga mengembangkan **Sistem Membership** dengan fitur:
>
> - Registrasi dan login member.
> - **Tier system**: Bronze, Silver, Gold, dan Platinum — berdasarkan jumlah kunjungan.
> - Diskon otomatis sesuai tier: mulai dari 0% hingga 15%.
> - Dashboard member dengan statistik kunjungan, riwayat transaksi, dan progress tier.
> - Fitur edit profil dan ubah password."

### 3.4 Fitur Panel Admin

🗣️

> "Untuk pengelolaan backend, kami menyediakan **Panel Admin** dengan fitur:
>
> - **Dashboard** dengan ringkasan statistik: jumlah layanan, tiket, promosi, galeri, pendapatan, pengunjung hari ini, dan pesanan yang perlu diverifikasi.
> - **CRUD Layanan** — Tambah, edit, hapus data layanan.
> - **CRUD Tiket** — Kelola jenis dan harga tiket.
> - **CRUD Promosi** — Kelola promosi dengan validasi tanggal.
> - **Manajemen Galeri** — Upload dan hapus foto galeri.
> - **Manajemen Kontak** — Update informasi kontak dan embed maps.
> - **Manajemen Pesanan** — Verifikasi pembayaran dan validasi tiket masuk menggunakan QR Code.
> - **Manajemen Member** — Lihat, edit, aktifkan/nonaktifkan akun member.
> - **Profil Admin** — Edit profil dan ubah password admin."

---

## BAGIAN 4: DEMO PROTOTYPE
⏱️ **Durasi: ±5 menit**

---

> **PENTING:** Bagian ini **wajib menggunakan screen recording**. Pastikan browser terbuka dengan tampilan yang bersih. Gunakan resolusi minimal 720p. Cursor harus terlihat jelas.

---

### 4.1 Demo Halaman Publik *(±1,5 menit)*

🖥️ *Buka browser → akses `http://localhost/kidspark/`*

🗣️ **Presenter (voice-over):**

> "Baik, sekarang kita masuk ke demo prototype. Yang pertama kita lihat adalah halaman utama website Kids Park."

🖥️ *Scroll perlahan dari atas ke bawah*

🗣️

> "Di bagian atas, kita memiliki **navbar** dengan navigasi ke setiap section. Terdapat juga tombol **Beli Tiket** dan **Login Member**.
>
> *(scroll ke hero section)*
> Ini adalah **Hero Section** yang menampilkan tagline utama Kids Park dengan desain yang menarik dan playful. Terdapat tombol untuk langsung membeli tiket online.
>
> *(scroll ke ticker jam operasional)*
> Di bawahnya ada **ticker jam operasional** yang berjalan secara otomatis, memberikan informasi jam buka kepada pengunjung.
>
> *(scroll ke section layanan)*
> Section **Layanan** menampilkan fasilitas yang tersedia di Kids Park. Setiap layanan ditampilkan dalam bentuk card dengan gambar, icon, dan deskripsi.
>
> *(scroll ke section tiket)*
> Selanjutnya, section **Harga Tiket** menampilkan berbagai jenis tiket beserta harganya, ditampilkan dengan latar belakang gelap agar lebih menonjol.
>
> *(scroll ke section promosi)*
> Section **Promosi** menampilkan promo-promo yang sedang berjalan. Setiap promo dilengkapi badge status: **Aktif** jika masih berlaku, atau **Berakhir** jika sudah lewat.
>
> *(scroll ke section galeri)*
> Pada section **Galeri**, kita bisa melihat foto-foto kegiatan dan fasilitas Kids Park dalam bentuk grid. Setiap foto memiliki overlay judul saat di-hover.
>
> *(scroll ke section kontak)*
> Terakhir, section **Kontak & Lokasi** menampilkan informasi lengkap termasuk alamat, telepon, email, media sosial, jam operasional, serta embed Google Maps untuk navigasi."

---

### 4.2 Demo Pembelian Tiket Online *(±1,5 menit)*

🖥️ *Klik tombol "Beli Tiket Online" atau navigasi ke halaman beli tiket*

🗣️

> "Sekarang kita akan demo fitur **Pembelian Tiket Online**.
>
> *(tampilkan halaman beli tiket)*
> Di halaman ini, pengunjung mengisi **informasi pengunjung** seperti nama, email, dan nomor WhatsApp. Kemudian memilih **tanggal kunjungan**.
>
> *(klik tombol + pada beberapa jenis tiket)*
> Di bawahnya, pengunjung memilih jenis dan jumlah tiket menggunakan tombol stepper plus-minus. Perhatikan di sebelah kanan, **ringkasan pembelian** ter-update secara real-time setiap kali kita menambah atau mengurangi tiket.
>
> *(klik "Lanjutkan Pembayaran")*
> Setelah klik 'Lanjutkan Pembayaran', sistem menghasilkan **kode booking** unik dan menampilkan halaman pembayaran.
>
> *(tampilkan halaman bayar)*
> Di halaman pembayaran, pengunjung melihat detail pesanan, informasi rekening tujuan, dan form untuk **upload bukti transfer**. Setelah upload, status berubah menjadi **Menunggu Konfirmasi**.
>
> *(tampilkan halaman status tiket)*
> Pengunjung juga dapat mengecek status tiket kapan saja menggunakan fitur **Cek Tiket** dengan memasukkan kode booking. Halaman status menampilkan detail lengkap termasuk **QR Code** yang bisa digunakan sebagai tiket masuk."

---

### 4.3 Demo Area Member *(±0,5 menit)*

🖥️ *Navigasi ke halaman login member*

🗣️

> "Selanjutnya, kita lihat fitur **Membership**. Pengunjung bisa registrasi sebagai member melalui halaman Register.
>
> *(login sebagai member)*
> Setelah login, member masuk ke **Dashboard Member** yang menampilkan informasi lengkap: nama, nomor member, dan **tier** saat ini beserta progress menuju tier berikutnya.
>
> *(tunjukkan stats & tier guide)*
> Terdapat statistik: total kunjungan, transaksi lunas, total belanja, dan diskon aktif. Di bagian bawah ada **Panduan Tier Member** yang menjelaskan syarat dan benefit dari setiap tier — Bronze, Silver, Gold, dan Platinum.
>
> Saat member membeli tiket, diskon otomatis diterapkan sesuai tier mereka."

---

### 4.4 Demo Panel Admin *(±1,5 menit)*

🖥️ *Buka tab baru → akses `http://localhost/kidspark/admin/login`*

🗣️

> "Sekarang kita masuk ke **Panel Admin**. Login menggunakan akun admin yang sudah terdaftar.
>
> *(login dan masuk ke dashboard)*
> Ini adalah **Dashboard Admin**. Di sini terlihat ringkasan statistik: jumlah layanan, jenis tiket, promosi, foto galeri, total pendapatan tiket, pengunjung hari ini, dan jumlah pesanan yang perlu diverifikasi.
>
> Di bawahnya terdapat tabel **Promosi Terbaru** untuk monitoring cepat."

🖥️ *Klik menu "Layanan" di sidebar*

🗣️

> "Di halaman **Kelola Layanan**, admin bisa menambah, mengedit, dan menghapus data layanan. Kita coba tambah layanan baru..."
>
> *(isi form dan submit — tunjukkan bahwa data berhasil ditambahkan)*

🖥️ *Klik menu "Pesanan Tiket" di sidebar*

🗣️

> "Pada halaman **Pesanan Tiket**, admin bisa melihat semua pesanan masuk, memfilter berdasarkan status, dan melakukan **konfirmasi pembayaran** atau **pembatalan**.
>
> *(klik salah satu pesanan → tunjukkan detail pesanan)*
> Admin bisa melihat detail pesanan lengkap termasuk bukti transfer yang diupload oleh pengunjung."

🖥️ *Klik menu "Validasi Tiket" di sidebar*

🗣️

> "Fitur **Validasi Tiket** memungkinkan admin untuk memvalidasi tiket pengunjung saat datang. Admin bisa **scan QR Code** pada tiket atau memasukkan kode booking secara manual."

🖥️ *Klik menu "Data Member" di sidebar*

🗣️

> "Terakhir, di halaman **Data Member**, admin bisa melihat daftar seluruh member terdaftar, melihat detail, mengedit informasi, serta mengaktifkan atau menonaktifkan akun member."

---

## BAGIAN 5: PENUTUP
⏱️ **Durasi: ±1 menit**

---

🎥 *Kembali ke face cam — tampilkan wajah presenter (wajib)*

🗣️ **Presenter (Abi):**

> "Baik, demikian presentasi dan demo prototype dari proyek **Sistem Informasi Promosi dan Layanan Kids Park** yang telah kami kembangkan.
>
> Sebagai kesimpulan, sistem ini menyediakan solusi terpadu bagi Kids Park untuk:
> - **Mempromosikan** layanan dan fasilitas secara digital melalui website yang informatif.
> - **Memudahkan pengunjung** membeli tiket secara online tanpa harus antre.
> - **Meningkatkan loyalitas** pengunjung melalui sistem membership dengan tier dan diskon.
> - **Membantu pengelola** dalam mengelola konten, pesanan, dan data member melalui panel admin yang intuitif.
>
> Untuk pengembangan ke depan, sistem ini masih bisa dikembangkan lebih lanjut, di antaranya integrasi **payment gateway**, fitur **pencarian dan filter**, sistem **multi-admin**, serta **notifikasi otomatis** via email atau WhatsApp.
>
> Kami menyadari bahwa sistem ini masih jauh dari sempurna, oleh karena itu kami sangat mengharapkan kritik dan saran yang membangun dari Bapak/Ibu dosen dan teman-teman sekalian.
>
> Atas perhatiannya, kami ucapkan **terima kasih**.
> Wassalamu'alaikum Warahmatullahi Wabarakatuh."

---

## RINGKASAN DURASI

| Bagian | Konten | Durasi |
|--------|--------|--------|
| 1 | Pembukaan & Perkenalan Kelompok | ±1,5 menit |
| 2 | Penjelasan Sistem (Latar Belakang, Tujuan, Teknologi) | ±2,5 menit |
| 3 | Penjelasan Fitur-Fitur | ±2 menit |
| 4 | Demo Prototype | ±5 menit |
| 5 | Penutup & Kesimpulan | ±1 menit |
| | **TOTAL** | **±12 menit** |

---

## TIPS PRODUKSI VIDEO

### Persiapan
- [ ] Pastikan **Laragon** dan database sudah berjalan
- [ ] Isi database dengan **data sampel** yang menarik (layanan, tiket, promosi, galeri, member)
- [ ] Buat akun member demo yang sudah memiliki tier (misalnya Gold) untuk demo diskon
- [ ] Siapkan **bukti transfer dummy** untuk demo upload pembayaran
- [ ] Test semua alur demo sebelum recording

### Recording
- [ ] Gunakan software recording seperti **OBS Studio**, **Bandicam**, atau **Camtasia**
- [ ] Resolusi minimal **1280x720** (720p), disarankan **1920x1080** (1080p)
- [ ] Gunakan **microphone eksternal** jika ada, untuk kualitas audio yang lebih baik
- [ ] Pastikan **cursor terlihat jelas** saat screen recording
- [ ] Bicara dengan **tempo yang jelas dan tidak terlalu cepat**

### Editing
- [ ] Tambahkan **title card** di awal video (nama proyek, kelompok, institusi)
- [ ] Tambahkan **lower third** saat perkenalan anggota
- [ ] Tambahkan **transisi** antar bagian agar tidak monoton
- [ ] Tambahkan **background music** yang lembut (royalty-free)
- [ ] Export dalam format **MP4** dengan codec H.264

### Upload YouTube
- [ ] Upload ke **YouTube** (bisa unlisted/public)
- [ ] Buat judul yang informatif, contoh:
  `Presentasi Proyek — Sistem Informasi Kids Park | Kelompok 9 SIKC POLINDRA`
- [ ] Isi deskripsi dengan nama anggota, mata kuliah, dan dosen pengampu
- [ ] Tambahkan timestamp di deskripsi YouTube:
  ```
  00:00 - Pembukaan & Perkenalan
  01:30 - Penjelasan Sistem
  04:00 - Penjelasan Fitur
  06:00 - Demo Prototype
  11:00 - Penutup
  ```
