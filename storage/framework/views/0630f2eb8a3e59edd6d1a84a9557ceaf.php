

<?php $__env->startSection('title', 'Manajemen Berita - PPID Admin'); ?>

<?php $__env->startPush('styles'); ?>
<style>
/* Badge Status Styling */
.badge.status-published {
    background-color: #28a745 !important;
    color: #ffffff !important;
    font-weight: 500;
    padding: 5px 12px;
}

.badge.status-draft {
    background-color: #6c757d !important;
    color: #ffffff !important;
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

/* Thumbnail Styling */
.news-thumbnail {
    width: 60px;
    height: 40px;
    object-fit: cover;
    border-radius: 0.375rem;
    box-shadow: 0 1px 3px rgba(0,0,0,0.1);
}

.news-thumbnail-placeholder {
    width: 60px;
    height: 40px;
    border-radius: 0.375rem;
    background-color: #f8f9fa;
    display: flex;
    align-items: center;
    justify-content: center;
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
        <h2>Manajemen Berita</h2>
        <p>Kelola berita, artikel, dan pengumuman</p>
    </div>
    <div>
        <a href="<?php echo e(route('admin.berita.create')); ?>" class="btn btn-primary">
            <i class="bi bi-plus-circle me-2"></i>Tambah Berita
        </a>
    </div>
</div>

<?php if(session('success')): ?>
<div class="alert alert-success alert-dismissible fade show">
    <?php echo e(session('success')); ?>

    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
<?php endif; ?>

<!-- FILTER CARD -->
<div class="card mb-4">
    <div class="card-body">
        <form method="GET" action="<?php echo e(route('admin.berita.index')); ?>">
            <div class="row g-3">
                <div class="col-md-5">
                    <input type="text"
                           name="search"
                           class="form-control"
                           placeholder="Cari judul berita..."
                           value="<?php echo e(request('search')); ?>">
                </div>

                <div class="col-md-3">
                    <select name="kategori" class="form-select">
                        <option value="">Semua Kategori</option>
                        <option value="berita" <?php echo e(request('kategori') === 'berita' ? 'selected' : ''); ?>>Berita</option>
                        <option value="artikel" <?php echo e(request('kategori') === 'artikel' ? 'selected' : ''); ?>>Artikel</option>
                        <option value="pengumuman" <?php echo e(request('kategori') === 'pengumuman' ? 'selected' : ''); ?>>Pengumuman</option>
                    </select>
                </div>

                <div class="col-md-2">
                    <select name="status" class="form-select">
                        <option value="">Semua Status</option>
                        <option value="published" <?php echo e(request('status') === 'published' ? 'selected' : ''); ?>>Published</option>
                        <option value="draft" <?php echo e(request('status') === 'draft' ? 'selected' : ''); ?>>Draft</option>
                    </select>
                </div>

                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="bi bi-search me-1"></i>Filter
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- MAIN CARD -->
<div class="card">
    <div class="card-header">
        <h5 class="mb-0">
            <i class="bi bi-newspaper me-2"></i>
            Daftar Berita
        </h5>
    </div>

    <div class="card-body">

        <?php if($berita->count()): ?>

        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th width="5%">No</th>
                        <th width="10%">Gambar</th>
                        <th width="30%">Judul</th>
                        <th width="12%">Kategori</th>
                        <th width="10%">Status</th>
                        <th width="8%">Views</th>
                        <th width="10%">Tanggal</th>
                        <th width="15%">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $berita; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td><?php echo e($berita->firstItem() + $index); ?></td>

                        <td>
                            <?php if($item->gambar): ?>
                                <img src="<?php echo e(asset('storage/' . $item->gambar)); ?>"
                                     alt="<?php echo e($item->judul); ?>"
                                     class="news-thumbnail">
                            <?php else: ?>
                                <div class="news-thumbnail-placeholder">
                                    <i class="bi bi-image text-muted"></i>
                                </div>
                            <?php endif; ?>
                        </td>

                        <td>
                            <strong><?php echo e(Str::limit($item->judul, 50)); ?></strong>
                        </td>

                        <td>
                            <?php if($item->kategori === 'berita'): ?>
                                <span class="badge bg-primary">Berita</span>
                            <?php elseif($item->kategori === 'artikel'): ?>
                                <span class="badge bg-info">Artikel</span>
                            <?php else: ?>
                                <span class="badge bg-warning text-dark">Pengumuman</span>
                            <?php endif; ?>
                        </td>

                        <td>
                            <?php if($item->is_published): ?>
                                <span class="badge status-published">Published</span>
                            <?php else: ?>
                                <span class="badge status-draft">Draft</span>
                            <?php endif; ?>
                        </td>

                        <td>
                            <span class="badge bg-light text-dark">
                                <i class="bi bi-eye me-1"></i><?php echo e($item->views); ?>

                            </span>
                        </td>

                        <td>
                            <small class="text-muted">
                                <?php echo e($item->created_at->format('d M Y')); ?>

                            </small>
                        </td>

                        <td>
                            <div class="btn-group-action">
                                <!-- Edit -->
                                <a href="<?php echo e(route('admin.berita.edit', $item->id)); ?>"
                                   class="btn btn-sm btn-warning text-white"
                                   data-bs-toggle="tooltip"
                                   title="Edit Berita">
                                    <i class="bi bi-pencil-square"></i>
                                </a>

                                <!-- Hapus -->
                                <button type="button"
                                        class="btn btn-sm btn-danger"
                                        data-bs-toggle="tooltip"
                                        title="Hapus Berita"
                                        onclick="confirmDelete(<?php echo e($item->id); ?>)">
                                    <i class="bi bi-trash"></i>
                                </button>

                                <form id="delete-form-<?php echo e($item->id); ?>"
                                      action="<?php echo e(route('admin.berita.destroy', $item->id)); ?>"
                                      method="POST"
                                      class="d-none">
                                    <?php echo csrf_field(); ?>
                                    <?php echo method_field('DELETE'); ?>
                                </form>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
        </div>

        <!-- PAGINATION -->
        <div class="d-flex justify-content-between align-items-center mt-4">
            <p class="text-muted mb-0">
                Menampilkan <?php echo e($berita->firstItem()); ?>–<?php echo e($berita->lastItem()); ?>

                dari <?php echo e($berita->total()); ?> data
            </p>
            <?php echo e($berita->links()); ?>

        </div>

        <?php else: ?>

        <!-- EMPTY STATE -->
        <div class="text-center py-5">
            <i class="bi bi-inbox fs-1 text-muted d-block mb-3"></i>
            <p class="text-muted mb-3">Belum ada berita yang tersedia</p>
            <a href="<?php echo e(route('admin.berita.create')); ?>" class="btn btn-primary">
                <i class="bi bi-plus-circle me-2"></i>Tambah Berita Pertama
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
    if (confirm('Yakin ingin menghapus berita ini? Data yang sudah dihapus tidak dapat dikembalikan.')) {
        document.getElementById('delete-form-' + id).submit();
    }
}
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\ppid-website\ppidwebsite\resources\views/admin/berita/index.blade.php ENDPATH**/ ?>