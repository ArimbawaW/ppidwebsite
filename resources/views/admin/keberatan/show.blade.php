{{-- resources/views/admin/keberatan/show.blade.php --}}
@extends('layouts.admin')

@section('title', 'Detail Keberatan - PPID Admin')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Detail Keberatan</h1>
</div>

@if(session('success'))
<div class="alert alert-success alert-dismissible fade show">
    <i class="bi bi-check-circle me-2"></i>
    {{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
@endif

<div class="card mb-4">
    <div class="card-header bg-primary text-white">
        <h5 class="mb-0">
            <i class="bi bi-file-earmark-text me-2"></i>
            Informasi Keberatan
        </h5>
    </div>
    <div class="card-body">

        {{-- Nomor Registrasi --}}
        <div class="row mb-3">
            <div class="col-md-6">
                <p class="mb-1"><strong>No. Registrasi Keberatan</strong></p>
                <p class="text-muted">{{ $keberatan->nomor_registrasi }}</p>
            </div>

            <div class="col-md-6">
                <p class="mb-1"><strong>No. Registrasi Permohonan</strong></p>
                <p class="text-muted">
                    {{ $keberatan->nomor_registrasi_permohonan ?? '-' }}
                    @if($keberatan->permohonan)
                        <a href="{{ route('admin.permohonan.show', $keberatan->permohonan_id) }}"
                           class="btn btn-sm btn-outline-light ms-2"
                           target="_blank">
                            <i class="bi bi-box-arrow-up-right"></i>
                        </a>
                    @endif
                </p>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-6">
                <p class="mb-1"><strong>Tanggal Pengajuan</strong></p>
                <p class="text-muted">{{ $keberatan->created_at->format('d M Y H:i') }} WIB</p>
            </div>
            <div class="col-md-6">
                <p class="mb-1"><strong>Status</strong></p>
                <p>
                    @switch($keberatan->status)
                        @case('pending')
                            <span class="badge bg-warning text-dark fs-6 px-3 py-2">Perlu Diverifikasi</span>
                            @break
                        @case('diproses')
                            <span class="badge bg-info fs-6 px-3 py-2">Diproses</span>
                            @break
                        @case('ditunda')
                            <span class="badge bg-secondary fs-6 px-3 py-2">Ditunda</span>
                            @break
                        @case('selesai')
                            <span class="badge bg-success fs-6 px-3 py-2">Selesai</span>
                            @break
                        @default
                            <span class="badge bg-danger fs-6 px-3 py-2">Ditolak</span>
                    @endswitch
                </p>
            </div>
        </div>

        <hr>

        {{-- Data Pemohon --}}
        <h6 class="fw-bold mb-3">
            <i class="bi bi-person-circle me-2"></i>Data Pemohon
        </h6>

        <div class="row mb-3">
            <div class="col-md-6">
                <table class="table table-borderless table-sm mb-0">
                    <tr>
                        <td width="160"><strong>Nama</strong></td>
                        <td>:</td>
                        <td>{{ $keberatan->nama_pemohon }}</td>
                    </tr>
                    <tr>
                        <td><strong>Email</strong></td>
                        <td>:</td>
                        <td>{{ $keberatan->email }}</td>
                    </tr>
                    <tr>
                        <td><strong>Nomor Kontak</strong></td>
                        <td>:</td>
                        <td>{{ $keberatan->nomor_kontak }}</td>
                    </tr>
                    <tr>
                        <td><strong>Pekerjaan</strong></td>
                        <td>:</td>
                        <td>{{ $keberatan->pekerjaan }}</td>
                    </tr>
                </table>
            </div>

            <div class="col-md-6">
                <p class="mb-1"><strong>Alamat</strong></p>
                <div class="p-3 bg-light rounded">
                    {{ $keberatan->alamat }}
                </div>
            </div>
        </div>

        @if($keberatan->kartu_identitas_path)
        <div class="mb-3">
            <p class="mb-1"><strong>Kartu Identitas</strong></p>
            <a href="{{ asset('storage/' . $keberatan->kartu_identitas_path) }}"
               target="_blank"
               class="btn btn-sm btn-outline-primary">
                <i class="bi bi-download me-1"></i>Download
            </a>
        </div>
        @endif

        <hr>

        {{-- Rincian Informasi --}}
        <h6 class="fw-bold mb-3">
            <i class="bi bi-info-circle me-2"></i>Rincian Informasi
        </h6>

        <div class="mb-3">
            <p class="mb-1"><strong>Informasi yang Diminta</strong></p>
            <div class="p-3 bg-light rounded">
                <pre class="mb-0">{{ $keberatan->informasi_diminta }}</pre>
            </div>
        </div>

        <div class="mb-3">
            <p class="mb-1"><strong>Tujuan Penggunaan Informasi</strong></p>
            <div class="p-3 bg-light rounded">
                <pre class="mb-0">{{ $keberatan->tujuan_penggunaan }}</pre>
            </div>
        </div>

        <hr>

        {{-- Alasan --}}
        <h6 class="fw-bold mb-3">
            <i class="bi bi-exclamation-triangle me-2"></i>Alasan & Uraian Keberatan
        </h6>

        <div class="mb-3">
            <p class="mb-1"><strong>Alasan Keberatan</strong></p>
            <div class="alert alert-info mb-0">
                {{ $keberatan->alasan_keberatan_label }}
            </div>
        </div>

        <div class="mb-3">
            <p class="mb-1"><strong>Uraian Keberatan</strong></p>
            <div class="p-3 bg-light rounded border">
                <pre class="mb-0">{{ $keberatan->uraian_keberatan }}</pre>
            </div>
        </div>

        @if($keberatan->keterangan)
        <hr>
        <div class="mb-3">
            <p class="mb-1"><strong>Keterangan Admin</strong></p>
            <div class="alert alert-warning">
                {{ $keberatan->keterangan }}
            </div>
        </div>
        @endif
    </div>
</div>

{{-- Form Update Status & Detail Tambahan --}}
<div class="card">
    <div class="card-header bg-light">
        <h5 class="mb-0">
            <i class="bi bi-pencil-square me-2"></i>Update Status & Detail Keberatan
        </h5>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.keberatan.update', $keberatan->id) }}" method="POST">
            @csrf
            @method('PUT')

            {{-- Status Keberatan --}}
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">Status Keberatan <span class="text-danger">*</span></label>
                    <select name="status" class="form-select" required>
                        @foreach(['pending','diproses','ditunda','selesai','ditolak'] as $status)
                            <option value="{{ $status }}" {{ $keberatan->status === $status ? 'selected' : '' }}>
                                @switch($status)
                                    @case('pending')
                                        Perlu Diverifikasi
                                        @break
                                    @case('diproses')
                                        Diproses
                                        @break
                                    @case('ditunda')
                                        Ditunda
                                        @break
                                    @case('selesai')
                                        Selesai
                                        @break
                                    @case('ditolak')
                                        Ditolak
                                        @break
                                @endswitch
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">Keterangan Admin</label>
                    <textarea name="keterangan" class="form-control" rows="3"
                              placeholder="Catatan singkat untuk pemohon...">{{ old('keterangan', $keberatan->keterangan) }}</textarea>
                </div>
            </div>

            <hr class="my-4">

            {{-- SECTION: Tanggapan Atasan PPID --}}
            <div class="mb-4">
                <h6 class="fw-bold text-primary mb-3">
                    <i class="bi bi-person-badge me-2"></i>Tanggapan Atasan PPID
                </h6>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Nama Atasan PPID</label>
                        <input type="text" name="nama_atasan_ppid" class="form-control" 
                               value="{{ old('nama_atasan_ppid', $keberatan->nama_atasan_ppid) }}"
                               placeholder="Nama lengkap atasan PPID">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Jabatan Atasan PPID</label>
                        <input type="text" name="jabatan_atasan_ppid" class="form-control" 
                               value="{{ old('jabatan_atasan_ppid', $keberatan->jabatan_atasan_ppid) }}"
                               placeholder="Contoh: Kepala Dinas / Sekretaris">
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Tanggapan Atasan PPID</label>
                    <textarea name="tanggapan_atasan_ppid" class="form-control" rows="5"
                              placeholder="Isi tanggapan resmi dari atasan PPID terhadap keberatan ini...">{{ old('tanggapan_atasan_ppid', $keberatan->tanggapan_atasan_ppid) }}</textarea>
                    <small class="text-muted">Tanggapan ini akan terlihat oleh pemohon</small>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Nomor Surat Tanggapan</label>
                        <input type="text" name="nomor_surat_tanggapan" class="form-control" 
                               value="{{ old('nomor_surat_tanggapan', $keberatan->nomor_surat_tanggapan) }}"
                               placeholder="Contoh: 123/PPID/2025">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Tanggal Surat Tanggapan</label>
                        <input type="date" name="tanggal_surat_tanggapan" class="form-control" 
                               value="{{ old('tanggal_surat_tanggapan', $keberatan->tanggal_surat_tanggapan ? $keberatan->tanggal_surat_tanggapan->format('Y-m-d') : '') }}">
                    </div>
                </div>
            </div>

            <hr class="my-4">

            {{-- SECTION: Keputusan Mediasi/Ajudikasi --}}
            <div class="mb-4">
                <h6 class="fw-bold text-warning mb-3">
                    <i class="bi bi-clipboard-check me-2"></i>Keputusan Hasil Mediasi/Ajudikasi Non-Litigasi
                </h6>

                <div class="mb-3">
                    <label class="form-label">Hasil Mediasi/Ajudikasi</label>
                    <textarea name="keputusan_mediasi" class="form-control" rows="5"
                              placeholder="Isi keputusan hasil mediasi atau ajudikasi non-litigasi jika ada...">{{ old('keputusan_mediasi', $keberatan->keputusan_mediasi) }}</textarea>
                    <small class="text-muted">Keputusan dari proses mediasi atau ajudikasi yang dilakukan oleh Komisi Informasi atau pihak berwenang lainnya</small>
                </div>
            </div>

            <hr class="my-4">

            {{-- SECTION: Putusan Pengadilan --}}
            <div class="mb-4">
                <h6 class="fw-bold text-danger mb-3">
                    <i class="bi bi-bank me-2"></i>Putusan Pengadilan atas Gugatan
                </h6>

                <div class="mb-3">
                    <label class="form-label">Putusan Pengadilan</label>
                    <textarea name="putusan_pengadilan" class="form-control" rows="5"
                              placeholder="Isi putusan pengadilan jika keberatan dilanjutkan ke jalur litigasi...">{{ old('putusan_pengadilan', $keberatan->putusan_pengadilan) }}</textarea>
                    <small class="text-muted">Dokumentasi putusan pengadilan jika kasus dilanjutkan ke pengadilan</small>
                </div>
            </div>

            <hr class="my-4">

            {{-- Submit Button --}}
            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-check-circle me-1"></i>Update Status & Detail
                </button>
                <a href="{{ route('admin.keberatan.index') }}" class="btn btn-secondary">
                    <i class="bi bi-arrow-left me-1"></i>Kembali
                </a>
            </div>
        </form>
    </div>
</div>

{{-- Display Section: Menampilkan Data yang Sudah Diisi --}}
@if($keberatan->tanggapan_atasan_ppid || $keberatan->tanggapan_pemohon || $keberatan->keputusan_mediasi || $keberatan->putusan_pengadilan)
<div class="card mt-4">
    <div class="card-header bg-info text-white">
        <h5 class="mb-0">
            <i class="bi bi-archive me-2"></i>Dokumentasi Proses Keberatan
        </h5>
    </div>
    <div class="card-body">
        
        {{-- Tanggapan Atasan PPID --}}
        @if($keberatan->tanggapan_atasan_ppid)
        <div class="mb-4">
            <h6 class="fw-bold text-primary border-bottom pb-2">
                <i class="bi bi-person-badge me-2"></i>Tanggapan Atasan PPID
            </h6>
            
            @if($keberatan->nama_atasan_ppid || $keberatan->jabatan_atasan_ppid)
            <div class="row mb-2">
                @if($keberatan->nama_atasan_ppid)
                <div class="col-md-6">
                    <strong>Nama:</strong> {{ $keberatan->nama_atasan_ppid }}
                </div>
                @endif
                @if($keberatan->jabatan_atasan_ppid)
                <div class="col-md-6">
                    <strong>Jabatan:</strong> {{ $keberatan->jabatan_atasan_ppid }}
                </div>
                @endif
            </div>
            @endif
            
            @if($keberatan->nomor_surat_tanggapan || $keberatan->tanggal_surat_tanggapan)
            <div class="row mb-2">
                @if($keberatan->nomor_surat_tanggapan)
                <div class="col-md-6">
                    <strong>Nomor Surat:</strong> {{ $keberatan->nomor_surat_tanggapan }}
                </div>
                @endif
                @if($keberatan->tanggal_surat_tanggapan)
                <div class="col-md-6">
                    <strong>Tanggal Surat:</strong> {{ $keberatan->tanggal_surat_tanggapan->format('d F Y') }}
                </div>
                @endif
            </div>
            @endif
            
            <div class="p-3 bg-light rounded mt-2">
                <pre class="mb-0">{{ $keberatan->tanggapan_atasan_ppid }}</pre>
            </div>
        </div>
        @endif

        {{-- Tanggapan Pemohon --}}
        @if($keberatan->tanggapan_pemohon)
        <div class="mb-4">
            <h6 class="fw-bold text-success border-bottom pb-2">
                <i class="bi bi-chat-left-quote me-2"></i>Tanggapan Pemohon Informasi
            </h6>
            <small class="text-muted d-block mb-2">
                <i class="bi bi-info-circle me-1"></i>
                Tanggapan ini diisi langsung oleh pemohon melalui halaman cek status keberatan
            </small>
            <div class="p-3 bg-light rounded">
                <pre class="mb-0">{{ $keberatan->tanggapan_pemohon }}</pre>
            </div>
        </div>
        @else
        <div class="mb-4">
            <h6 class="fw-bold text-success border-bottom pb-2">
                <i class="bi bi-chat-left-quote me-2"></i>Tanggapan Pemohon Informasi
            </h6>
            <div class="alert alert-info">
                <i class="bi bi-info-circle me-2"></i>
                Pemohon belum memberikan tanggapan. Tanggapan dapat diberikan oleh pemohon melalui halaman cek status keberatan setelah admin memberikan tanggapan atasan PPID.
            </div>
        </div>
        @endif

        {{-- Keputusan Mediasi --}}
        @if($keberatan->keputusan_mediasi)
        <div class="mb-4">
            <h6 class="fw-bold text-warning border-bottom pb-2">
                <i class="bi bi-clipboard-check me-2"></i>Keputusan Hasil Mediasi/Ajudikasi Non-Litigasi
            </h6>
            <div class="p-3 bg-light rounded">
                <pre class="mb-0">{{ $keberatan->keputusan_mediasi }}</pre>
            </div>
        </div>
        @endif

        {{-- Putusan Pengadilan --}}
        @if($keberatan->putusan_pengadilan)
        <div class="mb-4">
            <h6 class="fw-bold text-danger border-bottom pb-2">
                <i class="bi bi-bank me-2"></i>Putusan Pengadilan atas Gugatan
            </h6>
            <div class="p-3 bg-light rounded">
                <pre class="mb-0">{{ $keberatan->putusan_pengadilan }}</pre>
            </div>
        </div>
        @endif

    </div>
</div>
@endif

@endsection

@push('styles')
<style>
    pre {
        white-space: pre-wrap;
        font-family: inherit;
        font-size: 0.95rem;
    }
    
    .border-bottom {
        border-bottom: 2px solid #dee2e6 !important;
    }
</style>
@endpush