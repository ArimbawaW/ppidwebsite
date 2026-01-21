

<?php $__env->startSection('title', 'Galeri - PPID Admin'); ?>

<?php $__env->startPush('styles'); ?>
<style>
.badge.status-aktif-galeri {
    background-color: #28a745 !important;
    color: #fff !important;
    font-weight: 500;
    padding: 5px 12px;
}

.badge.status-nonaktif-galeri {
    background-color: #6c757d !important;
    color: #fff !important;
    font-weight: 500;
    padding: 5px 12px;
}

/* Button Group Custom Styling */
.btn-group-action {
    display: inline-flex;
    gap: 6px;
}

.btn-group-action .btn {
    padding: 0.375rem 0.75rem;
    border-radius: 0.25rem !important;
}

.btn-group-action .btn i {
    font-size: 0.875rem;
}

/* Gallery Image Styling */
.gallery-thumbnail {
    max-width: 100px;
    height: 80px;
    object-fit: cover;
    border-radius: 0.375rem;
    box-shadow: 0 1px 3px rgba(0,0,0,0.1);
    transition: transform 0.2s;
}

.gallery-thumbnail:hover {
    transform: scale(1.05);
    cursor: pointer;
}

/* Responsive button sizing */
@media (max-width: 768px) {
    .btn-group-action {
        flex-direction: column;
        gap: 4px;
    }
    
    .btn-group-action .btn {
        width: 100%;
    }
}
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>

<!-- PAGE HEADER -->
<div class="page-header">
    <div>
        <h2>Manajemen Galeri</h2>
        <p>Kelola galeri foto dan dokumentasi</p>
    </div>
    <div>
        <a href="<?php echo e(route('admin.galeri.create')); ?>" class="btn btn-primary">
            <i class="bi bi-plus-lg me-2"></i>Tambah Galeri
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
            <i class="bi bi-images me-2"></i>
            Daftar Galeri
        </h5>
    </div>

    <div class="card-body">

        <?php if($galeri->count()): ?>

        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th width="5%">No</th>
                        <th width="15%">Gambar</th>
                        <th width="30%">Judul</th>
                        <th width="12%">Status</th>
                        <th width="15%">Tanggal</th>
                        <th width="18%">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $galeri; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td><?php echo e($galeri->firstItem() + $index); ?></td>
                        <td>
                            <?php if($item->gambar): ?>
                                <img src="<?php echo e(asset('storage/' . $item->gambar)); ?>"
                                     alt="<?php echo e($item->judul); ?>"
                                     class="gallery-thumbnail"
                                     data-bs-toggle="modal"
                                     data-bs-target="#imageModal<?php echo e($item->id); ?>">
                            <?php else: ?>
                                <span class="text-muted">-</span>
                            <?php endif; ?>
                        </td>
                        <td><strong><?php echo e($item->judul); ?></strong></td>
                        <td>
                            <?php if($item->is_active): ?>
                                <span class="badge status-aktif-galeri">Aktif</span>
                            <?php else: ?>
                                <span class="badge status-nonaktif-galeri">Tidak Aktif</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <small class="text-muted"><?php echo e($item->created_at->format('d M Y')); ?></small>
                        </td>
                        <td>
                            <div class="btn-group-action">
                                <!-- Edit -->
                                <a href="<?php echo e(route('admin.galeri.edit', $item->id)); ?>"
                                   class="btn btn-sm btn-warning text-white"
                                   data-bs-toggle="tooltip"
                                   title="Edit Galeri">
                                    <i class="bi bi-pencil-square"></i>
                                </a>

                                <!-- Hapus -->
                                <button type="button"
                                        class="btn btn-sm btn-danger"
                                        data-bs-toggle="tooltip"
                                        title="Hapus Galeri"
                                        onclick="confirmDelete(<?php echo e($item->id); ?>)">
                                    <i class="bi bi-trash"></i>
                                </button>

                                <form id="delete-form-<?php echo e($item->id); ?>"
                                      action="<?php echo e(route('admin.galeri.destroy', $item->id)); ?>"
                                      method="POST"
                                      class="d-none">
                                    <?php echo csrf_field(); ?>
                                    <?php echo method_field('DELETE'); ?>
                                </form>
                            </div>
                        </td>
                    </tr>

                    <!-- Modal untuk Preview Gambar -->
                    <?php if($item->gambar): ?>
                    <div class="modal fade" id="imageModal<?php echo e($item->id); ?>" tabindex="-1">
                        <div class="modal-dialog modal-dialog-centered modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title"><?php echo e($item->judul); ?></h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body text-center">
                                    <img src="<?php echo e(asset('storage/' . $item->gambar)); ?>"
                                         alt="<?php echo e($item->judul); ?>"
                                         class="img-fluid rounded">
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endif; ?>

                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
        </div>

        <!-- PAGINATION -->
        <div class="d-flex justify-content-end mt-4">
            <?php echo e($galeri->links()); ?>

        </div>

        <?php else: ?>

        <div class="text-center py-5">
            <i class="bi bi-images fs-1 text-muted d-block mb-3"></i>
            <p class="text-muted mb-3">Belum ada galeri foto.</p>
            <a href="<?php echo e(route('admin.galeri.create')); ?>" class="btn btn-primary">
                <i class="bi bi-plus-lg me-2"></i>Tambah Galeri Pertama
            </a>
        </div>

        <?php endif; ?>

    </div>
</div>

<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
// Initialize tooltips
document.addEventListener('DOMContentLoaded', function () {
    var tooltipTriggerList = [].slice.call(
        document.querySelectorAll('[data-bs-toggle="tooltip"]')
    );
    tooltipTriggerList.forEach(function (el) {
        new bootstrap.Tooltip(el);
    });
});

// Confirm delete function
function confirmDelete(id) {
    if (confirm('Yakin ingin menghapus galeri ini? Data yang sudah dihapus tidak dapat dikembalikan.')) {
        document.getElementById('delete-form-' + id).submit();
    }
}
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\ppid-website\ppidwebsite\resources\views/admin/galeri/index.blade.php ENDPATH**/ ?>