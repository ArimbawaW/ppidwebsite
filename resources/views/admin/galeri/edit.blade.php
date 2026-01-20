@extends('layouts.admin')

@section('title', 'Edit Galeri - PPID Admin')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Edit Galeri</h1>
</div>

<form action="{{ route('admin.galeri.update', $galeri->id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <div class="mb-3">
        <label for="judul" class="form-label">Judul <span class="text-danger">*</span></label>
        <input type="text" class="form-control @error('judul') is-invalid @enderror" id="judul" name="judul" value="{{ old('judul', $galeri->judul) }}" required>
        @error('judul')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-3">
        <label for="deskripsi" class="form-label">Deskripsi</label>
        <textarea class="form-control @error('deskripsi') is-invalid @enderror" id="deskripsi" name="deskripsi" rows="3">{{ old('deskripsi', $galeri->deskripsi) }}</textarea>
        @error('deskripsi')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    @if($galeri->gambar)
    <div class="mb-3">
        <label class="form-label">Gambar Saat Ini</label>
        <p><img src="{{ asset('storage/' . $galeri->gambar) }}" alt="{{ $galeri->judul }}" style="max-width: 300px; height: auto;"></p>
    </div>
    @endif

    <div class="mb-3">
        <label for="gambar" class="form-label">Upload Gambar Baru (opsional)</label>
        <input type="file" class="form-control @error('gambar') is-invalid @enderror" id="gambar" name="gambar" accept="image/*">
        @error('gambar')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-3 form-check">
        <input type="checkbox" class="form-check-input" id="is_active" name="is_active" {{ old('is_active', $galeri->is_active) ? 'checked' : '' }}>
        <label class="form-check-label" for="is_active">Aktif</label>
    </div>

    <button type="submit" class="btn btn-primary">Update</button>
    <a href="{{ route('admin.galeri.index') }}" class="btn btn-secondary">Batal</a>
</form>
@endsection

