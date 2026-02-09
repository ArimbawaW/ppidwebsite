<?php if($agendaKegiatan->count() > 0): ?>
<div class="agenda-section py-5">
    <div class="container">

        <!-- WRAPPER AGAR TIDAK MEPET POJOK -->
        <div class="agenda-title-wrapper mb-5">
            <div class="agenda-title-section d-flex justify-content-between align-items-end">

                <!-- TITLE -->
                <h3 class="mb-0 fw-bold agenda-title-main">
                    Agenda<br>Kegiatan
                    <small class="d-block text-muted fw-normal">
                        <?php echo e(now()->locale('id')->isoFormat('MMMM YYYY')); ?>

                    </small>
                </h3>

                <!-- BUTTON LIHAT SEMUA -->
                <a href="<?php echo e(route('frontend.agenda-kegiatan.index')); ?>"
                   class="btn-agenda-all">
                    <span>Lihat Semua Agenda</span>
                    <i class="bi bi-arrow-right-circle"></i>
                </a>

            </div>
        </div>

        <!-- LIST AGENDA -->
        <div class="row g-4 agenda-list-wrapper">
            <?php $__currentLoopData = $agendaKegiatan; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $agenda): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="col-md-4 agenda-col">
                <div class="agenda-card">

                    <div class="agenda-content">
                        <div class="agenda-date">
                            <?php echo e($agenda->tanggal->format('d')); ?>

                            <?php echo e($agenda->tanggal->locale('id')->isoFormat('MMMM')); ?>

                        </div>

                        <div class="agenda-month">
                            <?php echo e($agenda->tanggal->locale('id')->isoFormat('dddd')); ?>

                        </div>

                        <h6 class="agenda-title">
                            <?php echo e($agenda->judul); ?>

                        </h6>

                        <?php if($agenda->lokasi): ?>
                        <div class="agenda-subtitle text-muted">
                            <i class="bi bi-geo-alt me-1"></i>
                            <?php echo e($agenda->lokasi); ?>

                        </div>
                        <?php endif; ?>

                        <?php if($agenda->waktu_mulai): ?>
                        <div class="agenda-subtitle text-muted">
                            <i class="bi bi-clock me-1"></i>
                            <?php echo e(date('H:i', strtotime($agenda->waktu_mulai))); ?>

                            <?php if($agenda->waktu_selesai): ?>
                                - <?php echo e(date('H:i', strtotime($agenda->waktu_selesai))); ?>

                            <?php endif; ?>
                        </div>
                        <?php endif; ?>

                        
                        <span class="agenda-badge mt-2 d-inline-block">
                            <?php echo e($agenda->status_badge); ?>

                        </span>
                    </div>

                    <!-- BUTTON DETAIL - FIXED SIZE -->
                    <div class="agenda-detail-btn">
                        <button class="btn btn-sm btn-detail"
                                style="font-size: 0.875rem;"
                                data-bs-toggle="modal"
                                data-bs-target="#modalAgenda<?php echo e($agenda->id); ?>">
                            <i class="bi bi-info-circle me-1" style="font-size: 1rem;"></i> Detail
                        </button>
                    </div>

                </div>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>

    </div>
</div>

<!-- MODAL DETAIL -->
<?php $__currentLoopData = $agendaKegiatan; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $agenda): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
<div class="modal fade" id="modalAgenda<?php echo e($agenda->id); ?>" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-header modal-agenda-header">
                <h5 class="modal-title fw-bold">
                    <i class="bi bi-calendar-event me-2"></i>
                    <?php echo e($agenda->judul); ?>

                </h5>
                <button type="button"
                        class="btn-close btn-close-white"
                        data-bs-dismiss="modal"></button>
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
                    <p style="line-height:1.8; white-space:pre-line;">
                        <?php echo e($agenda->deskripsi); ?>

                    </p>
                <?php else: ?>
                    <p class="text-muted fst-italic">Tidak ada deskripsi.</p>
                <?php endif; ?>

                
                <div class="mt-3">
                    <span class="badge <?php echo e($agenda->status_badge_class); ?>">
                        <?php echo e($agenda->status_badge); ?>

                    </span>
                </div>
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
/* ===================== TITLE FIX ===================== */
.agenda-title-wrapper {
    padding: 0 12px;
}

.agenda-title-section {
    max-width: 1100px;
    margin: 0 auto;
}

.agenda-title-main {
    color: #1a6b8a;
    line-height: 1.2;
}

.agenda-title-main small {
    font-size: 0.6em;
}

/* ===================== BUTTON ===================== */
.btn-agenda-all {
    display: inline-flex;
    align-items: center;
    gap: 8px;

    padding: 10px 22px;
    border-radius: 999px;

    font-size: 14px;
    font-weight: 600;
    text-decoration: none;

    color: #1a6b8a;
    background: #ffffff;

    border: 1.5px solid #1a6b8a;
    box-shadow: 0 6px 18px rgba(26,107,138,0.15);

    transition: all 0.25s ease;
}

.btn-agenda-all i {
    font-size: 16px;
    transition: transform 0.25s ease;
}

.btn-agenda-all:hover {
    background: linear-gradient(to right, #1a6b8a, #003344);
    color: #ffffff;
    box-shadow: 0 10px 30px rgba(0,0,0,0.2);
}

.btn-agenda-all:hover i {
    transform: translateX(4px);
}

/* ===================== CARD ===================== */
.agenda-col {
    display: flex;
}

.agenda-card {
    position: relative;
    width: 100%;
    min-height: 270px;
    padding: 20px 20px 70px;

    background: #ffffff;
    border: 1px solid #eee;
    border-radius: 14px;

    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.agenda-card:hover {
    transform: translateY(-6px);
    box-shadow: 0 12px 28px rgba(0,0,0,0.08);
}

/* ===================== TEXT FIX ===================== */
.agenda-title {
    margin-top: 10px;
    font-weight: 700;

    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

.agenda-subtitle {
    font-size: 14px;
    word-break: break-word;
}

/* ===================== DETAIL BUTTON FIX ===================== */
.agenda-detail-btn {
    position: absolute;
    bottom: 15px;
    right: 15px;
}

.btn-detail {
    font-size: 0.875rem !important;
    padding: 0.375rem 0.75rem;
}

.btn-detail i {
    font-size: 1rem !important;
    vertical-align: middle;
}

/* ===================== MODAL ===================== */
.modal-agenda-header {
    background: linear-gradient(to right, #1a6b8a, #003344);
    color: #ffffff;
}

/* ===================== RESPONSIVE ===================== */
@media (max-width: 576px) {

    /* BUANG LIMIT LEBAR DI MOBILE */
    .agenda-title-section {
        max-width: 100%;
        margin: 0;
        padding: 0 12px;

        flex-direction: column;
        align-items: center;
        text-align: center;
        gap: 14px;
    }

    .agenda-title-main {
        width: 100%;
        text-align: center;
    }

    .agenda-title-main small {
        text-align: center;
        display: block;
    }

    .btn-agenda-all {
        align-self: center;
    }
}
</style>
<?php endif; ?><?php /**PATH C:\ppid\resources\views/components/agenda-section.blade.php ENDPATH**/ ?>