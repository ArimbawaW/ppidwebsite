@extends('layouts.admin')

@section('title', 'Edit Regulasi')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0">Edit Regulasi</h1>
        <a href="{{ route('admin.regulasi.index') }}" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> Kembali
        </a>
    </div>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('admin.regulasi.update', $regulasi) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="row">
                    <!-- Kategori -->
                    <div class="col-md-6 mb-3">
                        <label for="kategori" class="form-label">Kategori <span class="text-danger">*</span></label>
                        <select name="kategori" id="kategori" 
                                class="form-select @error('kategori') is-invalid @enderror" required>
                            <option value="">-- Pilih Kategori --</option>
                            <option value="Undang-Undang" {{ old('kategori', $regulasi->kategori) == 'Undang-Undang' ? 'selected' : '' }}>Undang-Undang</option>
                            <option value="Peraturan Pemerintah" {{ old('kategori', $regulasi->kategori) == 'Peraturan Pemerintah' ? 'selected' : '' }}>Peraturan Pemerintah</option>
                            <option value="Peraturan Menteri" {{ old('kategori', $regulasi->kategori) == 'Peraturan Menteri' ? 'selected' : '' }}>Peraturan Menteri</option>
                            <option value="Peraturan Daerah" {{ old('kategori', $regulasi->kategori) == 'Peraturan Daerah' ? 'selected' : '' }}>Peraturan Daerah</option>
                            <option value="Keputusan" {{ old('kategori', $regulasi->kategori) == 'Keputusan' ? 'selected' : '' }}>Keputusan</option>
                            <option value="Lainnya" {{ old('kategori', $regulasi->kategori) == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                        </select>
                        @error('kategori')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Nomor -->
                    <div class="col-md-6 mb-3">
                        <label for="nomor" class="form-label">Nomor Regulasi <span class="text-danger">*</span></label>
                        <input type="text" name="nomor" id="nomor" 
                               class="form-control @error('nomor') is-invalid @enderror" 
                               value="{{ old('nomor', $regulasi->nomor) }}" 
                               placeholder="Contoh: 14/2008" required>
                        @error('nomor')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Judul -->
                    <div class="col-md-12 mb-3">
                        <label for="judul" class="form-label">Judul Regulasi <span class="text-danger">*</span></label>
                        <input type="text" name="judul" id="judul" 
                               class="form-control @error('judul') is-invalid @enderror" 
                               value="{{ old('judul', $regulasi->judul) }}" 
                               placeholder="Masukkan judul lengkap regulasi" required>
                        @error('judul')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Tahun -->
                    <div class="col-md-4 mb-3">
                        <label for="tahun" class="form-label">Tahun <span class="text-danger">*</span></label>
                        <input type="number" name="tahun" id="tahun" 
                               class="form-control @error('tahun') is-invalid @enderror" 
                               value="{{ old('tahun', $regulasi->tahun) }}" 
                               min="1900" max="2100" required>
                        @error('tahun')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Tanggal Terbit -->
                    <div class="col-md-4 mb-3">
                        <label for="tanggal_terbit" class="form-label">Tanggal Terbit</label>
                        <input type="date" name="tanggal_terbit" id="tanggal_terbit" 
                               class="form-control @error('tanggal_terbit') is-invalid @enderror" 
                               value="{{ old('tanggal_terbit', $regulasi->tanggal_terbit?->format('Y-m-d')) }}">
                        @error('tanggal_terbit')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Status -->
                    <div class="col-md-4 mb-3">
                        <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                        <select name="status" id="status" 
                                class="form-select @error('status') is-invalid @enderror" required>
                            <option value="aktif" {{ old('status', $regulasi->is_active ? 'aktif' : 'tidak_aktif') == 'aktif' ? 'selected' : '' }}>Aktif</option>
                            <option value="tidak_aktif" {{ old('status', $regulasi->is_active ? 'aktif' : 'tidak_aktif') == 'tidak_aktif' ? 'selected' : '' }}>Tidak Aktif</option>
                        </select>
                        @error('status')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Deskripsi -->
                    <div class="col-md-12 mb-3">
                        <label for="deskripsi" class="form-label">Deskripsi</label>
                        <textarea name="deskripsi" id="deskripsi" rows="4" 
                                  class="form-control @error('deskripsi') is-invalid @enderror" 
                                  placeholder="Masukkan deskripsi singkat tentang regulasi ini">{{ old('deskripsi', $regulasi->deskripsi) }}</textarea>
                        @error('deskripsi')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- File Upload -->
                    <div class="col-md-12 mb-3">
                        <label for="file" class="form-label">Upload File Baru (PDF)</label>
                        <input type="file" name="file" id="file" 
                               class="form-control @error('file') is-invalid @enderror" 
                               accept=".pdf">
                        <small class="text-muted">Format: PDF, Maksimal 10MB. Kosongkan jika tidak ingin mengganti file.</small>
                        @error('file')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        
                        @if($regulasi->file)
                            <div class="mt-2">
                                <span class="badge bg-info">
                                    <i class="bi bi-file-earmark-pdf"></i> File saat ini: {{ basename($regulasi->file) }}
                                </span>
                                <a href="{{ asset('storage/' . $regulasi->file) }}" 
                                   class="btn btn-sm btn-outline-primary ms-2" 
                                   target="_blank">
                                    <i class="bi bi-eye"></i> Lihat File
                                </a>
                            </div>
                        @endif
                    </div>
                </div>

                <div class="d-flex justify-content-end gap-2 mt-4">
                    <a href="{{ route('admin.regulasi.index') }}" class="btn btn-secondary">
                        Batal
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-save"></i> Update Regulasi
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection