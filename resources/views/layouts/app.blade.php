<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>@yield('title', 'Kids Park - Beli Tiket Online')</title>
  <meta name="description" content="Beli tiket masuk Kids Park secara online dengan pembayaran mudah menggunakan QRIS.">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700;800;900&family=Fredoka+One&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
  <link rel="icon" type="image/png" href="{{ asset('assets/images/logo/kidspark-logo.png') }}">
  <style>
    :root {
      --primary: #FF6B35;
      --secondary: #4ECDC4;
      --accent: #FFE66D;
      --dark: #1a1a2e;
      --text: #2d3748;
      --radius: 16px;
      --purple: #7209b7;
      --blue: #4361ee;
      --green: #4ece3d;
      --light-bg: #f8f9fa;
    }

    body {
      background-color: var(--light-bg);
      color: var(--text);
      display: flex;
      flex-direction: column;
      min-height: 100vh;
    }

    .main-content {
      flex: 1;
      padding-top: 100px;
      padding-bottom: 60px;
    }

    .ticket-container {
      max-width: 1000px;
      margin: 0 auto;
      padding: 0 20px;
    }

    /* Form Styles */
    .form-group {
      margin-bottom: 20px;
    }

    .form-group label {
      display: block;
      margin-bottom: 8px;
      font-weight: 700;
      color: var(--dark);
      font-size: 0.95rem;
    }

    .form-control {
      width: 100%;
      padding: 12px 16px;
      border: 2px solid #e2e8f0;
      border-radius: 12px;
      font-family: inherit;
      font-size: 1rem;
      color: var(--text);
      transition: all 0.3s ease;
      background-color: #fff;
    }

    .form-control:focus {
      outline: none;
      border-color: var(--primary);
      box-shadow: 0 0 0 3px rgba(255, 107, 53, 0.15);
    }

    .btn {
      display: inline-flex;
      align-items: center;
      justify-content: center;
      gap: 8px;
      padding: 12px 24px;
      border-radius: 12px;
      font-weight: 700;
      cursor: pointer;
      transition: all 0.3s ease;
      font-family: inherit;
      border: none;
    }

    .btn-block {
      display: flex;
      width: 100%;
    }

    .card {
      background-color: #fff;
      border-radius: var(--radius);
      box-shadow: 0 10px 30px rgba(0,0,0,0.04);
      padding: 30px;
      border: 1px solid rgba(0,0,0,0.02);
      margin-bottom: 30px;
    }

    .card-title {
      font-family: 'Fredoka One', cursive;
      font-size: 1.5rem;
      color: var(--dark);
      margin-bottom: 20px;
      display: flex;
      align-items: center;
      gap: 10px;
    }

    /* Alert styles */
    .alert {
      display: flex;
      align-items: center;
      gap: 12px;
      padding: 16px;
      border-radius: 12px;
      margin-bottom: 25px;
      font-weight: 600;
    }

    .alert-success {
      background-color: #e6fcf5;
      color: #0ca678;
      border: 1px solid #c3fae8;
    }

    .alert-error {
      background-color: #fff5f5;
      color: #fa5252;
      border: 1px solid #ffe3e3;
    }

    /* Additional navbar style helper */
    .navbar {
      background: #fff;
      box-shadow: 0 4px 20px rgba(0,0,0,0.05);
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      z-index: 1000;
    }
    
    .navbar-nav li a.active-link {
      color: var(--primary) !important;
      font-weight: 800;
    }

    .navbar-nav .btn-beli-tiket {
      background: linear-gradient(135deg, var(--primary), #ff8255);
      color: white !important;
      border-radius: 30px;
      padding: 8px 20px !important;
      box-shadow: 0 4px 12px rgba(255,107,53,0.3);
    }

    .navbar-nav .btn-beli-tiket:hover {
      transform: translateY(-2px);
      box-shadow: 0 6px 16px rgba(255,107,53,0.4);
    }
  </style>
  @stack('styles')
</head>
<body>

<!-- NAVBAR -->
<nav class="navbar">
  <a href="{{ route('home') }}" class="navbar-brand">
    🎡 Kids<span>Park</span>
  </a>
  <ul class="navbar-nav">
    <li><a href="{{ route('home') }}#beranda">Beranda</a></li>
    <li><a href="{{ route('home') }}#layanan">Layanan</a></li>
    <li><a href="{{ route('home') }}#tiket">Harga Tiket</a></li>
    <li><a href="{{ route('home') }}#promosi">Promosi</a></li>
    <li><a href="{{ route('home') }}#galeri">Galeri</a></li>
    <li><a href="{{ route('home') }}#kontak">Kontak</a></li>
    <li><a href="{{ route('tiket.cari') }}" class="{{ request()->routeIs('tiket.cari') ? 'active-link' : '' }}">Cek Tiket</a></li>
    <li><a href="{{ route('tiket.beli') }}" class="btn-beli-tiket">🎟️ Beli Tiket</a></li>
    @auth('member')
      <li>
        <a href="{{ route('member.dashboard') }}" class="btn btn-secondary" style="padding: 6px 14px !important; background: linear-gradient(135deg, #4ECDC4, #3db9b0); color:#fff; border-radius:30px; font-weight:700; box-shadow:0 4px 12px rgba(78,205,196,0.3)">
          @php
            $tierIcons = ['Bronze'=>'🥉','Silver'=>'🥈','Gold'=>'🥇','Platinum'=>'💎'];
            $mObj = Auth::guard('member')->user();
          @endphp
          {{ $tierIcons[$mObj->tier] ?? '👤' }} {{ $mObj->nama_lengkap }}
        </a>
      </li>
    @else
      <li><a href="{{ route('member.login') }}" class="btn btn-secondary" style="padding: 6px 14px !important">👤 Login Member</a></li>
    @endauth
  </ul>
  <div class="hamburger">
    <span></span>
    <span></span>
    <span></span>
  </div>
</nav>

<div class="main-content">
  <div class="ticket-container">
    @if(session('success'))
      <div class="alert alert-success">
        <span class="material-icons">check_circle</span>
        <div>{{ session('success') }}</div>
      </div>
    @endif

    @if(session('error'))
      <div class="alert alert-error">
        <span class="material-icons">error</span>
        <div>{{ session('error') }}</div>
      </div>
    @endif

    @if(session('info'))
      <div class="alert" style="background:#e7f5ff; color:#1971c2; border:1px solid #bee3f8">
        <span class="material-icons">info</span>
        <div>{{ session('info') }}</div>
      </div>
    @endif

    @yield('content')
  </div>
</div>

<!-- FOOTER -->
<footer style="margin-top: auto">
  <div class="brand">🎡 KidsPark</div>
  <p>Tempat bermain dan rekreasi keluarga yang menyenangkan</p>
  <p style="margin-top: 8px; font-size: 0.8rem; opacity: 0.5;">
    &copy; {{ date('Y') }} Kids Park. Dibuat oleh Kelompok 9 (Moh Abi Syamsul, Winesa, Alifa) - POLINDRA.
  </p>
  <p style="margin-top: 12px; text-align: center; font-size: 0.8rem;">
    <a href="{{ route('admin.login') }}" style="color: rgba(255,255,255,0.6); text-decoration: none; border-bottom: 1px solid rgba(255,255,255,0.3); padding-bottom: 2px;">
      🔐 Staff Login
    </a>
  </p>
</footer>

<script>
  // Simple Mobile Navbar Toggle
  const hamburger = document.querySelector('.hamburger');
  const navMenu = document.querySelector('.navbar-nav');
  if (hamburger) {
    hamburger.addEventListener('click', () => {
      hamburger.classList.toggle('active');
      navMenu.classList.toggle('active');
    });
  }
</script>
@stack('scripts')
</body>
</html>
