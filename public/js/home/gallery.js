/**
 * Galeri Kegiatan Auto Slider
 */
(function() {
    'use strict';
    
    let autoScrollTimer = null;
    let galeriSlider = null;
    let currentIndex = 0;
    let totalItems = 0;
    let isPaused = false;
    
    function initGaleriSlider() {
        galeriSlider = document.getElementById('galeriSlider');
        
        if (!galeriSlider) {
            console.warn('Galeri slider tidak ditemukan');
            return;
        }
        
        totalItems = galeriSlider.children.length;
        
        if (totalItems === 0) {
            console.warn('Galeri slider tidak memiliki item');
            return;
        }
        
        console.log('✓ Galeri slider initialized with', totalItems, 'items');
        
        startAutoScroll();
        
        // Event listeners
        galeriSlider.addEventListener('mouseenter', handleMouseEnter);
        galeriSlider.addEventListener('mouseleave', handleMouseLeave);
    }
    
    function handleMouseEnter() {
        isPaused = true;
        pauseAutoScroll();
    }
    
    function handleMouseLeave() {
        isPaused = false;
        startAutoScroll();
    }
    
    function scrollToIndex(index) {
        if (!galeriSlider) return;
        
        const itemWidth = 320; // width (300) + gap (20)
        const targetPosition = index * itemWidth;
        
        // Menggunakan CSS transition untuk smooth scroll
        galeriSlider.style.scrollBehavior = 'smooth';
        galeriSlider.scrollLeft = targetPosition;
        
        // Reset scroll behavior setelah animasi
        setTimeout(() => {
            if (galeriSlider) {
                galeriSlider.style.scrollBehavior = 'auto';
            }
        }, 700);
    }
    
    function startAutoScroll() {
        if (autoScrollTimer) {
            clearInterval(autoScrollTimer);
        }
        
        autoScrollTimer = setInterval(function() {
            if (isPaused || !galeriSlider) return;
            
            currentIndex++;
            
            // Jika sudah di akhir, kembali ke awal
            if (currentIndex >= totalItems) {
                currentIndex = 0;
                
                // Reset ke awal dengan smooth animation
                setTimeout(() => {
                    scrollToIndex(0);
                }, 100);
            } else {
                scrollToIndex(currentIndex);
            }
        }, 3000); // 3 detik per slide
    }
    
    function pauseAutoScroll() {
        if (autoScrollTimer) {
            clearInterval(autoScrollTimer);
            autoScrollTimer = null;
        }
    }
    
    /**
     * Fungsi untuk button manual scroll
     * Dipanggil dari onclick button di HTML
     */
    window.scrollGaleri = function(direction) {
        if (!galeriSlider) return;
        
        pauseAutoScroll();
        
        if (direction > 0) {
            currentIndex = Math.min(currentIndex + 1, totalItems - 1);
        } else {
            currentIndex = Math.max(currentIndex - 1, 0);
        }
        
        scrollToIndex(currentIndex);
        
        // Resume auto scroll setelah 3 detik jika tidak hover
        setTimeout(function() {
            if (!isPaused) {
                startAutoScroll();
            }
        }, 3000);
    };
    
    // Init saat DOM ready
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', function() {
            setTimeout(initGaleriSlider, 300);
        });
    } else {
        setTimeout(initGaleriSlider, 300);
    }
    
    // Cleanup saat window unload
    window.addEventListener('beforeunload', function() {
        pauseAutoScroll();
    });
})();