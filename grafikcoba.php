<?php
include "koneksi.php";


// SQL query
$sql = "SELECT YEAR(awal_kerjasama) AS tahun,
               SUM(CASE WHEN jenis = 'mou' THEN 1 ELSE 0 END) AS jumlah_mou,
               SUM(CASE WHEN jenis = 'moa' THEN 1 ELSE 0 END) AS jumlah_moa,
               COUNT(*) AS jumlah_total
        FROM data
        GROUP BY YEAR(awal_kerjasama)
        ORDER BY tahun";
        
$koneksi = $koneksi->query($sql);

// Initialize arrays to store data
$years = [];
$mou = [];
$moa = [];
$total = [];

if ($koneksi->num_rows > 0) {
    // Fetch data and populate arrays
    while($row = $koneksi->fetch_assoc()) {
        $years[] = $row['tahun'];
        $mou[] = $row['jumlah_mou'];
        $moa[] = $row['jumlah_moa'];
        $total[] = $row['jumlah_total'];
    }
} else {
    echo "0 results";
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>

   <!-- // <h2>Grafik MOU, MOA, dan Total berdasarkan Tahun</h2> -->

    <canvas id="myChart" width="400" height="200"></canvas>
    
    <script>
        // Data yang diambil dari PHP
        const years = <?php echo json_encode($years); ?>;
        const mouData = <?php echo json_encode($mou); ?>;
        const moaData = <?php echo json_encode($moa); ?>;
        const totalData = <?php echo json_encode($total); ?>;
        
        // Membuat grafik dengan Chart.js
        const ctx = document.getElementById('myChart').getContext('2d');
        const myChart = new Chart(ctx, {
            type: 'line', // Type: line chart
            data: {
                labels: years, // Tahun sebagai label
                datasets: [
                    {
                        label: 'Jumlah MOU',
                        data: mouData,
                        borderColor: 'rgb(221, 230, 99)',
                        backgroundColor: 'rgb(221, 230, 99)',
                        fill: false,
                        tension: 0.1
                    },
                    {
                        label: 'Jumlah MOA',
                        data: moaData,
                        borderColor: 'rgb(31, 145, 18)',
                        backgroundColor: 'rgb(31, 145, 18)',
                        fill: false,
                        tension: 0.1
                    },
                    {
                        label: 'Jumlah Total (MOU + MOA)',
                        data: totalData,
                        borderColor: 'rgb(245, 126, 7)',
                        backgroundColor: 'rgb(245, 126, 7)',
                        fill: false,
                        tension: 0.1
                    }
                ]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
</body>
</html>
