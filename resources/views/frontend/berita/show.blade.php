@extends('layouts.app')

@section('title', $berita->judul . ' - PPID')

@section('content')

<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

<style>
    /* === GLOBAL & FONT SETTINGS === */
    body, .container, .content, h1, h2, h3, h4, h5, h6, span, p, a, div {
        font-family: 'Inter', sans-serif !important;
        letter-spacing: -0.02em; 
        -webkit-font-smoothing: antialiased;
    }

    .content {
        font-size: 0.95rem; 
        line-height: 1.8;
        color: #1f2937;
        word-wrap: break-word;
    }

    .content p { margin-bottom: 1.2rem; }

    .content img {
        max-width: 100%;
        height: auto;
        border-radius: 8px;
        margin: 1rem 0;
    }

    .entry-title {
        font-size: 1.75rem; 
        font-weight: 800;
        line-height: 1.3;
        color: #111827;
        letter-spacing: -0.03em;
    }

    .meta-text, .breadcrumb {
        font-size: 0.8rem;
        color: #6b7280;
    }

    .breadcrumb-item a {
        text-decoration: none;
        color: #6b7280;
        transition: color 0.2s;
    }
    .breadcrumb-item a:hover { color: #1a6b8a; }

    .sidebar-title {
        font-size: 0.9rem;
        font-weight: 700;
        text-transform: uppercase;
        color: #111827;
        letter-spacing: 0.05em;
    }

    .text-custom-blue { color: #1a6b8a !important; }

    .sidebar-item-title {
        font-size: 0.85rem; 
        font-weight: 600;
        line-height: 1.4;
        color: #1f2937;
        transition: color 0.2s;
    }
    
    .list-group-item:hover .sidebar-item-title { color: #1a6b8a; }

    .sidebar-thumb {
        width: 70px;
        height: 50px;
        object-fit: cover;
        border-radius: 6px;
    }

    .sticky-top {
        top: 100px;
        z-index: 10;
    }

    .share-btn {
        width: 32px;
        height: 32px;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.2s;
        background-color: #1a6b8a !important;
        border: none;
        color: white !important;
    }
    .share-btn:hover { 
        transform: scale(1.1); 
        filter: brightness(1.2);
    }

    .bg-custom-blue { background-color: #1a6b8a !important; }
    .btn-outline-custom {
        color: #1a6b8a;
        border-color: #1a6b8a;
    }
    .btn-outline-custom:hover {
        background-color: #1a6b8a;
        border-color: #1a6b8a;
        color: white;
    }

    @media (max-width: 768px) {
        .entry-title { font-size: 1.5rem; }
        .content { font-size: 0.92rem; }
    }
</style>

<div class="container my-4">
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/">Beranda</a></li>
            <li class="breadcrumb-item"><a href="{{ route('berita.index') }}">Berita</a></li>
            <li class="breadcrumb-item active text-truncate" aria-current="page" style="max-width: 200px;">{{ $berita->judul }}</li>
        </ol>
    </nav>

    <div class="row g-5">
        <div class="col-lg-8">
            <article>
                <header class="mb-4">
                    <h1 class="entry-title mb-3">{{ $berita->judul }}</h1>
                    
                    <div class="d-flex align-items-center flex-wrap gap-3 meta-text border-bottom pb-4">
                        <div class="d-flex align-items-center">
                            @php
                                $badgeClass = match($berita->kategori) {
                                    'berita' => 'bg-custom-blue text-white',
                                    'artikel' => 'bg-info text-dark',
                                    'pengumuman' => 'bg-warning text-dark',
                                    default => 'bg-secondary text-white'
                                };
                            @endphp
                            <span class="badge {{ $badgeClass }} px-2 py-1" style="font-size: 0.7rem;">{{ ucfirst($berita->kategori) }}</span>
                        </div>
                        <div class="d-flex align-items-center">
                            <i class="bi bi-calendar3 me-1 text-custom-blue"></i>
                            <span>{{ $berita->published_at ? $berita->published_at->translatedFormat('d F Y') : $berita->created_at->translatedFormat('d F Y') }}</span>
                        </div>
                        {{-- Bagian Admin Dihapus --}}
                        <div class="d-flex align-items-center border-start ps-3">
                            <i class="bi bi-eye me-1 text-custom-blue"></i>
                            <span>{{ number_format($berita->views) }} views</span>
                        </div>
                    </div>
                </header>

                @if($berita->gambar)
                    <figure class="mb-4">
                        <img src="{{ asset('storage/' . $berita->gambar) }}" class="w-100 rounded-3 shadow-sm" alt="{{ $berita->judul }}">
                        @if(isset($berita->caption_gambar))
                            <figcaption class="text-center text-muted mt-2 fst-italic" style="font-size: 0.8rem;">{{ $berita->caption_gambar }}</figcaption>
                        @endif
                    </figure>
                @endif

                <div class="content entry-content">
                    {!! $berita->konten !!}
                </div>

                <div class="mt-5 p-4 bg-light rounded-3 d-flex align-items-center justify-content-between border">
                    <div>
                        <span class="fw-bold text-dark d-block" style="font-size: 0.85rem;">Sukai artikel ini?</span>
                        <span class="text-muted" style="font-size: 0.75rem;">Bagikan ke rekan Anda</span>
                    </div>
                    <div class="d-flex gap-2">
                        <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(request()->fullUrl()) }}" target="_blank" class="btn share-btn rounded-circle">
                            <i class="bi bi-facebook"></i>
                        </a>
                        <a href="https://twitter.com/intent/tweet?url={{ urlencode(request()->fullUrl()) }}&text={{ urlencode($berita->judul) }}" target="_blank" class="btn share-btn rounded-circle">
                            <i class="bi bi-twitter"></i>
                        </a>
                        <a href="https://api.whatsapp.com/send?text={{ urlencode($berita->judul . ' ' . request()->fullUrl()) }}" target="_blank" class="btn share-btn rounded-circle">
                            <i class="bi bi-whatsapp"></i>
                        </a>
                    </div>
                </div>
            </article>
        </div>

        <div class="col-lg-4">
            <div class="sticky-top">
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body p-3">
                        <form action="{{ route('berita.index') }}" method="GET">
                            <div class="input-group">
                                <input type="text" name="search" class="form-control form-control-sm border-end-0" placeholder="Cari berita...">
                                <button class="btn btn-sm btn-outline-custom border-start-0" type="submit">
                                    <i class="bi bi-search"></i>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-white py-3 border-bottom">
                        <h5 class="mb-0 sidebar-title text-custom-blue">Berita Terbaru</h5>
                    </div>
                    <div class="list-group list-group-flush">
                        @forelse($beritaTerbaru as $item)
                            <a href="{{ route('berita.show', $item->slug) }}" class="list-group-item list-group-item-action py-3 border-bottom">
                                <div class="row align-items-start g-3">
                                    <div class="col-4">
                                        <img src="{{ $item->gambar ? asset('storage/' . $item->gambar) : asset('images/no-image.jpg') }}" class="sidebar-thumb shadow-sm" alt="{{ $item->judul }}">
                                    </div>
                                    <div class="col-8">
                                        <h6 class="mb-1 sidebar-item-title">{{ Str::limit($item->judul, 55) }}</h6>
                                        <div class="text-muted d-flex align-items-center gap-1" style="font-size: 0.7rem;">
                                            <i class="bi bi-calendar3 text-custom-blue"></i> 
                                            {{ $item->published_at ? $item->published_at->format('d M Y') : $item->created_at->format('d M Y') }}
                                        </div>
                                    </div>
                                </div>
                            </a>
                        @empty
                            <div class="p-4 text-center text-muted small">Tidak ada berita lain</div>
                        @endforelse
                    </div>
                </div>

                <div class="d-grid">
                    <a href="{{ route('berita.index') }}" class="btn btn-outline-custom fw-bold" style="font-size: 0.8rem; border-style: dashed;">
                        <i class="bi bi-arrow-left me-2"></i>KEMBALI KE SEMUA BERITA
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection