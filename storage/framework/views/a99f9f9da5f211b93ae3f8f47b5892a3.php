
<div class="btn-group btn-group-sm" role="group">
    
    <button type="button" 
            class="btn btn-info text-white" 
            onclick="quickView(<?php echo e($item->id); ?>)"
            data-bs-toggle="tooltip" 
            title="Lihat Cepat">
        <i class="bi bi-eye"></i>
    </button>
    
    
    <a href="<?php echo e(route('admin.keberatan.show', $item->id)); ?>" 
       class="btn btn-primary"
       data-bs-toggle="tooltip" 
       title="Detail Lengkap">
        <i class="bi bi-file-text"></i>
    </a>
    
    
    <button type="button" 
            class="btn btn-danger" 
            onclick="confirmDelete(<?php echo e($item->id); ?>)"
            data-bs-toggle="tooltip" 
            title="Hapus">
        <i class="bi bi-trash"></i>
    </button>
</div>

<form id="delete-form-<?php echo e($item->id); ?>" 
      action="<?php echo e(route('admin.keberatan.destroy', $item->id)); ?>" 
      method="POST" 
      style="display: none;">
    <?php echo csrf_field(); ?>
    <?php echo method_field('DELETE'); ?>
</form><?php /**PATH C:\ppid-website\resources\views/admin/keberatan/action.blade.php ENDPATH**/ ?>