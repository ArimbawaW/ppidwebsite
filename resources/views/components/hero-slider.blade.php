@php
    // Ambil banner aktif dari database
    $banners = \App\Models\BannerSlider::getActiveBanners();
@endphp

<!-- ================= GOLD DIVIDER ================= -->
<div class="gold-divider"></div>

<!-- ================= HERO SLIDER ================= -->
@if($banners->count() > 0)
<div id="headerCarousel" class="carousel slide" data-bs-ride="carousel" data-bs-pause="hover">

    <!-- Carousel Items -->
    <div class="carousel-inner">
        @foreach($banners as $index => $banner)
            <div class="carousel-item {{ $index === 0 ? 'active' : '' }}" data-bs-interval="5000">
                <img src="{{ asset($banner->gambar) }}"
                     alt="{{ $banner->judul ?: 'Banner ' . ($index + 1) }}"
                     loading="{{ $index === 0 ? 'eager' : 'lazy' }}">
            </div>
        @endforeach
    </div>

    @if($banners->count() > 1)

        <!-- Navigation -->
        <button class="carousel-control-prev"
                type="button"
                data-bs-target="#headerCarousel"
                data-bs-slide="prev">
            <span class="carousel-control-prev-icon"></span>
        </button>

        <button class="carousel-control-next"
                type="button"
                data-bs-target="#headerCarousel"
                data-bs-slide="next">
            <span class="carousel-control-next-icon"></span>
        </button>

        <!-- Indicators -->
        <div class="carousel-indicators">
            @foreach($banners as $index => $banner)
                <button type="button"
                        data-bs-target="#headerCarousel"
                        data-bs-slide-to="{{ $index }}"
                        class="{{ $index === 0 ? 'active' : '' }}">
                </button>
            @endforeach
        </div>

    @endif

</div>
@else

<!-- FALLBACK -->
<div id="headerCarousel" class="carousel slide" data-bs-ride="carousel">

    <div class="carousel-inner">
        <div class="carousel-item active">
            <img src="{{ asset('images/header1.png') }}" alt="Banner">
        </div>
    </div>

</div>

@endif


<style>

/* ========================================
   GOLD DIVIDER
======================================== */
.gold-divider {
    width: 100%;
    height: 4px;
    background: linear-gradient(90deg, #d5c58a 0%, #f4e4a6 50%, #d5c58a 100%);
}


/* ========================================
   HEADER CAROUSEL
======================================== */

#headerCarousel {
    width: 100%;
    aspect-ratio: 1920 / 548; /* rasio banner */
    position: relative;
    overflow: hidden;
}

/* Item */
#headerCarousel .carousel-item {
    width: 100%;
    height: 100%;
}

/* Image */
#headerCarousel .carousel-item img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    display: block;

    /* lebih tajam */
    image-rendering: -webkit-optimize-contrast;
}


/* ========================================
   ARROW NAVIGATION
======================================== */

#headerCarousel .carousel-control-prev,
#headerCarousel .carousel-control-next {
    width: 6%;
}

#headerCarousel .carousel-control-prev-icon,
#headerCarousel .carousel-control-next-icon {
    filter: drop-shadow(0 2px 4px rgba(0,0,0,0.4));
}


/* ================================
   CAROUSEL INDICATORS CLEAN STYLE
================================ */

.carousel-indicators {
    bottom: 20px;
    margin-bottom: 0;
}

.carousel-indicators [data-bs-target] {
    width: 12px;
    height: 12px;
    border-radius: 50%;
    background-color: rgba(255, 255, 255, 0.6);
    border: none;
    margin: 0 6px;
    
    /* HAPUS SEMUA SHADOW */
    box-shadow: none !important;
    filter: none !important;
    
    opacity: 1;
    transition: all 0.3s ease;
}

.carousel-indicators .active {
    background-color: #f4c542; /* warna kuning aktif */
    transform: scale(1.2);
    
    /* Pastikan tidak ada shadow */
    box-shadow: none !important;
    filter: none !important;
}

/* Optional hover */
.carousel-indicators [data-bs-target]:hover {
    background-color: #f4c542;
}

/* ========================================
   MOBILE FIX
======================================== */

@media (max-width: 768px) {

    #headerCarousel .carousel-indicators {
        bottom: 10px;
        padding: 4px 10px;
    }

    #headerCarousel .carousel-indicators button {
        width: 10px;
        height: 10px;
    }

}

</style>