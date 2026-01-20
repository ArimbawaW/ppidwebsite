

<?php $__env->startSection('title', 'FAQ - PPID'); ?>

<?php $__env->startSection('content'); ?>

<!-- Hero Section -->
<section class="py-5" style="background: linear-gradient(135deg, #1a6b8a 0%, #003344 100%);">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-8">
                <h1 class="text-white fw-bold mb-3">Frequently Asked Questions</h1>
                <p class="text-white-50 mb-0 fs-5">
                    Pertanyaan yang sering diajukan seputar layanan PPID
                </p>
            </div>
            <div class="col-md-4 text-end">
                <i class="bi bi-question-circle text-white" style="font-size: 120px; opacity: 0.2;"></i>
            </div>
        </div>
    </div>
</section>

<!-- Search Section -->
<section class="py-4 bg-light">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 mx-auto">
                <div class="input-group input-group-lg">
                    <span class="input-group-text bg-white">
                        <i class="bi bi-search"></i>
                    </span>
                    <input type="text" 
                           class="form-control" 
                           id="searchFaq" 
                           placeholder="Cari pertanyaan...">
                </div>
            </div>
        </div>
    </div>
</section>

<!-- FAQ Content -->
<section class="py-5">
    <div class="container">
        
        <?php if($faqs->count() > 0): ?>
            <?php $__currentLoopData = $faqs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $kategori => $items): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="mb-5">
                <!-- Kategori Header -->
                <div class="mb-4">
                    <h3 class="fw-bold" style="color: #1a6b8a;">
                        <i class="bi bi-bookmark-fill me-2"></i>
                        <?php echo e($kategori ?? 'Umum'); ?>

                    </h3>
                    <hr class="mt-2" style="border-width: 2px; width: 100px; opacity: 1; color: #1a6b8a;">
                </div>

                <!-- Accordion FAQ -->
                <div class="accordion" id="accordion<?php echo e(Str::slug($kategori)); ?>">
                    <?php $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $faq): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="accordion-item border-0 shadow-sm mb-3">
                        <h2 class="accordion-header" id="heading<?php echo e($faq->id); ?>">
                            <button class="accordion-button <?php echo e($index == 0 ? '' : 'collapsed'); ?> fw-bold" 
                                    type="button" 
                                    data-bs-toggle="collapse" 
                                    data-bs-target="#collapse<?php echo e($faq->id); ?>" 
                                    aria-expanded="<?php echo e($index == 0 ? 'true' : 'false'); ?>" 
                                    aria-controls="collapse<?php echo e($faq->id); ?>"
                                    style="background-color: <?php echo e($index == 0 ? '#f0f8ff' : 'white'); ?>;">
                                <i class="bi bi-question-circle-fill me-3" style="color: #1a6b8a;"></i>
                                <?php echo e($faq->pertanyaan); ?>

                            </button>
                        </h2>
                        <div id="collapse<?php echo e($faq->id); ?>" 
                             class="accordion-collapse collapse <?php echo e($index == 0 ? 'show' : ''); ?>" 
                             aria-labelledby="heading<?php echo e($faq->id); ?>" 
                             data-bs-parent="#accordion<?php echo e(Str::slug($kategori)); ?>">
                            <div class="accordion-body bg-light">
                                <div class="d-flex align-items-start">
                                    <i class="bi bi-chat-left-text-fill me-3 text-success fs-4"></i>
                                    <div>
                                        <?php echo nl2br(e($faq->jawaban)); ?>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        <?php else: ?>
            <div class="alert alert-info text-center">
                <i class="bi bi-info-circle me-2"></i>
                Belum ada FAQ yang tersedia.
            </div>
        <?php endif; ?>

        <!-- CTA Section -->
        <div class="row mt-5">
            <div class="col-lg-10 mx-auto">
                <div class="card shadow-sm border-0 text-white" 
                     style="background: linear-gradient(135deg, #1a6b8a 0%, #003344 100%);">
                    <div class="card-body text-center p-5">
                        <i class="bi bi-envelope-open fs-1 mb-3"></i>
                        <h3 class="fw-bold mb-3">Tidak Menemukan Jawaban?</h3>
                        <p class="mb-4">
                            Silakan hubungi kami melalui form kontak atau kirim email ke ppid@pkp.go.id
                        </p>
                        <a href="<?php echo e(route('kontak.index')); ?>" class="btn btn-light btn-lg px-5">
                            <i class="bi bi-envelope me-2"></i>Hubungi Kami
                        </a>
                    </div>
                </div>
            </div>
        </div>

    </div>
</section>

<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Search functionality
    const searchInput = document.getElementById('searchFaq');
    
    if(searchInput) {
        searchInput.addEventListener('input', function(e) {
            const searchTerm = e.target.value.toLowerCase();
            const accordionItems = document.querySelectorAll('.accordion-item');
            
            accordionItems.forEach(function(item) {
                const question = item.querySelector('.accordion-button').textContent.toLowerCase();
                const answer = item.querySelector('.accordion-body').textContent.toLowerCase();
                
                if(question.includes(searchTerm) || answer.includes(searchTerm)) {
                    item.style.display = 'block';
                } else {
                    item.style.display = 'none';
                }
            });
        });
    }
});
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\ppid-website\resources\views/frontend/faq/index.blade.php ENDPATH**/ ?>