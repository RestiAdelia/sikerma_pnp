<?php
include 'koneksi.php';

// Ambil data berdasarkan ID dari URL
$id_edit = $_GET['id_edit'] ?? '';
$sql = mysqli_query($koneksi, "SELECT * FROM data WHERE id='$id_edit'");

if ($sql && mysqli_num_rows($sql) > 0) {
    $data = mysqli_fetch_array($sql);
} else {
    echo "Data tidak ditemukan.";
    exit;
}
?>
<style>
  
    .form-container {
        max-width: 800px;
        margin: 0 auto;

        padding: 20px;
        border-radius: 8px;

    }

    .form-container h1 {
        font-size: 1.5rem;
        color: #080808;
        margin-bottom: 10px;
        text-align: center;
        /* Pastikan teks rata kiri */
    }


    .form-container small {
        font-size: 0.85rem;
        color: #a5a5a5;
    }

    .form-group {
        display: flex;
        align-items: center;
        margin-bottom: 15px;
    }

    .form-group label {
        flex: 0 0 150px;
        margin-right: 10px;
        text-align: left;
    }

    .btn-link {
        display: inline-block;
        padding: 6px 15px;
        color: #fff;
        background-color: #007bff;
        border: none;
        border-radius: 5px;
        text-decoration: none;
        text-align: center;
        cursor: pointer;
      
    }

    .btn-link:hover {
        background-color: #0056b3;
    }
</style>


<div class="container">
    <div class="form-container">
        <h1>Edit Data Kerjasama</h1>
        <form method="POST" action="" enctype="multipart/form-data">

            <input type="hidden" name="id" value="<?= ($data['id']) ?>">
            <div class="form-group">
                <label for="nomor" class="form-label">Nomor</label>
                <input type="text" id="nomor" name="nomor" placeholder="Nomor" class="form-control"
                    value="<?= ($data['nomor']) ?>" required>
            </div>
            <div class="form-group">
                <label for="jenis" class="form-label">Jenis</label>
                <select id="jenis" name="jenis" class="form-select">
                    <option value="mou" <?= $data['jenis'] == 'mou' ? 'selected' : '' ?>>MoU</option>
                    <option value="moa" <?= $data['jenis'] == 'moa' ? 'selected' : '' ?>>MoA</option>
                </select>
            </div>
            <div class="form-group">
                <label for="nama_instansi" class="form-label">Nama Instansi</label>
                <input type="text" id="nama_instansi" name="nama_instansi" placeholder="Nama Instansi"
                    class="form-control" value="<?= ($data['nama_instansi']) ?>" required>
            </div>
            <div class="form-group">
                <label for="jangka_waktu" class="form-label">Jangka Waktu</label>
                <input type="text" id="jangka_waktu" name="jangka_waktu" placeholder="Jangka Waktu" class="form-control"
                    value="<?= ($data['jangka_waktu']) ?>">
            </div>
            <div class="form-group">
                <label for="awal_kerjasama" class="form-label">Awal Kerjasama</label>
                <input type="date" id="awal_kerjasama" name="awal_kerjasama" class="form-control"
                    value="<?= ($data['awal_kerjasama']) ?>">
            </div>
            <div class="form-group">
                <label for="akhir_kerjasama" class="form-label">Akhir Kerjasama</label>
                <input type="date" id="akhir_kerjasama" name="akhir_kerjasama" class="form-control"
                    value="<?= ($data['akhir_kerjasama']) ?>">
            </div>
            <div class="form-group">
                <label for="keterangan" class="form-label">Keterangan</label>
                <textarea id="keterangan" name="keterangan" placeholder="Keterangan"
                    class="form-control"><?= ($data['keterangan']) ?></textarea>
            </div>
            <div class="form-group">
                <label for="tindakan" class="form-label">Tindakan</label>
                <input type="text" id="tindakan" name="tindakan" placeholder="Tindakan" class="form-control"
                    value="<?= ($data['tindakan']) ?>">
            </div>
            <div class="form-group">
                <label for="provinsi" class="form-label">Provinsi</label>
                <input type="text" id="provinsi" name="provinsi" placeholder="Provinsi" class="form-control"
                    value="<?= ($data['provinsi']) ?>">
            </div>
            <div class="form-group">
                <label for="kota" class="form-label">Kota</label>
                <input type="text" id="kota" name="kota" placeholder="Kota" class="form-control"
                    value="<?= ($data['kota']) ?>">
            </div>
            <div class="form-group">
                <label for="bidang_usaha" class="form-label">Bidang Usaha</label>
                <input type="text" id="bidang_usaha" name="bidang_usaha" placeholder="Bidang Usaha" class="form-control"
                    value="<?= ($data['bidang_usaha']) ?>">
            </div>
            <div class="form-group">
                <label for="jurusan" class="form-label">Jurusan</label>
                <input type="text" id="jurusan" name="jurusan" placeholder="Jurusan" class="form-control"
                    value="<?= ($data['jurusan']) ?>">
            </div>
            <div class="form-group">
                <label for="topik_kerjasama" class="form-label">Topik Kerjasama</label>
                <input type="text" id="topik_kerjasama" name="topik_kerjasama" placeholder="Topik Kerjasama"
                    class="form-control" value="<?= ($data['topik_kerjasama']) ?>">
            </div>
            <div class="form-group">
                <label for="website" class="form-label">Website</label>
                <input type="url" id="website" name="website" placeholder="Website" class="form-control"
                    value="<?= ($data['website']) ?>">
            </div>
            <div class="form-group">
                <label for="alamat" class="form-label">Alamat</label>
                <input type="text" id="alamat" name="alamat" placeholder="Alamat" class="form-control"
                    value="<?= ($data['alamat']) ?>">
            </div>
            <div class="form-group">
                <label for="no_tlpn" class="form-label">No Telepon</label>
                <input type="text" id="no_tlpn" name="no_tlpn" placeholder="No Telepon" class="form-control"
                    value="<?= ($data['no_tlpn']) ?>">
            </div>
            <div class="form-group">
                <label for="email" class="form-label">Email</label>
                <input type="email" id="email" name="email" placeholder="Email" class="form-control"
                    value="<?= ($data['email']) ?>">
            </div>
            <div class="form-group">
                <label for="file" class="form-label">Upload File</label>
                <input type="file" id="file" name="file" class="form-control">
            </div>
            <small class="text-muted">File saat ini: <?= ($data['dokumen']) ?></small>
            <input type="hidden" name="dokumen_lama" value="<?= ($data['dokumen']) ?>">
    </div>
    <div class="form-group">
        <label for="kegiatan" class="form-label">Kegiatan</label>
        <input type="text" id="kegiatan" name="kegiatan" placeholder="Kegiatan" class="form-control"
            value="<?= ($data['kegiatan']) ?>">
    </div>

    <!-- Tombol Submit -->
    <button type="submit" name="submit" class="btn btn-primary">Update</button>
    <a href="navbar.php?p=crud" class="btn-link">Cancel</a>

    </form>
