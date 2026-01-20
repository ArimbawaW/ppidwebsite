@if($agendaKegiatan->count() > 0)
<div class="agenda-section">
    <div class="container">
        <div class="agenda-title-section mb-5">
            <h3>
                Agenda<br>Kegiatan
                <small>{{ now()->locale('id')->isoFormat('MMMM YYYY') }}</small>
            </h3>
        </div>

        <div class="row g-4">
            @foreach($agendaKegiatan as $agenda)
            <div class="col-md-4 agenda-col">
                <div class="agenda-card">
                    
                    <div>
                        <div class="agenda-date">
                            {{ $agenda->tanggal->format('d') }} {{ $agenda->tanggal->locale('id')->isoFormat('MMMM') }}
                        </div>
                        <div class="agenda-month">
                            {{ $agenda->tanggal->locale('id')->isoFormat('dddd') }}
                        </div>

                        <h6 class="agenda-title">{{ $agenda->judul }}</h6>

                        @if($agenda->lokasi)
                        <div class="agenda-subtitle">{{ $agenda->lokasi }}</div>
                        @endif

                        @if($agenda->waktu_mulai)
                        <div class="agenda-subtitle">
                            {{ date('H:i', strtotime($agenda->waktu_mulai)) }}
                            @if($agenda->waktu_selesai)
                                - {{ date('H:i', strtotime($agenda->waktu_selesai)) }}
                            @endif
                        </div>
                        @endif

                        <span class="agenda-badge">
                            @if($agenda->status == 'upcoming')
                                Akan Berlangsung
                            @elseif($agenda->status == 'ongoing')
                                Sedang Berlangsung
                            @else
                                Selesai
                            @endif
                        </span>
                    </div>

                    <!-- Tombol Detail -->
                    <div class="agenda-detail-btn">
                        <button class="btn btn-sm btn-detail"
                                data-bs-toggle="modal"
                                data-bs-target="#modalAgenda{{ $agenda->id }}">
                            <i class="bi bi-info-circle me-1"></i> Detail
                        </button>
                    </div>

                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>

<!-- MODAL -->
@foreach($agendaKegiatan as $agenda)
<div class="modal fade" id="modalAgenda{{ $agenda->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header" style="background: linear-gradient(to right, #1a6b8a, #003344); color: white;">
                <h5 class="modal-title fw-bold">
                    <i class="bi bi-calendar-event me-2"></i>
                    {{ $agenda->judul }}
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body p-4">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <small class="text-muted">Tanggal</small>
                        <strong class="d-block">
                            {{ $agenda->tanggal->locale('id')->isoFormat('dddd, D MMMM YYYY') }}
                        </strong>
                    </div>

                    @if($agenda->waktu_mulai)
                    <div class="col-md-6">
                        <small class="text-muted">Waktu</small>
                        <strong class="d-block">
                            {{ date('H:i', strtotime($agenda->waktu_mulai)) }}
                            @if($agenda->waktu_selesai)
                                - {{ date('H:i', strtotime($agenda->waktu_selesai)) }}
                            @endif
                            WIB
                        </strong>
                    </div>
                    @endif
                </div>

                @if($agenda->lokasi)
                <p><strong>Lokasi:</strong> {{ $agenda->lokasi }}</p>
                @endif

                <hr>

                <h6 class="fw-bold mb-2">Deskripsi Kegiatan</h6>
                @if($agenda->deskripsi)
                    <p class="text-justify" style="line-height:1.8; white-space: pre-line;">
                        {{ $agenda->deskripsi }}
                    </p>
                @else
                    <p class="text-muted fst-italic">Tidak ada deskripsi.</p>
                @endif
            </div>

            <div class="modal-footer">
                <button class="btn btn-danger" data-bs-dismiss="modal">
                    Tutup
                </button>
            </div>
        </div>
    </div>
</div>

@endforeach

<style>
.agenda-col {
    display: flex;
}

.agenda-card {
    position: relative;
    height: 100%;
    min-height: 270px;
    width: 100%;
    max-width: 100%;
    display: flex;
    flex-direction: column;
    padding: 20px 20px 70px;
    overflow: hidden;
}

/* FIX TEKS PANJANG */
.agenda-title,
.agenda-subtitle {
    word-break: break-word;
    overflow-wrap: break-word;
    white-space: normal;
}

/* Batasi judul */
.agenda-title {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

/* Tombol */
.agenda-detail-btn {
    position: absolute;
    bottom: 15px;
    right: 15px;
}

</style>
@endif