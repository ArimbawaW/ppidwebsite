{{-- resources/views/admin/keberatan/show.blade.php --}}
@extends('layouts.admin')

@section('title', 'Detail Keberatan - PPID Admin')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Detail Keberatan</h1>
</div>

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
                            <span class="badge bg-warning text-dark fs-6 px-3 py-2">Pending</span>
                            @break
                        @case('diproses')
                            <span class="badge bg-info fs-6 px-3 py-2">Diproses</span>
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

{{-- Form Update --}}
<div class="card">
    <div class="card-header bg-light">
        <h5 class="mb-0">
            <i class="bi bi-pencil-square me-2"></i>Update Status Keberatan
        </h5>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.keberatan.update', $keberatan->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">Status</label>
                    <select name="status" class="form-select" required>
                        @foreach(['pending','diproses','selesai','ditolak'] as $status)
                            <option value="{{ $status }}" {{ $keberatan->status === $status ? 'selected' : '' }}>
                                {{ ucfirst($status) }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label fw-bold">Keterangan</label>
                <textarea name="keterangan" class="form-control" rows="4"
                          placeholder="Catatan admin terkait status keberatan...">{{ $keberatan->keterangan }}</textarea>
                <small class="text-muted">
                    Keterangan ini akan ditampilkan kepada pemohon.
                </small>
            </div>

            <div class="d-flex gap-2">
                <button class="btn btn-primary">
                    <i class="bi bi-check-circle me-1"></i>Update
                </button>
                <a href="{{ route('admin.keberatan.index') }}" class="btn btn-secondary">
                    <i class="bi bi-arrow-left me-1"></i>Kembali
                </a>
            </div>
        </form>
    </div>
</div>
@endsection

@push('styles')
<style>
    pre {
        white-space: pre-wrap;
        font-family: inherit;
        font-size: 0.95rem;
    }
</style>
@endpush
