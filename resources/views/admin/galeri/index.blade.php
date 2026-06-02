@extends('layouts.admin')

@section('title', 'Kelola Galeri')
@section('page_title', 'Kelola Galeri')
@section('page_subtitle', 'Tambah dan hapus foto galeri')

@section('content')
<div class="card">
  <div class="card-header"><h3>Upload Foto Galeri</h3></div>
  <div class="card-body">
    <form method="POST" action="{{ route('admin.galeri.store') }}" enctype="multipart/form-data">
      @csrf
      <div class="form-grid-2">
        <div class="form-group">
          <label>Judul Foto <span style="color:red">*</span></label>
          <input type="text" name="judul_foto" class="form-control"
                 placeholder="contoh: Area Kolam Renang" required>
        </div>
        <div class="form-group">
          <label>File Gambar <span style="color:red">*</span></label>
          <input type="file" name="gambar" class="form-control" accept="image/*" required
                 onchange="previewImg(this)">
          <p class="form-text">Format: JPG, PNG, WEBP. Maks: 5MB</p>
        </div>
      </div>
      <img id="imgPreview" class="img-preview" style="display:none; margin-bottom: 16px">
      <button type="submit" class="btn btn-primary">
        <span class="material-icons" style="font-size:1rem">upload</span>
        Upload Foto
      </button>
    </form>
  </div>
</div>

<div class="card" style="margin-top: 24px">
  <div class="card-header">
    <h3>Foto Galeri</h3>
    <span style="font-size: 0.85rem; color: var(--text-light); font-weight: 700;">Total: {{ $data->count() }} foto</span>
  </div>
  <div class="card-body">
    @if($data->count() > 0)
    <div class="galeri-list">
      @foreach($data as $row)
      <div class="galeri-thumb">
        <img src="{{ asset('storage/uploads/' . $row->gambar) }}" alt="{{ $row->judul_foto }}">
        <div class="galeri-thumb-overlay">
          <span>{{ $row->judul_foto }}</span>
          <button class="btn btn-danger btn-sm"
                  onclick="confirmDelete({{ $row->id_galeri }}, '{{ addslashes($row->judul_foto) }}')">
            <span class="material-icons" style="font-size:0.9rem">delete</span> Hapus
          </button>
        </div>
      </div>
      @endforeach
    </div>
    @else
    <div class="empty-state">
      <span class="material-icons">photo_library</span>
      <p>Belum ada foto di galeri. Upload di atas.</p>
    </div>
    @endif
  </div>
</div>

<div class="modal-overlay" id="deleteModal">
  <div class="modal">
    <span class="material-icons" style="font-size: 3rem; color: var(--danger); margin-bottom: 12px; display: block">delete_forever</span>
    <h3>Hapus Foto?</h3>
    <p id="deleteMsg">Yakin ingin menghapus foto ini?</p>
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
function previewImg(input) {
  const preview = document.getElementById('imgPreview');
  if (input.files && input.files[0]) {
    const reader = new FileReader();
    reader.onload = e => { preview.src = e.target.result; preview.style.display = 'block'; };
    reader.readAsDataURL(input.files[0]);
  }
}
function confirmDelete(id, nama) {
  document.getElementById('deleteMsg').textContent = 'Yakin ingin menghapus foto "' + nama + '"?';
  document.getElementById('deleteForm').action = '/admin/galeri/' + id;
  document.getElementById('deleteModal').classList.add('open');
}
function closeModal() { document.getElementById('deleteModal').classList.remove('open'); }
</script>
@endpush
