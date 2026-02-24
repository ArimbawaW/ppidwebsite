@extends('layouts.admin')

@section('title', 'Tambah Halaman Statis')

@push('styles')
<style>
    .section-item {
        border-left: 4px solid #3b82f6;
        border-radius: 8px;
        overflow: hidden;
    }

    .item-row {
        background: #f8fafc;
        padding: 12px;
        border-radius: 8px;
        border: 1px solid #eef2f6;
        transition: .2s ease;
    }

    .item-row:hover {
        border-color: #3b82f6;
        background: #f7fbff;
        box-shadow: 0 4px 12px rgba(59,130,246,.08);
    }

    .btn-add-section {
        transition: all 0.25s;
    }

    .btn-add-section:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 16px rgba(59, 130, 246, 0.25);
    }

    .small-help {
        font-size: .85rem;
        color: #64748b;
    }

    .subsection-container {
        margin-top: 10px;
        padding: 10px;
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
            <h2 class="fw-bold mb-1">Tambah Halaman Statis</h2>
            <p class="text-muted mb-0">Buat halaman template baru seperti Informasi Berkala, Informasi Setiap Saat, dll</p>
        </div>
        <a href="{{ route('admin.halaman-statis.index') }}" class="btn btn-secondary">
            <i class="bi bi-arrow-left me-2"></i>Kembali
        </a>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <form action="{{ route('admin.halaman-statis.store') }}" method="POST" id="formHalaman" enctype="multipart/form-data">
                @csrf

                <div class="alert alert-info">
                    <i class="bi bi-info-circle me-2"></i>
                    <strong>Petunjuk:</strong> Isi informasi dasar halaman, lalu tambahkan section (A, B, C...) dan items di dalamnya. Item bisa memiliki subsection — jika ada subsection, link/file tidak perlu diisi.
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label fw-bold">
                                Slug <span class="text-danger">*</span>
                                <i class="bi bi-question-circle" data-bs-toggle="tooltip" title="URL halaman, contoh: informasi-berkala"></i>
                            </label>
                            <input type="text"
                                   name="slug"
                                   class="form-control @error('slug') is-invalid @enderror"
                                   value="{{ old('slug') }}"
                                   placeholder="informasi-berkala"
                                   required>
                            <small class="text-muted">Akan menjadi URL: /halaman/<strong>informasi-berkala</strong></small>
                            @error('slug')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label fw-bold">
                                Judul Halaman <span class="text-danger">*</span>
                            </label>
                            <input type="text"
                                   name="judul"
                                   class="form-control @error('judul') is-invalid @enderror"
                                   value="{{ old('judul') }}"
                                   placeholder="Informasi Publik yang Wajib Disediakan..."
                                   required>
                            <small class="text-muted">Akan tampil sebagai judul utama halaman</small>
                            @error('judul')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <hr class="my-4">

                <div class="mb-3">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div>
                            <h5 class="fw-bold mb-1">Konten Halaman</h5>
                            <small class="text-muted">Tambahkan section (A, B, C...) dan items di dalamnya.</small>
                        </div>
                        <button type="button" class="btn btn-success btn-add-section" onclick="addSection()">
                            <i class="bi bi-plus-lg me-1"></i>Tambah Section
                        </button>
                    </div>

                    <div id="sectionsContainer"></div>

                    <div class="alert alert-warning mt-3" id="emptyWarning">
                        <i class="bi bi-exclamation-triangle me-2"></i>
                        Belum ada section. Klik tombol <strong>"Tambah Section"</strong> untuk mulai.
                    </div>
                </div>

                <hr class="my-4">

                <div class="mb-4">
                    <div class="form-check form-switch">
                        <input type="checkbox"
                               name="is_active"
                               class="form-check-input"
                               id="is_active"
                               value="1"
                               {{ old('is_active', true) ? 'checked' : '' }}>
                        <label class="form-check-label fw-bold" for="is_active">
                            Aktifkan Halaman
                            <small class="text-muted d-block">Jika tidak dicentang, halaman tidak akan bisa diakses publik</small>
                        </label>
                    </div>
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary btn-lg">
                        <i class="bi bi-save me-2"></i>Simpan Halaman
                    </button>
                    <a href="{{ route('admin.halaman-statis.index') }}" class="btn btn-secondary btn-lg">
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    tooltipTriggerList.map(function (el) { return new bootstrap.Tooltip(el); });
});

function toggleEmptyWarning() {
    const container = document.getElementById('sectionsContainer');
    const warning = document.getElementById('emptyWarning');
    if (!container || !warning) return;
    warning.style.display = container.children.length === 0 ? 'block' : 'none';
}

