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
                        <p class="text-muted">Masukkan nomor registrasi Anda untuk mengecek status permohonan informasi</p>
                    </div>

                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <form action="{{ route('permohonan.cek-status.proses') }}" method="POST">
                        @csrf
                        
                        <div class="mb-4">
                            <label class="form-label fw-bold">
                                <i class="fas fa-hashtag"></i> Nomor Registrasi
                            </label>
                            <input type="text" 
                                   name="nomor_registrasi" 
                                   class="form-control form-control-lg @error('nomor_registrasi') is-invalid @enderror" 
                                   placeholder="Contoh: PPID/PERMOHONAN/2025/12/001"
                                   value="{{ old('nomor_registrasi') }}"
                                   required>
                            @error('nomor_registrasi')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="form-text text-muted">
                                <i class="fas fa-info-circle"></i> 
                                Masukkan nomor registrasi yang Anda terima saat mengajukan permohonan
                            </small>
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-lg" style="background:#0e5b73;color:white;">
                                <i class="fas fa-search"></i> Cek Status
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
        </div>
    </div>
</div>
@endsection