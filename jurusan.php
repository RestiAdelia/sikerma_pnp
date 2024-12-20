<?php
// Mulai output buffering untuk menunda pengiriman output
ob_start();

include 'koneksi.php'; // Koneksi ke database

// Jika ada data yang dikirim melalui POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Ambil data dari form
    $id = $_POST['kode_jurusan'];
    $status = $_POST['status'];

    // Validasi input
    if (!in_array($status, ['Pending', 'Approved', 'Rejected'])) {
        echo "<div class='alert alert-danger'>Status tidak valid!</div>";
        exit;
    }

    // Validasi kode_jurusan
    $query_check = "SELECT COUNT(*) AS count FROM jurusan WHERE kode_jurusan = ?";
    $stmt_check = mysqli_prepare($koneksi, $query_check);
    mysqli_stmt_bind_param($stmt_check, "s", $id); // Gunakan "s" karena kode_jurusan adalah string
    mysqli_stmt_execute($stmt_check);
    mysqli_stmt_bind_result($stmt_check, $count);
    mysqli_stmt_fetch($stmt_check);
    mysqli_stmt_close($stmt_check);

    if ($count == 0) {
        echo "<div class='alert alert-danger'>Jurusan tidak ditemukan!</div>";
        exit;
    }

    // Update status di database
    $query = "UPDATE jurusan SET status = ? WHERE kode_jurusan = ?";
    $stmt = mysqli_prepare($koneksi, $query);
    mysqli_stmt_bind_param($stmt, "ss", $status, $id); // Gunakan "ss" karena status dan kode_jurusan adalah string

    if (mysqli_stmt_execute($stmt)) {
        header('Location: navbar.php?p=jurusan'); // Kembali ke halaman utama
        exit; // Hentikan eksekusi lebih lanjut
    } else {
        echo "<div class='alert alert-danger'>Terjadi kesalahan saat memperbarui status!</div>";
    }
    mysqli_stmt_close($stmt);
}

// Ambil semua data dari tabel jurusan
$query = "SELECT * FROM jurusan";
$result = mysqli_query($koneksi, $query);

// Fungsi untuk menyesuaikan warna badge status
function getStatusBadgeClass($status)
{
    switch ($status) {
        case 'Pending':
            return 'warning';
        case 'Approved':
            return 'success';
        case 'Rejected':
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
        color:rgb(22, 21, 21);
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
        <h2 class="mb-4">Manajemen Jurusan</h2>
        <table class="table table-bordered" id="tabeljurusan">
            <thead class="table-warning">
                <tr>
                    <th>Kode Jurusan</th>
                    <th>Nama Jurusan</th>
                    <th>Username</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = mysqli_fetch_assoc($result)): ?>
                    <tr>
                        <td><?= htmlspecialchars($row['kode_jurusan'], ENT_QUOTES, 'UTF-8') ?></td>
                        <td><?= htmlspecialchars($row['nama_jurusan'], ENT_QUOTES, 'UTF-8') ?></td>
                        <td><?= htmlspecialchars($row['username'], ENT_QUOTES, 'UTF-8') ?></td>
                        <td>
                            <span class="badge bg-<?= getStatusBadgeClass($row['status']) ?>">
                                <?= htmlspecialchars($row['status'], ENT_QUOTES, 'UTF-8') ?>
                            </span>
                        </td>
                        <td>
                            <form action="" method="POST" class="d-inline">
                                <input type="hidden" name="kode_jurusan"
                                    value="<?= htmlspecialchars($row['kode_jurusan'], ENT_QUOTES, 'UTF-8') ?>">
                                <select name="status" class="form-select form-select-sm d-inline w-auto">
                                    <option value="Pending" <?= $row['status'] === 'Pending' ? 'selected' : '' ?>>Pending
                                    </option>
                                    <option value="Approved" <?= $row['status'] === 'Approved' ? 'selected' : '' ?>>Approved
                                    </option>
                                    <option value="Rejected" <?= $row['status'] === 'Rejected' ? 'selected' : '' ?>>Rejected
                                    </option>
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