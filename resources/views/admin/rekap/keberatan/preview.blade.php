@extends('layouts.admin')

@section('title', 'Preview Data Keberatan')

@section('content')
<div class="page-header mb-4">
    <div>
        <h2 class="fw-bold">Preview Data Keberatan</h2>
        <p class="text-muted">
            Periode: {{ date('d/m/Y', strtotime($validated['tanggal_mulai'])) }} - {{ date('d/m/Y', strtotime($validated['tanggal_akhir'])) }}
            @if(isset($validated['status']) && $validated['status'])
                | Status: <span class="badge bg-primary">{{ ucfirst($validated['status']) }}</span>
            @endif
        </p>
    </div>
</div>

{{-- Summary Cards --}}
<div class="row mb-4">
    <div class="col-md-3">
        <div class="card bg-primary text-white">
            <div class="card-body">
                <h6 class="card-title">Total Keberatan</h6>
                <h2 class="mb-0">{{ $keberatan->count() }}</h2>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-warning text-dark">
            <div class="card-body">
                <h6 class="card-title">Pending</h6>
                <h2 class="mb-0">{{ $keberatan->where('status', 'pending')->count() }}</h2>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-info text-white">
            <div class="card-body">
                <h6 class="card-title">Diproses</h6>
                <h2 class="mb-0">{{ $keberatan->where('status', 'diproses')->count() }}</h2>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-success text-white">
            <div class="card-body">
                <h6 class="card-title">Selesai</h6>
                <h2 class="mb-0">{{ $keberatan->where('status', 'selesai')->count() }}</h2>
            </div>
        </div>
    </div>
</div>

{{-- Action Buttons --}}
<div class="mb-3">
    <form action="{{ route('admin.rekap.keberatan.export') }}" method="POST" class="d-inline">
        @csrf
        <input type="hidden" name="tanggal_mulai" value="{{ $validated['tanggal_mulai'] }}">
        <input type="hidden" name="tanggal_akhir" value="{{ $validated['tanggal_akhir'] }}">
        @if(isset($validated['status']))
            <input type="hidden" name="status" value="{{ $validated['status'] }}">
        @endif
        
        <button type="submit" class="btn btn-success">
            <i class="bi bi-file-earmark-excel me-1"></i>Export ke Excel ({{ $keberatan->count() }} data)
        </button>
    </form>
    
    <a href="{{ route('admin.rekap.keberatan.index') }}" class="btn btn-secondary">
        <i class="bi bi-arrow-left me-1"></i>Kembali ke Filter
    </a>
</div>

{{-- Data Table --}}
<div class="card shadow-sm">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-hover table-sm" id="previewTable">
                <thead class="table-light">
                    <tr>
                        <th class="text-center" width="40">No</th>
                        <th>No. Registrasi</th>
                        <th>Tanggal</th>
                        <th>Nama Pemohon</th>
                        <th>Alasan</th>
                        <th class="text-center">Status</th>
                        <th>Tanggapan PPID</th>
                        <th>Tanggapan Pemohon</th>
                        <th>Mediasi</th>
                        <th>Putusan Pengadilan</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($keberatan as $index => $item)
                        <tr>
                            <td class="text-center">{{ $index + 1 }}</td>
                            <td>
                                <strong>{{ $item->nomor_registrasi }}</strong><br>
                                <small class="text-muted">Permohonan: {{ $item->nomor_registrasi_permohonan ?? '-' }}</small>
                            </td>
                            <td>
                                <small>{{ $item->created_at->format('d/m/Y H:i') }}</small>
                            </td>
                            <td>
                                <strong>{{ $item->nama_pemohon }}</strong><br>
                                <small class="text-muted">{{ $item->email }}</small>
                            </td>
                            <td>
                                <small>{{ Str::limit($item->alasan_keberatan_label, 50) }}</small>
                            </td>
                            <td class="text-center">
                                @switch($item->status)
                                    @case('pending')
                                        <span class="badge bg-warning text-dark">Pending</span>
                                        @break
                                    @case('diproses')
                                        <span class="badge bg-info">Diproses</span>
                                        @break
                                    @case('selesai')
                                        <span class="badge bg-success">Selesai</span>
                                        @break
                                    @default
                                        <span class="badge bg-danger">Ditolak</span>
                                @endswitch
                            </td>
                            <td>
                                @if($item->tanggapan_atasan_ppid)
                                    <i class="bi bi-check-circle text-success"></i>
                                    <small>{{ Str::limit($item->tanggapan_atasan_ppid, 30) }}</small>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td>
                                @if($item->tanggapan_pemohon)
                                    <i class="bi bi-check-circle text-success"></i>
                                    <small>{{ Str::limit($item->tanggapan_pemohon, 30) }}</small>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td>
                                @if($item->keputusan_mediasi)
                                    <i class="bi bi-check-circle text-success"></i>
                                    <small>{{ Str::limit($item->keputusan_mediasi, 30) }}</small>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td>
                                @if($item->putusan_pengadilan)
                                    <i class="bi bi-check-circle text-success"></i>
                                    <small>{{ Str::limit($item->putusan_pengadilan, 30) }}</small>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="10" class="text-center py-4">
                                <i class="bi bi-inbox fs-1 text-muted"></i>
                                <p class="text-muted mt-2 mb-0">Tidak ada data keberatan pada periode ini</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@if($keberatan->count() > 0)
<div class="alert alert-info mt-3">
    <i class="bi bi-info-circle me-2"></i>
    Preview menampilkan <strong>{{ $keberatan->count() }}</strong> data keberatan. 
    File Excel akan berisi semua detail lengkap termasuk uraian keberatan, tanggapan lengkap, dan informasi tambahan lainnya.
</div>
@endif
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    $('#previewTable').DataTable({
        pageLength: 25,
        language: {
            search: "Cari:",
            lengthMenu: "Tampilkan _MENU_ data",
            info: "Menampilkan _START_ - _END_ dari _TOTAL_ data",
            paginate: {
                previous: "‹",
                next: "›"
            }
        },
        order: [[2, 'desc']] // Sort by tanggal
    });
});
</script>
@endpush