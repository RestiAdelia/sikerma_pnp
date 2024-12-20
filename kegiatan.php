<?php
include("koneksi.php");

// Proses Hapus
if (isset($_GET['delete'])) {
    $id_kegiatan = $_GET['delete'];
    $sql = "DELETE FROM kegiatan WHERE id_kegiatan = $id_kegiatan";
    if ($koneksi->query($sql) === TRUE) {
        echo "<script>alert('Data kegiatan berhasil dihapus!'); window.location.href='navbar.php?p=kegiatan';</script>";
    } else {
        echo "Error: " . $sql . "<br>" . $koneksi->error;
    }
}

// Proses Edit
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update'])) {
    $id_kegiatan = $_POST['id_kegiatan'];
    $judul_kegiatan = $_POST['judul_kegiatan'];
    $nama_instansi = $_POST['nama_instansi'];
    $isi_kegiatan = $_POST['isi_kegiatan'];

    // Menangani gambar
    $gambar = $_POST['gambar_lama'];
    if (isset($_FILES['gambar']) && $_FILES['gambar']['name'] != '') {
        $gambar = 'uploadsgambar/' . basename($_FILES['gambar']['name']);
        move_uploaded_file($_FILES['gambar']['tmp_name'], $gambar);
    }

    // Update data ke database
    $sql = "UPDATE kegiatan SET judul_kegiatan='$judul_kegiatan', gambar='$gambar', nama_instansi='$nama_instansi', isi_kegiatan='$isi_kegiatan' WHERE id_kegiatan = $id_kegiatan";

    if ($koneksi->query($sql) === TRUE) {
        echo "<script>alert('Data kegiatan berhasil diperbarui!'); window.location.href='navbar.php?p=kegiatan';</script>";
    } else {
        echo "Error: " . $sql . "<br>" . $koneksi->error;
    }
}

