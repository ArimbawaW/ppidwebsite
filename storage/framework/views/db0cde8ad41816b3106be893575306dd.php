

<?php $__env->startSection('title', 'Daftar Permohonan'); ?>

<?php $__env->startPush('styles'); ?>
<style>
.table .badge {
    display: inline-block !important;
    padding: 0.5rem 0.75rem !important;
    font-size: 0.875rem !important;
    font-weight: 600 !important;
    line-height: 1 !important;
    border-radius: 0.25rem !important;
}

.badge-primary { background-color: #0d6efd !important; color: #fff !important; }
.badge-success { background-color: #198754 !important; color: #fff !important; }
.badge-warning { background-color: #ffc107 !important; color: #212529 !important; }
.badge-info    { background-color: #0dcaf0 !important; color: #212529 !important; }
.badge-danger  { background-color: #dc3545 !important; color: #fff !important; }

.btn-group-custom {
    display: inline-flex;
    gap: 6px;
}

.kategori-cell { min-width: 150px; }
.aksi-cell     { min-width: 110px; }
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>

<!-- PAGE HEADER -->
<div class="page-header">
    <div>
        <h2>Daftar Permohonan</h2>
        <p>Manajemen dan pemantauan permohonan layanan</p>
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
            <i class="bi bi-database me-2"></i>
            Data Permohonan
        </h5>
    </div>

    <div class="card-body">

        <div class="table-responsive">
            <table class="table table-bordered table-hover align-middle" id="permohonanTable">
                <thead class="table-light">
                    <tr>
                        <th class="text-center">No</th>
                        <th>No. Registrasi</th>
                        <th class="text-center">Kategori</th>
                        <th>Nama Pemohon</th>
                        <th>Kontak</th>
                        <th>Tanggal</th>
                        <th class="text-center">Status</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>

                <tbody>
                <?php $__currentLoopData = $permohonan; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td class="text-center"><?php echo e($index + 1); ?></td>

                        <td>
                            <a href="<?php echo e(route('admin.permohonan.show', $item)); ?>"
                               class="fw-bold text-primary">
                                <?php echo e($item->nomor_registrasi); ?>

                            </a>
                        </td>

                        <td class="text-center kategori-cell">
                            <?php if($item->kategori_pemohon === 'perorangan'): ?>
                                <span class="badge badge-primary">
                                    <i class="bi bi-person"></i> Perorangan
                                </span>
                            <?php elseif($item->kategori_pemohon === 'kelompok'): ?>
                                <span class="badge badge-success">
                                    <i class="bi bi-people"></i> Kelompok
                                </span>
                            <?php elseif($item->kategori_pemohon === 'badan_hukum'): ?>
                                <span class="badge badge-warning">
                                    <i class="bi bi-building"></i> Badan Hukum
                                </span>
                            <?php endif; ?>
                        </td>

                        <td>
                            <strong><?php echo e($item->nama); ?></strong><br>
                            <small class="text-muted"><?php echo e($item->pekerjaan); ?></small>
                        </td>

                        <td>
                            <small>
                                <i class="bi bi-envelope"></i> <?php echo e($item->email); ?><br>
                                <i class="bi bi-telephone"></i> <?php echo e($item->no_telepon); ?>

                            </small>
                        </td>

                        <td>
                            <small>
                                <?php echo e($item->created_at->format('d/m/Y')); ?><br>
                                <?php echo e($item->created_at->format('H:i')); ?> WIB
                            </small>
                        </td>

                        <td class="text-center">
                            <?php if($item->status === 'pending'): ?>
                                <span class="badge badge-warning">
                                    <i class="bi bi-clock"></i> Pending
                                </span>
                            <?php elseif($item->status === 'diproses'): ?>
                                <span class="badge badge-info">
                                    <i class="bi bi-arrow-repeat"></i> Diproses
                                </span>
                            <?php elseif($item->status === 'disetujui'): ?>
                                <span class="badge badge-success">
                                    <i class="bi bi-check-circle"></i> Disetujui
                                </span>
                            <?php else: ?>
                                <span class="badge badge-danger">
                                    <i class="bi bi-x-circle"></i> Ditolak
                                </span>
                            <?php endif; ?>
                        </td>

                        <td class="text-center aksi-cell">
                            <div class="btn-group-custom">
                                <a href="<?php echo e(route('admin.permohonan.show', $item)); ?>"
                                   class="btn btn-sm btn-primary">
                                    <i class="bi bi-eye"></i>
                                </a>
                                <button class="btn btn-sm btn-danger"
                                        onclick="confirmDelete(<?php echo e($item->id); ?>)">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </div>

                            <form id="delete-form-<?php echo e($item->id); ?>"
                                  action="<?php echo e(route('admin.permohonan.destroy', $item)); ?>"
                                  method="POST" class="d-none">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('DELETE'); ?>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>

            </table>
        </div>

    </div>
</div>

<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
$(document).ready(function () {
    $('#permohonanTable').DataTable({
        pageLength: 10,
        ordering: true,
        language: {
            search: "Cari:",
            lengthMenu: "Tampilkan _MENU_ data",
            info: "Menampilkan _START_–_END_ dari _TOTAL_ data",
            zeroRecords: "Tidak ada data permohonan",
            paginate: {
                previous: "Sebelumnya",
                next: "Selanjutnya"
            }
        }
    });
});

function confirmDelete(id) {
    if (confirm('Apakah Anda yakin ingin menghapus permohonan ini?')) {
        document.getElementById('delete-form-' + id).submit();
    }
}
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\ppid-website\resources\views/admin/permohonan/index.blade.php ENDPATH**/ ?>