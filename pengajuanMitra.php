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
       <style>
    /* Reset CSS */
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    body {
        font-family: 'Arial', sans-serif;
        background-color: #f4f7fc;
        color: #333;
    }

    /* Container Form */
    .form-container {
        background-color: white;
        max-width: 800px;
        margin: 30px auto;
        padding: 30px;
        border-radius: 10px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    }

    /* Judul Form */
    .form-container h2 {
        font-size: 2rem;
        color: #333;
        text-align: center;
        margin-bottom: 20px;
    }

    /* Gaya untuk form-group */
    .form-group {
        margin-bottom: 20px;
    }

    .form-group label {
        font-size: 1rem;
        font-weight: bold;
        display: block;
        margin-bottom: 8px;
    }

    .form-group input,
    .form-group textarea,
    .form-group select {
        width: 100%;
        padding: 10px;
        font-size: 1rem;
        border: 1px solid #ccc;
        border-radius: 5px;
        box-shadow: inset 0 1px 3px rgba(0, 0, 0, 0.1);
    }

    .form-group input[type="file"] {
        padding: 5px;
    }

    .form-group textarea {
        resize: vertical;
    }

    /* Tombol Submit */
    .btn-primary {
        background-color: #ff9f00;
        color: white;
        border: none;
        padding: 12px 20px;
        font-size: 1.2rem;
        border-radius: 5px;
        width: 100%;
        cursor: pointer;
    }

    .btn-primary:hover {
        background-color: #e68a00;
    }

    /* Notifikasi */
    .alert {
        padding: 15px;
        background-color: #4CAF50;
        color: white;
        margin-bottom: 20px;
        border-radius: 5px;
        text-align: center;
    }

    .alert-error {
        background-color: #f44336;
    }

    /* Responsif */
    @media (max-width: 768px) {
        .form-container {
            padding: 20px;
        }
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
                <input type="text" class="form-control" name="nama" required>
            </div>
            <div class="form-group-horizontal">
                <label for="alamat" class="form-label">Alamat</label>
                <textarea class="form-control" name="alamat"  required></textarea>
            </div>
            <div class="form-group-horizontal">
                <label for="nama_penandatangan" class="form-label">Nama Penanda Tangan</label>
                <input type="text" class="form-control" name="nama_penandatangan"  required>
            </div>
            <div class="form-group-horizontal">
                <label for="jabatan" class="form-label">Jabatan</label>
                <input type="text" class="form-control" name="jabatan" required>
            </div>
            <div class="form-group-horizontal">
                <label for="nama_kontak" class="form-label">Nama Contact Person</label>
                <input type="text" class="form-control" name="nama_kontak" required>
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


