<?php
include "koneksi.php"
    ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>SIKERMA PNP</title>

    <!-- Core theme CSS (includes Bootstrap)-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="styles.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/chart.js@3.9.1/dist/chart.min.js"></script>

    <style>
        table thead {
            background-color: #fd7e14;

            color: white;
        }

        table tbody tr:hover {
            background-color: #f8f9fa;
        }



        .table-wrapper {

            margin: 20px auto;

            width: 95%;
        }

        .table td {
            vertical-align: middle;
            text-align: left;
        }

        .table th {
            text-align: center;
            color: white;
        }

        .modal-backdrop {
            background-color: rgba(0, 0, 0, 0.5) !important;
            /* Warna hitam dengan transparansi */
        }
    </style>


<body id="page-top">
    <!-- Navigation-->
    <nav class="navbar navbar-expand-lg navbar-dark fixed-top" id="mainNav">
        <div class="container">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarResponsive"
                aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
                Menu
                <i class="fas fa-bars ms-1"></i>
            </button>
            <div class="collapse navbar-collapse" id="navbarResponsive">
                <ul class="navbar-nav text-uppercase ms-auto py-4 py-lg-0">
                    <li class="nav-item"><a class="nav-link" href="#statistik">Statistik</a></li>
                    <li class="nav-item"><a class="nav-link" href="#Kerjasama">Kerjasama</a></li>
                    <li class="nav-item"><a class="nav-link" href="login.php">Login</a></li>

                </ul>
            </div>
        </div>
    </nav>
    <!-- Masthead-->
    <header class="bg">
        <video autoplay muted loop id="background-video">
            <source src="img/vidiobg6.mp4" type="video/mp4">
            Your browser does not support the video tag.
        </video>

        <style>
            header.bg {
                position: relative;
                text-align: center;
                color: #fff;
                padding-top: 3rem;
                /* Tambahkan ruang agar tidak terlalu dekat dengan konten */
                padding-bottom: 0rem;
                overflow: hidden;
                height: 450px;
                /* Pastikan tinggi header mencocokkan tinggi video */
            }


            #background-video {
                position: absolute;
                top: 0;
                left: 0;
                width: 100%;
                height: 700px;
                object-fit: cover;
                z-index: -1;
            }

            header.bg .container {
                position: relative;
                z-index: 1;
            }

            header.bg img {
                max-width: 150px;
                margin-bottom: 20px;
            }

            header.bg .btn {
                margin-top: 20px;
            }

            .masthead-subheading {
                font-family: 'Arial', sans-serif;
                /* Ubah font sesuai preferensi */
                font-size: 23px;
                /* Ubah ukuran font */
                font-weight: bold;
                /* Tambahkan gaya tebal */
                color: #ffffff;
                /* Ubah warna teks */
                text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.7);
                /* Tambahkan efek bayangan */
            }
            footer {
            margin-top: 30px;
            padding: 20px 0;
            background-color: #f8f9fa;
            text-align: center;
            font-size: 14px;
            color: #6c757d;
            border-top: 1px solid #dee2e6;
        }
        </style>

        <div class="container">
            <img src="logo_pnp.png" alt="">
            <div class="masthead-subheading">SIKERMA POLITEKNIK NEGERI PADANG</div>
            <a class="btn btn-primary btn-xl text-uppercase" href="pengajuan.php">Ajukan Kerjasama</a>
        </div>
    </header>



    <!-- Services-->
    <section class="page-section" id="statistik">
        <div class="container py-5">
            <div class="text-center mb-4">
                <h2 class="section-heading text-uppercase">Kerjasama Politeknik Negeri Padang</h2>
            </div>
            <div class="row g-4">
                <!-- Card 1 -->
                <div class="col-md-4">
                    <div class="card h-100 shadow">
                        <div class="card-body text-center">
                            <h5 class="card-title my-3">MoA & MoU</h5>
                            <?php
                            // Query untuk menghitung jumlah MoU (case-insensitive)
                            $sql = "SELECT COUNT(*) AS jumlah_MoU_MOA
                        FROM data ";
                            $result = $koneksi->query($sql);

                            if ($result && $row = $result->fetch_assoc()) {
                                echo "<h2>" . $row['jumlah_MoU_MOA'] . "</h2>";
                            } else {
                                echo "<p >Tidak ada data kerjasama MoU.</p>";
                            }
                            ?>
                            <!-- <p class="display-4 text-primary fw-bold">380</p> -->
                        </div>
                    </div>
                </div>
                <!-- Card 2 -->
                <div class="col-md-4">
                    <div class="card h-100 shadow">
                        <div class="card-body text-center">
                            <h5 class="card-title my-3">Memorandum of Agreement</h5>
                            <?php
                            $sql = "SELECT COUNT(*) AS jumlah_MoU FROM data WHERE jenis = 'mou'";
                            $result = $koneksi->query($sql);

                            if ($result && $row = $result->fetch_assoc()) {
                                echo "<h2>" . $row['jumlah_MoU'] . "</h2>";
                            } else {
                                echo "<p>Tidak ada data kerjasama MoU.</p>";
                            }
                            ?>
                        </div>
                    </div>
                </div>
                <!-- Card 3 -->
                <div class="col-md-4">
                    <div class="card h-100 shadow">
                        <div class="card-body text-center">
                            <h5 class="card-title my-3">Memorandum of Understanding</h5>
                            <?php
                            $sql = "SELECT COUNT(*) AS jumlah_MoA FROM data WHERE jenis = 'moa'";
                            $result = $koneksi->query($sql);

                            if ($result && $row = $result->fetch_assoc()) {
                                echo "<h2>" . $row['jumlah_MoA'] . "</h2>";
                            } else {
                                echo "<p>Tidak ada data kerjasama MoU.</p>";
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>

    <?php
    include "grafik.php"
        ?>
    <style>
        /* Card Container Styling */
        .card-daftar {
            border: 1px solid #ddd;
            /* Border tipis untuk mempercantik */
            border-radius: 8px;
            /* Membuat sudut card melengkung */
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            /* Bayangan untuk memberikan efek kedalaman */
            overflow: hidden;
            /* Agar elemen di dalam card tidak keluar dari area card */
        }

        /* Card Header Styling */
        .card-daftar-header {
            background-color: #007bff;
            /* Warna biru untuk header */
            color: #fff;
            /* Warna teks putih */
            font-weight: bold;
            /* Membuat teks header lebih tebal */
            font-size: 1.25rem;
            /* Ukuran font lebih besar */
            text-align: center;
            /* Teks berada di tengah */
            padding: 10px 20px;
            /* Menambahkan padding */
        }

        /* Card Body Styling */
        .card-daftar-body {
            padding: 20px;
            /* Menambahkan ruang di dalam card */
            background-color: #f8f9fa;
            padding: 15px;
        }

        /* Table Responsive Styling */
        .table-daftar-responsive {
            margin-top: 10px;
            /* Jarak antara header card dan tabel */
        }

        /* Table Styling */
        .table-daftar {
            border-collapse: separate;
            /* Memberikan jarak antar sel */
            border-spacing: 0 8px;
            /* Memberikan jarak antar baris */
        }

        .table-daftar th {
            background-color: #fd7e14;
            /* Warna oranye pada header tabel */
            color: white;
            /* Warna teks putih */
            text-align: center;
            /* Pusatkan teks di header tabel */
            padding: 10px;
        }

        .table-daftar td {
            background-color: white;
            /* Warna putih untuk isi tabel */
            vertical-align: middle;
            /* Teks berada di tengah secara vertikal */
            padding: 10px;
            /* Memberikan padding di dalam sel */
        }

        /* Table Row Hover Effect */
        .table-daftar tbody tr:hover {
            background-color: #f1f1f1;
            /* Warna abu-abu terang saat baris di-hover */
        }

        /* Button Styling */
        .btn {
            border-radius: 5px;
            /* Membuat tombol lebih melengkung */
        }

        .btn-warning {
            background-color:rgb(141, 216, 125);
            /* Warna kuning untuk tombol */
            border: none;
            /* Hilangkan border tombol */
        }

        .btn-warning:hover {
            background-color:rgb(221, 181, 59);
            /* Warna lebih gelap saat di-hover */
        }

        /* Responsiveness for Small Devices */
        @media (max-width: 576px) {
            .card-header {
                font-size: 1rem;
                /* Ukuran font lebih kecil pada perangkat kecil */
            }


        }
    </style>
    <div class="table-wrapper">
        <h2 class="text-center">Daftar Dokumen Kerjasama Politeknik Negeri Padang</h2>
        <div class="card-daftar-body">
            <div class="tabel-daftar-responsive">
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
                                <td class="text-center">
                                    <button class="btn btn-warning btn-sm btn-detail" data-bs-toggle="modal"
                                        data-bs-target="#detailModal" data-nomor="<?= $data['nomor'] ?>"
                                        data-jenis="<?= $data['jenis'] ?>" data-instansi="<?= $data['nama_instansi'] ?>"
                                        data-jangka="<?= $data['jangka_waktu'] ?>"
                                        data-mulai="<?= $data['awal_kerjasama'] ?>"
                                        data-akhir="<?= $data['akhir_kerjasama'] ?>"
                                        data-keterangan="<?= $data['keterangan'] ?>"
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
        </div>


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
                            <div class="col-4"><strong>Nomor</strong></div>
                            <div class="col-6" id="modalNomor"></div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-4"><strong>Jenis Kerjasama</strong></div>
                            <div class="col-6" id="modalJenis"></div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-4"><strong>Nama Instansi</strong></div>
                            <div class="col-6" id="modalInstansi"></div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-4"><strong>Jangka Waktu</strong></div>
                            <div class="col-6" id="modalJangka"></div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-4"><strong>Tanggal Mulai</strong></div>
                            <div class="col-6" id="modalMulai"></div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-4"><strong>Tanggal Akhir</strong></div>
                            <div class="col-6" id="modalAkhir"></div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-4"><strong>Keterangan</strong></div></div>
                            <div class="col-6" id="modalKeterangan"></div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-4"><strong>Kegiatan</strong></div>
                            <div class="col-6" id="modalKegiatan"></div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>

   <!-- Footer -->
   <footer>
        &copy; <?= date("Y") ?> Sistem Kerjasama Politeknik Negeri Padang - Dikembangkan oleh [kelompok 7 MI2A]. Semua Hak Dilindungi.
    </footer>


    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/2.1.8/js/dataTables.js"></script>
    <script src="https://cdn.datatables.net/2.1.8/js/dataTables.bootstrap5.js"></script>

    <script>
        new DataTable("#Tabelkerjasama");

        $(document).ready(function () {
            $('#myTable').DataTable(); // Gantilah '#myTable' dengan ID tabel Anda
        });
    </script>
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

    <!-- Bootstrap core JS-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Core theme JS-->
    <script src="scripts.js"></script>
    <!-- * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *-->
    <!-- * *                               SB Forms JS                               * *-->
    <!-- * * Activate your form at https://startbootstrap.com/solution/contact-forms * *-->
    <!-- * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *-->
    <script src="https://cdn.startbootstrap.com/sb-forms-latest.js"></script>
</body>

</html>