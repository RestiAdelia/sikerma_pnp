
<div class="row">
    <!-- Grafik Garis -->
    <div class="col-md-6">
        <h5>Grafik Garis</h5>
        <canvas id="lineChart" width="400" height="200"></canvas>
    </div>

    <!-- Grafik Batang -->
    <div class="col-md-6">
        <h5>Grafik Batang</h5>
        <canvas id="barChart" width="400" height="200"></canvas>
    </div>
</div>

<script>
    // Data untuk Grafik Garis (Line Chart)
    const lineChartData = {
        labels: ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni'],
        datasets: [{
            label: 'Jumlah Kerjasama',
            data: [12, 19, 3, 5, 2, 3],
            fill: false,
            borderColor: 'rgb(75, 192, 192)',
            tension: 0.1
        }]
    };

    // Grafik Garis
    const ctxLine = document.getElementById('lineChart').getContext('2d');
    const lineChart = new Chart(ctxLine, {
        type: 'line',
        data: lineChartData,
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });

    // Data untuk Grafik Batang (Bar Chart)
    const barChartData = {
        labels: ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni'],
        datasets: [{
            label: 'Pendapatan Bulanan',
            data: [65, 59, 80, 81, 56, 55],
            backgroundColor: 'rgba(54, 162, 235, 0.2)',
            borderColor: 'rgba(54, 162, 235, 1)',
            borderWidth: 1
        }]
    };

    // Grafik Batang
    const ctxBar = document.getElementById('barChart').getContext('2d');
    const barChart = new Chart(ctxBar, {
        type: 'bar',
        data: barChartData,
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
</script>
