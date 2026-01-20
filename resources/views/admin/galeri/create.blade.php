@extends('layouts.admin')

@section('title', 'Tambah Galeri - PPID Admin')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Tambah Galeri</h1>
</div>

<form action="{{ route('admin.galeri.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="mb-3">
        <label for="judul" class="form-label">Judul <span class="text-danger">*</span></label>
        <input type="text" class="form-control @error('judul') is-invalid @enderror" id="judul" name="judul" value="{{ old('judul') }}" required>
        @error('judul')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-3">
        <label for="deskripsi" class="form-label">Deskripsi</label>
        <textarea class="form-control @error('deskripsi') is-invalid @enderror" id="deskripsi" name="deskripsi" rows="3">{{ old('deskripsi') }}</textarea>
        @error('deskripsi')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-3">
        <label for="gambar" class="form-label">Gambar <span class="text-danger">*</span></label>
        <input type="file" 
               class="form-control @error('gambar') is-invalid @enderror" 
               id="gambar" 
               name="gambar" 
               accept=".png,image/png" 
               required>
        <div class="form-text">
            <i class="bi bi-info-circle"></i> Hanya file PNG yang diperbolehkan. Maksimal 2MB.
        </div>
        @error('gambar')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-3 form-check">
        <input type="checkbox" class="form-check-input" id="is_active" name="is_active" {{ old('is_active') ? 'checked' : '' }}>
        <label class="form-check-label" for="is_active">Aktif</label>
    </div>

    <button type="submit" class="btn btn-primary">Simpan</button>
    <a href="{{ route('admin.galeri.index') }}" class="btn btn-secondary">Batal</a>
</form>

<script>
// Validasi file PNG di sisi client
document.getElementById('gambar').addEventListener('change', function(e) {
    const file = e.target.files[0];
    
    if (file) {
        // Cek ekstensi file
        const fileName = file.name.toLowerCase();
        const fileExtension = fileName.split('.').pop();
        
        // Cek tipe MIME
        const fileType = file.type;
        
        if (fileExtension !== 'png' || fileType !== 'image/png') {
            alert('Hanya file PNG yang diperbolehkan!');
            e.target.value = ''; // Reset input
            return false;
        }
        
        // Cek ukuran file (maksimal 2MB)
        const maxSize = 2 * 1024 * 1024; // 2MB dalam bytes
        if (file.size > maxSize) {
            alert('Ukuran file maksimal 2MB!');
            e.target.value = ''; // Reset input
            return false;
        }
    }
});
</script>
@endsection