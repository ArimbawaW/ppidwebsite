@extends('layouts.admin')

@section('title', 'Detail Permohonan')

@push('styles')
<style>
    /* Force badge visibility */
    .badge {
        display: inline-block !important;
        padding: 0.5rem 0.75rem !important;
        font-size: 0.875rem !important;
        font-weight: 600 !important;
        line-height: 1 !important;
        text-align: center !important;
        white-space: nowrap !important;
        vertical-align: baseline !important;
        border-radius: 0.25rem !important;
        margin: 0.15rem !important;
    }

    .badge-lg {
        font-size: 1rem !important;
        padding: 0.5rem 1rem !important;
    }

    .badge-primary {
        color: #fff !important;
        background-color: #007bff !important;
    }

    .badge-success {
        color: #fff !important;
        background-color: #28a745 !important;
    }

    .badge-warning {
        color: #212529 !important;
        background-color: #ffc107 !important;
    }

    .badge-info {
        color: #fff !important;
        background-color: #17a2b8 !important;
    }

    .badge-danger {
        color: #fff !important;
        background-color: #dc3545 !important;
    }

    .badge-secondary {
        color: #fff !important;
        background-color: #6c757d !important;
    }

    /* Force icon visibility */
    .fas,
    .far,
    .fab,
    .fa {
        display: inline-block !important;
        font-family: "Font Awesome 5 Free" !important;
        font-weight: 900 !important;
        font-style: normal !important;
        font-variant: normal !important;
        text-rendering: auto !important;
        line-height: 1 !important;
        -webkit-font-smoothing: antialiased !important;
        margin-right: 0.25rem !important;
    }

    .far {
        font-weight: 400 !important;
    }

    /* Border styles */
    .border-left-primary {
        border-left: 0.25rem solid #4e73df !important;
    }

    .border-left-warning {
        border-left: 0.25rem solid #f6c23e !important;
    }

    .border-primary {
        border-color: #007bff !important;
    }

    .border-success {
        border-color: #28a745 !important;
    }

    .border-warning {
        border-color: #ffc107 !important;
    }

    /* Table styles */
    .table-borderless td,
    .table-borderless th {
        border: 0 !important;
        padding: 0.5rem 0 !important;
    }

    .table-borderless tr {
        border-bottom: 1px solid #e3e6f0 !important;
    }

    .table-borderless tr:last-child {
        border-bottom: 0 !important;
    }

    /* Card header colors */
    .bg-primary {
        background-color: #007bff !important;
    }

    .bg-info {
        background-color: #17a2b8 !important;
    }

    .bg-secondary {
        background-color: #6c757d !important;
    }

    .bg-success {
        background-color: #28a745 !important;
    }

    .bg-purple {
        background-color: #6f42c1 !important;
    }

    /* Button styles */
    .btn {
        display: inline-flex !important;
        align-items: center !important;
        justify-content: center !important;
    }

    .btn i {
        margin-right: 0.25rem !important;
    }

    /* Shadow */
    .shadow {
        box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15) !important;
    }

    .shadow-sm {
        box-shadow: 0 0.125rem 0.25rem 0 rgba(58, 59, 69, 0.2) !important;
    }

    /* Lainnya field styling */
    #lainnya_field {
        margin-top: 10px;
        display: none;
    }
