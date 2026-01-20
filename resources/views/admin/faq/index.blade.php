@extends('layouts.admin')

@section('title', 'Manajemen FAQ')

@section('styles')
<style>
    button, a.btn, .btn {
        display: inline-block !important;
        opacity: 1 !important;
        visibility: visible !important;
    }

    .table td:nth-child(2),
    .table td:nth-child(4),
    .table td:nth-child(5) {
        text-align: center !important;
        vertical-align: middle !important;
    }
</style>
@endsection

@section('content')

<!-- PAGE HEADER -->
<div class="page-header">
    <div>
        <h2>Manajemen FAQ</h2>
        <p>Pertanyaan yang sering diajukan oleh pengguna</p>
    </div>
    <div>
        <a href="{{ route('admin.faq.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle me-2"></i>Tambah FAQ
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
            <i class="bi bi-question-circle me-2"></i>
            Daftar FAQ
        </h5>
    </div>

    <div class="card-body">

        <!-- FILTER -->
        <form method="GET" action="{{ route('admin.faq.index') }}" class="mb-3">
            <div class="row g-2">
                <div class="col-md-6">
                    <input type="text"
                           name="search"
                           class="form-control"
                           placeholder="Cari pertanyaan atau jawaban..."
                           value="{{ request('search') }}">
                </div>

                <div class="col-md-3">
                    <select name="kategori" class="form-select">
                        <option value="">Semua Kategori</option>
                        @foreach(['Permohonan Informasi','Keberatan','Sengketa','Informasi Publik','Umum','Lainnya'] as $kat)
                            <option value="{{ $kat }}" {{ request('kategori') === $kat ? 'selected' : '' }}>
                                {{ $kat }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-3">
                    <button class="btn btn-secondary">
                        <i class="bi bi-search"></i> Filter
                    </button>
                    <a href="{{ route('admin.faq.index') }}" class="btn btn-outline-secondary">
                        Reset
                    </a>
                </div>
            </div>
        </form>

        <!-- TABLE -->
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead>
                    <tr>
                        <th width="5%">No</th>
                        <th width="15%">Kategori</th>
                        <th width="40%">Pertanyaan</th>
                        <th width="10%">Urutan</th>
                        <th width="10%">Status</th>
                        <th width="20%">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($faqs as $index => $faq)
                    <tr>
                        <td>{{ $faqs->firstItem() + $index }}</td>
                        <td>
                            <span class="badge bg-primary">{{ $faq->kategori }}</span>
                        </td>
                        <td>{{ Str::limit($faq->pertanyaan, 80) }}</td>
                        <td>
                            <span class="badge bg-secondary">{{ $faq->urutan }}</span>
                        </td>
                        <td>
                            @if($faq->is_active)
                                <span class="badge bg-success">Aktif</span>
                            @else
                                <span class="badge bg-secondary">Nonaktif</span>
                            @endif
                        </td>
                        <td>
                            <div class="d-flex gap-1">
                                <a href="{{ route('admin.faq.edit', $faq) }}"
                                   class="btn btn-warning btn-sm"
                                   title="Edit">
                                    <i class="bi bi-pencil"></i>
                                </a>

                                <button type="button"
                                        class="btn btn-info btn-sm"
                                        data-bs-toggle="modal"
                                        data-bs-target="#detailModal{{ $faq->id }}"
                                        title="Detail">
                                    <i class="bi bi-eye"></i>
                                </button>

                                <form action="{{ route('admin.faq.destroy', $faq) }}"
                                      method="POST"
                                      onsubmit="return confirm('Yakin ingin menghapus FAQ ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger btn-sm" title="Hapus">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-4 text-muted">
                            Belum ada data FAQ
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- PAGINATION -->
        <div class="d-flex justify-content-between align-items-center mt-3">
            <div>
                Menampilkan {{ $faqs->firstItem() ?? 0 }}–{{ $faqs->lastItem() ?? 0 }}
                dari {{ $faqs->total() }} data
            </div>
            {{ $faqs->links() }}
        </div>

    </div>
</div>

<!-- MODALS -->
@foreach($faqs as $faq)
<div class="modal fade" id="detailModal{{ $faq->id }}" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Detail FAQ</h5>
                <button class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p><strong>Kategori:</strong> {{ $faq->kategori }}</p>
                <p><strong>Pertanyaan:</strong><br>{{ $faq->pertanyaan }}</p>
                <p><strong>Jawaban:</strong></p>
                <div class="p-3 bg-light rounded">
                    {!! nl2br(e($faq->jawaban)) !!}
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>
@endforeach

@endsection
