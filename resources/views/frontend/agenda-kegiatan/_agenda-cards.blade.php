<div class="row g-4">
@foreach($agendaList as $agenda)
    <div class="col-md-4 agenda-col">
        <div class="agenda-card-modern">

            <!-- DATE SECTION -->
            <div class="agenda-date-big">
                <div class="agenda-day-number">
                    {{ $agenda->tanggal->format('d') }}
                    {{ $agenda->tanggal->locale('id')->isoFormat('MMMM') }}
                </div>
                <div class="agenda-day-name">
                    {{ $agenda->tanggal->locale('id')->isoFormat('dddd') }}
                </div>
            </div>

            <!-- CONTENT -->
            <div class="agenda-content">
                <h6 class="agenda-title-modern">
                    {{ $agenda->judul }}
                </h6>

                @if($agenda->lokasi)
                <div class="agenda-location text-muted">
                    <i class="bi bi-geo-alt me-1"></i> {{ $agenda->lokasi }}
                </div>
                @endif

                @if($agenda->waktu_mulai)
                <div class="agenda-time text-muted">
                    <i class="bi bi-clock me-1"></i>
                    {{ date('H:i', strtotime($agenda->waktu_mulai)) }}
                    @if($agenda->waktu_selesai)
                        - {{ date('H:i', strtotime($agenda->waktu_selesai)) }}
                    @endif
                </div>
                @endif
            </div>

            <!-- FOOTER -->
            <div class="agenda-footer">
                <span class="agenda-badge-modern
                    @if($agenda->status === 'upcoming') badge-upcoming
                    @elseif($agenda->status === 'ongoing') badge-ongoing
                    @else badge-finished @endif">
                    @if($agenda->status === 'upcoming')
                        Akan Berlangsung
                    @elseif($agenda->status === 'ongoing')
                        Sedang Berlangsung
                    @else
                        Selesai
                    @endif
                </span>

                <button class="agenda-detail-link"
                        data-bs-toggle="modal"
                        data-bs-target="#modalAgenda{{ $agenda->id }}">
                    <i class="bi bi-info-circle me-1"></i> Detail
                </button>
            </div>

        </div>
    </div>
@endforeach
</div>
