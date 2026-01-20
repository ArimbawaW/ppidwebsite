{{-- resources/views/admin/keberatan/quick-view.blade.php --}}
<div class="row">
    <div class="col-md-6">
        <h6 class="fw-bold">Informasi Dasar</h6>
        <table class="table table-sm table-borderless">
            <tr>
                <td width="40%"><strong>No. Registrasi:</strong></td>
                <td>{{ $keberatan->nomor_registrasi }}</td>
            </tr>
            <tr>
                <td><strong>No. Permohonan:</strong></td>
                <td>{{ $keberatan->nomor_registrasi_permohonan }}</td>
            </tr>
            <tr>
                <td><strong>Nama Pemohon:</strong></td>
                <td>{{ $keberatan->nama_pemohon }}</td>
            </tr>
            <tr>
                <td><strong>Nomor Kontak:</strong></td>
                <td>{{ $keberatan->nomor_kontak }}</td>
            </tr>
            <tr>
                <td><strong>Pekerjaan:</strong></td>
                <td>{{ $keberatan->pekerjaan }}</td>
            </tr>
        </table>
    </div>
    
    <div class="col-md-6">
        <h6 class="fw-bold">Status & Alasan</h6>
        <table class="table table-sm table-borderless">
            <tr>
                <td width="40%"><strong>Status:</strong></td>
                <td>
                    @if($keberatan->status == 'pending')
                        <span class="badge bg-warning text-dark">Pending</span>
                    @elseif($keberatan->status == 'diproses')
                        <span class="badge bg-info">Diproses</span>
                    @elseif($keberatan->status == 'selesai')
                        <span class="badge bg-success">Selesai</span>
                    @else
                        <span class="badge bg-danger">Ditolak</span>
                    @endif
                </td>
            </tr>
            <tr>
                <td><strong>Alasan:</strong></td>
                <td>
                    <small>{{ $keberatan->alasan_keberatan_label }}</small>
                </td>
            </tr>
            <tr>
                <td><strong>Tanggal:</strong></td>
                <td>{{ $keberatan->created_at->format('d M Y H:i') }}</td>
            </tr>
        </table>
    </div>
</div>

<hr>

<div class="mb-3">
    <h6 class="fw-bold">Uraian Keberatan:</h6>
    <div class="p-3 bg-light rounded">
        <small style="white-space: pre-line;">{{ Str::limit($keberatan->uraian_keberatan, 300) }}</small>
    </div>
</div>

<div class="text-end">
    <a href="{{ route('admin.keberatan.show', $keberatan->id) }}" 
       class="btn btn-primary btn-sm">
        <i class="bi bi-arrow-right me-1"></i>
        Lihat Detail Lengkap
    </a>
</div>