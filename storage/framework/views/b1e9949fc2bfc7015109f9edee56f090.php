

<?php $__env->startSection('title', 'Informasi Publik - PPID Admin'); ?>

<?php $__env->startSection('content'); ?>
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Manajemen Informasi Publik</h1>
    <a href="<?php echo e(route('admin.informasi-publik.create')); ?>" class="btn btn-primary">Tambah Informasi</a>
</div>

<?php if(isset($informasi) && $informasi->count() > 0): ?>
<div class="table-responsive">
    <table class="table table-striped table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Judul</th>
                <th>Kategori</th>
                <th>Status</th>
                <th>Download</th>
                <th>Tanggal</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php $__currentLoopData = $informasi; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr>
                <td><?php echo e($item->id); ?></td>
                <td><?php echo e($item->judul); ?></td>
                <td><?php echo e($item->kategori_label); ?></td>
                <td>
                    <?php if($item->is_active): ?>
                        <span class="badge status-aktif">Aktif</span>
                    <?php else: ?>
                        <span class="badge status-nonaktif">Tidak Aktif</span>
                    <?php endif; ?>
                </td>
                <td><?php echo e($item->download_count); ?></td>
                <td><?php echo e($item->created_at->format('d M Y')); ?></td>
                <td>
                    <a href="<?php echo e(route('admin.informasi-publik.edit', ['informasi_publik' => $item->id])); ?>" class="btn btn-sm btn-warning">Edit</a>
                    <form action="<?php echo e(route('admin.informasi-publik.destroy', ['informasi_publik' => $item->id])); ?>" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus?');">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('DELETE'); ?>
                        <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                    </form>
                </td>
            </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
    </table>
    
    <?php echo e($informasi->links()); ?>

</div>
<?php else: ?>
<div class="alert alert-info">
    Belum ada informasi publik. <a href="<?php echo e(route('admin.informasi-publik.create')); ?>">Tambah informasi pertama</a>
</div>
<?php endif; ?>

<style>
/* Status Badge untuk Informasi Publik */
.badge.status-aktif {
    background-color: #28a745 !important;
    color: white !important;
    font-weight: 500;
    padding: 5px 12px;
}

.badge.status-nonaktif {
    background-color: #6c757d !important;
    color: white !important;
    font-weight: 500;
    padding: 5px 12px;
}
</style>

<div class="table-responsive mt-4" style="display: none;" id="datatableContainer">
    <table class="table table-striped table-bordered" id="informasiTable">
        <thead>
            <tr>
                <th>ID</th>
                <th>Judul</th>
                <th>Kategori</th>
                <th>Status</th>
                <th>Download</th>
                <th>Tanggal</th>
                <th>Aksi</th>
            </tr>
        </thead>
    </table>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
    $(document).ready(function() {
        $('#informasiTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "<?php echo e(route('admin.informasi-publik.index')); ?>",
                type: 'GET',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            },
            columns: [
                { data: 'id', name: 'id' },
                { data: 'judul', name: 'judul' },
                { data: 'kategori', name: 'kategori' },
                { data: 'is_active', name: 'is_active' },
                { data: 'download_count', name: 'download_count' },
                { data: 'created_at', name: 'created_at' },
                { data: 'action', name: 'action', orderable: false, searchable: false }
            ],
            error: function(xhr, error, thrown) {
                console.log('DataTables Error:', error);
                console.log('Response:', xhr.responseText);
            }
        });
    });
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\ppid-website\resources\views/admin/informasi-publik/index.blade.php ENDPATH**/ ?>