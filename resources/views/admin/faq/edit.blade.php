@extends('layouts.admin')

@section('title', 'Edit FAQ')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0">Edit FAQ</h1>
        <a href="{{ route('admin.faq.index') }}" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> Kembali
        </a>
    </div>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('admin.faq.update', $faq) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="row">
                    <!-- Kategori -->
                    <div class="col-md-6 mb-3">
                        <label for="kategori" class="form-label">Kategori <span class="text-danger">*</span></label>
                        <select name="kategori" id="kategori" 
                                class="form-select @error('kategori') is-invalid @enderror" required>
                            <option value="">-- Pilih Kategori --</option>
                            <option value="Permohonan Informasi" {{ old('kategori', $faq->kategori) == 'Permohonan Informasi' ? 'selected' : '' }}>Permohonan Informasi</option>
                            <option value="Keberatan" {{ old('kategori', $faq->kategori) == 'Keberatan' ? 'selected' : '' }}>Keberatan</option>
                            <option value="Sengketa" {{ old('kategori', $faq->kategori) == 'Sengketa' ? 'selected' : '' }}>Sengketa</option>
                            <option value="Informasi Publik" {{ old('kategori', $faq->kategori) == 'Informasi Publik' ? 'selected' : '' }}>Informasi Publik</option>
                            <option value="Umum" {{ old('kategori', $faq->kategori) == 'Umum' ? 'selected' : '' }}>Umum</option>
                            <option value="Lainnya" {{ old('kategori', $faq->kategori) == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                        </select>
                        @error('kategori')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Urutan -->
                    <div class="col-md-3 mb-3">
                        <label for="urutan" class="form-label">Urutan Tampilan</label>
                        <input type="number" name="urutan" id="urutan" 
                               class="form-control @error('urutan') is-invalid @enderror" 
                               value="{{ old('urutan', $faq->urutan) }}" 
                               min="0">
                        <small class="text-muted">Semakin kecil tampil lebih dulu</small>
                        @error('urutan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Status -->
                    <div class="col-md-3 mb-3">
                        <label for="is_active" class="form-label">Status</label>
                        <select name="is_active" id="is_active" 
                                class="form-select @error('is_active') is-invalid @enderror">
                            <option value="1" {{ old('is_active', $faq->is_active) == '1' ? 'selected' : '' }}>Aktif</option>
                            <option value="0" {{ old('is_active', $faq->is_active) == '0' ? 'selected' : '' }}>Nonaktif</option>
                        </select>
                        @error('is_active')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Pertanyaan -->
                    <div class="col-md-12 mb-3">
                        <label for="pertanyaan" class="form-label">Pertanyaan <span class="text-danger">*</span></label>
                        <textarea name="pertanyaan" id="pertanyaan" rows="3" 
                                  class="form-control @error('pertanyaan') is-invalid @enderror" 
                                  placeholder="Masukkan pertanyaan yang sering diajukan" required>{{ old('pertanyaan', $faq->pertanyaan) }}</textarea>
                        @error('pertanyaan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Jawaban -->
                    <div class="col-md-12 mb-3">
                        <label for="jawaban" class="form-label">Jawaban <span class="text-danger">*</span></label>
                        <textarea name="jawaban" id="jawaban" rows="8" 
                                  class="form-control @error('jawaban') is-invalid @enderror" 
                                  placeholder="Masukkan jawaban lengkap dan jelas" required>{{ old('jawaban', $faq->jawaban) }}</textarea>
                        <small class="text-muted">Berikan jawaban yang lengkap dan mudah dipahami. Gunakan enter untuk membuat paragraf baru.</small>
                        @error('jawaban')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="d-flex justify-content-end gap-2 mt-4">
                    <a href="{{ route('admin.faq.index') }}" class="btn btn-secondary">
                        Batal
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-save"></i> Update FAQ
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection