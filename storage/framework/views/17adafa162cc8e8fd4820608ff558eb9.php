
<div class="statistics-section">
    <div class="container">
        <div class="statistics-title">
            <h2>Statistik Permohonan Informasi Publik</h2>
            <p>Data permohonan yang telah diproses</p>
        </div>
        
        
        <div class="stats-card-row">
            <?php
                $masuk = \App\Models\Permohonan::count();
                $selesai = \App\Models\Permohonan::where('status', 'selesai')->count();
                $ditolak = \App\Models\Permohonan::where('status', 'ditolak')->count();
            ?>
            
            <div class="stats-card masuk">
                <div class="stats-card-title">Permohonan Masuk</div>
                <div class="stats-card-number"><?php echo e($masuk); ?></div>
            </div>
            
            <div class="stats-card selesai">
                <div class="stats-card-title">Permohonan Selesai</div>
                <div class="stats-card-number"><?php echo e($selesai); ?></div>
            </div>
            
            <div class="stats-card ditolak">
                <div class="stats-card-title">Permohonan Ditolak</div>
                <div class="stats-card-number"><?php echo e($ditolak); ?></div>
            </div>
        </div>
        
        
        <div class="chart-container">
            <h3 class="chart-title">Grafik Status Permohonan</h3>
            <canvas id="permohonanChart" height="80"></canvas>
        </div>
        
        
    </div>
</div>


<script>
    window.statisticsData = {
        masuk: <?php echo e($masuk); ?>,
        selesai: <?php echo e($selesai); ?>,
        ditolak: <?php echo e($ditolak); ?>

    };
</script><?php /**PATH C:\ppid-website\resources\views/components/statistics-section.blade.php ENDPATH**/ ?>