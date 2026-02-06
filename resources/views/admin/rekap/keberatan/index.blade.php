@extends('layouts.admin')

@section('title', 'Rekap Data Keberatan')

@push('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.min.css">
<style>
    body { background-color: #f4f7f6; color: #4a5568; }

    .card {
        border: none;
        border-radius: 12px;
        transition: all 0.3s cubic-bezier(.25,.8,.25,1);
    }

    /* Header Card */
    .card-header {
        background: linear-gradient(45deg, #7a0f0f, #b71c1c) !important;
        padding: 1rem 1.25rem;
        border: none;
    }

    .card-header h6 {
        color: #ffffff !important;
        font-weight: 600 !important;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin: 0;
        text-shadow: 1px 1px 2px rgba(0,0,0,0.2);
    }

    .card-header i {
        color: rgba(255,255,255,0.85) !important;
    }

    /* Stat Card */
    .stat-card {
        border: none !important;
        position: relative;
        overflow: hidden;
    }

    .stat-card::before {
        content: '';
        position: absolute;
        left: 0; top: 0; bottom: 0;
        width: 4px;
        border-radius: 4px;
    }

    .stat-card.primary::before { background-color: #dc3545; }
    .stat-card.warning::before { background-color: #f6c23e; }
    .stat-card.success::before { background-color: #1cc88a; }
    .stat-card.danger::before  { background-color: #e74a3b; }

    .stat-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.08) !important;
    }

    .form-control, .form-select {
        border-radius: 8px;
        border: 1px solid #e2e8f0;
        padding: 0.6rem 1rem;
        font-size: 0.9rem;
    }

    .btn {
        border-radius: 8px;
        padding: 0.6rem 1.2rem;
        font-weight: 500;
    }

    .btn-info { color: white; background-color: #36b9cc; border: none; }
    .btn-success { background-color: #1cc88a; border: none; }

    .chart-container {
        position: relative;
        height: 320px;
        margin-top: 10px;
    }

    .modal-content {
        border: none;
        border-radius: 16px;
    }

    /* Periode Filter Card */
    .periode-filter {
        background: linear-gradient(135deg, #7a0f0f 0%, #b71c1c 100%);
        color: white;
        border-radius: 12px;
        padding: 1.5rem;
        margin-bottom: 2rem;
    }

    .periode-filter .form-label {
        color: white;
        font-weight: 500;
    }

    .periode-filter .form-control {
        background: rgba(255,255,255,0.2);
        border: 1px solid rgba(255,255,255,0.3);
        color: white;
    }

    .periode-filter .form-control::placeholder {
        color: rgba(255,255,255,0.7);
    }

    .periode-filter .form-control:focus {
        background: rgba(255,255,255,0.3);
        border-color: white;
        color: white;
    }

    .periode-info {
        background: rgba(255,255,255,0.15);
        padding: 0.75rem 1rem;
        border-radius: 8px;
        display: inline-block;
    }
</style>
@endpush

@section('content')
<div class="container-fluid">

    <!-- PAGE HEADER -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800">
                <i class="fas fa-chart-bar me-2"></i>Rekap Data Keberatan
            </h1>
            <p class="text-muted mb-0">Laporan dan statistik keberatan pemohon informasi</p>
        </div>
        <div>
            <a href="{{ route('admin.keberatan.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-2"></i>Kembali
            </a>
        </div>
    </div>

    <!-- Filter Periode -->
    <div class="periode-filter shadow">
        <form action="{{ route('admin.rekap.keberatan.index') }}" method="GET">
            <div class="row align-items-end">
                <div class="col-md-3 mb-3 mb-md-0">
                    <label class="form-label">
                        <i class="fas fa-calendar-alt me-2"></i>Tanggal Mulai
                    </label>
                    <input type="date" name="periode_mulai" class="form-control" 
                           value="{{ $tanggalMulai ? $tanggalMulai->format('Y-m-d') : '' }}">
                </div>
                <div class="col-md-3 mb-3 mb-md-0">
                    <label class="form-label">
                        <i class="fas fa-calendar-check me-2"></i>Tanggal Selesai
                    </label>
                    <input type="date" name="periode_selesai" class="form-control" 
                           value="{{ $tanggalSelesai ? $tanggalSelesai->format('Y-m-d') : '' }}">
                </div>
                <div class="col-md-6">
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-light">
                            <i class="fas fa-filter me-2"></i>Terapkan Filter
                        </button>
                        <a href="{{ route('admin.rekap.keberatan.index') }}" class="btn btn-outline-light">
                            <i class="fas fa-redo me-2"></i>Reset
                        </a>
                        <div class="periode-info ms-auto">
                            <i class="fas fa-info-circle me-2"></i>
                            <strong>Periode:</strong> 
                            @if($tanggalMulai && $tanggalSelesai)
                                {{ $tanggalMulai->format('d M Y') }} - {{ $tanggalSelesai->format('d M Y') }}
                            @else
                                Semua Data
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <!-- STAT CARDS -->
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card stat-card primary shadow h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="text-muted small mb-1">Total Keberatan</div>
                            <div class="h3 mb-0 fw-bold text-danger">{{ number_format($stats['total']) }}</div>
                            <small class="text-muted">
                                @if($tanggalMulai && $tanggalSelesai)
                                    Pada periode terpilih
                                @else
                                    Seluruh data
                                @endif
                            </small>
                        </div>
                        <div class="text-danger" style="font-size: 3rem; opacity: 0.3;">
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
                            <div class="text-muted small mb-1">Perlu Verifikasi</div>
                            <div class="h3 mb-0 fw-bold text-warning">{{ number_format($stats['pending']) }}</div>
                            <small class="text-muted">
                                @if($tanggalMulai && $tanggalSelesai)
                                    Pada periode terpilih
                                @else
                                    Seluruh data
                                @endif
                            </small>
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
                            <small class="text-muted">
                                @if($tanggalMulai && $tanggalSelesai)
                                    Pada periode terpilih
                                @else
                                    Seluruh data
                                @endif
                            </small>
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
                            <small class="text-muted">
                                @if($tanggalMulai && $tanggalSelesai)
                                    Pada periode terpilih
                                @else
                                    Seluruh data
                                @endif
                            </small>
                        </div>
                        <div class="text-danger" style="font-size: 3rem; opacity: 0.3;">
                            <i class="fas fa-times-circle"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- CHARTS -->
    <div class="row mb-4">
        <div class="col-xl-8 mb-4">
            <div class="card shadow">
                <div class="card-header">
                    <h6><i class="fas fa-chart-line me-2"></i>Trend Keberatan Tahun {{ $currentYear }}</h6>
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
                <div class="card-header">
                    <h6><i class="fas fa-chart-pie me-2"></i>Distribusi Status</h6>
                </div>
                <div class="card-body">
                    <div class="chart-container">
                        <canvas id="statusChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- EXPORT -->
    <div class="card shadow mb-4">
        <div class="card-header">
            <h6><i class="fas fa-file-export me-2"></i>Export Data Keberatan</h6>
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
                            <option value="perlu_verifikasi">Perlu Verifikasi</option>
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

    <!-- PREVIEW MODAL -->
    <div class="modal fade" id="previewModal" tabindex="-1">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="fas fa-eye me-2"></i>Preview Data Export Keberatan
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body" id="previewContent">
                    <div class="text-center py-5">
                        <div class="spinner-border text-primary"></div>
                        <p class="mt-2">Loading...</p>
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
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2.2.0"></script>

<script>
// Register plugin
Chart.register(ChartDataLabels);

const chartData = @json($chartData);
const statusData = @json($dataPerStatus);

/* LINE CHART */
const lineChartData = chartData;
const hasLineData = lineChartData.reduce((a, b) => a + b, 0) > 0;

if (hasLineData) {
    new Chart(document.getElementById('keberatanChart'), {
        type: 'line',
        data: {
            labels: ['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Agu','Sep','Okt','Nov','Des'],
            datasets: [{
                data: chartData,
                borderColor: '#dc3545',
                backgroundColor: 'rgba(220,53,69,0.2)',
                tension: 0.4,
                fill: true
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { display: false }},
            scales: { y: { beginAtZero: true, ticks: { stepSize: 1 }}}
        }
    });
} else {
    const chartCanvas = document.getElementById('keberatanChart');
    chartCanvas.style.display = 'none';
    
    const container = chartCanvas.parentElement;
    const noDataMsg = document.createElement('div');
    noDataMsg.className = 'text-center py-5';
    noDataMsg.innerHTML = `
        <i class="fas fa-chart-line text-muted" style="font-size: 3rem; opacity: 0.3;"></i>
        <p class="text-muted mt-3 mb-0">Tidak ada data keberatan pada tahun ini</p>
    `;
    container.appendChild(noDataMsg);
}

/* DOUGHNUT */
// Mapping label status keberatan
const keberatanStatusLabels = statusData.map(item => {
    const labels = {
        'pending': 'Perlu Verifikasi',
        'perlu_verifikasi': 'Perlu Verifikasi',
        'diproses': 'Diproses',
        'ditunda': 'Ditunda',
        'selesai': 'Selesai',
        'dikabulkan': 'Dikabulkan',
        'ditolak': 'Ditolak'
    };
    return labels[item.status] || item.status;
});

const statusChartData = statusData.map(i => i.total);
const hasData = statusChartData.reduce((a, b) => a + b, 0) > 0;

if (hasData) {
    new Chart(document.getElementById('statusChart'), {
        type: 'doughnut',
        data: {
            labels: keberatanStatusLabels,
            datasets: [{
                data: statusChartData,
                backgroundColor: ['#ffc107', '#17a2b8', '#6c757d', '#28a745', '#20c997', '#dc3545']
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { 
                legend: { 
                    position: 'bottom',
                    labels: { boxWidth: 12, padding: 15 }
                },
                datalabels: {
                    color: '#fff',
                    font: { weight: 'bold', size: 14 },
                    formatter: (value, ctx) => {
                        let sum = 0;
                        let dataArr = ctx.chart.data.datasets[0].data;
                        dataArr.map(data => { sum += data; });
                        let percentage = (value * 100 / sum).toFixed(1) + "%";
                        return percentage;
                    }
                }
            }
        }
    });
} else {
    // Tampilkan pesan jika tidak ada data
    const chartCanvas = document.getElementById('statusChart');
    const ctx = chartCanvas.getContext('2d');
    chartCanvas.style.display = 'none';
    
    const container = chartCanvas.parentElement;
    const noDataMsg = document.createElement('div');
    noDataMsg.className = 'text-center py-5';
    noDataMsg.innerHTML = `
        <i class="fas fa-chart-pie text-muted" style="font-size: 3rem; opacity: 0.3;"></i>
        <p class="text-muted mt-3 mb-0">Tidak ada data keberatan pada periode ini</p>
    `;
    container.appendChild(noDataMsg);
}

/* PREVIEW */
function previewData() {
    const formData = new FormData(document.getElementById('exportForm'));
    
    $('#previewModal').modal('show');
    $('#previewContent').html(`
        <div class="text-center py-5">
            <div class="spinner-border text-primary"></div>
            <p class="mt-2">Loading...</p>
        </div>
    `);
    
    fetch('{{ route("admin.rekap.keberatan.preview") }}', {
        method: 'POST',
        body: formData,
        headers: { 'X-Requested-With': 'XMLHttpRequest' }
    })
    .then(res => res.text())
    .then(html => $('#previewContent').html(html))
    .catch(()=> $('#previewContent').html(`
        <div class="alert alert-danger text-center">
            <i class="fas fa-exclamation-triangle me-2"></i>Gagal memuat preview
        </div>
    `));
}

/* EXPORT */
function exportExcel() {
    const form = document.getElementById('exportForm');
    form.action = '{{ route("admin.rekap.keberatan.export") }}';
    form.submit();
}

/* RESET */
function resetFilter() {
    tanggal_mulai.value='';
    tanggal_selesai.value='';
    status.value='semua';
    alasan.value='semua';
}
</script>
@endpush