<?php
include("koneksi.php");

// Ambil data dari form
$id_kegiatan = $_POST['id_kegiatan'];
$judul_kegiatan = $_POST['judul_kegiatan'];
$nama_instansi = $_POST['nama_instansi'];
$isi_kegiatan = $_POST['isi_kegiatan'];

// Proses gambar jika ada yang di-upload
if ($_FILES['gambar']['name']) {
    $target_dir = "uploadsgambar/";
    $target_file = $target_dir . basename($_FILES["gambar"]["name"]);
    move_uploaded_file($_FILES["gambar"]["tmp_name"], $target_file);
    $gambar = $target_file;
} else {
    // Jika gambar tidak di-upload, gunakan gambar lama
    $gambar = $_POST['gambar_lama'];
}

// Query untuk update data kegiatan
$sql = "UPDATE kegiatan SET judul_kegiatan='$judul_kegiatan', gambar='$gambar', nama_instansi='$nama_instansi', isi_kegiatan='$isi_kegiatan' WHERE id_kegiatan=$id_kegiatan";

if ($koneksi->query($sql) === TRUE) {
    echo "Data berhasil diperbarui!";
    header("Location: navbar.php?p=kegiatan");  // Redirect ke halaman galeri setelah berhasil
} else {
    echo "Error: " . $sql . "<br>" . $koneksi->error;
}

$koneksi->close();
?>
