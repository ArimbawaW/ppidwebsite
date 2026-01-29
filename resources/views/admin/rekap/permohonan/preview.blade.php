<div class="table-responsive">
    <table class="table table-bordered table-hover table-sm">
        <thead class="table-light">
            <tr>
                <th width="50">No</th>
                <th>No. Registrasi</th>
                <th>Tanggal</th>
                <th>Kategori</th>
                <th>Nama</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse($permohonan as $index => $item)
            <tr>
                <td class="text-center">{{ $index + 1 }}</td>
                <td>{{ $item->nomor_registrasi }}</td>
                <td>{{ $item->created_at->format('d/m/Y') }}</td>
                <td>
                    <span class="badge bg-primary">{{ $item->kategori_label }}</span>
                </td>
                <td>{{ $item->nama }}</td>
                <td>
                    <span class="badge bg-{{ $item->status_color }}">
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
    <strong>Total: {{ count($permohonan) }} data</strong> akan di-export ke Excel
</div>