
<div class="statistics-section">
    <div class="container">
        <div class="statistics-title">
            <h2>Statistik Permohonan Informasi Publik</h2>
        </div>
        
        
        <div class="stats-card-row">
            <?php
                use App\Models\Permohonan;

                $masuk = Permohonan::count();

                // Disetujui = dikabulkan seluruhnya + sebagian
                $disetujui = Permohonan::whereIn('status', [
                    'dikabulkan_seluruhnya',
                    'dikabulkan_sebagian'
                ])->count();

                $ditolak = Permohonan::where('status', 'ditolak')->count();
            ?>
            
            <div class="stats-card masuk">
                <div class="stats-card-title">Permohonan Masuk</div>
                <div class="stats-card-number"><?php echo e($masuk); ?></div>
            </div>
            
            <div class="stats-card selesai">
                <div class="stats-card-title">Permohonan Disetujui</div>
                <div class="stats-card-number"><?php echo e($disetujui); ?></div>
            </div>
            
            <div class="stats-card ditolak">
                <div class="stats-card-title">Permohonan Ditolak</div>
                <div class="stats-card-number"><?php echo e($ditolak); ?></div>
            </div>
        </div>
        
        
        <div class="chart-container">
            <h3 class="chart-title">Grafik Status Permohonan</h3>
            <div class="chart-wrapper">
                <canvas id="permohonanChart"></canvas>
            </div>
        </div>
    </div>
</div>


<script>
    window.statisticsData = {
        masuk: <?php echo e($masuk); ?>,
        disetujui: <?php echo e($disetujui); ?>,
        ditolak: <?php echo e($ditolak); ?>

    };
</script>

<style>
    .chart-container {
        background: white;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        margin-top: 30px;
    }
    
    .chart-title {
        margin-bottom: 20px;
        font-size: 18px;
        font-weight: 600;
        color: #333;
    }
    
    .chart-wrapper {
        position: relative;
        width: 100%;
        height: 300px;
    }
    
    @media (max-width: 768px) {
        .chart-container {
            padding: 15px;
            margin-top: 20px;
        }
        
        .chart-title {
            font-size: 16px;
            margin-bottom: 15px;
            text-align: center;
        }
        
        .chart-wrapper {
            height: 250px;
        }
    }
    
    @media (max-width: 480px) {
        .chart-container {
            padding: 12px;
        }
        
        .chart-title {
            font-size: 14px;
        }
        
        .chart-wrapper {
            height: 220px;
        }
    }
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const ctx = document.getElementById('permohonanChart');
    if (!ctx) return;

    const data = window.statisticsData;
    const isMobile = window.innerWidth < 768;

    const chart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['Masuk', 'Disetujui', 'Ditolak'],
            datasets: [{
                label: '',
                data: [data.masuk, data.disetujui, data.ditolak],
                backgroundColor: [
                    'rgba(54, 162, 235, 0.7)',   // Masuk
                    'rgba(75, 192, 192, 0.7)',   // Disetujui
                    'rgba(255, 99, 132, 0.7)'    // Ditolak
                ],
                borderColor: [
                    'rgba(54, 162, 235, 1)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(255, 99, 132, 1)'
                ],
                borderWidth: 2,
                borderRadius: 6
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false },
                tooltip: {
                    enabled: true,
                    backgroundColor: 'rgba(0, 0, 0, 0.8)',
                    titleFont: { size: isMobile ? 12 : 14 },
                    bodyFont: { size: isMobile ? 11 : 13 },
                    padding: isMobile ? 8 : 12
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        font: { size: isMobile ? 10 : 12 },
                        stepSize: 1
                    },
                    grid: {
                        color: 'rgba(0, 0, 0, 0.05)'
                    }
                },
                x: {
                    ticks: {
                        font: { size: isMobile ? 11 : 12 }
                    },
                    grid: { display: false }
                }
            }
        }
    });

    // Responsive resize handler
    let resizeTimer;
    window.addEventListener('resize', function() {
        clearTimeout(resizeTimer);
        resizeTimer = setTimeout(function() {
            const newIsMobile = window.innerWidth < 768;
            chart.options.plugins.tooltip.titleFont.size = newIsMobile ? 12 : 14;
            chart.options.plugins.tooltip.bodyFont.size = newIsMobile ? 11 : 13;
            chart.options.scales.y.ticks.font.size = newIsMobile ? 10 : 12;
            chart.options.scales.x.ticks.font.size = newIsMobile ? 11 : 12;
            chart.update();
        }, 250);
    });
});
</script>
<?php /**PATH C:\ppid\resources\views/components/statistics-section.blade.php ENDPATH**/ ?>