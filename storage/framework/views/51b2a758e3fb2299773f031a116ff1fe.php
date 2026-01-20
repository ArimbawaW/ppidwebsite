


<?php $__env->startSection('title', 'Hasil Cek Keberatan'); ?>

<?php $__env->startSection('content'); ?>
<div class="container my-5">
    <h2 class="mb-4">Hasil Cek Keberatan</h2>

    <div class="card">
        <div class="card-body">
            <div class="row mb-3">
                <div class="col-md-6">
                    <p><strong>Nomor Registrasi Keberatan:</strong></p>
                    <p class="text-muted"><?php echo e($keberatan->nomor_registrasi); ?></p>
                </div>
                
                <?php if($keberatan->nomor_registrasi_permohonan): ?>
                <div class="col-md-6">
                    <p><strong>Nomor Registrasi Permohonan:</strong></p>
                    <p class="text-muted"><?php echo e($keberatan->nomor_registrasi_permohonan); ?></p>
                </div>
                <?php endif; ?>
            </div>

            <hr>

            <div class="row mb-3">
                <div class="col-md-6">
                    <p><strong>Nama Pemohon:</strong></p>
                    <p class="text-muted"><?php echo e($keberatan->nama_pemohon); ?></p>
                </div>
                <div class="col-md-6">
                    <p><strong>Tanggal Pengajuan:</strong></p>
                    <p class="text-muted"><?php echo e($keberatan->created_at->format('d M Y H:i')); ?> WIB</p>
                </div>
            </div>

            <div class="mb-3">
                <p><strong>Alasan Keberatan:</strong></p>
                <div class="p-3 bg-light rounded">
                    <p class="mb-0" style="white-space: pre-line;"><?php echo e($keberatan->alasan_keberatan); ?></p>
                </div>
            </div>

            <div class="mb-3">
                <p><strong>Status:</strong></p>
                <p>
                    <?php if($keberatan->status == 'pending'): ?>
                        <span class="badge bg-warning text-dark fs-6 px-3 py-2">Pending</span>
                    <?php elseif($keberatan->status == 'diproses'): ?>
                        <span class="badge bg-info fs-6 px-3 py-2">Diproses</span>
                    <?php elseif($keberatan->status == 'selesai'): ?>
                        <span class="badge bg-success fs-6 px-3 py-2">Selesai</span>
                    <?php else: ?>
                        <span class="badge bg-danger fs-6 px-3 py-2">Ditolak</span>
                    <?php endif; ?>
                </p>
            </div>

            <?php if($keberatan->keterangan): ?>
            <div class="mb-3">
                <p><strong>Keterangan dari Admin:</strong></p>
                <div class="alert alert-info">
                    <p class="mb-0" style="white-space: pre-line;"><?php echo e($keberatan->keterangan); ?></p>
                </div>
            </div>
            <?php endif; ?>

            <hr>

            <div class="d-flex gap-2">
                <a href="<?php echo e(route('keberatan.cek')); ?>" class="btn btn-secondary">
                    <i class="bi bi-arrow-left"></i> Cek Lagi
                </a>
                <a href="<?php echo e(route('home')); ?>" class="btn btn-primary">
                    <i class="bi bi-house"></i> Kembali ke Beranda
                </a>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\ppid-website\resources\views/frontend/keberatan/hasil.blade.php ENDPATH**/ ?>