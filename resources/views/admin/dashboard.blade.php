@extends('layouts.admin')

@section('title', 'Dashboard')
@section('page_title', 'Dashboard')
@section('page_subtitle', 'Selamat datang di panel admin')

@section('content')
<div class="stats-grid">
  @php
    $stats = [
      ['icon'=>'water',               'value'=>$total_layanan, 'label'=>'Layanan',     'color'=>'var(--primary)',              'route'=>'admin.layanan.index'],
      ['icon'=>'confirmation_number', 'value'=>$total_tiket,   'label'=>'Jenis Tiket', 'color'=>'var(--secondary)',            'route'=>'admin.tiket.index'],
      ['icon'=>'local_offer',         'value'=>$total_promosi, 'label'=>'Promosi',     'color'=>'var(--purple, #9B59B6)',      'route'=>'admin.promosi.index'],
      ['icon'=>'photo_library',       'value'=>$total_galeri,  'label'=>'Foto Galeri', 'color'=>'var(--blue, #45B7D1)',        'route'=>'admin.galeri.index'],
      ['icon'=>'payments',            'value'=>'Rp ' . number_format($revenue, 0, ',', '.'), 'label'=>'Pendapatan Tiket', 'color'=>'#2ecc71', 'route'=>'admin.pesanan.index'],
      ['icon'=>'check_circle',        'value'=>$validated_today, 'label'=>'Pengunjung Hari Ini', 'color'=>'#f1c40f', 'route'=>'admin.pesanan.validasi'],
      ['icon'=>'hourglass_empty',     'value'=>$pending_confirmation, 'label'=>'Perlu Verifikasi', 'color'=>'#e74c3c', 'route'=>'admin.pesanan.index'],
    ];
  @endphp
  @foreach($stats as $stat)
  <a href="{{ route($stat['route']) }}" style="text-decoration:none">
    <div class="stat-card">
      <div class="stat-icon" style="background: linear-gradient(135deg, {{ $stat['color'] }}, {{ $stat['color'] }}aa)">
        <span class="material-icons">{{ $stat['icon'] }}</span>
      </div>
      <div class="stat-info">
        <h3>{{ $stat['value'] }}</h3>
        <p>{{ $stat['label'] }}</p>
      </div>
    </div>
  </a>
  @endforeach
</div>

@if($promo_aktif > 0)
<div class="alert alert-success" style="margin-bottom: 24px;">
  <span class="material-icons">local_offer</span>
  Ada <strong>{{ $promo_aktif }} promosi</strong> yang sedang aktif saat ini.
</div>
@endif

<div class="card">
  <div class="card-header">
    <h3>Promosi Terbaru</h3>
    <a href="{{ route('admin.promosi.index') }}" class="btn btn-outline btn-sm">
      <span class="material-icons" style="font-size:1rem">arrow_forward</span> Lihat Semua
    </a>
  </div>
  <div class="card-body" style="padding: 0">
    <div class="table-responsive">
      <table>
        <thead>
          <tr><th>#</th><th>Judul Promosi</th><th>Tanggal Mulai</th><th>Tanggal Selesai</th><th>Status</th></tr>
        </thead>
        <tbody>
          @forelse($recent_promosi as $i => $row)
          <tr>
            <td>{{ $i + 1 }}</td>
            <td><strong>{{ $row->judul_promosi }}</strong></td>
            <td>{{ $row->tanggal_mulai->format('d M Y') }}</td>
            <td>{{ $row->tanggal_selesai->format('d M Y') }}</td>
            <td>
              <span class="badge {{ $row->isAktif() ? 'badge-success' : 'badge-danger' }}">
                {{ $row->isAktif() ? 'Aktif' : 'Berakhir' }}
              </span>
            </td>
          </tr>
          @empty
          <tr><td colspan="5"><div class="empty-state"><span class="material-icons">local_offer</span><p>Belum ada promosi.</p></div></td></tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>
</div>
@endsection
