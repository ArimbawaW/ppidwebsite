@extends('layouts.admin')

@section('title', 'Tambah Berita - PPID Admin')

@push('styles')
<link rel="stylesheet" href="https://cdn.ckeditor.com/ckeditor5/43.0.0/ckeditor5.css">
<style>
    .ck-editor__editable {
        min-height: 400px;
        border-bottom-left-radius: 8px !important;
        border-bottom-right-radius: 8px !important;
    }
    .card {
        border: none;
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.1);
        border-radius: 12px;
    }
    .form-label { font-weight: 600; color: #334155; }
    #image-preview {
        width: 100%;
        height: 200px;
        object-fit: cover;
        display: none;
        border-radius: 8px;
        border: 2px dashed #cbd5e1;
        padding: 5px;
    }
</style>
@endpush

@section('content')
<div class="d-flex justify-content-between align-items-center pt-3 pb-2 mb-4 border-bottom">
    <h1 class="h2">Tambah Berita</h1>
    <a href="{{ route('admin.berita.index') }}" class="btn btn-outline-secondary">
        <i class="bi bi-arrow-left"></i> Kembali
    </a>
</div>

@if($errors->any())
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <strong>Terjadi Kesalahan!</strong>
        <ul class="mb-0">
            @foreach($errors->all() as $error) <li>{{ $error }}</li> @endforeach
        </ul>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<form action="{{ route('admin.berita.store') }}" method="POST" enctype="multipart/form-data" id="formBerita">
    @csrf
    <div class="row">
        {{-- Kolom Kiri: Konten Utama --}}
        <div class="col-lg-8">
            <div class="card mb-4">
                <div class="card-body">
                    <div class="mb-4">
                        <label for="judul" class="form-label">Judul Berita <span class="text-danger">*</span></label>
                        <input type="text"
                               class="form-control form-control-lg @error('judul') is-invalid @enderror"
                               id="judul"
                               name="judul"
                               value="{{ old('judul') }}"
                               placeholder="Masukkan judul berita..."
                               required>
                        @error('judul')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="editor" class="form-label">Konten <span class="text-danger">*</span></label>
                        <textarea id="editor" name="konten" style="display:none;">{{ old('konten') }}</textarea>
                        @error('konten')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
        </div>

        {{-- Kolom Kanan: Pengaturan --}}
        <div class="col-lg-4">
            <div class="card mb-4">
                <div class="card-header bg-white py-3">
                    <h5 class="card-title mb-0">Pengaturan Berita</h5>
                </div>
                <div class="card-body">
                    {{-- Kategori --}}
                    <div class="mb-3">
                        <label class="form-label">Kategori <span class="text-danger">*</span></label>
                        <select class="form-select @error('kategori') is-invalid @enderror" name="kategori" required>
                            <option value="berita" {{ old('kategori') == 'berita' ? 'selected' : '' }}>Berita</option>
                            <option value="artikel" {{ old('kategori') == 'artikel' ? 'selected' : '' }}>Artikel</option>
                            <option value="pengumuman" {{ old('kategori') == 'pengumuman' ? 'selected' : '' }}>Pengumuman</option>
                        </select>
                    </div>

                    {{-- Tanggal Publikasi (Baru Ditambahkan) --}}
                    <div class="mb-3">
                        <label for="published_at" class="form-label">Tanggal Publikasi <span class="text-danger">*</span></label>
                        <input type="datetime-local" 
                               class="form-control @error('published_at') is-invalid @enderror" 
                               id="published_at" 
                               name="published_at" 
                               value="{{ old('published_at', now()->format('Y-m-d\TH:i')) }}" 
                               required>
                        <small class="text-muted">Tentukan kapan berita ini diterbitkan.</small>
                        @error('published_at')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Gambar Utama --}}
                    <div class="mb-3">
                        <label class="form-label">Gambar Utama</label>
                        <div class="text-center mb-2">
                            <img id="image-preview" src="#" alt="Preview">
                        </div>
                        <input type="file"
                               class="form-control @error('gambar') is-invalid @enderror"
                               id="gambar"
                               name="gambar"
                               accept="image/png, image/jpeg, image/jpg">
                        <small class="text-muted">Maksimal 2MB (JPG, PNG)</small>
                    </div>

                    {{-- Status Switch --}}
                    <div class="form-check form-switch mb-4">
                        <input class="form-check-input" type="checkbox" id="is_published" name="is_published" value="1" {{ old('is_published', true) ? 'checked' : '' }}>
                        <label class="form-check-label" for="is_published">Aktifkan Publikasi</label>
                    </div>

                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary btn-lg" id="btnSubmit">
                            <span id="spinner" class="spinner-border spinner-border-sm d-none"></span>
                            <span id="btnText">Simpan Berita</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection

@push('scripts')
<script src="https://cdn.ckeditor.com/ckeditor5/43.0.0/ckeditor5.umd.js"></script>
<script>
    const {
        ClassicEditor, Essentials, Paragraph, Heading, Bold, Italic, Underline, List, Undo, FontSize, FontColor, Alignment
    } = CKEDITOR;

    let myEditor;

    ClassicEditor.create(document.querySelector('#editor'), {
        plugins: [ Essentials, Paragraph, Heading, Bold, Italic, Underline, List, Undo, FontSize, FontColor, Alignment ],
        toolbar: [
            'heading', '|',
            'fontSize', 'fontColor', '|',
            'bold', 'italic', 'underline', '|',
            'alignment', '|',
            'bulletedList', 'numberedList', '|',
            'undo', 'redo'
        ],
        fontSize: {
            options: [ 9, 11, 13, 'default', 17, 19, 21, 24, 30 ],
            supportAllValues: true
        },
        alignment: {
            options: [ 'left', 'center', 'right', 'justify' ]
        }
    })
    .then(editor => { 
        myEditor = editor; 
    })
    .catch(error => { 
        console.error("CKEditor Error: ", error); 
    });

    // Preview Gambar
    document.getElementById('gambar').addEventListener('change', function() {
        const [file] = this.files;
        if (file) {
            const previewImg = document.getElementById('image-preview');
            previewImg.src = URL.createObjectURL(file);
            previewImg.style.display = 'block';
        }
    });

    // Validasi & Sinkronisasi Data
    document.getElementById('formBerita').addEventListener('submit', function(e) {
        if (!myEditor) return;

        const data = myEditor.getData();
        
        if (data.trim() === '' || data === '<p>&nbsp;</p>') {
            alert('Konten berita tidak boleh kosong!');
            e.preventDefault();
            return false;
        }

        // Masukkan data CKEditor ke textarea asli
        document.querySelector('#editor').value = data;

        document.getElementById('btnSubmit').disabled = true;
        document.getElementById('spinner').classList.remove('d-none');
        document.getElementById('btnText').textContent = 'Sedang Menyimpan...';
    });
</script>
@endpush