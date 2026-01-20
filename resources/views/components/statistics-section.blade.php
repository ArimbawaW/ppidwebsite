{{-- STATISTIK SECTION --}}
<div class="statistics-section">
    <div class="container">
        <div class="statistics-title">
            <h2>Statistik Permohonan Informasi Publik</h2>
            <p>Data permohonan yang telah diproses</p>
        </div>
        
        {{-- Stats Cards --}}
        <div class="stats-card-row">
            @php
                $masuk = \App\Models\Permohonan::count();
                $selesai = \App\Models\Permohonan::where('status', 'disetujui')->count();
                $ditolak = \App\Models\Permohonan::where('status', 'ditolak')->count();
            @endphp
            
            <div class="stats-card masuk">
                <div class="stats-card-title">Permohonan Masuk</div>
                <div class="stats-card-number">{{ $masuk }}</div>
            </div>
            
            <div class="stats-card selesai">
                <div class="stats-card-title">Permohonan Selesai</div>
                <div class="stats-card-number">{{ $selesai }}</div>
            </div>
            
            <div class="stats-card ditolak">
                <div class="stats-card-title">Permohonan Ditolak</div>
                <div class="stats-card-number">{{ $ditolak }}</div>
            </div>
        </div>
        
        {{-- Chart --}}
        <div class="chart-container">
            <h3 class="chart-title">Grafik Status Permohonan</h3>
            <canvas id="permohonanChart" height="80"></canvas>
        </div>
        
        
    </div>
</div>

{{-- Pass data to JavaScript --}}
<script>
    window.statisticsData = {
        masuk: {{ $masuk }},
        selesai: {{ $selesai }},
        ditolak: {{ $ditolak }}
    };
</script>

    