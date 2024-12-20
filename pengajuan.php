<?php
include "koneksi.php";
$message = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama = $_POST['nama'];
    $alamat = $_POST['alamat'];
    $nama_penandatangan = $_POST['nama_penandatangan'];
    $jabatan = $_POST['jabatan'];
    $nama_kontak = $_POST['nama_kontak'];
    $no_kontak = $_POST['no_kontak'];
    $email = $_POST['email'];

    // Proses file upload
    $dokumen = null;
    if (isset($_FILES['dokumen']) && $_FILES['dokumen']['error'] == 0) {
        $target_dir = "uploads/";
        if (!is_dir($target_dir)) {
            mkdir($target_dir, 0777, true); // Buat folder jika belum ada
        }

        $dokumen = $target_dir . basename($_FILES['dokumen']['name']);
        move_uploaded_file($_FILES['dokumen']['tmp_name'], $dokumen);
    }

    // Query untuk menyimpan data
    $sql = "INSERT INTO usulan (nama, alamat, nama_penandatangan, jabatan, nama_kontak, no_kontak, email, dokumen,status)
            VALUES ('$nama', '$alamat', '$nama_penandatangan', '$jabatan', '$nama_kontak', '$no_kontak', '$email', '$dokumen','Terkirim')";

    if ($koneksi->query($sql) === TRUE) {
        $message = "Inputan Anda berhasil terkirim";
    } else {
        $message = "Error: " . $sql . "<br>" . $koneksi->error;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Usulan Kerjasama</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
           
        .form-container {
            max-width: 700px;
            margin: 50px auto;
            padding: 30px;
            background: rgba(255, 255, 255, 0.8); 
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .form-title {
            text-align: center;
            font-size: 14px;
            font-weight: 600;
            color: #6c63ff;
            margin-bottom: 20px;
        }
        .form-control {
            border: none;
            border-bottom: 2px solid #d3d3d3;
            border-radius: 0;
            transition: border-color 0.3s;
        }
        .form-control:focus {
            border-bottom-color: #6c63ff;
            box-shadow: none;
        }
        .form-label {
            font-weight: bold;
            color: #6c757d;
        }
        .btn-primary {
            background-color: #6c63ff;
            border: none;
        }
        .btn-primary:hover {
            background-color: #574dcf;
        }
    </style>
</head>
<body>
<div class="form-container">
    <h2 class="form-title">Form Usulan Kerjasama</h2>

    <!-- Notifikasi Berhasil/Tidak Berhasil -->
    <?php if (!empty($message)): ?>
        <div class="alert alert-success" role="alert">
            <?= htmlspecialchars($message); ?>
        </div>
    <?php endif; ?>

    <form action="" method="POST" enctype="multipart/form-data">
        <div class="mb-3">
            <label for="nama" class="form-label">Nama Instansi</label>
            <input type="text" class="form-control" name="nama" placeholder="Masukkan nama instansi Anda" required>
        </div>
        <div class="mb-3">
            <label for="alamat" class="form-label">Alamat</label>
            <textarea class="form-control" name="alamat" placeholder="Masukkan alamat Anda" required></textarea>
        </div>
        <div class="mb-3">
            <label for="nama_penandatangan" class="form-label">Nama Penanda Tangan</label>
            <input type="text" class="form-control" name="nama_penandatangan" placeholder="Masukkan nama penanda tangan" required>
        </div>
        <div class="mb-3">
            <label for="jabatan" class="form-label">Jabatan</label>
            <input type="text" class="form-control" name="jabatan" placeholder="Masukkan jabatan" required>
        </div>
        <div class="mb-3">
            <label for="nama_kontak" class="form-label">Nama Contact Person</label>
            <input type="text" class="form-control" name="nama_kontak" placeholder="Masukkan nama contact person" required>
        </div>
        <div class="mb-3">
            <label for="no_kontak" class="form-label">Nomor Telepon</label>
            <input type="tel" class="form-control" name="no_kontak" placeholder="08xxxxxxxxxx" required>
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" name="email" placeholder="name@example.com" required>
        </div>
        <div class="mb-3">
            <label for="dokumen" class="form-label">Unggah Dokumen Pendukung</label>
            <input class="form-control" type="file" name="dokumen">
        </div>

        <div class="d-grid">
            <button type="submit" class="btn btn-primary">Submit</button>
        </div>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
