@extends('layouts.admin')

@section('title', 'Rekap Data Keberatan')

@push('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.min.css">
<style>
    .stat-card { border-left: 4px solid; transition: transform 0.2s; }
    .stat-card:hover { transform: translateY(-5px); box-shadow: 0 4px 15px rgba(0,0,0,0.1); }
    .stat-card.primary { border-left-color: #007bff; }
    .stat-card.success { border-left-color: #28a745; }
    .stat-card.warning { border-left-color: #ffc107; }
    .stat-card.danger { border-left-color: #dc3545; }
    .chart-container { position: relative; height: 300px; }
</style>
@endpush

@section('content')
<div class="container-fluid">
    
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800">
                <i class="fas fa-chart-bar me-2"></i>Rekap Data Keberatan
            </h1>
            <p class="text-muted mb-0">Laporan dan statistik keberatan</p>
        </div>
        <a href="{{ route('admin.keberatan.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-2"></i>Kembali
        </a>
    </div>

    <!-- Statistics Cards -->
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card stat-card primary shadow h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="text-muted small mb-1">Total Keberatan</div>
                            <div class="h3 mb-0 fw-bold text-primary">{{ number_format($stats['total']) }}</div>
                        </div>
                        <div class="text-primary" style="font-size: 3rem; opacity: 0.3;">
                            <i class="fas fa-exclamation-triangle"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card stat-card warning shadow h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="text-muted small mb-1">Pending</div>
                            <div class="h3 mb-0 fw-bold text-warning">{{ number_format($stats['pending']) }}</div>
                        </div>
                        <div class="text-warning" style="font-size: 3rem; opacity: 0.3;">
                            <i class="fas fa-hourglass-half"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card stat-card success shadow h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="text-muted small mb-1">Selesai</div>
                            <div class="h3 mb-0 fw-bold text-success">{{ number_format($stats['selesai']) }}</div>
                        </div>
                        <div class="text-success" style="font-size: 3rem; opacity: 0.3;">
                            <i class="fas fa-check-circle"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card stat-card danger shadow h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="text-muted small mb-1">Ditolak</div>
                            <div class="h3 mb-0 fw-bold text-danger">{{ number_format($stats['ditolak']) }}</div>
                        </div>
                        <div class="text-danger" style="font-size: 3rem; opacity: 0.3;">
                            <i class="fas fa-times-circle"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts -->
    <div class="row mb-4">
        <div class="col-xl-8 mb-4">
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 fw-bold text-primary">
                        <i class="fas fa-chart-line me-2"></i>Trend Keberatan Tahun {{ $currentYear }}
                    </h6>
                </div>
                <div class="card-body">
                    <div class="chart-container">
                        <canvas id="keberatanChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-4 mb-4">
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 fw-bold text-primary">
                        <i class="fas fa-chart-pie me-2"></i>Distribusi Status
                    </h6>
                </div>
                <div class="card-body">
                    <div class="chart-container">
                        <canvas id="statusChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Export Section -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 fw-bold text-primary">
                <i class="fas fa-file-export me-2"></i>Export Data ke Excel
            </h6>
        </div>
        <div class="card-body">
            <form id="exportForm" method="POST" target="_blank">
                @csrf
                
                <div class="row">
                    <div class="col-md-3 mb-3">
                        <label class="form-label fw-bold">Tanggal Mulai</label>
                        <input type="date" name="tanggal_mulai" class="form-control" id="tanggal_mulai">
                    </div>

                    <div class="col-md-3 mb-3">
                        <label class="form-label fw-bold">Tanggal Selesai</label>
                        <input type="date" name="tanggal_selesai" class="form-control" id="tanggal_selesai">
                    </div>

                    <div class="col-md-3 mb-3">
                        <label class="form-label fw-bold">Status</label>
                        <select name="status" class="form-select" id="status">
                            <option value="semua">Semua Status</option>
                            <option value="pending">Pending</option>
                            <option value="diproses">Diproses</option>
                            <option value="selesai">Selesai</option>
                            <option value="ditolak">Ditolak</option>
                        </select>
                    </div>

                    <div class="col-md-3 mb-3">
                        <label class="form-label fw-bold">Alasan Keberatan</label>
                        <select name="alasan" class="form-select" id="alasan">
                            <option value="semua">Semua Alasan</option>
                            <option value="penolakan_pasal_17">Penolakan Pasal 17</option>
                            <option value="tidak_disediakan_berkala">Tidak Disediakan Berkala</option>
                            <option value="tidak_ditanggapi">Tidak Ditanggapi</option>
                            <option value="tidak_sesuai_permintaan">Tidak Sesuai Permintaan</option>
                            <option value="tidak_dipenuhi">Tidak Dipenuhi</option>
                            <option value="biaya_tidak_wajar">Biaya Tidak Wajar</option>
                            <option value="melebihi_jangka_waktu">Melebihi Jangka Waktu</option>
                        </select>
                    </div>
                </div>

                <div class="d-flex gap-2">
                    <button type="button" onclick="previewData()" class="btn btn-info">
                        <i class="fas fa-eye me-2"></i>Preview Data
                    </button>
                    <button type="button" onclick="exportExcel()" class="btn btn-success">
                        <i class="fas fa-file-excel me-2"></i>Export ke Excel
                    </button>
                    <button type="button" onclick="resetFilter()" class="btn btn-secondary">
                        <i class="fas fa-redo me-2"></i>Reset Filter
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Preview Modal -->
    <div class="modal fade" id="previewModal" tabindex="-1">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Preview Data Export</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body" id="previewContent">
                    <div class="text-center py-5">
                        <div class="spinner-border text-primary"></div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    <button type="button" onclick="exportExcel()" class="btn btn-success">
                        <i class="fas fa-file-excel me-2"></i>Export Excel
                    </button>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
const chartData = @json($chartData);
const statusData = @json($dataPerStatus);

// Line Chart
const ctx1 = document.getElementById('keberatanChart').getContext('2d');
new Chart(ctx1, {
    type: 'line',
    data: {
        labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'],
        datasets: [{
            label: 'Jumlah Keberatan',
            data: chartData,
            borderColor: 'rgb(255, 99, 132)',
            backgroundColor: 'rgba(255, 99, 132, 0.2)',
            tension: 0.4,
            fill: true
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        scales: {
            y: {
                beginAtZero: true,
                ticks: { stepSize: 1 }
            }
        }
    }
});

// Pie Chart
const ctx2 = document.getElementById('statusChart').getContext('2d');
new Chart(ctx2, {
    type: 'doughnut',
    data: {
        labels: ['Pending', 'Diproses', 'Selesai', 'Ditolak'],
        datasets: [{
            data: statusData.map(item => item.total),
            backgroundColor: ['#ffc107', '#17a2b8', '#28a745', '#dc3545']
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: { position: 'bottom' }
        }
    }
});

function previewData() {
    const formData = new FormData(document.getElementById('exportForm'));
    $('#previewModal').modal('show');
    $('#previewContent').html('<div class="text-center py-5"><div class="spinner-border text-primary"></div></div>');
    
    fetch('{{ route("admin.rekap.keberatan.preview") }}', {
        method: 'POST',
        body: formData,
        headers: { 'X-Requested-With': 'XMLHttpRequest' }
    })
    .then(response => response.text())
    .then(html => $('#previewContent').html(html));
}

function exportExcel() {
    const form = document.getElementById('exportForm');
    form.action = '{{ route("admin.rekap.keberatan.export") }}';
    form.submit();
}

function resetFilter() {
    document.getElementById('tanggal_mulai').value = '';
    document.getElementById('tanggal_selesai').value = '';
    document.getElementById('status').value = 'semua';
    document.getElementById('alasan').value = 'semua';
}
</script>
@endpush