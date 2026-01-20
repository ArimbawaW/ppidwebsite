{{-- resources/views/frontend/keberatan/hasil.blade.php --}}
@extends('layouts.app')

@section('title', 'Hasil Cek Keberatan')

@section('content')
<div class="container my-5">
    <h2 class="mb-4">Hasil Cek Keberatan</h2>

    <div class="card">
        <div class="card-body">
            <div class="row mb-3">
                <div class="col-md-6">
                    <p><strong>Nomor Registrasi Keberatan:</strong></p>
                    <p class="text-muted">{{ $keberatan->nomor_registrasi }}</p>
                </div>
                
                @if($keberatan->nomor_registrasi_permohonan)
                <div class="col-md-6">
                    <p><strong>Nomor Registrasi Permohonan:</strong></p>
                    <p class="text-muted">{{ $keberatan->nomor_registrasi_permohonan }}</p>
                </div>
                @endif
            </div>

            <hr>

            <div class="row mb-3">
                <div class="col-md-6">
                    <p><strong>Nama Pemohon:</strong></p>
                    <p class="text-muted">{{ $keberatan->nama_pemohon }}</p>
                </div>
                <div class="col-md-6">
                    <p><strong>Tanggal Pengajuan:</strong></p>
                    <p class="text-muted">{{ $keberatan->created_at->format('d M Y H:i') }} WIB</p>
                </div>
            </div>

            <div class="mb-3">
                <p><strong>Alasan Keberatan:</strong></p>
                <div class="p-3 bg-light rounded">
                    <p class="mb-0" style="white-space: pre-line;">{{ $keberatan->alasan_keberatan }}</p>
                </div>
            </div>

            <div class="mb-3">
                <p><strong>Status:</strong></p>
                <p>
                    @if($keberatan->status == 'pending')
                        <span class="badge bg-warning text-dark fs-6 px-3 py-2">Pending</span>
                    @elseif($keberatan->status == 'diproses')
                        <span class="badge bg-info fs-6 px-3 py-2">Diproses</span>
                    @elseif($keberatan->status == 'selesai')
                        <span class="badge bg-success fs-6 px-3 py-2">Selesai</span>
                    @else
                        <span class="badge bg-danger fs-6 px-3 py-2">Ditolak</span>
                    @endif
                </p>
            </div>

            @if($keberatan->keterangan)
            <div class="mb-3">
                <p><strong>Keterangan dari Admin:</strong></p>
                <div class="alert alert-info">
                    <p class="mb-0" style="white-space: pre-line;">{{ $keberatan->keterangan }}</p>
                </div>
            </div>
            @endif

            <hr>

            <div class="d-flex gap-2">
                <a href="{{ route('keberatan.cek') }}" class="btn btn-secondary">
                    <i class="bi bi-arrow-left"></i> Cek Lagi
                </a>
                <a href="{{ route('home') }}" class="btn btn-primary">
                    <i class="bi bi-house"></i> Kembali ke Beranda
                </a>
            </div>
        </div>
    </div>
</div>
@endsection