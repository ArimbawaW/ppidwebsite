@extends('layouts.app')

@section('title', 'Status Permohonan')

@section('content')
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            
            {{-- Header dengan Status Badge --}}
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body p-4 text-center" style="background: linear-gradient(135deg, #0e5b73 0%, #1a8aa6 100%);">
                    <div class="mb-3">
                        @if($permohonan->status === 'perlu_verifikasi')
                            <i class="fas fa-hourglass-half fa-4x text-white mb-3"></i>
                        @elseif($permohonan->status === 'diproses')
                            <i class="fas fa-spinner fa-spin fa-4x text-white mb-3"></i>
                        @elseif($permohonan->status === 'ditunda')
                            <i class="fas fa-pause-circle fa-4x text-white mb-3"></i>
                        @elseif(in_array($permohonan->status, ['dikabulkan_seluruhnya', 'dikabulkan_sebagian']))
                            <i class="fas fa-check-circle fa-4x text-white mb-3"></i>
                        @else
                            <i class="fas fa-times-circle fa-4x text-white mb-3"></i>
                        @endif
                    </div>
                    <h3 class="text-white fw-bold mb-2">Status Permohonan</h3>
                    <h2 class="text-white fw-bold mb-0">
                        {{ strtoupper($permohonan->status_label_public) }}
                    </h2>
                </div>
            </div>

            {{-- Detail Permohonan --}}
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header" style="background:#0e5b73;">
                    <h5 class="mb-0 text-white">
                        <i class="fas fa-info-circle"></i> Detail Permohonan
                    </h5>
                </div>
                <div class="card-body p-4">
                    <table class="table table-borderless">
                        <tr>
                            <th width="40%" class="text-muted">Nomor Registrasi</th>
                            <td class="fw-bold">{{ $permohonan->nomor_registrasi }}</td>
                        </tr>
                        <tr>
                            <th class="text-muted">Kategori Pemohon</th>
                            <td>
                                @if($permohonan->kategori_pemohon === 'perorangan')
                                    <span class="badge bg-primary">
                                        <i class="fas fa-user me-1"></i> Perorangan
                                    </span>
                                @elseif($permohonan->kategori_pemohon === 'kelompok')
                                    <span class="badge bg-success">
                                        <i class="fas fa-users me-1"></i> Kelompok Orang
                                    </span>
                                @else
                                    <span class="badge bg-warning text-dark">
                                        <i class="fas fa-building me-1"></i> Badan Hukum
                                    </span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th class="text-muted">Nama Pemohon</th>
                            <td class="fw-bold">{{ $permohonan->nama }}</td>
                        </tr>
                        <tr>
                            <th class="text-muted">Email</th>
                            <td>{{ $permohonan->email }}</td>
                        </tr>
                        <tr>
                            <th class="text-muted">Tanggal Pengajuan</th>
                            <td>
                                <i class="far fa-calendar"></i>
                                {{ $permohonan->created_at->format('d F Y, H:i') }} WIB
                            </td>
                        </tr>
                        @if($permohonan->tanggal_selesai)
                        <tr>
                            <th class="text-muted">Tanggal Selesai</th>
                            <td>
                                <i class="far fa-calendar-check"></i>
                                {{ $permohonan->tanggal_selesai->format('d F Y, H:i') }} WIB
                            </td>
                        </tr>
                        @endif
                    </table>
                </div>
            </div>

            {{-- Rincian Informasi --}}
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header" style="background:#0e5b73;">
                    <h5 class="mb-0 text-white">
                        <i class="fas fa-file-alt"></i> Rincian Informasi
                    </h5>
                </div>
                <div class="card-body p-4">
                    <div class="mb-3">
                        <strong class="text-primary">
                            <i class="fas fa-info-circle me-1"></i> Informasi yang Diminta:
                        </strong>
                        <p class="mb-0 mt-2 text-muted" style="white-space: pre-line;">{{ $permohonan->rincian_informasi }}</p>
                    </div>
                    <hr>
                    <div>
                        <strong class="text-primary">
                            <i class="fas fa-bullseye me-1"></i> Tujuan Penggunaan:
                        </strong>
                        <p class="mb-0 mt-2 text-muted" style="white-space: pre-line;">{{ $permohonan->tujuan_penggunaan }}</p>
                    </div>
                </div>
            </div>

            {{-- Catatan Admin (Jika Ada) --}}
            @if($permohonan->catatan_admin)
            <div class="card border-0 shadow-sm mb-4 border-start border-warning border-5">
                <div class="card-body p-4">
                    <h5 class="fw-bold text-warning mb-3">
                        <i class="fas fa-comment-dots"></i> Catatan dari Admin
                    </h5>
                    <p class="mb-0" style="white-space: pre-line;">{{ $permohonan->catatan_admin }}</p>
                </div>
            </div>
            @endif

            {{-- Timeline Status --}}
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header" style="background:#0e5b73;">
                    <h5 class="mb-0 text-white">
                        <i class="fas fa-stream"></i> Timeline Proses
                    </h5>
                </div>
                <div class="card-body p-4">
                    <div class="timeline">
                        <div class="timeline-item">
                            <i class="fas fa-check-circle text-success"></i>
                            <div class="ms-3">
                                <strong>Permohonan Diterima</strong>
                                <p class="text-muted small mb-0">
                                    {{ $permohonan->created_at->format('d F Y, H:i') }} WIB
                                </p>
                            </div>
                        </div>

                        @if($permohonan->status !== 'perlu_verifikasi')
                        <div class="timeline-item">
                            <i class="fas fa-check-circle text-success"></i>
                            <div class="ms-3">
                                <strong>Verifikasi Selesai</strong>
                                <p class="text-muted small mb-0">Permohonan telah diverifikasi oleh admin</p>
                            </div>
                        </div>
                        @endif

                        @if(in_array($permohonan->status, ['diproses', 'ditunda', 'dikabulkan_seluruhnya', 'dikabulkan_sebagian', 'ditolak']))
                        <div class="timeline-item">
                            <i class="fas fa-{{ $permohonan->status === 'diproses' ? 'spinner fa-spin' : 'check-circle' }} text-info"></i>
                            <div class="ms-3">
                                <strong>Sedang Diproses</strong>
                                <p class="text-muted small mb-0">Permohonan sedang diproses oleh tim PPID</p>
                            </div>
                        </div>
                        @endif

                        @if($permohonan->status === 'ditunda')
                        <div class="timeline-item">
                            <i class="fas fa-pause-circle text-secondary"></i>
                            <div class="ms-3">
                                <strong>Ditunda Sementara</strong>
                                <p class="text-muted small mb-0">Permohonan sementara ditunda</p>
                            </div>
                        </div>
                        @endif

                        @if(in_array($permohonan->status, ['dikabulkan_seluruhnya', 'dikabulkan_sebagian', 'ditolak']))
                        <div class="timeline-item">
                            <i class="fas fa-{{ in_array($permohonan->status, ['dikabulkan_seluruhnya', 'dikabulkan_sebagian']) ? 'check-circle text-success' : 'times-circle text-danger' }}"></i>
                            <div class="ms-3">
                                <strong>{{ $permohonan->status_label_public }}</strong>
                                <p class="text-muted small mb-0">
                                    {{ $permohonan->tanggal_selesai ? $permohonan->tanggal_selesai->format('d F Y, H:i') . ' WIB' : '' }}
                                </p>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Info Keberatan --}}
            @if(in_array($permohonan->status, ['ditolak', 'dikabulkan_sebagian','dikabulkan_seluruhnya']))
            <div class="card border-0 shadow-sm mb-4 bg-light">
                <div class="card-body p-4">
                    <h6 class="fw-bold text-primary mb-3">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        Tidak Puas dengan Keputusan?
                    </h6>
                    <p class="mb-3">
                        Jika Anda tidak puas dengan keputusan permohonan informasi ini, 
                        Anda dapat mengajukan keberatan sesuai dengan UU No. 14 Tahun 2008 tentang Keterbukaan Informasi Publik.
                    </p>
                    <a href="{{ route('keberatan.index') }}" class="btn btn-warning">
                        <i class="fas fa-file-signature me-2"></i>
                        Ajukan Keberatan
                    </a>
                </div>
            </div>
            @endif

            {{-- Action Buttons --}}
            <div class="text-center">
                <a href="{{ route('permohonan.cek-status') }}" class="btn btn-secondary btn-lg me-2">
                    <i class="fas fa-arrow-left"></i> Cek Lagi
                </a>
                <a href="{{ route('home') }}" class="btn btn-outline-secondary btn-lg">
                    <i class="fas fa-home"></i> Kembali ke Beranda
                </a>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
.timeline {
    position: relative;
    padding-left: 30px;
}

.timeline::before {
    content: '';
    position: absolute;
    left: 10px;
    top: 0;
    bottom: 0;
    width: 2px;
    background: #dee2e6;
}

.timeline-item {
    position: relative;
    display: flex;
    align-items: start;
    margin-bottom: 20px;
}

.timeline-item:last-child {
    margin-bottom: 0;
}

.timeline-item i {
    position: absolute;
    left: -26px;
    background: white;
    padding: 3px;
    font-size: 1.2rem;
}

.border-start {
    border-left-width: 5px !important;
}

.card {
    border-radius: 15px;
}

.card-header {
    border-radius: 15px 15px 0 0 !important;
}
</style>
@endpush
@endsection