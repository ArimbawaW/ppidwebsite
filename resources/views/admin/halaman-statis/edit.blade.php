@extends('layouts.admin')

@section('title', 'Edit Halaman Statis')

@php
    use Illuminate\Support\Facades\Storage;
@endphp

@push('styles')
<style>
    .section-item {
        border-left: 5px solid #0d6efd;
        border-radius: 12px;
        background: #fff;
        transition: all 0.3s ease;
    }

    .section-header-handle {
        cursor: move;
        background-color: #f8f9fa;
        border-bottom: 1px solid #edf2f7;
        padding: 12px 20px;
    }

    .item-row {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        padding: 18px;
        margin-bottom: 15px;
        transition: all 0.2s ease;
        position: relative;
    }

    .item-row:hover {
        border-color: #3b82f6;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
    }

    .drag-handle-item {
        cursor: move;
        color: #cbd5e1;
        font-size: 1.5rem;
        transition: color 0.2s;
    }

    .drag-handle-item:hover { color: #64748b; }

    .file-status-box {
        background: #f1f5f9;
        padding: 10px 14px;
        border-radius: 8px;
        border: 1px solid #e2e8f0;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .form-label-custom {
        font-size: 0.75rem;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        font-weight: 700;
        color: #475569;
        margin-bottom: 6px;
    }

    .sortable-ghost {
        opacity: 0.3;
        border: 2px dashed #0d6efd !important;
    }

    .btn-remove-circle {
        width: 32px;
        height: 32px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 0;
        transition: all 0.2s;
    }

    .subsection-container {
        margin-top: 10px;
        padding: 12px;
        background: #eef6ff;
        border-radius: 8px;
        border: 1px dashed #93c5fd;
    }

    .subsection-row {
        background: #fff;
        padding: 10px;
        border-radius: 6px;
        border: 1px solid #dbeafe;
        margin-bottom: 8px;
    }

    .has-subsection-indicator {
        font-size: 0.78rem;
        color: #2563eb;
        font-weight: 600;
    }
</style>
@endpush

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold mb-0">Edit Halaman Statis</h2>
            <p class="text-muted">Kelola struktur konten dan dokumen secara dinamis.</p>
        </div>
        <a href="{{ route('admin.halaman-statis.index') }}" class="btn btn-outline-secondary shadow-sm">
            <i class="bi bi-arrow-left me-2"></i>Kembali
        </a>
    </div>

    <form action="{{ route('admin.halaman-statis.update', $halamanStatis->id) }}" method="POST" enctype="multipart/form-data" id="formHalaman">
        @csrf
        @method('PUT')

        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body p-4">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Slug Halaman</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light"><i class="bi bi-link-45deg"></i></span>
                            <input type="text" class="form-control bg-light" value="{{ $halamanStatis->slug }}" readonly>
                        </div>
                        <input type="hidden" name="slug" value="{{ $halamanStatis->slug }}">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Judul Halaman <span class="text-danger">*</span></label>
                        <input type="text" name="judul" class="form-control @error('judul') is-invalid @enderror" value="{{ old('judul', $halamanStatis->judul) }}" required>
                        @error('judul')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
        </div>

        <div id="sectionsContainer">
            @foreach($halamanStatis->konten as $sectionIndex => $section)
            <div class="section-item card border-0 shadow-sm mb-4" data-index="{{ $sectionIndex }}">
                <div class="section-header-handle d-flex justify-content-between align-items-center">
                    <div class="d-flex align-items-center">
                        <i class="bi bi-grip-horizontal fs-4 me-2 text-muted"></i>
                        <h5 class="mb-0 fw-bold text-dark">Section {{ $sectionIndex + 1 }}</h5>
                    </div>
                    <button type="button" class="btn btn-outline-danger btn-sm border-0" onclick="removeSection(this)">
                        <i class="bi bi-trash3 me-1"></i> Hapus Section
                    </button>
                </div>

                <div class="card-body p-4">
                    <div class="mb-4">
                        <label class="form-label-custom">Nama / Judul Section</label>
                        <input type="text" name="sections[]" class="form-control form-control-lg fw-semibold" value="{{ $section['section'] }}" placeholder="Contoh: Dokumen Perencanaan" required>
                    </div>

                    <div class="items-container">
                        @foreach($section['items'] as $itemIndex => $item)
                        @php $hasSubsection = !empty($item['subsections']); @endphp
                        <div class="item-row">
                            <div class="row g-3 align-items-end">
                                <div class="col-md-auto">
                                    <div class="drag-handle-item" title="Geser untuk mengurutkan item">
                                        <i class="bi bi-grip-vertical"></i>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <label class="form-label-custom">Nama Item</label>
                                    <input type="text" name="items[{{ $sectionIndex }}][]" class="form-control shadow-sm" value="{{ $item['text'] }}" placeholder="Nama dokumen">
                                </div>

                                <div class="col-md-6 link-fields" style="{{ $hasSubsection ? 'opacity:0.4;pointer-events:none;' : '' }}">
                                    <div class="row g-2">
                                        <div class="col-6">
                                            <label class="form-label-custom">URL Luar (Opsional)</label>
                                            <input type="url" name="file_urls[{{ $sectionIndex }}][]" class="form-control shadow-sm" value="{{ $item['file_url'] ?? '' }}" placeholder="https://...">
                                        </div>
                                        <div class="col-6">
                                            <label class="form-label-custom">File / Dokumen</label>
                                            <input type="file" name="files[{{ $sectionIndex }}][]" class="form-control form-control-sm mb-2 shadow-sm">
                                            <input type="hidden" name="existing_files[{{ $sectionIndex }}][]" value="{{ $item['file_path'] ?? '' }}" class="path-input">

                                            @if(!empty($item['file_path']))
                                                <div class="file-status-box">
                                                    <div class="d-flex align-items-center">
                                                        <i class="bi bi-check-circle-fill text-success me-2"></i>
                                                        <span class="small fw-semibold">File Tersedia</span>
                                                        <a href="{{ Storage::url($item['file_path']) }}" target="_blank" class="ms-2 small text-decoration-none border-start ps-2">Lihat</a>
                                                    </div>
                                                    <button type="button" class="btn btn-sm text-danger p-0" onclick="clearFile(this)" title="Hapus file ini">
                                                        <i class="bi bi-x-circle-fill"></i>
                                                    </button>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-1">
                                    <button type="button" class="btn btn-remove-item btn-danger btn-remove-circle shadow-sm" onclick="removeItem(this)" title="Hapus item">
                                        <i class="bi bi-x"></i>
                                    </button>
                                </div>
                            </div>

                            {{-- Subsection Toggle --}}
                            <div class="mt-3">
                                <div class="form-check form-switch mb-1">
                                    <input type="checkbox" class="form-check-input subsection-toggle"
                                           onchange="toggleSubsection(this)"
                                           {{ $hasSubsection ? 'checked' : '' }}>
                                    <label class="form-check-label small fw-semibold text-primary">Tambah Subsection</label>
                                </div>
                                <input type="hidden" name="has_subsection[{{ $sectionIndex }}][]"
                                       value="{{ $hasSubsection ? '1' : '0' }}"
                                       class="has-subsection-flag">

                                <div class="subsection-wrapper" style="{{ $hasSubsection ? '' : 'display:none;' }}">
                                    <div class="subsection-container">
                                        <p class="has-subsection-indicator mb-2"><i class="bi bi-diagram-3 me-1"></i>Subsection dari item ini:</p>
                                        <div class="subsections-list">
                                            @if($hasSubsection)
                                                @foreach($item['subsections'] as $sub)
                                                <div class="subsection-row">
                                                    <div class="row g-2 align-items-start">
                                                        <div class="col-md-5">
                                                            <input type="text"
                                                                   name="subsection_titles[{{ $sectionIndex }}][{{ $itemIndex }}][]"
                                                                   class="form-control form-control-sm"
                                                                   value="{{ $sub['text'] }}"
                                                                   placeholder="Nama subsection">
                                                        </div>
                                                        <div class="col-md-3">
                                                            <input type="url"
                                                                   name="subsection_urls[{{ $sectionIndex }}][{{ $itemIndex }}][]"
                                                                   class="form-control form-control-sm"
                                                                   value="{{ $sub['file_url'] ?? '' }}"
                                                                   placeholder="URL (opsional)">
                                                        </div>
                                                        <div class="col-md-3">
                                                            <input type="file"
                                                                   name="subsection_files[{{ $sectionIndex }}][{{ $itemIndex }}][]"
                                                                   class="form-control form-control-sm"
                                                                   accept=".pdf,.doc,.docx,.xls,.xlsx,.ppt,.pptx,.jpg,.jpeg,.png">
                                                            @if(!empty($sub['file_path']))
                                                                <input type="hidden" name="existing_subsection_files[{{ $sectionIndex }}][{{ $itemIndex }}][]" value="{{ $sub['file_path'] }}" class="sub-path-input">
                                                                <small class="text-success"><i class="bi bi-check-circle me-1"></i>Ada file
                                                                    <a href="{{ Storage::url($sub['file_path']) }}" target="_blank" class="ms-1">Lihat</a>
                                                                    <button type="button" class="btn btn-link btn-sm text-danger p-0 ms-1" onclick="clearSubFile(this)">Hapus</button>
                                                                </small>
                                                            @else
                                                                <input type="hidden" name="existing_subsection_files[{{ $sectionIndex }}][{{ $itemIndex }}][]" value="" class="sub-path-input">
                                                            @endif
                                                        </div>
                                                        <div class="col-md-1">
                                                            <button type="button" class="btn btn-sm btn-danger" onclick="removeSubsection(this)">
                                                                <i class="bi bi-x"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                                @endforeach
                                            @else
                                                <div class="subsection-row">
                                                    <div class="row g-2 align-items-start">
                                                        <div class="col-md-5">
                                                            <input type="text" name="subsection_titles[{{ $sectionIndex }}][{{ $itemIndex }}][]" class="form-control form-control-sm" placeholder="Nama subsection">
                                                        </div>
                                                        <div class="col-md-3">
                                                            <input type="url" name="subsection_urls[{{ $sectionIndex }}][{{ $itemIndex }}][]" class="form-control form-control-sm" placeholder="URL (opsional)">
                                                        </div>
                                                        <div class="col-md-3">
                                                            <input type="file" name="subsection_files[{{ $sectionIndex }}][{{ $itemIndex }}][]" class="form-control form-control-sm" accept=".pdf,.doc,.docx,.xls,.xlsx,.ppt,.pptx,.jpg,.jpeg,.png">
                                                            <input type="hidden" name="existing_subsection_files[{{ $sectionIndex }}][{{ $itemIndex }}][]" value="" class="sub-path-input">
                                                        </div>
                                                        <div class="col-md-1">
                                                            <button type="button" class="btn btn-sm btn-danger" onclick="removeSubsection(this)">
                                                                <i class="bi bi-x"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                        <button type="button" class="btn btn-sm btn-outline-info mt-1"
                                                onclick="addSubsection(this, {{ $sectionIndex }}, {{ $itemIndex }})">
                                            <i class="bi bi-plus me-1"></i>Tambah Subsection
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>

                    <button type="button" class="btn btn-sm btn-outline-primary fw-bold mt-2" onclick="addItem(this)">
                        <i class="bi bi-plus-lg me-1"></i> Tambah Item
                    </button>
                </div>
            </div>
            @endforeach
        </div>

        <div class="card border-0 shadow-sm mb-4 bg-light">
            <div class="card-body p-3 d-flex justify-content-between align-items-center">
                <button type="button" class="btn btn-primary shadow-sm px-4" onclick="addSection()">
                    <i class="bi bi-plus-circle me-2"></i>Tambah Section Baru
                </button>
                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" name="is_active" id="isActive" value="1" {{ $halamanStatis->is_active ? 'checked' : '' }}>
                    <label class="form-check-label fw-bold" for="isActive">Publikasikan Halaman</label>
                </div>
            </div>
        </div>

        <div class="d-grid gap-2 d-md-flex justify-content-md-end mb-5">
            <button type="submit" class="btn btn-success btn-lg px-5 shadow">
                <i class="bi bi-save me-2"></i>Update Halaman
            </button>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        initSortable();
    });

    function initSortable() {
        const sectionsEl = document.getElementById('sectionsContainer');
        if (sectionsEl) {
            new Sortable(sectionsEl, {
                animation: 150,
                handle: '.section-header-handle',
                ghostClass: 'sortable-ghost',
                onEnd: reindexAll
            });
        }

        document.querySelectorAll('.items-container').forEach(container => {
            new Sortable(container, {
                animation: 150,
                handle: '.drag-handle-item',
                ghostClass: 'sortable-ghost',
                onEnd: reindexAll
            });
        });
    }

    function reindexAll() {
        document.querySelectorAll('.section-item').forEach((section, sIdx) => {
            section.dataset.index = sIdx;
            const title = section.querySelector('h5');
            if (title) title.textContent = `Section ${sIdx + 1}`;

            section.querySelectorAll('input[name], textarea[name]').forEach(el => {
                const old = el.getAttribute('name') || '';
                const replaced = old.replace(
                    /^(items|file_urls|files|existing_files|has_subsection|subsection_titles|subsection_urls|subsection_files|existing_subsection_files)\[(\d+)\]/,
                    (m, p1) => `${p1}[${sIdx}]`
                );
                if (replaced !== old) el.setAttribute('name', replaced);
            });

            // Reindex item index (second bracket for subsection fields)
            section.querySelectorAll('.items-container .item-row').forEach((itemEl, iIdx) => {
                itemEl.querySelectorAll('input[name]').forEach(el => {
                    const old = el.getAttribute('name') || '';
                    const replaced = old.replace(
                        /^(subsection_titles|subsection_urls|subsection_files|existing_subsection_files)\[(\d+)\]\[(\d+)\]/,
                        (m, p1, p2) => `${p1}[${p2}][${iIdx}]`
                    );
                    if (replaced !== old) el.setAttribute('name', replaced);
                });
            });
        });
    }

    function toggleSubsection(checkbox) {
        const itemRow = checkbox.closest('.item-row');
        const wrapper = itemRow.querySelector('.subsection-wrapper');
        const linkFields = itemRow.querySelector('.link-fields');
        const flag = itemRow.querySelector('.has-subsection-flag');

        if (checkbox.checked) {
            wrapper.style.display = 'block';
            linkFields.style.opacity = '0.4';
            linkFields.style.pointerEvents = 'none';
            if (flag) flag.value = '1';
        } else {
            wrapper.style.display = 'none';
            linkFields.style.opacity = '1';
            linkFields.style.pointerEvents = '';
            if (flag) flag.value = '0';
        }
    }

    function clearFile(btn) {
        if (confirm('Hapus file ini?')) {
            const col = btn.closest('.col-6') || btn.closest('.col-md-4');
            const hiddenInput = col.querySelector('.path-input');
            if (hiddenInput) hiddenInput.value = '';
            const statusBox = col.querySelector('.file-status-box');
            if (statusBox) {
                statusBox.style.background = '#fee2e2';
                statusBox.innerHTML = '<span class="small text-danger fw-bold"><i class="bi bi-exclamation-triangle me-1"></i> File ditandai untuk dihapus</span>';
            }
        }
    }

    function clearSubFile(btn) {
        if (confirm('Hapus file subsection ini?')) {
            const col = btn.closest('.col-md-3');
            const hidden = col.querySelector('.sub-path-input');
            if (hidden) hidden.value = '';
            btn.closest('small').innerHTML = '<span class="text-danger small">File dihapus</span>';
        }
    }

    function addSubsection(btn, sectionIndex, itemIndex) {
        const list = btn.previousElementSibling;
        const html = `
            <div class="subsection-row">
                <div class="row g-2 align-items-start">
                    <div class="col-md-5">
                        <input type="text" name="subsection_titles[${sectionIndex}][${itemIndex}][]" class="form-control form-control-sm" placeholder="Nama subsection">
                    </div>
                    <div class="col-md-3">
                        <input type="url" name="subsection_urls[${sectionIndex}][${itemIndex}][]" class="form-control form-control-sm" placeholder="URL (opsional)">
                    </div>
                    <div class="col-md-3">
                        <input type="file" name="subsection_files[${sectionIndex}][${itemIndex}][]" class="form-control form-control-sm" accept=".pdf,.doc,.docx,.xls,.xlsx,.ppt,.pptx,.jpg,.jpeg,.png">
                        <input type="hidden" name="existing_subsection_files[${sectionIndex}][${itemIndex}][]" value="" class="sub-path-input">
                    </div>
                    <div class="col-md-1">
                        <button type="button" class="btn btn-sm btn-danger" onclick="removeSubsection(this)">
                            <i class="bi bi-x"></i>
                        </button>
                    </div>
                </div>
            </div>`;
        list.insertAdjacentHTML('beforeend', html);
    }

    function removeSubsection(btn) {
        const list = btn.closest('.subsections-list');
        if (list.querySelectorAll('.subsection-row').length <= 1) {
            alert('Minimal 1 subsection. Matikan toggle jika tidak ingin menggunakan subsection.');
            return;
        }
        btn.closest('.subsection-row').remove();
    }

    function addItem(btn) {
        const sectionEl = btn.closest('.section-item');
        const sectionIdx = parseInt(sectionEl.dataset.index, 10);
        const itemsContainer = sectionEl.querySelector('.items-container');
        const itemCount = itemsContainer.querySelectorAll('.item-row').length;

        const html = `
            <div class="item-row">
                <div class="row g-3 align-items-end">
                    <div class="col-md-auto">
                        <div class="drag-handle-item"><i class="bi bi-grip-vertical"></i></div>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label-custom">Nama Item</label>
                        <input type="text" name="items[${sectionIdx}][]" class="form-control shadow-sm" placeholder="Nama dokumen">
                    </div>
                    <div class="col-md-6 link-fields">
                        <div class="row g-2">
                            <div class="col-6">
                                <label class="form-label-custom">URL Luar (Opsional)</label>
                                <input type="url" name="file_urls[${sectionIdx}][]" class="form-control shadow-sm" placeholder="https://...">
                            </div>
                            <div class="col-6">
                                <label class="form-label-custom">File / Dokumen</label>
                                <input type="file" name="files[${sectionIdx}][]" class="form-control form-control-sm shadow-sm">
                                <input type="hidden" name="existing_files[${sectionIdx}][]" value="" class="path-input">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-1">
                        <button type="button" class="btn btn-remove-item btn-danger btn-remove-circle shadow-sm" onclick="removeItem(this)">
                            <i class="bi bi-x"></i>
                        </button>
                    </div>
                </div>

                <div class="mt-3">
                    <div class="form-check form-switch mb-1">
                        <input type="checkbox" class="form-check-input subsection-toggle" onchange="toggleSubsection(this)">
                        <label class="form-check-label small fw-semibold text-primary">Tambah Subsection</label>
                    </div>
                    <input type="hidden" name="has_subsection[${sectionIdx}][]" value="0" class="has-subsection-flag">
                    <div class="subsection-wrapper" style="display:none;">
                        <div class="subsection-container">
                            <p class="has-subsection-indicator mb-2"><i class="bi bi-diagram-3 me-1"></i>Subsection dari item ini:</p>
                            <div class="subsections-list">
                                <div class="subsection-row">
                                    <div class="row g-2 align-items-start">
                                        <div class="col-md-5">
                                            <input type="text" name="subsection_titles[${sectionIdx}][${itemCount}][]" class="form-control form-control-sm" placeholder="Nama subsection">
                                        </div>
                                        <div class="col-md-3">
                                            <input type="url" name="subsection_urls[${sectionIdx}][${itemCount}][]" class="form-control form-control-sm" placeholder="URL (opsional)">
                                        </div>
                                        <div class="col-md-3">
                                            <input type="file" name="subsection_files[${sectionIdx}][${itemCount}][]" class="form-control form-control-sm" accept=".pdf,.doc,.docx,.xls,.xlsx,.ppt,.pptx,.jpg,.jpeg,.png">
                                            <input type="hidden" name="existing_subsection_files[${sectionIdx}][${itemCount}][]" value="" class="sub-path-input">
                                        </div>
                                        <div class="col-md-1">
                                            <button type="button" class="btn btn-sm btn-danger" onclick="removeSubsection(this)"><i class="bi bi-x"></i></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <button type="button" class="btn btn-sm btn-outline-info mt-1" onclick="addSubsection(this, ${sectionIdx}, ${itemCount})">
                                <i class="bi bi-plus me-1"></i>Tambah Subsection
                            </button>
                        </div>
                    </div>
                </div>
            </div>`;

        itemsContainer.insertAdjacentHTML('beforeend', html);
        initSortable();
        reindexAll();
    }

    function addSection() {
        const sIdx = document.querySelectorAll('.section-item').length;
        const html = `
            <div class="section-item card border-0 shadow-sm mb-4" data-index="${sIdx}">
                <div class="section-header-handle d-flex justify-content-between align-items-center">
                    <div class="d-flex align-items-center">
                        <i class="bi bi-grip-horizontal fs-4 me-2 text-muted"></i>
                        <h5 class="mb-0 fw-bold">Section ${sIdx + 1}</h5>
                    </div>
                    <button type="button" class="btn btn-outline-danger btn-sm border-0" onclick="removeSection(this)">
                        <i class="bi bi-trash3"></i>
                    </button>
                </div>
                <div class="card-body p-4">
                    <div class="mb-4">
                        <label class="form-label-custom">Nama / Judul Section</label>
                        <input type="text" name="sections[]" class="form-control form-control-lg fw-semibold" placeholder="Contoh: Dokumen Perencanaan" required>
                    </div>
                    <div class="items-container"></div>
                    <button type="button" class="btn btn-sm btn-outline-primary fw-bold mt-2" onclick="addItem(this)">
                        <i class="bi bi-plus-lg"></i> Tambah Item
                    </button>
                </div>
            </div>`;
        document.getElementById('sectionsContainer').insertAdjacentHTML('beforeend', html);
        initSortable();
        reindexAll();
    }

    function removeSection(btn) {
        if (confirm('Hapus seluruh section ini?')) {
            btn.closest('.section-item').remove();
            reindexAll();
        }
    }

    function removeItem(btn) {
        btn.closest('.item-row').remove();
    }
</script>
@endpush