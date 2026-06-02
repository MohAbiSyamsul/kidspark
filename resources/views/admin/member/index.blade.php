@extends('layouts.admin')

@section('title', 'Kelola Member')
@section('page_title', 'Kelola Member')
@section('page_subtitle', 'Manajemen akun member Kids Park')

@section('content')
{{-- Stats Row --}}
<div style="display:grid; grid-template-columns:repeat(auto-fit,minmax(140px,1fr)); gap:16px; margin-bottom:24px">
  @php
    $statItems = [
      ['label'=>'Total Member','val'=>$stats['total'],'icon'=>'groups','color'=>'#4361ee','bg'=>'#eef2ff'],
      ['label'=>'Aktif','val'=>$stats['active'],'icon'=>'check_circle','color'=>'#0ca678','bg'=>'#e6fcf5'],
      ['label'=>'🥉 Bronze','val'=>$stats['bronze'],'icon'=>null,'color'=>'#a0522d','bg'=>'#fdf0e6'],
      ['label'=>'🥈 Silver','val'=>$stats['silver'],'icon'=>null,'color'=>'#616161','bg'=>'#f5f5f5'],
      ['label'=>'🥇 Gold','val'=>$stats['gold'],'icon'=>null,'color'=>'#e65c00','bg'=>'#fffde7'],
      ['label'=>'💎 Platinum','val'=>$stats['platinum'],'icon'=>null,'color'=>'#00bcd4','bg'=>'#e0fdfc'],
    ];
  @endphp
  @foreach($statItems as $s)
  <div style="background:#fff; border-radius:16px; padding:18px 16px; text-align:center;
              box-shadow:0 2px 12px rgba(0,0,0,0.04); border:1px solid #f0f2f5">
    <div style="font-family:'Fredoka One',cursive; font-size:1.8rem; color:{{ $s['color'] }}">{{ $s['val'] }}</div>
    <div style="font-size:0.8rem; color:#8a94a6; margin-top:2px">{{ $s['label'] }}</div>
  </div>
  @endforeach
</div>

{{-- Toolbar --}}
<div style="display:flex; gap:12px; align-items:center; margin-bottom:20px; flex-wrap:wrap">
  <form method="GET" style="display:flex; gap:8px; flex:1; flex-wrap:wrap">
    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama, email, no. member..."
           class="form-control" style="max-width:300px; min-width:200px">
    <select name="tier" class="form-control" style="max-width:160px">
      <option value="">Semua Tier</option>
      @foreach(['Bronze','Silver','Gold','Platinum'] as $t)
        <option value="{{ $t }}" {{ request('tier') === $t ? 'selected' : '' }}>{{ $t }}</option>
      @endforeach
    </select>
    <button type="submit" class="btn btn-primary">
      <span class="material-icons">search</span> Cari
    </button>
    @if(request()->anyFilled(['search','tier']))
      <a href="{{ route('admin.member.index') }}" class="btn" style="background:#f0f2f5; color:var(--text)">Reset</a>
    @endif
  </form>
  <a href="{{ route('admin.member.create') }}" class="btn btn-primary">
    <span class="material-icons">person_add</span> Tambah Member
  </a>
</div>

