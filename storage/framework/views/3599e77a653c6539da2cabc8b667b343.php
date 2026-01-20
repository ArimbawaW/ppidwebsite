

<?php $__env->startSection('title', 'Manajemen Berita - PPID Admin'); ?>

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
                <thead>
                    <tr>
                        <th width="5%">No</th>
                        <th width="10%">Gambar</th>
                        <th width="30%">Judul</th>
                        <th width="15%">Kategori</th>
                        <th width="10%">Status</th>
                        <th width="10%">Views</th>
                        <th width="10%">Tanggal</th>
                        <th width="10%">Aksi</th>
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
                                     class="rounded"
                                     style="width:60px;height:40px;object-fit:cover;">
                            <?php else: ?>
                                <div class="d-flex align-items-center justify-content-center bg-light rounded"
                                     style="width:60px;height:40px;">
                                    <i class="bi bi-image text-muted"></i>
                                </div>
                            <?php endif; ?>
                        </td>

                        <td>
                            <strong><?php echo e(Str::limit($item->judul, 50)); ?></strong>
                        </td>

                        <td>
                            <span class="badge bg-info">
                                <?php echo e(ucfirst($item->kategori)); ?>

                            </span>
                        </td>

                        <td>
                            <?php if($item->is_published): ?>
                                <span class="badge bg-success">Published</span>
                            <?php else: ?>
                                <span class="badge bg-secondary">Draft</span>
                            <?php endif; ?>
                        </td>

                        <td><?php echo e($item->views); ?></td>

                        <td>
                            <small class="text-muted">
                                <?php echo e($item->created_at->format('d M Y')); ?>

                            </small>
                        </td>

                        <td>
                            <div class="btn-group btn-group-sm">
                                <a href="<?php echo e(route('admin.berita.edit', $item->id)); ?>"
                                   class="btn btn-warning"
                                   title="Edit">
                                    <i class="bi bi-pencil"></i>
                                </a>

                                <form action="<?php echo e(route('admin.berita.destroy', $item->id)); ?>"
                                      method="POST"
                                      class="d-inline"
                                      onsubmit="return confirm('Yakin ingin menghapus berita ini?')">
                                    <?php echo csrf_field(); ?>
                                    <?php echo method_field('DELETE'); ?>
                                    <button class="btn btn-danger" title="Hapus">
                                        <i class="bi bi-trash"></i>
                                    </button>
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
            <i class="bi bi-inbox fs-1 text-muted"></i>
            <p class="text-muted mt-3">Belum ada berita yang tersedia</p>
            <a href="<?php echo e(route('admin.berita.create')); ?>" class="btn btn-primary">
                <i class="bi bi-plus-circle me-2"></i>Tambah Berita Pertama
            </a>
        </div>

        <?php endif; ?>

    </div>
</div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\ppid-website\resources\views/admin/berita/index.blade.php ENDPATH**/ ?>