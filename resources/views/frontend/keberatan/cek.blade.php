@extends('layouts.app')

@section('title', 'Cek Status Keberatan')

@section('content')
<div class="container my-5">
    <h2 class="mb-4">Cek Status Keberatan</h2>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            <i class="bi bi-check-circle me-2"></i>
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show">
            <i class="bi bi-exclamation-circle me-2"></i>
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card">
        <div class="card-body">
            <form action="{{ route('keberatan.cek.proses') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label for="nomor_registrasi" class="form-label fw-bold">
                        <i class="bi bi-card-text me-1"></i>
                        Nomor Registrasi Keberatan <span class="text-danger">*</span>
                    </label>
                    <input type="text" 
                           name="nomor_registrasi" 
                           id="nomor_registrasi"
                           class="form-control @error('nomor_registrasi') is-invalid @enderror" 
                           value="{{ old('nomor_registrasi') }}"
                           placeholder="Contoh: KEB-202501-0001"
                           required>
                    @error('nomor_registrasi')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <small class="text-muted">
                        <i class="bi bi-info-circle me-1"></i>
                        Masukkan nomor registrasi yang Anda terima saat mengajukan keberatan
                    </small>
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label fw-bold">
                        <i class="bi bi-envelope me-1"></i>
                        Email <span class="text-danger">*</span>
                    </label>
                    <input type="email" 
                           name="email" 
                           id="email"
                           class="form-control @error('email') is-invalid @enderror" 
                           value="{{ old('email') }}"
                           placeholder="Contoh: email@example.com"
                           required>
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <small class="text-muted">
                        <i class="bi bi-shield-lock me-1"></i>
                        Masukkan email yang sama dengan yang Anda gunakan saat mengajukan keberatan
                    </small>
                </div>

                <div class="alert alert-info mb-3">
                    <i class="bi bi-info-circle-fill me-2"></i>
                    <strong>Catatan:</strong> Untuk keamanan data Anda, email yang dimasukkan harus sesuai dengan email yang terdaftar pada keberatan ini.
                </div>

                <button type="submit" class="btn btn-primary w-100">
                    <i class="bi bi-search me-2"></i>Cek Status
                </button>
            </form>
        </div>
    </div>

    <div class="card mt-3">
        <div class="card-body bg-light">
            <h6 class="fw-bold mb-3">
                <i class="bi bi-question-circle me-2"></i>Informasi
            </h6>
            <ul class="small mb-0">
                <li>Gunakan nomor registrasi yang Anda terima melalui email</li>
                <li>Email harus sama dengan yang digunakan saat mengajukan keberatan</li>
                <li>Anda dapat memberikan tanggapan setelah admin memberikan keputusan</li>
                <li>Status akan diupdate secara berkala sesuai progres penanganan</li>
            </ul>
        </div>
    </div>
</div>
@endsection