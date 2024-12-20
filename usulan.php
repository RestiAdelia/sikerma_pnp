<?php
// Mulai output buffering untuk menunda pengiriman output
ob_start();

// Menghubungkan ke database (pastikan koneksi sudah benar)
include 'koneksi.php'; 

// Jika ada data yang dikirim melalui POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Ambil data dari form
    $id = $_POST['id'];
    $status = $_POST['status'];

    // Validasi input
    if (!in_array($status, ['Terkirim', 'Proses', 'Tolak'])) {
        echo "<div class='alert alert-danger'>Status tidak valid!</div>";
        exit;
    }
    

    // Update status di database
    $query = "UPDATE usulan SET status = ? WHERE id = ?";
    $stmt = mysqli_prepare($koneksi, $query);
    mysqli_stmt_bind_param($stmt, "si", $status, $id); // "si" karena status adalah string dan id adalah integer

    if (mysqli_stmt_execute($stmt)) {
        header('Location: navbar.php?p=usulan'); // Kembali ke halaman utama
        exit; // Hentikan eksekusi lebih lanjut
    } else {
        echo "<div class='alert alert-danger'>Terjadi kesalahan saat memperbarui status!</div>";
    }
    mysqli_stmt_close($stmt);
}

// Ambil semua data dari tabel usulan
$query = "SELECT * FROM usulan";
$result = mysqli_query($koneksi, $query);

// Fungsi untuk menyesuaikan warna badge status
function getStatusBadgeClass($status)
{
    switch ($status) {
        case 'Terkirim':
            return 'warning';
        case 'Proses':
            return 'success';
        case 'Tolak':
            return 'danger';
        default:
            return 'secondary';
    }
}
?>

<style>
    table {
        width: 100%;
        border-collapse: collapse;
    }

    th {
        color: rgb(22, 21, 21);
        padding: 5px;
        text-align: center;
    }

    /* Warna untuk sel tabel */
    td {
        padding: 8px;
        text-align: center;
        border: 1px solid #ddd;
    }
</style>

<body>
    <div class="container mt-5">
        <h2 class="mb-4">Konfirmasi Status Usulan</h2>
        <table class="table table-bordered" id="tabelusulan">
            <thead class="table-warning">
                <tr>
                    <th>No</th>
                    <th>Nama Penandatangan</th>
                    <th>Jabatan</th>
                    <th>Nama Kontak</th>
                    <th>No Kontak</th>
                    <th>Email</th>
                    <th>Alamat</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = mysqli_fetch_assoc($result)): ?>
                    <tr>
                        <td><?= htmlspecialchars($row['id']) ?></td>
                        <td><?= htmlspecialchars($row['nama_penandatangan']) ?></td>
                        <td><?= htmlspecialchars($row['jabatan']) ?></td>
                        <td><?= htmlspecialchars($row['nama_kontak']) ?></td>
                        <td><?= htmlspecialchars($row['no_kontak']) ?></td>
                        <td><?= htmlspecialchars($row['email']) ?></td>
                        <td><?= htmlspecialchars($row['alamat']) ?></td>
                        <td>
                            <span class="badge bg-<?= getStatusBadgeClass($row['status']) ?>">
                                <?= htmlspecialchars($row['status']) ?>
                            </span>
                        </td>
                        <td>
                            <form action="" method="POST" class="d-inline">
                                <input type="hidden" name="id" value="<?= htmlspecialchars($row['id']) ?>">
                                <select name="status" class="form-select form-select-sm d-inline w-auto">
                                    <!-- Update the options to reflect the new status values -->
                                    <option value="Terkirim" <?= $row['status'] === 'Terkirim' ? 'selected' : '' ?>>Terkirim</option>
                                    <option value="Proses" <?= $row['status'] === 'Proses' ? 'selected' : '' ?>>Proses</option>
                                    <option value="Tolak" <?= $row['status'] === 'Tolak' ? 'selected' : '' ?>>Tolak</option>
                                </select>
                                <button type="submit" class="btn btn-primary btn-sm">Simpan</button>
                            </form>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</body>

<?php
// Hentikan output buffering dan kirim output ke browser
ob_end_flush();
?>
