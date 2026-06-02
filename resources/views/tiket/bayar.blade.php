@extends('layouts.app')

@section('title', 'Pembayaran Tiket - Kids Park')

@push('styles')
<style>
  .payment-layout {
    display: grid;
    grid-template-columns: 1fr 400px;
    gap: 30px;
    align-items: start;
  }

  @media (max-width: 900px) {
    .payment-layout {
      grid-template-columns: 1fr;
    }
  }

  /* Invoice details */
  .invoice-details {
    background: #fff;
    border-radius: var(--radius);
    padding: 30px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.04);
  }

  .invoice-header {
    border-bottom: 2px solid #f1f3f5;
    padding-bottom: 20px;
    margin-bottom: 20px;
  }

  .invoice-title {
    font-family: 'Fredoka One', cursive;
    font-size: 1.5rem;
    color: var(--dark);
    margin: 0;
  }

  .booking-code {
    display: inline-block;
    background: #e7f5ff;
    color: var(--blue);
    padding: 6px 12px;
    border-radius: 8px;
    font-weight: 800;
    margin-top: 6px;
    font-size: 0.95rem;
    letter-spacing: 0.05em;
  }

  .detail-table {
    width: 100%;
    border-collapse: collapse;
    margin-bottom: 25px;
  }

  .detail-table th, .detail-table td {
    padding: 12px 16px;
    text-align: left;
    border-bottom: 1px solid #f1f3f5;
  }

  .detail-table th {
    font-weight: 700;
    color: #495057;
    background-color: #f8f9fa;
  }

  .detail-table td {
    color: var(--text);
  }

  /* QRIS Display Standee */
  .qris-card {
    background: #fff;
    border: 2px solid #e9ecef;
    border-radius: var(--radius);
    overflow: hidden;
    box-shadow: 0 12px 28px rgba(0,0,0,0.06);
    display: flex;
    flex-direction: column;
    align-items: center;
    padding-bottom: 25px;
  }

  .qris-header {
    background: #d90429;
    color: #fff;
    width: 100%;
    padding: 15px;
    text-align: center;
    font-family: 'Fredoka One', cursive;
    font-size: 1.25rem;
    letter-spacing: 0.05em;
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 4px;
  }

  .qris-logo {
    font-weight: 900;
    font-size: 1.6rem;
    color: #fff;
    background: #003049;
    padding: 2px 14px;
    border-radius: 6px;
    font-style: italic;
    letter-spacing: 0;
  }

  .qris-qr-container {
    padding: 25px;
    background: #fff;
    border: 1px solid #dee2e6;
    border-radius: 12px;
    margin: 25px 0;
    box-shadow: 0 4px 12px rgba(0,0,0,0.03);
  }

  .qris-instructions {
    padding: 0 25px;
    text-align: center;
    font-size: 0.85rem;
    color: #6c757d;
    line-height: 1.5;
  }

  .total-highlight {
    font-family: 'Fredoka One', cursive;
    font-size: 1.6rem;
    color: var(--primary);
    margin-bottom: 10px;
  }

  /* File upload custom input */
  .upload-area {
    border: 2px dashed var(--secondary);
    border-radius: 12px;
    padding: 20px;
    text-align: center;
    background: #f3fbfb;
    cursor: pointer;
    transition: all 0.3s ease;
    margin-top: 15px;
  }

  .upload-area:hover {
    background: #e6fcfc;
    border-color: #3dbdb5;
  }

  .upload-area input[type=file] {
    display: none;
  }

  .upload-area .material-icons {
    font-size: 3rem;
    color: var(--secondary);
    margin-bottom: 8px;
  }

  .upload-filename {
    font-weight: 700;
    font-size: 0.9rem;
    color: var(--dark);
    margin-top: 8px;
    word-break: break-all;
  }

  .btn-submit-booking {
    background: linear-gradient(135deg, var(--primary), var(--primary-dark));
    color: #fff;
    border-radius: 30px;
    font-size: 1.05rem;
    font-weight: 700;
    box-shadow: 0 4px 15px rgba(255, 107, 53, 0.3);
    width: 100%;
    justify-content: center;
  }

  .btn-submit-booking:hover {
    background: linear-gradient(135deg, var(--primary-dark), #cf4b1b);
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(255, 107, 53, 0.4);
  }
</style>
@endpush

@section('content')
<div class="payment-layout">
  <!-- LEFT SIDE: Invoice Details -->
  <div class="booking-left">
    <div class="invoice-details">
      <div class="invoice-header">
        <div style="display:flex; justify-content:space-between; align-items:center;">
          <h2 class="invoice-title">Invoice Pemesanan</h2>
          <span class="booking-code">{{ $pesanan->kode_booking }}</span>
        </div>
        <p style="color:#7a828a; margin: 6px 0 0 0">Segera selesaikan pembayaran Anda sebelum tanggal kunjungan.</p>
      </div>

      <div style="display:grid; grid-template-columns: 1fr 1fr; gap:20px; margin-bottom:25px; font-size:0.92rem;">
        <div>
          <strong style="color:var(--dark)">Detail Pengunjung:</strong>
          <div style="margin-top: 5px; line-height: 1.5">
            <strong>Nama:</strong> {{ $pesanan->nama_pengunjung }}<br>
            <strong>WhatsApp:</strong> {{ $pesanan->telepon_pengunjung }}<br>
            <strong>Email:</strong> {{ $pesanan->email_pengunjung }}
          </div>
        </div>
        <div>
          <strong style="color:var(--dark)">Kunjungan:</strong>
          <div style="margin-top: 5px; line-height: 1.5">
            <strong>Tanggal:</strong> {{ $pesanan->tanggal_kunjungan->format('d F Y') }}<br>
            <strong>Status Kunjungan:</strong> 
            <span class="badge" style="background:#e9ecef; color:#495057; font-weight:700; padding:2px 8px; border-radius:4px; font-size:0.8rem">
              Belum Validasi
            </span>
          </div>
        </div>
      </div>

      <h3 style="font-family:'Fredoka One', cursive; font-size:1.15rem; color:var(--dark); margin-bottom:12px;">Detail Tiket</h3>
      <table class="detail-table">
        <thead>
          <tr>
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
            <td style="text-align: center">{{ $detail->jumlah }}</td>
            <td style="text-align: right; font-weight: 700">Rp {{ number_format($detail->subtotal, 0, ',', '.') }}</td>
          </tr>
          @endforeach
          <tr style="background:#fff9f6; font-size: 1.1rem;">
            <td colspan="3" style="text-align: right; font-weight: 800; border-top: 2px solid var(--primary)">Total Bayar:</td>
            <td style="text-align: right; font-weight: 900; color: var(--primary); border-top: 2px solid var(--primary)">
              Rp {{ number_format($pesanan->total_bayar, 0, ',', '.') }}
            </td>
          </tr>
        </tbody>
      </table>

      <!-- Payment Instructions alert -->
      <div style="background:#e7f5ff; border:1px solid #abdbff; border-radius:12px; padding:18px; display:flex; gap:12px; align-items:flex-start">
        <span class="material-icons" style="color:var(--blue)">info</span>
        <div style="font-size:0.9rem; line-height:1.5; color:#1864ab">
          <strong style="display:block; margin-bottom:4px">Petunjuk Pembayaran:</strong>
          1. Scan QRIS yang berada di sebelah kanan menggunakan aplikasi pembayaran pilihan Anda.<br>
          2. Masukkan nominal transfer sebesar yang tertera pada total bayar.<br>
          3. Setelah transfer berhasil, simpan bukti transfer dan unggah melalui form di sebelah kanan.<br>
          4. Admin akan meninjau pembayaran Anda dan mengubah status tiket menjadi aktif.
        </div>
      </div>
    </div>
  </div>

  <!-- RIGHT SIDE: QRIS Standee & Upload Form -->
  <div class="booking-right">
    <!-- QRIS Display -->
    <div class="qris-card">
      <div class="qris-header">
        <div class="qris-logo">QRIS</div>
        <span style="font-size:0.75rem; letter-spacing:0.1em; font-weight:600">GPN - INTEROPERABLE</span>
      </div>
      
      <div class="qris-qr-container">
        <!-- Render QR using free API pointing to the booking confirmation URL -->
        <img src="https://api.qrserver.com/v1/create-qr-code/?size=200x200&data={{ urlencode(route('tiket.status', $pesanan->kode_booking)) }}" 
             alt="QRIS QR Code" style="display:block; width:200px; height:200px">
      </div>

      <div class="total-highlight">
        Rp {{ number_format($pesanan->total_bayar, 0, ',', '.') }}
      </div>

      <div class="qris-instructions">
        <strong>Penyedia Pembayaran:</strong><br>
        GoPay, OVO, Dana, LinkAja, ShopeePay, atau Mobile Banking
      </div>
    </div>

    <!-- Upload Receipt Form Card -->
    <div class="card" style="margin-top:20px;">
      <div class="card-title" style="font-size:1.25rem">
        <span class="material-icons" style="color:var(--primary)">cloud_upload</span>
        Unggah Bukti Transfer
      </div>

      <form action="{{ route('tiket.upload_bukti', $pesanan->kode_booking) }}" method="POST" enctype="multipart/form-data" id="uploadForm">
        @csrf
        <div class="form-group" style="margin-bottom:15px">
          <label>File Bukti Pembayaran</label>
          <div class="upload-area" onclick="document.getElementById('bukti_pembayaran').click()">
            <span class="material-icons">image</span>
            <div style="font-weight:700; color:var(--text)">Klik untuk memilih file</div>
            <div style="font-size:0.75rem; color:#7a828a; margin-top:4px">Mendukung format JPG, PNG, WEBP (Maks 5MB)</div>
            <input type="file" name="bukti_pembayaran" id="bukti_pembayaran" accept="image/*" required>
            <div id="file-name" class="upload-filename" style="display:none"></div>
          </div>
        </div>

        <button type="submit" class="btn btn-submit-booking btn-block">
          <span class="material-icons">send</span>
          Kirim Bukti Pembayaran
        </button>
      </form>
    </div>
  </div>
</div>
@endsection

@push('scripts')
<script>
  document.addEventListener('DOMContentLoaded', function() {
    const fileInput = document.getElementById('bukti_pembayaran');
    const fileNameDiv = document.getElementById('file-name');

    fileInput.addEventListener('change', function() {
      if (fileInput.files.length > 0) {
        fileNameDiv.textContent = '📄 ' + fileInput.files[0].name;
        fileNameDiv.style.display = 'block';
      } else {
        fileNameDiv.style.display = 'none';
      }
    });
  });
</script>
@endpush
