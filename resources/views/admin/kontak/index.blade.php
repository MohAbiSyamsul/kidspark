@extends('layouts.admin')

@section('title', 'Kelola Kontak')
@section('page_title', 'Kelola Kontak')
@section('page_subtitle', 'Edit informasi kontak dan lokasi Kids Park')

@section('content')
<div class="card">
  <div class="card-header"><h3>Informasi Kontak & Lokasi</h3></div>
  <div class="card-body">
    <form method="POST" action="{{ route('admin.kontak.update') }}">
      @csrf @method('PUT')

      <div class="form-group">
        <label>Alamat Lengkap</label>
        <textarea name="alamat" class="form-control" rows="3"
                  placeholder="Jl. Nama Jalan No. X, Kota...">{{ old('alamat', $kontak->alamat ?? '') }}</textarea>
      </div>

      <div class="form-grid-2">
        <div class="form-group">
          <label>Nomor Telepon / WhatsApp</label>
          <input type="text" name="nomor_telepon" class="form-control"
                 placeholder="08xxxxxxxxxx"
                 value="{{ old('nomor_telepon', $kontak->nomor_telepon ?? '') }}">
          <p class="form-text">Format: 08xxxxxxxxxx (tanpa tanda - atau spasi)</p>
        </div>
        <div class="form-group">
          <label>Email</label>
          <input type="email" name="email" class="form-control"
                 placeholder="kidspark@email.com"
                 value="{{ old('email', $kontak->email ?? '') }}">
        </div>
      </div>

      <div class="form-grid-2">
        <div class="form-group">
          <label>Instagram</label>
          <input type="url" name="instagram" class="form-control"
                 placeholder="https://www.instagram.com/kidspark"
                 value="{{ old('instagram', $kontak->instagram ?? '') }}">
        </div>
        <div class="form-group">
          <label>TikTok</label>
          <input type="url" name="tiktok" class="form-control"
                 placeholder="https://www.tiktok.com/@kidspark"
                 value="{{ old('tiktok', $kontak->tiktok ?? '') }}">
        </div>
      </div>

      <div class="form-group">
        <label>Jam Operasional</label>
        <input type="text" name="jam_operasional" class="form-control"
               placeholder="contoh: Senin - Minggu: 08.00 - 17.00 WIB"
               value="{{ old('jam_operasional', $kontak->jam_operasional ?? '') }}">
      </div>

      <div class="form-group">
        <label>Embed Google Maps</label>
        <textarea name="maps" class="form-control" rows="4"
                  placeholder="Tempel kode iframe dari Google Maps...">{{ old('maps', $kontak->maps ?? '') }}</textarea>
        <p class="form-text">Cara: Buka Google Maps → Cari lokasi → Klik Bagikan → Sematkan peta → Salin kode iframe</p>
      </div>

      <button type="submit" class="btn btn-primary">
        <span class="material-icons" style="font-size:1rem">save</span>
        Simpan Perubahan
      </button>
    </form>
  </div>
</div>

@if($kontak && $kontak->maps && str_contains($kontak->maps, 'iframe'))
<div class="card" style="margin-top: 24px">
  <div class="card-header"><h3>Preview Maps</h3></div>
  <div class="card-body">
    <div style="border-radius: 10px; overflow: hidden; height: 300px">
      {!! $kontak->maps !!}
    </div>
  </div>
</div>
@endif
@endsection
