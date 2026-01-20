@extends('layouts.admin')

@section('title', 'Tambah Halaman Standar Layanan')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0">Tambah Halaman Baru</h1>
        <a href="{{ route('admin.standar-layanan.index') }}" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> Kembali
        </a>
    </div>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('admin.standar-layanan.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="alert alert-info">
                    <i class="bi bi-info-circle me-2"></i>
                    Halaman yang Anda buat akan otomatis muncul di dropdown menu <strong>"Standar Layanan"</strong>
                </div>

                <div class="row">
                    <!-- Nama Layanan (Judul Halaman) -->
                    <div class="col-md-8 mb-3">
                        <label for="nama_layanan" class="form-label fw-bold">
                            Nama Layanan (Judul Halaman) <span class="text-danger">*</span>
                        </label>
                        <input type="text" name="nama_layanan" id="nama_layanan" 
                               class="form-control @error('nama_layanan') is-invalid @enderror" 
                               value="{{ old('nama_layanan') }}" 
                               placeholder="Contoh: Permohonan Informasi Publik" required>
                        @error('nama_layanan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Urutan -->
                    <div class="col-md-4 mb-3">
                        <label for="urutan" class="form-label fw-bold">Urutan Tampilan</label>
                        <input type="number" name="urutan" id="urutan" 
                               class="form-control" 
                               value="{{ old('urutan', 0) }}" 
                               min="0">
                        <small class="text-muted">Semakin kecil tampil lebih dulu</small>
                    </div>

                    <!-- Gambar/Banner -->
                    <div class="col-md-12 mb-3">
                        <label for="gambar" class="form-label fw-bold">Gambar/Banner Halaman</label>
                        <input type="file" name="gambar" id="gambar" 
                               class="form-control @error('gambar') is-invalid @enderror" 
                               accept="image/*">
                        <small class="text-muted">Format: JPG, PNG (Max: 2MB)</small>
                        @error('gambar')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        
                        <!-- Preview -->
                        <div id="preview" class="mt-2" style="display:none;">
                            <img id="previewImg" src="" style="max-width: 300px;" class="img-thumbnail">
                        </div>
                    </div>

                    <!-- Deskripsi Singkat -->
                    <div class="col-md-12 mb-3">
                        <label for="deskripsi" class="form-label fw-bold">Deskripsi Singkat</label>
                        <textarea name="deskripsi" id="deskripsi" rows="2" 
                                  class="form-control" 
                                  placeholder="Deskripsi singkat untuk preview">{{ old('deskripsi') }}</textarea>
                    </div>

                    <!-- Konten Halaman -->
                    <div class="col-md-12 mb-3">
                        <label for="konten" class="form-label fw-bold">
                            Konten Halaman <span class="text-danger">*</span>
                        </label>
                        <textarea name="konten" id="konten" rows="15" 
                                  class="form-control @error('konten') is-invalid @enderror" 
                                  placeholder="Tulis konten halaman di sini..." required>{{ old('konten') }}</textarea>
                        @error('konten')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Upload File Pendukung (Opsional) -->
                    <div class="col-md-12 mb-3">
                        <label for="file" class="form-label fw-bold">File Pendukung (Opsional)</label>
                        <input type="file" name="file" id="file" 
                               class="form-control" 
                               accept=".pdf,.doc,.docx">
                        <small class="text-muted">File tambahan yang bisa didownload (PDF, DOC, DOCX - Max: 10MB)</small>
                    </div>

                    <!-- Status Aktif -->
                    <div class="col-md-12 mb-3">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" name="is_active" id="is_active" value="1" checked>
                            <label class="form-check-label fw-bold" for="is_active">
                                Aktifkan Halaman
                            </label>
                            <div class="text-muted small mt-1">
                                Jika dicentang, halaman akan muncul di dropdown menu
                            </div>
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-end gap-2 mt-4">
                    <a href="{{ route('admin.standar-layanan.index') }}" class="btn btn-secondary">
                        Batal
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-save"></i> Simpan Halaman
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
// Preview gambar
document.getElementById('gambar').addEventListener('change', function(e) {
    const file = e.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('previewImg').src = e.target.result;
            document.getElementById('preview').style.display = 'block';
        }
        reader.readAsDataURL(file);
    }
});
</script>
@endpush