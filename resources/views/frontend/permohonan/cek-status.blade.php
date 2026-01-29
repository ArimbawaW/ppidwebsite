@extends('layouts.app')

@section('title', 'Cek Status Permohonan')

@section('content')
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-lg-6">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-5">
                    <div class="text-center mb-4">
                        <i class="fas fa-search fa-3x text-primary mb-3"></i>
                        <h3 class="fw-bold" style="color:#0e5b73;">Cek Status Permohonan</h3>
                        <p class="text-muted">Masukkan nomor registrasi dan email Anda untuk mengecek status permohonan informasi</p>
                    </div>

                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show">
                            <i class="bi bi-check-circle me-2"></i>
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show">
                            <i class="fas fa-exclamation-circle me-2"></i>
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <form action="{{ route('permohonan.cek-status.proses') }}" method="POST">
                        @csrf
                        
                        <div class="mb-4">
                            <label for="nomor_registrasi" class="form-label fw-bold">
                                <i class="fas fa-hashtag me-1"></i> 
                                Nomor Registrasi <span class="text-danger">*</span>
                            </label>
                            <input type="text" 
                                   name="nomor_registrasi" 
                                   id="nomor_registrasi"
                                   class="form-control form-control-lg @error('nomor_registrasi') is-invalid @enderror" 
                                   placeholder="Contoh: PPID/PERMOHONAN/2025/01/001"
                                   value="{{ old('nomor_registrasi') }}"
                                   required>
                            @error('nomor_registrasi')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="form-text text-muted">
                                <i class="fas fa-info-circle me-1"></i>
                                Masukkan nomor registrasi yang Anda terima saat mengajukan permohonan
                            </small>
                        </div>

                        <div class="mb-4">
                            <label for="email" class="form-label fw-bold">
                                <i class="fas fa-envelope me-1"></i>
                                Email <span class="text-danger">*</span>
                            </label>
                            <input type="email" 
                                   name="email" 
                                   id="email"
                                   class="form-control form-control-lg @error('email') is-invalid @enderror" 
                                   placeholder="Contoh: email@example.com"
                                   value="{{ old('email') }}"
                                   required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="form-text text-muted">
                                <i class="fas fa-shield-lock me-1"></i>
                                Masukkan email yang sama dengan yang Anda gunakan saat mengajukan permohonan
                            </small>
                        </div>

                        <div class="alert alert-info mb-4">
                            <i class="fas fa-info-circle me-2"></i>
                            <strong>Catatan:</strong> Untuk keamanan data Anda, email yang dimasukkan harus sesuai dengan email yang terdaftar pada permohonan ini.
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-lg" style="background:#0e5b73;color:white;">
                                <i class="fas fa-search me-2"></i> Cek Status
                            </button>
                        </div>
                    </form>

                    <hr class="my-4">

                    <div class="text-center">
                        <small class="text-muted">
                            Belum mengajukan permohonan? 
                            <a href="{{ route('permohonan.index') }}" class="text-decoration-none fw-bold" style="color:#0e5b73;">
                                Ajukan Sekarang
                            </a>
                        </small>
                    </div>
                </div>
            </div>

            {{-- Info Box --}}
            <div class="card mt-3 border-0 shadow-sm">
                <div class="card-body bg-light">
                    <h6 class="fw-bold mb-3">
                        <i class="fas fa-question-circle me-2"></i>Informasi
                    </h6>
                    <ul class="small mb-0">
                        <li class="mb-2">Gunakan nomor registrasi yang Anda terima melalui email</li>
                        <li class="mb-2">Email harus sama dengan yang digunakan saat mengajukan permohonan</li>
                        <li class="mb-2">Status akan diupdate secara berkala sesuai progres penanganan</li>
                        <li class="mb-2">Proses permohonan maksimal 10 hari kerja sesuai UU KIP</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .card {
        border-radius: 15px;
    }
    
    .btn:hover {
        opacity: 0.9;
        transform: translateY(-2px);
        transition: all 0.3s ease;
    }
    
    .form-control:focus {
        border-color: #0e5b73;
        box-shadow: 0 0 0 0.2rem rgba(14, 91, 115, 0.25);
    }
</style>
@endpush