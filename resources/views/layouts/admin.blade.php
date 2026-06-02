<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>@yield('title', 'Admin') - Kids Park</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700;800;900&family=Fredoka+One&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('assets/css/admin.css') }}">
  <link rel="icon" type="image/png" href="{{ asset('assets/images/logo/kidspark-logo.png') }}">
  @stack('styles')
</head>
<body>
<div class="admin-wrapper">
  <!-- SIDEBAR OVERLAY (mobile) -->
  <div class="sidebar-overlay" id="sidebarOverlay"></div>
  
  <!-- SIDEBAR -->
  <aside class="sidebar" id="sidebar">
    <a href="{{ route('admin.dashboard') }}" class="sidebar-brand">
      🎡 Kids<span>Park</span>
    </a>
    <nav class="sidebar-menu">
      <div class="menu-label">Main</div>
      <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
        <span class="material-icons">dashboard</span> Dashboard
      </a>

      <div class="menu-label">Konten</div>
      <a href="{{ route('admin.layanan.index') }}" class="{{ request()->routeIs('admin.layanan*') ? 'active' : '' }}">
        <span class="material-icons">water</span> Layanan
      </a>
      <a href="{{ route('admin.tiket.index') }}" class="{{ request()->routeIs('admin.tiket*') ? 'active' : '' }}">
        <span class="material-icons">confirmation_number</span> Harga Tiket
      </a>
      <a href="{{ route('admin.promosi.index') }}" class="{{ request()->routeIs('admin.promosi*') ? 'active' : '' }}">
        <span class="material-icons">local_offer</span> Promosi
      </a>
      <a href="{{ route('admin.galeri.index') }}" class="{{ request()->routeIs('admin.galeri*') ? 'active' : '' }}">
        <span class="material-icons">photo_library</span> Galeri
      </a>
      <a href="{{ route('admin.kontak.index') }}" class="{{ request()->routeIs('admin.kontak*') ? 'active' : '' }}">
        <span class="material-icons">contact_phone</span> Kontak
      </a>

      <div class="menu-label">Transaksi</div>
      <a href="{{ route('admin.pesanan.index') }}" class="{{ request()->routeIs('admin.pesanan.index') || request()->routeIs('admin.pesanan.show') ? 'active' : '' }}">
        <span class="material-icons">receipt_long</span> Pesanan Tiket
        @php
          $pendingCount = 0;
          if (\Illuminate\Support\Facades\Schema::hasTable('pesanan_tiket')) {
              $pendingCount = \App\Models\PesananTiket::where('status_pembayaran', 'menunggu_konfirmasi')->count();
          }
        @endphp
        @if($pendingCount > 0)
          <span style="background-color: #ff6b6b; color: white; border-radius: 50%; font-size: 0.72rem; padding: 2px 6px; margin-left: auto; font-weight: 800; display: inline-block; line-height: 1.2;">
            {{ $pendingCount }}
          </span>
        @endif
      </a>
      <a href="{{ route('admin.pesanan.validasi') }}" class="{{ request()->routeIs('admin.pesanan.validasi') ? 'active' : '' }}">
        <span class="material-icons">qr_code_scanner</span> Validasi Tiket
      </a>
      <a href="{{ route('admin.member.index') }}" class="{{ request()->routeIs('admin.member*') ? 'active' : '' }}">
        <span class="material-icons">groups</span> Kelola Member
        @php $totalMember = \App\Models\Member::count(); @endphp
        @if($totalMember > 0)
          <span style="background:#4ECDC4; color:#fff; border-radius:10px; font-size:0.72rem; padding:2px 6px; margin-left:auto; font-weight:800; display:inline-block; line-height:1.2">{{ $totalMember }}</span>
        @endif
      </a>

      <div class="menu-label">Akun</div>
      <a href="{{ route('admin.profil.index') }}" class="{{ request()->routeIs('admin.profil*') ? 'active' : '' }}">
        <span class="material-icons">person</span> Profil
      </a>
    </nav>
    <div class="sidebar-footer">
      <a href="{{ route('home') }}" target="_blank">
        <span class="material-icons">open_in_new</span> Lihat Website
      </a>
      <form method="POST" action="{{ route('admin.logout') }}" style="display:inline">
        @csrf
        <button type="submit" style="background:none;border:none;cursor:pointer;display:flex;align-items:center;gap:8px;color:inherit;font-size:inherit;padding:0;width:100%">
          <span class="material-icons">logout</span> Keluar
        </button>
      </form>
    </div>
  </aside>

  <!-- MAIN -->
  <main class="admin-main">
    <!-- TOPBAR -->
    <div class="topbar">
      <button class="topbar-toggle" id="sidebarToggle" aria-label="Toggle Sidebar">
        <span class="material-icons">menu</span>
      </button>
      <div class="topbar-title">
        <h2>@yield('page_title', 'Dashboard')</h2>
        <p>@yield('page_subtitle', 'Kids Park Admin Panel')</p>
      </div>
      <div class="topbar-user">
        <div class="avatar">{{ strtoupper(substr(Auth::user()->username, 0, 2)) }}</div>
        <div class="topbar-user-info">
          <span>{{ Auth::user()->username }}</span>
        </div>
      </div>
    </div>
    <!-- PAGE CONTENT -->
    <div class="page-content">
      @if(session('success'))
        <div class="alert alert-success">
          <span class="material-icons" style="font-size:1.1rem">check_circle</span>
          {{ session('success') }}
        </div>
      @endif
      @if(session('error'))
        <div class="alert alert-error">
          <span class="material-icons" style="font-size:1.1rem">error</span>
          {{ session('error') }}
        </div>
      @endif
      @if($errors->any())
        <div class="alert alert-error">
          <span class="material-icons" style="font-size:1.1rem">error</span>
          {{ $errors->first() }}
        </div>
      @endif

      @yield('content')
    </div>
  </main>
</div>

<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
<script src="{{ asset('assets/js/admin.js') }}"></script>
@stack('scripts')
</body>
</html>
