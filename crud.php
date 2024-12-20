<html>

<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
</head>

<body>
    <?php
    include 'koneksi.php';
    // Pastikan $level diambil dari sesi atau basis data
    $level = isset($_SESSION['level']) ? $_SESSION['level'] : '';  // Contoh dari sesi
    $aksi = isset($_GET['aksi']) ? $_GET['aksi'] : 'list';

    switch ($aksi) {
        case 'list':
            ?>
            <h2>Data Kerjasama</h2>
            <?php if ($level == 'Staf') { ?>
                <a href="navbar.php?p=crud&aksi=input" class="btn btn-warning mb-2"> <i class="bi bi-plus-circle-dotted"></i>New</a>
            <?php } ?>
            <table id="Tabelkerjasama" class="table table-bordered table-striped text-center">
                <thead class="kepala_tabel">
                    <tr>
                        <th class="text-center">No</th>
                        <th class="text-center">Nomor</th>
                        <th class="text-center">Jenis Kerjasama</th>
                        <th class="text-center">Nama Instansi</th>
                        <th class="text-center">Jangka Waktu</th>
                        <th class="text-center">Tanggal Mulai</th>
                        <th class="text-center">Tanggal Akhir</th>
                        <th class="text-center">Provinsi</th>
                        <th class="text-center">Kota</th>
                        <th class="text-center">Bidang Usaha</th>
                        <th class="text-center">Jurusan</th>
                        <th class="text-center">Topik Kerjasama</th>
                        <th class="text-center">Website</th>
                        <th class="text-center">Alamat</th>
                        <th class="text-center">No Telepon</th>
                        <th class="text-center">Email</th>
                        <th class="text-center">Link Dokumen</th>
                        <th class="text-center">Status</th>
                        <th>Aksi</th> <!-- Kolom Aksi hanya tampil jika level staf -->
                    </tr>
                </thead>

                <style>
                    .kepala_tabel {
                        background-color: #FF8D21;
                        color: white;
                    }

                    .btn-tutup {
                        background-color: #FF8D21;
                        border-color: #FF8D21;
                        color: #fff;
                    }
                </style>

                <tbody>
                    <?php
                    $ambil = mysqli_query($koneksi, "SELECT * FROM data");
                    $no = 1;
                    while ($data = mysqli_fetch_array($ambil)) {
                        $tanggal_akhir = strtotime($data['akhir_kerjasama']);
                        $tanggal_sekarang = time();
                        ?>
                        <tr>
                            <td style="text-align:center"><?php echo $no ?></td>
                            <td style="text-align:left"><?= $data['nomor'] ?></td>
                            <td><?= $data['jenis'] ?></td>
                            <td style="text-align:left"><?= $data['nama_instansi'] ?></td>
                            <td><?= $data['jangka_waktu'] ?></td>
                            <td><?= $data['awal_kerjasama'] ?></td>
                            <td><?= $data['akhir_kerjasama'] ?></td>
                            <td><?= $data['provinsi'] ?></td>
                            <td><?= $data['kota'] ?></td>
                            <td><?= $data['bidang_usaha'] ?></td>
                            <td><?= $data['jurusan'] ?></td>
                            <td><?= $data['topik_kerjasama'] ?></td>
                            <td><?= $data['website'] ?></td>
                            <td><?= $data['alamat'] ?></td>
                            <td><?= $data['no_tlpn'] ?></td>
                            <td><?= $data['email'] ?></td>
                            <td>
                                <?php if (!empty($data['dokumen'])): ?>
                                    <a href="<?= $data['dokumen'] ?>" target="_blank" class="btn btn-link">Lihat Dokumen</a>
                                <?php else: ?>
                                    <span class="text-muted">Tidak Ada Dokumen</span>
                                <?php endif; ?>
                            </td>

                            <td
                                style="color: <?= $tanggal_akhir >= $tanggal_sekarang ? 'green' : 'red'; ?>; font-family:Arial,sans-serif; font-size:14px;">
                                <?= $tanggal_akhir >= $tanggal_sekarang ? '<span style ="font-family: Verdana ; font-size: 14px;">Aktif</span>' : '<span style="font-family: Verdana; font-size: 14px;">Expired</span>'; ?>
                            </td>
                            <td class="text-nowrap">
                                <?php if ($level == 'Staf') { ?>
                                    <a href="navbar.php?p=crud&aksi=edit&id_edit=<?= $data['id'] ?>" class="btn btn-warning">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>
                                    <a href="navbar.php?p=crud&aksi=delete&id_hapus=<?= $data['id'] ?>" class="btn btn-danger"
                                        onclick="return confirm('Yakin akan menghapus data?')">
                                        <i class="bi bi-trash"></i>
                                    </a><?php } ?>
                                <button class="btn btn-info" data-bs-toggle="modal" data-bs-target="#detailModal<?= $data['id'] ?>">
                                    <i class="bi bi-info-circle"></i>
                                </button>

                                <!-- Modal -->
                                <div class="modal fade" id="detailModal<?= $data['id'] ?>" tabindex="-1"
                                    aria-labelledby="detailModalLabel<?= $data['id'] ?>" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="detailModalLabel<?= $data['id'] ?>">Detail Kerjasama
                                                </h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <p><strong>Nomor:</strong> <?= $data['nomor'] ?></p>
                                                <p><strong>Jenis Kerjasama:</strong> <?= $data['jenis'] ?></p>
                                                <p><strong>Nama Instansi:</strong> <?= $data['nama_instansi'] ?></p>
                                                <p><strong>Jangka Waktu:</strong> <?= $data['jangka_waktu'] ?></p>
                                                <p><strong>Tanggal Mulai:</strong> <?= $data['awal_kerjasama'] ?></p>
                                                <p><strong>Tanggal Akhir:</strong> <?= $data['akhir_kerjasama'] ?></p>
                                                <p><strong>Status:</strong>
                                                    <?= $tanggal_akhir >= $tanggal_sekarang ? 'Aktif' : 'Expired'; ?></p>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-tutup" data-bs-dismiss="modal">Tutup</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <?php
                        $no++;
                    }
                    ?>
                </tbody>
            </table>
            <?php
            break;

        case 'input':
            if ($level == 'Staf') {
                include "tambah.php";
            } else {
                echo "Akses ditolak.";
            }
            break;

        case 'edit':
            if ($level == 'Staf') {
                include 'edit.php';
            } else {
                echo "Akses ditolak.";
            }
            break;

        case 'delete':
            if ($level == 'Staf') {
                include 'koneksi.php';
                $id = $_GET['id_hapus'];
                $query = "DELETE FROM data WHERE id='$id'";
                $result = mysqli_query($koneksi, $query);

                if ($result) {
                    echo "<script>alert('Data berhasil dihapus!'); window.location='navbar.php?p=crud'</script>";
                } else {
                    echo "Error: " . mysqli_error($koneksi);
                }
            } else {
                echo "Akses ditolak.";
            }
            break;
    }
    ?>
</body>

</html>