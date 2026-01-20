

<?php $__env->startSection('title', 'Informasi Publik - PPID'); ?>

<?php $__env->startSection('content'); ?>


<div class="py-5" style="
    background: linear-gradient(90deg, #0a3568 0%, #1f6fe5 100%);
    color: white;
">
    <div class="container py-3">
        <h1 class="fw-bold display-6">Daftar Informasi Publik (DIP)</h1>
        <p class="mt-2 fs-5">Daftar lengkap semua dokumen informasi publik yang tersedia</p>
    </div>
</div>

<div class="container my-5">

    
    <div class="d-flex flex-wrap gap-3 justify-content-center mb-5">
        
        
        <a href="<?php echo e(route('halaman-statis.show', 'informasi-berkala')); ?>" 
           class="btn-kategori-link">
            <i class="bi bi-calendar-check me-2"></i>
            Informasi Berkala
        </a>

        
        <a href="<?php echo e(route('halaman-statis.show', 'informasi-setiap-saat')); ?>" 
           class="btn-kategori-link">
            <i class="bi bi-clock-history me-2"></i>
            Informasi Setiap Saat
        </a>

        
        <a href="<?php echo e(route('halaman-statis.show', 'informasi-serta-merta')); ?>" 
           class="btn-kategori-link">
            <i class="bi bi-lightning-charge me-2"></i>
            Informasi Serta-Merta
        </a>

    </div>

    
    <div class="alert alert-info d-flex align-items-center" role="alert">
        <i class="bi bi-info-circle fs-4 me-3"></i>
        <div>
            <strong>Informasi:</strong> Silakan pilih kategori di atas untuk melihat daftar lengkap dokumen informasi publik sesuai kategorinya.
        </div>
    </div>

    
    <div class="row g-4 mt-3">
        
        
        <div class="col-md-4">
            <div class="card h-100 shadow-sm border-0 hover-card">
                <div class="card-body text-center p-4">
                    <div class="icon-wrapper mb-3">
                        <i class="bi bi-calendar-check text-primary" style="font-size: 3rem;"></i>
                    </div>
                    <h5 class="fw-bold mb-3">Informasi Berkala</h5>
                    <p class="text-muted small">
                        Informasi yang wajib disediakan dan diumumkan secara berkala 
                        sekurang-kurangnya setiap 6 (enam) bulan sekali.
                    </p>
                    <a href="<?php echo e(route('halaman-statis.show', 'informasi-berkala')); ?>" 
                       class="btn btn-outline-primary btn-sm mt-3">
                        Lihat Dokumen <i class="bi bi-arrow-right ms-1"></i>
                    </a>
                </div>
            </div>
        </div>

        
        <div class="col-md-4">
            <div class="card h-100 shadow-sm border-0 hover-card">
                <div class="card-body text-center p-4">
                    <div class="icon-wrapper mb-3">
                        <i class="bi bi-clock-history text-success" style="font-size: 3rem;"></i>
                    </div>
                    <h5 class="fw-bold mb-3">Informasi Setiap Saat</h5>
                    <p class="text-muted small">
                        Informasi yang wajib tersedia setiap saat dan dapat diakses 
                        oleh publik kapan saja dibutuhkan.
                    </p>
                    <a href="<?php echo e(route('halaman-statis.show', 'informasi-setiap-saat')); ?>" 
                       class="btn btn-outline-success btn-sm mt-3">
                        Lihat Dokumen <i class="bi bi-arrow-right ms-1"></i>
                    </a>
                </div>
            </div>
        </div>

        
        <div class="col-md-4">
            <div class="card h-100 shadow-sm border-0 hover-card">
                <div class="card-body text-center p-4">
                    <div class="icon-wrapper mb-3">
                        <i class="bi bi-lightning-charge text-warning" style="font-size: 3rem;"></i>
                    </div>
                    <h5 class="fw-bold mb-3">Informasi Serta-Merta</h5>
                    <p class="text-muted small">
                        Informasi yang harus diumumkan segera kepada masyarakat 
                        tanpa penundaan jika dapat mengancam hajat hidup orang banyak.
                    </p>
                    <a href="<?php echo e(route('halaman-statis.show', 'informasi-serta-merta')); ?>" 
                       class="btn btn-outline-warning btn-sm mt-3">
                        Lihat Dokumen <i class="bi bi-arrow-right ms-1"></i>
                    </a>
                </div>
            </div>
        </div>

    </div>

    
    <div class="card mt-5 border-0 shadow-sm" style="background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);">
        <div class="card-body p-4">
            <div class="row align-items-center">
                <div class="col-md-2 text-center">
                    <i class="bi bi-question-circle text-primary" style="font-size: 4rem;"></i>
                </div>
                <div class="col-md-10">
                    <h5 class="fw-bold mb-3">Butuh Bantuan?</h5>
                    <p class="mb-3">
                        Jika Anda memiliki pertanyaan atau membutuhkan informasi lebih lanjut 
                        mengenai Informasi Publik, silakan hubungi kami melalui:
</p>
<div class="d-flex flex-wrap gap-3">
    <a href="https://api.whatsapp.com/send/?phone=6285975062727&text&type=phone_number&app_absent=0" 
       target="_blank" 
       class="btn btn-primary">
        <i class="bi bi-envelope me-2"></i>Hubungi Kami
    </a>

    <a href="<?php echo e(route('faq.index')); ?>" class="btn btn-outline-primary">
        <i class="bi bi-question-circle me-2"></i>FAQ
    </a>

    <a href="<?php echo e(route('permohonan.index')); ?>" class="btn btn-outline-success">
        <i class="bi bi-file-earmark-text me-2"></i>Ajukan Permohonan
    </a>
</div>

                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

<style>
/* Button Kategori Link */
.btn-kategori-link {
    display: inline-block;
    padding: 15px 30px;
    background: linear-gradient(135deg, #005f69 0%, #003344 100%);
    color: white;
    text-decoration: none;
    border-radius: 12px;
    font-weight: 600;
    font-size: 1.1rem;
    transition: all 0.3s ease;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    border: 2px solid transparent;
}

.btn-kategori-link:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 15px rgba(0, 95, 105, 0.3);
    background: linear-gradient(135deg, #007a88 0%, #004455 100%);
    color: white;
    border-color: #d5c58a;
}

.btn-kategori-link:active {
    transform: translateY(-1px);
}

/* Hover Card Effect */
.hover-card {
    transition: all 0.3s ease;
}

.hover-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15) !important;
}

/* Icon Wrapper */
.icon-wrapper {
    animation: pulse 2s infinite;
}

@keyframes pulse {
    0%, 100% {
        transform: scale(1);
    }
    50% {
        transform: scale(1.05);
    }
}

/* Responsive */
@media (max-width: 768px) {
    .btn-kategori-link {
        width: 100%;
        text-align: center;
        font-size: 1rem;
        padding: 12px 20px;
    }
}
</style>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\ppid-website\resources\views/frontend/informasi-publik/index.blade.php ENDPATH**/ ?>