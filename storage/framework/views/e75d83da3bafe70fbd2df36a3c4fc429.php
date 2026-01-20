

<?php $__env->startSection('title', 'Galeri - PPID Admin'); ?>

<?php $__env->startSection('styles'); ?>
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
</style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

<!-- PAGE HEADER -->
<div class="page-header">
    <div>
        <h2>Manajemen Galeri</h2>
        <p>Kelola galeri foto dan dokumentasi</p>
    </div>
    <div>
        <a href="<?php echo e(route('admin.galeri.create')); ?>" class="btn btn-primary">
            Tambah Galeri
        </a>
    </div>
</div>

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
            <table class="table table-striped table-bordered align-middle">
                <thead>
                    <tr>
                        <th width="5%">ID</th>
                        <th width="15%">Gambar</th>
                        <th width="25%">Judul</th>
                        <th width="15%">Status</th>
                        <th width="15%">Tanggal</th>
                        <th width="25%">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $galeri; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td><?php echo e($item->id); ?></td>
                        <td>
                            <?php if($item->gambar): ?>
                                <img src="<?php echo e(asset('storage/' . $item->gambar)); ?>"
                                     alt="<?php echo e($item->judul); ?>"
                                     class="rounded"
                                     style="max-width: 100px;">
                            <?php else: ?>
                                -
                            <?php endif; ?>
                        </td>
                        <td><?php echo e($item->judul); ?></td>
                        <td>
                            <?php if($item->is_active): ?>
                                <span class="badge status-aktif-galeri">Aktif</span>
                            <?php else: ?>
                                <span class="badge status-nonaktif-galeri">Tidak Aktif</span>
                            <?php endif; ?>
                        </td>
                        <td><?php echo e($item->created_at->format('d M Y')); ?></td>
                        <td>
                            <div class="btn-group btn-group-sm">
                                <a href="<?php echo e(route('admin.galeri.edit', $item->id)); ?>"
                                   class="btn btn-warning">
                                    Edit
                                </a>
                                <form action="<?php echo e(route('admin.galeri.destroy', $item->id)); ?>"
                                      method="POST"
                                      class="d-inline"
                                      onsubmit="return confirm('Yakin ingin menghapus galeri ini?')">
                                    <?php echo csrf_field(); ?>
                                    <?php echo method_field('DELETE'); ?>
                                    <button class="btn btn-danger">
                                        Hapus
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
        </div>

        <?php echo e($galeri->links()); ?>


        <?php else: ?>

        <div class="alert alert-info">
            Belum ada galeri.
            <a href="<?php echo e(route('admin.galeri.create')); ?>">Tambah galeri pertama</a>
        </div>

        <?php endif; ?>

    </div>
</div>

<!-- DATATABLE (OPTIONAL / HIDDEN) -->
<div class="table-responsive mt-4 d-none" id="datatableContainer">
    <table class="table table-striped table-bordered" id="galeriTable">
        <thead>
            <tr>
                <th>ID</th>
                <th>Gambar</th>
                <th>Judul</th>
                <th>Status</th>
                <th>Tanggal</th>
                <th>Aksi</th>
            </tr>
        </thead>
    </table>
</div>

<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
$(document).ready(function () {
    $('#galeriTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: "<?php echo e(route('admin.galeri.index')); ?>",
            type: 'GET',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        },
        columns: [
            { data: 'id', name: 'id' },
            { data: 'gambar_preview', orderable: false, searchable: false },
            { data: 'judul', name: 'judul' },
            { data: 'is_active', name: 'is_active' },
            { data: 'created_at', name: 'created_at' },
            { data: 'action', orderable: false, searchable: false }
        ]
    });
});
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\ppid-website\resources\views/admin/galeri/index.blade.php ENDPATH**/ ?>