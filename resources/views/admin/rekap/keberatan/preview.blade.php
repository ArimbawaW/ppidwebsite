<div class="p-3">

    <div class="table-responsive border rounded shadow-sm">
        <table class="table table-hover align-middle mb-0" style="font-size: 0.85rem;">
            <thead class="bg-light">
                <tr class="text-uppercase fw-bold text-muted">
                    <th class="text-center py-3">No</th>
                    <th>No. Registrasi</th>
                    <th>Tanggal</th>
                    <th>Nama Pemohon</th>
                    <th>Alasan</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($keberatan as $index => $item)
                <tr>
                    <td class="text-center fw-bold">{{ $index + 1 }}</td>

                    <td>
                        <div class="fw-bold">{{ $item->nomor_registrasi }}</div>
                        <div class="text-muted small">{{ $item->nomor_registrasi_permohonan }}</div>
                    </td>

                    <td>{{ $item->created_at->format('d/m/Y') }}</td>

                    <td>{{ $item->nama_pemohon }}</td>

                    <td>
                        <span class="badge rounded-pill px-3 py-2"
                              style="background-color: #0e5b73;">
                            {{ $item->alasan_keberatan_label }}
                        </span>
                    </td>

                    <td>
                        <span class="badge rounded-pill px-3 py-2 bg-success text-white">
                            {{ ucfirst($item->status) }}
                        </span>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center text-muted py-4">
                        <i class="fas fa-inbox me-2"></i> Tidak ada data keberatan
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="alert alert-info mt-3 border-0 d-flex align-items-center"
         style="background-color: #e3f7fc; border-radius: 10px;">
        <i class="fas fa-info-circle me-2 text-info"></i>
        <span>
            <strong>Total: {{ count($keberatan) }} data</strong> akan di-export ke Excel
        </span>
    </div>

</div>
