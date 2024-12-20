<?php
// Mulai output buffering untuk menunda pengiriman output
ob_start();
if (!isset($_SESSION['login']) || $_SESSION['level'] !== 'Staf') {
    // Jika belum login atau level bukan Staf, alihkan ke halaman login
    header("Location: login.php");
    exit;
}

include 'koneksi.php'; // Koneksi ke database

// Ambil data dari tabel user dengan level Mitra
$query = "SELECT * FROM user WHERE level = 'Mitra'";
$result = mysqli_query($koneksi, $query);

?>
<style>
    table {
        width: 100%;
        border-collapse: collapse;
    }

    
    th {
        color:rgb(22, 21, 21);
        padding: 5px;
        text-align: center;
    }

    /* Warna untuk sel tabel */
    td {
        padding: 8px;
        text-align: left;
        border: 1px solid #ddd;
    }
</style>

<body>
    <div class="container mt-5">
        <h2 class="mb-4">Daftar User Mitra</h2>
        <table class="table table-bordered" id="tabelusermitra">
            <thead class="table-warning">
                <tr>
                    <th>No</th>
                    <th>Username</th>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Alamat</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                $no = 1; // Mulai dari nomor 1
                while ($row = mysqli_fetch_assoc($result)): ?>
                    <tr>
                        <td><?= $no++ ?></td> <!-- Menampilkan nomor urut -->
                        <td><?= htmlspecialchars($row['username']) ?></td>
                        <td><?= htmlspecialchars($row['nama']) ?></td>
                        <td><?= htmlspecialchars($row['email']) ?></td>
                        <td><?= htmlspecialchars($row['alamat']) ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</body>
