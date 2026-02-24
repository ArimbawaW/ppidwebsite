@extends('layouts.admin')

@section('title', 'Tambah Halaman Standar Layanan')

@push('styles')
{{-- Tambahkan CSS CKEditor agar toolbar rapi --}}
<link rel="stylesheet" href="https://cdn.ckeditor.com/ckeditor5/43.0.0/ckeditor5.css">
<style>
    .ck-editor__editable { min-height: 300px; }
    .preview-container { display: none; margin-top: 10px; }
    .preview-container img { max-width: 300px; border: 1px solid #ddd; padding: 5px; border-radius: 8px; }
    .form-label { color: #334155; }
</style>
@endpush

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4 border-bottom pb-3">
        <h1 class="h3 mb-0 text-gray-800">Tambah Halaman Standar Layanan</h1>
        <a href="{{ route('admin.standar-layanan.index') }}" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> Kembali
        </a>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-body p-4">
            <form action="{{ route('admin.standar-layanan.store') }}" method="POST" enctype="multipart/form-data" id="formLayanan">
                @csrf

        

                <div class="row">
                    <div class="col-md-8 mb-4">
                        <label for="nama_layanan" class="form-label fw-bold">Nama Layanan (Judul Halaman) <span class="text-danger">*</span></label>
                        <input type="text" name="nama_layanan" id="nama_layanan" 
                               class="form-control form-control-lg @error('nama_layanan') is-invalid @enderror" 
                               value="{{ old('nama_layanan') }}" required placeholder="Masukkan nama layanan">
                        @error('nama_layanan') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-4 mb-4">
                        <label for="urutan" class="form-label fw-bold">Urutan Tampilan</label>
                        <input type="number" name="urutan" id="urutan" class="form-control form-control-lg" value="{{ old('urutan', 0) }}" min="0">
                    </div>

                    <div class="col-12"><hr class="my-3"></div>

                    <div class="col-md-6 mb-4">
                        <h5 class="text-primary mb-3">Bagian 1 (Atas)</h5>
                        <div class="mb-3">
    <label for="gambar" class="form-label fw-bold">Gambar Utama (Gambar 1)</label>
    <input type="file" name="gambar" id="gambar" class="form-control @error('gambar') is-invalid @enderror" accept="image/*">
    <small class="text-muted d-block mt-1"><i class="bi bi-exclamation-circle"></i> Maksimal ukuran file: <strong>2MB</strong> (Format: JPG, PNG, WEBP)</small>
    <div id="preview1" class="preview-container">
        <img id="previewImg1" src="">
    </div>
</div>
                        
                        <div class="mb-3">
                            <label for="konten" class="form-label fw-bold">Deskripsi/Konten Utama <span class="text-danger">*</span></label>
                            <textarea name="konten" id="editor1" class="@error('konten') is-invalid @enderror">{{ old('konten') }}</textarea>
                            @error('konten') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    <div class="col-md-6 mb-4">
                        <h5 class="text-primary mb-3">Bagian 2 (Bawah)</h5>
                        <div class="mb-3">
    <label for="gambar_2" class="form-label fw-bold">Gambar Kedua (Opsional)</label>
    <input type="file" name="gambar_2" id="gambar_2" class="form-control @error('gambar_2') is-invalid @enderror" accept="image/*">
    <small class="text-muted d-block mt-1"><i class="bi bi-exclamation-circle"></i> Maksimal ukuran file: <strong>2MB</strong> (Format: JPG, PNG, WEBP)</small>
    <div id="preview2" class="preview-container">
        <img id="previewImg2" src="">
    </div>
</div>
                        <div class="mb-3">
                            <label for="deskripsi_2" class="form-label fw-bold">Deskripsi Kedua (Opsional)</label>
                            <textarea name="deskripsi_2" id="editor2">{{ old('deskripsi_2') }}</textarea>
                        </div>
                    </div>

                    <div class="col-12"><hr class="my-3"></div>

                    <div class="col-md-8 mb-4">
                        <label for="file" class="form-label fw-bold">File Lampiran/Pendukung (PDF/DOC)</label>
                        <input type="file" name="file" id="file" class="form-control" accept=".pdf,.doc,.docx">
                        <small class="text-muted">Maksimal 10MB</small>
                    </div>

                    <div class="col-md-4 mb-4 d-flex align-items-center">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" name="is_active" id="is_active" value="1" checked>
                            <label class="form-check-label fw-bold" for="is_active">Aktifkan Halaman</label>
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-end gap-2 mt-4 border-top pt-4">
                    <a href="{{ route('admin.standar-layanan.index') }}" class="btn btn-light px-4">Batal</a>
                    <button type="submit" class="btn btn-primary px-4 shadow-sm" id="btnSubmit">
                        <i class="bi bi-save me-1"></i> Simpan Halaman
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.ckeditor.com/ckeditor5/43.0.0/ckeditor5.umd.js"></script>
<script>
    const { ClassicEditor, Essentials, Paragraph, Heading, Bold, Italic, List, Undo } = CKEDITOR;

    // Fungsi Inisialisasi Editor
    function createEditor(selector) {
        ClassicEditor.create(document.querySelector(selector), {
            plugins: [ Essentials, Paragraph, Heading, Bold, Italic, List, Undo ],
            toolbar: [ 'heading', '|', 'bold', 'italic', '|', 'bulletedList', 'numberedList', '|', 'undo', 'redo' ]
        }).catch(error => console.error(error));
    }

    createEditor('#editor1');
    createEditor('#editor2');

    // Fungsi Preview Gambar
    function setupPreview(inputId, previewDivId, previewImgId) {
        document.getElementById(inputId).addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById(previewImgId).src = e.target.result;
                    document.getElementById(previewDivId).style.display = 'block';
                }
                reader.readAsDataURL(file);
            }
        });
    }

    setupPreview('gambar', 'preview1', 'previewImg1');
    setupPreview('gambar_2', 'preview2', 'previewImg2');

    // Button Loading
    document.getElementById('formLayanan').onsubmit = function() {
        const btn = document.getElementById('btnSubmit');
        btn.disabled = true;
        btn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Menyimpan...';
    };
</script>
@endpush