{{-- Table --}}
<div class="table-card">
  <div style="overflow-x:auto">
    <table class="data-table">
      <thead>
        <tr>
          <th>Member</th>
          <th>No. Member</th>
          <th>Tier</th>
          <th>Kunjungan</th>
          <th>Total Belanja</th>
          <th>Status</th>
          <th>Bergabung</th>
          <th>Aksi</th>
        </tr>
      </thead>
      <tbody>
        @forelse($members as $m)
        @php
          $tierColors = ['Bronze'=>['color'=>'#a0522d','bg'=>'#fdf0e6','icon'=>'🥉'],
                         'Silver'=>['color'=>'#616161','bg'=>'#f5f5f5','icon'=>'🥈'],
                         'Gold'  =>['color'=>'#e65c00','bg'=>'#fffde7','icon'=>'🥇'],
                         'Platinum'=>['color'=>'#00bcd4','bg'=>'#e0fdfc','icon'=>'💎']];
          $tc = $tierColors[$m->tier] ?? $tierColors['Bronze'];
        @endphp
        <tr>
          <td>
            <div style="display:flex; align-items:center; gap:10px">
              <div style="width:38px; height:38px; border-radius:50%;
                          background:linear-gradient(135deg,var(--primary),var(--secondary));
                          display:flex; align-items:center; justify-content:center;
                          color:#fff; font-weight:800; font-size:0.95rem; flex-shrink:0">
                {{ strtoupper(substr($m->nama_lengkap, 0, 1)) }}
              </div>
              <div>
                <div style="font-weight:700; color:var(--text)">{{ $m->nama_lengkap }}</div>
                <div style="font-size:0.82rem; color:#8a94a6">{{ $m->email }}</div>
              </div>
            </div>
          </td>
          <td><code style="background:#f0f2f5; padding:3px 8px; border-radius:6px; font-size:0.82rem">{{ $m->no_member }}</code></td>
          <td>
            <span style="display:inline-flex; align-items:center; gap:4px; padding:4px 10px; border-radius:20px;
                         background:{{ $tc['bg'] }}; color:{{ $tc['color'] }}; font-weight:700; font-size:0.82rem">
              {{ $tc['icon'] }} {{ $m->tier }}
            </span>
          </td>
          <td style="text-align:center; font-weight:700">{{ $m->total_kunjungan }}</td>
          <td>Rp {{ number_format($m->total_belanja, 0, ',', '.') }}</td>
          <td>
            @if($m->is_active)
              <span style="background:#e6fcf5; color:#0ca678; padding:4px 10px; border-radius:20px; font-size:0.8rem; font-weight:700">✅ Aktif</span>
            @else
              <span style="background:#fff5f5; color:#e03131; padding:4px 10px; border-radius:20px; font-size:0.8rem; font-weight:700">❌ Nonaktif</span>
            @endif
          </td>
          <td style="font-size:0.85rem; color:#8a94a6">{{ $m->created_at->format('d M Y') }}</td>
          <td>
            <div style="display:flex; gap:6px">
              <a href="{{ route('admin.member.show', $m->id_member) }}"
                 class="btn-action" title="Detail" style="color:#4361ee">
                <span class="material-icons">visibility</span>
              </a>
              <a href="{{ route('admin.member.edit', $m->id_member) }}"
                 class="btn-action" title="Edit" style="color:#0ca678">
                <span class="material-icons">edit</span>
              </a>
              <form method="POST" action="{{ route('admin.member.toggle', $m->id_member) }}" style="margin:0">
                @csrf
                <button type="submit" class="btn-action" title="{{ $m->is_active ? 'Nonaktifkan' : 'Aktifkan' }}"
                        style="color:{{ $m->is_active ? '#e67700' : '#0ca678' }}; background:none; border:none; cursor:pointer; padding:0">
                  <span class="material-icons">{{ $m->is_active ? 'block' : 'check_circle' }}</span>
                </button>
              </form>
              <form method="POST" action="{{ route('admin.member.destroy', $m->id_member) }}" style="margin:0"
                    onsubmit="return confirm('Hapus member {{ $m->nama_lengkap }}?')">
                @csrf @method('DELETE')
                <button type="submit" class="btn-action" title="Hapus"
                        style="color:#e03131; background:none; border:none; cursor:pointer; padding:0">
                  <span class="material-icons">delete</span>
                </button>
              </form>
            </div>
          </td>
        </tr>
        @empty
        <tr>
          <td colspan="8" style="text-align:center; padding:40px; color:#8a94a6">
            <span class="material-icons" style="font-size:3rem; opacity:0.3; display:block; margin-bottom:8px">group_off</span>
            Belum ada member terdaftar.
          </td>
        </tr>
        @endforelse
      </tbody>
    </table>
  </div>
  @if($members->hasPages())
  <div style="padding:16px 20px; border-top:1px solid #f0f2f5">
    {{ $members->links() }}
  </div>
  @endif
</div>

@push('styles')
<style>
  .btn-action {
    width:32px; height:32px; border-radius:8px;
    display:inline-flex; align-items:center; justify-content:center;
    transition: all 0.2s; text-decoration:none;
    background:#f8f9fa;
  }
  .btn-action:hover { background:#f0f2f5; transform: scale(1.1); }
  .btn-action .material-icons { font-size:1.1rem; }
</style>
@endpush
@endsection