function addSection() {
    const container = document.getElementById('sectionsContainer');
    const newIndex = container.querySelectorAll('.section-item').length;

    const sectionHTML = `
        <div class="section-item card mb-3" data-index="${newIndex}">
            <div class="card-header bg-light">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="mb-0 fw-bold">
                            <i class="bi bi-folder-fill me-2 text-primary"></i>
                            Section ${newIndex + 1}
                        </h6>
                    </div>
                    <button type="button" class="btn btn-sm btn-danger" onclick="removeSection(this)">
                        <i class="bi bi-trash"></i> Hapus Section
                    </button>
                </div>
            </div>

            <div class="card-body">
                <div class="mb-3">
                    <label class="form-label fw-bold">
                        Judul Section <span class="text-danger">*</span>
                    </label>
                    <input type="text"
                           name="sections[]"
                           class="form-control"
                           placeholder="Contoh: A. Informasi tentang Kementerian"
                           required>
                </div>

                <div class="items-container">
                    <label class="form-label fw-bold d-flex align-items-center gap-2">
                        <i class="bi bi-list-ol me-1"></i>Items dalam Section
                        <small class="text-muted">(isi URL/file, atau tambah subsection)</small>
                    </label>

                    ${buildItemHTML(newIndex)}
                </div>

                <button type="button"
                        class="btn btn-sm btn-outline-primary mt-2"
                        onclick="addItem(this)">
                    <i class="bi bi-plus me-1"></i>Tambah Item
                </button>
            </div>
        </div>
    `;

    container.insertAdjacentHTML('beforeend', sectionHTML);
    reindexSections();
    toggleEmptyWarning();
}

function buildItemHTML(sectionIndex) {
    return `
        <div class="item-row mb-3">
            <div class="row g-2 align-items-start">
                <div class="col-md-5">
                    <input type="text"
                           name="items[${sectionIndex}][]"
                           class="form-control"
                           placeholder="Nama item"
                           required>
                </div>
                <div class="col-md-6">
                    <div class="link-fields">
                        <div class="row g-2">
                            <div class="col-md-6">
                                <input type="url"
                                       name="file_urls[${sectionIndex}][]"
                                       class="form-control"
                                       placeholder="https://example.com/file.pdf (opsional)">
                            </div>
                            <div class="col-md-6">
                                <input type="file"
                                       name="files[${sectionIndex}][]"
                                       class="form-control"
                                       accept=".pdf,.doc,.docx,.xls,.xlsx,.ppt,.pptx,.jpg,.jpeg,.png">
                                <small class="text-muted">Maks 5 MB</small>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-1 d-grid">
                    <button type="button"
                            class="btn btn-sm btn-danger"
                            onclick="removeItem(this)"
                            title="Hapus item">
                        <i class="bi bi-x-lg"></i>
                    </button>
                </div>
            </div>

            {{-- Subsection area --}}
            <div class="mt-2">
                <div class="d-flex align-items-center gap-2 mb-1">
                    <div class="form-check form-switch mb-0">
                        <input type="checkbox" class="form-check-input subsection-toggle" id="" onchange="toggleSubsection(this)">
                        <label class="form-check-label small fw-semibold text-primary">Tambah Subsection</label>
                    </div>
                </div>
                <div class="subsection-wrapper" style="display:none;">
                    <div class="subsection-container">
                        <p class="has-subsection-indicator mb-2"><i class="bi bi-diagram-3 me-1"></i>Subsection dari item ini:</p>
                        <input type="hidden" name="has_subsection[${sectionIndex}][]" value="0" class="has-subsection-flag">
                        <div class="subsections-list">
                            ${buildSubsectionHTML(sectionIndex)}
                        </div>
                        <button type="button" class="btn btn-sm btn-outline-info mt-1" onclick="addSubsection(this, ${sectionIndex})">
                            <i class="bi bi-plus me-1"></i>Tambah Subsection
                        </button>
                    </div>
                </div>
            </div>
        </div>
    `;
}

