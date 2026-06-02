@extends('layouts.admin')

@section('title', 'Edit Member')
@section('page_title', 'Edit Member')
@section('page_subtitle', 'Ubah data member')

@section('content')
<div style="max-width:640px">
  <div class="table-card" style="padding:32px">
    <form action="{{ route('admin.member.update', $member->id_member) }}" method="POST">
      @csrf @method('PUT')

      <div style="display:grid; grid-template-columns:1fr 1fr; gap:20px">
        <div class="form-group" style="grid-column:1/-1">
          <label>No. Member</label>
          <input type="text" class="form-control" value="{{ $member->no_member }}" disabled
                 style="background:#f8f9fa; color:#8a94a6">
        </div>

        <div class="form-group" style="grid-column:1/-1">
          <label>Nama Lengkap <span style="color:red">*</span></label>
          <input type="text" name="nama_lengkap" class="form-control"
                 value="{{ old('nama_lengkap', $member->nama_lengkap) }}" required>
        </div>

        <div class="form-group">
          <label>Email <span style="color:red">*</span></label>
          <input type="email" name="email" class="form-control"
                 value="{{ old('email', $member->email) }}" required>
        </div>

        <div class="form-group">
          <label>No. WhatsApp</label>
          <input type="tel" name="no_telepon" class="form-control"
                 value="{{ old('no_telepon', $member->no_telepon) }}" placeholder="081234567890">
        </div>

        <div class="form-group">
          <label>Total Kunjungan <span style="color:red">*</span></label>
          <input type="number" name="total_kunjungan" class="form-control"
                 value="{{ old('total_kunjungan', $member->total_kunjungan) }}" min="0" required>
          <small style="color:#8a94a6">Tier otomatis terupdate</small>
        </div>

        <div class="form-group">
          <label>Status Akun</label>
          <select name="is_active" class="form-control">
            <option value="1" {{ old('is_active', $member->is_active ? '1' : '0') == '1' ? 'selected' : '' }}>✅ Aktif</option>
            <option value="0" {{ old('is_active', $member->is_active ? '1' : '0') == '0' ? 'selected' : '' }}>❌ Nonaktif</option>
          </select>
        </div>

        <div class="form-group" style="grid-column:1/-1">
          <label>Password Baru <span style="color:#8a94a6; font-weight:400">(kosongkan jika tidak diubah)</span></label>
          <input type="password" name="password" class="form-control" placeholder="Minimal 6 karakter">
        </div>

        <div class="form-group" style="grid-column:1/-1">
          <label>Konfirmasi Password Baru</label>
          <input type="password" name="password_confirmation" class="form-control" placeholder="Ulangi password baru">
        </div>
      </div>

      {{-- Tier Preview --}}
      <div id="tier-preview" style="background:#f8f9fa; border-radius:12px; padding:16px; margin-bottom:20px; display:flex; align-items:center; gap:12px">
        <div id="tier-icon" style="font-size:2rem"></div>
        <div>
          <div style="font-weight:700; color:var(--text)" id="tier-name"></div>
          <div style="font-size:0.82rem; color:#8a94a6" id="tier-desc"></div>
        </div>
      </div>

      <div style="display:flex; gap:12px">
        <button type="submit" class="btn btn-primary">
          <span class="material-icons">save</span> Simpan Perubahan
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
    { min: 0,  name: 'Bronze',   icon: '🥉', color: '#a0522d', desc: '0–4 kunjungan · Tanpa diskon' },
    { min: 5,  name: 'Silver',   icon: '🥈', color: '#616161', desc: '5–14 kunjungan · Diskon 5%' },
    { min: 15, name: 'Gold',     icon: '🥇', color: '#e65c00', desc: '15–29 kunjungan · Diskon 10%' },
    { min: 30, name: 'Platinum', icon: '💎', color: '#00bcd4', desc: '30+ kunjungan · Diskon 15%' },
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
