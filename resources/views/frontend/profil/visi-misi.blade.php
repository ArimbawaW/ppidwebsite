@extends('layouts.app')

@section('title', 'Visi-Misi - PPID')

@section('content')

<!-- ================= HERO SECTION (MASTER TEMPLATE) ================= -->
<section class="hero-section">
    <div class="container hero-container">
        <div class="row align-items-center">
            <div class="col-md-8">
                <h1 class="text-white fw-bold mb-1">Visi & Misi</h1>
                <p class="text-white-50 mb-0">
                    Visi dan misi PPID Kementerian Perumahan dan Kawasan Permukiman
                </p>
            </div>
            <div class="col-md-4 text-end d-none d-md-block">
                <i class="bi bi-eye text-white icon-hero"></i>
            </div>
        </div>
    </div>
</section>

<!-- ================= CONTENT ================= -->
<div class="container my-4">
    <div class="card shadow-sm border-0">
        <div class="card-body text-center">

            {{-- GAMBAR VISI --}}
            <img 
                src="{{ asset('images/visi.png') }}" 
                alt="Visi Misi PPID"
                class="img-fluid mx-auto d-block visi-img"
            >

        </div>
    </div>

    <!-- ================= BERITA TERBARU ================= -->
    <x-news-section :beritaTerbaru="$beritaTerbaru ?? collect()" />

</div>

{{-- ================= STYLES ================= --}}
<style>
/* ========================================
   HERO SECTION (MASTER TEMPLATE)
   ======================================== */

.hero-section {
    position: relative;
    background: linear-gradient(135deg, #1a6b8a 0%, #003344 100%);
    overflow: hidden;
    display: flex;
    align-items: center;
    min-height: 120px;
    padding: 32px 0;
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
    opacity: 0.35;
    z-index: -1;
    pointer-events: none;
}

.hero-container {
    position: relative;
    z-index: 10;
}

.hero-section h1 {
    font-size: 1.9rem;
    line-height: 1.2;
}

.hero-section p {
    font-size: 0.95rem;
}

.icon-hero {
    font-size: 64px;
    opacity: 0.18;
}

/* ========================================
   VISI IMAGE
   ======================================== */

.visi-img {
    width: 100%;
    max-width: 1200px;
    height: auto;
    object-fit: contain;
}

/* ========================================
   RESPONSIVE
   ======================================== */

@media (max-width: 768px) {
    .hero-section {
        min-height: 100px;
        padding: 24px 0;
        text-align: center;
    }

    .hero-section h1 {
        font-size: 1.5rem;
    }

    .hero-section p {
        font-size: 0.85rem;
    }

    .icon-hero {
        display: none;
    }

    .hero-section::before {
        background-size: 140px;
    }
}
</style>

@endsection
