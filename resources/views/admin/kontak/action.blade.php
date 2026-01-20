<a href="{{ route('admin.kontak.show', $item->id) }}" class="btn btn-sm btn-info">Detail</a>
<form action="{{ route('admin.kontak.destroy', $item->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus?');">
    @csrf
    @method('DELETE')
    <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
</form>

