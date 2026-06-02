@extends('layouts.admin')

@section('title', 'Pesanan Tiket')
@section('page_title', 'Kelola Pesanan Tiket')
@section('page_subtitle', 'Verifikasi pembayaran dan pantau pemesanan tiket pengunjung')

@push('styles')
<style>
  .filter-tabs {
    display: flex;
    gap: 8px;
    margin-bottom: 20px;
    flex-wrap: wrap;
  }

  .filter-tab {
    padding: 8px 16px;
    border-radius: 20px;
    background: #fff;
    border: 1px solid #dee2e6;
    color: var(--text-light);
    font-weight: 700;
    text-decoration: none;
    font-size: 0.88rem;
    transition: all 0.2s ease;
  }

  .filter-tab:hover {
    background: #f8f9fa;
    border-color: #ced4da;
  }

  .filter-tab.active {
    background: var(--primary);
    color: #fff;
    border-color: var(--primary);
  }

  .status-badge {
    display: inline-block;
    padding: 4px 10px;
    border-radius: 6px;
    font-size: 0.78rem;
    font-weight: 800;
    text-transform: uppercase;
  }

  .badge-pending { background-color: #fff9db; color: #f08c00; }
  .badge-waiting { background-color: #e7f5ff; color: #1971c2; }
  .badge-paid { background-color: #ebfbee; color: #2f9e44; }
  .badge-cancelled { background-color: #fff5f5; color: #e03131; }

  .visit-badge {
    display: inline-block;
    padding: 4px 10px;
    border-radius: 6px;
    font-size: 0.78rem;
    font-weight: 800;
  }

  .badge-not-arrived { background-color: #f1f3f5; color: #495057; }
  .badge-arrived { background-color: #d3f9d8; color: #2b8a3e; }
  
  .search-form {
    display: flex;
    gap: 10px;
    margin-bottom: 20px;
  }

  .search-input {
    flex: 1;
    max-width: 300px;
  }
</style>
@endpush

@section('content')
<div class="card">
  <div class="card-body">
    <!-- Search and Filters Section -->
    <div style="display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:15px; margin-bottom: 10px;">
      <!-- Tabs -->
      <div class="filter-tabs">
        <a href="{{ route('admin.pesanan.index', ['status' => 'all', 'search' => $search]) }}" class="filter-tab {{ $status === 'all' ? 'active' : '' }}">
          Semua
        </a>
        <a href="{{ route('admin.pesanan.index', ['status' => 'pending', 'search' => $search]) }}" class="filter-tab {{ $status === 'pending' ? 'active' : '' }}">
          Pending
        </a>
        <a href="{{ route('admin.pesanan.index', ['status' => 'menunggu_konfirmasi', 'search' => $search]) }}" class="filter-tab {{ $status === 'menunggu_konfirmasi' ? 'active' : '' }}">
          Perlu Verifikasi
        </a>
        <a href="{{ route('admin.pesanan.index', ['status' => 'lunas', 'search' => $search]) }}" class="filter-tab {{ $status === 'lunas' ? 'active' : '' }}">
          Lunas
        </a>
        <a href="{{ route('admin.pesanan.index', ['status' => 'batal', 'search' => $search]) }}" class="filter-tab {{ $status === 'batal' ? 'active' : '' }}">
          Batal
        </a>
      </div>

      <!-- Search Box -->
      <form action="{{ route('admin.pesanan.index') }}" method="GET" class="search-form">
        <input type="hidden" name="status" value="{{ $status }}">
        <input type="text" name="search" class="form-control search-input" placeholder="Cari Kode, Nama, HP..." value="{{ $search }}">
        <button type="submit" class="btn btn-primary" style="padding: 10px 18px">
          <span class="material-icons">search</span>
        </button>
        @if($search)
          <a href="{{ route('admin.pesanan.index', ['status' => $status]) }}" class="btn btn-outline" style="padding: 10px 18px">Reset</a>
        @endif
      </form>
    </div>

    <!-- Data Table -->
    <div class="table-responsive">
      <table>
        <thead>
          <tr>
            <th>Kode Booking</th>
            <th>Pengunjung</th>
            <th>Tanggal Kunjungan</th>
            <th>Total Bayar</th>
            <th>Pembayaran</th>
            <th>Kunjungan</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody>
          @forelse($pesanan as $row)
          <tr>
            <td>
              <a href="{{ route('admin.pesanan.show', $row->id_pesanan) }}" style="font-weight: 800; text-decoration: none; color: var(--blue)">
                {{ $row->kode_booking }}
              </a>
            </td>
            <td>
              <strong style="color:var(--dark)">{{ $row->nama_pengunjung }}</strong>
              <div style="font-size: 0.8rem; color:#868e96">{{ $row->telepon_pengunjung }}</div>
            </td>
            <td>{{ $row->tanggal_kunjungan->format('d M Y') }}</td>
            <td><strong style="color:var(--primary)">Rp {{ number_format($row->total_bayar, 0, ',', '.') }}</strong></td>
            <td>
              <span class="status-badge 
                @if($row->status_pembayaran === 'pending') badge-pending
                @elseif($row->status_pembayaran === 'menunggu_konfirmasi') badge-waiting
                @elseif($row->status_pembayaran === 'lunas') badge-paid
                @elseif($row->status_pembayaran === 'batal') badge-cancelled
                @endif">
                @if($row->status_pembayaran === 'pending') Pending
                @elseif($row->status_pembayaran === 'menunggu_konfirmasi') Verifikasi
                @elseif($row->status_pembayaran === 'lunas') Lunas
                @elseif($row->status_pembayaran === 'batal') Batal
                @endif
              </span>
            </td>
            <td>
              <span class="visit-badge {{ $row->status_kunjungan === 'sudah_hadir' ? 'badge-arrived' : 'badge-not-arrived' }}">
                {{ $row->status_kunjungan === 'sudah_hadir' ? 'Hadir' : 'Belum Hadir' }}
              </span>
            </td>
            <td>
              <a href="{{ route('admin.pesanan.show', $row->id_pesanan) }}" class="btn btn-outline btn-sm">
                <span class="material-icons" style="font-size: 0.95rem">visibility</span> Tinjau
              </a>
            </td>
          </tr>
          @empty
          <tr>
            <td colspan="7">
              <div class="empty-state">
                <span class="material-icons">receipt_long</span>
                <p>Belum ada data pemesanan tiket yang cocok.</p>
              </div>
            </td>
          </tr>
          @endforelse
        </tbody>
      </table>
    </div>

    <!-- Pagination -->
    <div style="margin-top:20px;">
      {{ $pesanan->links() }}
    </div>
  </div>
</div>
@endsection
