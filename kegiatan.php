<?php
include("koneksi.php"); 


// Proses Hapus
if (isset($_GET['delete'])) {
    $id_kegiatan = intval($_GET['delete']);
    $stmt = $koneksi->prepare("DELETE FROM kegiatan WHERE id_kegiatan = ?");
    $stmt->bind_param("i", $id_kegiatan);

    if ($stmt->execute()) {
        echo "<script>alert('Data kegiatan berhasil dihapus!'); window.location.href='navbar.php?p=kegiatan';</script>";
    } else {
        echo "<script>alert('Gagal menghapus data kegiatan: " . addslashes($stmt->error) . "'); window.location.href='navbar.php?p=kegiatan';</script>";
    }
    $stmt->close();
}

// Proses Tambah
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['tambah'])) {
    $judul_kegiatan = $koneksi->real_escape_string($_POST['judul_kegiatan']);
    $nama_instansi = $koneksi->real_escape_string($_POST['nama_instansi']);
    $isi_kegiatan = $koneksi->real_escape_string($_POST['isi_kegiatan']);
    $gambar = '';

    // Validasi dan upload gambar
    if (isset($_FILES['gambar']) && $_FILES['gambar']['name'] != '') {
        $file_ext = strtolower(pathinfo($_FILES['gambar']['name'], PATHINFO_EXTENSION));
        if (in_array($file_ext, ['jpg', 'png', 'jpeg'])) {
            $gambar = 'uploadsgambar/' . uniqid() . '.' . $file_ext;
            move_uploaded_file($_FILES['gambar']['tmp_name'], $gambar);
        } else {
            echo "<script>alert('Format gambar tidak valid. Hanya jpg, png, dan jpeg yang diizinkan.'); window.location.href='navbar.php?p=kegiatan';</script>";
            exit;
        }
    }

    $stmt = $koneksi->prepare("INSERT INTO kegiatan (judul_kegiatan, gambar, nama_instansi, isi_kegiatan) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $judul_kegiatan, $gambar, $nama_instansi, $isi_kegiatan);

    if ($stmt->execute()) {
        echo "<script>alert('Data kegiatan berhasil ditambahkan!'); window.location.href='navbar.php?p=kegiatan';</script>";
    } else {
        echo "<script>alert('Gagal menambahkan data kegiatan: " . addslashes($stmt->error) . "'); window.location.href='navbar.php?p=kegiatan';</script>";
    }
    $stmt->close();
}

// Proses Edit
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update'])) {
    $id_kegiatan = intval($_POST['id_kegiatan']);
    $judul_kegiatan = $koneksi->real_escape_string($_POST['judul_kegiatan']);
    $nama_instansi = $koneksi->real_escape_string($_POST['nama_instansi']);
    $isi_kegiatan = $koneksi->real_escape_string($_POST['isi_kegiatan']);
    $gambar = $_POST['gambar_lama'];

    if (isset($_FILES['gambar']) && $_FILES['gambar']['name'] != '') {
        $file_ext = strtolower(pathinfo($_FILES['gambar']['name'], PATHINFO_EXTENSION));
        if (in_array($file_ext, ['jpg', 'png', 'jpeg'])) {
            $gambar = 'uploadsgambar/' . uniqid() . '.' . $file_ext;
            move_uploaded_file($_FILES['gambar']['tmp_name'], $gambar);
        } else {
            echo "<script>alert('Format gambar tidak valid.'); window.location.href='navbar.php?p=kegiatan';</script>";
            exit;
        }
    }

    $stmt = $koneksi->prepare("UPDATE kegiatan SET judul_kegiatan = ?, gambar = ?, nama_instansi = ?, isi_kegiatan = ? WHERE id_kegiatan = ?");
    $stmt->bind_param("ssssi", $judul_kegiatan, $gambar, $nama_instansi, $isi_kegiatan, $id_kegiatan);

    if ($stmt->execute()) {
        echo "<script>alert('Data kegiatan berhasil diperbarui!'); window.location.href='navbar.php?p=kegiatan';</script>";
    } else {
        echo "<script>alert('Gagal memperbarui data kegiatan: " . addslashes($stmt->error) . "'); window.location.href='navbar.php?p=kegiatan';</script>";
    }
    $stmt->close();
}

