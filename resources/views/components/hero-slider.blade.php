<div class="gold-divider"></div>

<div id="headerCarousel" class="carousel slide" data-bs-ride="carousel" data-bs-pause="hover">

    <div class="carousel-inner">
        <div class="carousel-item active" data-bs-interval="3000">
            <img src="{{ asset('images/header1.png') }}"
                 class="d-block w-100"
                 alt="Header 1">
        </div>

        <div class="carousel-item" data-bs-interval="3000">
            <img src="{{ asset('images/header2.png') }}"
                 class="d-block w-100"
                 alt="Header 2">
        </div>
    </div>

    <!-- Arrow Kiri -->
    <button class="carousel-control-prev custom-arrow"
            type="button"
            data-bs-target="#headerCarousel"
            data-bs-slide="prev"
            aria-label="Previous">
        <span class="carousel-control-prev-icon"></span>
    </button>

    <!-- Arrow Kanan -->
    <button class="carousel-control-next custom-arrow"
            type="button"
            data-bs-target="#headerCarousel"
            data-bs-slide="next"
            aria-label="Next">
        <span class="carousel-control-next-icon"></span>
    </button>

</div>
