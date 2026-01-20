

<?php $__env->startSection('title', 'Kelola Halaman Statis'); ?>

<?php $__env->startSection('styles'); ?>
<style>
.badge.status-aktif-halaman {
    background-color: #28a745 !important;
    color: #ffffff !important;
    font-weight: 500;
    padding: 5px 12px;
}

.badge.status-nonaktif-halaman {
    background-color: #dc3545 !important;
    color: #ffffff !important;
    font-weight: 500;
    padding: 5px 12px;
}
</style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

<!-- PAGE HEADER -->
<div class="page-header">
    <div>
        <h2>Kelola Halaman Statis</h2>
        <p>Manajemen konten halaman statis website</p>
    </div>
    <div>
        <a href="<?php echo e(route('admin.halaman-statis.create')); ?>" class="btn btn-primary">
            <i class="bi bi-plus-lg me-2"></i>Tambah Halaman
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
            <i class="bi bi-file-earmark-text me-2"></i>
            Daftar Halaman Statis
        </h5>
    </div>

    <div class="card-body">

        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th width="5%">No</th>
                        <th width="30%">Judul</th>
                        <th width="25%">Slug</th>
                        <th width="15%">Status</th>
                        <th width="25%">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $halaman; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr>
                        <td><?php echo e($halaman->firstItem() + $index); ?></td>
                        <td><strong><?php echo e($item->judul); ?></strong></td>
                        <td><code><?php echo e($item->slug); ?></code></td>
                        <td>
                            <?php if($item->is_active): ?>
                                <span class="badge status-aktif-halaman">Aktif</span>
                            <?php else: ?>
                                <span class="badge status-nonaktif-halaman">Nonaktif</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <div class="btn-group btn-group-sm">

                                <!-- Lihat Frontend -->
                                <a href="<?php echo e(route('halaman-statis.show', $item->slug)); ?>"
                                   class="btn btn-info text-white"
                                   target="_blank"
                                   rel="noopener"
                                   data-bs-toggle="tooltip"
                                   title="Lihat Halaman">
                                    <i class="bi bi-box-arrow-up-right"></i>
                                </a>

                                <!-- Edit -->
                                <a href="<?php echo e(route('admin.halaman-statis.edit', $item->id)); ?>"
                                   class="btn btn-warning text-white"
                                   data-bs-toggle="tooltip"
                                   title="Edit Halaman">
                                    <i class="bi bi-pencil-square"></i>
                                </a>

                                <!-- Hapus -->
                                <form action="<?php echo e(route('admin.halaman-statis.destroy', $item->id)); ?>"
                                      method="POST"
                                      class="d-inline"
                                      onsubmit="return confirm('Yakin ingin menghapus halaman ini?')">
                                    <?php echo csrf_field(); ?>
                                    <?php echo method_field('DELETE'); ?>
                                    <button class="btn btn-danger"
                                            data-bs-toggle="tooltip"
                                            title="Hapus Halaman">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>

                            </div>
                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="5" class="text-center text-muted py-4">
                            Belum ada halaman statis
                        </td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <!-- PAGINATION -->
        <div class="d-flex justify-content-end mt-4">
            <?php echo e($halaman->links()); ?>

        </div>

    </div>
</div>

<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
document.addEventListener('DOMContentLoaded', function () {
    var tooltipTriggerList = [].slice.call(
        document.querySelectorAll('[data-bs-toggle="tooltip"]')
    );
    tooltipTriggerList.forEach(function (el) {
        new bootstrap.Tooltip(el);
    });
});
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\ppid-website\resources\views/admin/halaman-statis/index.blade.php ENDPATH**/ ?>