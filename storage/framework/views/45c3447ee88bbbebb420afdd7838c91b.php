

<?php $__env->startSection('title', 'Manajemen Standar Layanan'); ?>

<?php $__env->startSection('styles'); ?>
<style>
    button, a.btn, .btn {
        display: inline-block !important;
        opacity: 1 !important;
        visibility: visible !important;
    }

    .table td:nth-child(3) {
        text-align: center !important;
        vertical-align: middle !important;
    }
</style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

<!-- PAGE HEADER -->
<div class="page-header">
    <div>
        <h2>Manajemen Standar Layanan</h2>
        <p>Pengelolaan daftar standar layanan yang ditampilkan pada sistem</p>
    </div>
    <div>
        <a href="<?php echo e(route('admin.standar-layanan.create')); ?>" class="btn btn-primary">
            <i class="bi bi-plus-circle"></i> Tambah Standar Layanan
        </a>
    </div>
</div>

<?php if(session('success')): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <?php echo e(session('success')); ?>

        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>

<!-- MAIN CARD -->
<div class="card">
    <div class="card-header">
        <h5>Daftar Standar Layanan</h5>
    </div>

    <div class="card-body">

        <!-- Search -->
        <form method="GET" action="<?php echo e(route('admin.standar-layanan.index')); ?>" class="mb-3">
            <div class="row g-2">
                <div class="col-md-8">
                    <input type="text"
                           name="search"
                           class="form-control"
                           placeholder="Cari nama layanan..."
                           value="<?php echo e(request('search')); ?>">
                </div>
                <div class="col-md-4">
                    <button type="submit" class="btn btn-secondary">
                        <i class="bi bi-search"></i> Cari
                    </button>
                    <a href="<?php echo e(route('admin.standar-layanan.index')); ?>" class="btn btn-outline-secondary">
                        Reset
                    </a>
                </div>
            </div>
        </form>

        <!-- Table -->
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th width="5%">No</th>
                        <th width="65%">Nama Layanan</th>
                        <th width="10%" class="text-center">Urutan</th>
                        <th width="20%">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $standarLayanan; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $layanan): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr>
                            <td><?php echo e($standarLayanan->firstItem() + $index); ?></td>
                            <td><?php echo e($layanan->nama_layanan); ?></td>
                            <td class="text-center">
                                <span class="badge bg-secondary">
                                    <?php echo e($layanan->urutan); ?>

                                </span>
                            </td>
                            <td>
                                <div class="d-flex gap-1">
                                    <a href="<?php echo e(route('admin.standar-layanan.edit', $layanan)); ?>"
                                       class="btn btn-warning btn-sm"
                                       title="Edit">
                                        <i class="bi bi-pencil"></i>
                                    </a>

                                    <form action="<?php echo e(route('admin.standar-layanan.destroy', $layanan)); ?>"
                                          method="POST"
                                          onsubmit="return confirm('Yakin ingin menghapus standar layanan ini?')">
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('DELETE'); ?>
                                        <button type="submit"
                                                class="btn btn-danger btn-sm"
                                                title="Hapus">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="4" class="text-center py-4">
                                <i class="bi bi-inbox fs-1 text-muted"></i>
                                <p class="text-muted mb-0">Belum ada data standar layanan</p>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="d-flex justify-content-between align-items-center mt-3">
            <div>
                Menampilkan <?php echo e($standarLayanan->firstItem() ?? 0); ?> -
                <?php echo e($standarLayanan->lastItem() ?? 0); ?>

                dari <?php echo e($standarLayanan->total()); ?> data
            </div>
            <?php echo e($standarLayanan->links()); ?>

        </div>

    </div>
</div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\ppid-website\resources\views/admin/standar-layanan/index.blade.php ENDPATH**/ ?>