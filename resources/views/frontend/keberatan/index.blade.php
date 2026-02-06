{{-- resources/views/frontend/keberatan/index.blade.php --}}
@extends('layouts.app')

@section('title', 'Formulir Keberatan - PPID')

@section('content')
<div class="container my-5">
    <div class="row">
        <div class="col-lg-10 mx-auto">
            
            {{-- Header --}}
            <div class="text-center mb-5">
                <h2 class="fw-bold mb-3">Formulir Pengajuan Keberatan</h2>
            </div>

            {{-- Alert Success --}}
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show">
                    <i class="bi bi-check-circle me-2"></i>
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
            
            {{-- Form --}}
            <div class="card shadow-sm">
                <div class="card-body p-4">
                    <form action="{{ route('keberatan.store') }}" method="POST" enctype="multipart/form-data" id="formKeberatan">
                        @csrf

                        {{-- SECTION 1: NOMOR PERMOHONAN --}}
                        <div class="mb-4">
                            <h5 class="fw-bold text-primary mb-3">
                                <i class="bi bi-1-circle-fill me-2"></i>Nomor Registrasi Permohonan
                            </h5>
                            
                            <div class="mb-3">
                                <label for="nomor_registrasi_permohonan" class="form-label fw-bold">
                                    Nomor Registrasi Permohonan <span class="text-danger">*</span>
                                </label>
                                <input type="text" 
                                       class="form-control @error('nomor_registrasi_permohonan') is-invalid @enderror" 
                                       id="nomor_registrasi_permohonan" 
                                       name="nomor_registrasi_permohonan" 
                                       value="{{ old('nomor_registrasi_permohonan') }}" 
                                       placeholder="Contoh: PPID-202601-0001"
                                       required>
                                <small class="form-text text-muted">
                                    <i class="bi bi-info-circle me-1"></i>
                                    Masukkan nomor registrasi dari permohonan informasi yang ingin diajukan keberatan
                                </small>
                                @error('nomor_registrasi_permohonan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <hr class="my-4">

                        {{-- SECTION 2: DATA PEMOHON --}}
                        <div class="mb-4">
                            <h5 class="fw-bold text-primary mb-3">
                                <i class="bi bi-2-circle-fill me-2"></i>Data Pemohon
                            </h5>
                            
                            <div class="row">
                                {{-- Nama --}}
                                <div class="col-md-6 mb-3">
                                    <label for="nama_pemohon" class="form-label fw-bold">
                                        Nama Lengkap <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" 
                                           class="form-control @error('nama_pemohon') is-invalid @enderror" 
                                           id="nama_pemohon" 
                                           name="nama_pemohon" 
                                           value="{{ old('nama_pemohon') }}" 
                                           placeholder="Masukkan nama lengkap"
                                           required>
                                    @error('nama_pemohon')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Nomor Kontak --}}
                                <div class="col-md-6 mb-3">
                                    <label for="nomor_kontak" class="form-label fw-bold">
                                        Nomor Kontak <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" 
                                           class="form-control @error('nomor_kontak') is-invalid @enderror" 
                                           id="nomor_kontak" 
                                           name="nomor_kontak" 
                                           value="{{ old('nomor_kontak') }}" 
                                           placeholder="Contoh: 08123456789"
                                           required>
                                    @error('nomor_kontak')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Email (BARU DITAMBAHKAN) --}}
                                <div class="col-md-12 mb-3">
                                    <label for="email" class="form-label fw-bold">
                                        Email <span class="text-danger">*</span>
                                    </label>
                                    <input type="email" 
                                           class="form-control @error('email') is-invalid @enderror" 
                                           id="email" 
                                           name="email" 
                                           value="{{ old('email') }}" 
                                           placeholder="Contoh: email@example.com"
                                           required>
                                    <small class="text-muted">
                                        <i class="bi bi-info-circle me-1"></i>
                                        Email harus sama dengan yang digunakan saat mengajukan permohonan
                                    </small>
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Alamat --}}
                                <div class="col-md-8 mb-3">
                                    <label for="alamat" class="form-label fw-bold">
                                        Alamat <span class="text-danger">*</span>
                                    </label>
                                    <textarea class="form-control @error('alamat') is-invalid @enderror" 
                                              id="alamat" 
                                              name="alamat" 
                                              rows="3" 
                                              placeholder="Masukkan alamat lengkap"
                                              required>{{ old('alamat') }}</textarea>
                                    @error('alamat')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Pekerjaan --}}
                                <div class="col-md-4 mb-3">
                                    <label for="pekerjaan" class="form-label fw-bold">
                                        Pekerjaan <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" 
                                           class="form-control @error('pekerjaan') is-invalid @enderror" 
                                           id="pekerjaan" 
                                           name="pekerjaan" 
                                           value="{{ old('pekerjaan') }}" 
                                           placeholder="Contoh: Pegawai Swasta"
                                           required>
                                    @error('pekerjaan')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Upload Kartu Identitas --}}
                                <div class="col-md-12 mb-3">
                                    <label for="kartu_identitas" class="form-label fw-bold">
                                        Upload Kartu Identitas <span class="text-danger">*</span>
                                    </label>
                                    <input type="file" 
                                           class="form-control @error('kartu_identitas') is-invalid @enderror" 
                                           id="kartu_identitas" 
                                           name="kartu_identitas" 
                                           accept=".pdf,.jpg,.jpeg,.png" 
                                           required>
                                    <small class="form-text text-muted">
                                        <i class="bi bi-info-circle me-1"></i>
                                        Format: PDF, JPG, PNG (Max: 2MB) | KTP / KK / SIM / Paspor
                                    </small>
                                    @error('kartu_identitas')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <hr class="my-4">

                        {{-- SECTION 3: INFORMASI YANG DIMINTA --}}
                        <div class="mb-4">
                            <h5 class="fw-bold text-primary mb-3">
                                <i class="bi bi-3-circle-fill me-2"></i>Rincian Informasi
                            </h5>

                            <div class="mb-3">
                                <label for="informasi_diminta" class="form-label fw-bold">
                                    Informasi yang Diminta <span class="text-danger">*</span>
                                </label>
                                <textarea class="form-control @error('informasi_diminta') is-invalid @enderror" 
                                          id="informasi_diminta" 
                                          name="informasi_diminta" 
                                          rows="4" 
                                          placeholder="Jelaskan secara rinci informasi apa yang Anda minta dalam permohonan sebelumnya"
                                          required>{{ old('informasi_diminta') }}</textarea>
                                @error('informasi_diminta')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="tujuan_penggunaan" class="form-label fw-bold">
                                    Tujuan Penggunaan Informasi <span class="text-danger">*</span>
                                </label>
                                <textarea class="form-control @error('tujuan_penggunaan') is-invalid @enderror" 
                                          id="tujuan_penggunaan" 
                                          name="tujuan_penggunaan" 
                                          rows="4" 
                                          placeholder="Jelaskan untuk apa informasi tersebut akan digunakan"
                                          required>{{ old('tujuan_penggunaan') }}</textarea>
                                @error('tujuan_penggunaan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <hr class="my-4">

                        {{-- SECTION 4: ALASAN KEBERATAN --}}
                        <div class="mb-4">
                            <h5 class="fw-bold text-primary mb-3">
                                <i class="bi bi-4-circle-fill me-2"></i>Alasan Pengajuan Keberatan
                            </h5>

                            <div class="mb-3">
                                <label class="form-label fw-bold">
                                    Pilih Alasan Keberatan (Pasal 35 ayat 1 UU KIP) <span class="text-danger">*</span>
                                </label>

                                <div class="list-group">
                                    <label class="list-group-item">
                                        <input class="form-check-input me-3" type="radio" name="alasan_keberatan" value="penolakan_pasal_17" {{ old('alasan_keberatan') == 'penolakan_pasal_17' ? 'checked' : '' }} required>
                                        <strong>a.</strong> Penolakan berdasarkan alasan sebagaimana dimaksud dalam Pasal 17 UU KIP
                                    </label>
                                    <label class="list-group-item">
                                        <input class="form-check-input me-3" type="radio" name="alasan_keberatan" value="tidak_disediakan_berkala" {{ old('alasan_keberatan') == 'tidak_disediakan_berkala' ? 'checked' : '' }}>
                                        <strong>b.</strong> Tidak disediakan informasi berkala
                                    </label>
                                    <label class="list-group-item">
                                        <input class="form-check-input me-3" type="radio" name="alasan_keberatan" value="tidak_ditanggapi" {{ old('alasan_keberatan') == 'tidak_ditanggapi' ? 'checked' : '' }}>
                                        <strong>c.</strong> Tidak ditanggapinya permintaan informasi
                                    </label>
                                    <label class="list-group-item">
                                        <input class="form-check-input me-3" type="radio" name="alasan_keberatan" value="tidak_sesuai_permintaan" {{ old('alasan_keberatan') == 'tidak_sesuai_permintaan' ? 'checked' : '' }}>
                                        <strong>d.</strong> Permintaan informasi tidak ditanggapi sebagaimana yang diminta
                                    </label>
                                    <label class="list-group-item">
                                        <input class="form-check-input me-3" type="radio" name="alasan_keberatan" value="tidak_dipenuhi" {{ old('alasan_keberatan') == 'tidak_dipenuhi' ? 'checked' : '' }}>
                                        <strong>e.</strong> Tidak dipenuhinya permintaan informasi
                                    </label>
                                    <label class="list-group-item">
                                        <input class="form-check-input me-3" type="radio" name="alasan_keberatan" value="biaya_tidak_wajar" {{ old('alasan_keberatan') == 'biaya_tidak_wajar' ? 'checked' : '' }}>
                                        <strong>f.</strong> Pengenaan biaya yang tidak wajar
                                    </label>
                                    <label class="list-group-item">
                                        <input class="form-check-input me-3" type="radio" name="alasan_keberatan" value="melebihi_jangka_waktu" {{ old('alasan_keberatan') == 'melebihi_jangka_waktu' ? 'checked' : '' }}>
                                        <strong>g.</strong> Penyampaian informasi yang melebihi jangka waktu yang diatur dalam UU KIP
                                    </label>
                                </div>

                                @error('alasan_keberatan')
                                    <div class="text-danger small mt-2">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <hr class="my-4">

                        {{-- SECTION 5: URAIAN KEBERATAN --}}
                        <div class="mb-4">
                            <h5 class="fw-bold text-primary mb-3">
                                <i class="bi bi-5-circle-fill me-2"></i>Uraian Keberatan
                            </h5>

                            <div class="mb-3">
                                <label for="uraian_keberatan" class="form-label fw-bold">
                                    Jelaskan Kasus Anda <span class="text-danger">*</span>
                                </label>
                                <textarea class="form-control @error('uraian_keberatan') is-invalid @enderror" 
                                          id="uraian_keberatan" 
                                          name="uraian_keberatan" 
                                          rows="6" 
                                          placeholder="Jelaskan secara detail kronologi dan alasan pengajuan keberatan Anda."
                                          required>{{ old('uraian_keberatan') }}</textarea>
                                
                                @error('uraian_keberatan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <hr class="my-4">

                        {{-- SUBMIT BUTTON --}}
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="bi bi-send me-2"></i>Kirim Keberatan
                            </button>
                            <a href="{{ route('home') }}" class="btn btn-outline-secondary">
                                <i class="bi bi-arrow-left me-2"></i>Kembali
                            </a>
                        </div>
                    </form>
                </div>
            </div>

            {{-- Info Box --}}
            <div class="card mt-4 bg-light border-0">
                <div class="card-body">
                    <h6 class="fw-bold mb-3">
                        <i class="bi bi-info-circle-fill text-primary me-2"></i>
                        Informasi Penting
                    </h6>
                    <ul class="mb-0 small">
                        <li>Pastikan nomor registrasi permohonan yang Anda masukkan sudah benar</li>
                        <li>Isi semua field yang bertanda <span class="text-danger">*</span> (wajib)</li>
                        <li>Jelaskan alasan keberatan dengan lengkap dan jelas</li>
                        <li>Setelah mengirim, Anda akan mendapat nomor registrasi keberatan untuk tracking</li>
                        <li>Proses penanganan keberatan maksimal 30 hari kerja sesuai UU KIP</li>
                    </ul>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
.list-group-item { cursor: pointer; transition: all 0.3s; }
.list-group-item:hover { background-color: #f8f9fa; }
.list-group-item input[type="radio"]:checked ~ * { font-weight: 600; }
.list-group-item:has(input[type="radio"]:checked) { background-color: #e7f3ff; border-color: #0d6efd; }

.alert {
    animation: slideDown 0.3s ease-out;
}

@keyframes slideDown {
    from {
        opacity: 0;
        transform: translateY(-20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.alert-danger {
    border-left: 4px solid #dc3545;
}
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // File validation function
    function validateFileSize(input, maxSizeMB = 2) {
        if (input.files && input.files[0]) {
            const fileSize = input.files[0].size / 1024 / 1024; // Convert to MB
            
            if (fileSize > maxSizeMB) {
                // Show error message
                const errorDiv = document.createElement('div');
                errorDiv.className = 'alert alert-danger alert-dismissible fade show mt-2';
                errorDiv.innerHTML = `
                    <i class="bi bi-exclamation-triangle me-2"></i>
                    <strong>Ukuran file terlalu besar!</strong> 
                    File yang Anda upload berukuran ${fileSize.toFixed(2)} MB. 
                    Maksimal ukuran file adalah ${maxSizeMB} MB.
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                `;
                
                // Remove existing error if any
                const existingError = input.parentElement.querySelector('.alert-danger');
                if (existingError) {
                    existingError.remove();
                }
                
                // Insert error after small text
                const smallText = input.parentElement.querySelector('.form-text');
                if (smallText) {
                    smallText.insertAdjacentElement('afterend', errorDiv);
                } else {
                    input.insertAdjacentElement('afterend', errorDiv);
                }
                
                // Clear the input
                input.value = '';
                
                // Scroll to error
                errorDiv.scrollIntoView({ behavior: 'smooth', block: 'center' });
                
                return false;
            } else {
                // Show file info if valid
                const fileName = input.files[0].name;
                let infoDiv = input.parentElement.querySelector('.file-info');
                if (!infoDiv) {
                    infoDiv = document.createElement('div');
                    infoDiv.className = 'file-info small text-success mt-1';
                    const smallText = input.parentElement.querySelector('.form-text');
                    if (smallText) {
                        smallText.insertAdjacentElement('afterend', infoDiv);
                    } else {
                        input.insertAdjacentElement('afterend', infoDiv);
                    }
                }
                
                infoDiv.innerHTML = `
                    <i class="bi bi-file-earmark-check me-1"></i>
                    ${fileName} (${fileSize.toFixed(2)} MB)
                `;
            }
        }
        return true;
    }
    
    // Add file size validation to all file inputs
    const fileInputs = document.querySelectorAll('input[type="file"]');
    fileInputs.forEach(input => {
        input.addEventListener('change', function() {
            // Remove any existing error messages
            const existingError = this.parentElement.querySelector('.alert-danger');
            if (existingError) {
                existingError.remove();
            }
            
            // Remove any existing file info
            const existingInfo = this.parentElement.querySelector('.file-info');
            if (existingInfo) {
                existingInfo.remove();
            }
            
            // Validate file size
            validateFileSize(this);
        });
    });
    
    // Prevent form submission if file size is invalid
    document.getElementById('formKeberatan').addEventListener('submit', function(e) {
        let isValid = true;
        
        fileInputs.forEach(input => {
            if (input.files && input.files[0]) {
                if (!validateFileSize(input)) {
                    isValid = false;
                }
            }
        });
        
        if (!isValid) {
            e.preventDefault();
            
            // Show alert at top
            const alertDiv = document.createElement('div');
            alertDiv.className = 'alert alert-danger alert-dismissible fade show';
            alertDiv.innerHTML = `
                <i class="bi bi-exclamation-triangle me-2"></i>
                <strong>Gagal mengirim keberatan!</strong> 
                Terdapat file yang melebihi ukuran maksimal (2 MB). 
                Silakan periksa kembali file yang Anda upload.
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            `;
            
            // Remove existing alert if any
            const existingAlert = document.querySelector('.card-body > .alert-danger');
            if (existingAlert) {
                existingAlert.remove();
            }
            
            // Insert at top of form
            const formCard = document.querySelector('.card-body');
            formCard.insertBefore(alertDiv, formCard.firstChild);
            
            // Scroll to top
            window.scrollTo({ top: 0, behavior: 'smooth' });
        }
    });
});
</script>
@endpush