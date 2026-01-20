@extends('layouts.admin')

@section('title', 'Edit Halaman Statis')

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold">Edit Halaman Statis</h2>
        <a href="{{ route('admin.halaman-statis.index') }}" class="btn btn-secondary">
            <i class="bi bi-arrow-left me-2"></i>Kembali
        </a>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <form action="{{ route('admin.halaman-statis.update', $halamanStatis->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Slug <span class="text-danger">*</span></label>
                            <input type="text" name="slug" class="form-control @error('slug') is-invalid @enderror" 
                                   value="{{ old('slug', $halamanStatis->slug) }}" required>
                            <small class="text-muted">Contoh: informasi-berkala, informasi-setiap-saat</small>
                            @error('slug')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Judul Halaman <span class="text-danger">*</span></label>
                            <input type="text" name="judul" class="form-control @error('judul') is-invalid @enderror" 
                                   value="{{ old('judul', $halamanStatis->judul) }}" required>
                            @error('judul')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>
                </div>

                <hr class="my-4">

                <div class="mb-3">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5 class="fw-bold mb-0">Konten Halaman</h5>
                        <button type="button" class="btn btn-success btn-sm" onclick="addSection()">
                            <i class="bi bi-plus-lg me-1"></i>Tambah Section
                        </button>
                    </div>

                    <div id="sectionsContainer">
                        @foreach($halamanStatis->konten as $sectionIndex => $section)
                        <div class="section-item card mb-3" data-index="{{ $sectionIndex }}">
                            <div class="card-header bg-light">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h6 class="mb-0 fw-bold">Section {{ $sectionIndex + 1 }}</h6>
                                    <button type="button" class="btn btn-sm btn-danger" onclick="removeSection(this)">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="mb-3">
                                    <label class="form-label">Judul Section</label>
                                    <input type="text" name="sections[]" class="form-control" 
                                           value="{{ $section['section'] }}" 
                                           placeholder="Contoh: A. Informasi tentang...">
                                </div>

                                <div class="items-container">
                                    <label class="form-label fw-bold">Items:</label>
                                    @foreach($section['items'] as $itemIndex => $item)
                                    <div class="item-row mb-2">
                                        <div class="row g-2">
                                            <div class="col-md-6">
                                                <input type="text" 
                                                       name="items[{{ $sectionIndex }}][]" 
                                                       class="form-control" 
                                                       value="{{ $item['text'] }}"
                                                       placeholder="Nama item">
                                            </div>
                                            <div class="col-md-5">
                                                <input type="url" 
                                                       name="file_urls[{{ $sectionIndex }}][]" 
                                                       class="form-control" 
                                                       value="{{ $item['file_url'] ?? '' }}"
                                                       placeholder="URL file (opsional)">
                                            </div>
                                            <div class="col-md-1">
                                                <button type="button" class="btn btn-sm btn-danger w-100" onclick="removeItem(this)">
                                                    <i class="bi bi-x-lg"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>

                                <button type="button" class="btn btn-sm btn-outline-primary mt-2" onclick="addItem(this)">
                                    <i class="bi bi-plus me-1"></i>Tambah Item
                                </button>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>

                <div class="mb-3">
                    <div class="form-check">
                        <input type="checkbox" name="is_active" class="form-check-input" id="is_active" 
                               value="1" {{ old('is_active', $halamanStatis->is_active) ? 'checked' : '' }}>
                        <label class="form-check-label" for="is_active">Aktif</label>
                    </div>
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-save me-2"></i>Update
                    </button>
                    <a href="{{ route('admin.halaman-statis.index') }}" class="btn btn-secondary">Batal</a>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
let sectionCounter = {{ count($halamanStatis->konten) }};

function addSection() {
    const container = document.getElementById('sectionsContainer');
    const sectionHTML = `
        <div class="section-item card mb-3" data-index="${sectionCounter}">
            <div class="card-header bg-light">
                <div class="d-flex justify-content-between align-items-center">
                    <h6 class="mb-0 fw-bold">Section ${sectionCounter + 1}</h6>
                    <button type="button" class="btn btn-sm btn-danger" onclick="removeSection(this)">
                        <i class="bi bi-trash"></i>
                    </button>
                </div>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <label class="form-label">Judul Section</label>
                    <input type="text" name="sections[]" class="form-control" placeholder="Contoh: A. Informasi tentang...">
                </div>

                <div class="items-container">
                    <label class="form-label fw-bold">Items:</label>
                    <div class="item-row mb-2">
                        <div class="row g-2">
                            <div class="col-md-6">
                                <input type="text" name="items[${sectionCounter}][]" class="form-control" placeholder="Nama item">
                            </div>
                            <div class="col-md-5">
                                <input type="url" name="file_urls[${sectionCounter}][]" class="form-control" placeholder="URL file (opsional)">
                            </div>
                            <div class="col-md-1">
                                <button type="button" class="btn btn-sm btn-danger w-100" onclick="removeItem(this)">
                                    <i class="bi bi-x-lg"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <button type="button" class="btn btn-sm btn-outline-primary mt-2" onclick="addItem(this)">
                    <i class="bi bi-plus me-1"></i>Tambah Item
                </button>
            </div>
        </div>
    `;
    container.insertAdjacentHTML('beforeend', sectionHTML);
    sectionCounter++;
}

function removeSection(button) {
    if (confirm('Yakin ingin menghapus section ini?')) {
        button.closest('.section-item').remove();
    }
}

function addItem(button) {
    const sectionItem = button.closest('.section-item');
    const sectionIndex = sectionItem.dataset.index;
    const itemsContainer = sectionItem.querySelector('.items-container');
    
    const itemHTML = `
        <div class="item-row mb-2">
            <div class="row g-2">
                <div class="col-md-6">
                    <input type="text" name="items[${sectionIndex}][]" class="form-control" placeholder="Nama item">
                </div>
                <div class="col-md-5">
                    <input type="url" name="file_urls[${sectionIndex}][]" class="form-control" placeholder="URL file (opsional)">
                </div>
                <div class="col-md-1">
                    <button type="button" class="btn btn-sm btn-danger w-100" onclick="removeItem(this)">
                        <i class="bi bi-x-lg"></i>
                    </button>
                </div>
            </div>
        </div>
    `;
    itemsContainer.insertAdjacentHTML('beforeend', itemHTML);
}

function removeItem(button) {
    button.closest('.item-row').remove();
}
</script>
@endpush