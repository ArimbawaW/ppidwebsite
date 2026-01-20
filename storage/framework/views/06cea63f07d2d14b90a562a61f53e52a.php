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
            <div class="col-md-4 agenda-col">
                <div class="agenda-card">
                    
                    <div>
                        <div class="agenda-date">
                            <?php echo e($agenda->tanggal->format('d')); ?> <?php echo e($agenda->tanggal->locale('id')->isoFormat('MMMM')); ?>

                        </div>
                        <div class="agenda-month">
                            <?php echo e($agenda->tanggal->locale('id')->isoFormat('dddd')); ?>

                        </div>

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
                    </div>

                    <!-- Tombol Detail -->
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

<!-- MODAL -->
<?php $__currentLoopData = $agendaKegiatan; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $agenda): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
<div class="modal fade" id="modalAgenda<?php echo e($agenda->id); ?>" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header" style="background: linear-gradient(to right, #1a6b8a, #003344); color: white;">
                <h5 class="modal-title fw-bold">
                    <i class="bi bi-calendar-event me-2"></i>
                    <?php echo e($agenda->judul); ?>

                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body p-4">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <small class="text-muted">Tanggal</small>
                        <strong class="d-block">
                            <?php echo e($agenda->tanggal->locale('id')->isoFormat('dddd, D MMMM YYYY')); ?>

                        </strong>
                    </div>

                    <?php if($agenda->waktu_mulai): ?>
                    <div class="col-md-6">
                        <small class="text-muted">Waktu</small>
                        <strong class="d-block">
                            <?php echo e(date('H:i', strtotime($agenda->waktu_mulai))); ?>

                            <?php if($agenda->waktu_selesai): ?>
                                - <?php echo e(date('H:i', strtotime($agenda->waktu_selesai))); ?>

                            <?php endif; ?>
                            WIB
                        </strong>
                    </div>
                    <?php endif; ?>
                </div>

                <?php if($agenda->lokasi): ?>
                <p><strong>Lokasi:</strong> <?php echo e($agenda->lokasi); ?></p>
                <?php endif; ?>

                <hr>

                <h6 class="fw-bold mb-2">Deskripsi Kegiatan</h6>
                <?php if($agenda->deskripsi): ?>
                    <p class="text-justify" style="line-height:1.8; white-space: pre-line;">
                        <?php echo e($agenda->deskripsi); ?>

                    </p>
                <?php else: ?>
                    <p class="text-muted fst-italic">Tidak ada deskripsi.</p>
                <?php endif; ?>
            </div>

            <div class="modal-footer">
                <button class="btn btn-danger" data-bs-dismiss="modal">
                    Tutup
                </button>
            </div>
        </div>
    </div>
</div>

<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

<style>
.agenda-col {
    display: flex;
}

.agenda-card {
    position: relative;
    height: 100%;
    min-height: 270px;
    width: 100%;
    max-width: 100%;
    display: flex;
    flex-direction: column;
    padding: 20px 20px 70px;
    overflow: hidden;
}

/* FIX TEKS PANJANG */
.agenda-title,
.agenda-subtitle {
    word-break: break-word;
    overflow-wrap: break-word;
    white-space: normal;
}

/* Batasi judul */
.agenda-title {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

/* Tombol */
.agenda-detail-btn {
    position: absolute;
    bottom: 15px;
    right: 15px;
}

</style>
<?php endif; ?><?php /**PATH C:\ppid-website\ppidwebsite\resources\views/components/agenda-section.blade.php ENDPATH**/ ?>