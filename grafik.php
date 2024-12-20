<?php
include "koneksi.php";

// Query SQL
$sql = "SELECT YEAR(awal_kerjasama) AS tahun,
               SUM(CASE WHEN jenis = 'mou' THEN 1 ELSE 0 END) AS jumlah_mou,
               SUM(CASE WHEN jenis = 'moa' THEN 1 ELSE 0 END) AS jumlah_moa,
               COUNT(*) AS jumlah_total
        FROM data
        GROUP BY YEAR(awal_kerjasama)
        ORDER BY tahun";

// Eksekusi query
$result = $koneksi->query($sql);

// Initialize arrays to store data
$years = [];
$mou = [];
$moa = [];
$total = [];

// Cek apakah hasil query mengembalikan data
if ($result && $result->num_rows > 0) {
    // Fetch data and populate arrays
    while ($row = $result->fetch_assoc()) {
        $years[] = $row['tahun'];
        $mou[] = $row['jumlah_mou'];
        $moa[] = $row['jumlah_moa'];
        $total[] = $row['jumlah_total'];
    }
} else {
    echo "0 results";
}

// Query untuk data yang mendekati akhir kerjasama
$sql = "SELECT *, DATEDIFF(akhir_kerjasama, CURDATE()) AS sisa_hari 
        FROM data
        WHERE akhir_kerjasama BETWEEN CURDATE() AND DATE_ADD(CURDATE(), INTERVAL 30 DAY)";
$result = $koneksi->query($sql);

?>



<style>
    .card-container {
        display: flex;
        justify-content: space-between;
        gap: 20px;
        flex-wrap: wrap;
        /* Agar responsif jika layar terlalu kecil */
        margin: 20px 0;
    }

    .card {
        flex: 1;
        /* Membuat setiap card memiliki lebar yang sama */
        /* Membatasi lebar maksimum agar rapi */
        display: flex;
        justify-content: center;
        /* Memusatkan canvas di dalam card */
        align-items: center;
        background-color: rgb(247, 244, 241);
        /* Warna latar belakang putih */
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        /* Memberikan efek bayangan */
        border-radius: 10px;
        /* Membuat sudut kartu melengkung */
        padding: 20px;
        /* Memberikan ruang di dalam kartu */
        margin: 10px;
        /* Memberikan jarak antar kartu */
        width: 400;
        height: 200;
    }

    canvas {
        display: block;
        max-width: 100%;
        /* Agar responsif */
        height: auto;
    }

    body {
        font-family: Arial, sans-serif;
        margin: 20px;
        background-color: #f9f9f9;
    }

</style>



<body>
    <div class="card-container">
        <div class="card">
            <canvas id="myChart"></canvas>
        </div>
        <div class="card">
            <canvas id="barChart" width="600" height="400"></canvas>
        </div>
    </div>

   
        
</body>

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

    // Grafik Batang
    const barCtx = document.getElementById('barChart').getContext('2d');
    const barChart = new Chart(barCtx, {
        type: 'bar',
        data: {
            labels: years,
            datasets: [
                {
                    label: 'Jumlah MOU',
                    data: mouData,
                    backgroundColor: 'rgba(221, 230, 99, 0.5)',
                    borderColor: 'rgb(221, 230, 99)',
                    borderWidth: 1
                },
                {
                    label: 'Jumlah MOA',
                    data: moaData,
                    backgroundColor: 'rgba(31, 145, 18, 0.5)',
                    borderColor: 'rgb(31, 145, 18)',
                    borderWidth: 1
                },
                {
                    label: 'Jumlah Total (MOU + MOA)',
                    data: totalData,
                    backgroundColor: 'rgba(245, 126, 7, 0.5)',
                    borderColor: 'rgb(245, 126, 7)',
                    borderWidth: 1
                }
            ]
        },
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
</body>


</html>