<a href="<?php echo e(route('admin.permohonan.show', $item->id)); ?>" class="btn btn-sm btn-info">Detail</a>
<form action="<?php echo e(route('admin.permohonan.destroy', $item->id)); ?>" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus?');">
    <?php echo csrf_field(); ?>
    <?php echo method_field('DELETE'); ?>
    <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
</form>

<?php /**PATH C:\ppid-website\resources\views/admin/permohonan/action.blade.php ENDPATH**/ ?>