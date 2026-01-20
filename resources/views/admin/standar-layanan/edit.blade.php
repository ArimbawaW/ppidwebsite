@extends('layouts.admin')

@section('title', 'Edit Halaman Standar Layanan')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0">Edit Halaman</h1>
        <a href="{{ route('admin.standar-layanan.index') }}" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> Kembali
        </a>
    </div>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('admin.standar-layanan.update', $standarLayanan) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="row">
                    <!-- Nama Layanan -->
                    <div class="col-md-8 mb-3">
                        <label for="nama_layanan" class="form-label fw-bold">
                            Nama Layanan <span class="text-danger">*</span>
                        </label>
                        <input type="text" name="nama_layanan" id="nama_layanan" 
                               class="form-control @error('nama_layanan') is-invalid @enderror" 
                               value="{{ old('nama_layanan', $standarLayanan->nama_layanan) }}" required>
                        @error('nama_layanan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Urutan -->
                    <div class="col-md-4 mb-3">
                        <label for="urutan" class="form-label fw-bold">Urutan Tampilan</label>
                        <input type="number" name="urutan" id="urutan" 
                               class="form-control" 
                               value="{{ old('urutan', $standarLayanan->urutan) }}" 
                               min="0">
                    </div>

                    <!-- Gambar -->
                    <div class="col-md-12 mb-3">
                        <label for="gambar" class="form-label fw-bold">Gambar/Banner</label>
                        
                        @if($standarLayanan->gambar)
                        <div class="mb-2">
                            <img src="{{ asset('storage/' . $standarLayanan->gambar) }}" 
                                 style="max-width: 300px;" class="img-thumbnail">
                        </div>
                        @endif
                        
                        <input type="file" name="gambar" id="gambar" 
                               class="form-control" 
                               accept="image/*">
                        <small class="text-muted">Upload gambar baru jika ingin mengganti</small>
                        
                        <!-- Preview -->
                        <div id="preview" class="mt-2" style="display:none;">
                            <img id="previewImg" src="" style="max-width: 300px;" class="img-thumbnail">
                        </div>
                    </div>

                    <!-- Deskripsi -->
                    <div class="col-md-12 mb-3">
                        <label for="deskripsi" class="form-label fw-bold">Deskripsi Singkat</label>
                        <textarea name="deskripsi" id="deskripsi" rows="2" 
                                  class="form-control">{{ old('deskripsi', $standarLayanan->deskripsi) }}</textarea>
                    </div>

                    <!-- Konten -->
                    <div class="col-md-12 mb-3">
                        <label for="konten" class="form-label fw-bold">
                            Konten Halaman <span class="text-danger">*</span>
                        </label>
                        <textarea name="konten" id="konten" rows="15" 
                                  class="form-control @error('konten') is-invalid @enderror" 
                                  required>{{ old('konten', $standarLayanan->konten) }}</textarea>
                        @error('konten')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- File -->
                    <div class="col-md-12 mb-3">
                        <label for="file" class="form-label fw-bold">File Pendukung</label>
                        
                        @if($standarLayanan->file)
                        <div class="mb-2">
                            <a href="{{ asset('storage/' . $standarLayanan->file) }}" target="_blank" class="btn btn-sm btn-info">
                                <i class="bi bi-file-earmark"></i> Lihat File Saat Ini
                            </a>
                        </div>
                        @endif
                        
                        <input type="file" name="file" id="file" 
                               class="form-control" 
                               accept=".pdf,.doc,.docx">
                        <small class="text-muted">Upload file baru jika ingin mengganti</small>
                    </div>

                    <!-- Status -->
                    <div class="col-md-12 mb-3">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" name="is_active" id="is_active" 
                                   value="1" {{ old('is_active', $standarLayanan->is_active) ? 'checked' : '' }}>
                            <label class="form-check-label fw-bold" for="is_active">
                                Aktifkan Halaman
                            </label>
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-end gap-2 mt-4">
                    <a href="{{ route('admin.standar-layanan.index') }}" class="btn btn-secondary">
                        Batal
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-save"></i> Update Halaman
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