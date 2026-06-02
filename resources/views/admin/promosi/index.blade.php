@extends('layouts.admin')

@section('title', 'Kelola Promosi')
@section('page_title', 'Kelola Promosi')
@section('page_subtitle', 'Tambah, ubah, dan hapus promosi & event')

@section('content')
<div class="card">
  <div class="card-header">
    <h3>{{ $edit_data ? 'Edit Promosi' : 'Tambah Promosi' }}</h3>
  </div>
  <div class="card-body">
    @if($edit_data)
    <form method="POST" action="{{ route('admin.promosi.update', $edit_data->id_promosi) }}">
      @csrf @method('PUT')
    @else
    <form method="POST" action="{{ route('admin.promosi.store') }}">
      @csrf
    @endif

      <div class="form-group">
        <label>Judul Promosi <span style="color:red">*</span></label>
        <input type="text" name="judul_promosi" class="form-control"
               placeholder="contoh: Promo Liburan Sekolah"
               value="{{ old('judul_promosi', $edit_data->judul_promosi ?? '') }}" required>
      </div>

      <div class="form-group">
        <label>Deskripsi Promosi</label>
        <textarea name="deskripsi" class="form-control" rows="4"
                  placeholder="Detail promosi...">{{ old('deskripsi', $edit_data->deskripsi ?? '') }}</textarea>
      </div>

      <div class="form-grid-2">
        <div class="form-group">
          <label>Tanggal Mulai <span style="color:red">*</span></label>
          <input type="date" name="tanggal_mulai" class="form-control"
                 value="{{ old('tanggal_mulai', $edit_data->tanggal_mulai?->format('Y-m-d') ?? '') }}" required>
        </div>
        <div class="form-group">
          <label>Tanggal Selesai <span style="color:red">*</span></label>
          <input type="date" name="tanggal_selesai" class="form-control"
                 value="{{ old('tanggal_selesai', $edit_data->tanggal_selesai?->format('Y-m-d') ?? '') }}" required>
        </div>
      </div>

      <div style="display: flex; gap: 12px;">
        <button type="submit" class="btn btn-primary">
          <span class="material-icons" style="font-size:1rem">{{ $edit_data ? 'save' : 'add' }}</span>
          {{ $edit_data ? 'Simpan Perubahan' : 'Tambah Promosi' }}
        </button>
        @if($edit_data)
        <a href="{{ route('admin.promosi.index') }}" class="btn btn-outline">Batal</a>
        @endif
      </div>
    </form>
  </div>
</div>

<div class="card" style="margin-top: 24px">
  <div class="card-header"><h3>Daftar Promosi</h3></div>
  <div class="card-body" style="padding: 0">
    <div class="table-responsive">
      <table>
        <thead>
          <tr><th>#</th><th>Judul Promosi</th><th>Tgl Mulai</th><th>Tgl Selesai</th><th>Status</th><th>Aksi</th></tr>
        </thead>
        <tbody>
          @forelse($data as $i => $row)
          <tr>
            <td>{{ $i + 1 }}</td>
            <td><strong>{{ $row->judul_promosi }}</strong><br>
              <small style="color:var(--text-light)">{{ Str::limit($row->deskripsi ?? '', 50) }}</small></td>
            <td>{{ $row->tanggal_mulai->format('d M Y') }}</td>
            <td>{{ $row->tanggal_selesai->format('d M Y') }}</td>
            <td><span class="badge {{ $row->isAktif() ? 'badge-success' : 'badge-danger' }}">{{ $row->isAktif() ? '🔥 Aktif' : 'Berakhir' }}</span></td>
            <td>
              <div style="display: flex; gap: 8px">
                <a href="{{ route('admin.promosi.edit', $row->id_promosi) }}" class="btn btn-warning btn-sm">
                  <span class="material-icons" style="font-size:0.9rem">edit</span> Edit
                </a>
                <button class="btn btn-danger btn-sm" onclick="confirmDelete({{ $row->id_promosi }}, '{{ addslashes($row->judul_promosi) }}')">
                  <span class="material-icons" style="font-size:0.9rem">delete</span> Hapus
                </button>
              </div>
            </td>
          </tr>
          @empty
          <tr><td colspan="6"><div class="empty-state"><span class="material-icons">local_offer</span><p>Belum ada promosi.</p></div></td></tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>
</div>

<div class="modal-overlay" id="deleteModal">
  <div class="modal">
    <span class="material-icons" style="font-size: 3rem; color: var(--danger); margin-bottom: 12px; display: block">delete_forever</span>
    <h3>Hapus Promosi?</h3>
    <p id="deleteMsg">Yakin ingin menghapus promosi ini?</p>
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
  document.getElementById('deleteMsg').textContent = 'Yakin ingin menghapus promosi "' + nama + '"?';
  document.getElementById('deleteForm').action = '/admin/promosi/' + id;
  document.getElementById('deleteModal').classList.add('open');
}
function closeModal() { document.getElementById('deleteModal').classList.remove('open'); }
</script>
@endpush
