@extends('layouts.app')

@section('title', 'Tugas dan Tanggung Jawab - PPID')

@section('content')

<!-- ================= HERO SECTION ================= -->
<section class="hero-section">
    <div class="container hero-container">
        <div class="row align-items-center">
            <div class="col-md-8">
                <h1 class="text-white fw-bold mb-1">Tugas dan Tanggung Jawab</h1>
                <p class="text-white-50 mb-0">
                    Tugas dan Tanggung Jawab PPID dalam pelayanan informasi publik
                </p>
            </div>
            <div class="col-md-4 text-end d-none d-md-block">
                <i class="bi bi-clipboard-check text-white icon-hero"></i>
            </div>
        </div>
    </div>
</section>

<!-- ================= CONTENT ================= -->
<div class="container my-4">

    {{-- TAB NAV --}}
    <ul class="nav nav-tabs custom-tabs mb-4" id="tugasFungsiTab" role="tablist">
        <li class="nav-item">
            <button class="nav-link active"
                data-bs-toggle="tab"
                data-bs-target="#ppid">
                PPID
            </button>
        </li>
        <li class="nav-item">
            <button class="nav-link"
                data-bs-toggle="tab"
                data-bs-target="#ppid-pelaksana">
                PPID Pelaksana
            </button>
        </li>
    </ul>

    <div class="tab-content">

        {{-- ================= PPID ================= --}}
        <div class="tab-pane fade show active" id="ppid">

            <div class="card shadow-sm border-0">
                <div class="card-body text-center">

                    <img src="{{ asset('images/TugasPPID.png') }}"
                        class="img-fluid tugas-img"
                        alt="Tugas PPID">

                </div>
            </div>

        </div>


        {{-- ================= PPID PELAKSANA ================= --}}
        <div class="tab-pane fade" id="ppid-pelaksana">

            <div class="card shadow-sm border-0">
                <div class="card-body text-center">

                    <div id="carouselTugas" class="carousel slide">

                        <div class="carousel-inner">

                            <div class="carousel-item active">
                                <img src="{{ asset('images/20.png') }}"
                                    class="img-fluid tugas-img"
                                    alt="Tugas 1">
                            </div>

                            <div class="carousel-item">
                                <img src="{{ asset('images/21.png') }}"
                                    class="img-fluid tugas-img"
                                    alt="Tugas 2">
                            </div>

                            <div class="carousel-item">
                                <img src="{{ asset('images/22.png') }}"
                                    class="img-fluid tugas-img"
                                    alt="Tugas 3">
                            </div>

                            <div class="carousel-item">
                                <img src="{{ asset('images/23.png') }}"
                                    class="img-fluid tugas-img"
                                    alt="Tugas 4">
                            </div>

                        </div>

                        {{-- ARROW --}}
                        <button class="carousel-control-prev"
                            type="button"
                            data-bs-target="#carouselTugas"
                            data-bs-slide="prev">
                            <span class="carousel-control-prev-icon custom-nav"></span>
                        </button>

                        <button class="carousel-control-next"
                            type="button"
                            data-bs-target="#carouselTugas"
                            data-bs-slide="next">
                            <span class="carousel-control-next-icon custom-nav"></span>
                        </button>

                    </div>

                </div>
            </div>

        </div>

    </div>

    <x-news-section :beritaTerbaru="$beritaTerbaru ?? collect()" />

</div>
@endsection

@push('styles')
<style>

/* ========================================
   HERO SECTION
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
}

.hero-container {
    position: relative;
    z-index: 10;
}

.hero-section h1 {
    font-size: 1.85rem;
}

.hero-section p {
    font-size: 0.95rem;
}

.icon-hero {
    font-size: 64px;
    opacity: 0.18;
}


/* ========================================
   CUSTOM TABS
======================================== */
.custom-tabs {
    border-bottom: 2px solid #e5e7eb;
}

.custom-tabs .nav-link {
    color: #6c757d;
    border: none;
    border-bottom: 3px solid transparent;
    padding: 12px 24px;
    font-weight: 600;
    font-size: 0.95rem;
}

