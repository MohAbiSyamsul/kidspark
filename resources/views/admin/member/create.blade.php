@extends('layouts.admin')

@section('title', 'Tambah Member Baru')
@section('page_title', 'Tambah Member')
@section('page_subtitle', 'Buat akun member baru')

@section('content')
<div style="max-width:640px">
  <div class="table-card" style="padding:32px">
    <form action="{{ route('admin.member.store') }}" method="POST">
      @csrf

      <div style="display:grid; grid-template-columns:1fr 1fr; gap:20px">
        <div class="form-group" style="grid-column:1/-1">
          <label>Nama Lengkap <span style="color:red">*</span></label>
          <input type="text" name="nama_lengkap" class="form-control"
                 value="{{ old('nama_lengkap') }}" placeholder="Nama lengkap member" required autofocus>
        </div>

        <div class="form-group">
          <label>Email <span style="color:red">*</span></label>
          <input type="email" name="email" class="form-control"
                 value="{{ old('email') }}" placeholder="email@contoh.com" required>
        </div>

        <div class="form-group">
          <label>No. WhatsApp</label>
          <input type="tel" name="no_telepon" class="form-control"
                 value="{{ old('no_telepon') }}" placeholder="081234567890">
        </div>

        <div class="form-group">
          <label>Password <span style="color:red">*</span></label>
          <input type="password" name="password" class="form-control" placeholder="Minimal 6 karakter" required>
        </div>

        <div class="form-group">
          <label>Konfirmasi Password <span style="color:red">*</span></label>
          <input type="password" name="password_confirmation" class="form-control" placeholder="Ulangi password" required>
        </div>

        <div class="form-group">
          <label>Total Kunjungan Awal</label>
          <input type="number" name="total_kunjungan" class="form-control"
                 value="{{ old('total_kunjungan', 0) }}" min="0" placeholder="0">
          <small style="color:#8a94a6">Tier akan otomatis dihitung berdasarkan kunjungan</small>
        </div>

        <div class="form-group">
          <label>Status Akun</label>
          <select name="is_active" class="form-control">
            <option value="1" {{ old('is_active', '1') == '1' ? 'selected' : '' }}>✅ Aktif</option>
            <option value="0" {{ old('is_active') == '0' ? 'selected' : '' }}>❌ Nonaktif</option>
          </select>
        </div>
      </div>

      {{-- Tier Preview --}}
      <div id="tier-preview" style="background:#f8f9fa; border-radius:12px; padding:16px; margin-bottom:20px; display:flex; align-items:center; gap:12px">
        <div id="tier-icon" style="font-size:2rem">🥉</div>
        <div>
          <div style="font-weight:700; color:var(--text)" id="tier-name">Tier: Bronze</div>
          <div style="font-size:0.82rem; color:#8a94a6" id="tier-desc">0–4 kunjungan · Tanpa diskon</div>
        </div>
      </div>

      <div style="display:flex; gap:12px">
        <button type="submit" class="btn btn-primary">
          <span class="material-icons">person_add</span> Buat Member
        </button>
        <a href="{{ route('admin.member.index') }}" class="btn" style="background:#f0f2f5; color:var(--text)">
          Batal
        </a>
      </div>
    </form>
  </div>
</div>

@push('scripts')
<script>
  const kunjunganInput = document.querySelector('[name="total_kunjungan"]');
  const tiers = [
    { min: 0,  max: 4,   name: 'Bronze',   icon: '🥉', color: '#a0522d', desc: '0–4 kunjungan · Tanpa diskon' },
    { min: 5,  max: 14,  name: 'Silver',   icon: '🥈', color: '#616161', desc: '5–14 kunjungan · Diskon 5%' },
    { min: 15, max: 29,  name: 'Gold',     icon: '🥇', color: '#e65c00', desc: '15–29 kunjungan · Diskon 10%' },
    { min: 30, max: 9999,name: 'Platinum', icon: '💎', color: '#00bcd4', desc: '30+ kunjungan · Diskon 15%' },
  ];

  function computeTier(v) {
    for (let i = tiers.length - 1; i >= 0; i--) {
      if (v >= tiers[i].min) return tiers[i];
    }
    return tiers[0];
  }

  function updatePreview() {
    const v = parseInt(kunjunganInput.value) || 0;
    const t = computeTier(v);
    document.getElementById('tier-icon').textContent = t.icon;
    document.getElementById('tier-name').textContent = 'Tier: ' + t.name;
    document.getElementById('tier-name').style.color = t.color;
    document.getElementById('tier-desc').textContent = t.desc;
  }

  kunjunganInput.addEventListener('input', updatePreview);
  updatePreview();
</script>
@endpush
@endsection
