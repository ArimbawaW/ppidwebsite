

<?php $__env->startSection('title', 'Manajemen Regulasi'); ?>

<?php $__env->startPush('styles'); ?>
<style>
    .badge {
        display: inline-block !important;
        padding: 0.35em 0.65em !important;
        font-size: 0.875em !important;
        font-weight: 600 !important;
        border-radius: 0.25rem !important;
        white-space: nowrap !important;
    }

    .btn-action {
        padding: 0.25rem 0.5rem;
        font-size: 0.875rem;
        border-radius: 0.25rem;
        display: inline-flex;
        align-items: center;
        gap: 0.25rem;
        border: 1px solid transparent;
    }
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>

<!-- PAGE HEADER -->
<div class="page-header">
    <div>
        <h2>Manajemen Regulasi</h2>
        <p>Kelola peraturan dan regulasi yang dipublikasikan</p>
    </div>
    <div>
        <a href="<?php echo e(route('admin.regulasi.create')); ?>" class="btn btn-primary">
            <i class="bi bi-plus-circle me-1"></i> Tambah Regulasi
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
            <i class="bi bi-journal-text me-2"></i>
            Data Regulasi
        </h5>
    </div>

    <div class="card-body">

        <!-- FILTER -->
        <form method="GET" action="<?php echo e(route('admin.regulasi.index')); ?>" class="mb-4">
            <div class="row g-2">
                <div class="col-md-4">
                    <input type="text"
                           name="search"
                           class="form-control"
                           placeholder="Cari judul atau nomor..."
                           value="<?php echo e(request('search')); ?>">
                </div>

                <div class="col-md-3">
                    <select name="kategori" class="form-select">
                        <option value="">Semua Kategori</option>
                        <?php $__currentLoopData = ['Undang-Undang','Peraturan Pemerintah','Peraturan Menteri','Peraturan Daerah','Keputusan','Lainnya']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $kat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($kat); ?>" <?php echo e(request('kategori') == $kat ? 'selected' : ''); ?>>
                                <?php echo e($kat); ?>

                            </option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>

                <div class="col-md-2">
                    <select name="status" class="form-select">
                        <option value="">Semua Status</option>
                        <option value="aktif" <?php echo e(request('status') == 'aktif' ? 'selected' : ''); ?>>Aktif</option>
                        <option value="tidak_aktif" <?php echo e(request('status') == 'tidak_aktif' ? 'selected' : ''); ?>>Tidak Aktif</option>
                    </select>
                </div>

                <div class="col-md-3">
                    <button class="btn btn-secondary me-1">
                        <i class="bi bi-search"></i> Filter
                    </button>
                    <a href="<?php echo e(route('admin.regulasi.index')); ?>" class="btn btn-outline-secondary">
                        Reset
                    </a>
                </div>
            </div>
        </form>

        <!-- TABLE -->
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th width="5%">No</th>
                        <th width="15%" class="text-center">Kategori</th>
                        <th width="15%">Nomor</th>
                        <th width="30%">Judul</th>
                        <th width="10%" class="text-center">Tahun</th>
                        <th width="10%" class="text-center">Status</th>
                        <th width="15%">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $regulasi; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $reg): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr>
                        <td><?php echo e($regulasi->firstItem() + $index); ?></td>

                        <td class="text-center">
                            <?php
                                $kategoriClass = match($reg->kategori) {
                                    'Undang-Undang' => 'bg-primary',
                                    'Peraturan Pemerintah' => 'bg-success',
                                    'Peraturan Menteri' => 'bg-info',
                                    'Peraturan Daerah' => 'bg-warning',
                                    'Keputusan' => 'bg-danger',
                                    default => 'bg-secondary'
                                };
                            ?>
                            <span class="badge <?php echo e($kategoriClass); ?>">
                                <?php echo e($reg->kategori); ?>

                            </span>
                        </td>

                        <td><?php echo e($reg->nomor); ?></td>

                        <td><?php echo e(Str::limit($reg->judul, 60)); ?></td>

                        <td class="text-center"><?php echo e($reg->tahun ?? '-'); ?></td>

                        <td class="text-center">
                            <?php if($reg->is_active): ?>
                                <span class="badge bg-success">Aktif</span>
                            <?php else: ?>
                                <span class="badge bg-secondary">Tidak Aktif</span>
                            <?php endif; ?>
                        </td>

                        <td>
                            <div class="d-flex gap-1">
                                <a href="<?php echo e(route('admin.regulasi.edit', $reg)); ?>"
                                   class="btn-action btn btn-warning"
                                   title="Edit">
                                    <i class="bi bi-pencil"></i>
                                </a>

                                <a href="<?php echo e(asset('storage/' . $reg->file)); ?>"
                                   target="_blank"
                                   class="btn-action btn btn-info"
                                   title="Lihat File">
                                    <i class="bi bi-eye"></i>
                                </a>

                                <form action="<?php echo e(route('admin.regulasi.destroy', $reg)); ?>"
                                      method="POST"
                                      onsubmit="return confirm('Yakin ingin menghapus regulasi ini?')">
                                    <?php echo csrf_field(); ?>
                                    <?php echo method_field('DELETE'); ?>
                                    <button class="btn-action btn btn-danger" title="Hapus">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="7" class="text-center py-4 text-muted">
                            <i class="bi bi-inbox fs-1 d-block mb-2"></i>
                            Belum ada data regulasi
                        </td>
                    </tr>
                <?php endif; ?>
                </tbody>
            </table>
        </div>

        <!-- PAGINATION -->
        <div class="d-flex justify-content-between align-items-center mt-3">
            <div class="text-muted">
                Menampilkan <?php echo e($regulasi->firstItem() ?? 0); ?> –
                <?php echo e($regulasi->lastItem() ?? 0); ?>

                dari <?php echo e($regulasi->total()); ?> data
            </div>
            <?php echo e($regulasi->links()); ?>

        </div>

    </div>
</div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\ppid-website\resources\views/admin/regulasi/index.blade.php ENDPATH**/ ?>