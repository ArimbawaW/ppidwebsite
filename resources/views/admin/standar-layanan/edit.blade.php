@extends('layouts.admin')

@section('title', 'Edit Halaman Standar Layanan')

@push('styles')
{{-- CSS CKEditor agar toolbar rapi --}}
<link rel="stylesheet" href="https://cdn.ckeditor.com/ckeditor5/43.0.0/ckeditor5.css">
<style>
    .ck-editor__editable { min-height: 300px; }
    .preview-container { margin-top: 10px; }
    .preview-container img { max-width: 300px; border: 1px solid #ddd; padding: 5px; border-radius: 8px; }
    .form-label { color: #334155; }
</style>
@endpush

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4 border-bottom pb-3">
        <h1 class="h3 mb-0 text-gray-800">Edit Halaman Standar Layanan</h1>
        <a href="{{ route('admin.standar-layanan.index') }}" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> Kembali
        </a>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-body p-4">
            <form action="{{ route('admin.standar-layanan.update', $standarLayanan->id) }}" method="POST" enctype="multipart/form-data" id="formEditLayanan">
                @csrf
                @method('PUT')

                <div class="row">
                    <div class="col-md-8 mb-4">
                        <label for="nama_layanan" class="form-label fw-bold">Nama Layanan (Judul Halaman) <span class="text-danger">*</span></label>
                        <input type="text" name="nama_layanan" id="nama_layanan" 
                               class="form-control form-control-lg @error('nama_layanan') is-invalid @enderror" 
                               value="{{ old('nama_layanan', $standarLayanan->nama_layanan) }}" required>
                        @error('nama_layanan') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-4 mb-4">
                        <label for="urutan" class="form-label fw-bold">Urutan Tampilan</label>
                        <input type="number" name="urutan" id="urutan" class="form-control form-control-lg" 
                               value="{{ old('urutan', $standarLayanan->urutan) }}" min="0">
                    </div>

                    <div class="col-12"><hr class="my-3"></div>

                    <div class="col-md-6 mb-4">
                        <h5 class="text-primary mb-3"><i class="bi bi-1-circle me-2"></i>Bagian Atas</h5>
                        <div class="mb-3">
                            <label for="gambar" class="form-label fw-bold">Gambar Utama (Gambar 1)</label>
                            @if($standarLayanan->gambar)
                            <div class="mb-2">
                                <small class="text-muted d-block mb-1">Gambar saat ini:</small>
                                <img src="{{ asset('storage/' . $standarLayanan->gambar) }}" class="img-thumbnail" style="max-height: 150px;">
                            </div>
                            @endif
                            <input type="file" name="gambar" id="gambar" class="form-control @error('gambar') is-invalid @enderror" accept="image/*">
                            <div id="preview1" class="preview-container" style="display:none;">
                                <small class="text-success d-block mb-1">Preview gambar baru:</small>
                                <img id="previewImg1" src="">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="konten" class="form-label fw-bold">Deskripsi/Konten 1 <span class="text-danger">*</span></label>
                            <textarea name="konten" id="editor1">{{ old('konten', $standarLayanan->konten) }}</textarea>
                            @error('konten') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    <div class="col-md-6 mb-4">
                        <h5 class="text-primary mb-3"><i class="bi bi-2-circle me-2"></i>Bagian Bawah</h5>
                        <div class="mb-3">
                            <label for="gambar_2" class="form-label fw-bold">Gambar Kedua (Opsional)</label>
                            @if($standarLayanan->gambar_2)
                            <div class="mb-2">
                                <small class="text-muted d-block mb-1">Gambar saat ini:</small>
                                <img src="{{ asset('storage/' . $standarLayanan->gambar_2) }}" class="img-thumbnail" style="max-height: 150px;">
                            </div>
                            @endif
                            <input type="file" name="gambar_2" id="gambar_2" class="form-control @error('gambar_2') is-invalid @enderror" accept="image/*">
                            <div id="preview2" class="preview-container" style="display:none;">
                                <small class="text-success d-block mb-1">Preview gambar baru:</small>
                                <img id="previewImg2" src="">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="deskripsi_2" class="form-label fw-bold">Deskripsi/Konten 2 (Opsional)</label>
                            <textarea name="deskripsi_2" id="editor2">{{ old('deskripsi_2', $standarLayanan->deskripsi_2) }}</textarea>
                        </div>
                    </div>

                    <div class="col-12"><hr class="my-3"></div>

                    <div class="col-md-8 mb-4">
                        <label for="file" class="form-label fw-bold">File Lampiran (PDF/DOC)</label>
                        @if($standarLayanan->file)
                        <div class="mb-2">
                            <a href="{{ asset('storage/' . $standarLayanan->file) }}" target="_blank" class="btn btn-sm btn-info text-white">
                                <i class="bi bi-file-earmark-text"></i> Lihat File Saat Ini
                            </a>
                        </div>
                        @endif
                        <input type="file" name="file" id="file" class="form-control" accept=".pdf,.doc,.docx">
                        <small class="text-muted">Kosongkan jika tidak ingin mengubah file.</small>
                    </div>

                    <div class="col-md-4 mb-4 d-flex align-items-center">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" name="is_active" id="is_active" value="1" {{ $standarLayanan->is_active ? 'checked' : '' }}>
                            <label class="form-check-label fw-bold" for="is_active">Aktifkan Halaman</label>
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-end gap-2 mt-4 border-top pt-4">
                    <a href="{{ route('admin.standar-layanan.index') }}" class="btn btn-light px-4">Batal</a>
                    <button type="submit" class="btn btn-primary px-4 shadow-sm" id="btnSubmit">
                        <i class="bi bi-save me-1"></i> Update Halaman
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
    const { ClassicEditor, Essentials, Paragraph, Heading, Bold, Italic, List, Undo, Link } = CKEDITOR;

    // Inisialisasi CKEditor untuk Konten 1 dan Konten 2
    function setupEditor(selector) {
        ClassicEditor.create(document.querySelector(selector), {
            plugins: [ Essentials, Paragraph, Heading, Bold, Italic, List, Undo, Link ],
            toolbar: [ 'heading', '|', 'bold', 'italic', 'link', '|', 'bulletedList', 'numberedList', '|', 'undo', 'redo' ]
        }).catch(error => console.error(error));
    }

    setupEditor('#editor1');
    setupEditor('#editor2');

    // Preview Gambar Dinamis
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

    // Loading State saat Update
    document.getElementById('formEditLayanan').onsubmit = function() {
        const btn = document.getElementById('btnSubmit');
        btn.disabled = true;
        btn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Memperbarui...';
    };
</script>
@endpush