@extends('layouts.app')

@section('title', 'Profil Member - Kids Park')

@section('content')
<div class="section-header" style="display:flex; align-items:center; justify-content:space-between; margin-bottom:24px">
  <div>
    <h2 style="font-family:'Fredoka One',cursive; font-size:1.8rem; color:var(--dark); margin:0 0 4px">
      Profil Saya
    </h2>
    <p style="color:#8a94a6; margin:0">Kelola informasi akun Anda</p>
  </div>
  <a href="{{ route('member.dashboard') }}" class="btn" style="background:#f0f2f5; color:var(--dark)">
    <span class="material-icons">arrow_back</span> Dashboard
  </a>
</div>

<div style="display:grid; grid-template-columns:1fr 1fr; gap:24px">
  {{-- Profile Info --}}
  <div class="card">
    <div class="card-title">
      <span class="material-icons" style="color:var(--primary)">manage_accounts</span>
      Informasi Akun
    </div>
    <form action="{{ route('member.profil.update') }}" method="POST">
      @csrf
      @method('PUT')

      <div class="form-group">
        <label>No. Member</label>
        <input type="text" class="form-control" value="{{ $member->no_member }}" disabled
               style="background:#f8f9fa; color:#8a94a6">
      </div>
      <div class="form-group">
        <label>Tier Member</label>
        @php
          $tierColors = ['Bronze'=>'#a0522d','Silver'=>'#616161','Gold'=>'#e65c00','Platinum'=>'#00bcd4'];
          $tierIcons  = ['Bronze'=>'🥉','Silver'=>'🥈','Gold'=>'🥇','Platinum'=>'💎'];
        @endphp
        <input type="text" class="form-control"
               value="{{ ($tierIcons[$member->tier] ?? '') . ' ' . $member->tier }}"
               disabled style="background:#f8f9fa; color:{{ $tierColors[$member->tier] ?? '#333' }}; font-weight:700">
      </div>
      <div class="form-group">
        <label for="nama_lengkap">Nama Lengkap</label>
        <input type="text" id="nama_lengkap" name="nama_lengkap" class="form-control"
               value="{{ old('nama_lengkap', $member->nama_lengkap) }}" required>
      </div>
      <div class="form-group">
        <label>Email</label>
        <input type="email" class="form-control" value="{{ $member->email }}" disabled
               style="background:#f8f9fa; color:#8a94a6">
        <small style="color:#8a94a6">Email tidak dapat diubah</small>
      </div>
      <div class="form-group" style="margin-bottom:0">
        <label for="no_telepon">No. WhatsApp</label>
        <input type="tel" id="no_telepon" name="no_telepon" class="form-control"
               value="{{ old('no_telepon', $member->no_telepon) }}" placeholder="081234567890">
      </div>

      <button type="submit" class="btn" style="margin-top:20px; background:linear-gradient(135deg,var(--primary),#ff8255); color:#fff; width:100%">
        <span class="material-icons">save</span> Simpan Perubahan
      </button>
    </form>
  </div>

  {{-- Change Password --}}
  <div class="card">
    <div class="card-title">
      <span class="material-icons" style="color:var(--secondary)">lock_reset</span>
      Ubah Password
    </div>
    <form action="{{ route('member.profil.password') }}" method="POST">
      @csrf
      @method('PUT')

      <div class="form-group">
        <label for="current_password">Password Saat Ini</label>
        <input type="password" id="current_password" name="current_password" class="form-control"
               placeholder="••••••••" required>
        @error('current_password')
          <p style="color:#ef4444; font-size:0.85rem; margin-top:5px">{{ $message }}</p>
        @enderror
      </div>
      <div class="form-group">
        <label for="password">Password Baru</label>
        <input type="password" id="password" name="password" class="form-control"
               placeholder="Minimal 6 karakter" required>
      </div>
      <div class="form-group" style="margin-bottom:0">
        <label for="password_confirmation">Konfirmasi Password Baru</label>
        <input type="password" id="password_confirmation" name="password_confirmation" class="form-control"
               placeholder="Ulangi password baru" required>
      </div>

      <button type="submit" class="btn" style="margin-top:20px; background:linear-gradient(135deg,var(--secondary),#3db9b0); color:#fff; width:100%">
        <span class="material-icons">lock</span> Ubah Password
      </button>
    </form>

    {{-- Logout --}}
    <div style="margin-top: 24px; border-top: 1px solid #f0f2f5; padding-top: 20px;">
      <form action="{{ route('member.logout') }}" method="POST">
        @csrf
        <button type="submit" class="btn" style="width:100%; background:#fff5f5; color:#e03131; border: 1px solid #ffe3e3">
          <span class="material-icons">logout</span> Keluar dari Akun
        </button>
      </form>
    </div>
  </div>
</div>
@endsection
