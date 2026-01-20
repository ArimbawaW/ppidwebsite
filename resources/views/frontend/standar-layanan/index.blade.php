@extends('layouts.app')

@section('title', 'Standar Layanan - PPID')

@section('content')

<!-- Hero Section -->
<section class="py-5" style="background: linear-gradient(135deg, #1a6b8a 0%, #003344 100%);">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-8">
                <h1 class="text-white fw-bold mb-3">Standar Layanan</h1>
                <p class="text-white-50 mb-0 fs-5">
                    Standar pelayanan informasi publik di lingkungan Kementerian PKP
                </p>
            </div>
            <div class="col-md-4 text-end">
                <i class="bi bi-clipboard-check text-white" style="font-size: 120px; opacity: 0.2;"></i>
            </div>
        </div>
    </div>
</section>

<!-- Content Section -->
<section class="py-5">
    <div class="container">
        
        <!-- Intro -->
        <div class="row mb-5">
            <div class="col-lg-8 mx-auto text-center">
                <h2 class="fw-bold mb-3">Standar Pelayanan Informasi Publik</h2>
                <p class="text-muted">
                    Berikut adalah standar layanan yang kami berikan untuk memenuhi hak masyarakat 
                    dalam memperoleh informasi publik sesuai dengan Undang-Undang No. 14 Tahun 2008.
                </p>
            </div>
        </div>

        <!-- Standar Layanan Cards -->
        <div class="row g-4">
            @forelse($standarLayanan as $index => $item)
            <div class="col-md-6 col-lg-4">
                <div class="card h-100 shadow-sm border-0 hover-card">
                    <!-- Icon Header -->
                    <div class="card-header text-white text-center py-4" 
                         style="background: linear-gradient(135deg, #1a6b8a 0%, #003344 100%);">
                        <div class="mb-2">
                            <i class="bi bi-{{ $index % 3 == 0 ? 'clock' : ($index % 3 == 1 ? 'file-text' : 'check-circle') }} fs-1"></i>
                        </div>
                        <h5 class="mb-0 fw-bold">{{ $item->judul }}</h5>
                    </div>
                    
                    <div class="card-body">
                        @if($item->deskripsi)
                        <p class="text-muted">{{ $item->deskripsi }}</p>
                        @endif
                    </div>
                    
                    @if($item->file)
                    <div class="card-footer bg-white border-0">
                        <a href="{{ asset('storage/' . $item->file) }}" 
                           target="_blank" 
                           class="btn btn-outline-primary btn-sm w-100">
                            <i class="bi bi-download me-2"></i>Unduh Dokumen
                        </a>
                    </div>
                    @endif
                </div>
            </div>
            @empty
            <div class="col-12">
                <div class="alert alert-info text-center">
                    <i class="bi bi-info-circle me-2"></i>
                    Belum ada standar layanan yang tersedia.
                </div>
            </div>
            @endforelse
        </div>

        <!-- Maklumat Pelayanan -->
        <div class="row mt-5">
            <div class="col-lg-10 mx-auto">
                <div class="card shadow-sm border-0" style="background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);">
                    <div class="card-body p-5">
                        <h3 class="fw-bold mb-4 text-center">
                            <i class="bi bi-megaphone me-2" style="color: #1a6b8a;"></i>
                            Maklumat Pelayanan
                        </h3>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <div class="d-flex align-items-start">
                                    <i class="bi bi-check-circle-fill text-success me-3 fs-4"></i>
                                    <div>
                                        <h6 class="fw-bold mb-1">Waktu Layanan</h6>
                                        <p class="mb-0 text-muted">Senin - Jumat: 08.00 - 16.00 WIB</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="d-flex align-items-start">
                                    <i class="bi bi-check-circle-fill text-success me-3 fs-4"></i>
                                    <div>
                                        <h6 class="fw-bold mb-1">Biaya</h6>
                                        <p class="mb-0 text-muted">Gratis untuk informasi publik</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="d-flex align-items-start">
                                    <i class="bi bi-check-circle-fill text-success me-3 fs-4"></i>
                                    <div>
                                        <h6 class="fw-bold mb-1">Waktu Penyelesaian</h6>
                                        <p class="mb-0 text-muted">Maksimal 10 hari kerja</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="d-flex align-items-start">
                                    <i class="bi bi-check-circle-fill text-success me-3 fs-4"></i>
                                    <div>
                                        <h6 class="fw-bold mb-1">Kontak</h6>
                                        <p class="mb-0 text-muted">ppid@pu.go.id</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</section>

<style>
.hover-card {
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.hover-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 30px rgba(0,0,0,0.15) !important;
}
</style>

@endsection