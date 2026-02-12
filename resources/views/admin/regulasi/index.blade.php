@extends('layouts.admin')

@section('title', 'Manajemen Regulasi')

@push('styles')
<style>
    .badge {
        display: inline-block !important;
        padding: 0.35em 0.65em !important;
        font-size: 0.875em !important;
        font-weight: 600 !important;
        border-radius: 0.25rem !important;
        white-space: nowrap !important;
    }

    .btn-action {
        padding: 0.25rem 0.5rem;
        font-size: 0.875rem;
        border-radius: 0.25rem;
        display: inline-flex;
        align-items: center;
        gap: 0.25rem;
        border: 1px solid transparent;
    }

    /* Responsive Table Wrapper */
    .table-responsive {
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
        width: 100%;
    }

    /* Mobile Responsive Adjustments */
    @media (max-width: 768px) {
        .table-responsive {
            border: 1px solid #dee2e6;
            border-radius: 0.25rem;
        }

        .table {
            min-width: 800px; /* Ensure table is scrollable on mobile */
        }

        .page-header {
            flex-direction: column;
            gap: 1rem;
        }

        .page-header > div {
            width: 100%;
        }

        .page-header .btn {
            width: 100%;
        }

        /* Filter Form Mobile */
        .filter-form .row {
            margin: 0;
        }

        .filter-form .col-md-4,
        .filter-form .col-md-3,
        .filter-form .col-md-2 {
            padding-left: 0;
            padding-right: 0;
            margin-bottom: 0.5rem;
        }

        /* Pagination on mobile */
        .pagination {
            flex-wrap: wrap;
            justify-content: center;
        }
    }

    /* Scrollbar styling for better UX */
    .table-responsive::-webkit-scrollbar {
        height: 8px;
    }

    .table-responsive::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 10px;
    }

    .table-responsive::-webkit-scrollbar-thumb {
        background: #888;
        border-radius: 10px;
    }

    .table-responsive::-webkit-scrollbar-thumb:hover {
        background: #555;
    }
</style>
@endpush

@section('content')

<!-- PAGE HEADER -->
<div class="page-header d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2>Kelola Regulasi</h2>
    </div>
    <div>
        <a href="{{ route('admin.regulasi.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle me-1"></i> Tambah Regulasi
        </a>
    </div>
</div>

@if(session('success'))
<div class="alert alert-success alert-dismissible fade show">
    {{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
@endif

<!-- MAIN CARD -->
<div class="card">
    <div class="card-header">
        <h5 class="mb-0">
            <i class="bi bi-journal-text me-2"></i>
            Data Regulasi
        </h5>
    </div>

    <div class="card-body">

        <!-- FILTER -->
        <form method="GET" action="{{ route('admin.regulasi.index') }}" class="mb-4 filter-form">
            <div class="row g-2">
                <div class="col-md-4">
                    <input type="text"
                           name="search"
                           class="form-control"
                           placeholder="Cari judul atau nomor..."
                           value="{{ request('search') }}">
                </div>

                <div class="col-md-3">
                   <select name="kategori" class="form-select">
                    <option value="">Semua Kategori</option>
                     @foreach(['Undang-Undang','Peraturan Pemerintah','Peraturan Presiden','Peraturan Menteri','Peraturan Daerah','Surat Edaran','Keputusan','Lainnya'] as $kat)
                    <option value="{{ $kat }}" {{ request('kategori') == $kat ? 'selected' : '' }}>
                 {{ $kat }}
                        </option>
                     @endforeach
                    </select>
                </div>

                <div class="col-md-2">
                    <select name="status" class="form-select">
                        <option value="">Semua Status</option>
                        <option value="aktif" {{ request('status') == 'aktif' ? 'selected' : '' }}>Aktif</option>
                        <option value="tidak_aktif" {{ request('status') == 'tidak_aktif' ? 'selected' : '' }}>Tidak Aktif</option>
                    </select>
                </div>

                <div class="col-md-3">
                    <div class="d-flex gap-2">
                        <button class="btn btn-secondary flex-fill">
                            <i class="bi bi-search"></i> Filter
                        </button>
                        <a href="{{ route('admin.regulasi.index') }}" class="btn btn-outline-secondary flex-fill">
                            Reset
                        </a>
                    </div>
                </div>
            </div>
        </form>

        <!-- TABLE WITH SCROLL INDICATOR -->
        <div class="mb-2 d-md-none">
            <small class="text-muted">
                <i class="bi bi-arrow-left-right me-1"></i>
                Geser tabel ke kiri/kanan untuk melihat seluruh data
            </small>
        </div>

        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th width="5%">No</th>
                        <th width="15%" class="text-center">Kategori</th>
                        <th width="15%">Nomor</th>
                        <th width="30%">Judul</th>
                        <th width="15%" class="text-center">Tanggal Terbit</th>
                        <th width="10%" class="text-center">Status</th>
                        <th width="15%">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                @forelse($regulasi as $index => $reg)
                    <tr>
                        <td>{{ $regulasi->firstItem() + $index }}</td>

                        <td class="text-center">
                         @php
                        $kategoriClass = match($reg->kategori) {
                            'Undang-Undang' => 'bg-primary',
                            'Peraturan Pemerintah' => 'bg-success',
                            'Peraturan Presiden' => 'bg-danger',
                            'Peraturan Menteri' => 'bg-info',
                            'Peraturan Daerah' => 'bg-warning',
                            'Surat Edaran' => 'bg-info',
                            'Keputusan' => 'bg-danger',
                            default => 'bg-secondary'
                            };
                            @endphp 
                            <span class="badge {{ $kategoriClass }}">
                                {{ $reg->kategori }}
                            </span>
                        </td>

                        <td>{{ $reg->nomor ?? '-' }}</td>

                        <td>{{ Str::limit($reg->judul, 60) }}</td>

                        <td class="text-center">
                         {{ $reg->tanggal_terbit 
                        ? \Carbon\Carbon::parse($reg->tanggal_terbit)->format('d-m-Y') 
                            : '-' 
                        }}
                        </td>

                        <td class="text-center">
                            @if($reg->is_active)
                                <span class="badge bg-success">Aktif</span>
                            @else
                                <span class="badge bg-secondary">Tidak Aktif</span>
                            @endif
                        </td>

                        <td>
                            <div class="d-flex gap-1 flex-nowrap">
                                <a href="{{ route('admin.regulasi.edit', $reg) }}"
                                   class="btn-action btn btn-warning"
                                   title="Edit">
                                    <i class="bi bi-pencil"></i>
                                </a>

                                @if($reg->file)
                                <a href="{{ asset('storage/' . $reg->file) }}"
                                   target="_blank"
                                   class="btn-action btn btn-info"
                                   title="Lihat File">
                                    <i class="bi bi-eye"></i>
                                </a>
                                @endif

                                <form action="{{ route('admin.regulasi.destroy', $reg) }}"
                                      method="POST"
                                      class="d-inline"
                                      onsubmit="return confirm('Yakin ingin menghapus regulasi ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn-action btn btn-danger" title="Hapus">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center py-4 text-muted">
                            <i class="bi bi-inbox fs-1 d-block mb-2"></i>
                            Belum ada data regulasi
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>

        <!-- PAGINATION -->
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-center mt-3 gap-3">
            <div class="text-muted">
                Menampilkan {{ $regulasi->firstItem() ?? 0 }} –
                {{ $regulasi->lastItem() ?? 0 }}
                dari {{ $regulasi->total() }} data
            </div>
            <div>
                {{ $regulasi->links() }}
            </div>
        </div>

    </div>
</div>

@endsection