</style>
@endpush

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">Detail Permohonan</h1>
        <a href="{{ route('admin.permohonan.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle"></i> {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert">
                <span>&times;</span>
            </button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
            <button type="button" class="close" data-dismiss="alert">
                <span>&times;</span>
            </button>
        </div>
    @endif

    <!-- Nomor Registrasi & Status -->
    <div class="row mb-4">
        <div class="col-lg-12">
            <div class="card shadow-sm border-left-primary">
                <div class="card-body py-3">
                    <div class="row align-items-center">
                        <div class="col-md-8">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Nomor Registrasi
                            </div>
                            <div class="h4 mb-0 font-weight-bold text-gray-800">
                                {{ $permohonan->nomor_registrasi }}
                            </div>
                        </div>
                        <div class="col-md-4 text-right">
                            @if($permohonan->status === 'perlu_verifikasi')
                                <span class="badge badge-warning badge-lg">
                                    <i class="fas fa-exclamation-circle"></i> Perlu Verifikasi
                                </span>
                            @elseif($permohonan->status === 'diproses')
                                <span class="badge badge-info badge-lg">
                                    <i class="fas fa-spinner fa-spin"></i> Sedang Diproses
                                </span>
                            @elseif($permohonan->status === 'ditunda')
                                <span class="badge badge-secondary badge-lg">
                                    <i class="fas fa-pause-circle"></i> Ditunda
                                </span>
                            @elseif($permohonan->status === 'dikabulkan_seluruhnya')
                                <span class="badge badge-success badge-lg">
                                    <i class="fas fa-check-circle"></i> Dikabulkan Seluruhnya
                                </span>
                            @elseif($permohonan->status === 'dikabulkan_sebagian')
                                <span class="badge badge-success badge-lg">
                                    <i class="fas fa-check-circle"></i> Dikabulkan Sebagian
                                </span>
                            @else
                                <span class="badge badge-danger badge-lg">
                                    <i class="fas fa-times-circle"></i> Ditolak
                                </span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Data Pemohon -->
        <div class="col-lg-6 mb-4">
            <div class="card shadow h-100">
                <div class="card-header py-3 bg-primary text-white">
                    <h6 class="m-0 font-weight-bold">
                        <i class="fas fa-user"></i> Data Pemohon
                    </h6>
                </div>
                <div class="card-body">
                    <table class="table table-sm table-borderless">
                        <tr>
                            <th width="40%">Kategori</th>
                            <td>
                                @if($permohonan->kategori_pemohon === 'perorangan')
                                    <span class="badge badge-primary">
                                        <i class="fas fa-user"></i> Perorangan
                                    </span>
                                @elseif($permohonan->kategori_pemohon === 'kelompok')
                                    <span class="badge badge-success">
                                        <i class="fas fa-users"></i> Kelompok Orang
                                    </span>
                                @else
                                    <span class="badge badge-warning">
                                        <i class="fas fa-building"></i> Badan Hukum
                                    </span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>Nama</th>
                            <td><strong>{{ $permohonan->nama }}</strong></td>
                        </tr>
                        <tr>
                            <th>Pekerjaan</th>
                            <td>{{ $permohonan->pekerjaan }}</td>
                        </tr>
                        <tr>
                            <th>Email</th>
                            <td>
                                <i class="fas fa-envelope text-muted"></i>
                                {{ $permohonan->email }}
                            </td>
                        </tr>
                        <tr>
                            <th>No. Telepon</th>
                            <td>
                                <i class="fas fa-phone text-muted"></i>
                                {{ $permohonan->no_telepon }}
                            </td>
                        </tr>
                        <tr>
                            <th>Alamat</th>
                            <td>{{ $permohonan->alamat }}</td>
                        </tr>
                    </table>

                    {{-- Informasi Tambahan Berdasarkan Kategori --}}
                    @if($permohonan->kategori_pemohon === 'perorangan')
                        <hr>
                        <h6 class="font-weight-bold text-primary mb-3">
                            <i class="fas fa-id-card"></i> Identitas
                        </h6>
                        <table class="table table-sm table-borderless">
                            <tr>
                                <th width="40%">Jenis Identitas</th>
                                <td>{{ $permohonan->jenis_identitas ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th>Nomor Identitas</th>
                                <td>{{ $permohonan->nomor_identitas ?? '-' }}</td>
                            </tr>
                        </table>
                    @elseif($permohonan->kategori_pemohon === 'kelompok')
                        <hr>
                        <h6 class="font-weight-bold text-success mb-3">
                            <i class="fas fa-users"></i> Data Pemberi Kuasa
                        </h6>
                        <table class="table table-sm table-borderless">
                            <tr>
                                <th width="40%">No. KTP Pemberi Kuasa</th>
                                <td>{{ $permohonan->nomor_ktp_pemberi_kuasa ?? '-' }}</td>
                            </tr>
                        </table>
                    @elseif($permohonan->kategori_pemohon === 'badan_hukum')
                        <hr>
                        <h6 class="font-weight-bold text-warning mb-3">
                            <i class="fas fa-building"></i> Data Badan Hukum
                        </h6>
                        <table class="table table-sm table-borderless">
                            <tr>
                                <th width="40%">No. Akta AHU</th>
                                <td>{{ $permohonan->nomor_akta_ahu ?? '-' }}</td>
                            </tr>
                        </table>
                    @endif
                </div>
            </div>
        </div>

        <!-- Rincian Permohonan -->
        <div class="col-lg-6 mb-4">
            <div class="card shadow h-100">
                <div class="card-header py-3 bg-info text-white">
                    <h6 class="m-0 font-weight-bold">
                        <i class="fas fa-file-alt"></i> Rincian Permohonan
                    </h6>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <strong class="text-primary">
                            <i class="fas fa-info-circle"></i> Rincian Informasi:
                        </strong>
                        <p class="text-muted mb-0 mt-1">{{ $permohonan->rincian_informasi }}</p>
                    </div>
                    <hr>
                    <div class="mb-3">
                        <strong class="text-primary">
                            <i class="fas fa-bullseye"></i> Tujuan Penggunaan:
                        </strong>
                        <p class="text-muted mb-0 mt-1">{{ $permohonan->tujuan_penggunaan }}</p>
                    </div>
                    <hr>
                    <div class="mb-3">
                        <strong class="text-primary">
                            <i class="far fa-calendar-plus"></i> Tanggal Pengajuan:
                        </strong>
                        <p class="text-muted mb-0 mt-1">
                            {{ $permohonan->created_at->format('d F Y, H:i') }} WIB
                        </p>
                    </div>
                    @if($permohonan->tanggal_selesai)
                        <div>
                            <strong class="text-primary">
                                <i class="far fa-calendar-check"></i> Tanggal Selesai:
                            </strong>
                            <p class="text-muted mb-0 mt-1">
                                {{ $permohonan->tanggal_selesai->format('d F Y, H:i') }} WIB
                            </p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Dokumen Lampiran -->
    <div class="row">
        <div class="col-lg-12 mb-4">
            <div class="card shadow">
                <div class="card-header py-3 bg-secondary text-white">
                    <h6 class="m-0 font-weight-bold">
                        <i class="fas fa-paperclip"></i> Dokumen Lampiran
                    </h6>
                </div>
                <div class="card-body">
                    @php
                        $hasFiles = false;
                    @endphp

                    <div class="row">
                        {{-- Untuk Perorangan --}}
                        @if($permohonan->kategori_pemohon === 'perorangan' && $permohonan->file_identitas_path)
                            @php $hasFiles = true; @endphp
                            <div class="col-md-4 mb-3">
                                <div class="card border-primary h-100">
                                    <div class="card-body text-center">
                                        <i class="fas fa-id-card fa-3x text-primary mb-3"></i>
                                        <h6 class="font-weight-bold">{{ $permohonan->jenis_identitas ?? 'Kartu Identitas' }}</h6>
                                        <p class="text-muted small mb-3">{{ basename($permohonan->file_identitas_path) }}</p>
                                        <a href="{{ route('admin.permohonan.downloadFile', [$permohonan, 'identitas']) }}" 
                                           class="btn btn-primary btn-sm btn-block">
                                            <i class="fas fa-download"></i> Download
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endif

                        {{-- Untuk Kelompok --}}
                        @if($permohonan->kategori_pemohon === 'kelompok')
                            @if($permohonan->file_surat_kuasa_path)
                                @php $hasFiles = true; @endphp
                                <div class="col-md-4 mb-3">
                                    <div class="card border-success h-100">
                                        <div class="card-body text-center">
                                            <i class="fas fa-file-signature fa-3x text-success mb-3"></i>
                                            <h6 class="font-weight-bold">Surat Kuasa</h6>
                                            <p class="text-muted small mb-3">{{ basename($permohonan->file_surat_kuasa_path) }}</p>
                                            <a href="{{ route('admin.permohonan.downloadFile', [$permohonan, 'surat_kuasa']) }}" 
                                               class="btn btn-success btn-sm btn-block">
                                                <i class="fas fa-download"></i> Download
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @endif

                            @if($permohonan->file_ktp_pemberi_kuasa_path)
                                @php $hasFiles = true; @endphp
                                <div class="col-md-4 mb-3">
                                    <div class="card border-success h-100">
                                        <div class="card-body text-center">
                                            <i class="fas fa-id-card fa-3x text-success mb-3"></i>
                                            <h6 class="font-weight-bold">KTP Pemberi Kuasa</h6>
                                            <p class="text-muted small mb-3">{{ basename($permohonan->file_ktp_pemberi_kuasa_path) }}</p>
                                            <a href="{{ route('admin.permohonan.downloadFile', [$permohonan, 'ktp_kuasa']) }}" 
                                               class="btn btn-success btn-sm btn-block">
                                                <i class="fas fa-download"></i> Download
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endif

                        {{-- Untuk Badan Hukum --}}
                        @if($permohonan->kategori_pemohon === 'badan_hukum')
                            @if($permohonan->file_akta_ahu_path)
                                @php $hasFiles = true; @endphp
                                <div class="col-md-4 mb-3">
                                    <div class="card border-warning h-100">
                                        <div class="card-body text-center">
                                            <i class="fas fa-file-contract fa-3x text-warning mb-3"></i>
                                            <h6 class="font-weight-bold">Akta AHU</h6>
                                            <p class="text-muted small mb-3">{{ basename($permohonan->file_akta_ahu_path) }}</p>
                                            <a href="{{ route('admin.permohonan.downloadFile', [$permohonan, 'akta_ahu']) }}" 
                                               class="btn btn-warning btn-sm btn-block">
                                                <i class="fas fa-download"></i> Download
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @endif

                            @if($permohonan->file_ad_art_path)
                                @php $hasFiles = true; @endphp
                                <div class="col-md-4 mb-3">
                                    <div class="card border-warning h-100">
                                        <div class="card-body text-center">
                                            <i class="fas fa-file-alt fa-3x text-warning mb-3"></i>
                                            <h6 class="font-weight-bold">AD/ART</h6>
                                            <p class="text-muted small mb-3">{{ basename($permohonan->file_ad_art_path) }}</p>
                                            <a href="{{ route('admin.permohonan.downloadFile', [$permohonan, 'ad_art']) }}" 
                                               class="btn btn-warning btn-sm btn-block">
                                                <i class="fas fa-download"></i> Download
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endif
                    </div>

                    @if(!$hasFiles)
                        <div class="text-center text-muted py-5">
                            <i class="fas fa-inbox fa-4x mb-3 d-block"></i>
                            <p class="mb-0">Tidak ada dokumen lampiran</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <!-- Update Status & Kategorisasi -->
    <div class="row">
        <div class="col-lg-12 mb-4">
            <div class="card shadow">
                <div class="card-header py-3 bg-success text-white">
                    <h6 class="m-0 font-weight-bold">
                        <i class="fas fa-edit"></i> Update Status & Kategorisasi Permohonan
                    </h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.permohonan.updateStatus', $permohonan) }}" method="POST">
                        @csrf
                        
                        <!-- Status Permohonan -->
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="font-weight-bold">
                                    Status Permohonan <span class="text-danger">*</span>
                                </label>
                                <select name="status" class="form-control @error('status') is-invalid @enderror" required>
                                    <option value="perlu_verifikasi" {{ $permohonan->status === 'perlu_verifikasi' ? 'selected' : '' }}>
                                        ⚠️ Perlu Verifikasi
                                    </option>
                                    <option value="diproses" {{ $permohonan->status === 'diproses' ? 'selected' : '' }}>
                                        🔄 Sedang Diproses
                                    </option>
                                    <option value="ditunda" {{ $permohonan->status === 'ditunda' ? 'selected' : '' }}>
                                        ⏸️ Ditunda
                                    </option>
                                    <option value="dikabulkan_seluruhnya" {{ $permohonan->status === 'dikabulkan_seluruhnya' ? 'selected' : '' }}>
                                        ✅ Dikabulkan Seluruhnya
                                    </option>
                                    <option value="dikabulkan_sebagian" {{ $permohonan->status === 'dikabulkan_sebagian' ? 'selected' : '' }}>
                                        ✔️ Dikabulkan Sebagian
                                    </option>
                                    <option value="ditolak" {{ $permohonan->status === 'ditolak' ? 'selected' : '' }}>
                                        ❌ Ditolak
                                    </option>
                                </select>
                                @error('status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="font-weight-bold">Status Saat Ini</label>
                                <div class="form-control-plaintext">
                                    @if($permohonan->status === 'perlu_verifikasi')
                                        <span class="badge badge-warning badge-lg">
                                            <i class="fas fa-exclamation-circle"></i> Perlu Verifikasi
                                        </span>
                                    @elseif($permohonan->status === 'diproses')
                                        <span class="badge badge-info badge-lg">
                                            <i class="fas fa-spinner fa-spin"></i> Diproses
                                        </span>
                                    @elseif($permohonan->status === 'ditunda')
                                        <span class="badge badge-secondary badge-lg">
                                            <i class="fas fa-pause-circle"></i> Ditunda
                                        </span>
                                    @elseif($permohonan->status === 'dikabulkan_seluruhnya')
                                        <span class="badge badge-success badge-lg">
                                            <i class="fas fa-check-circle"></i> Dikabulkan Seluruhnya
                                        </span>
                                    @elseif($permohonan->status === 'dikabulkan_sebagian')
                                        <span class="badge badge-success badge-lg">
                                            <i class="fas fa-check-circle"></i> Dikabulkan Sebagian
                                        </span>
                                    @else
                                        <span class="badge badge-danger badge-lg">
                                            <i class="fas fa-times-circle"></i> Ditolak
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- Kategorisasi Admin -->
                        <hr class="my-4">
                        <h5 class="text-primary mb-3">
                            <i class="fas fa-tags"></i> Kategorisasi Informasi
                        </h5>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="font-weight-bold">
                                    <i class="fas fa-layer-group"></i> Kategori Informasi
                                </label>
                                <select name="kategori_informasi" class="form-control @error('kategori_informasi') is-invalid @enderror">
                                    <option value="">-- Pilih Kategori --</option>
                                    <option value="informasi_berkala" {{ old('kategori_informasi', $permohonan->kategori_informasi) === 'informasi_berkala' ? 'selected' : '' }}>Informasi Berkala</option>
                                    <option value="informasi_setiap_saat" {{ old('kategori_informasi', $permohonan->kategori_informasi) === 'informasi_setiap_saat' ? 'selected' : '' }}>Informasi Setiap Saat</option>
                                    <option value="informasi_serta_merta" {{ old('kategori_informasi', $permohonan->kategori_informasi) === 'informasi_serta_merta' ? 'selected' : '' }}>Informasi Serta Merta</option>
                                    <option value="informasi_dikecualikan" {{ old('kategori_informasi', $permohonan->kategori_informasi) === 'informasi_dikecualikan' ? 'selected' : '' }}>Informasi Dikecualikan</option>
                                </select>
                                @error('kategori_informasi')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="font-weight-bold">
                                    <i class="fas fa-clipboard-list"></i> Jenis Permohonan Informasi
                                </label>
                                <select name="jenis_permohonan_informasi" id="jenis_permohonan_informasi" class="form-control @error('jenis_permohonan_informasi') is-invalid @enderror">
                                    <option value="">-- Pilih Jenis Permohonan --</option>
                                    <option value="aplikasi_sistem_informasi" {{ old('jenis_permohonan_informasi', $permohonan->jenis_permohonan_informasi) === 'aplikasi_sistem_informasi' ? 'selected' : '' }}>Aplikasi/Sistem Informasi</option>
                                    <option value="kemitraan_kerja_sama" {{ old('jenis_permohonan_informasi', $permohonan->jenis_permohonan_informasi) === 'kemitraan_kerja_sama' ? 'selected' : '' }}>Kemitraan/Kerja Sama</option>
                                    <option value="jabatan_fungsional" {{ old('jenis_permohonan_informasi', $permohonan->jenis_permohonan_informasi) === 'jabatan_fungsional' ? 'selected' : '' }}>Jabatan Fungsional</option>
                                    <option value="kebijakan_regulasi" {{ old('jenis_permohonan_informasi', $permohonan->jenis_permohonan_informasi) === 'kebijakan_regulasi' ? 'selected' : '' }}>Kebijakan/Regulasi</option>
                                    <option value="konsultasi_teknis" {{ old('jenis_permohonan_informasi', $permohonan->jenis_permohonan_informasi) === 'konsultasi_teknis' ? 'selected' : '' }}>Konsultasi Teknis</option>
                                    <option value="perizinan" {{ old('jenis_permohonan_informasi', $permohonan->jenis_permohonan_informasi) === 'perizinan' ? 'selected' : '' }}>Perizinan</option>
                                    <option value="bsps" {{ old('jenis_permohonan_informasi', $permohonan->jenis_permohonan_informasi) === 'bsps' ? 'selected' : '' }}>BSPS</option>
                                    <option value="rumah_susun" {{ old('jenis_permohonan_informasi', $permohonan->jenis_permohonan_informasi) === 'rumah_susun' ? 'selected' : '' }}>Rumah Susun</option>
                                    <option value="rumah_khusus" {{ old('jenis_permohonan_informasi', $permohonan->jenis_permohonan_informasi) === 'rumah_khusus' ? 'selected' : '' }}>Rumah Khusus</option>
                                    <option value="pembiayaan_perumahan" {{ old('jenis_permohonan_informasi', $permohonan->jenis_permohonan_informasi) === 'pembiayaan_perumahan' ? 'selected' : '' }}>Pembiayaan Perumahan (FLPP & SBUM)</option>
                                    <option value="bantuan_permukiman" {{ old('jenis_permohonan_informasi', $permohonan->jenis_permohonan_informasi) === 'bantuan_permukiman' ? 'selected' : '' }}>Bantuan Permukiman</option>
                                    <option value="kpp_kur_perumahan" {{ old('jenis_permohonan_informasi', $permohonan->jenis_permohonan_informasi) === 'kpp_kur_perumahan' ? 'selected' : '' }}>KPP/KUR Perumahan</option>
                                    <option value="pelayanan_publik" {{ old('jenis_permohonan_informasi', $permohonan->jenis_permohonan_informasi) === 'pelayanan_publik' ? 'selected' : '' }}>Pelayanan Publik</option>
                                    <option value="lain_lain" {{ old('jenis_permohonan_informasi', $permohonan->jenis_permohonan_informasi) === 'lain_lain' ? 'selected' : '' }}>Lain-lain</option>
                                </select>
                                @error('jenis_permohonan_informasi')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror

                                <!-- Field Lainnya -->
                                <div id="lainnya_field" style="{{ old('jenis_permohonan_informasi', $permohonan->jenis_permohonan_informasi) === 'lain_lain' ? 'display: block;' : 'display: none;' }}">
                                    <input type="text" name="jenis_permohonan_lainnya" class="form-control mt-2 @error('jenis_permohonan_lainnya') is-invalid @enderror" placeholder="Sebutkan jenis lainnya..." value="{{ old('jenis_permohonan_lainnya', $permohonan->jenis_permohonan_lainnya) }}">
                                    @error('jenis_permohonan_lainnya')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="font-weight-bold">
                                    <i class="fas fa-info-circle"></i> Status Informasi
                                </label>
                                <select name="status_informasi" class="form-control @error('status_informasi') is-invalid @enderror">
                                    <option value="">-- Pilih Status --</option>
                                    <option value="ya" {{ old('status_informasi', $permohonan->status_informasi) === 'ya' ? 'selected' : '' }}>Ya</option>
                                    <option value="dibawah_penguasaan" {{ old('status_informasi', $permohonan->status_informasi) === 'dibawah_penguasaan' ? 'selected' : '' }}>Di Bawah Penguasaan</option>
                                    <option value="tidak_dibawah_penguasaan" {{ old('status_informasi', $permohonan->status_informasi) === 'tidak_dibawah_penguasaan' ? 'selected' : '' }}>Tidak Di Bawah Penguasaan</option>
                                    <option value="belum_didokumentasikan" {{ old('status_informasi', $permohonan->status_informasi) === 'belum_didokumentasikan' ? 'selected' : '' }}>Belum Didokumentasikan</option>
                                </select>
                                @error('status_informasi')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="font-weight-bold">
                                    <i class="fas fa-file-pdf"></i> Bentuk Informasi yang Dikuasai
                                </label>
                                <select name="bentuk_informasi" class="form-control @error('bentuk_informasi') is-invalid @enderror">
                                    <option value="">-- Pilih Bentuk Informasi --</option>
                                    <option value="softcopy" {{ old('bentuk_informasi', $permohonan->bentuk_informasi) === 'softcopy' ? 'selected' : '' }}>Softcopy</option>
                                    <option value="hardcopy" {{ old('bentuk_informasi', $permohonan->bentuk_informasi) === 'hardcopy' ? 'selected' : '' }}>Hardcopy</option>
                                    <option value="softcopy_hardcopy" {{ old('bentuk_informasi', $permohonan->bentuk_informasi) === 'softcopy_hardcopy' ? 'selected' : '' }}>Softcopy & Hardcopy</option>
                                </select>
                                @error('bentuk_informasi')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label class="font-weight-bold">
                                    <i class="fas fa-hand-pointer"></i> Jenis Permintaan
                                </label>
                                <select name="jenis_permintaan" class="form-control @error('jenis_permintaan') is-invalid @enderror">
                                    <option value="">-- Pilih Jenis Permintaan --</option>
                                    <option value="melihat_mengetahui" {{ old('jenis_permintaan', $permohonan->jenis_permintaan) === 'melihat_mengetahui' ? 'selected' : '' }}>Melihat/Mengetahui</option>
                                    <option value="meminta_salinan" {{ old('jenis_permintaan', $permohonan->jenis_permintaan) === 'meminta_salinan' ? 'selected' : '' }}>Meminta Salinan</option>
                                    <option value="melihat_dan_salinan" {{ old('jenis_permintaan', $permohonan->jenis_permintaan) === 'melihat_dan_salinan' ? 'selected' : '' }}>Melihat/Mengetahui & Meminta Salinan</option>
                                </select>
                                @error('jenis_permintaan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Catatan Admin -->
                        <hr class="my-4">
                        <div class="mb-3">
                            <label class="font-weight-bold">
                                <i class="fas fa-sticky-note"></i> Catatan Admin
                            </label>
                            <textarea name="catatan_admin" 
                                      class="form-control @error('catatan_admin') is-invalid @enderror" 
                                      rows="5" 
                                      placeholder="Masukkan catatan untuk pemohon (opsional)...">{{ old('catatan_admin', $permohonan->catatan_admin) }}</textarea>
                            @error('catatan_admin')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="form-text text-muted">
                                <i class="fas fa-info-circle"></i> 
                                Catatan ini akan terlihat oleh pemohon saat mereka mengecek status
                            </small>
                        </div>

                        <div class="d-flex justify-content-between align-items-center">
                            <div class="text-muted small">
                                <i class="fas fa-clock"></i> 
                                Terakhir diupdate: {{ $permohonan->updated_at->format('d F Y, H:i') }} WIB
                            </div>
                            <button type="submit" class="btn btn-success btn-lg">
                                <i class="fas fa-save"></i> Update Status & Kategorisasi
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Catatan Admin (Jika Ada) -->
    @if($permohonan->catatan_admin)
    <div class="row">
        <div class="col-lg-12 mb-4">
            <div class="card shadow border-left-warning">
                <div class="card-header bg-light">
                    <h6 class="m-0 font-weight-bold text-warning">
                        <i class="fas fa-comments"></i> Catatan dari Admin
                    </h6>
                </div>
                <div class="card-body">
                    <p class="mb-0">{{ $permohonan->catatan_admin }}</p>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>
@php
    $indikator = $permohonan->indikator_waktu;
@endphp

<!-- Indikator Waktu Card -->
<div class="row mb-4">
    <div class="col-lg-12">
        <div class="card shadow-sm border-left-{{ $indikator['warna'] }}">
            <div class="card-body py-3">
                <div class="row align-items-center">
                    <div class="col-md-3 text-center">
                        <i class="fas fa-{{ $indikator['icon'] }} fa-3x {{ $indikator['text_class'] }} mb-2"></i>
                        <h4 class="mb-0 font-weight-bold {{ $indikator['text_class'] }}">
                            {{ $indikator['label'] }}
                        </h4>
                    </div>
                    
                    <div class="col-md-9">
                        <div class="row text-center">
                            @if($permohonan->tanggal_selesai)
                                {{-- Jika sudah selesai --}}
                                <div class="col-md-4">
                                    <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                        Status
                                    </div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                                        <i class="fas fa-check-circle text-success"></i> Selesai
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                        Hari Kerja Terpakai
                                    </div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                                        {{ $indikator['hari_terpakai'] }} dari {{ \App\Models\Permohonan::BATAS_WAKTU_HARI_KERJA }} hari
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                        Tanggal Selesai
                                    </div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                                        {{ $permohonan->tanggal_selesai->format('d M Y') }}
                                    </div>
                                </div>
                            @else
                                {{-- Jika belum selesai --}}
                                <div class="col-md-3">
                                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                        Sisa Hari Kerja
                                    </div>
                                    <div class="h4 mb-0 font-weight-bold {{ $indikator['text_class'] }}">
                                        @if(isset($indikator['terlambat']) && $indikator['terlambat'])
                                            <i class="fas fa-exclamation-triangle"></i> 
                                            Terlambat {{ $indikator['hari_keterlambatan'] }} hari
                                        @else
                                            {{ $indikator['sisa_hari'] }} Hari
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="text-xs font-weight-bold text-secondary text-uppercase mb-1">
                                        Hari Terpakai
                                    </div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                                        {{ $indikator['hari_terpakai'] }} dari {{ \App\Models\Permohonan::BATAS_WAKTU_HARI_KERJA }} hari
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                        Deadline
                                    </div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                                        {{ $permohonan->deadline->format('d M Y') }}
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                        Progress
                                    </div>
                                    <div class="progress mt-2" style="height: 20px;">
                                        <div class="progress-bar bg-{{ $indikator['warna'] }}" 
                                             role="progressbar" 
                                             style="width: {{ $indikator['persentase'] }}%"
                                             aria-valuenow="{{ $indikator['persentase'] }}" 
                                             aria-valuemin="0" 
                                             aria-valuemax="100">
                                            {{ round($indikator['persentase']) }}%
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                        
                        @if(!$permohonan->tanggal_selesai)
<div class="row mt-3">
    <div class="col-12">
        <div class="alert alert-{{ $indikator['warna'] }} mb-0 py-2">
            <small>
                <i class="fas fa-info-circle"></i>
                @if($indikator['label'] === 'On Schedule')
                    Permohonan masih dalam batas waktu normal. Proses sesuai prioritas.
                @elseif($indikator['label'] === 'Attention')
                    <strong>Attention!</strong> Waktu pemrosesan mendekati deadline. Harap segera ditindaklanjuti.
                @elseif($indikator['label'] === 'Urgent')
                    <strong>URGENT!</strong> Permohonan ini harus segera diselesaikan! Tinggal {{ $indikator['sisa_hari'] }} hari kerja lagi.
                @else
                    <strong>TERLAMBAT!</strong> Permohonan ini telah melewati batas waktu {{ \App\Models\Permohonan::BATAS_WAKTU_HARI_KERJA }} hari kerja.
                @endif
            </small>
        </div>
    </div>
</div>
@endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

<style>
.border-left-success {
    border-left: 0.25rem solid #28a745 !important;
}

.border-left-warning {
    border-left: 0.25rem solid #ffc107 !important;
}

.border-left-danger {
    border-left: 0.25rem solid #dc3545 !important;
}

.border-left-info {
    border-left: 0.25rem solid #17a2b8 !important;
}
</style>

@push('scripts')
<script>
    $(document).ready(function() {
        // Auto hide alert
        setTimeout(function() {
            $('.alert').fadeOut('slow');
        }, 5000);
        
        // Show/hide lainnya field
        $('#jenis_permohonan_informasi').on('change', function() {
            if ($(this).val() === 'lain_lain') {
                $('#lainnya_field').slideDown();
            } else {
                $('#lainnya_field').slideUp();
                $('input[name="jenis_permohonan_lainnya"]').val('');
            }
        });
        
        // Konfirmasi sebelum update
        $('form').on('submit', function(e) {
            const status = $('select[name="status"]').val();
            const statusText = $('select[name="status"] option:selected').text().trim();
            
            if (!confirm(`Apakah Anda yakin ingin mengubah status menjadi "${statusText}"?`)) {
                e.preventDefault();
                return false;
            }
        });
    });
</script>
@endpush