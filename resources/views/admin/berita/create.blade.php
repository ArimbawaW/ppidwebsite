@extends('layouts.admin')

@section('title', 'Tambah Berita - PPID Admin')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Tambah Berita</h1>
</div>

{{-- Notifikasi Error Global --}}
@if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <strong>Gagal!</strong> {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<form action="{{ route('admin.berita.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    
    <div class="mb-3">
        <label for="judul" class="form-label">Judul <span class="text-danger">*</span></label>
        <input type="text" class="form-control @error('judul') is-invalid @enderror" id="judul" name="judul" value="{{ old('judul') }}" required>
        @error('judul')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-3">
        <label for="kategori" class="form-label">Kategori <span class="text-danger">*</span></label>
        <select class="form-select @error('kategori') is-invalid @enderror" id="kategori" name="kategori" required>
            <option value="berita" {{ old('kategori') == 'berita' ? 'selected' : '' }}>Berita</option>
            <option value="artikel" {{ old('kategori') == 'artikel' ? 'selected' : '' }}>Artikel</option>
            <option value="pengumuman" {{ old('kategori') == 'pengumuman' ? 'selected' : '' }}>Pengumuman</option>
        </select>
        @error('kategori')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-3">
        <label for="gambar" class="form-label">Gambar</label>
        <input type="file" class="form-control @error('gambar') is-invalid @enderror" id="gambar" name="gambar" accept="image/jpeg,image/png,image/jpg">
       <label for="gambar" class="form-label">(Format: JPG, JPEG, PNG | Max: 2MB)</label>
        <div id="gambar-js-error" class="invalid-feedback" style="display: none;"></div>
        @error('gambar')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-3">
        <label for="konten" class="form-label">Konten <span class="text-danger">*</span></label>
        <textarea class="form-control @error('konten') is-invalid @enderror" id="konten" name="konten" rows="10">{{ old('konten') }}</textarea>
        @error('konten')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-3 form-check">
        <input type="checkbox" class="form-check-input" id="is_published" name="is_published" {{ old('is_published') ? 'checked' : '' }}>
        <label class="form-check-label" for="is_published">Publish</label>
    </div>

    <button type="submit" class="btn btn-primary" id="btnSubmit">
        <span id="submitBtnSpinner" class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
        <span id="submitBtnText">Simpan</span>
    </button>
    <a href="{{ route('admin.berita.index') }}" class="btn btn-secondary">Batal</a>
</form>
@endsection

@push('scripts')
<script src="https://cdn.ckeditor.com/ckeditor5/43.0.0/classic/ckeditor.js"></script>
<script>
    // Inisialisasi CKEditor
    ClassicEditor
        .create(document.querySelector('#konten'))
        .catch(error => {
            console.error(error);
        });
    
    // Validasi Gambar Client-side (Feedback Instan)
    const gambarInput = document.getElementById('gambar');
    const gambarError = document.getElementById('gambar-js-error');

    gambarInput.addEventListener('change', function() {
        const file = this.files[0];
        const allowedTypes = ['image/jpeg', 'image/jpg', 'image/png'];
        
        if (file) {
            // Cek tipe file
            if (!allowedTypes.includes(file.type)) {
                gambarError.textContent = 'Format gambar tidak sesuai! Gunakan JPG, JPEG, atau PNG.';
                gambarError.style.display = 'block';
                this.classList.add('is-invalid');
                this.value = ''; // Reset input
                return;
            }
            // Cek ukuran (2MB)
            if (file.size > 2 * 1024 * 1024) {
                gambarError.textContent = 'Ukuran gambar terlalu besar! Maksimal 2MB.';
                gambarError.style.display = 'block';
                this.classList.add('is-invalid');
                this.value = ''; // Reset input
                return;
            }
            
            // Jika valid
            gambarError.style.display = 'none';
            this.classList.remove('is-invalid');
            this.classList.add('is-valid');
        }
    });

    // Handle Button Loading saat Submit
    document.querySelector('form').addEventListener('submit', function() {
        const btn = document.getElementById('btnSubmit');
        const btnText = document.getElementById('submitBtnText');
        const btnSpinner = document.getElementById('submitBtnSpinner');
        
        btn.disabled = true;
        btnText.textContent = 'Menyimpan...';
        btnSpinner.classList.remove('d-none');
    });
</script>
@endpush