// Proses Tambah
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['tambah'])) {
    $judul_kegiatan = $_POST['judul_kegiatan'];
    $nama_instansi = $_POST['nama_instansi'];
    $isi_kegiatan = $_POST['isi_kegiatan'];

    // Menangani gambar
    $gambar = '';
    if (isset($_FILES['gambar']) && $_FILES['gambar']['name'] != '') {
        $gambar = 'uploadsgambar/' . basename($_FILES['gambar']['name']);
        move_uploaded_file($_FILES['gambar']['tmp_name'], $gambar);
    }

    // Insert data ke database
    $sql = "INSERT INTO kegiatan (judul_kegiatan, gambar, nama_instansi, isi_kegiatan) VALUES ('$judul_kegiatan', '$gambar', '$nama_instansi', '$isi_kegiatan')";

    if ($koneksi->query($sql) === TRUE) {
        echo "<script>alert('Data kegiatan berhasil ditambahkan!'); window.location.href='navbar.php?p=kegiatan';</script>";
    } else {
        echo "Error: " . $sql . "<br>" . $koneksi->error;
    }
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
        .gallery-container {
            display: flex;
            flex-wrap: wrap;
        }
        .gallery-item {
            width: 25%;
            margin: 1%;
            padding: 10px;
            border: 1px solid #ccc;
            text-align: center;
        }
        .gallery-item img {
            width: 80%;
            height: auto;
        }
        .icon-btn {
            background: none;
            border: none;
            color: rgb(255, 195, 42);
            font-size: 1.5rem;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <h1 class="text-center mt-4">Galeri Kegiatan</h1>

    <!-- Tombol untuk membuka modal tambah -->
    <button class="btn btn-warning mb-2" data-bs-toggle="modal" data-bs-target="#addModal">
        <i class="bi bi-plus-circle-dotted"></i> New
    </button>

    <!-- Modal Tambah Kegiatan -->
    <div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addModalLabel">Tambah Kegiatan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="kegiatan.php" method="post" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label for="judul_kegiatan" class="form-label">Judul Kegiatan</label>
                            <input type="text" class="form-control" id="judul_kegiatan" name="judul_kegiatan" required>
                        </div>
                        <div class="mb-3">
                            <label for="gambar" class="form-label">Gambar</label>
                            <input type="file" class="form-control" id="gambar" name="gambar">
                        </div>
                        <div class="mb-3">
                            <label for="nama_instansi" class="form-label">Nama Instansi</label>
                            <input type="text" class="form-control" id="nama_instansi" name="nama_instansi" required>
                        </div>
                        <div class="mb-3">
                            <label for="isi_kegiatan" class="form-label">Isi Kegiatan</label>
                            <textarea class="form-control" id="isi_kegiatan" name="isi_kegiatan" required></textarea>
                        </div>
                        <button type="submit" name="tambah" class="btn btn-primary">Tambah Kegiatan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="gallery-container">
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<div class='gallery-item'>";
                echo "<img src='" . $row["gambar"] . "' alt='" . $row["judul_kegiatan"] . "' class='img-fluid'>";
                echo "<h3>" . $row["judul_kegiatan"] . "</h3>";
                echo "<p><strong>" . $row["nama_instansi"] . "</strong></p>";
                echo "<p>" . $row["isi_kegiatan"] . "</p>";
                echo "<button class='icon-btn' onclick='editKegiatan(" . $row["id_kegiatan"] . ", \"" . $row["judul_kegiatan"] . "\", \"" . $row["nama_instansi"] . "\", \"" . $row["isi_kegiatan"] . "\", \"" . $row["gambar"] . "\")'><i class='bi bi-pencil'></i></button>";

                echo "<button class='icon-btn' onclick='deleteKegiatan(" . $row["id_kegiatan"] . ")'><i class='bi bi-trash'></i></button>";
                echo "</div>";
            }
        } else {
            echo "<p class='text-center'>Tidak ada data kegiatan.</p>";
        }
        ?>
    </div>

    <!-- Modal Edit Kegiatan -->
    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Edit Kegiatan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="kegiatan.php" method="post" enctype="multipart/form-data">
                        <input type="hidden" id="id_kegiatan" name="id_kegiatan">
                        <div class="mb-3">
                            <label for="judul_kegiatan" class="form-label">Judul Kegiatan</label>
                            <input type="text" class="form-control" id="judul_kegiatan" name="judul_kegiatan" value="" required>
                        </div>
                        <div class="mb-3">
                            <label for="gambar" class="form-label">Gambar</label>
                            <input type="file" class="form-control" id="gambar" name="gambar">
                            <input type="hidden" id="gambar_lama" name="gambar_lama">
                            <img id="gambar_preview" src="" class="img-thumbnail" width="100" style="display: none;">
                        </div>
                        <div class="mb-3">
                            <label for="nama_instansi" class="form-label">Nama Instansi</label>
                            <input type="text" class="form-control" id="nama_instansi" name="nama_instansi"  value="" required>
                        </div>
                        <div class="mb-3">
                            <label for="isi_kegiatan" class="form-label">Isi Kegiatan</label>
                            <textarea class="form-control" id="isi_kegiatan" name="isi"value="" required></textarea>
                        </div>
                        <button type="submit" name="update" class="btn btn-primary">Update Kegiatan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script>
       // Fungsi untuk membuka modal edit dengan data yang sesuai
       function editKegiatan(id, judul, instansi, isi, gambar) {
    // Isi data form edit
    document.getElementById("id_kegiatan").value = id;
    document.getElementById("judul_kegiatan").value = judul;
    document.getElementById("nama_instansi").value = instansi;
    document.getElementById("isi_kegiatan").value = isi;
    document.getElementById("gambar_lama").value = gambar;

    // Tampilkan preview gambar jika ada
    const gambarPreview = document.getElementById("gambar_preview");
    if (gambar) {
        gambarPreview.style.display = "block";
        gambarPreview.src = gambar;
    } else {
        gambarPreview.style.display = "none";
    }

    // Tampilkan modal edit
    const editModal = new bootstrap.Modal(document.getElementById("editModal"));
    editModal.show();
}


// Fungsi untuk membuka modal tambah dengan form kosong
document.getElementById("addModal").addEventListener("show.bs.modal", function () {
    // Kosongkan semua field di modal tambah
    document.querySelector("#addModal form").reset();
});

        function deleteKegiatan(id) {
            if (confirm("Apakah Anda yakin ingin menghapus kegiatan ini?")) {
                window.location.href = "kegiatan.php?delete=" + id; } } </script>

</body> </html>
