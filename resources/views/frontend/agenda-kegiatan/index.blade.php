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

                    {{-- JUDUL --}}
                    <h6 class="agenda-title-modern"
                        title="{{ $item->judul }}">
                        {{ $item->judul }}
                    </h6>

                    {{-- WAKTU --}}
                    @if($item->waktu_mulai)
                    <div class="agenda-meta">
                        <i class="bi bi-clock"></i>
                        {{ date('H:i', strtotime($item->waktu_mulai)) }}
                    </div>
                    @endif

                    {{-- STATUS --}}
                    <span class="agenda-badge-modern">
                        @if($item->status == 'upcoming')
                            Akan Berlangsung
                        @elseif($item->status == 'ongoing')
                            Sedang Berlangsung
                        @else
                            Selesai
                        @endif
                    </span>
                </div>

                {{-- DETAIL BUTTON --}}
                <div class="agenda-detail-btn-modern">
                    <button class="btn btn-link p-0"
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
    <div class="mt-4">
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
            </div>
        </div>
    </div>
</div>
@endforeach
@endsection