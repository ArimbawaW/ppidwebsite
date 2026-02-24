@extends('layouts.app')

@section('title', 'Galeri - PPID')

@section('content')

<!-- ================= HERO SECTION (MASTER TEMPLATE) ================= -->
<section class="hero-section">
    <div class="container hero-container">
        <div class="row align-items-center">
            <div class="col-md-8">
                <h1 class="text-white fw-bold mb-1">Galeri Kegiatan</h1>
                <p class="text-white-50 mb-0">
                    Dokumentasi foto kegiatan dan acara Kementerian PKP
                </p>
            </div>
            <div class="col-md-4 text-end d-none d-md-block">
                <i class="bi bi-images text-white icon-hero"></i>
            </div>
        </div>
    </div>
</section>

<!-- ================= CONTENT ================= -->
<section class="gallery-section">
    <div class="container">

        <div class="row g-4">
            @forelse($galeri as $item)
                <div class="col-md-4 col-lg-3">
                    <a href="{{ asset('storage/' . $item->gambar) }}" 
                       class="glightbox gallery-link" 
                       data-gallery="gallery1"
                       data-glightbox="title: {{ $item->judul }}; description: {{ $item->deskripsi ?? '' }}">

                        <div class="gallery-card">
                            <img src="{{ asset('storage/' . $item->gambar) }}" 
                                 alt="{{ $item->judul }}"
                                 class="gallery-img">

                            <div class="gallery-overlay">
                                <div class="overlay-content">
                                    <h6 class="mb-1">{{ $item->judul }}</h6>
                                    @if($item->deskripsi)
                                        <small>{{ Str::limit($item->deskripsi, 60) }}</small>
                                    @endif
                                </div>
                            </div>
                        </div>

                    </a>
                </div>
            @empty
                <div class="col-12">
                    <div class="empty-state">
                        <i class="bi bi-images"></i>
                        <h5>Tidak ada galeri ditemukan</h5>
                        <p>Belum tersedia dokumentasi kegiatan.</p>
                    </div>
                </div>
            @endforelse
        </div>

        <!-- ================= PAGINATION ================= -->
        @if($galeri->hasPages())
        <div class="row mt-5">
            <div class="col-12 d-flex justify-content-center">
                {{ $galeri->links() }}
            </div>
        </div>
        @endif

    </div>
</section>

{{-- ================= STYLES ================= --}}
<style>
:root{
    --main-blue:#1A6B8A;
}

/* ================= HERO ================= */
.hero-section{
    position:relative;
    background:linear-gradient(135deg,#1a6b8a 0%,#003344 100%);
    min-height:120px;
    padding:32px 0;
    display:flex;
    align-items:center;
    overflow:hidden;
    z-index:1;
}
.hero-section::before{
    content:"";
    position:absolute;
    inset:0;
    background-image:url('{{ asset("images/Pattern - Midnight Green.png") }}');
    background-size:180px;
    background-repeat:repeat;
    mix-blend-mode:overlay;
    opacity:.35;
    z-index:-1;
}
.hero-container{z-index:5;position:relative;}
.icon-hero{font-size:64px;opacity:.18}

/* ================= GALLERY SECTION ================= */
.gallery-section{
    background:#f6f9fb;
    padding:50px 0;
}

/* ================= CARD ================= */
.gallery-card{
    position:relative;
    border-radius:14px;
    overflow:hidden;
    box-shadow:0 6px 18px rgba(0,0,0,.08);
    transition:.35s ease;
    background:#fff;
}

.gallery-card:hover{
    transform:translateY(-8px);
    box-shadow:0 12px 30px rgba(0,0,0,.18);
}

/* ================= IMAGE ================= */
.gallery-img{
    width:100%;
    height:260px;
    object-fit:cover;
    display:block;
    transition:.4s ease;
}

.gallery-card:hover .gallery-img{
    transform:scale(1.06);
}

/* ================= OVERLAY ================= */
.gallery-overlay{
    position:absolute;
    inset:0;
    background:linear-gradient(to top, rgba(0,0,0,.65), rgba(0,0,0,.1), transparent);
    opacity:0;
    transition:.35s ease;
    display:flex;
    align-items:flex-end;
}

.gallery-card:hover .gallery-overlay{
    opacity:1;
}

.overlay-content{
    padding:14px 16px;
    color:#fff;
}

.overlay-content h6{
    font-weight:700;
    font-size:.95rem;
}

.overlay-content small{
    font-size:.75rem;
    opacity:.85;
}

/* ================= LINK ================= */
.gallery-link{
    text-decoration:none;
}

/* ================= EMPTY STATE ================= */
.empty-state{
    text-align:center;
    padding:80px 20px;
    background:#fff;
    border-radius:16px;
    box-shadow:0 6px 20px rgba(0,0,0,.06);
}
.empty-state i{
    font-size:48px;
    color:var(--main-blue);
    margin-bottom:12px;
}
.empty-state h5{
    font-weight:700;
    margin-bottom:6px;
}
.empty-state p{
    color:#6b7280;
    margin:0;
}

/* ================= RESPONSIVE ================= */
@media(max-width:768px){
    .hero-section{
        min-height:100px;
        padding:24px 0;
        text-align:center;
    }
    .icon-hero{display:none}
    .gallery-img{
        height:220px;
    }
}
</style>

@endsection
