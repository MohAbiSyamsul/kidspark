@extends('layouts.app')

@section('title', 'Dashboard Member - Kids Park')

@push('styles')
<style>
  .member-hero {
    background: linear-gradient(135deg, var(--dark) 0%, #16213e 100%);
    border-radius: 24px;
    padding: 36px 40px;
    color: #fff;
    margin-bottom: 30px;
    display: flex;
    align-items: center;
    gap: 30px;
    position: relative;
    overflow: hidden;
  }
  .member-hero::before {
    content: '🎡';
    position: absolute;
    right: 30px;
    top: 50%;
    transform: translateY(-50%);
    font-size: 8rem;
    opacity: 0.06;
  }
  .member-avatar {
    width: 80px; height: 80px;
    border-radius: 50%;
    background: linear-gradient(135deg, var(--primary), var(--secondary));
    display: flex; align-items: center; justify-content: center;
    font-size: 2rem; font-weight: 900; color: #fff;
    flex-shrink: 0;
    box-shadow: 0 8px 24px rgba(255,107,53,0.4);
  }
  .member-hero-info h2 {
    font-family: 'Fredoka One', cursive;
    font-size: 1.7rem; margin: 0 0 4px; color: #fff;
  }
  .member-hero-info p { margin: 0; opacity: 0.7; font-size: 0.9rem; }
  .tier-badge-big {
    display: inline-flex; align-items: center; gap: 6px;
    padding: 6px 16px; border-radius: 30px;
    font-weight: 800; font-size: 0.95rem;
    margin-top: 10px;
  }
  .tier-progress-wrap {
    margin-top: 14px;
    background: rgba(255,255,255,0.1);
    border-radius: 50px;
    height: 8px;
    overflow: hidden;
  }
  .tier-progress-bar {
    height: 100%;
    border-radius: 50px;
    background: linear-gradient(90deg, var(--primary), var(--accent));
    transition: width 1s ease;
  }
  .tier-progress-label {
    font-size: 0.78rem; opacity: 0.65; margin-top: 6px;
  }

  /* Stats Grid */
  .stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(160px, 1fr));
    gap: 20px;
    margin-bottom: 30px;
  }
  .stat-card {
    background: #fff;
    border-radius: 18px;
    padding: 22px 20px;
    text-align: center;
    box-shadow: 0 4px 20px rgba(0,0,0,0.04);
    border: 1px solid #f0f2f5;
  }
  .stat-icon {
    width: 48px; height: 48px;
    border-radius: 14px;
    display: flex; align-items: center; justify-content: center;
    margin: 0 auto 12px;
    font-size: 1.4rem;
  }
  .stat-card h3 {
    font-family: 'Fredoka One', cursive;
    font-size: 2rem; margin: 0 0 4px; color: var(--dark);
  }
  .stat-card p { margin: 0; color: #8a94a6; font-size: 0.85rem; }

  /* Recent Orders */
  .orders-table { width: 100%; border-collapse: collapse; }
  .orders-table th {
    text-align: left; padding: 12px 16px;
    font-size: 0.8rem; text-transform: uppercase;
    letter-spacing: 0.05em; color: #8a94a6;
    border-bottom: 2px solid #f0f2f5;
  }
  .orders-table td {
    padding: 14px 16px;
    border-bottom: 1px solid #f8f9fa;
    font-size: 0.92rem;
    vertical-align: middle;
  }
  .orders-table tr:last-child td { border-bottom: none; }
  .badge {
    padding: 4px 12px; border-radius: 20px;
    font-size: 0.78rem; font-weight: 700;
    display: inline-block;
  }
  .badge-success { background: #e6fcf5; color: #0ca678; }
  .badge-warning { background: #fff9db; color: #e67700; }
  .badge-info    { background: #e7f5ff; color: #1971c2; }
  .badge-danger  { background: #fff5f5; color: #e03131; }
  .section-label {
    font-family: 'Fredoka One', cursive;
    font-size: 1.3rem; color: var(--dark);
    margin: 0 0 16px;
    display: flex; align-items: center; gap: 8px;
  }
  .quick-links {
    display: flex; gap: 12px; flex-wrap: wrap; margin-bottom: 30px;
  }
  .quick-link {
    display: inline-flex; align-items: center; gap: 8px;
    padding: 12px 20px; border-radius: 12px;
    font-weight: 700; font-size: 0.92rem;
    text-decoration: none; transition: all 0.3s;
    border: 2px solid transparent;
  }
  .quick-link-primary {
    background: linear-gradient(135deg, var(--primary), #ff8255);
    color: #fff;
    box-shadow: 0 4px 14px rgba(255,107,53,0.3);
  }
  .quick-link-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(255,107,53,0.4);
  }
  .quick-link-outline {
    border-color: var(--secondary);
    color: var(--secondary);
    background: #fff;
  }
  .quick-link-outline:hover {
    background: var(--secondary);
    color: #fff;
  }
</style>
@endpush

@section('content')
{{-- Hero + Member Info --}}
<div class="member-hero">
  <div class="member-avatar">
    {{ strtoupper(substr($member->nama_lengkap, 0, 1)) }}
  </div>
  <div class="member-hero-info" style="flex:1">
    <p>Selamat datang,</p>
    <h2>{{ $member->nama_lengkap }}</h2>
    <p>{{ $member->no_member }}</p>

    @php
      $tierColors = [
        'Bronze'   => ['bg' => '#fdf0e6', 'color' => '#a0522d', 'icon' => '🥉'],
        'Silver'   => ['bg' => '#f5f5f5', 'color' => '#757575', 'icon' => '🥈'],
        'Gold'     => ['bg' => 'rgba(255,215,0,0.2)', 'color' => '#e65c00', 'icon' => '🥇'],
        'Platinum' => ['bg' => 'rgba(78,205,196,0.2)', 'color' => '#00bcd4', 'icon' => '💎'],
      ];
      $tc = $tierColors[$member->tier] ?? $tierColors['Bronze'];
      $progress = $member->tier_progress;
    @endphp

    <div class="tier-badge-big" style="background: {{ $tc['bg'] }}; color: {{ $tc['color'] }}">
      {{ $tc['icon'] }} Member {{ $member->tier }}
      @if($member->diskon > 0)
        · Diskon {{ $member->diskon }}%
      @endif
    </div>

    @if($progress['next'])
      <div class="tier-progress-wrap">
        <div class="tier-progress-bar" style="width: {{ $progress['percent'] }}%"></div>
      </div>
      <div class="tier-progress-label">
        {{ $progress['remaining'] }} kunjungan lagi untuk naik ke {{ $progress['next'] }}
      </div>
    @else
      <div class="tier-progress-label" style="margin-top:6px">
        🎉 Anda telah mencapai tier tertinggi — Platinum!
      </div>
    @endif
  </div>
</div>

{{-- Quick Links --}}
<div class="quick-links">
  <a href="{{ route('tiket.beli') }}" class="quick-link quick-link-primary">
    <span class="material-icons">confirmation_number</span> Beli Tiket
  </a>
  <a href="{{ route('member.riwayat') }}" class="quick-link quick-link-outline">
    <span class="material-icons">history</span> Riwayat Pembelian
  </a>
  <a href="{{ route('member.profil') }}" class="quick-link quick-link-outline">
    <span class="material-icons">manage_accounts</span> Edit Profil
  </a>
</div>

{{-- Stats --}}
<div class="stats-grid">
  <div class="stat-card">
    <div class="stat-icon" style="background:#fff3ef">🎟️</div>
    <h3>{{ $member->total_kunjungan }}</h3>
    <p>Total Kunjungan</p>
  </div>
  <div class="stat-card">
    <div class="stat-icon" style="background:#e7f5ff">💳</div>
    <h3>{{ $totalTransaksi }}</h3>
    <p>Transaksi Lunas</p>
  </div>
  <div class="stat-card">
    <div class="stat-icon" style="background:#f0fffe">💰</div>
    <h3 style="font-size:1.4rem">Rp {{ number_format($member->total_belanja, 0, ',', '.') }}</h3>
    <p>Total Belanja</p>
  </div>
  <div class="stat-card">
    <div class="stat-icon" style="background:#fff9db">🏷️</div>
    <h3>{{ $member->diskon }}%</h3>
    <p>Diskon Aktif</p>
  </div>
</div>

{{-- Recent Orders --}}
<div class="card">
  <div class="card-title">
    <span class="material-icons" style="color: var(--primary)">receipt_long</span>
    Pesanan Terakhir
    <a href="{{ route('member.riwayat') }}" style="margin-left:auto; font-size:0.85rem; color: var(--primary); font-family: inherit; font-weight:600;">Lihat semua →</a>
  </div>

  @if($pesanan->isEmpty())
    <div style="text-align:center; padding: 30px 0; color: #8a94a6">
      <span class="material-icons" style="font-size:3rem; opacity:0.3">inbox</span>
      <p>Belum ada pesanan. <a href="{{ route('tiket.beli') }}" style="color:var(--primary)">Beli tiket sekarang!</a></p>
    </div>
  @else
    <div style="overflow-x: auto">
      <table class="orders-table">
        <thead>
          <tr>
            <th>Kode Booking</th>
            <th>Tanggal Kunjungan</th>
            <th>Total</th>
            <th>Status</th>
            <th></th>
          </tr>
        </thead>
        <tbody>
          @foreach($pesanan as $p)
          <tr>
            <td><strong>{{ $p->kode_booking }}</strong></td>
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
              <a href="{{ route('tiket.status', $p->kode_booking) }}" style="color:var(--primary); font-weight:600; font-size:0.85rem;">Detail</a>
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  @endif
</div>

{{-- Tier Guide --}}
<div class="card" style="margin-top:0">
  <div class="card-title">
    <span class="material-icons" style="color: var(--secondary)">emoji_events</span>
    Panduan Tier Member
  </div>
  @php
    $tiers = [
      ['name'=>'Bronze','icon'=>'🥉','color'=>'#a0522d','bg'=>'#fdf0e6','min'=>0,'max'=>4,'disc'=>0],
      ['name'=>'Silver','icon'=>'🥈','color'=>'#616161','bg'=>'#f5f5f5','min'=>5,'max'=>14,'disc'=>5],
      ['name'=>'Gold','icon'=>'🥇','color'=>'#e65c00','bg'=>'#fffde7','min'=>15,'max'=>29,'disc'=>10],
      ['name'=>'Platinum','icon'=>'💎','color'=>'#00bcd4','bg'=>'#e0fdfc','min'=>30,'max'=>null,'disc'=>15],
    ];
  @endphp
  <div style="display:grid; grid-template-columns: repeat(auto-fit, minmax(180px,1fr)); gap:12px;">
    @foreach($tiers as $t)
    <div style="background:{{ $t['bg'] }}; border-radius:14px; padding:18px; text-align:center;
                {{ $member->tier === $t['name'] ? 'outline: 3px solid ' . $t['color'] . ';' : '' }}">
      <div style="font-size:2rem">{{ $t['icon'] }}</div>
      <div style="font-family:'Fredoka One',cursive; color:{{ $t['color'] }}; font-size:1.1rem; margin:6px 0 2px">
        {{ $t['name'] }}
        @if($member->tier === $t['name']) <span style="font-size:0.7rem">(Anda)</span> @endif
      </div>
      <div style="font-size:0.82rem; color:#616161; margin-bottom:4px">
        {{ $t['max'] ? $t['min'] . '–' . $t['max'] : $t['min'] . '+' }} kunjungan
      </div>
      <div style="font-weight:800; color:{{ $t['color'] }}">
        {{ $t['disc'] > 0 ? 'Diskon ' . $t['disc'] . '%' : 'Tanpa diskon' }}
      </div>
    </div>
    @endforeach
  </div>
</div>
@endsection