function buildSubsectionHTML(sectionIndex) {
    return `
        <div class="subsection-row">
            <div class="row g-2 align-items-start">
                <div class="col-md-5">
                    <input type="text"
                           name="subsection_titles[${sectionIndex}][0][]"
                           class="form-control form-control-sm"
                           placeholder="Nama subsection">
                </div>
                <div class="col-md-3">
                    <input type="url"
                           name="subsection_urls[${sectionIndex}][0][]"
                           class="form-control form-control-sm"
                           placeholder="URL (opsional)">
                </div>
                <div class="col-md-3">
                    <input type="file"
                           name="subsection_files[${sectionIndex}][0][]"
                           class="form-control form-control-sm"
                           accept=".pdf,.doc,.docx,.xls,.xlsx,.ppt,.pptx,.jpg,.jpeg,.png">
                </div>
                <div class="col-md-1">
                    <button type="button" class="btn btn-sm btn-danger" onclick="removeSubsection(this)">
                        <i class="bi bi-x"></i>
                    </button>
                </div>
            </div>
        </div>
    `;
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

function addSubsection(btn, sectionIndex) {
    const list = btn.previousElementSibling;
    const itemRow = btn.closest('.item-row');
    const allItemRows = itemRow.closest('.items-container').querySelectorAll('.item-row');
    let itemIndex = 0;
    allItemRows.forEach((row, i) => { if (row === itemRow) itemIndex = i; });

    const html = `
        <div class="subsection-row">
            <div class="row g-2 align-items-start">
                <div class="col-md-5">
                    <input type="text"
                           name="subsection_titles[${sectionIndex}][${itemIndex}][]"
                           class="form-control form-control-sm"
                           placeholder="Nama subsection">
                </div>
                <div class="col-md-3">
                    <input type="url"
                           name="subsection_urls[${sectionIndex}][${itemIndex}][]"
                           class="form-control form-control-sm"
                           placeholder="URL (opsional)">
                </div>
                <div class="col-md-3">
                    <input type="file"
                           name="subsection_files[${sectionIndex}][${itemIndex}][]"
                           class="form-control form-control-sm"
                           accept=".pdf,.doc,.docx,.xls,.xlsx,.ppt,.pptx,.jpg,.jpeg,.png">
                </div>
                <div class="col-md-1">
                    <button type="button" class="btn btn-sm btn-danger" onclick="removeSubsection(this)">
                        <i class="bi bi-x"></i>
                    </button>
                </div>
            </div>
        </div>
    `;
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

function removeSection(button) {
    if (!confirm('Yakin ingin menghapus section ini beserta semua items di dalamnya?')) return;
    const section = button.closest('.section-item');
    if (section) section.remove();
    reindexSections();
    toggleEmptyWarning();
}

function addItem(button) {
    const sectionItem = button.closest('.section-item');
    const sectionIndex = parseInt(sectionItem.dataset.index, 10);
    const itemsContainer = sectionItem.querySelector('.items-container');
    itemsContainer.insertAdjacentHTML('beforeend', buildItemHTML(sectionIndex));
    reindexSections();
}

function removeItem(button) {
    const itemsContainer = button.closest('.items-container');
    const itemCount = itemsContainer.querySelectorAll('.item-row').length;

    if (itemCount <= 1) {
        alert('Setiap section harus memiliki minimal 1 item');
        return;
    }

    button.closest('.item-row').remove();
}

function reindexSections() {
    const sections = document.querySelectorAll('#sectionsContainer .section-item');

    sections.forEach((sectionEl, sIdx) => {
        sectionEl.dataset.index = String(sIdx);
        const headerTitle = sectionEl.querySelector('.card-header h6');
        if (headerTitle) {
            headerTitle.innerHTML = `<i class="bi bi-folder-fill me-2 text-primary"></i>Section ${sIdx + 1}`;
        }

        // Reindex item-level fields
        sectionEl.querySelectorAll('input[name], textarea[name]').forEach((el) => {
            const old = el.getAttribute('name') || '';
            const replaced = old.replace(
                /^(items|file_urls|files|has_subsection|subsection_titles|subsection_urls|subsection_files)\[(\d+)\]/,
                (m, p1) => `${p1}[${sIdx}]`
            );
            if (replaced !== old) el.setAttribute('name', replaced);
        });

        // Reindex subsection item index (second bracket)
        sectionEl.querySelectorAll('.items-container .item-row').forEach((itemEl, iIdx) => {
            itemEl.querySelectorAll('input[name]').forEach(el => {
                const old = el.getAttribute('name') || '';
                const replaced = old.replace(
                    /^(subsection_titles|subsection_urls|subsection_files)\[(\d+)\]\[(\d+)\]/,
                    (m, p1, p2) => `${p1}[${p2}][${iIdx}]`
                );
                if (replaced !== old) el.setAttribute('name', replaced);
            });
        });
    });
}

document.getElementById('formHalaman').addEventListener('submit', function(e) {
    const container = document.getElementById('sectionsContainer');
    const sections = container.querySelectorAll('.section-item');

    if (sections.length === 0) {
        e.preventDefault();
        alert('Anda harus menambahkan minimal 1 section dengan items!');
        return false;
    }

    for (const sectionEl of sections) {
        const itemCount = sectionEl.querySelectorAll('.items-container .item-row').length;
        if (itemCount === 0) {
            e.preventDefault();
            alert('Setiap section harus memiliki minimal 1 item');
            return false;
        }
    }
});
</script>
@endpush