// Ambil data kegiatan
$sql = "SELECT * FROM kegiatan";
$result = $koneksi->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Galeri Kegiatan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        .gallery-container { display: flex; flex-wrap: wrap; }
        .gallery-item { width: 25%; margin: 1%; padding: 10px; border: 1px solid #ccc; text-align: center; }
        .gallery-item img { width: 80%; height: auto; }
        .icon-btn { background: none; border: none; color: rgb(255, 195, 42); font-size: 1.5rem; cursor: pointer; }
    </style>
</head>
<body>
    <!-- <div class="container mt-4"> -->
        <h1 class="text-center">Galeri Kegiatan</h1>

        <!-- Tombol Tambah -->
        <button class="btn btn-warning mb-3" data-bs-toggle="modal" data-bs-target="#addModal"><i class="bi bi-plus-circle-dotted"></i> Tambah Kegiatan</button>

        <!-- Galeri -->
        <div class="gallery-container">
            <?php while ($row = $result->fetch_assoc()) { ?>
                <div class="gallery-item">
                    <img src="<?= $row['gambar'] ?>" alt="<?= $row['judul_kegiatan'] ?>" class="img-fluid">
                    <h3><?= $row['judul_kegiatan'] ?></h3>
                    <p><strong><?= $row['nama_instansi'] ?></strong></p>
                    <p><?= $row['isi_kegiatan'] ?></p>
                    <button class="icon-btn" onclick="editKegiatan(<?= $row['id_kegiatan'] ?>, '<?= $row['judul_kegiatan'] ?>', '<?= $row['nama_instansi'] ?>', '<?= $row['isi_kegiatan'] ?>', '<?= $row['gambar'] ?>')"><i class="bi bi-pencil"></i></button>
                    <button class="icon-btn" onclick="deleteKegiatan(<?= $row['id_kegiatan'] ?>)"><i class="bi bi-trash"></i></button>
                </div>
            <?php } ?>
        </div>
    </div>

    <!-- Modal Tambah -->
    <div class="modal fade" id="addModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="kegiatan.php" method="POST" enctype="multipart/form-data">
                    <div class="modal-header">
                        <h5 class="modal-title">Tambah Kegiatan</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <input type="text" name="judul_kegiatan" class="form-control mb-2" placeholder="Judul Kegiatan" required>
                        <input type="file" name="gambar" class="form-control mb-2">
                        <input type="text" name="nama_instansi" class="form-control mb-2" placeholder="Nama Instansi" required>
                        <textarea name="isi_kegiatan" class="form-control mb-2" placeholder="Isi Kegiatan" required></textarea>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" name="tambah" class="btn btn-primary">Tambah</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Edit -->
    <div class="modal fade" id="editModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="kegiatan.php" method="POST" enctype="multipart/form-data">
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Kegiatan</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="id_kegiatan" id="edit_id">
                        <input type="hidden" name="gambar_lama" id="edit_gambar_lama">
                        <div class="mb-3 text-center">
                            <img id="preview_gambar" src="" alt="Gambar Sebelumnya" class="img-fluid" style="max-height: 200px; border: 1px solid #ccc;">
                        </div>
                        <input type="text" name="judul_kegiatan" id="edit_judul" class="form-control mb-2" required>
                        <input type="file" name="gambar" class="form-control mb-2">
                        <input type="text" name="nama_instansi" id="edit_instansi" class="form-control mb-2" required>
                        <textarea name="isi_kegiatan" id="edit_isi" class="form-control mb-2" required></textarea>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" name="update" class="btn btn-primary">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function editKegiatan(id, judul, instansi, isi, gambar) {
            document.getElementById('edit_id').value = id;
            document.getElementById('edit_judul').value = judul;
            document.getElementById('edit_instansi').value = instansi;
            document.getElementById('edit_isi').value = isi;
            document.getElementById('edit_gambar_lama').value = gambar;
            document.getElementById('preview_gambar').src = gambar;
            new bootstrap.Modal(document.getElementById('editModal')).show();
        }

        function deleteKegiatan(id) {
            if (confirm('Apakah Anda yakin ingin menghapus kegiatan ini?')) {
                window.location.href = 'kegiatan.php?delete=' + id;
            }
        }
    </script>

<!-- <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script> -->

</body>
</html>