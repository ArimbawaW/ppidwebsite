

<?php $__env->startSection('title', 'Kelola Agenda Kegiatan'); ?>

<?php $__env->startSection('content'); ?>

<!-- PAGE HEADER -->
<div class="page-header">
    <div>
        <h2>Kelola Agenda Kegiatan</h2>
        <p>Manajemen jadwal dan agenda kegiatan</p>
    </div>
    <div>
        <a href="<?php echo e(route('admin.agenda-kegiatan.create')); ?>" class="btn btn-primary">
            <i class="bi bi-plus-lg me-2"></i>Tambah Agenda
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
            <i class="bi bi-calendar-event me-2"></i>
            Daftar Agenda Kegiatan
        </h5>
    </div>

    <div class="card-body">

        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th width="5%">No</th>
                        <th width="15%">Tanggal</th>
                        <th width="25%">Judul</th>
                        <th width="10%">Waktu</th>
                        <th width="20%">Lokasi</th>
                        <th width="10%">Status</th>
                        <th width="15%">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $agenda; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr>
                        <td><?php echo e($agenda->firstItem() + $index); ?></td>
                        <td><?php echo e($item->tanggal_format); ?></td>
                        <td><strong><?php echo e($item->judul); ?></strong></td>
                        <td>
                            <?php if($item->waktu_mulai): ?>
                                <?php echo e(date('H:i', strtotime($item->waktu_mulai))); ?> WIB
                            <?php else: ?>
                                -
                            <?php endif; ?>
                        </td>
                        <td><?php echo e($item->lokasi ?? '-'); ?></td>
                        <td>
                            <?php if($item->status === 'upcoming'): ?>
                                <span class="badge status-upcoming">Akan Datang</span>
                            <?php elseif($item->status === 'ongoing'): ?>
                                <span class="badge status-ongoing">Berlangsung</span>
                            <?php else: ?>
                                <span class="badge status-selesai-agenda">Selesai</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <div class="btn-group btn-group-sm">
                                <a href="<?php echo e(route('admin.agenda-kegiatan.edit', $item->id)); ?>"
                                   class="btn btn-outline-primary"
                                   title="Edit">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form action="<?php echo e(route('admin.agenda-kegiatan.destroy', $item->id)); ?>"
                                      method="POST"
                                      class="d-inline"
                                      onsubmit="return confirm('Yakin hapus agenda ini?')">
                                    <?php echo csrf_field(); ?>
                                    <?php echo method_field('DELETE'); ?>
                                    <button class="btn btn-outline-danger" title="Hapus">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="7" class="text-center py-4 text-muted">
                            Belum ada agenda kegiatan
                        </td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <!-- PAGINATION -->
        <div class="d-flex justify-content-end mt-4">
            <?php echo e($agenda->links()); ?>

        </div>

    </div>
</div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\ppid-website\resources\views/admin/agenda-kegiatan/index.blade.php ENDPATH**/ ?>