

<?php $__env->startSection('title', 'Status Permohonan'); ?>

<?php $__env->startSection('content'); ?>
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            
            <!-- Header dengan Status Badge -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body p-4 text-center" style="background: linear-gradient(135deg, #0e5b73 0%, #1a8aa6 100%);">
                    <div class="mb-3">
                        <?php if($permohonan->status === 'pending'): ?>
                            <i class="fas fa-clock fa-4x text-white mb-3"></i>
                        <?php elseif($permohonan->status === 'diproses'): ?>
                            <i class="fas fa-spinner fa-spin fa-4x text-white mb-3"></i>
                        <?php elseif($permohonan->status === 'disetujui'): ?>
                            <i class="fas fa-check-circle fa-4x text-white mb-3"></i>
                        <?php else: ?>
                            <i class="fas fa-times-circle fa-4x text-white mb-3"></i>
                        <?php endif; ?>
                    </div>
                    <h3 class="text-white fw-bold mb-2">Status Permohonan</h3>
                    <h2 class="text-white fw-bold mb-0">
                        <?php if($permohonan->status === 'pending'): ?>
                            PENDING
                        <?php elseif($permohonan->status === 'diproses'): ?>
                            SEDANG DIPROSES
                        <?php elseif($permohonan->status === 'disetujui'): ?>
                            DISETUJUI
                        <?php else: ?>
                            DITOLAK
                        <?php endif; ?>
                    </h2>
                </div>
            </div>

            <!-- Detail Permohonan -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header" style="background:#0e5b73;">
                    <h5 class="mb-0 text-white">
                        <i class="fas fa-info-circle"></i> Detail Permohonan
                    </h5>
                </div>
                <div class="card-body p-4">
                    <table class="table table-borderless">
                        <tr>
                            <th width="40%" class="text-muted">Nomor Registrasi</th>
                            <td class="fw-bold"><?php echo e($permohonan->nomor_registrasi); ?></td>
                        </tr>
                        <tr>
                            <th class="text-muted">Kategori Pemohon</th>
                            <td>
                                <?php if($permohonan->kategori_pemohon === 'perorangan'): ?>
                                    <span class="badge bg-primary">Perorangan</span>
                                <?php elseif($permohonan->kategori_pemohon === 'kelompok'): ?>
                                    <span class="badge bg-success">Kelompok Orang</span>
                                <?php else: ?>
                                    <span class="badge bg-warning text-dark">Badan Hukum</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <tr>
                            <th class="text-muted">Nama Pemohon</th>
                            <td class="fw-bold"><?php echo e($permohonan->nama); ?></td>
                        </tr>
                        <tr>
                            <th class="text-muted">Email</th>
                            <td><?php echo e($permohonan->email); ?></td>
                        </tr>
                        <tr>
                            <th class="text-muted">Tanggal Pengajuan</th>
                            <td>
                                <i class="far fa-calendar"></i>
                                <?php echo e($permohonan->created_at->format('d F Y, H:i')); ?> WIB
                            </td>
                        </tr>
                        <?php if($permohonan->tanggal_selesai): ?>
                        <tr>
                            <th class="text-muted">Tanggal Selesai</th>
                            <td>
                                <i class="far fa-calendar-check"></i>
                                <?php echo e($permohonan->tanggal_selesai->format('d F Y, H:i')); ?> WIB
                            </td>
                        </tr>
                        <?php endif; ?>
                    </table>
                </div>
            </div>

            <!-- Rincian Informasi -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header" style="background:#0e5b73;">
                    <h5 class="mb-0 text-white">
                        <i class="fas fa-file-alt"></i> Rincian Informasi
                    </h5>
                </div>
                <div class="card-body p-4">
                    <div class="mb-3">
                        <strong class="text-primary">Informasi yang Diminta:</strong>
                        <p class="mb-0 mt-2 text-muted"><?php echo e($permohonan->rincian_informasi); ?></p>
                    </div>
                    <hr>
                    <div>
                        <strong class="text-primary">Tujuan Penggunaan:</strong>
                        <p class="mb-0 mt-2 text-muted"><?php echo e($permohonan->tujuan_penggunaan); ?></p>
                    </div>
                </div>
            </div>

            <!-- Catatan Admin (Jika Ada) -->
            <?php if($permohonan->catatan_admin): ?>
            <div class="card border-0 shadow-sm mb-4 border-start border-warning border-5">
                <div class="card-body p-4">
                    <h5 class="fw-bold text-warning mb-3">
                        <i class="fas fa-comment-dots"></i> Catatan dari Admin
                    </h5>
                    <p class="mb-0"><?php echo e($permohonan->catatan_admin); ?></p>
                </div>
            </div>
            <?php endif; ?>

            <!-- Timeline Status -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header" style="background:#0e5b73;">
                    <h5 class="mb-0 text-white">
                        <i class="fas fa-stream"></i> Timeline Proses
                    </h5>
                </div>
                <div class="card-body p-4">
                    <div class="timeline">
                        <div class="timeline-item">
                            <i class="fas fa-check-circle text-success"></i>
                            <div class="ms-3">
                                <strong>Permohonan Diterima</strong>
                                <p class="text-muted small mb-0">
                                    <?php echo e($permohonan->created_at->format('d F Y, H:i')); ?> WIB
                                </p>
                            </div>
                        </div>

                        <?php if(in_array($permohonan->status, ['diproses', 'disetujui', 'ditolak'])): ?>
                        <div class="timeline-item">
                            <i class="fas fa-<?php echo e($permohonan->status === 'diproses' ? 'spinner fa-spin' : 'check-circle'); ?> text-info"></i>
                            <div class="ms-3">
                                <strong>Sedang Diproses</strong>
                                <p class="text-muted small mb-0">Permohonan sedang ditinjau oleh admin</p>
                            </div>
                        </div>
                        <?php endif; ?>

                        <?php if(in_array($permohonan->status, ['disetujui', 'ditolak'])): ?>
                        <div class="timeline-item">
                            <i class="fas fa-<?php echo e($permohonan->status === 'disetujui' ? 'check-circle text-success' : 'times-circle text-danger'); ?>"></i>
                            <div class="ms-3">
                                <strong><?php echo e($permohonan->status === 'disetujui' ? 'Disetujui' : 'Ditolak'); ?></strong>
                                <p class="text-muted small mb-0">
                                    <?php echo e($permohonan->tanggal_selesai ? $permohonan->tanggal_selesai->format('d F Y, H:i') : ''); ?> WIB
                                </p>
                            </div>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="text-center">
                <a href="<?php echo e(route('permohonan.cek-status')); ?>" class="btn btn-secondary btn-lg me-2">
                    <i class="fas fa-arrow-left"></i> Cek Lagi
                </a>
                <a href="<?php echo e(route('home')); ?>" class="btn btn-outline-secondary btn-lg">
                    <i class="fas fa-home"></i> Kembali ke Beranda
                </a>
            </div>
        </div>
    </div>
</div>

<style>
.timeline {
    position: relative;
    padding-left: 30px;
}

.timeline::before {
    content: '';
    position: absolute;
    left: 10px;
    top: 0;
    bottom: 0;
    width: 2px;
    background: #dee2e6;
}

.timeline-item {
    position: relative;
    display: flex;
    align-items: start;
    margin-bottom: 20px;
}

.timeline-item:last-child {
    margin-bottom: 0;
}

.timeline-item i {
    position: absolute;
    left: -26px;
    background: white;
    padding: 3px;
    font-size: 1.2rem;
}

.border-start {
    border-left-width: 5px !important;
}
</style>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\ppid-website\resources\views/frontend/permohonan/hasil-status.blade.php ENDPATH**/ ?>