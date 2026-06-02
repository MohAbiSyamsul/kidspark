@extends('layouts.app')

@section('title', 'Beli Tiket Online - Kids Park')

@push('styles')
<style>
  .booking-grid {
    display: grid;
    grid-template-columns: 1fr 380px;
    gap: 30px;
    align-items: start;
  }

  @media (max-width: 900px) {
    .booking-grid {
      grid-template-columns: 1fr;
    }
  }

  /* Ticket Selection Item */
  .ticket-select-list {
    display: flex;
    flex-direction: column;
    gap: 16px;
    margin-bottom: 30px;
  }

  .ticket-select-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    background: #fff;
    border: 2px solid #f1f3f5;
    padding: 20px;
    border-radius: 16px;
    transition: all 0.3s ease;
  }

  .ticket-select-item:hover {
    border-color: var(--secondary);
    box-shadow: 0 8px 24px rgba(78, 205, 196, 0.08);
  }

  .ticket-info h4 {
    font-family: 'Fredoka One', cursive;
    font-size: 1.15rem;
    color: var(--dark);
    margin: 0 0 6px 0;
  }

  .ticket-info p {
    font-size: 0.88rem;
    color: #7a828a;
    margin: 0 0 8px 0;
    line-height: 1.4;
  }

  .ticket-price {
    font-weight: 800;
    color: var(--primary);
    font-size: 1.1rem;
  }

  /* Numeric Stepper */
  .stepper {
    display: flex;
    align-items: center;
    background: #f1f3f5;
    border-radius: 30px;
    padding: 4px;
    border: 1px solid #e9ecef;
  }

  .stepper-btn {
    width: 36px;
    height: 36px;
    border-radius: 50%;
    background: #fff;
    border: none;
    font-size: 1.2rem;
    font-weight: bold;
    color: var(--dark);
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    box-shadow: 0 2px 6px rgba(0,0,0,0.05);
    transition: all 0.2s ease;
  }

  .stepper-btn:hover {
    background: var(--primary);
    color: #fff;
  }

  .stepper-btn:active {
    transform: scale(0.95);
  }

  .stepper-input {
    width: 45px;
    border: none;
    background: transparent;
    text-align: center;
    font-weight: 800;
    font-size: 1.05rem;
    color: var(--dark);
    outline: none;
    -webkit-appearance: none;
    margin: 0;
  }

  /* Summary Card */
  .summary-card {
    position: sticky;
    top: 120px;
    background: var(--dark);
    color: #fff;
    border-radius: var(--radius);
    padding: 30px;
    box-shadow: 0 15px 35px rgba(26, 26, 46, 0.15);
  }

  @media (max-height: 720px) {
    .summary-card {
      position: static !important;
    }
  }

  .summary-card h3 {
    font-family: 'Fredoka One', cursive;
    font-size: 1.4rem;
    color: var(--accent);
    margin-top: 0;
    margin-bottom: 20px;
    border-bottom: 2px dashed rgba(255,255,255,0.15);
    padding-bottom: 15px;
  }

  .summary-item {
    display: flex;
    justify-content: space-between;
    margin-bottom: 12px;
    font-size: 0.92rem;
    opacity: 0.9;
  }

  .summary-total {
    display: flex;
    justify-content: space-between;
    border-top: 2px dashed rgba(255,255,255,0.15);
    padding-top: 15px;
    margin-top: 15px;
    margin-bottom: 25px;
  }

  .summary-total-label {
    font-weight: 700;
    font-size: 1.05rem;
  }

  .summary-total-price {
    font-family: 'Fredoka One', cursive;
    font-size: 1.5rem;
    color: var(--accent);
  }

  .btn-submit-booking {
    background: linear-gradient(135deg, var(--primary), var(--primary-dark));
    color: #fff;
    border-radius: 30px;
    font-size: 1.05rem;
    font-weight: 700;
    box-shadow: 0 4px 15px rgba(255, 107, 53, 0.3);
    width: 100%;
  }

  .btn-submit-booking:hover {
    background: linear-gradient(135deg, var(--primary-dark), #cf4b1b);
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(255, 107, 53, 0.4);
  }

  .empty-tickets {
    text-align: center;
    padding: 30px;
    color: #7a828a;
  }
</style>
@endpush

@section('content')
<div class="section-header" style="text-align: center; margin-bottom: 40px">
  <div class="section-tag" style="background: var(--primary); margin: 0 auto 10px auto;">Online Booking</div>
  <h2 style="font-family: 'Fredoka One', cursive; font-size: 2.2rem; color: var(--dark); margin: 5px 0 10px 0;">Beli Tiket Masuk</h2>
  <p style="color: #7a828a;">Pilih tiket dan tanggal kunjungan Anda dengan mudah & cepat.</p>
</div>

@if(isset($member) && $member->diskon > 0)
<div style="background:linear-gradient(135deg,#e0fdfc,#fff8f0); border:2px solid #4ECDC4; border-radius:16px; padding:16px 20px; margin-bottom:28px; display:flex; align-items:center; gap:14px">
  <span style="font-size:2rem">🏷️</span>
  <div>
    <div style="font-family:'Fredoka One',cursive; color:var(--dark); font-size:1.1rem">
      Diskon {{ $member->diskon }}% Member {{ $member->tier }} diterapkan!
    </div>
    <div style="font-size:0.88rem; color:#4a5568">Harga tiket sudah termasuk potongan harga eksklusif untuk Anda.</div>
  </div>
</div>
@endif

<form action="{{ route('tiket.store') }}" method="POST" id="bookingForm">
  @csrf
  <div class="booking-grid">
    <!-- LEFT SIDE: Form Inputs & Tickets -->
    <div class="booking-left">
      <!-- Visitor Identity Card -->
      <div class="card">
        <div class="card-title">
          <span class="material-icons" style="color: var(--primary)">person</span>
          Informasi Pengunjung
        </div>
        
        <div class="form-group">
          <label for="nama_pengunjung">Nama Lengkap</label>
          <input type="text" id="nama_pengunjung" name="nama_pengunjung" class="form-control" 
                 placeholder="Masukkan nama lengkap Anda" value="{{ old('nama_pengunjung', $member->nama_lengkap ?? '') }}" required>
        </div>

        <div class="form-grid" style="display:grid; grid-template-columns: 1fr 1fr; gap:20px;">
          <div class="form-group">
            <label for="email_pengunjung">Email</label>
            <input type="email" id="email_pengunjung" name="email_pengunjung" class="form-control" 
                   placeholder="Contoh: nama@email.com" value="{{ old('email_pengunjung', $member->email ?? '') }}" required>
          </div>
          <div class="form-group">
            <label for="telepon_pengunjung">No. WhatsApp</label>
            <input type="tel" id="telepon_pengunjung" name="telepon_pengunjung" class="form-control" 
                   placeholder="Contoh: 081234567890" value="{{ old('telepon_pengunjung', $member->no_telepon ?? '') }}" required>
          </div>
        </div>

        <div class="form-group" style="margin-bottom:0">
          <label for="tanggal_kunjungan">Tanggal Kunjungan</label>
          <input type="date" id="tanggal_kunjungan" name="tanggal_kunjungan" class="form-control" 
                 value="{{ old('tanggal_kunjungan', date('Y-m-d')) }}" min="{{ date('Y-m-d') }}" required>
        </div>
      </div>

      <!-- Ticket Types Card -->
      <div class="card">
        <div class="card-title">
          <span class="material-icons" style="color: var(--secondary)">confirmation_number</span>
          Pilih Jenis Tiket
        </div>

        <div class="ticket-select-list">
          @forelse($tiket as $row)
          <div class="ticket-select-item" data-id="{{ $row->id_tiket }}" data-nama="{{ $row->jenis_tiket }}" data-harga="{{ $row->harga }}">
            <div class="ticket-info">
              <h4>{{ $row->jenis_tiket }}</h4>
              @if($row->deskripsi)
              <p>{{ $row->deskripsi }}</p>
              @endif
              <span class="ticket-price">Rp {{ number_format($row->harga, 0, ',', '.') }}</span>
            </div>
            
            <div class="stepper">
              <button type="button" class="stepper-btn btn-minus">–</button>
              <input type="number" name="tiket_qty[{{ $row->id_tiket }}]" class="stepper-input" 
                     value="{{ old('tiket_qty.' . $row->id_tiket, 0) }}" min="0" max="50" readonly>
              <button type="button" class="stepper-btn btn-plus">+</button>
            </div>
          </div>
          @empty
          <div class="empty-tickets">
            <span class="material-icons" style="font-size:3rem; opacity:0.3">info</span>
            <p>Maaf, informasi tiket saat ini tidak tersedia. Silakan hubungi pengelola.</p>
          </div>
          @endforelse
        </div>
      </div>
    </div>

    <!-- RIGHT SIDE: Summary sticky card -->
    <div class="booking-right">
      <div class="summary-card">
        <h3>Ringkasan Pembelian</h3>
        
        <div id="summary-items-list" style="margin-bottom: 20px; max-height:220px; overflow-y:auto;">
          <!-- Items will be populated via JS -->
          <div style="text-align: center; opacity: 0.6; padding: 20px 0;">Belum ada tiket yang dipilih</div>
        </div>

        <div class="summary-item">
          <span>Tanggal Kunjungan:</span>
          <strong id="summary-visit-date">-</strong>
        </div>

        <div class="summary-total">
          <span class="summary-total-label">Total Pembayaran</span>
          <span class="summary-total-price" id="summary-total-price">Rp 0</span>
        </div>

        <button type="submit" class="btn btn-submit-booking btn-block">
          <span class="material-icons">payment</span>
          Lanjutkan Pembayaran
        </button>
      </div>
    </div>
  </div>
</form>
@endsection

@push('scripts')
<script>
  document.addEventListener('DOMContentLoaded', function() {
    const ticketItems = document.querySelectorAll('.ticket-select-item');
    const summaryItemsList = document.getElementById('summary-items-list');
    const summaryTotalPrice = document.getElementById('summary-total-price');
    const summaryVisitDate = document.getElementById('summary-visit-date');
    const visitDateInput = document.getElementById('tanggal_kunjungan');

    // Format Rupiah
    function formatRupiah(number) {
      return 'Rp ' + new Intl.NumberFormat('id-ID').format(number);
    }

    // Format Date (d M Y)
    function formatDate(dateStr) {
      if (!dateStr) return '-';
      const options = { year: 'numeric', month: 'long', day: 'numeric' };
      return new Date(dateStr).toLocaleDateString('id-ID', options);
    }

    // Update Date Display
    function updateDateDisplay() {
      summaryVisitDate.textContent = formatDate(visitDateInput.value);
    }
    visitDateInput.addEventListener('change', updateDateDisplay);
    updateDateDisplay();

    // Update Summary Logic
    function updateSummary() {
      let total = 0;
      let html = '';
      let hasItems = false;

      ticketItems.forEach(item => {
        const id = item.dataset.id;
        const name = item.dataset.nama;
        const price = parseFloat(item.dataset.harga);
        const qtyInput = item.querySelector('.stepper-input');
        const qty = parseInt(qtyInput.value);

        if (qty > 0) {
          hasItems = true;
          const subtotal = price * qty;
          total += subtotal;
          html += `
            <div class="summary-item" style="border-bottom:1px solid rgba(255,255,255,0.08); padding-bottom:8px; margin-bottom:8px">
              <span>${name} <strong style="color:var(--accent)">x${qty}</strong></span>
              <strong>${formatRupiah(subtotal)}</strong>
            </div>
          `;
        }
      });

      if (!hasItems) {
        summaryItemsList.innerHTML = '<div style="text-align: center; opacity: 0.6; padding: 20px 0;">Belum ada tiket yang dipilih</div>';
        summaryTotalPrice.textContent = 'Rp 0';
      } else {
        summaryItemsList.innerHTML = html;
        summaryTotalPrice.textContent = formatRupiah(total);
      }
    }

    // Handle Stepper Clicks
    ticketItems.forEach(item => {
      const btnMinus = item.querySelector('.btn-minus');
      const btnPlus = item.querySelector('.btn-plus');
      const qtyInput = item.querySelector('.stepper-input');

      btnMinus.addEventListener('click', function() {
        let val = parseInt(qtyInput.value);
        if (val > 0) {
          qtyInput.value = val - 1;
          updateSummary();
        }
      });

      btnPlus.addEventListener('click', function() {
        let val = parseInt(qtyInput.value);
        if (val < 50) {
          qtyInput.value = val + 1;
          updateSummary();
        }
      });
    });

    // Run once on load (to handle back navigation / old values)
    updateSummary();
  });
</script>
@endpush
