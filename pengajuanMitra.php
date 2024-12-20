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
            mkdir($target_dir, 0777, true);
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

    <style>
        /* Container Form */
        .form-container {
            max-width: 800px;
            margin: 0 auto;
            padding: 10px;
            border-radius: 8px;
        }

        /* Judul Form */
        .form-container h2 {
            font-size: 2 rem;
            color: #080808;
            margin-bottom: 10px;
            text-align: center;
        }

        /* Gaya untuk formulir horizontal */
        .form-group-horizontal {
            display: flex;
            align-items: center;
            margin-bottom: 15px;
        }

        .form-group-horizontal label {
            flex: 0 0 150px; /* Tetapkan lebar tetap */
            margin-right: 5px;
            text-align: left;
        }

        .form-group-horizontal input,
        .form-group-horizontal textarea {
            flex: 1; /* Input menggunakan sisa ruang yang tersedia */
        }

        /* Tombol Submit */
        .btn-primary {
            background-color: rgb(221, 176, 42);
            border: none;
        }

        .btn-primary:hover {
            background-color: rgb(210, 124, 74);
        }

        /* Ukuran teks kecil */
        .form-container small {
            font-size: 0.85rem;
            color: #a5a5a5;
        }
    </style>
</head>

<body>
    <div class="form-container">
        <h2 class="form-title">Form Usulan Kerjasama</h2>

        <!-- Notifikasi Berhasil/Tidak Berhasil -->
        <?php if (!empty($message)) : ?>
            <div class="alert alert-success" role="alert">
                <?= htmlspecialchars($message); ?>
            </div>
        <?php endif; ?>

        <form action="" method="POST" enctype="multipart/form-data">
            <div class="form-group-horizontal">
                <label for="nama" class="form-label">Nama Instansi</label>
                <input type="text" class="form-control" name="nama" placeholder="Masukkan nama instansi Anda" required>
            </div>
            <div class="form-group-horizontal">
                <label for="alamat" class="form-label">Alamat</label>
                <textarea class="form-control" name="alamat" placeholder="Masukkan alamat Anda" required></textarea>
            </div>
            <div class="form-group-horizontal">
                <label for="nama_penandatangan" class="form-label">Nama Penanda Tangan</label>
                <input type="text" class="form-control" name="nama_penandatangan" placeholder="Masukkan nama penanda tangan" required>
            </div>
            <div class="form-group-horizontal">
                <label for="jabatan" class="form-label">Jabatan</label>
                <input type="text" class="form-control" name="jabatan" placeholder="Masukkan jabatan" required>
            </div>
            <div class="form-group-horizontal">
                <label for="nama_kontak" class="form-label">Nama Contact Person</label>
                <input type="text" class="form-control" name="nama_kontak" placeholder="Masukkan nama contact person" required>
            </div>
            <div class="form-group-horizontal">
                <label for="no_kontak" class="form-label">Nomor Telepon</label>
                <input type="tel" class="form-control" name="no_kontak" placeholder="08xxxxxxxxxx" required>
            </div>
            <div class="form-group-horizontal">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" name="email" placeholder="name@example.com" required>
            </div>
            <div class="form-group-horizontal">
                <label for="dokumen" class="form-label">Unggah Dokumen</label>
                <input class="form-control" type="file" name="dokumen">
            </div>

            <div class="d-grid mt-3">
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
        </form>
    </div>

    
</body>


