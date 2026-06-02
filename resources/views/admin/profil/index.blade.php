@extends('layouts.admin')

@section('title', 'Profil Admin')
@section('page_title', 'Profil Admin')
@section('page_subtitle', 'Edit informasi akun dan password')

@section('content')
<div class="card">
  <div class="card-header"><h3>Edit Profil</h3></div>
  <div class="card-body">
    <form method="POST" action="{{ route('admin.profil.update') }}" enctype="multipart/form-data">
      @csrf @method('PUT')
      <div class="form-grid-2">
        <div class="form-group">
          <label>Nama Lengkap</label>
          <input type="text" name="nama" class="form-control"
                 placeholder="Nama lengkap admin"
                 value="{{ old('nama', $admin->nama ?? '') }}">
        </div>
        <div class="form-group">
          <label>Jabatan</label>
          <input type="text" name="jabatan" class="form-control"
                 placeholder="contoh: Administrator"
                 value="{{ old('jabatan', $admin->jabatan ?? '') }}">
        </div>
      </div>
      <div class="form-group">
        <label>Foto Profil</label>
        <input type="file" name="foto" class="form-control" accept="image/*">
        <p class="form-text">Format: JPG, PNG, WEBP. Maks: 2MB</p>
      </div>
      <button type="submit" class="btn btn-primary">
        <span class="material-icons" style="font-size:1rem">save</span> Simpan Profil
      </button>
    </form>
  </div>
</div>

<div class="card" style="margin-top: 24px">
  <div class="card-header"><h3>Ubah Password</h3></div>
  <div class="card-body">
    <form method="POST" action="{{ route('admin.profil.password') }}">
      @csrf @method('PUT')
      <div class="form-group">
        <label>Password Lama <span style="color:red">*</span></label>
        <input type="password" name="password_lama" class="form-control"
               placeholder="Masukkan password lama" required>
        @error('password_lama')
          <p style="color:var(--danger); font-size:0.85rem; margin-top:4px">{{ $message }}</p>
        @enderror
      </div>
      <div class="form-grid-2">
        <div class="form-group">
          <label>Password Baru <span style="color:red">*</span></label>
          <input type="password" name="password_baru" class="form-control"
                 placeholder="Min. 6 karakter" required>
        </div>
        <div class="form-group">
          <label>Konfirmasi Password Baru <span style="color:red">*</span></label>
          <input type="password" name="password_baru_confirmation" class="form-control"
                 placeholder="Ulangi password baru" required>
        </div>
      </div>
      <button type="submit" class="btn btn-primary">
        <span class="material-icons" style="font-size:1rem">lock</span> Ubah Password
      </button>
    </form>
  </div>
</div>
@endsection
