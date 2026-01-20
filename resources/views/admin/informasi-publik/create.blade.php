@extends('layouts.admin')

@section('title', 'Tambah Informasi Publik - PPID Admin')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Tambah Informasi Publik</h1>
</div>

<form action="{{ route('admin.informasi-publik.store') }}" method="POST" enctype="multipart/form-data">
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
            <option value="informasi_berkala" {{ old('kategori') == 'informasi_berkala' ? 'selected' : '' }}>Informasi Secara Berkala</option>
            <option value="informasi_setiap_saat" {{ old('kategori') == 'informasi_setiap_saat' ? 'selected' : '' }}>Informasi Setiap Saat</option>
            <option value="informasi_serta_merta" {{ old('kategori') == 'informasi_serta_merta' ? 'selected' : '' }}>Informasi Serta-Merta</option>
            <option value="informasi_dikecualikan" {{ old('kategori') == 'informasi_dikecualikan' ? 'selected' : '' }}>Informasi Dikecualikan</option>
        </select>
        @error('kategori')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-3">
        <label for="deskripsi" class="form-label">Deskripsi <span class="text-danger">*</span></label>
        <textarea class="form-control @error('deskripsi') is-invalid @enderror" id="deskripsi" name="deskripsi" rows="5" required>{{ old('deskripsi') }}</textarea>
        @error('deskripsi')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-3">
        <label for="file" class="form-label">File</label>
        <input type="file" class="form-control @error('file') is-invalid @enderror" id="file" name="file" accept=".pdf,.doc,.docx">
        <small class="form-text text-muted">Format: PDF, DOC, DOCX (Max: 5MB)</small>
        @error('file')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-3">
        <label for="link_download" class="form-label">Link Download (Alternatif)</label>
        <input type="url" class="form-control @error('link_download') is-invalid @enderror" id="link_download" name="link_download" value="{{ old('link_download') }}">
        @error('link_download')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-3 form-check">
        <input type="checkbox" class="form-check-input" id="is_active" name="is_active" {{ old('is_active') ? 'checked' : '' }}>
        <label class="form-check-label" for="is_active">Aktif</label>
    </div>

    <button type="submit" class="btn btn-primary">Simpan</button>
    <a href="{{ route('admin.informasi-publik.index') }}" class="btn btn-secondary">Batal</a>
</form>
@endsection

