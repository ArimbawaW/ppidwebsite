@extends('layouts.admin')

@section('title', 'Manajemen Standar Layanan')

@section('styles')
<style>
    button, a.btn, .btn {
        display: inline-block !important;
        opacity: 1 !important;
        visibility: visible !important;
    }

    .table td:nth-child(3) {
        text-align: center !important;
        vertical-align: middle !important;
    }
</style>
@endsection

@section('content')

<!-- PAGE HEADER -->
<div class="page-header">
    <div>
        <h2>Kelola Standar Layanan</h2>
    </div>
    <div>
        <a href="{{ route('admin.standar-layanan.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle"></i> Tambah Standar Layanan
        </a>
    </div>
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<!-- MAIN CARD -->
<div class="card">
    <div class="card-header">
        <h5>Daftar Standar Layanan</h5>
    </div>

    <div class="card-body">

        <!-- Search -->
        <form method="GET" action="{{ route('admin.standar-layanan.index') }}" class="mb-3">
            <div class="row g-2">
                <div class="col-md-8">
                    <input type="text"
                           name="search"
                           class="form-control"
                           placeholder="Cari nama layanan..."
                           value="{{ request('search') }}">
                </div>
                <div class="col-md-4">
                    <button type="submit" class="btn btn-secondary">
                        <i class="bi bi-search"></i> Cari
                    </button>
                    <a href="{{ route('admin.standar-layanan.index') }}" class="btn btn-outline-secondary">
                        Reset
                    </a>
                </div>
            </div>
        </form>

        <!-- Table -->
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th width="5%">No</th>
                        <th width="65%">Nama Layanan</th>
                        <th width="10%" class="text-center">Urutan</th>
                        <th width="20%">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($standarLayanan as $index => $layanan)
                        <tr>
                            <td>{{ $standarLayanan->firstItem() + $index }}</td>
                            <td>{{ $layanan->nama_layanan }}</td>
                            <td class="text-center">
                                <span class="badge bg-secondary">
                                    {{ $layanan->urutan }}
                                </span>
                            </td>
                            <td>
                                <div class="d-flex gap-1">
                                    <a href="{{ route('admin.standar-layanan.edit', $layanan) }}"
                                       class="btn btn-warning btn-sm"
                                       title="Edit">
                                        <i class="bi bi-pencil"></i>
                                    </a>

                                    <form action="{{ route('admin.standar-layanan.destroy', $layanan) }}"
                                          method="POST"
                                          onsubmit="return confirm('Yakin ingin menghapus standar layanan ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="btn btn-danger btn-sm"
                                                title="Hapus">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center py-4">
                                <i class="bi bi-inbox fs-1 text-muted"></i>
                                <p class="text-muted mb-0">Belum ada data standar layanan</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="d-flex justify-content-between align-items-center mt-3">
            <div>
                Menampilkan {{ $standarLayanan->firstItem() ?? 0 }} -
                {{ $standarLayanan->lastItem() ?? 0 }}
                dari {{ $standarLayanan->total() }} data
            </div>
            {{ $standarLayanan->links() }}
        </div>

    </div>
</div>

@endsection