.custom-tabs .nav-link.active {
    color: #1a6b8a;
    border-bottom: 3px solid #1a6b8a;
}


/* ========================================
   CARD
======================================== */
.card {
    border-radius: 16px;
    border: 1px solid #edf1f4;
    box-shadow: 0 6px 18px rgba(0,0,0,0.05);
}

.card-body {
    padding: 28px;
}


/* ========================================
   GALLERY — MATCH TUGAS PPID
======================================== */

.gallery-wrapper {
    width: 100%;
    max-width: 760px;          /* ukuran sama seperti tugas ppid */
    margin: 0 auto;
    background: #fff;
    border-radius: 14px;
    border: 1px solid #edf1f4;
    box-shadow: 0 8px 24px rgba(0,0,0,0.05);
    overflow: hidden;
}

/* container utama gambar */
.gallery-main {
    width: 100%;
    position: relative;
}

/* GAMBAR UTAMA — PROPORSIONAL */
.gallery-img {
    width: 100%;
    height: auto;
    display: block;
}


/* ========================================
   CAROUSEL FIX
======================================== */

.carousel-item {
    width: 100%;
}

.carousel-item img {
    width: 100%;
    height: auto;
    display: block;
}


/* ========================================
   ARROW DALAM FOTO
======================================== */

.carousel-control-prev,
.carousel-control-next {
    width: 10%;
    opacity: 1;
}

.custom-nav {
    background-color: rgba(0,0,0,0.45);
    border-radius: 50%;
    width: 42px;
    height: 42px;
    background-size: 55%;
}

.carousel-control-prev:hover .custom-nav,
.carousel-control-next:hover .custom-nav {
    background-color: rgba(0,0,0,0.7);
}


/* ========================================
   THUMBNAIL
======================================== */

.gallery-thumbs {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 12px;
    padding: 14px;
    border-top: 1px solid #f1f3f5;
}

.thumb {
    width: 100%;
    height: 85px;
    object-fit: cover;
    border-radius: 8px;
    cursor: pointer;
    opacity: 0.6;
    border: 2px solid transparent;
    transition: 0.25s;
}

.thumb:hover {
    opacity: 1;
}

.thumb.active {
    opacity: 1;
    border-color: #1a6b8a;
}


/* ========================================
   TUGAS IMAGE (JIKA DIPAKAI)
======================================== */

.tugas-img {
    width: 100%;
    max-width: 760px;
    height: auto;
    display: block;
    margin: 0 auto;
}


/* ========================================
   RESPONSIVE
======================================== */

@media (max-width: 992px) {
    .gallery-wrapper {
        max-width: 100%;
    }
}

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

    .gallery-thumbs {
        grid-template-columns: repeat(2, 1fr);
    }

}

@media (max-width: 480px) {

    .thumb {
        height: 70px;
    }

}

</style>
@endpush

@push('scripts')
<script>
document.addEventListener("DOMContentLoaded", function () {
    const carouselEl = document.getElementById('carouselTugas');
    if (!carouselEl) return;

    // Bootstrap 5 Carousel instance - manual (no auto-cycle)
    const carousel = new bootstrap.Carousel(carouselEl, {
        interval: false,
        ride: false,
        wrap: true
    });

    const thumbs = Array.from(document.querySelectorAll(".thumb"));

    // Klik thumbnail => pindah slide + set active
    thumbs.forEach((thumb, index) => {
        thumb.addEventListener("click", () => {
            carousel.to(index);
            thumbs.forEach(t => t.classList.remove("active"));
            thumb.classList.add("active");
        });
    });

    // Sinkronkan highlight thumbnail ketika slide berubah via nav
    carouselEl.addEventListener('slid.bs.carousel', (e) => {
        const idx = e.to;
        thumbs.forEach(t => t.classList.remove("active"));
        if (thumbs[idx]) thumbs[idx].classList.add("active");
    });
});
</script>
@endpush