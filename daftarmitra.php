<?php
include("koneksi.php");
?>
<div class="table-wrapper">
        <h2 class="text-center">Daftar Dokumen Kerjasama Politeknik Negeri Padang</h2>
        <table id="Tabelkerjasama" class="table table-bordered table-striped table-hover">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nomor</th>
                    <th>Jenis Kerjasama</th>
                    <th>Nama Instansi</th>
                    <th>Jangka Waktu</th>
                    <th>Tanggal Mulai</th>
                    <th>Tanggal Akhir</th>
                    <th>Keterangan</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $ambil = mysqli_query($koneksi, "SELECT * FROM data");
                $no = 1;
                while ($data = mysqli_fetch_array($ambil)) {
                    ?>
                    <tr>
                        <td><?php echo $no ?></td>
                        <td><?= $data['nomor'] ?></td>
                        <td><?= $data['jenis'] ?></td>
                        <td><?= $data['nama_instansi'] ?></td>
                        <td><?= $data['jangka_waktu'] ?></td>
                        <td><?= $data['awal_kerjasama'] ?></td>
                        <td><?= $data['akhir_kerjasama'] ?></td>
                        <td><?= $data['keterangan'] ?></td>
                        <td>
                            <button class="btn btn-warning btn-sm btn-detail" data-bs-toggle="modal"
                                data-bs-target="#detailModal" data-nomor="<?= $data['nomor'] ?>"
                                data-jenis="<?= $data['jenis'] ?>" data-instansi="<?= $data['nama_instansi'] ?>"
                                data-jangka="<?= $data['jangka_waktu'] ?>" data-mulai="<?= $data['awal_kerjasama'] ?>"
                                data-akhir="<?= $data['akhir_kerjasama'] ?>" data-keterangan="<?= $data['keterangan'] ?>"
                                data-kegiatan="<?= $data['kegiatan'] ?>">
                                <i class="bi bi-list"></i>
                            </button>
                        </td>

                    </tr>
                    <?php
                    $no++;
                }
                ?>
            </tbody>
        </table>
    </div>
    <!-- Modal untuk Detail -->
    <div class="modal fade" id="detailModal" tabindex="-1" aria-labelledby="detailModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg"> <!-- Tambahkan 'modal-lg' agar modal lebih besar -->
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="detailModalLabel">Detail Kerjasama</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="container">
                        <div class="row mb-2">
                            <div class="col-4"><strong>Nomor:</strong></div>
                            <div class="col-8" id="modalNomor"></div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-4"><strong>Jenis Kerjasama:</strong></div>
                            <div class="col-8" id="modalJenis"></div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-4"><strong>Nama Instansi:</strong></div>
                            <div class="col-8" id="modalInstansi"></div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-4"><strong>Jangka Waktu:</strong></div>
                            <div class="col-8" id="modalJangka"></div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-4"><strong>Tanggal Mulai:</strong></div>
                            <div class="col-8" id="modalMulai"></div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-4"><strong>Tanggal Akhir:</strong></div>
                            <div class="col-8" id="modalAkhir"></div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-4"><strong>Keterangan:</strong></div>
                            <div class="col-8" id="modalKeterangan"></div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-4"><strong>Kegiatan:</strong></div>
                            <div class="col-8" id="modalKegiatan"></div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
        document.addEventListener('DOMContentLoaded', function () {
            // Ambil semua tombol detail
            const detailButtons = document.querySelectorAll('.btn-detail');

            detailButtons.forEach(button => {
                button.addEventListener('click', function () {
                    // Ambil data dari atribut data-*
                    const nomor = this.getAttribute('data-nomor');
                    const jenis = this.getAttribute('data-jenis');
                    const instansi = this.getAttribute('data-instansi');
                    const jangka = this.getAttribute('data-jangka');
                    const mulai = this.getAttribute('data-mulai');
                    const akhir = this.getAttribute('data-akhir');
                    const keterangan = this.getAttribute('data-keterangan');

                    // Masukkan data ke dalam modal
                    document.getElementById('modalNomor').textContent = nomor;
                    document.getElementById('modalJenis').textContent = jenis;
                    document.getElementById('modalInstansi').textContent = instansi;
                    document.getElementById('modalJangka').textContent = jangka;
                    document.getElementById('modalMulai').textContent = mulai;
                    document.getElementById('modalAkhir').textContent = akhir;
                    document.getElementById('modalKeterangan').textContent = keterangan;
                });
            });
        });
    </script>