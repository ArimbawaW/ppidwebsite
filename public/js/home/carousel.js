/**
 * Header Carousel Auto Slider
 */
(function() {
    'use strict';
    
    function initHeaderCarousel() {
        var myCarousel = document.getElementById('headerCarousel');
        
        if (!myCarousel) {
            console.warn('Header carousel tidak ditemukan');
            return;
        }
        
        if (typeof bootstrap === 'undefined') {
            console.error('Bootstrap tidak tersedia');
            return;
        }
        
        var carousel = new bootstrap.Carousel(myCarousel, {
            interval: 3000,
            ride: 'carousel',
            pause: false,
            wrap: true,
            touch: true
        });
        
        console.log('✓ Header carousel initialized');
    }
    
    // Init saat DOM ready
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initHeaderCarousel);
    } else {
        initHeaderCarousel();
    }
})();