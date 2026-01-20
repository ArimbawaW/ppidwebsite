{{-- resources/views/admin/keberatan/action.blade.php --}}
<div class="btn-group btn-group-sm" role="group">
    {{-- Quick View --}}
    <button type="button" 
            class="btn btn-info text-white" 
            onclick="quickView({{ $item->id }})"
            data-bs-toggle="tooltip" 
            title="Lihat Cepat">
        <i class="bi bi-eye"></i>
    </button>
    
    {{-- Detail --}}
    <a href="{{ route('admin.keberatan.show', $item->id) }}" 
       class="btn btn-primary"
       data-bs-toggle="tooltip" 
       title="Detail Lengkap">
        <i class="bi bi-file-text"></i>
    </a>
    
    {{-- Delete --}}
    <button type="button" 
            class="btn btn-danger" 
            onclick="confirmDelete({{ $item->id }})"
            data-bs-toggle="tooltip" 
            title="Hapus">
        <i class="bi bi-trash"></i>
    </button>
</div>

<form id="delete-form-{{ $item->id }}" 
      action="{{ route('admin.keberatan.destroy', $item->id) }}" 
      method="POST" 
      style="display: none;">
    @csrf
    @method('DELETE')
</form>