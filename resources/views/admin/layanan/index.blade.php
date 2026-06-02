@extends('layouts.admin')

@section('title', 'Kelola Layanan')
@section('page_title', 'Kelola Layanan')
@section('page_subtitle', 'Tambah, ubah, dan hapus layanan Kids Park')

@section('content')
<div class="card">
  <div class="card-header">
    <h3>{{ $edit_data ? 'Edit Layanan' : 'Tambah Layanan' }}</h3>
  </div>
  <div class="card-body">
    @if($edit_data)
    <form method="POST" action="{{ route('admin.layanan.update', $edit_data->id_layanan) }}" enctype="multipart/form-data">
      @csrf @method('PUT')
    @else
    <form method="POST" action="{{ route('admin.layanan.store') }}" enctype="multipart/form-data">
      @csrf
    @endif

      <div class="form-grid-2">
        <div class="form-group">
          <label>Nama Layanan <span style="color:red">*</span></label>
          <input type="text" name="nama_layanan" class="form-control"
                 placeholder="contoh: Kolam Renang"
                 value="{{ old('nama_layanan', $edit_data->nama_layanan ?? '') }}" required>
        </div>
        <div class="form-group">
          <label>Icon</label>
          <select name="icon" class="form-control">
            @php
              $icons = ['water'=>'🏊 Kolam Renang','play_arrow'=>'🎪 Playground','star'=>'⭐ Bintang','park'=>'🌿 Taman','local_cafe'=>'🍦 Café','sports'=>'⚽ Olahraga'];
            @endphp
            @foreach($icons as $val => $label)
            <option value="{{ $val }}" {{ ($edit_data->icon ?? 'star') === $val ? 'selected' : '' }}>{{ $label }}</option>
            @endforeach
          </select>
        </div>
      </div>

      <div class="form-grid-2">
        <div class="form-group">
          <label>Gambar Layanan</label>
          <input type="file" name="gambar" class="form-control" accept="image/*">
          <span style="font-size:0.75rem; color:var(--text-light)">Format: JPG, JPEG, PNG, WEBP (Max 5MB)</span>
        </div>
        @if($edit_data && $edit_data->gambar)
        <div class="form-group">
          <label>Gambar Saat Ini</label>
          <div>
            <img src="{{ asset('storage/uploads/' . $edit_data->gambar) }}" class="img-preview" alt="Layanan" style="border: 1px solid var(--border)">
          </div>
        </div>
        @endif
      </div>

      <div class="form-group">
        <label>Deskripsi</label>
        <textarea name="deskripsi" class="form-control" rows="3"
                  placeholder="Deskripsi layanan...">{{ old('deskripsi', $edit_data->deskripsi ?? '') }}</textarea>
      </div>

      <div style="display: flex; gap: 12px;">
        <button type="submit" class="btn btn-primary">
          <span class="material-icons" style="font-size:1rem">{{ $edit_data ? 'save' : 'add' }}</span>
          {{ $edit_data ? 'Simpan Perubahan' : 'Tambah Layanan' }}
        </button>
        @if($edit_data)
        <a href="{{ route('admin.layanan.index') }}" class="btn btn-outline">Batal</a>
        @endif
      </div>
    </form>
  </div>
</div>

<div class="card" style="margin-top: 24px">
  <div class="card-header">
    <h3>Daftar Layanan</h3>
    <span style="font-size: 0.85rem; color: var(--text-light); font-weight: 700;">Total: {{ $data->count() }} layanan</span>
  </div>
  <div class="card-body" style="padding: 0">
    <div class="table-responsive">
      <table>
        <thead>
          <tr>
            <th>#</th>
            <th>Gambar</th>
            <th>Nama Layanan</th>
            <th>Deskripsi</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody>
          @forelse($data as $i => $row)
          <tr>
            <td>{{ $i + 1 }}</td>
            <td>
              @if($row->gambar)
                <img src="{{ asset('storage/uploads/' . $row->gambar) }}" class="img-preview" alt="{{ $row->nama_layanan }}" style="border: 1px solid var(--border)">
              @else
                <div style="width:100px; height:60px; background:#f0f2f5; border-radius:8px; display:flex; align-items:center; justify-content:center; color:#adb5bd; font-size:1.5rem">
                  🖼️
                </div>
              @endif
            </td>
            <td><strong>{{ $row->nama_layanan }}</strong></td>
            <td style="max-width: 300px; color: var(--text-light)">{{ Str::limit($row->deskripsi ?? '', 120) }}</td>
            <td>
              <div style="display: flex; gap: 8px">
                <a href="{{ route('admin.layanan.edit', $row->id_layanan) }}" class="btn btn-warning btn-sm">
                  <span class="material-icons" style="font-size:0.9rem">edit</span> Edit
                </a>
                <button class="btn btn-danger btn-sm" onclick="confirmDelete({{ $row->id_layanan }}, '{{ addslashes($row->nama_layanan) }}')">
                  <span class="material-icons" style="font-size:0.9rem">delete</span> Hapus
                </button>
              </div>
            </td>
          </tr>
          @empty
          <tr><td colspan="5">
            <div class="empty-state">
              <span class="material-icons">water</span>
              <p>Belum ada layanan. Tambahkan di atas.</p>
            </div>
          </td></tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>
</div>

<!-- Modal Hapus -->
<div class="modal-overlay" id="deleteModal">
  <div class="modal">
    <span class="material-icons" style="font-size: 3rem; color: var(--danger); margin-bottom: 12px; display: block">delete_forever</span>
    <h3>Hapus Layanan?</h3>
    <p id="deleteMsg">Yakin ingin menghapus layanan ini?</p>
    <form method="POST" id="deleteForm">
      @csrf @method('DELETE')
      <div class="modal-btns">
        <button type="button" class="btn btn-outline" onclick="closeModal()">Batal</button>
        <button type="submit" class="btn btn-danger">Ya, Hapus</button>
      </div>
    </form>
  </div>
</div>
@endsection

@push('scripts')
<script>
function confirmDelete(id, nama) {
  document.getElementById('deleteMsg').textContent = 'Yakin ingin menghapus layanan "' + nama + '"?';
  document.getElementById('deleteForm').action = '/admin/layanan/' + id;
  document.getElementById('deleteModal').classList.add('open');
}
function closeModal() { document.getElementById('deleteModal').classList.remove('open'); }
</script>
@endpush
