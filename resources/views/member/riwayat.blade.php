@extends('layouts.app')

@section('title', 'Riwayat Pembelian - Kids Park')

@push('styles')
<style>
  .badge { padding: 4px 12px; border-radius: 20px; font-size: 0.78rem; font-weight: 700; display: inline-block; }
  .badge-success { background: #e6fcf5; color: #0ca678; }
  .badge-warning { background: #fff9db; color: #e67700; }
  .badge-info    { background: #e7f5ff; color: #1971c2; }
  .badge-danger  { background: #fff5f5; color: #e03131; }
  .orders-table { width: 100%; border-collapse: collapse; }
  .orders-table th {
    text-align: left; padding: 12px 16px;
    font-size: 0.8rem; text-transform: uppercase;
    letter-spacing: 0.05em; color: #8a94a6;
    border-bottom: 2px solid #f0f2f5;
  }
  .orders-table td {
    padding: 14px 16px; border-bottom: 1px solid #f8f9fa;
    font-size: 0.92rem; vertical-align: middle;
  }
  .orders-table tr:last-child td { border-bottom: none; }
</style>
@endpush

@section('content')
<div class="section-header" style="display:flex; align-items:center; justify-content:space-between; margin-bottom:24px">
  <div>
    <h2 style="font-family:'Fredoka One',cursive; font-size:1.8rem; color:var(--dark); margin:0 0 4px">
      Riwayat Pembelian
    </h2>
    <p style="color:#8a94a6; margin:0">Semua transaksi tiket Anda</p>
  </div>
  <a href="{{ route('member.dashboard') }}" class="btn" style="background:#f0f2f5; color:var(--dark)">
    <span class="material-icons">arrow_back</span> Dashboard
  </a>
</div>

<div class="card">
  @if($pesanan->isEmpty())
    <div style="text-align:center; padding:40px 0; color:#8a94a6">
      <span class="material-icons" style="font-size:3.5rem; opacity:0.3">receipt_long</span>
      <p style="margin-top:12px">Belum ada riwayat pembelian.<br>
        <a href="{{ route('tiket.beli') }}" style="color:var(--primary); font-weight:700">Beli tiket sekarang →</a>
      </p>
    </div>
  @else
    <div style="overflow-x:auto">
      <table class="orders-table">
        <thead>
          <tr>
            <th>Kode Booking</th>
            <th>Tanggal Pesan</th>
            <th>Tanggal Kunjungan</th>
            <th>Total</th>
            <th>Pembayaran</th>
            <th>Kunjungan</th>
            <th></th>
          </tr>
        </thead>
        <tbody>
          @foreach($pesanan as $p)
          <tr>
            <td><strong>{{ $p->kode_booking }}</strong></td>
            <td>{{ $p->created_at->format('d M Y') }}</td>
            <td>{{ \Carbon\Carbon::parse($p->tanggal_kunjungan)->format('d M Y') }}</td>
            <td>Rp {{ number_format($p->total_bayar, 0, ',', '.') }}</td>
            <td>
              @if($p->status_pembayaran === 'lunas')
                <span class="badge badge-success">✅ Lunas</span>
              @elseif($p->status_pembayaran === 'menunggu_konfirmasi')
                <span class="badge badge-warning">⏳ Menunggu</span>
              @elseif($p->status_pembayaran === 'pending')
                <span class="badge badge-info">🔄 Pending</span>
              @else
                <span class="badge badge-danger">❌ Batal</span>
              @endif
            </td>
            <td>
              @if($p->status_kunjungan === 'sudah_hadir')
                <span class="badge badge-success">✅ Hadir</span>
              @else
                <span class="badge" style="background:#f8f9fa; color:#868e96">🔄 Belum</span>
              @endif
            </td>
            <td>
              <a href="{{ route('tiket.status', $p->kode_booking) }}"
                 style="color:var(--primary); font-weight:600; font-size:0.85rem;">
                Detail
              </a>
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
    <div style="margin-top:20px">
      {{ $pesanan->links() }}
    </div>
  @endif
</div>
@endsection
