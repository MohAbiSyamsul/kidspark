<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Kids Park - Tempat Bermain & Rekreasi Keluarga</title>
  <meta name="description" content="Kids Park menyediakan fasilitas kolam renang dan playground yang aman dan menyenangkan untuk keluarga.">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700;800;900&family=Fredoka+One&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
  <link rel="icon" type="image/png" href="{{ asset('assets/images/logo/kidspark-logo.png') }}">
</head>
<body>

<!-- NAVBAR -->
<nav class="navbar">
  <a href="{{ route('home') }}" class="navbar-brand">
    🎡 Kids<span>Park</span>
  </a>
  <ul class="navbar-nav">
    <li><a href="#beranda" class="active">Beranda</a></li>
    <li><a href="#layanan">Layanan</a></li>
    <li><a href="#tiket">Harga Tiket</a></li>
    <li><a href="#promosi">Promosi</a></li>
    <li><a href="#galeri">Galeri</a></li>
    <li><a href="#kontak">Kontak</a></li>
    <li><a href="{{ route('tiket.cari') }}">Cek Tiket</a></li>
    <li><a href="{{ route('tiket.beli') }}" class="btn-beli-tiket" style="background: linear-gradient(135deg, var(--primary), #ff8255); color: white !important; border-radius: 30px; padding: 8px 20px !important; box-shadow: 0 4px 12px rgba(255,107,53,0.3); font-weight: 700; margin-left: 5px;">🎟️ Beli Tiket</a></li>
    @auth('member')
      @php
        $tierIcons = ['Bronze'=>'🥉','Silver'=>'🥈','Gold'=>'🥇','Platinum'=>'💎'];
        $mObj = Auth::guard('member')->user();
      @endphp
      <li><a href="{{ route('member.dashboard') }}" class="btn btn-secondary admin-login" style="background:linear-gradient(135deg,#4ECDC4,#3db9b0); color:#fff; border-radius:30px; font-weight:700;">{{ $tierIcons[$mObj->tier] ?? '👤' }} {{ $mObj->nama_lengkap }}</a></li>
    @else
      <li><a href="{{ route('member.login') }}" class="btn btn-secondary admin-login">👤 Login Member</a></li>
    @endauth
  </ul>
  <div class="hamburger">
    <span></span>
    <span></span>
    <span></span>
  </div>
</nav>

<!-- HERO -->
<section id="beranda" class="hero">
  <div class="hero-shapes">
    <div class="shape"></div>
    <div class="shape"></div>
    <div class="shape"></div>
  </div>
  <div class="hero-content">
    <div class="hero-badge">🎉 Selamat Datang di Kids Park</div>
    <h1>
      Tempat Bermain<br>
      <span class="highlight">Seru & Aman</span><br>
      untuk <span class="highlight-2">Keluargamu</span>
    </h1>
    <p>Nikmati fasilitas kolam renang dan playground terbaik. Pengalaman bermain yang menyenangkan dan tak terlupakan untuk anak-anak.</p>
    <div class="hero-btns">
      <a href="{{ route('tiket.beli') }}" class="btn btn-primary">
        <span class="material-icons" style="font-size:1.1rem">confirmation_number</span>
        Beli Tiket Online
      </a>
      <a href="#layanan" class="btn btn-outline">
        <span class="material-icons" style="font-size:1.1rem">explore</span>
        Fasilitas Park
      </a>
    </div>
  </div>
</section>

<!-- JAM OPERASIONAL TICKER -->
@if($kontak && $kontak->jam_operasional)
<div class="jam-ops-ticker">
  <div class="ticker-label">
    <span class="material-icons">schedule</span>
    <strong>Jam Operasional</strong>
  </div>
  <div class="ticker-wrapper">
    <div class="ticker-track">
      @for($i = 0; $i < 5; $i++)
      <span class="ticker-item">
        🕐 {{ $kontak->jam_operasional }}
        &nbsp;&nbsp;&nbsp;⭐&nbsp;&nbsp;&nbsp;
      </span>
      @endfor
    </div>
  </div>
</div>
@endif

