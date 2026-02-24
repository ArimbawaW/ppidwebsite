@extends('layouts.app')

@section('content')

<!-- ================= HERO SECTION (MASTER TEMPLATE) ================= -->
<section class="hero-section">
    <div class="container hero-container">
        <div class="row align-items-center">
            <div class="col-md-8">
                <h1 class="text-white fw-bold mb-1">Agenda Kegiatan</h1>
                <p class="text-white-50 mb-0">
                    Jadwal kegiatan dan acara yang akan dilaksanakan
                </p>
            </div>
            <div class="col-md-4 text-end d-none d-md-block">
                <i class="bi bi-calendar-event text-white icon-hero"></i>
            </div>
        </div>
    </div>
</section>

<!-- ================= CONTENT ================= -->
<div class="container py-4">

    {{-- ================= SEARCH BAR ================= --}}
    <form method="GET"
          action="{{ route('frontend.agenda-kegiatan.index') }}"
          class="mb-4">

        <div class="input-group shadow-sm">
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
            <small class="text-muted d-block mt-1">
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

                    {{-- JUDUL --}}
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

                {{-- DETAIL BUTTON --}}
                <div class="agenda-detail-btn-modern">
                    <button class="btn btn-link p-0 text-decoration-none"
                            data-bs-toggle="modal"
                            data-bs-target="#modalAgenda{{ $item->id }}">
                        <i class="bi bi-info-circle"></i> Detail
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
    <div class="mt-4 d-flex justify-content-center pagination-wrapper">
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

{{-- ================= STYLES ================= --}}
<style>
/* ========================================
   HERO SECTION (MASTER TEMPLATE)
   ======================================== */

.hero-section {
    position: relative;
    background: linear-gradient(135deg, #1a6b8a 0%, #003344 100%);
    overflow: hidden;
    display: flex;
    align-items: center;
    min-height: 120px;
    padding: 32px 0;
    z-index: 1;
}

.hero-section::before {
    content: "";
    position: absolute;
    inset: 0;
    background-image: url('{{ asset("images/Pattern - Midnight Green.png") }}');
    background-size: 180px;
    background-repeat: repeat;
    mix-blend-mode: overlay;
    opacity: 0.35;
    z-index: -1;
    pointer-events: none;
}

.hero-container {
    position: relative;
    z-index: 10;
}

.hero-section h1 {
    font-size: 1.9rem;
    line-height: 1.2;
}

.hero-section p {
    font-size: 0.95rem;
}

.icon-hero {
    font-size: 64px;
    opacity: 0.18;
}

/* ========================================
   AGENDA CARD FIX
   ======================================== */

.agenda-card-modern {
    display: flex;
    flex-direction: column;
    height: 100%;
    min-height: 280px;
}

.agenda-card-modern > div:first-child {
    flex: 1;
}

.agenda-detail-btn-modern {
    margin-top: auto;
    padding-top: 0.5rem;
}

.agenda-detail-btn-modern .btn {
    font-size: 0.85rem;
    color: #0d6efd;
}

.agenda-detail-btn-modern .btn:hover {
    color: #0a58ca;
}

.agenda-title-modern {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
    text-overflow: ellipsis;
    line-height: 1.4;
}

/* ========================================
   PAGINATION CLEAN
   ======================================== */

.pagination svg,
.pagination i,
.pagination .bi {
    display: none !important;
}

.pagination .page-link {
    font-size: 0.9rem;
    padding: 0.5rem 0.75rem;
    min-width: 40px;
    text-align: center;
    border: 1px solid #dee2e6;
    color: #0d6efd;
}

.pagination .page-item.active .page-link {
    background-color: #0d6efd;
    border-color: #0d6efd;
    color: white;
}

.pagination .page-item.disabled .page-link {
    color: #6c757d;
    background-color: #fff;
}

.pagination .page-item:first-child .page-link,
.pagination .page-item:last-child .page-link {
    font-size: 0 !important;
}

.pagination .page-item:first-child .page-link::after {
    content: "‹ Prev";
    font-size: 0.9rem;
}

.pagination .page-item:last-child .page-link::after {
    content: "Next ›";
    font-size: 0.9rem;
}

/* ========================================
   RESPONSIVE
   ======================================== */

@media (max-width: 768px) {
    .hero-section {
        min-height: 100px;
        padding: 24px 0;
        text-align: center;
    }

    .hero-section h1 {
        font-size: 1.5rem;
    }

    .hero-section p {
        font-size: 0.85rem;
    }

    .icon-hero {
        display: none;
    }

    .hero-section::before {
        background-size: 140px;
    }
}
</style>

@endsection
