<div class="table-responsive">
    <table class="table table-bordered table-hover table-sm">
        <thead class="table-light">
            <tr>
                <th width="50">No</th>
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
                <td class="text-center">{{ $index + 1 }}</td>
                <td>{{ $item->nomor_registrasi }}</td>
                <td>{{ $item->created_at->format('d/m/Y') }}</td>
                <td>{{ $item->nama_pemohon }}</td>
                <td><small>{{ Str::limit($item->alasan_keberatan_label, 30) }}</small></td>
                <td>
                    <span class="badge bg-{{ $item->status == 'pending' ? 'warning' : ($item->status == 'selesai' ? 'success' : ($item->status == 'ditolak' ? 'danger' : 'info')) }}">
                        {{ $item->status_label }}
                    </span>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="text-center text-muted">
                    Tidak ada data sesuai filter
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="alert alert-info mt-3">
    <i class="fas fa-info-circle me-2"></i>
    <strong>Total: {{ count($keberatan) }} data</strong> akan di-export ke Excel
</div>