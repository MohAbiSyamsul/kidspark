@extends('layouts.admin')

@section('title', 'Kelola Harga Tiket')
@section('page_title', 'Kelola Harga Tiket')
@section('page_subtitle', 'Tambah, ubah, dan hapus harga tiket')

@section('content')
<div class="card">
  <div class="card-header">
    <h3>{{ $edit_data ? 'Edit Tiket' : 'Tambah Tiket' }}</h3>
  </div>
  <div class="card-body">
    @if($edit_data)
    <form method="POST" action="{{ route('admin.tiket.update', $edit_data->id_tiket) }}">
      @csrf @method('PUT')
    @else
    <form method="POST" action="{{ route('admin.tiket.store') }}">
      @csrf
    @endif

      <div class="form-grid-2">
        <div class="form-group">
          <label>Jenis Tiket <span style="color:red">*</span></label>
          <input type="text" name="jenis_tiket" class="form-control"
                 placeholder="contoh: Tiket Anak (Weekday)"
                 value="{{ old('jenis_tiket', $edit_data->jenis_tiket ?? '') }}" required>
        </div>
        <div class="form-group">
          <label>Harga (Rp) <span style="color:red">*</span></label>
          <input type="number" name="harga" class="form-control"
                 placeholder="contoh: 30000" min="0" step="1000"
                 value="{{ old('harga', $edit_data->harga ?? '') }}" required>
        </div>
      </div>

      <div class="form-group">
        <label>Keterangan</label>
        <textarea name="deskripsi" class="form-control" rows="2"
                  placeholder="Keterangan tiket...">{{ old('deskripsi', $edit_data->deskripsi ?? '') }}</textarea>
      </div>

      <div style="display: flex; gap: 12px;">
        <button type="submit" class="btn btn-primary">
          <span class="material-icons" style="font-size:1rem">{{ $edit_data ? 'save' : 'add' }}</span>
          {{ $edit_data ? 'Simpan Perubahan' : 'Tambah Tiket' }}
        </button>
        @if($edit_data)
        <a href="{{ route('admin.tiket.index') }}" class="btn btn-outline">Batal</a>
        @endif
      </div>
    </form>
  </div>
</div>

<div class="card" style="margin-top: 24px">
  <div class="card-header">
    <h3>Daftar Harga Tiket</h3>
  </div>
  <div class="card-body" style="padding: 0">
    <div class="table-responsive">
      <table>
        <thead>
          <tr><th>#</th><th>Jenis Tiket</th><th>Harga</th><th>Keterangan</th><th>Aksi</th></tr>
        </thead>
        <tbody>
          @forelse($data as $i => $row)
          <tr>
            <td>{{ $i + 1 }}</td>
            <td><strong>{{ $row->jenis_tiket }}</strong></td>
            <td><span style="font-weight: 800; color: var(--primary)">{{ formatRupiah($row->harga) }}</span></td>
            <td style="color: var(--text-light)">{{ $row->deskripsi ?? '-' }}</td>
            <td>
              <div style="display: flex; gap: 8px">
                <a href="{{ route('admin.tiket.edit', $row->id_tiket) }}" class="btn btn-warning btn-sm">
                  <span class="material-icons" style="font-size:0.9rem">edit</span> Edit
                </a>
                <button class="btn btn-danger btn-sm" onclick="confirmDelete({{ $row->id_tiket }}, '{{ addslashes($row->jenis_tiket) }}')">
                  <span class="material-icons" style="font-size:0.9rem">delete</span> Hapus
                </button>
              </div>
            </td>
          </tr>
          @empty
          <tr><td colspan="5"><div class="empty-state"><span class="material-icons">confirmation_number</span><p>Belum ada data tiket.</p></div></td></tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>
</div>

<div class="modal-overlay" id="deleteModal">
  <div class="modal">
    <span class="material-icons" style="font-size: 3rem; color: var(--danger); margin-bottom: 12px; display: block">delete_forever</span>
    <h3>Hapus Tiket?</h3>
    <p id="deleteMsg">Yakin ingin menghapus tiket ini?</p>
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
  document.getElementById('deleteMsg').textContent = 'Yakin ingin menghapus tiket "' + nama + '"?';
  document.getElementById('deleteForm').action = '/admin/tiket/' + id;
  document.getElementById('deleteModal').classList.add('open');
}
function closeModal() { document.getElementById('deleteModal').classList.remove('open'); }
</script>
@endpush
