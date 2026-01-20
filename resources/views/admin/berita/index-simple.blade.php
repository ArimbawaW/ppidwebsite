@extends('layouts.admin')

@section('title', 'Berita - PPID Admin')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Manajemen Berita</h1>
    <a href="{{ route('admin.berita.create') }}" class="btn btn-primary">Tambah Berita</a>
</div>

@if($berita->count() > 0)
<div class="table-responsive">
    <table class="table table-striped table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Judul</th>
                <th>Kategori</th>
                <th>Status</th>
                <th>Views</th>
                <th>Tanggal</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($berita as $item)
            <tr>
                <td>{{ $item->id }}</td>
                <td>{{ $item->judul }}</td>
                <td>{{ ucfirst($item->kategori) }}</td>
                <td>
                    @if($item->is_published)
                        <span class="badge bg-success">Published</span>
                    @else
                        <span class="badge bg-secondary">Draft</span>
                    @endif
                </td>
                <td>{{ $item->views }}</td>
                <td>{{ $item->created_at->format('d M Y') }}</td>
                <td>
                    <a href="{{ route('admin.berita.edit', $item->id) }}" class="btn btn-sm btn-warning">Edit</a>
                    <form action="{{ route('admin.berita.destroy', $item->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    
    {{ $berita->links() }}
</div>
@else
<div class="alert alert-info">
    Belum ada berita. <a href="{{ route('admin.berita.create') }}">Tambah berita pertama</a>
</div>
@endif
@endsection

