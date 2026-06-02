@extends('layouts.admin')

@section('title', 'Detail Member')
@section('page_title', 'Detail Member')
@section('page_subtitle', 'Informasi lengkap akun member')

@section('content')
@php
  $tierColors = [
    'Bronze'  => ['color'=>'#a0522d','bg'=>'#fdf0e6','icon'=>'🥉'],
    'Silver'  => ['color'=>'#616161','bg'=>'#f5f5f5','icon'=>'🥈'],
    'Gold'    => ['color'=>'#e65c00','bg'=>'#fffde7','icon'=>'🥇'],
    'Platinum'=> ['color'=>'#00bcd4','bg'=>'#e0fdfc','icon'=>'💎'],
  ];
  $tc = $tierColors[$member->tier] ?? $tierColors['Bronze'];
@endphp

<div style="display:grid; grid-template-columns:340px 1fr; gap:24px; align-items:start">
  {{-- Profile Card --}}
  <div class="table-card" style="padding:28px; text-align:center">
    <div style="width:80px; height:80px; border-radius:50%;
                background:linear-gradient(135deg,var(--primary),var(--secondary));
                display:flex; align-items:center; justify-content:center;
                font-size:2.2rem; font-weight:900; color:#fff; margin:0 auto 16px">
      {{ strtoupper(substr($member->nama_lengkap, 0, 1)) }}
    </div>
    <h3 style="font-family:'Fredoka One',cursive; font-size:1.4rem; margin:0 0 4px">{{ $member->nama_lengkap }}</h3>
    <p style="color:#8a94a6; margin:0 0 16px; font-size:0.9rem">{{ $member->email }}</p>

    <div style="display:inline-flex; align-items:center; gap:6px; padding:6px 16px; border-radius:20px; font-weight:800; font-size:1rem; margin-bottom:16px;
                background:{{ $tc['bg'] }}; color:{{ $tc['color'] }}">
      {{ $tc['icon'] }} {{ $member->tier }}
    </div>

    <div style="background:#f8f9fa; border-radius:12px; padding:16px; text-align:left; margin-bottom:16px">
      <div style="font-size:0.85rem; color:#8a94a6; margin-bottom:6px">No. Member</div>
      <code style="font-weight:700; color:var(--text)">{{ $member->no_member }}</code>
    </div>

    @if($member->no_telepon)
    <div style="margin-bottom:16px; font-size:0.9rem; color:#8a94a6">
      📱 {{ $member->no_telepon }}
    </div>
    @endif

    <div style="margin-bottom:16px">
      @if($member->is_active)
        <span style="background:#e6fcf5; color:#0ca678; padding:5px 14px; border-radius:20px; font-size:0.85rem; font-weight:700">✅ Akun Aktif</span>
      @else
        <span style="background:#fff5f5; color:#e03131; padding:5px 14px; border-radius:20px; font-size:0.85rem; font-weight:700">❌ Nonaktif</span>
      @endif
    </div>

    <div style="font-size:0.82rem; color:#b0bac9; margin-bottom:20px">
      Bergabung: {{ $member->created_at->format('d M Y') }}
    </div>

    <div style="display:flex; gap:8px; justify-content:center; flex-wrap:wrap">
      <a href="{{ route('admin.member.edit', $member->id_member) }}" class="btn btn-primary" style="flex:1">
        <span class="material-icons">edit</span> Edit
      </a>
      <form method="POST" action="{{ route('admin.member.toggle', $member->id_member) }}" style="flex:1">
        @csrf
        <button type="submit" class="btn" style="width:100%; background:{{ $member->is_active ? '#fff9db' : '#e6fcf5' }}; color:{{ $member->is_active ? '#e67700' : '#0ca678' }}">
          <span class="material-icons">{{ $member->is_active ? 'block' : 'check_circle' }}</span>
          {{ $member->is_active ? 'Nonaktifkan' : 'Aktifkan' }}
        </button>
      </form>
    </div>
    <a href="{{ route('admin.member.index') }}" class="btn" style="width:100%; margin-top:8px; background:#f0f2f5; color:var(--text)">
      ← Kembali
    </a>
  </div>

  {{-- Stats + Orders --}}
  <div>
    {{-- Stats --}}
    <div style="display:grid; grid-template-columns:repeat(3,1fr); gap:16px; margin-bottom:24px">
      @php
        $memberStats = [
          ['label'=>'Total Kunjungan','val'=>$member->total_kunjungan,'color'=>'#4361ee','bg'=>'#eef2ff','icon'=>'🎫'],
          ['label'=>'Total Belanja','val'=>'Rp '.number_format($member->total_belanja,0,',','.'),'color'=>'#0ca678','bg'=>'#e6fcf5','icon'=>'💰'],
          ['label'=>'Diskon Aktif','val'=>$member->diskon.'%','color'=>'#e65c00','bg'=>'#fff9db','icon'=>'🏷️'],
        ];
      @endphp
      @foreach($memberStats as $s)
      <div style="background:#fff; border-radius:14px; padding:18px; text-align:center;
                  box-shadow:0 2px 12px rgba(0,0,0,0.04); border:1px solid #f0f2f5">
        <div style="font-size:1.8rem">{{ $s['icon'] }}</div>
        <div style="font-family:'Fredoka One',cursive; font-size:1.5rem; color:{{ $s['color'] }}; margin:4px 0 2px">{{ $s['val'] }}</div>
        <div style="font-size:0.78rem; color:#8a94a6">{{ $s['label'] }}</div>
      </div>
      @endforeach
    </div>

    {{-- Progress --}}
    @php $progress = $member->tier_progress; @endphp
    @if($progress['next'])
    <div class="table-card" style="padding:20px; margin-bottom:24px">
      <div style="font-weight:700; margin-bottom:8px">
        Progress ke tier <strong style="color:{{ $tc['color'] }}">{{ $progress['next'] }}</strong>
        — {{ $progress['remaining'] }} kunjungan lagi
      </div>
      <div style="background:#f0f2f5; border-radius:50px; height:10px; overflow:hidden">
        <div style="width:{{ $progress['percent'] }}%; height:100%; border-radius:50px;
                    background:linear-gradient(90deg,var(--primary),var(--secondary)); transition:width 1s"></div>
      </div>
    </div>
    @endif

    {{-- Order History --}}
    <div class="table-card">
      <div style="padding:20px 20px 0; font-family:'Fredoka One',cursive; font-size:1.2rem; color:var(--text)">
        📋 Riwayat Pesanan ({{ $pesanan->total() }})
      </div>
      <div style="overflow-x:auto; padding:16px 20px">
        @if($pesanan->isEmpty())
          <div style="text-align:center; padding:24px; color:#8a94a6">
            Belum ada riwayat pesanan.
          </div>
        @else
          <table style="width:100%; border-collapse:collapse">
            <thead>
              <tr style="font-size:0.8rem; color:#8a94a6; border-bottom:2px solid #f0f2f5">
                <th style="padding:8px 12px; text-align:left">Kode</th>
                <th style="padding:8px 12px; text-align:left">Tanggal</th>
                <th style="padding:8px 12px; text-align:left">Total</th>
                <th style="padding:8px 12px; text-align:left">Status</th>
              </tr>
            </thead>
            <tbody>
              @foreach($pesanan as $p)
              <tr style="border-bottom:1px solid #f8f9fa">
                <td style="padding:10px 12px; font-size:0.88rem">
                  <a href="{{ route('admin.pesanan.show', $p->id_pesanan) }}" style="color:var(--primary); font-weight:600">
                    {{ $p->kode_booking }}
                  </a>
                </td>
                <td style="padding:10px 12px; font-size:0.85rem; color:#8a94a6">
                  {{ \Carbon\Carbon::parse($p->tanggal_kunjungan)->format('d M Y') }}
                </td>
                <td style="padding:10px 12px; font-size:0.88rem">
                  Rp {{ number_format($p->total_bayar, 0, ',', '.') }}
                </td>
                <td style="padding:10px 12px">
                  @if($p->status_pembayaran === 'lunas')
                    <span style="background:#e6fcf5; color:#0ca678; padding:3px 10px; border-radius:20px; font-size:0.78rem; font-weight:700">✅ Lunas</span>
                  @elseif($p->status_pembayaran === 'menunggu_konfirmasi')
                    <span style="background:#fff9db; color:#e67700; padding:3px 10px; border-radius:20px; font-size:0.78rem; font-weight:700">⏳ Menunggu</span>
                  @elseif($p->status_pembayaran === 'pending')
                    <span style="background:#e7f5ff; color:#1971c2; padding:3px 10px; border-radius:20px; font-size:0.78rem; font-weight:700">🔄 Pending</span>
                  @else
                    <span style="background:#fff5f5; color:#e03131; padding:3px 10px; border-radius:20px; font-size:0.78rem; font-weight:700">❌ Batal</span>
                  @endif
                </td>
              </tr>
              @endforeach
            </tbody>
          </table>
          <div style="margin-top:16px">{{ $pesanan->links() }}</div>
        @endif
      </div>
    </div>
  </div>
</div>
@endsection
