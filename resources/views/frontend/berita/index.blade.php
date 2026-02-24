@extends('layouts.app')

@section('title', 'Berita - PPID')

@section('content')

<section class="hero-section">
    <div class="container hero-container">
        <div class="row align-items-center">
            <div class="col-md-8">
                <h1 class="text-white fw-bold mb-1">Berita</h1>
                <p class="text-white-50 mb-0">
                    Informasi terkini seputar kegiatan dan program Kementerian PKP
                </p>
            </div>
            <div class="col-md-4 text-end d-none d-md-block">
                {{-- Ikon berita disesuaikan dengan style samar (opacity) --}}
                <i class="bi bi-newspaper text-white icon-hero"></i>
            </div>
        </div>
    </div>
</section>

{{-- FILTER SECTION --}}
<section class="bg-light filter-section border-bottom">
    <div class="container py-4">
        <form action="{{ route('berita.index') }}" method="GET" class="row g-3 align-items-center">
            <div class="col-md-3">
                <select name="kategori" class="form-select border-0 shadow-sm px-3 py-2">
                    <option value="">Semua Kategori</option>
                    <option value="berita" {{ request('kategori') == 'berita' ? 'selected' : '' }}>Berita</option>
                    <option value="artikel" {{ request('kategori') == 'artikel' ? 'selected' : '' }}>Artikel</option>
                    <option value="pengumuman" {{ request('kategori') == 'pengumuman' ? 'selected' : '' }}>Pengumuman</option>
                </select>
            </div>
            <div class="col-md-7">
                <div class="input-group shadow-sm">
                    <span class="input-group-text bg-white border-0 ps-3">
                        <i class="bi bi-search text-muted"></i>
                    </span>
                    <input type="text" name="search" class="form-control border-0 py-2" placeholder="Cari berita..." value="{{ request('search') }}">
                </div>
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-primary w-100 fw-semibold shadow-sm py-2">Cari</button>
            </div>
        </form>
    </div>
</section>

{{-- MAIN CONTENT --}}
<section class="py-5 bg-white">
    <div class="container">
        <div class="row g-4">
            @forelse($berita as $item)
            <div class="col-md-4 col-sm-6">
                <div class="card h-100 border-0 shadow-sm hover-card">
                    {{-- Image Wrapper --}}
                    <div class="position-relative overflow-hidden card-img-container">
                        @if($item->gambar)
                            <img src="{{ asset('storage/' . $item->gambar) }}" class="card-img-top news-img" alt="{{ $item->judul }}">
                        @else
                            <div class="bg-light d-flex align-items-center justify-content-center news-img">
                                <i class="bi bi-image text-muted opacity-25 fs-1"></i>
                            </div>
                        @endif
                        
                        {{-- Kategori Badge --}}
                        <div class="position-absolute top-0 start-0 m-3">
                            @php
                                $badgeClass = match($item->kategori) {
                                    'berita' => 'bg-primary',
                                    'artikel' => 'bg-info text-dark',
                                    'pengumuman' => 'bg-warning text-dark',
                                    default => 'bg-secondary'
                                };
                            @endphp
                            <span class="badge {{ $badgeClass }} shadow-sm px-3 py-2">{{ ucfirst($item->kategori) }}</span>
                        </div>
                    </div>

                    <div class="card-body p-4 d-flex flex-column">
                        {{-- Meta Info --}}
                        <div class="mb-3 d-flex justify-content-between align-items-center">
                            <small class="text-muted d-flex align-items-center gap-2">
                                <i class="bi bi-calendar3"></i> 
                                {{ $item->published_at ? $item->published_at->translatedFormat('d M Y') : $item->created_at->translatedFormat('d M Y') }}
                            </small>
                            <small class="text-muted d-flex align-items-center gap-1">
                                <i class="bi bi-eye"></i> {{ $item->views }}
                            </small>
                        </div>
                        
                        {{-- Judul --}}
                        <h5 class="card-title fw-bold mb-3 text-dark" style="line-height: 1.5; font-size: 1.15rem;">
                            <a href="{{ route('berita.show', $item->slug) }}" class="text-decoration-none text-dark link-primary-hover">
                                {{ Str::limit($item->judul, 75) }}
                            </a>
                        </h5>

                        {{-- Footer Link --}}
                        <div class="mt-auto">
                            <hr class="opacity-10 mb-3">
                            <a href="{{ route('berita.show', $item->slug) }}" class="fw-bold text-primary text-decoration-none small d-flex align-items-center gap-1">
                                Baca Selengkapnya <i class="bi bi-arrow-right-short fs-5"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-12 text-center py-5">
                <div class="py-5">
                    <i class="bi bi-newspaper text-muted fs-1 opacity-25 mb-3 d-block"></i>
                    <h4 class="text-muted">Tidak ada berita ditemukan</h4>
                    <p class="text-muted-50">Coba gunakan kata kunci atau kategori lain.</p>
                </div>
            </div>
            @endforelse
        </div>

        {{-- PAGINATION --}}
        <div class="row mt-5">
            <div class="col-md-12 d-flex justify-content-center">
                {{ $berita->appends(request()->input())->links() }}
            </div>
        </div>
    </div>
</section>

@endsection

@push('styles')
<style>
:root {
    --main-blue: #1A6B8A;
    --dark-blue: #003344;
}

/* ================= HERO (IDENTIK DENGAN MASTER TEMPLATE) ================= */
.hero-section {
    position: relative;
    background: linear-gradient(135deg, #1a6b8a 0%, #003344 100%);
    min-height: 120px; /* Ukuran standard template */
    padding: 32px 0;
    display: flex;
    align-items: center;
    overflow: hidden;
    z-index: 1;
}

.hero-section::before {
    content: "";
    position: absolute;
    inset: 0;
    background-image: url('{{ asset("images/Pattern - Midnight Green.png") }}');
    background-size: 180px;
    background-repeat: repeat;
    mix-blend-mode: overlay;
    opacity: .35;
    z-index: -1;
}

.hero-container { z-index: 5; position: relative; }

.icon-hero {
    font-size: 64px; /* Sama dengan template galeri */
    opacity: .18;
    color: #fff;
}

/* ================= CARD STYLING ================= */
.hover-card {
    transition: all 0.3s ease;
    border-radius: 12px;
}
.hover-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 15px 35px rgba(0,0,0,0.1) !important;
}

.card-img-container {
    height: 220px;
    border-radius: 12px 12px 0 0;
}

.news-img {
    height: 100%;
    width: 100%;
    object-fit: cover;
    transition: transform 0.6s ease;
}

.hover-card:hover .news-img {
    transform: scale(1.1);
}

.link-primary-hover {
    transition: color 0.2s ease;
}
.link-primary-hover:hover {
    color: var(--main-blue) !important;
}

/* Badge & Colors */
.badge.bg-primary { background-color: var(--main-blue) !important; }
.btn-primary { 
    background-color: var(--main-blue) !important; 
    border: none;
    transition: filter 0.2s;
}
.btn-primary:hover {
    filter: brightness(115%);
}
.text-primary { color: var(--main-blue) !important; }

/* Pagination Styling Customization */
.pagination .page-item.active .page-link {
    background-color: var(--main-blue);
    border-color: var(--main-blue);
}

@media(max-width: 768px) {
    .hero-section {
        min-height: 100px;
        padding: 24px 0;
        text-align: center;
    }
    .icon-hero { display: none; }
    .card-img-container { height: 180px; }
}
</style>
@endpush