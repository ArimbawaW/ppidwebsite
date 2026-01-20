@extends('layouts.admin')

@section('title', 'Informasi Publik - PPID Admin')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Manajemen Informasi Publik</h1>
    <a href="{{ route('admin.informasi-publik.create') }}" class="btn btn-primary">Tambah Informasi</a>
</div>

@if(isset($informasi) && $informasi->count() > 0)
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
            @foreach($informasi as $item)
            <tr>
                <td>{{ $item->id }}</td>
                <td>{{ $item->judul }}</td>
                <td>{{ $item->kategori_label }}</td>
                <td>
                    @if($item->is_active)
                        <span class="badge status-aktif">Aktif</span>
                    @else
                        <span class="badge status-nonaktif">Tidak Aktif</span>
                    @endif
                </td>
                <td>{{ $item->download_count }}</td>
                <td>{{ $item->created_at->format('d M Y') }}</td>
                <td>
                    <a href="{{ route('admin.informasi-publik.edit', ['informasi_publik' => $item->id]) }}" class="btn btn-sm btn-warning">Edit</a>
                    <form action="{{ route('admin.informasi-publik.destroy', ['informasi_publik' => $item->id]) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    
    {{ $informasi->links() }}
</div>
@else
<div class="alert alert-info">
    Belum ada informasi publik. <a href="{{ route('admin.informasi-publik.create') }}">Tambah informasi pertama</a>
</div>
@endif

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
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        $('#informasiTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ route('admin.informasi-publik.index') }}",
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
@endpush