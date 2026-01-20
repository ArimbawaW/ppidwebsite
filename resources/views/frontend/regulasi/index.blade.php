@extends('layouts.app')

@section('title', 'Regulasi - PPID')

@section('content')

<!-- Hero Section -->
<section class="py-5" style="background: linear-gradient(135deg, #1a6b8a 0%, #003344 100%);">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-8">
                <h1 class="text-white fw-bold mb-3">Regulasi</h1>
                <p class="text-white-50 mb-0 fs-5">
                    Kumpulan peraturan perundang-undangan yang menjadi dasar pelaksanaan PPID
                </p>
            </div>
            <div class="col-md-4 text-end">
                <i class="bi bi-file-earmark-text text-white" style="font-size: 120px; opacity: 0.2;"></i>
            </div>
        </div>
    </div>
</section>

<!-- Filter Section -->
<section class="py-4 bg-light">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="btn-group" role="group">
                    <button type="button" class="btn btn-outline-primary active">Semua</button>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Content Section -->
<section class="py-5">
    <div class="container">
        <div class="row g-4">
            @forelse($regulasi as $item)
            <div class="col-md-6 col-lg-4">
                <div class="card h-100 shadow-sm border-0 hover-card">
                    <div class="card-body">
                        <!-- Badge Kategori -->
                        <div class="mb-3">
                            <span class="badge bg-primary">{{ $item->kategori ?? 'Regulasi' }}</span>
                            @if($item->tanggal_terbit)
                            <span class="badge bg-secondary">{{ $item->tanggal_terbit->format('Y') }}</span>
                            @endif
                        </div>

                        <!-- Nomor -->
                        @if($item->nomor)
                        <h6 class="text-muted mb-2">{{ $item->nomor }}</h6>
                        @endif

                        <!-- Judul -->
                        <h5 class="card-title fw-bold mb-3" style="color: #1a6b8a;">
                            {{ $item->judul }}
                        </h5>

                        <!-- Deskripsi -->
                        @if($item->deskripsi)
                        <p class="card-text text-muted small">
                            {{ Str::limit($item->deskripsi, 100) }}
                        </p>
                        @endif

                        <!-- Tanggal -->
                        @if($item->tanggal_terbit)
                        <p class="text-muted small mb-3">
                            <i class="bi bi-calendar3 me-1"></i>
                            Ditetapkan: {{ $item->tanggal_terbit->format('d F Y') }}
                        </p>
                        @endif
                    </div>
                    
                    <div class="card-footer bg-white border-0">
                        @if($item->file)
                        <a href="{{ asset('storage/' . $item->file) }}" 
                           target="_blank" 
                           class="btn btn-outline-primary btn-sm w-100">
                            <i class="bi bi-download me-2"></i>Unduh Dokumen
                        </a>
                        @else
                        <button class="btn btn-outline-secondary btn-sm w-100" disabled>
                            <i class="bi bi-file-earmark-x me-2"></i>Dokumen Tidak Tersedia
                        </button>
                        @endif
                    </div>
                </div>
            </div>
            @empty
            <div class="col-12">
                <div class="alert alert-info text-center">
                    <i class="bi bi-info-circle me-2"></i>
                    Belum ada regulasi yang tersedia.
                </div>
            </div>
            @endforelse
        </div>

        <!-- Pagination -->
        @if($regulasi->hasPages())
        <div class="row mt-5">
            <div class="col-12 d-flex justify-content-center">
                {{ $regulasi->links() }}
            </div>
        </div>
        @endif
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