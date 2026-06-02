@extends('layouts.admin')

@section('title', 'Validasi Tiket Masuk')
@section('page_title', 'Validasi Tiket Masuk')
@section('page_subtitle', 'Scan QR Code tiket pengunjung atau masukkan kode booking secara manual')

@push('styles')
<style>
  .scanner-layout {
    display: grid;
    grid-template-columns: 1fr 400px;
    gap: 24px;
    align-items: start;
  }

  @media (max-width: 900px) {
    .scanner-layout {
      grid-template-columns: 1fr;
    }
  }

  /* Scan area */
  .scanner-card {
    background: #fff;
    border-radius: var(--radius);
    padding: 30px;
    text-align: center;
    border: 1px solid #dee2e6;
    box-shadow: 0 4px 15px rgba(0,0,0,0.02);
  }

  #reader {
    background: #f8f9fa;
    border: 2px dashed #dee2e6 !important;
    border-radius: 12px;
    margin: 20px auto;
    overflow: hidden;
  }

  #reader__dashboard_section_csr button {
    background-color: var(--primary) !important;
    color: white !important;
    border: none !important;
    padding: 8px 16px !important;
    border-radius: 6px !important;
    font-weight: 700 !important;
    cursor: pointer !important;
    margin: 4px !important;
  }

  #reader__dashboard_section_csr button:hover {
    background-color: #ff8255 !important;
  }

  /* Verification Alerts */
  .validation-result-card {
    background: #fff;
    border-radius: var(--radius);
    padding: 30px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.04);
    border: 2px solid #dee2e6;
  }

  .result-valid {
    border-color: #51cf66;
    background-color: #ebfbee;
  }

  .result-invalid {
    border-color: #ff6b6b;
    background-color: #fff5f5;
  }

  .result-warning {
    border-color: #fcc419;
    background-color: #fff9db;
  }

  .result-header {
    display: flex;
    align-items: center;
    gap: 12px;
    margin-bottom: 20px;
    font-family: 'Fredoka One', cursive;
    font-size: 1.4rem;
  }

  .result-header span {
    font-size: 2.2rem;
  }

  .text-valid { color: #2b8a3e; }
  .text-invalid { color: #c92a2a; }
  .text-warning { color: #e67e22; }

  .ticket-details-box {
    background: rgba(255, 255, 255, 0.7);
    border-radius: 8px;
    padding: 15px;
    border: 1px solid rgba(0,0,0,0.05);
    margin-bottom: 20px;
  }

  .ticket-details-box table {
    width: 100%;
    font-size: 0.9rem;
  }

  .ticket-details-box td {
    padding: 6px 0;
    border: none;
  }

  .ticket-details-box td:first-child {
    font-weight: 700;
    color: #495057;
    width: 120px;
  }

  .ticket-details-box td:last-child {
    color: var(--dark);
  }
</style>
@endpush

@section('content')
<div class="scanner-layout">
  <!-- LEFT: Scanning Form & Camera -->
  <div>
    <div class="scanner-card">
      <h3 style="font-family:'Fredoka One', cursive; color:var(--dark); margin-top:0">Scan Kode Tiket</h3>
      <p style="color:#7a828a; font-size:0.9rem">Gunakan kamera untuk men-scan QR code tiket pengunjung, atau masukkan kode booking secara manual di bawah.</p>
      
      <!-- Camera Reader container -->
      <div id="reader" style="width: 100%; max-width: 450px;"></div>

      <form action="{{ route('admin.pesanan.validasi') }}" method="GET" id="validationSearchForm" style="margin-top: 25px;">
        <div class="form-group" style="max-width: 400px; margin: 0 auto 15px auto;">
          <label for="kode_booking">Kode Booking Manual</label>
          <input type="text" name="kode_booking" id="kode_booking" class="form-control" 
                 placeholder="Contoh: KP-20260528-ABCD" value="{{ $kode }}"
                 style="text-align: center; font-size: 1.15rem; font-weight: 800; letter-spacing: 0.05em; text-transform: uppercase;" required>
        </div>
        <button type="submit" class="btn btn-primary" style="border-radius:30px; padding: 10px 30px">
          <span class="material-icons">search</span> Cari Tiket
        </button>
      </form>
    </div>
  </div>

  <!-- RIGHT: Results and Check-In Action -->
  <div>
    @if($pesanan)
      <!-- Found Ticket Result -->
      @if($pesanan->status_pembayaran === 'lunas' && $pesanan->status_kunjungan === 'belum_hadir')
        <!-- VALID TICKET -->
        <div class="validation-result-card result-valid">
          <div class="result-header text-valid">
            <span class="material-icons">check_circle</span>
            TIKET VALID
          </div>
          
          <p style="font-size:0.9rem; color:#2b8a3e; margin-bottom:15px">Tiket ini aktif dan siap divalidasi masuk ke dalam wahana.</p>

          <div class="ticket-details-box">
            <table>
              <tr>
                <td>Kode Booking</td>
                <td><strong>{{ $pesanan->kode_booking }}</strong></td>
              </tr>
              <tr>
                <td>Nama</td>
                <td>{{ $pesanan->nama_pengunjung }}</td>
              </tr>
              <tr>
                <td>Kunjungan</td>
                <td>{{ $pesanan->tanggal_kunjungan->format('d M Y') }}</td>
              </tr>
              <tr>
                <td>Jumlah Orang</td>
                <td><strong style="font-size:1.1rem; color:var(--primary)">{{ $pesanan->details->sum('jumlah') }} Orang</strong></td>
              </tr>
            </table>
          </div>

          <form action="{{ route('admin.pesanan.proses_validasi') }}" method="POST">
            @csrf
            <input type="hidden" name="id_pesanan" value="{{ $pesanan->id_pesanan }}">
            <button type="submit" class="btn btn-primary btn-block" style="background:#2b8a3e; border-radius:30px; box-shadow:0 4px 12px rgba(43,138,62,0.3)">
              <span class="material-icons">login</span> Konfirmasi Kehadiran (Check-In)
            </button>
          </form>
        </div>
      @elseif($pesanan->status_pembayaran === 'lunas' && $pesanan->status_kunjungan === 'sudah_hadir')
        <!-- ALREADY CHECKED IN -->
        <div class="validation-result-card result-warning">
          <div class="result-header text-warning">
            <span class="material-icons">warning</span>
            TIKET SUDAH DI-SCAN
          </div>
          
          <p style="font-size:0.9rem; color:#e67e22; margin-bottom:15px">
            Tiket ini <strong>SUDAH DIGUNAKAN</strong> untuk masuk sebelumnya.
          </p>

          <div class="ticket-details-box">
            <table>
              <tr>
                <td>Kode Booking</td>
                <td><strong>{{ $pesanan->kode_booking }}</strong></td>
              </tr>
              <tr>
                <td>Nama</td>
                <td>{{ $pesanan->nama_pengunjung }}</td>
              </tr>
              <tr>
                <td>Waktu Masuk</td>
                <td><strong class="text-warning">{{ $pesanan->kunjungan_validated_at->format('d M Y H:i') }} WIB</strong></td>
              </tr>
              <tr>
                <td>Jumlah Orang</td>
                <td>{{ $pesanan->details->sum('jumlah') }} Orang</td>
              </tr>
            </table>
          </div>

          <div style="background:#fcc419; color:#862e01; font-weight:700; padding:12px; border-radius:8px; font-size:0.85rem; text-align:center">
            Peringatan: Tolak masuk! Tiket sudah tidak berlaku.
          </div>
        </div>
      @elseif($pesanan->status_pembayaran === 'pending' || $pesanan->status_pembayaran === 'menunggu_konfirmasi')
        <!-- UNPAID / WAITING PAYMENT -->
        <div class="validation-result-card result-warning">
          <div class="result-header text-warning">
            <span class="material-icons">hourglass_empty</span>
            TIKET BELUM LUNAS
          </div>
          
          <p style="font-size:0.9rem; color:#e67e22; margin-bottom:15px">
            Pembayaran tiket ini belum divalidasi. Anda dapat menerima pembayaran tunai di loket untuk langsung memvalidasi masuk.
          </p>

          @if($pesanan->status_pembayaran === 'menunggu_konfirmasi' && $pesanan->bukti_pembayaran)
            <div style="background:#e7f5ff; border:1px solid #a5d8ff; padding:10px; border-radius:8px; margin-bottom:15px; font-size:0.85rem">
              <span class="material-icons" style="font-size:1rem; vertical-align:middle; color:var(--blue)">image</span>
              Pengunjung mengunggah bukti bayar: 
              <a href="{{ asset('storage/uploads/' . $pesanan->bukti_pembayaran) }}" target="_blank" style="color:var(--blue); font-weight:700; text-decoration:none">
                Lihat Gambar &raquo;
              </a>
            </div>
          @endif

          <div class="ticket-details-box">
            <table>
              <tr>
                <td>Kode Booking</td>
                <td><strong>{{ $pesanan->kode_booking }}</strong></td>
              </tr>
              <tr>
                <td>Nama</td>
                <td>{{ $pesanan->nama_pengunjung }}</td>
              </tr>
              <tr>
                <td>Total Tagihan</td>
                <td><strong style="font-size:1.1rem; color:var(--primary)">Rp {{ number_format($pesanan->total_bayar, 0, ',', '.') }}</strong></td>
              </tr>
              <tr>
                <td>Jumlah Orang</td>
                <td>{{ $pesanan->details->sum('jumlah') }} Orang</td>
              </tr>
            </table>
          </div>

          <form action="{{ route('admin.pesanan.proses_validasi') }}" method="POST" onsubmit="return confirm('Apakah Anda yakin telah menerima pembayaran tunai sebesar Rp {{ number_format($pesanan->total_bayar, 0, ',', '.') }}?')">
            @csrf
            <input type="hidden" name="id_pesanan" value="{{ $pesanan->id_pesanan }}">
            <input type="hidden" name="action" value="bayar_dan_masuk">
            <button type="submit" class="btn btn-primary btn-block" style="background:#2b8a3e; border-radius:30px; box-shadow:0 4px 12px rgba(43,138,62,0.3)">
              <span class="material-icons">payments</span> Bayar Tunai & Check-In
            </button>
          </form>

          <a href="{{ route('admin.pesanan.show', $pesanan->id_pesanan) }}" class="btn btn-block btn-outline" style="border-radius:30px; margin-top:10px; text-align:center; display:block">
            <span class="material-icons">receipt</span> Tinjau Detail Transaksi
          </a>
        </div>
      @else
        <!-- CANCELLED TICKET -->
        <div class="validation-result-card result-invalid">
          <div class="result-header text-invalid">
            <span class="material-icons">cancel</span>
            PESANAN BATAL
          </div>
          
          <p style="font-size:0.9rem; color:#c92a2a; margin-bottom:15px">
            Pesanan tiket ini telah dibatalkan atau ditolak. Pengunjung tidak diperbolehkan masuk.
          </p>

          <div class="ticket-details-box">
            <table>
              <tr>
                <td>Kode Booking</td>
                <td><strong>{{ $pesanan->kode_booking }}</strong></td>
              </tr>
              <tr>
                <td>Nama</td>
                <td>{{ $pesanan->nama_pengunjung }}</td>
              </tr>
              <tr>
                <td>Status</td>
                <td><strong class="text-invalid">DIBATALKAN</strong></td>
              </tr>
            </table>
          </div>

          <a href="{{ route('admin.pesanan.show', $pesanan->id_pesanan) }}" class="btn btn-block" style="background:#c92a2a; color:#fff; border-radius:30px; text-align:center; display:block">
            <span class="material-icons">receipt</span> Tinjau Detail
          </a>
        </div>
      @endif
    @elseif($error)
      <!-- Error Alert -->
      <div class="validation-result-card result-invalid">
        <div class="result-header text-invalid">
          <span class="material-icons">error</span>
          TIDAK DITEMUKAN
        </div>
        <p style="color:#c92a2a; font-size:0.9rem; line-height:1.5">{{ $error }}</p>
      </div>
    @else
      <!-- Waiting for Input -->
      <div class="validation-result-card" style="border-style:dashed; text-align:center; color:#adb5bd; background:#f8f9fa">
        <span class="material-icons" style="font-size:4rem; margin-bottom:10px">qr_code_scanner</span>
        <h4>Menunggu Scan / Input</h4>
        <p style="font-size:0.85rem; margin-top:5px">Silakan scan QR code tiket pengunjung atau ketik kode booking untuk memvalidasi tiket masuk.</p>
      </div>
    @endif
  </div>
</div>
@endsection

@push('scripts')
<!-- Load html5-qrcode scanner from CDN -->
<script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>
<script>
  document.addEventListener('DOMContentLoaded', function() {
    function onScanSuccess(decodedText, decodedResult) {
      // Fill in form and submit
      document.getElementById('kode_booking').value = decodedText;
      document.getElementById('validationSearchForm').submit();
      
      // Stop scanner after successful scan to avoid duplicate requests
      if (html5QrcodeScanner) {
        html5QrcodeScanner.clear().catch(error => {
          console.error("Failed to clear scanner", error);
        });
      }
    }

    function onScanFailure(error) {
      // Fail silently, is fine since camera scans continuously
    }

    let html5QrcodeScanner = new Html5QrcodeScanner(
      "reader", 
      { 
        fps: 10, 
        qrbox: { width: 250, height: 250 },
        rememberLastUsedCamera: true,
        supportedScanTypes: [Html5QrcodeScanType.SCAN_TYPE_CAMERA]
      },
      /* verbose= */ false
    );
    html5QrcodeScanner.render(onScanSuccess, onScanFailure);
  });
</script>
@endpush
