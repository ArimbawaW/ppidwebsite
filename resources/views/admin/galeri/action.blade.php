<a href="{{ route('admin.galeri.edit', $item->id) }}" class="btn btn-sm btn-warning">Edit</a>
<form action="{{ route('admin.galeri.destroy', $item->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus?');">
    @csrf
    @method('DELETE')
    <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
</form>

