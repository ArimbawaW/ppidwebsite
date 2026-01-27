@foreach($agendaList as $agenda)
<div class="modal fade" id="modalAgenda{{ $agenda->id }}" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-header"
                 style="background:linear-gradient(to right,#1a6b8a,#003344); color:white;">
                <h5 class="modal-title fw-bold">
                    <i class="bi bi-calendar-event me-2"></i>
                    {{ $agenda->judul }}
                </h5>
                <button type="button"
                        class="btn-close btn-close-white"
                        data-bs-dismiss="modal"></button>
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
                    <p style="line-height:1.8; white-space:pre-line;">
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
