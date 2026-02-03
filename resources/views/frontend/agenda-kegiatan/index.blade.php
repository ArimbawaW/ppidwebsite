@extends('layouts.app')

@section('content')
<div class="container py-5">

    {{-- ================= SEARCH BAR ================= --}}
    <form method="GET"
          action="{{ route('frontend.agenda-kegiatan.index') }}"
          class="mb-4">

        <div class="input-group">
            <input type="text"
                   name="q"
                   value="{{ request('q') }}"
                   class="form-control"
                   placeholder="Cari agenda kegiatan...">

            <button class="btn btn-primary">
                <i class="bi bi-search"></i>
            </button>
        </div>

        @if(request('q'))
            <small class="text-muted">
                Hasil pencarian untuk: <strong>{{ request('q') }}</strong>
            </small>
        @endif
    </form>

    {{-- ================= LIST AGENDA ================= --}}
    <div class="row g-4">

        @forelse($agenda as $item)
        <div class="col-md-4 agenda-col">
            <div class="agenda-card-modern">

                <div>
                    {{-- TANGGAL --}}
                    <div class="agenda-date-modern">
                        {{ $item->tanggal->format('d') }}
                        <span>{{ $item->tanggal->locale('id')->isoFormat('MMMM') }}</span>
                    </div>

                    <div class="agenda-day-modern">
                        {{ $item->tanggal->locale('id')->isoFormat('dddd') }}
                    </div>

                    {{-- JUDUL WITH TEXT TRUNCATION --}}
                    <h6 class="agenda-title-modern"
                        title="{{ $item->judul }}">
                        {{ Str::limit($item->judul, 50) }}
                    </h6>

                    {{-- WAKTU --}}
                    @if($item->waktu_mulai)
                    <div class="agenda-meta">
                        <i class="bi bi-clock"></i>
                        {{ date('H:i', strtotime($item->waktu_mulai)) }}
                    </div>
                    @endif

                    {{-- STATUS BADGE --}}
                    <span class="agenda-badge-modern">
                        {{ $item->status_badge }}
                    </span>
                </div>

                {{-- DETAIL BUTTON - FIXED SIZE --}}
                <div class="agenda-detail-btn-modern">
                    <button class="btn btn-link p-0 text-decoration-none"
                            style="font-size: 0.875rem;"
                            data-bs-toggle="modal"
                            data-bs-target="#modalAgenda{{ $item->id }}">
                        <i class="bi bi-info-circle" style="font-size: 1rem;"></i> Detail
                    </button>
                </div>
            </div>
        </div>
        @empty
            <div class="col-12">
                <div class="alert alert-warning text-center">
                    Agenda tidak ditemukan.
                </div>
            </div>
        @endforelse
    </div>

    {{-- ================= PAGINATION ================= --}}
    <div class="mt-4 d-flex justify-content-center">
        {{ $agenda->links() }}
    </div>
</div>

{{-- ================= MODAL DETAIL ================= --}}
@foreach($agenda as $item)
<div class="modal fade" id="modalAgenda{{ $item->id }}" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">
                    {{ $item->judul }}
                </h5>
                <button class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <p>
                    <strong>Tanggal:</strong>
                    {{ $item->tanggal->locale('id')->isoFormat('dddd, D MMMM YYYY') }}
                </p>

                @if($item->waktu_mulai)
                <p>
                    <strong>Waktu:</strong>
                    {{ date('H:i', strtotime($item->waktu_mulai)) }} WIB
                </p>
                @endif

                @if($item->lokasi)
                <p><strong>Lokasi:</strong> {{ $item->lokasi }}</p>
                @endif

                <hr>

                <p style="white-space: pre-line;">
                    {{ $item->deskripsi ?? 'Tidak ada deskripsi.' }}
                </p>

                {{-- STATUS BADGE --}}
                <div class="mt-3">
                    <span class="badge {{ $item->status_badge_class }}">
                        {{ $item->status_badge }}
                    </span>
                </div>
            </div>
        </div>
    </div>
</div>
@endforeach

{{-- ================= CUSTOM STYLES ================= --}}
<style>
    /* Fix button size in agenda cards */
    .agenda-detail-btn-modern {
        margin-top: auto;
        padding-top: 0.5rem;
    }

    .agenda-detail-btn-modern .btn {
        font-size: 0.875rem !important;
        line-height: 1.5;
        color: #0d6efd;
    }
    
    .agenda-detail-btn-modern .btn i {
        font-size: 1rem !important;
        vertical-align: middle;
    }

    .agenda-detail-btn-modern .btn:hover {
        color: #0a58ca;
    }

    /* Ensure agenda cards have consistent height */
    .agenda-card-modern {
        display: flex;
        flex-direction: column;
        height: 100%;
        min-height: 280px;
    }

    .agenda-card-modern > div:first-child {
        flex: 1;
    }

    /* Fix title text overflow */
    .agenda-title-modern {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        text-overflow: ellipsis;
        word-wrap: break-word;
        line-height: 1.4;
    }

    /* ========== COMPLETE PAGINATION FIX ========== */
    
    /* Hide ALL SVG and icons in pagination */
    .pagination svg {
        display: none !important;
        width: 0 !important;
        height: 0 !important;
        visibility: hidden !important;
    }

    .pagination .page-link svg {
        display: none !important;
    }

    /* Force hide any icon elements */
    .pagination i,
    .pagination .bi,
    .pagination [class*="icon"] {
        display: none !important;
    }

    /* Reset pagination link styling */
    .pagination .page-link {
        font-size: 0.9rem !important;
        padding: 0.5rem 0.75rem !important;
        min-width: 40px;
        text-align: center;
        border: 1px solid #dee2e6;
        color: #0d6efd;
    }

    /* Style for active page */
    .pagination .page-item.active .page-link {
        background-color: #0d6efd;
        border-color: #0d6efd;
        color: white;
    }

    /* Style for disabled items */
    .pagination .page-item.disabled .page-link {
        color: #6c757d;
        pointer-events: none;
        background-color: #fff;
        border-color: #dee2e6;
    }

    /* Override any inline styles that might add icons */
    .pagination * {
        background-image: none !important;
    }

    /* Pagination wrapper */
    .pagination {
        margin-bottom: 0 !important;
        gap: 5px;
    }

    /* Remove any pseudo-elements that might be adding icons */
    .pagination .page-link::before,
    .pagination .page-link::after {
        content: none !important;
    }

    /* Specifically target Laravel's pagination arrows */
    .pagination .page-item:first-child .page-link,
    .pagination .page-item:last-child .page-link {
        font-size: 0 !important; /* Hide default text */
    }

    /* Add simple text arrows */
    .pagination .page-item:first-child .page-link::after {
        content: "‹ Prev" !important;
        font-size: 0.9rem !important;
        display: inline-block !important;
    }

    .pagination .page-item:last-child .page-link::after {
        content: "Next ›" !important;
        font-size: 0.9rem !important;
        display: inline-block !important;
    }

    /* Make sure the container doesn't overflow */
    .pagination-wrapper {
        overflow: hidden;
    }
</style>

@endsection