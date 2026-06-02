@extends('layouts.app')

@section('title', 'Cari Tiket - Kids Park')

@push('styles')
<style>
  .search-card {
    max-width: 500px;
    margin: 40px auto;
    text-align: center;
  }
  
  .search-icon {
    font-size: 4rem;
    color: var(--primary);
    margin-bottom: 15px;
  }

  .btn-search {
    background: linear-gradient(135deg, var(--primary), #ff8255);
    color: #fff;
    border-radius: 30px;
    font-size: 1rem;
    box-shadow: 0 4px 12px rgba(255, 107, 53, 0.2);
    width: 100%;
    margin-top: 10px;
  }

  .btn-search:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 18px rgba(255, 107, 53, 0.3);
  }
</style>
@endpush

@section('content')
<div class="card search-card">
  <span class="material-icons search-icon">confirmation_number</span>
  <h2 style="font-family: 'Fredoka One', cursive; font-size: 1.8rem; color: var(--dark); margin: 0 0 10px 0;">Cari Tiket Anda</h2>
  <p style="color: #7a828a; font-size: 0.92rem; margin-bottom: 25px;">
    Masukkan Kode Booking Anda (contoh: KP-20260528-ABCD) untuk melihat status pembayaran, bukti transfer, atau mencetak tiket Anda.
  </p>

  <form action="{{ route('tiket.cari') }}" method="GET">
    <div class="form-group">
      <label for="kode_booking" style="text-align: left">Kode Booking</label>
      <input type="text" id="kode_booking" name="kode_booking" class="form-control" 
             placeholder="Masukkan Kode Booking Anda" required style="text-align: center; font-size: 1.1rem; font-weight: 700; letter-spacing: 0.05em; text-transform: uppercase;">
    </div>

    <button type="submit" class="btn btn-search">
      <span class="material-icons">search</span>
      Cari Tiket
    </button>
  </form>

  <div style="margin-top: 30px; border-top: 1px solid #e9ecef; padding-top: 20px;">
    <p style="font-size: 0.85rem; color: #adb5bd;">
      Kehilangan kode booking? Hubungi pengelola Kids Park melalui WhatsApp di nomor yang tersedia pada halaman kontak.
    </p>
  </div>
</div>
@endsection
