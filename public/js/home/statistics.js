// Statistics Chart
document.addEventListener('DOMContentLoaded', function() {
    const ctx = document.getElementById('permohonanChart');
    
    if (ctx && window.statisticsData) {
        const data = window.statisticsData;
        
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['Permohonan Masuk', 'Permohonan Selesai', 'Permohonan Ditolak'],
                datasets: [{
                    label: 'Jumlah Permohonan',
                    data: [data.masuk, data.selesai, data.ditolak],
                    backgroundColor: [
                        '#17a2b8',
                        '#28a745',
                        '#dc3545'
                    ],
                    borderRadius: 8,
                    barThickness: 80
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return context.parsed.y + ' permohonan';
                            }
                        },
                        backgroundColor: 'rgba(0, 0, 0, 0.8)',
                        titleColor: '#fff',
                        bodyColor: '#fff',
                        padding: 12,
                        cornerRadius: 8
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 10,
                            font: {
                                size: 12,
                                family: 'Montserrat'
                            },
                            color: '#666'
                        },
                        grid: {
                            color: '#e0e0e0',
                            drawBorder: false
                        }
                    },
                    x: {
                        ticks: {
                            font: {
                                size: 12,
                                family: 'Montserrat'
                            },
                            color: '#666'
                        },
                        grid: {
                            display: false
                        }
                    }
                }
            }
        });
    }
});