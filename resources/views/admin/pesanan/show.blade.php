@extends('layouts.admin')

@section('title', 'Tinjau Pesanan #' . $pesanan->kode_booking)
@section('page_title', 'Detail Pesanan')
@section('page_subtitle', 'Tinjau rincian pemesanan dan bukti transaksi pembayaran')

@push('styles')
<style>
  .detail-grid {
    display: grid;
    grid-template-columns: 1fr 360px;
    gap: 24px;
    align-items: start;
  }

  @media (max-width: 900px) {
    .detail-grid {
      grid-template-columns: 1fr;
    }
  }

  .status-badge {
    display: inline-block;
    padding: 6px 12px;
    border-radius: 6px;
    font-size: 0.82rem;
    font-weight: 800;
    text-transform: uppercase;
  }

  .badge-pending { background-color: #fff9db; color: #f08c00; }
  .badge-waiting { background-color: #e7f5ff; color: #1971c2; }
  .badge-paid { background-color: #ebfbee; color: #2f9e44; }
  .badge-cancelled { background-color: #fff5f5; color: #e03131; }

  .visit-badge {
    display: inline-block;
    padding: 6px 12px;
    border-radius: 6px;
    font-size: 0.82rem;
    font-weight: 800;
  }

  .badge-not-arrived { background-color: #f1f3f5; color: #495057; }
  .badge-arrived { background-color: #d3f9d8; color: #2b8a3e; }

  .info-table {
    width: 100%;
    margin-bottom: 20px;
  }

  .info-table td {
    padding: 10px 0;
    border-bottom: 1px solid #f1f3f5;
  }

  .info-table td:first-child {
    font-weight: 700;
    color: var(--text-light);
    width: 160px;
  }

  .info-table td:last-child {
    color: var(--dark);
  }

  /* Receipt image review */
  .receipt-box {
    background: #fff;
    border: 1px solid #dee2e6;
    border-radius: var(--radius);
    padding: 20px;
    text-align: center;
    box-shadow: 0 4px 12px rgba(0,0,0,0.02);
  }

  .receipt-preview {
    max-width: 100%;
    max-height: 250px;
    border-radius: 8px;
    cursor: pointer;
    border: 1px solid #e9ecef;
    transition: all 0.2s ease;
    margin-top: 10px;
  }

  .receipt-preview:hover {
    transform: scale(1.02);
    box-shadow: 0 8px 16px rgba(0,0,0,0.08);
  }

  /* Fullscreen Modal Image Lightbox */
  .lightbox-modal {
    display: none;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0,0,0,0.85);
    z-index: 1500;
    align-items: center;
    justify-content: center;
    padding: 20px;
  }

  .lightbox-modal.open {
    display: flex;
  }

  .lightbox-img {
    max-width: 90%;
    max-height: 90%;
    border-radius: 8px;
    box-shadow: 0 10px 40px rgba(0,0,0,0.5);
  }

  .lightbox-close {
    position: absolute;
    top: 20px;
    right: 30px;
    color: #fff;
    font-size: 2.5rem;
    cursor: pointer;
    font-weight: bold;
  }
</style>
@endpush

@section('content')
<div style="margin-bottom: 20px;">
  <a href="{{ route('admin.pesanan.index') }}" class="btn btn-outline">
    <span class="material-icons" style="font-size: 1.1rem">arrow_back</span>
    Kembali ke Daftar
  </a>
</div>

<div class="detail-grid">
  <!-- LEFT: Order Details -->
  <div>
    <div class="card">
      <div class="card-header" style="display:flex; justify-content:space-between; align-items:center; border-bottom:1px solid #f1f3f5; padding-bottom:15px; margin-bottom:15px">
        <h3>Informasi Pemesanan</h3>
        <span style="font-family:'Fredoka One', cursive; font-size:1.3rem; color:var(--blue)">
          {{ $pesanan->kode_booking }}
        </span>
      </div>

      <div class="card-body">
        <table class="info-table">
          <tr>
            <td>Nama Pengunjung</td>
            <td><strong>{{ $pesanan->nama_pengunjung }}</strong></td>
          </tr>
          <tr>
            <td>No. WhatsApp</td>
            <td>
              <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $pesanan->telepon_pengunjung) }}" target="_blank" style="color:var(--primary); font-weight:700; text-decoration:none">
                {{ $pesanan->telepon_pengunjung }} <span class="material-icons" style="font-size:0.8rem; vertical-align:middle">open_in_new</span>
              </a>
            </td>
          </tr>
          <tr>
            <td>Alamat Email</td>
            <td>{{ $pesanan->email_pengunjung }}</td>
          </tr>
          <tr>
            <td>Tanggal Kunjungan</td>
            <td><strong>{{ $pesanan->tanggal_kunjungan->format('d F Y') }}</strong></td>
          </tr>
          <tr>
            <td>Tanggal Transaksi</td>
            <td>{{ $pesanan->created_at->format('d M Y H:i') }} WIB</td>
          </tr>
          <tr>
            <td>Status Pembayaran</td>
            <td>
              <span class="status-badge 
                @if($pesanan->status_pembayaran === 'pending') badge-pending
                @elseif($pesanan->status_pembayaran === 'menunggu_konfirmasi') badge-waiting
                @elseif($pesanan->status_pembayaran === 'lunas') badge-paid
                @elseif($pesanan->status_pembayaran === 'batal') badge-cancelled
                @endif">
                @if($pesanan->status_pembayaran === 'pending') Menunggu Pembayaran
                @elseif($pesanan->status_pembayaran === 'menunggu_konfirmasi') Menunggu Konfirmasi
                @elseif($pesanan->status_pembayaran === 'lunas') Lunas / Aktif
                @elseif($pesanan->status_pembayaran === 'batal') Dibatalkan / Ditolak
                @endif
              </span>
            </td>
          </tr>
          <tr>
            <td>Status Kehadiran</td>
            <td>
              <span class="visit-badge {{ $pesanan->status_kunjungan === 'sudah_hadir' ? 'badge-arrived' : 'badge-not-arrived' }}">
                {{ $pesanan->status_kunjungan === 'sudah_hadir' ? '✓ Sudah Validasi / Masuk' : 'Belum Datang' }}
              </span>
              @if($pesanan->status_kunjungan === 'sudah_hadir' && $pesanan->kunjungan_validated_at)
                <div style="font-size:0.8rem; color:#868e96; margin-top:4px">
                  Divalidasi pada: {{ $pesanan->kunjungan_validated_at->format('d M Y H:i') }} WIB
                </div>
              @endif
            </td>
          </tr>
        </table>

        <h4 style="font-family:'Fredoka One', cursive; margin-top:25px; margin-bottom:12px; color:var(--dark)">Rincian Tiket</h4>
        <div class="table-responsive">
          <table style="border: 1px solid #f1f3f5">
            <thead>
              <tr style="background:#f8f9fa">
                <th>Jenis Tiket</th>
                <th style="text-align: right">Harga</th>
                <th style="text-align: center">Jumlah</th>
                <th style="text-align: right">Subtotal</th>
              </tr>
            </thead>
            <tbody>
              @foreach($pesanan->details as $detail)
              <tr>
                <td><strong>{{ $detail->tiket->jenis_tiket }}</strong></td>
                <td style="text-align: right">Rp {{ number_format($detail->tiket->harga, 0, ',', '.') }}</td>
                <td style="text-align: center"><strong>{{ $detail->jumlah }}</strong></td>
                <td style="text-align: right; font-weight: 700">Rp {{ number_format($detail->subtotal, 0, ',', '.') }}</td>
              </tr>
              @endforeach
              <tr style="background:#fff9f6; font-size:1.05rem;">
                <td colspan="3" style="text-align: right; font-weight:800">Total Nominal:</td>
                <td style="text-align: right; font-weight:900; color:var(--primary)">Rp {{ number_format($pesanan->total_bayar, 0, ',', '.') }}</td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>

  <!-- RIGHT: Action Panel & Payment Proof -->
  <div>
    <!-- Proof image -->
    <div class="receipt-box">
      <h4 style="font-family:'Fredoka One', cursive; color:var(--dark); margin:0 0 10px 0;">Bukti Pembayaran</h4>
      
      @if($pesanan->bukti_pembayaran)
        <p style="font-size:0.8rem; color:#868e96; margin-bottom:10px">Klik gambar untuk memperbesar</p>
        <img src="{{ asset('storage/uploads/' . $pesanan->bukti_pembayaran) }}" 
             class="receipt-preview" alt="Bukti Pembayaran" onclick="openLightbox(this.src)">
      @else
        <div style="padding:40px 20px; border: 2px dashed #dee2e6; border-radius:12px; color:#adb5bd; background:#f8f9fa; margin-top:10px">
          <span class="material-icons" style="font-size:2.5rem; display:block; margin-bottom:5px">no_photography</span>
          Belum ada bukti pembayaran yang diunggah.
        </div>
      @endif
    </div>

    <!-- Approval actions -->
    @if($pesanan->status_pembayaran !== 'lunas' && $pesanan->status_pembayaran !== 'batal')
    <div class="card" style="margin-top:20px;">
      <div class="card-title" style="font-size:1.2rem; margin-bottom:15px">
        <span class="material-icons" style="color:var(--secondary)">gavel</span>
        Tindakan Admin
      </div>
      
      <div style="display:flex; flex-direction:column; gap:12px">
        <!-- Approve button -->
        <form action="{{ route('admin.pesanan.confirm', $pesanan->id_pesanan) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menyetujui dan melunasi pembayaran tiket ini?')">
          @csrf
          <button type="submit" class="btn btn-primary btn-block" style="background:var(--success); box-shadow:0 4px 12px rgba(47,158,68,0.2)">
            <span class="material-icons">check_circle</span> Setujui (Lunas)
          </button>
        </form>

        <!-- Cancel button -->
        <form action="{{ route('admin.pesanan.cancel', $pesanan->id_pesanan) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menolak / membatalkan pesanan tiket ini?')">
          @csrf
          <button type="submit" class="btn btn-outline btn-block" style="color:var(--danger); border: 2px solid var(--danger); background:#fff">
            <span class="material-icons">cancel</span> Batalkan / Tolak
          </button>
        </form>
      </div>
    </div>
    @endif
  </div>
</div>

<!-- Lightbox Modal -->
<div class="lightbox-modal" id="lightboxModal" onclick="closeLightbox()">
  <span class="lightbox-close">&times;</span>
  <img class="lightbox-img" id="lightboxImg">
</div>
@endsection

@push('scripts')
<script>
  function openLightbox(src) {
    const modal = document.getElementById('lightboxModal');
    const img = document.getElementById('lightboxImg');
    img.src = src;
    modal.classList.add('open');
  }

  function closeLightbox() {
    const modal = document.getElementById('lightboxModal');
    modal.classList.remove('open');
  }
</script>
@endpush
