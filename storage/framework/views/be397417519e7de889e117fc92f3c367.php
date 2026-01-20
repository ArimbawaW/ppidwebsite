

<?php $__env->startSection('title', 'Manajemen FAQ'); ?>

<?php $__env->startSection('styles'); ?>
<style>
    button, a.btn, .btn {
        display: inline-block !important;
        opacity: 1 !important;
        visibility: visible !important;
    }

    .table td:nth-child(2),
    .table td:nth-child(4),
    .table td:nth-child(5) {
        text-align: center !important;
        vertical-align: middle !important;
    }
</style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

<!-- PAGE HEADER -->
<div class="page-header">
    <div>
        <h2>Manajemen FAQ</h2>
        <p>Pertanyaan yang sering diajukan oleh pengguna</p>
    </div>
    <div>
        <a href="<?php echo e(route('admin.faq.create')); ?>" class="btn btn-primary">
            <i class="bi bi-plus-circle me-2"></i>Tambah FAQ
        </a>
    </div>
</div>

<?php if(session('success')): ?>
<div class="alert alert-success alert-dismissible fade show">
    <?php echo e(session('success')); ?>

    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
<?php endif; ?>

<!-- MAIN CARD -->
<div class="card">
    <div class="card-header">
        <h5 class="mb-0">
            <i class="bi bi-question-circle me-2"></i>
            Daftar FAQ
        </h5>
    </div>

    <div class="card-body">

        <!-- FILTER -->
        <form method="GET" action="<?php echo e(route('admin.faq.index')); ?>" class="mb-3">
            <div class="row g-2">
                <div class="col-md-6">
                    <input type="text"
                           name="search"
                           class="form-control"
                           placeholder="Cari pertanyaan atau jawaban..."
                           value="<?php echo e(request('search')); ?>">
                </div>

                <div class="col-md-3">
                    <select name="kategori" class="form-select">
                        <option value="">Semua Kategori</option>
                        <?php $__currentLoopData = ['Permohonan Informasi','Keberatan','Sengketa','Informasi Publik','Umum','Lainnya']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $kat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($kat); ?>" <?php echo e(request('kategori') === $kat ? 'selected' : ''); ?>>
                                <?php echo e($kat); ?>

                            </option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>

                <div class="col-md-3">
                    <button class="btn btn-secondary">
                        <i class="bi bi-search"></i> Filter
                    </button>
                    <a href="<?php echo e(route('admin.faq.index')); ?>" class="btn btn-outline-secondary">
                        Reset
                    </a>
                </div>
            </div>
        </form>

        <!-- TABLE -->
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead>
                    <tr>
                        <th width="5%">No</th>
                        <th width="15%">Kategori</th>
                        <th width="40%">Pertanyaan</th>
                        <th width="10%">Urutan</th>
                        <th width="10%">Status</th>
                        <th width="20%">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $faqs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $faq): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr>
                        <td><?php echo e($faqs->firstItem() + $index); ?></td>
                        <td>
                            <span class="badge bg-primary"><?php echo e($faq->kategori); ?></span>
                        </td>
                        <td><?php echo e(Str::limit($faq->pertanyaan, 80)); ?></td>
                        <td>
                            <span class="badge bg-secondary"><?php echo e($faq->urutan); ?></span>
                        </td>
                        <td>
                            <?php if($faq->is_active): ?>
                                <span class="badge bg-success">Aktif</span>
                            <?php else: ?>
                                <span class="badge bg-secondary">Nonaktif</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <div class="d-flex gap-1">
                                <a href="<?php echo e(route('admin.faq.edit', $faq)); ?>"
                                   class="btn btn-warning btn-sm"
                                   title="Edit">
                                    <i class="bi bi-pencil"></i>
                                </a>

                                <button type="button"
                                        class="btn btn-info btn-sm"
                                        data-bs-toggle="modal"
                                        data-bs-target="#detailModal<?php echo e($faq->id); ?>"
                                        title="Detail">
                                    <i class="bi bi-eye"></i>
                                </button>

                                <form action="<?php echo e(route('admin.faq.destroy', $faq)); ?>"
                                      method="POST"
                                      onsubmit="return confirm('Yakin ingin menghapus FAQ ini?')">
                                    <?php echo csrf_field(); ?>
                                    <?php echo method_field('DELETE'); ?>
                                    <button class="btn btn-danger btn-sm" title="Hapus">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="6" class="text-center py-4 text-muted">
                            Belum ada data FAQ
                        </td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <!-- PAGINATION -->
        <div class="d-flex justify-content-between align-items-center mt-3">
            <div>
                Menampilkan <?php echo e($faqs->firstItem() ?? 0); ?>–<?php echo e($faqs->lastItem() ?? 0); ?>

                dari <?php echo e($faqs->total()); ?> data
            </div>
            <?php echo e($faqs->links()); ?>

        </div>

    </div>
</div>

<!-- MODALS -->
<?php $__currentLoopData = $faqs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $faq): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
<div class="modal fade" id="detailModal<?php echo e($faq->id); ?>" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Detail FAQ</h5>
                <button class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p><strong>Kategori:</strong> <?php echo e($faq->kategori); ?></p>
                <p><strong>Pertanyaan:</strong><br><?php echo e($faq->pertanyaan); ?></p>
                <p><strong>Jawaban:</strong></p>
                <div class="p-3 bg-light rounded">
                    <?php echo nl2br(e($faq->jawaban)); ?>

                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\ppid-website\resources\views/admin/faq/index.blade.php ENDPATH**/ ?>