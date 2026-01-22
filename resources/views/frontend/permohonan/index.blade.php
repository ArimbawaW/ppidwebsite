@extends('layouts.app')

@section('title', 'Permohonan Informasi - PPID')

@push('styles')
<style>
    .dynamic-fields {
        display: none;
        animation: fadeIn 0.5s;
    }
    
    .dynamic-fields.show {
        display: block;
    }
    
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(-10px); }
        to { opacity: 1; transform: translateY(0); }
    }
    
    .required-badge {
        background-color: #dc3545;
        color: white;
        font-size: 0.7rem;
        padding: 2px 6px;
        border-radius: 3px;
        margin-left: 5px;
    }
</style>
@endpush

@section('content')
<div class="container my-5">
    <h2 class="mb-4 fw-bold">Formulir Permohonan Informasi</h2>
    <div class="row">
        <div class="col-md-8">
            <div class="card shadow-sm border-0">
                <div class="card-body p-4">
                    <form action="{{ route('permohonan.store') }}" method="POST" enctype="multipart/form-data" id="formPermohonan">
                        @csrf
                        
                        {{-- STEP 1: KATEGORI PEMOHON --}}
                        <div class="mb-5">
                            <h5 class="fw-bold mb-3">
                                <i class="bi bi-person-badge me-2"></i>
                                Kategori Klasifikasi Pemohon
                                <span class="required-badge">WAJIB</span>
                            </h5>
                            
                            <div class="mb-3">
                                <label class="form-label fw-bold">
                                    Pilih Kategori Pemohon <span class="text-danger">*</span>
                                </label>
                                <select name="kategori_pemohon" 
                                        id="kategoriPemohon"
                                        class="form-select @error('kategori_pemohon') is-invalid @enderror" 
                                        required>
                                    <option value="">-- Pilih Kategori Pemohon --</option>
                                    <option value="perorangan" {{ old('kategori_pemohon') == 'perorangan' ? 'selected' : '' }}>
                                        Perorangan (Individu/Perseorangan)
                                    </option>
                                    <option value="kelompok" {{ old('kategori_pemohon') == 'kelompok' ? 'selected' : '' }}>
                                        Kelompok Orang (Organisasi/Komunitas)
                                    </option>
                                    <option value="badan_hukum" {{ old('kategori_pemohon') == 'badan_hukum' ? 'selected' : '' }}>
                                        Badan Hukum (Perusahaan/Lembaga)
                                    </option>
                                </select>
                                @error('kategori_pemohon')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <hr class="my-4">

                        {{-- STEP 2: DATA PEMOHON --}}
                        <div class="mb-4">
                            <h5 class="fw-bold mb-3">
                                <i class="bi bi-person-lines-fill me-2"></i>
                                Data Pemohon
                            </h5>

                            <div class="row">
                                {{-- Nama --}}
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">
                                        Nama Lengkap <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" name="nama" 
                                           class="form-control @error('nama') is-invalid @enderror" 
                                           value="{{ old('nama') }}" 
                                           placeholder="Masukkan nama lengkap" required>
                                    @error('nama')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Pekerjaan --}}
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">
                                        Pekerjaan <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" name="pekerjaan" 
                                           class="form-control @error('pekerjaan') is-invalid @enderror" 
                                           value="{{ old('pekerjaan') }}" 
                                           placeholder="Contoh: PNS, Wiraswasta, Mahasiswa" required>
                                    @error('pekerjaan')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Alamat --}}
                                <div class="col-md-12 mb-3">
                                    <label class="form-label fw-bold">
                                        Alamat Lengkap <span class="text-danger">*</span>
                                    </label>
                                    <textarea name="alamat" 
                                              class="form-control @error('alamat') is-invalid @enderror" 
                                              rows="3" 
                                              placeholder="Masukkan alamat lengkap termasuk RT/RW, Kelurahan, Kecamatan, Kota/Kabupaten, Provinsi" required>{{ old('alamat') }}</textarea>
                                    @error('alamat')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- No Telepon --}}
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">
                                        No. Telepon/HP <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" name="no_telepon" 
                                           class="form-control @error('no_telepon') is-invalid @enderror" 
                                           value="{{ old('no_telepon') }}" 
                                           placeholder="Contoh: 08123456789" required>
                                    @error('no_telepon')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Email --}}
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">
                                        Email <span class="text-danger">*</span>
                                    </label>
                                    <input type="email" name="email" 
                                           class="form-control @error('email') is-invalid @enderror" 
                                           value="{{ old('email') }}" 
                                           placeholder="contoh@email.com" required>
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <hr class="my-4">

                        {{-- STEP 3: RINCIAN PERMOHONAN --}}
                        <div class="mb-4">
                            <h5 class="fw-bold mb-3">
                                <i class="bi bi-file-text me-2"></i>
                                Rincian Permohonan Informasi
                            </h5>

                            {{-- Rincian Informasi --}}
                            <div class="mb-3">
                                <label class="form-label fw-bold">
                                    Rincian Informasi yang Dibutuhkan <span class="text-danger">*</span>
                                </label>
                                <textarea name="rincian_informasi" 
                                          class="form-control @error('rincian_informasi') is-invalid @enderror" 
                                          rows="4" 
                                          placeholder="Jelaskan secara detail dan spesifik informasi apa yang Anda butuhkan..." required>{{ old('rincian_informasi') }}</textarea>
                                @error('rincian_informasi')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Tujuan Penggunaan --}}
                            <div class="mb-3">
                                <label class="form-label fw-bold">
                                    Tujuan Penggunaan Informasi <span class="text-danger">*</span>
                                </label>
                                <textarea name="tujuan_penggunaan" 
                                          class="form-control @error('tujuan_penggunaan') is-invalid @enderror" 
                                          rows="4" 
                                          placeholder="Jelaskan untuk apa informasi ini akan digunakan..." required>{{ old('tujuan_penggunaan') }}</textarea>
                                @error('tujuan_penggunaan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <hr class="my-4">

                        {{-- STEP 4: DOKUMEN KELENGKAPAN (DYNAMIC) --}}
                        <div class="mb-4">
                            <h5 class="fw-bold mb-3">
                                <i class="bi bi-file-earmark-arrow-up me-2"></i>
                                Dokumen Kelengkapan
                            </h5>

                            {{-- UNTUK PERORANGAN --}}
                            <div id="fields-perorangan" class="dynamic-fields">
                                <div class="alert alert-info">
                                    <i class="bi bi-info-circle me-2"></i>
                                    <strong>Dokumen untuk Perorangan:</strong> KTP, Paspor, atau SIM
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-bold">
                                        Jenis Kartu Identitas <span class="text-danger">*</span>
                                    </label>
                                    <select name="jenis_identitas" 
                                            class="form-select @error('jenis_identitas') is-invalid @enderror">
                                        <option value="">-- Pilih Jenis Identitas --</option>
                                        <option value="KTP" {{ old('jenis_identitas') == 'KTP' ? 'selected' : '' }}>KTP</option>
                                        <option value="Paspor" {{ old('jenis_identitas') == 'Paspor' ? 'selected' : '' }}>Paspor</option>
                                        <option value="SIM" {{ old('jenis_identitas') == 'SIM' ? 'selected' : '' }}>SIM</option>
                                    </select>
                                    @error('jenis_identitas')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-bold">
                                        Nomor Identitas <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" name="nomor_identitas" 
                                           class="form-control @error('nomor_identitas') is-invalid @enderror" 
                                           value="{{ old('nomor_identitas') }}" 
                                           placeholder="Masukkan nomor identitas">
                                    @error('nomor_identitas')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-bold">
                                        Upload Kartu Identitas <span class="text-danger">*</span>
                                    </label>
                                    <input type="file" name="file_identitas" 
                                           class="form-control @error('file_identitas') is-invalid @enderror" 
                                           accept=".pdf,.jpg,.jpeg,.png">
                                    <small class="form-text text-muted">Format: PDF, JPG, PNG (Max: 2MB)</small>
                                    @error('file_identitas')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            {{-- UNTUK KELOMPOK ORANG --}}
                            <div id="fields-kelompok" class="dynamic-fields">
                                <div class="alert alert-info">
                                    <i class="bi bi-info-circle me-2"></i>
                                    <strong>Dokumen untuk Kelompok Orang:</strong> Surat Kuasa dan KTP Pemberi Kuasa
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-bold">
                                        Nomor KTP Pemberi Kuasa <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" name="nomor_ktp_pemberi_kuasa" 
                                           class="form-control @error('nomor_ktp_pemberi_kuasa') is-invalid @enderror" 
                                           value="{{ old('nomor_ktp_pemberi_kuasa') }}" 
                                           placeholder="Masukkan nomor KTP pemberi kuasa">
                                    @error('nomor_ktp_pemberi_kuasa')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-bold">
                                        Upload Surat Kuasa <span class="text-danger">*</span>
                                    </label>
                                    <input type="file" name="file_surat_kuasa" 
                                           class="form-control @error('file_surat_kuasa') is-invalid @enderror" 
                                           accept=".pdf">
                                    <small class="form-text text-muted">Format: PDF (Max: 2MB)</small>
                                    @error('file_surat_kuasa')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-bold">
                                        Upload KTP Pemberi Kuasa <span class="text-danger">*</span>
                                    </label>
                                    <input type="file" name="file_ktp_pemberi_kuasa" 
                                           class="form-control @error('file_ktp_pemberi_kuasa') is-invalid @enderror" 
                                           accept=".pdf,.jpg,.jpeg,.png">
                                    <small class="form-text text-muted">Format: PDF, JPG, PNG (Max: 2MB)</small>
                                    @error('file_ktp_pemberi_kuasa')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            {{-- UNTUK BADAN HUKUM --}}
                            <div id="fields-badan_hukum" class="dynamic-fields">
                                <div class="alert alert-info">
                                    <i class="bi bi-info-circle me-2"></i>
                                    <strong>Dokumen untuk Badan Hukum:</strong> Akta AHU dan AD/ART
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-bold">
                                        Nomor Akta AHU Kementerian Hukum RI <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" name="nomor_akta_ahu" 
                                           class="form-control @error('nomor_akta_ahu') is-invalid @enderror" 
                                           value="{{ old('nomor_akta_ahu') }}" 
                                           placeholder="Masukkan nomor akta AHU">
                                    @error('nomor_akta_ahu')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-bold">
                                        Upload Akta AHU Kementerian Hukum RI <span class="text-danger">*</span>
                                    </label>
                                    <input type="file" name="file_akta_ahu" 
                                           class="form-control @error('file_akta_ahu') is-invalid @enderror" 
                                           accept=".pdf">
                                    <small class="form-text text-muted">Format: PDF (Max: 2MB)</small>
                                    @error('file_akta_ahu')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-bold">
                                        Upload Anggaran Dasar/Anggaran Rumah Tangga (AD/ART) <span class="text-danger">*</span>
                                    </label>
                                    <input type="file" name="file_ad_art" 
                                           class="form-control @error('file_ad_art') is-invalid @enderror" 
                                           accept=".pdf">
                                    <small class="form-text text-muted">Format: PDF (Max: 2MB)</small>
                                    @error('file_ad_art')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <hr class="my-4">

                        {{-- STEP 5: TERMS AND CONDITIONS --}}
                        <div class="mb-4">
                            <div class="card border-warning">
                                <div class="card-body">
                                    <h6 class="fw-bold mb-3">
                                        <i class="bi bi-shield-check me-2"></i>
                                        Persetujuan dan Pernyataan
                                    </h6>
                                    
                                    <div class="form-check">
                                        <input class="form-check-input @error('persetujuan_terms') is-invalid @enderror" 
                                               type="checkbox" 
                                               name="persetujuan_terms" 
                                               id="persetujuan_terms" 
                                               value="1"
                                               {{ old('persetujuan_terms') ? 'checked' : '' }} 
                                               required>
                                        <label class="form-check-label" for="persetujuan_terms">
                                            Saya menyatakan bahwa informasi yang diperoleh <strong>tidak akan disalahgunakan</strong> 
                                            dan <strong>hanya digunakan sebagaimana mestinya</strong> sesuai dengan tujuan yang telah saya sampaikan. 
                                            Saya memahami dan bertanggung jawab penuh atas penggunaan informasi yang diberikan.
                                        </label>
                                        @error('persetujuan_terms')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- SUBMIT BUTTON --}}
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="bi bi-send-fill me-2"></i>
                                Kirim Permohonan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        {{-- SIDEBAR INFO --}}
        <div class="col-md-4">
            <div class="card shadow-sm border-0 mb-3">
                <div class="card-body">
                    <h6 class="card-title fw-bold">
                        <i class="bi bi-info-circle-fill text-primary me-2"></i>
                        Informasi Penting
                    </h6>
                    <hr>
                    <ul class="small mb-0">
                        <li class="mb-2">Pilih kategori pemohon sesuai dengan status Anda</li>
                        <li class="mb-2">Isi semua field yang ditandai dengan (<span class="text-danger">*</span>)</li>
                        <li class="mb-2">Pastikan dokumen yang diupload jelas dan terbaca</li>
                        <li class="mb-2">Setelah mengirim, Anda akan mendapat nomor registrasi</li>
                        <li class="mb-2">Gunakan nomor registrasi untuk mengecek status permohonan</li>
                    </ul>
                </div>
            </div>

            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <h6 class="card-title fw-bold">
                        <i class="bi bi-clock-fill text-success me-2"></i>
                        Waktu Proses
                    </h6>
                    <hr>
                    <p class="small mb-0">
                        Permohonan akan diproses maksimal <strong>10 hari kerja</strong> 
                        sesuai dengan UU No. 14 Tahun 2008 tentang Keterbukaan Informasi Publik.
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const kategoriPemohon = document.getElementById('kategoriPemohon');
    
    // Function to show/hide dynamic fields
    function updateDynamicFields() {
        const selectedKategori = kategoriPemohon.value;
        
        // Hide all dynamic fields first
        document.querySelectorAll('.dynamic-fields').forEach(field => {
            field.classList.remove('show');
            field.querySelectorAll('input, select, textarea').forEach(input => {
                input.removeAttribute('required');
            });
        });
        
        if (selectedKategori) {
            const targetFields = document.getElementById(`fields-${selectedKategori}`);
            
            if (targetFields) {
                targetFields.classList.add('show');
                targetFields.querySelectorAll('input, select, textarea').forEach(input => {
                    if (input.closest('.mb-3').querySelector('label').textContent.includes('*')) {
                        input.setAttribute('required', 'required');
                    }
                });
            }
        }
    }
    
    // Handle kategori change
    kategoriPemohon.addEventListener('change', updateDynamicFields);
    
    // Initialize on page load (untuk handle old() values)
    updateDynamicFields();
});
</script>
@endpush