<style>
.jam-ops-ticker {
  display: flex;
  align-items: center;
  background: linear-gradient(90deg, var(--secondary, #4ECDC4), #3dbdb5);
  color: #fff;
  overflow: hidden;
  height: 48px;
  box-shadow: 0 2px 12px rgba(78,205,196,0.25);
}

.ticker-label {
  display: flex;
  align-items: center;
  gap: 6px;
  padding: 0 18px;
  background: rgba(0,0,0,0.18);
  height: 100%;
  white-space: nowrap;
  font-size: 0.92rem;
  flex-shrink: 0;
  border-right: 2px solid rgba(255,255,255,0.2);
}

.ticker-label .material-icons {
  font-size: 1.15rem;
}

.ticker-wrapper {
  flex: 1;
  overflow: hidden;
  position: relative;
  height: 100%;
  display: flex;
  align-items: center;
}

.ticker-track {
  display: flex;
  align-items: center;
  white-space: nowrap;
  animation: ticker-scroll 28s linear infinite;
  will-change: transform;
}

.ticker-item {
  font-size: 0.9rem;
  font-weight: 600;
  padding: 0 8px;
  letter-spacing: 0.02em;
}

@keyframes ticker-scroll {
  0%   { transform: translateX(0); }
  100% { transform: translateX(-50%); }
}

.ticker-wrapper:hover .ticker-track {
  animation-play-state: paused;
}
</style>

<!-- LAYANAN -->
<section id="layanan">
  <div class="section-header fade-in">
    <div class="section-tag">Fasilitas Kami</div>
    <h2>Layanan Kids Park</h2>
    <p>Berbagai fasilitas lengkap untuk memberikan pengalaman bermain terbaik bagi si kecil</p>
  </div>
  <div class="grid-3">
    @php $icons_default = ['🏊','🎪','🌿','🎨','⚽','🎢']; @endphp
    @forelse($layanan as $i => $row)
    @php $icon = $icon_map[$row->icon] ?? $icons_default[$i % count($icons_default)]; @endphp
    <div class="card layanan-card fade-in" style="padding: 0; text-align: left; display: flex; flex-direction: column; height: 100%;">
      @if($row->gambar)
        <div style="width: 100%; height: 200px; overflow: hidden; position: relative;">
          <img src="{{ asset('storage/uploads/' . $row->gambar) }}" alt="{{ $row->nama_layanan }}" style="width: 100%; height: 100%; object-fit: cover; display: block; border-bottom: 2px solid var(--border);">
          <div style="position: absolute; bottom: 12px; left: 12px; background: linear-gradient(135deg, var(--primary), #ff8c5a); width: 44px; height: 44px; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 1.4rem; box-shadow: 0 4px 12px rgba(0,0,0,0.15); color: #fff;">
            {{ $icon }}
          </div>
        </div>
      @else
        <div style="padding: 36px 28px 10px 28px; text-align: center;">
          <div class="layanan-icon" style="font-size: 2rem">{{ $icon }}</div>
        </div>
      @endif
      <div style="padding: 24px 28px 36px 28px; flex: 1; display: flex; flex-direction: column; justify-content: space-between;">
        <div>
          <h3 style="font-family: 'Fredoka One', cursive; font-size: 1.3rem; color: var(--dark); margin-bottom: 10px; text-align: {{ $row->gambar ? 'left' : 'center' }}">{{ $row->nama_layanan }}</h3>
          <p style="color: var(--text-light); font-size: 0.95rem; line-height: 1.5; text-align: {{ $row->gambar ? 'left' : 'center' }}">{{ $row->deskripsi }}</p>
        </div>
      </div>
    </div>
    @empty
    <div class="empty-state">
      <span class="material-icons">info</span>
      <p>Informasi layanan belum tersedia.</p>
    </div>
    @endforelse
  </div>
</section>

<!-- TIKET -->
<section id="tiket">
  <div class="section-header fade-in">
    <div class="section-tag" style="background: var(--secondary)">Harga Tiket</div>
    <h2>Harga Tiket Masuk</h2>
    <p>Harga terjangkau untuk pengalaman bermain yang tak terlupakan</p>
  </div>
  <div class="grid-4">
    @forelse($tiket as $row)
    <div class="tiket-card fade-in">
      <div class="tiket-jenis">{{ $row->jenis_tiket }}</div>
      <div class="tiket-harga">{{ formatRupiah($row->harga) }}</div>
      @if($row->deskripsi)
      <div class="tiket-desc">{{ $row->deskripsi }}</div>
      @endif
    </div>
    @empty
    <div class="empty-state">
      <span class="material-icons" style="color: rgba(255,255,255,0.3)">confirmation_number</span>
      <p style="color: rgba(255,255,255,0.4)">Informasi tiket belum tersedia.</p>
    </div>
    @endforelse
  </div>
</section>

<!-- PROMOSI -->
<section id="promosi">
  <div class="section-header fade-in">
    <div class="section-tag" style="background: var(--purple)">Promo & Event</div>
    <h2>Promosi Spesial</h2>
    <p>Jangan lewatkan penawaran menarik dari Kids Park</p>
  </div>
  <div class="grid-3">
    @forelse($promosi as $row)
    <div class="card promo-card fade-in">
      <div class="promo-header">
        <div class="promo-badge {{ $row->isAktif() ? '' : 'expired' }}">
          {{ $row->isAktif() ? '🔥 Aktif' : 'Berakhir' }}
        </div>
        <h3>{{ $row->judul_promosi }}</h3>
      </div>
      <div class="promo-body">
        <p>{!! nl2br(e($row->deskripsi)) !!}</p>
        <div class="promo-dates">
          <span class="material-icons">calendar_today</span>
          {{ $row->tanggal_mulai->format('d M Y') }} – {{ $row->tanggal_selesai->format('d M Y') }}
        </div>
      </div>
    </div>
    @empty
    <div class="empty-state">
      <span class="material-icons">local_offer</span>
      <p>Belum ada promosi saat ini.</p>
    </div>
    @endforelse
  </div>
</section>

<!-- GALERI -->
<section id="galeri">
  <div class="section-header fade-in">
    <div class="section-tag" style="background: var(--blue)">Galeri Foto</div>
    <h2>Galeri Kids Park</h2>
    <p>Lihat keseruan dan fasilitas kami melalui galeri foto berikut</p>
  </div>
  <div class="galeri-grid">
    @forelse($galeri as $row)
    <div class="galeri-item fade-in">
      <img src="{{ asset('storage/uploads/' . $row->gambar) }}"
           alt="{{ $row->judul_foto }}" loading="lazy">
      <div class="galeri-overlay">
        <span>{{ $row->judul_foto }}</span>
      </div>
    </div>
    @empty
    <div class="empty-state">
      <span class="material-icons">photo_library</span>
      <p>Belum ada foto di galeri.</p>
    </div>
    @endforelse
  </div>
</section>

<!-- KONTAK -->
<section id="kontak">
  <div class="section-header fade-in">
    <div class="section-tag" style="background: var(--green); color: var(--dark)">Hubungi Kami</div>
    <h2>Kontak & Lokasi</h2>
    <p>Temukan kami atau hubungi langsung untuk informasi lebih lanjut</p>
  </div>
  @if($kontak)
  <div class="kontak-grid fade-in">
    <div class="kontak-info">
      @if($kontak->alamat)
      <div class="kontak-item">
        <div class="kontak-icon"><span class="material-icons">location_on</span></div>
        <div>
          <h4>Alamat</h4>
          <p>{!! nl2br(e($kontak->alamat)) !!}</p>
        </div>
      </div>
      @endif
      @if($kontak->nomor_telepon)
      <div class="kontak-item">
        <div class="kontak-icon" style="background: linear-gradient(135deg, var(--secondary), #3dbdb5)">
          <span class="material-icons">phone</span>
        </div>
        <div>
          <h4>Telepon / WhatsApp</h4>
          <p><a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $kontak->nomor_telepon) }}"
               style="color: var(--primary); font-weight: 700; text-decoration: none;" target="_blank">
            {{ $kontak->nomor_telepon }}
          </a></p>
        </div>
      </div>
      @endif
      @if($kontak->email)
      <div class="kontak-item">
        <div class="kontak-icon" style="background: linear-gradient(135deg, var(--purple), #c77dff)">
          <span class="material-icons">email</span>
        </div>
        <div>
          <h4>Email</h4>
          <p>{{ $kontak->email }}</p>
        </div>
      </div>
      @endif
      @if($kontak->instagram || $kontak->tiktok)
      <div class="kontak-item">
        <div class="kontak-icon" style="background: linear-gradient(135deg, #f09433, #e6683c)">
          <span class="material-icons">public</span>
        </div>
        <div>
          <h4>Social Media</h4>
          <p>
            @if($kontak->instagram)
            <a href="{{ $kontak->instagram }}" target="_blank" rel="noopener noreferrer"
               style="color: var(--primary); font-weight: 700; text-decoration: none;">Instagram</a>
            @endif
            @if($kontak->instagram && $kontak->tiktok) • @endif
            @if($kontak->tiktok)
            <a href="{{ $kontak->tiktok }}" target="_blank" rel="noopener noreferrer"
               style="color: var(--primary); font-weight: 700; text-decoration: none;">TikTok</a>
            @endif
          </p>
        </div>
      </div>
      @endif
      @if($kontak->jam_operasional)
      <div class="kontak-item">
        <div class="kontak-icon" style="background: linear-gradient(135deg, var(--blue), #74c7e0)">
          <span class="material-icons">schedule</span>
        </div>
        <div>
          <h4>Jam Operasional</h4>
          <p>{!! nl2br(e($kontak->jam_operasional)) !!}</p>
        </div>
      </div>
      @endif
    </div>
    <div class="kontak-map">
      @if($kontak->maps && str_contains($kontak->maps, 'iframe'))
        {!! $kontak->maps !!}
      @else
        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d63464!2d108.3!3d-6.3!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zNsKwMTgnMDAuMCJTIDEwOMKwMTgnMDAuMCJF!5e0!3m2!1sid!2sid!4v1"
                width="100%" height="350" style="border:0;" allowfullscreen="" loading="lazy"
                referrerpolicy="no-referrer-when-downgrade"></iframe>
      @endif
    </div>
  </div>
  @endif
</section>

<!-- FOOTER -->
<footer>
  <div class="brand">🎡 KidsPark</div>
  <p>Tempat bermain dan rekreasi keluarga yang menyenangkan</p>
  <p style="margin-top: 8px; font-size: 0.8rem; opacity: 0.5;">
    &copy; {{ date('Y') }} Kids Park. Dibuat oleh Kelompok 9 - POLINDRA.
  </p>
  <p style="margin-top: 12px; text-align: center; font-size: 0.8rem;">
    <a href="{{ route('admin.login') }}" style="color: rgba(255,255,255,0.6); text-decoration: none; border-bottom: 1px solid rgba(255,255,255,0.3); padding-bottom: 2px;">
      🔐 Staff Login
    </a>
  </p>
</footer>

<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
<script src="{{ asset('assets/js/main.js') }}"></script>
</body>
</html>