</div>
</div>

<?php
// Proses update
if (isset($_POST['submit'])) {
    // Ambil data dari form
    $id = $_POST['id'];
    $nomor = $_POST['nomor'];
    $jenis = $_POST['jenis'];
    $nama_instansi = $_POST['nama_instansi'];
    $jangka_waktu = $_POST['jangka_waktu'];
    $awal_kerjasama = $_POST['awal_kerjasama'];
    $akhir_kerjasama = $_POST['akhir_kerjasama'];
    $keterangan = $_POST['keterangan'];
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

    // Proses upload file
    $file_name = $_FILES['file']['name'];
    $file_tmp = $_FILES['file']['tmp_name'];
    $dokumen_lama = $_POST['dokumen_lama'];

    if (!empty($file_name)) {
        $upload_dir = "uploads/";
        $file_path = $upload_dir . $file_name;

        if (move_uploaded_file($file_tmp, $file_path)) {
            $dokumen = $file_name;
        } else {
            echo "Gagal mengupload file.";
            exit;
        }
    } else {
        $dokumen = $dokumen_lama;
    }

    $query = "UPDATE data SET 
                nomor='$nomor', 
                jenis='$jenis', 
                nama_instansi='$nama_instansi', 
                jangka_waktu='$jangka_waktu', 
                awal_kerjasama='$awal_kerjasama', 
                akhir_kerjasama='$akhir_kerjasama', 
                keterangan='$keterangan', 
                tindakan='$tindakan', 
                provinsi='$provinsi', 
                kota='$kota', 
                bidang_usaha='$bidang_usaha', 
                jurusan='$jurusan', 
                topik_kerjasama='$topik_kerjasama', 
                website='$website', 
                alamat='$alamat', 
                no_tlpn='$no_tlpn', 
                email='$email', 
                dokumen='$dokumen', 
                kegiatan='$kegiatan' 
              WHERE id='$id'";

    $result = mysqli_query($koneksi, $query);

    if ($result) {
        echo "<script>alert('Data berhasil diupdate!'); window.location='navbar.php?p=crud';</script>";
    } else {
        echo "Error: " . mysqli_error($koneksi);
    }
}
?>