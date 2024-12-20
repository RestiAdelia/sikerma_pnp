<?php
if (isset($_POST['submit'])) {
    include 'koneksi.php';

    // Ambil data dari form
    $nomor = $_POST['nomor'];
    $jenis = $_POST['jenis'];
    $nama_instansi = $_POST['nama_instansi'];
    $jangka_waktu = $_POST['jangka_waktu'];
    $awal_kerjasama = $_POST['awal_kerjasama'];
    $akhir_kerjasama = $_POST['akhir_kerjasama'];
    $keterangan = ''; // Inisialisasi kosong untuk keterangan
    $tindakan = $_POST['tindakan'];
    $provinsi = $_POST['provinsi'];
    $kota = $_POST['kota'];
    $bidang_usaha = $_POST['bidang_usaha'];
    $jurusan = $_POST['jurusan'];
    $topik_kerjasama = $_POST['topik_kerjasama'];
    $website = $_POST['website'];
    $alamat = $_POST['alamat'];
    $no_tlpn = $_POST['no_tlpn'];
    $email = $_POST['email'];
    $kegiatan = $_POST['kegiatan'];

    // Logika untuk menentukan status keterangan berdasarkan tanggal akhir_kerjasama
    $currentDate = date('Y-m-d'); // Ambil tanggal saat ini
    if ($akhir_kerjasama < $currentDate) {
        $keterangan = 'expired';
    } else {
        $keterangan = 'aktif';
    }

    // Mengambil data file
    $fileName = $_FILES["file"]["name"];
    $fileSize = $_FILES["file"]["size"];
    $fileTemp = $_FILES["file"]["tmp_name"];
    $fileDir = "uploadS/";
    $uploadPath = $fileDir . basename($fileName);

    // Pastikan direktori upload ada
    if (!is_dir($fileDir)) {
        mkdir($fileDir, 0777, true); // Buat folder jika belum ada
    }

    // Upload file ke folder
    if (move_uploaded_file($fileTemp, $uploadPath)) {
        // Simpan data ke database
        $sql = "INSERT INTO data 
                (nomor, jenis, nama_instansi, jangka_waktu, awal_kerjasama, akhir_kerjasama, keterangan, tindakan, provinsi, kota, bidang_usaha, jurusan, topik_kerjasama, website, alamat, no_tlpn, email, dokumen, kegiatan) 
                VALUES ('$nomor', '$jenis', '$nama_instansi', '$jangka_waktu', '$awal_kerjasama', '$akhir_kerjasama', '$keterangan', '$tindakan', '$provinsi', '$kota', '$bidang_usaha', '$jurusan', '$topik_kerjasama', '$website', '$alamat', '$no_tlpn', '$email', '$fileName', '$kegiatan')";

        if (mysqli_query($koneksi, $sql)) {
            echo "<script>alert('Data berhasil diinputkan'); window.location='navbar.php?p=crud'</script>";
        } else {
            echo "Error: " . mysqli_error($koneksi);
        }
    } else {
        echo "Gagal mengupload file.";
    }
}
?>

<!-- Style dan HTML form tetap sama -->

    <style>
        body {
            background-color: #f8f9fa; /* Warna latar belakang */
        }

        .form-container {
            max-width: 800px;
            margin: 50px auto;
            background: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .form-container h1 {
            text-align: center;
            margin-bottom: 20px;
            color: #343a40; /* Warna teks header */
        }

        .form-control {
            margin-bottom: 15px;
        }

        .btn-primary {
            width: 100%;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="form-container">
            <h1>Form Kerjasama</h1>
            <form method="POST" action="" enctype="multipart/form-data">
                <!-- Form fields -->
                <input type="text" name="nomor" placeholder="Nomor" class="form-control" required>
                <select name="jenis" class="form-select">
                    <option value="mou">MoU</option>
                    <option value="moa">MoA</option>
                </select><br>
                <input type="text" name="nama_instansi" placeholder="Nama Instansi" class="form-control" required>
                <input type="text" name="jangka_waktu" placeholder="Jangka Waktu" class="form-control">
                <input type="date" name="awal_kerjasama" placeholder="Awal Kerjasama" class="form-control">
                <input type="date" name="akhir_kerjasama" placeholder="Akhir Kerjasama" class="form-control">
                <select name="keterangan" class="form-select">
                    <option value="mou">aktif</option>
                    <option value="moa">expired</option>
                </select><br>
                <input type="text" name="tindakan" placeholder="Tindakan" class="form-control">
                <input type="text" name="provinsi" placeholder="Provinsi" class="form-control">
                <input type="text" name="kota" placeholder="Kota" class="form-control">
                <input type="text" name="bidang_usaha" placeholder="Bidang Usaha" class="form-control">
                <input type="text" name="jurusan" placeholder="Jurusan" class="form-control">
                <input type="text" name="topik_kerjasama" placeholder="Topik Kerjasama" class="form-control">
                <input type="url" name="website" placeholder="Website" class="form-control">
                <input type="text" name="alamat" placeholder="Alamat" class="form-control">
                <input type="text" name="no_tlpn" placeholder="No Telepon" class="form-control">
                <input type="email" name="email" placeholder="Email" class="form-control">
                <input type="file" name="file" placeholder="file" class="form-control">
                <input type="text" name="kegiatan" placeholder="Kegiatan" class="form-control">
                <button type="submit"  name="submit" class="btn btn-primary">Simpan</button>
            </form>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
