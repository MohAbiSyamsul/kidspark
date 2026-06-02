@extends('layouts.app')

@section('title', 'Login Member - Kids Park')

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
    max-width: 460px;
    position: relative;
    overflow: hidden;
  }
  .auth-card::before {
    content: '';
    position: absolute;
    top: 0; left: 0; right: 0;
    height: 5px;
    background: linear-gradient(90deg, var(--primary), var(--secondary), var(--accent));
  }
  .auth-logo {
    text-align: center;
    margin-bottom: 28px;
  }
  .auth-logo .emoji {
    font-size: 3.5rem;
    display: block;
    margin-bottom: 8px;
  }
  .auth-logo h1 {
    font-family: 'Fredoka One', cursive;
    font-size: 1.8rem;
    color: var(--dark);
    margin: 0 0 4px;
  }
  .auth-logo p {
    color: #8a94a6;
    font-size: 0.9rem;
    margin: 0;
  }
  .auth-card .form-group label {
    font-weight: 700;
    color: var(--dark);
    font-size: 0.9rem;
  }
  .btn-auth {
    width: 100%;
    background: linear-gradient(135deg, var(--primary), #ff8255);
    color: #fff;
    padding: 14px;
    border-radius: 12px;
    font-size: 1.05rem;
    font-weight: 700;
    border: none;
    cursor: pointer;
    transition: all 0.3s;
    margin-top: 8px;
  }
  .btn-auth:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 24px rgba(255,107,53,0.35);
  }
  .auth-footer {
    text-align: center;
    margin-top: 24px;
    color: #8a94a6;
    font-size: 0.92rem;
  }
  .auth-footer a {
    color: var(--primary);
    font-weight: 700;
    text-decoration: none;
  }
  .auth-footer a:hover { text-decoration: underline; }
  .input-icon-wrap {
    position: relative;
  }
  .input-icon-wrap .material-icons {
    position: absolute;
    left: 14px;
    top: 50%;
    transform: translateY(-50%);
    color: #b0bac9;
    font-size: 1.2rem;
  }
  .input-icon-wrap .form-control {
    padding-left: 44px;
  }
  .remember-row {
    display: flex;
    align-items: center;
    gap: 8px;
    margin-bottom: 20px;
    font-size: 0.9rem;
    color: #6b7280;
  }
  .error-text { color: #ef4444; font-size: 0.85rem; margin-top: 5px; }
  .divider {
    display: flex; align-items: center; gap: 12px;
    margin: 20px 0; color: #c4cad4; font-size: 0.85rem;
  }
  .divider::before, .divider::after {
    content: ''; flex: 1; height: 1px; background: #e8edf2;
  }
</style>
@endpush

@section('content')
<div class="auth-wrap">
  <div class="auth-card">
    <div class="auth-logo">
      <span class="emoji">🎡</span>
      <h1>Login Member</h1>
      <p>Masuk ke akun member Kids Park Anda</p>
    </div>

    @if($errors->has('login'))
      <div class="alert alert-error">
        <span class="material-icons">error</span>
        {{ $errors->first('login') }}
      </div>
    @endif

    <form action="{{ route('member.login.post') }}" method="POST">
      @csrf
      <div class="form-group">
        <label for="email">Alamat Email</label>
        <div class="input-icon-wrap">
          <span class="material-icons">email</span>
          <input type="email" id="email" name="email" class="form-control"
                 placeholder="contoh@email.com" value="{{ old('email') }}" required autofocus>
        </div>
      </div>

      <div class="form-group">
        <label for="password">Password</label>
        <div class="input-icon-wrap">
          <span class="material-icons">lock</span>
          <input type="password" id="password" name="password" class="form-control"
                 placeholder="••••••••" required>
        </div>
      </div>

      <div class="remember-row">
        <input type="checkbox" id="remember" name="remember" value="1">
        <label for="remember">Ingat saya</label>
      </div>

      <button type="submit" class="btn-auth">
        <span class="material-icons" style="vertical-align: middle; margin-right:6px; font-size:1.1rem">login</span>
        Masuk
      </button>
    </form>

    <div class="divider">atau</div>

    <div class="auth-footer">
      Belum punya akun member?
      <a href="{{ route('member.register') }}">Daftar Sekarang →</a>
    </div>
    <div class="auth-footer" style="margin-top: 10px;">
      <a href="{{ route('home') }}">← Kembali ke Beranda</a>
    </div>
  </div>
</div>
@endsection
