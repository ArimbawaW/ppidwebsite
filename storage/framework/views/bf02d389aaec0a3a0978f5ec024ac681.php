<?php
    // Ambil banner aktif dari database
    $banners = \App\Models\BannerSlider::getActiveBanners();
?>

<!-- Gold Divider -->
<div class="gold-divider"></div>

<!-- Hero Slider -->
<?php if($banners->count() > 0): ?>
<div id="headerCarousel" class="carousel slide" data-bs-ride="carousel" data-bs-pause="hover">

    <!-- Carousel Items -->
    <div class="carousel-inner">
        <?php $__currentLoopData = $banners; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $banner): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="carousel-item <?php echo e($index === 0 ? 'active' : ''); ?>" data-bs-interval="5000">
                <img src="<?php echo e(asset($banner->gambar)); ?>"
                     class="d-block w-100"
                     alt="<?php echo e($banner->judul ?: 'Banner ' . ($index + 1)); ?>"
                     loading="<?php echo e($index === 0 ? 'eager' : 'lazy'); ?>">
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>

    <?php if($banners->count() > 1): ?>
        <!-- Navigation Arrows -->
        <button class="carousel-control-prev" 
                type="button"
                data-bs-target="#headerCarousel"
                data-bs-slide="prev"
                aria-label="Previous Slide">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>

        <button class="carousel-control-next"
                type="button"
                data-bs-target="#headerCarousel"
                data-bs-slide="next"
                aria-label="Next Slide">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>

        <!-- Indicators -->
        <div class="carousel-indicators">
            <?php $__currentLoopData = $banners; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $banner): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <button type="button" 
                        data-bs-target="#headerCarousel" 
                        data-bs-slide-to="<?php echo e($index); ?>" 
                        class="<?php echo e($index === 0 ? 'active' : ''); ?>"
                        aria-current="<?php echo e($index === 0 ? 'true' : 'false'); ?>"
                        aria-label="Slide <?php echo e($index + 1); ?>">
                </button>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    <?php endif; ?>

</div>
<?php else: ?>
<!-- Fallback -->
<div id="headerCarousel" class="carousel slide" data-bs-ride="carousel" data-bs-pause="hover">
    <div class="carousel-inner">
        <div class="carousel-item active" data-bs-interval="5000">
            <img src="<?php echo e(asset('images/header1.png')); ?>"
                 class="d-block w-100"
                 alt="Banner PPID 1"
                 loading="eager">
        </div>

        <?php if(file_exists(public_path('images/header2.png'))): ?>
        <div class="carousel-item" data-bs-interval="5000">
            <img src="<?php echo e(asset('images/header2.png')); ?>"
                 class="d-block w-100"
                 alt="Banner PPID 2"
                 loading="lazy">
        </div>
        <?php endif; ?>
    </div>

    <?php if(file_exists(public_path('images/header2.png'))): ?>
    <button class="carousel-control-prev"
            type="button"
            data-bs-target="#headerCarousel"
            data-bs-slide="prev"
            aria-label="Previous">
        <span class="carousel-control-prev-icon"></span>
    </button>

    <button class="carousel-control-next"
            type="button"
            data-bs-target="#headerCarousel"
            data-bs-slide="next"
            aria-label="Next">
        <span class="carousel-control-next-icon"></span>
    </button>
    <?php endif; ?>
</div>
<?php endif; ?>

<style>
/* ===============================
   HERO SLIDER
   =============================== */

#headerCarousel {
    width: 100%;
    overflow: hidden;
}

#headerCarousel .carousel-item img {
    width: 100%;
    height: auto;
    object-fit: cover;
    display: block;
}

/* Responsive height */
@media (min-width: 1440px) {
    #headerCarousel .carousel-item img { max-height: 410px; }
}
@media (min-width: 992px) and (max-width: 1439px) {
    #headerCarousel .carousel-item img { max-height: 350px; }
}
@media (min-width: 768px) and (max-width: 991px) {
    #headerCarousel .carousel-item img { max-height: 280px; }
}
@media (max-width: 767px) {
    #headerCarousel .carousel-item img { max-height: 200px; }
}

/* ===============================
   NAVIGATION (NO BACKGROUND)
   =============================== */

.carousel-control-prev,
.carousel-control-next {
    width: 56px;
    height: 56px;
    min-width: 56px;
    min-height: 56px;
    top: 50%;
    transform: translateY(-50%);
    background: transparent !important;   /* 🔥 no background */
    border-radius: 50%;
    opacity: 0;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    justify-content: center;
}

/* panah saja */
.carousel-control-prev-icon,
.carousel-control-next-icon {
    width: 22px;
    height: 22px;
    background-size: 100% 100%;
    filter: drop-shadow(0 0 3px rgba(0,0,0,0.6)); /* biar kontras */
}

/* show on hover */
#headerCarousel:hover .carousel-control-prev,
#headerCarousel:hover .carousel-control-next {
    opacity: 1;
}

/* posisi */
.carousel-control-prev { left: 20px; }
.carousel-control-next { right: 20px; }

/* ===============================
   INDICATORS
   =============================== */
.carousel-indicators button {
    width: 12px;
    height: 12px;
    border-radius: 50%;
    background-color: rgba(255, 255, 255, 0.5);
    border: 2px solid rgba(255, 255, 255, 0.8);
}

.carousel-indicators button.active {
    background-color: #ffffff;
    transform: scale(1.2);
}

/* ===============================
   GOLD DIVIDER
   =============================== */
.gold-divider {
    width: 100%;
    height: 4px;
    background: linear-gradient(90deg, #d5c58a 0%, #f4e4a6 50%, #d5c58a 100%);
}

/* ===============================
   MOBILE
   =============================== */
@media (max-width: 576px) {
    .carousel-control-prev,
    .carousel-control-next {
        width: 42px;
        height: 42px;
        min-width: 42px;
        min-height: 42px;
    }

    .carousel-control-prev-icon,
    .carousel-control-next-icon {
        width: 16px;
        height: 16px;
    }

    .carousel-control-prev { left: 10px; }
    .carousel-control-next { right: 10px; }
}
</style>
<?php /**PATH C:\ppid\resources\views/components/hero-slider.blade.php ENDPATH**/ ?>