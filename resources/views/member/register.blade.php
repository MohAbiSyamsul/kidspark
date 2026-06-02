@extends('layouts.app')

@section('title', 'Daftar Member - Kids Park')

@push('styles')
<style>
  .auth-wrap {
    min-height: calc(100vh - 160px);
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 40px 20px;
  }
  .auth-card {
    background: #fff;
    border-radius: 24px;
    box-shadow: 0 20px 60px rgba(0,0,0,0.08);
    padding: 48px 44px;
    width: 100%;
    max-width: 500px;
    position: relative;
    overflow: hidden;
  }
  .auth-card::before {
    content: '';
    position: absolute;
    top: 0; left: 0; right: 0;
    height: 5px;
    background: linear-gradient(90deg, var(--secondary), var(--primary), var(--accent));
  }
  .auth-logo {
    text-align: center;
    margin-bottom: 28px;
  }
  .auth-logo .emoji { font-size: 3.5rem; display: block; margin-bottom: 8px; }
  .auth-logo h1 {
    font-family: 'Fredoka One', cursive;
    font-size: 1.8rem; color: var(--dark); margin: 0 0 4px;
  }
  .auth-logo p { color: #8a94a6; font-size: 0.9rem; margin: 0; }
  .btn-auth {
    width: 100%;
    background: linear-gradient(135deg, var(--secondary), var(--primary));
    color: #fff;
    padding: 14px; border-radius: 12px;
    font-size: 1.05rem; font-weight: 700;
    border: none; cursor: pointer; transition: all 0.3s; margin-top: 8px;
  }
  .btn-auth:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 24px rgba(78,205,196,0.35);
  }
  .auth-footer { text-align: center; margin-top: 20px; color: #8a94a6; font-size: 0.92rem; }
  .auth-footer a { color: var(--primary); font-weight: 700; text-decoration: none; }
  .auth-footer a:hover { text-decoration: underline; }
  .input-icon-wrap { position: relative; }
  .input-icon-wrap .material-icons {
    position: absolute; left: 14px; top: 50%;
    transform: translateY(-50%); color: #b0bac9; font-size: 1.2rem;
  }
  .input-icon-wrap .form-control { padding-left: 44px; }
  .tier-info {
    background: linear-gradient(135deg, #f0fffe, #fff8f0);
    border: 1px solid #e0f7f5;
    border-radius: 12px;
    padding: 14px 16px;
    margin-bottom: 20px;
    font-size: 0.88rem;
    color: #4a5568;
  }
  .tier-info h4 {
    font-family: 'Fredoka One', cursive;
    color: var(--dark); margin: 0 0 8px; font-size: 1rem;
  }
  .tier-row { display: flex; gap: 6px; flex-wrap: wrap; }
  .tier-badge {
    display: inline-flex; align-items: center; gap: 4px;
    padding: 4px 10px; border-radius: 20px; font-size: 0.8rem; font-weight: 700;
  }
</style>
@endpush

@section('content')
<div class="auth-wrap">
  <div class="auth-card">
    <div class="auth-logo">
      <span class="emoji">🌟</span>
      <h1>Daftar Member</h1>
      <p>Buat akun untuk menikmati keuntungan eksklusif</p>
    </div>

    <div class="tier-info">
      <h4>🏆 Program Loyalitas Member</h4>
      <div class="tier-row">
        <span class="tier-badge" style="background:#fdf0e6; color:#a0522d;">🥉 Bronze (0–4 kunjungan)</span>
        <span class="tier-badge" style="background:#f5f5f5; color:#616161;">🥈 Silver (5–14) · Diskon 5%</span>
        <span class="tier-badge" style="background:#fffde7; color:#e65100;">🥇 Gold (15–29) · Diskon 10%</span>
        <span class="tier-badge" style="background:#e0fdfc; color:#00695c;">💎 Platinum (30+) · Diskon 15%</span>
      </div>
    </div>

    @if ($errors->any())
      <div class="alert alert-error">
        <span class="material-icons">error</span>
        {{ $errors->first() }}
      </div>
    @endif

    <form action="{{ route('member.register.post') }}" method="POST">
      @csrf

      <div class="form-group">
        <label for="nama_lengkap">Nama Lengkap</label>
        <div class="input-icon-wrap">
          <span class="material-icons">person</span>
          <input type="text" id="nama_lengkap" name="nama_lengkap" class="form-control"
                 placeholder="Nama lengkap Anda" value="{{ old('nama_lengkap') }}" required autofocus>
        </div>
      </div>

      <div class="form-group">
        <label for="email">Alamat Email</label>
        <div class="input-icon-wrap">
          <span class="material-icons">email</span>
          <input type="email" id="email" name="email" class="form-control"
                 placeholder="contoh@email.com" value="{{ old('email') }}" required>
        </div>
      </div>

      <div class="form-group">
        <label for="no_telepon">No. WhatsApp <span style="color:#b0bac9;font-weight:400">(opsional)</span></label>
        <div class="input-icon-wrap">
          <span class="material-icons">phone</span>
          <input type="tel" id="no_telepon" name="no_telepon" class="form-control"
                 placeholder="081234567890" value="{{ old('no_telepon') }}">
        </div>
      </div>

      <div class="form-group">
        <label for="password">Password</label>
        <div class="input-icon-wrap">
          <span class="material-icons">lock</span>
          <input type="password" id="password" name="password" class="form-control"
                 placeholder="Minimal 6 karakter" required>
        </div>
      </div>

      <div class="form-group">
        <label for="password_confirmation">Konfirmasi Password</label>
        <div class="input-icon-wrap">
          <span class="material-icons">lock_outline</span>
          <input type="password" id="password_confirmation" name="password_confirmation" class="form-control"
                 placeholder="Ulangi password" required>
        </div>
      </div>

      <button type="submit" class="btn-auth">
        <span class="material-icons" style="vertical-align: middle; margin-right:6px; font-size:1.1rem">how_to_reg</span>
        Daftar Sekarang
      </button>
    </form>

    <p style="margin-top:1rem; color:#495057; font-size:0.95rem; line-height:1.5;">Akun baru akan ditinjau dan dikonfirmasi oleh admin terlebih dahulu sebelum dapat digunakan.</p>

    <div class="auth-footer" style="margin-top: 16px;">
      Sudah punya akun? <a href="{{ route('member.login') }}">Login di sini</a>
    </div>
    <div class="auth-footer" style="margin-top: 10px;">
      <a href="{{ route('home') }}">← Kembali ke Beranda</a>
    </div>
  </div>
</div>
@endsection
