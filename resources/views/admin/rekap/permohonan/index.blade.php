@extends('layouts.admin')

@section('title', 'Rekap Data Permohonan')

@push('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.min.css">
<style>
    /* Global Background & Typography */
    body { background-color: #f4f7f6; color: #4a5568; }
    
    /* Card Styling */
    .card {
        border: none;
        border-radius: 12px;
        transition: all 0.3s cubic-bezier(.25,.8,.25,1);
    }
    
    /* Pastikan teks Header Kartu berwarna putih dan tebal */
.card-header {
    background: linear-gradient(45deg, #0e5b73, #157a91) !important; /* Warna sesuai screenshot Anda */
    padding: 1rem 1.25rem;
    border: none;
}

.card-header h6 {
    color: #ffffff !important; /* Teks Putih */
    font-weight: 600 !important;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    margin: 0;
    text-shadow: 1px 1px 2px rgba(0,0,0,0.2); /* Memberi dimensi agar lebih terbaca */
}

/* Memperbaiki warna ikon di dalam header agar ikut putih */
.card-header i {
    color: rgba(255, 255, 255, 0.8) !important;
}

/* Opsional: Jika tulisan di dalam chart juga sulit terbaca, 
   pastikan font-nya cukup besar di konfigurasi Chart.js */px;
    }

    /* Stat Card Enhancements */
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

    .stat-card.primary::before { background-color: #4e73df; }
    .stat-card.success::before { background-color: #1cc88a; }
    .stat-card.warning::before { background-color: #f6c23e; }
    .stat-card.info::before { background-color: #36b9cc; }

    .stat-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.08) !important;
    }

    .icon-shape {
        width: 50px;
        height: 50px;
        background: rgba(255,255,255,0.2);
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 12px;
    }

    /* Form Styling */
    .form-control, .form-select {
        border-radius: 8px;
        border: 1px solid #e2e8f0;
        padding: 0.6rem 1rem;
        font-size: 0.9rem;
    }

    .form-control:focus, .form-select:focus {
        box-shadow: 0 0 0 3px rgba(78, 115, 223, 0.1);
        border-color: #4e73df;
    }

    /* Button Enhancements */
    .btn {
        border-radius: 8px;
        padding: 0.6rem 1.2rem;
        font-weight: 500;
        transition: all 0.2s;
    }

    .btn-info { color: white; background-color: #36b9cc; border: none; }
    .btn-success { background-color: #1cc88a; border: none; }
    
    /* Chart Container */
    .chart-container {
        position: relative;
        height: 320px;
        margin-top: 10px;
    }

    /* Modal Styling */
    .modal-content {
        border: none;
        border-radius: 16px;
    }
</style>
@endpush

@section('content')
<div class="container-fluid">
    
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800">
                <i class="fas fa-chart-bar me-2"></i>Rekap Data Permohonan
            </h1>
            <p class="text-muted mb-0">Laporan dan statistik permohonan informasi</p>
        </div>
        <div>
            <a href="{{ route('admin.permohonan.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-2"></i>Kembali
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            <i class="fas fa-check-circle me-2"></i>
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Statistics Cards -->
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card stat-card primary shadow h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="text-muted small mb-1">Total Permohonan</div>
                            <div class="h3 mb-0 fw-bold text-primary">{{ number_format($stats['total']) }}</div>
                        </div>
                        <div class="text-primary" style="font-size: 3rem; opacity: 0.3;">
                            <i class="fas fa-file-alt"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card stat-card info shadow h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="text-muted small mb-1">Bulan Ini</div>
                            <div class="h3 mb-0 fw-bold text-info">{{ number_format($stats['bulan_ini']) }}</div>
                        </div>
                        <div class="text-info" style="font-size: 3rem; opacity: 0.3;">
                            <i class="fas fa-calendar-alt"></i>
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
                            <div class="h3 mb-0 fw-bold text-warning">{{ number_format($stats['perlu_verifikasi']) }}</div>
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
    </div>

    <!-- Charts Row -->
    <div class="row mb-4">
        <!-- Line Chart -->
        <div class="col-xl-8 mb-4">
            <div class="card shadow">
                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                    <h6 class="m-0 fw-bold text-primary">
                        <i class="fas fa-chart-line me-2"></i>
                        Trend Permohonan Tahun {{ $currentYear }}
                    </h6>
                </div>
                <div class="card-body">
                    <div class="chart-container">
                        <canvas id="permohonanChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Pie Chart -->
        <div class="col-xl-4 mb-4">
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 fw-bold text-primary">
                        <i class="fas fa-chart-pie me-2"></i>
                        Distribusi Status
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
                <i class="fas fa-file-export me-2"></i>
                Export Data ke Excel
            </h6>
        </div>
        <div class="card-body">
            <form id="exportForm" method="POST" target="_blank">
                @csrf
                
                <div class="row">
                    <div class="col-md-3 mb-3">
                        <label class="form-label fw-bold">
                            <i class="fas fa-calendar me-1"></i>Tanggal Mulai
                        </label>
                        <input type="date" name="tanggal_mulai" class="form-control" id="tanggal_mulai">
                    </div>

                    <div class="col-md-3 mb-3">
                        <label class="form-label fw-bold">
                            <i class="fas fa-calendar me-1"></i>Tanggal Selesai
                        </label>
                        <input type="date" name="tanggal_selesai" class="form-control" id="tanggal_selesai">
                    </div>

                    <div class="col-md-3 mb-3">
                        <label class="form-label fw-bold">
                            <i class="fas fa-info-circle me-1"></i>Status
                        </label>
                        <select name="status" class="form-select" id="status">
                            <option value="semua">Semua Status</option>
                            <option value="perlu_verifikasi">Perlu Verifikasi</option>
                            <option value="diproses">Diproses</option>
                            <option value="ditunda">Ditunda</option>
                            <option value="dikabulkan_seluruhnya">Dikabulkan Seluruhnya</option>
                            <option value="dikabulkan_sebagian">Dikabulkan Sebagian</option>
                            <option value="ditolak">Ditolak</option>
                        </select>
                    </div>

                    <div class="col-md-3 mb-3">
                        <label class="form-label fw-bold">
                            <i class="fas fa-tags me-1"></i>Kategori Informasi
                        </label>
                        <select name="kategori_informasi" class="form-select" id="kategori_informasi">
                            <option value="semua">Semua Kategori</option>
                            <option value="informasi_berkala">Informasi Berkala</option>
                            <option value="informasi_setiap_saat">Informasi Setiap Saat</option>
                            <option value="informasi_serta_merta">Informasi Serta Merta</option>
                            <option value="informasi_dikecualikan">Informasi Dikecualikan</option>
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
                    <h5 class="modal-title">
                        <i class="fas fa-eye me-2"></i>Preview Data Export
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
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2.2.0"></script>
<script>
// Chart configurations
Chart.register(ChartDataLabels);

const chartData = @json($chartData);
const statusData = @json($dataPerStatus);

// 1. Line Chart (Hapus Label/Legend)
const ctx1 = document.getElementById('permohonanChart').getContext('2d');
new Chart(ctx1, {
    type: 'line',
    data: {
        labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'],
        datasets: [{
            data: chartData,
            borderColor: 'rgb(75, 192, 192)',
            backgroundColor: 'rgba(75, 192, 192, 0.2)',
            tension: 0.4,
            fill: true
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                display: false // MENGHAPUS TULISAN "JUMLAH PERMOHONAN"
            },
            datalabels: {
                display: false // Jangan tampilkan angka di line chart agar bersih
            }
        },
        scales: {
            y: {
                beginAtZero: true,
                ticks: { stepSize: 1 }
            }
        }
    }
});

// 2. Pie/Doughnut Chart (Tambah Persentase)
const statusLabels = statusData.map(item => {
    const labels = {
        'perlu_verifikasi': 'Perlu Verifikasi',
        'diproses': 'Diproses',
        'ditunda': 'Ditunda',
        'dikabulkan_seluruhnya': 'Dikabulkan Seluruhnya',
        'dikabulkan_sebagian': 'Dikabulkan Sebagian',
        'ditolak': 'Ditolak',
        'pending': 'Pending'
    };
    return labels[item.status] || item.status;
});

const statusValues = statusData.map(item => item.total);

const ctx2 = document.getElementById('statusChart').getContext('2d');
new Chart(ctx2, {
    type: 'doughnut',
    data: {
        labels: statusLabels,
        datasets: [{
            data: statusValues,
            backgroundColor: ['#ffc107', '#17a2b8', '#6c757d', '#28a745', '#20c997', '#dc3545', '#f6c23e']
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
                    return percentage; // MENAMPILKAN PERSENTASE
                }
            }
        }
    }
});

// Functions
function previewData() {
    const formData = new FormData(document.getElementById('exportForm'));
    
    $('#previewModal').modal('show');
    $('#previewContent').html('<div class="text-center py-5"><div class="spinner-border text-primary"></div><p class="mt-2">Loading...</p></div>');
    
    fetch('{{ route("admin.rekap.permohonan.preview") }}', {
        method: 'POST',
        body: formData,
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(response => response.text())
    .then(html => {
        $('#previewContent').html(html);
    })
    .catch(error => {
        $('#previewContent').html('<div class="alert alert-danger">Error loading preview</div>');
    });
}

function exportExcel() {
    const form = document.getElementById('exportForm');
    form.action = '{{ route("admin.rekap.permohonan.export") }}';
    form.submit();
}

function resetFilter() {
    document.getElementById('tanggal_mulai').value = '';
    document.getElementById('tanggal_selesai').value = '';
    document.getElementById('status').value = 'semua';
    document.getElementById('kategori_informasi').value = 'semua';
}
</script>
@endpush