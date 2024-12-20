<?php
ob_start();

// Periksa apakah pengguna sudah login
if (!isset($_SESSION['login'])) {
    header("Location: login.php"); // Arahkan ke halaman login jika belum login
    exit;
}

// Sertakan file koneksi ke database
include 'koneksi.php';

// Ambil level pengguna dari sesi (default ke 'Guest' jika tidak ada)
$userLevel = isset($_SESSION['level']) ? $_SESSION['level'] : 'Guest';
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <style>
        /* Styling for the content section */
        .card-stats {
            display: flex;
            justify-content: space-between;
            gap: 20px;
            margin-bottom: 30px;
        }

        .card-stats .card {
            flex: 1;
            background-color: #ffcc99;
            color: #fff;
            border: none;
            box-shadow: 0px 3px 10px rgba(0, 0, 0, 0.1);
        }

        .card-stats .card-header {
            background-color: #ff6600;
        }

        .card-stats .card-body {
            background-color: #ff9933;
        }

        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            background-color: #f9f9f9;
        }

        h4 {
            text-align: center;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: center;
        }

        th {
            background-color: rgb(205, 208, 25);
            font-weight: bold;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        tr:hover {
            background-color: #f1f1f1;
        }

        .no-data {
            text-align: center;
            font-style: italic;
            color: #666;
        }
    </style>
</head>

<body>
    <div class="alert alert-info">
        <strong>Level Anda: <?php echo htmlspecialchars($userLevel); ?></strong>
        
    </div>
    <div id="content">
        <h2 class="mb-4">Welcome to the Dashboard</h2>
        <div class="row mb-4">
            <div class="col-md-4">
                <div class="card bg-primary text-white shadow">
                    <div class="card-body">
                        <h5 class="card-title">Jumlah Usulan</h5>
                        <?php
                        // Query untuk menghitung jumlah MoU (case-insensitive)
                        $sql = "SELECT COUNT(*) AS jumlah_usulan
                        FROM usulan";
                        $result = $koneksi->query($sql);

                        if ($result && $row = $result->fetch_assoc()) {
                            echo "<h2>" . $row['jumlah_usulan'] . "</h2>";
                        } else {
                            echo "<p>Tidak ada data kerjasama MoU.</p>";
                        }
                        ?>

                    </div>

                </div>
            </div>
            <div class="col-md-4">
                <div class="card bg-success text-white shadow">
                    <div class="card-body">
                        <h5 class="card-title">Jumlah MoU</h5>
                        <?php
                        $sql = "SELECT COUNT(*) AS jumlah_MoU FROM data WHERE jenis = 'mou'";
                        $result = $koneksi->query($sql);

                        if ($result && $row = $result->fetch_assoc()) {
                            echo "<h2>" . $row['jumlah_MoU'] . "</h2>";
                        } else {
                            echo "<p>Tidak ada data kerjasama MoU.</p>";
                        }
                        ?>
                    </div>

                </div>
            </div>
            <div class="col-md-4">
                <div class="card bg-warning text-white shadow">
                    <div class="card-body">
                        <h5 class="card-title">Jumlah MoA</h5>
                        <?php
                        $sql = "SELECT COUNT(*) AS jumlah_MoA FROM data WHERE jenis = 'moa'";
                        $result = $koneksi->query($sql);

                        if ($result && $row = $result->fetch_assoc()) {
                            echo "<h2>" . $row['jumlah_MoA'] . "</h2>";
                        } else {
                            echo "<p>Tidak ada data kerjasama MoU.</p>";
                        }
                        ?>
                    </div>

                </div>
            </div>
        </div>

    </div>
    <?php
    include 'grafik.php';
    ?>
    <div class="card">
        <h4>Tabel Kerjasama yang Akan Berakhir</h4>
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Kerjasama</th>
                    <th>Jenis Kerjasama</th>
                    <th>Tanggal Mulai</th>
                    <th>Tanggal Selesai</th>
                    <th>Sisa Hari</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result && $result->num_rows > 0) {
                    $no = 1; // Nomor otomatis
                    while ($row = $result->fetch_assoc()) {
                        $sisa_hari = $row['sisa_hari'];
                        $status = $sisa_hari > 0 ? "Akan berakhir dalam $sisa_hari hari" : "Telah berakhir";

                        echo "<tr>
                            <td>$no</td>
                            <td>{$row['nama_instansi']}</td>
                            <td>{$row['jenis_kerjasama']}</td>
                            <td>{$row['awal_kerjasama']}</td>
                            <td>{$row['akhir_kerjasama']}</td>
                            <td>{$sisa_hari} hari</td>
                            <td>$status</td>
                          </tr>";
                        $no++;
                    }
                } else {
                    // Tampilkan baris kosong jika tidak ada data
                    echo "<tr>
                        <td colspan='7' class='no-data'>Tidak ada kerjasama yang mendekati akhir dalam 30 hari ke depan</td>
                      </tr>";
                }
                ?>
            </tbody>
        </table>
    </div>



</body>

</html>