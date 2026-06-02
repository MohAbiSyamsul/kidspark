@extends('layouts.app')

@section('title', 'Status Tiket - Kids Park')

@push('styles')
<style>
  .status-wrapper {
    max-width: 650px;
    margin: 0 auto;
  }

  .status-banner {
    text-align: center;
    border-radius: var(--radius);
    padding: 24px;
    margin-bottom: 30px;
    font-weight: 700;
  }

  .status-pending {
    background-color: #fff9db;
    color: #f08c00;
    border: 1px solid #ffe066;
  }

  .status-waiting {
    background-color: #e7f5ff;
    color: #1971c2;
    border: 1px solid #a5d8ff;
  }

  .status-paid {
    background-color: #ebfbee;
    color: #2f9e44;
    border: 1px solid #b2f2bb;
  }

  .status-cancelled {
    background-color: #fff5f5;
    color: #e03131;
    border: 1px solid #ffc9c9;
  }

  /* Digital Ticket Stub Styling */
  .ticket-stub {
    background: #fff;
    border-radius: var(--radius);
    box-shadow: 0 15px 35px rgba(0,0,0,0.06);
    overflow: hidden;
    position: relative;
    border: 2px solid #e9ecef;
  }

  /* Decorative cutouts on sides */
  .ticket-stub::before, .ticket-stub::after {
    content: '';
    position: absolute;
    top: 50%;
    width: 24px;
    height: 24px;
    border-radius: 50%;
    background: var(--light-bg);
    transform: translateY(-50%);
    z-index: 5;
    border: 2px solid #e9ecef;
  }

  .ticket-stub::before {
    left: -13px;
  }

  .ticket-stub::after {
    right: -13px;
  }

  .ticket-top {
    background: linear-gradient(135deg, var(--primary), #ff8255);
    color: #fff;
    padding: 30px;
    text-align: center;
    border-bottom: 2px dashed #dee2e6;
  }

  .ticket-top h3 {
    font-family: 'Fredoka One', cursive;
    font-size: 1.6rem;
    margin: 0 0 6px 0;
    letter-spacing: 0.02em;
  }

  .ticket-top p {
    font-size: 0.9rem;
    margin: 0;
    opacity: 0.9;
  }

  .ticket-bottom {
    padding: 30px;
    background: #fff;
    display: grid;
    grid-template-columns: 1fr 180px;
    gap: 20px;
    align-items: center;
  }

  @media (max-width: 580px) {
    .ticket-bottom {
      grid-template-columns: 1fr;
      text-align: center;
      justify-items: center;
    }
  }

  .ticket-info-grid {
    display: grid;
    grid-template-columns: 1fr;
    gap: 12px;
  }

  .info-item label {
    display: block;
    font-size: 0.78rem;
    text-transform: uppercase;
    letter-spacing: 0.05em;
    color: #868e96;
    margin-bottom: 2px;
    font-weight: 700;
  }

  .info-item span {
    font-size: 1.05rem;
    font-weight: 800;
    color: var(--dark);
  }

  .ticket-qr-box {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 8px;
  }

  .ticket-qr {
    width: 140px;
    height: 140px;
    border: 1px solid #e9ecef;
    border-radius: 8px;
    padding: 8px;
    background: #fff;
  }

  .ticket-code {
    font-family: 'Fredoka One', cursive;
    font-size: 1rem;
    color: var(--dark);
    letter-spacing: 0.05em;
  }

  /* List of items */
  .ticket-items-summary {
    padding: 20px 30px;
    background: #f8f9fa;
    border-top: 1px solid #e9ecef;
    font-size: 0.88rem;
  }

  .ticket-item-row {
    display: flex;
    justify-content: space-between;
    margin-bottom: 6px;
    color: #495057;
  }

  .action-buttons {
    display: flex;
    gap: 15px;
    margin-top: 30px;
    justify-content: center;
  }

  /* Print Stylesheet */
  @media print {
    body {
      background-color: #fff;
      font-size: 12pt;
    }
    
    .navbar, footer, .status-banner, .action-buttons, .main-content {
      padding-top: 0 !important;
      padding-bottom: 0 !important;
    }

    .navbar, footer, .status-banner, .action-buttons {
      display: none !important;
    }

    .main-content {
      margin: 0 !important;
      padding: 0 !important;
    }

    .status-wrapper {
      max-width: 100% !important;
      width: 100% !important;
      margin: 0 !important;
    }

    .ticket-stub {
      box-shadow: none !important;
      border: 1px solid #000 !important;
      page-break-inside: avoid;
    }

    .ticket-top {
      background: #f1f3f5 !important;
      color: #000 !important;
      border-bottom: 1px dashed #000 !important;
    }

    .ticket-top h3, .ticket-top p {
      color: #000 !important;
    }

    .ticket-stub::before, .ticket-stub::after {
      display: none !important;
    }
  }
</style>
@endpush

@section('content')
<div class="status-wrapper">
  <!-- Status Banner -->
  <div class="status-banner 
    @if($pesanan->status_pembayaran === 'pending') status-pending
    @elseif($pesanan->status_pembayaran === 'menunggu_konfirmasi') status-waiting
    @elseif($pesanan->status_pembayaran === 'lunas') status-paid
    @elseif($pesanan->status_pembayaran === 'batal') status-cancelled
    @endif">
    
    @if($pesanan->status_pembayaran === 'pending')
      <span class="material-icons" style="vertical-align:middle; margin-right:6px">payment</span>
      <strong>MENUNGGU PEMBAYARAN</strong>
      <div style="font-size:0.9rem; font-weight:normal; margin-top:6px">
        Tiket belum dibayar. Silakan lakukan pembayaran via QRIS terlebih dahulu.
      </div>
    @elseif($pesanan->status_pembayaran === 'menunggu_konfirmasi')
      <span class="material-icons" style="vertical-align:middle; margin-right:6px">hourglass_empty</span>
      <strong>MENUNGGU KONFIRMASI</strong>
      <div style="font-size:0.9rem; font-weight:normal; margin-top:6px">
        Bukti pembayaran telah diterima. Pengelola sedang memverifikasi transaksi Anda.
      </div>
    @elseif($pesanan->status_pembayaran === 'lunas')
      <span class="material-icons" style="vertical-align:middle; margin-right:6px">check_circle</span>
      <strong>TIKET AKTIF (LUNAS)</strong>
      <div style="font-size:0.9rem; font-weight:normal; margin-top:6px">
        Pembayaran berhasil dikonfirmasi! Tiket Anda aktif dan siap digunakan.
      </div>
    @elseif($pesanan->status_pembayaran === 'batal')
      <span class="material-icons" style="vertical-align:middle; margin-right:6px">cancel</span>
      <strong>PESANAN DIBATALKAN</strong>
      <div style="font-size:0.9rem; font-weight:normal; margin-top:6px">
        Pesanan dibatalkan atau bukti pembayaran tidak valid/ditolak.
      </div>
    @endif
  </div>

  <!-- Ticket Card -->
  <div class="ticket-stub">
    <div class="ticket-top">
      <h3>🎡 KIDS PARK INDRAMAYU</h3>
      <p>Tiket Masuk Wahana & Rekreasi Keluarga</p>
    </div>

    <div class="ticket-bottom">
      <div class="ticket-info-grid">
        <div class="info-item">
          <label>Nama Pengunjung</label>
          <span>{{ $pesanan->nama_pengunjung }}</span>
        </div>
        <div class="info-item">
          <label>Tanggal Kunjungan</label>
          <span>{{ $pesanan->tanggal_kunjungan->format('d F Y') }}</span>
        </div>
        <div class="info-item">
          <label>Status Kunjungan</label>
          <span>
            @if($pesanan->status_kunjungan === 'sudah_hadir')
              <strong style="color:var(--green)">✓ SUDAH MASUK (VALIDATED)</strong>
            @else
              <strong style="color:#868e96">BELUM HADIR</strong>
            @endif
          </span>
        </div>
        <div class="info-item" style="margin-top:4px">
          <label>Kontak Pembeli</label>
          <span style="font-size:0.88rem; font-weight:normal">{{ $pesanan->telepon_pengunjung }} | {{ $pesanan->email_pengunjung }}</span>
        </div>
      </div>

      <!-- QR Code Block -->
      <div class="ticket-qr-box">
        @if($pesanan->status_pembayaran === 'lunas')
          <!-- Ticket is active: Render code QR for entry scanning -->
          <img class="ticket-qr" src="https://api.qrserver.com/v1/create-qr-code/?size=150x150&data={{ $pesanan->kode_booking }}" alt="Ticket QR Code">
          <span class="ticket-code">{{ $pesanan->kode_booking }}</span>
        @else
          <!-- Show payment QRIS symbol or locking symbol -->
          <div class="ticket-qr" style="display:flex; flex-direction:column; align-items:center; justify-content:center; background:#f8f9fa; border-style:dashed; color:#adb5bd">
            <span class="material-icons" style="font-size:3rem">lock</span>
            <span style="font-size:0.75rem; text-align:center; font-weight:700; margin-top:5px; padding:0 5px">Menunggu Lunas</span>
          </div>
          <span class="ticket-code" style="color:#adb5bd">{{ $pesanan->kode_booking }}</span>
        @endif
      </div>
    </div>

    <!-- Ticket Items Summary -->
    <div class="ticket-items-summary">
      <div style="font-weight:800; color:var(--dark); margin-bottom:8px; border-bottom:1px solid #dee2e6; padding-bottom:4px">
        Rincian Tiket Dipesan:
      </div>
      @foreach($pesanan->details as $detail)
      <div class="ticket-item-row">
        <span>{{ $detail->tiket->jenis_tiket }}</span>
        <span><strong>{{ $detail->jumlah }}x</strong> - Rp {{ number_format($detail->subtotal, 0, ',', '.') }}</span>
      </div>
      @endforeach
      <div class="ticket-item-row" style="margin-top:10px; font-weight:800; font-size:0.95rem; color:var(--primary)">
        <span>Total Pembayaran:</span>
        <span>Rp {{ number_format($pesanan->total_bayar, 0, ',', '.') }}</span>
      </div>
    </div>
  </div>

  <!-- Action Buttons -->
  <div class="action-buttons">
    <a href="{{ route('home') }}" class="btn btn-secondary">
      <span class="material-icons">home</span> Kembali ke Beranda
    </a>

    @if($pesanan->status_pembayaran === 'pending')
      <a href="{{ route('tiket.bayar', $pesanan->kode_booking) }}" class="btn btn-primary" style="background:var(--primary)">
        <span class="material-icons">payment</span> Bayar Sekarang
      </a>
    @elseif($pesanan->status_pembayaran === 'lunas')
      <button onclick="window.print()" class="btn btn-primary" style="background:var(--blue)">
        <span class="material-icons">print</span> Cetak Tiket
      </button>
    @endif
  </div>
</div>
@endsection
