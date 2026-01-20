<?php if($agendaKegiatan->count() > 0): ?>
<div class="agenda-section">
    <div class="container">
        <div class="agenda-title-section mb-5">
            <h3>
                Agenda<br>Kegiatan
                <small><?php echo e(now()->locale('id')->isoFormat('MMMM YYYY')); ?></small>
            </h3>
        </div>

        <div class="row g-4">
            <?php $__currentLoopData = $agendaKegiatan; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $agenda): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="col-md-4">
                <div class="agenda-card">
                    <div class="agenda-date"><?php echo e($agenda->tanggal->format('d')); ?> <?php echo e($agenda->tanggal->locale('id')->isoFormat('MMMM')); ?></div>
                    <div class="agenda-month"><?php echo e($agenda->tanggal->locale('id')->isoFormat('dddd')); ?></div>
                    
                    <h6 class="agenda-title"><?php echo e($agenda->judul); ?></h6>
                    
                    <?php if($agenda->lokasi): ?>
                    <div class="agenda-subtitle"><?php echo e($agenda->lokasi); ?></div>
                    <?php endif; ?>

                    <?php if($agenda->waktu_mulai): ?>
                    <div class="agenda-subtitle">
                        <?php echo e(date('H:i', strtotime($agenda->waktu_mulai))); ?>

                        <?php if($agenda->waktu_selesai): ?>
                            - <?php echo e(date('H:i', strtotime($agenda->waktu_selesai))); ?>

                        <?php endif; ?>
                    </div>
                    <?php endif; ?>

                    <span class="agenda-badge">
                        <?php if($agenda->status == 'upcoming'): ?>
                            Akan Berlangsung
                        <?php elseif($agenda->status == 'ongoing'): ?>
                            Sedang Berlangsung
                        <?php else: ?>
                            Selesai
                        <?php endif; ?>
                    </span>

                    <!-- Tombol Detail di kanan bawah -->
                    <div class="agenda-detail-btn">
                        <button class="btn btn-sm btn-detail" 
                                data-bs-toggle="modal" 
                                data-bs-target="#modalAgenda<?php echo e($agenda->id); ?>">
                            <i class="bi bi-info-circle me-1"></i> Detail
                        </button>
                    </div>
                </div>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>
</div>

<!-- SEMUA MODAL DI LUAR LOOP (PENTING!) -->
<?php $__currentLoopData = $agendaKegiatan; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $agenda): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
<div class="modal fade" id="modalAgenda<?php echo e($agenda->id); ?>" tabindex="-1" aria-labelledby="modalAgendaLabel<?php echo e($agenda->id); ?>" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header" style="background: linear-gradient(to right, #1a6b8a, #003344); color: white;">
                <h5 class="modal-title fw-bold" id="modalAgendaLabel<?php echo e($agenda->id); ?>">
                    <i class="bi bi-calendar-event me-2"></i>
                    <?php echo e($agenda->judul); ?>

                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <!-- Info Tanggal & Waktu -->
                <div class="row mb-3">
                    <div class="col-md-6">
                        <div class="d-flex align-items-center mb-2">
                            <i class="bi bi-calendar3 text-primary me-2 fs-5"></i>
                            <div>
                                <small class="text-muted d-block">Tanggal</small>
                                <strong><?php echo e($agenda->tanggal->locale('id')->isoFormat('dddd, D MMMM YYYY')); ?></strong>
                            </div>
                        </div>
                    </div>
                    
                    <?php if($agenda->waktu_mulai): ?>
                    <div class="col-md-6">
                        <div class="d-flex align-items-center mb-2">
                            <i class="bi bi-clock text-primary me-2 fs-5"></i>
                            <div>
                                <small class="text-muted d-block">Waktu</small>
                                <strong><?php echo e(date('H:i', strtotime($agenda->waktu_mulai))); ?> WIB</strong>
                                <?php if($agenda->waktu_selesai): ?>
                                    - <?php echo e(date('H:i', strtotime($agenda->waktu_selesai))); ?> WIB
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    <?php endif; ?>
                </div>
                
                <?php if($agenda->lokasi): ?>
                <div class="mb-3">
                    <div class="d-flex align-items-start">
                        <i class="bi bi-geo-alt-fill text-primary me-2 fs-5"></i>
                        <div>
                            <small class="text-muted d-block">Lokasi</small>
                            <strong><?php echo e($agenda->lokasi); ?></strong>
                        </div>
                    </div>
                </div>
                <?php endif; ?>
                
                <?php if($agenda->penyelenggara): ?>
                <div class="mb-3">
                    <div class="d-flex align-items-start">
                        <i class="bi bi-people-fill text-primary me-2 fs-5"></i>
                        <div>
                            <small class="text-muted d-block">Penyelenggara</small>
                            <strong><?php echo e($agenda->penyelenggara); ?></strong>
                        </div>
                    </div>
                </div>
                <?php endif; ?>
                
                <hr>
                
                <!-- Deskripsi -->
                <div>
                    <h6 class="fw-bold mb-3">
                        <i class="bi bi-card-text text-primary me-2"></i>
                        Deskripsi Kegiatan
                    </h6>
                    <?php if($agenda->deskripsi): ?>
                        <p class="text-justify" style="line-height: 1.8; white-space: pre-line;"><?php echo e($agenda->deskripsi); ?></p>
                    <?php else: ?>
                        <p class="text-muted fst-italic">Tidak ada deskripsi untuk agenda ini.</p>
                    <?php endif; ?>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">
                    <i class="bi bi-x-circle me-1"></i> Tutup
                </button>
            </div>
        </div>
    </div>
</div>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

<style>
/* Tombol Detail di kanan bawah card */
.agenda-detail-btn {
    position: absolute;
    bottom: 15px;
    right: 15px;
    z-index: 10;
}

.btn-detail {
    background-color: #1a6b8a;
    color: white;
    border: none;
    padding: 5px 15px;
    border-radius: 5px;
    font-size: 13px;
    font-weight: 600;
    transition: all 0.3s ease;
}

.btn-detail:hover {
    background-color: #003344;
    color: white;
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(0,0,0,0.2);
}

/* Button Tutup Merah dengan Hover Effect */
.btn-danger {
    background-color: #dc3545 !important;
    border-color: #dc3545 !important;
    font-weight: 600;
    transition: all 0.3s ease;
}

.btn-danger:hover {
    background-color: #c82333 !important;
    border-color: #bd2130 !important;
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(220, 53, 69, 0.3);
}

/* Pastikan card memiliki position relative */
.agenda-card {
    position: relative;
    padding-bottom: 60px;
}

/* Modal styling */
.modal-header {
    border-bottom: 3px solid #d5c58a;
}

.modal-body i {
    min-width: 30px;
}

/* Fix z-index untuk modal */
.modal-backdrop {
    z-index: 1040;
}

.modal {
    z-index: 1050;
}
</style>
<?php endif; ?><?php /**PATH C:\ppid-website\resources\views/components/agenda-section.blade.php ENDPATH**/ ?>