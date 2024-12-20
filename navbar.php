<?php
ob_start();
session_start();


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Dashboard</title>
    <!-- Bootstrap CSS -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/2.1.8/css/dataTables.bootstrap5.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/3.2.0/css/buttons.bootstrap5.min.css">


    <!-- FontAwesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js@3.9.1/dist/chart.min.js"></script>
</head>
<style>
    .body {

        background: linear-gradient(to bottom, #ff914d, #ffe6cc);
    }

    /* Custom sidebar color */
    .sidebar {
        height: 100vh;
        width: 250px;
        background: linear-gradient(to bottom, #ff6600, #ff9933);
        color: #fff;
        position: fixed;
        left: -250px;
        /* Disembunyikan secara default */
        transition: all 0.3s ease;
        padding-top: 20px;
        z-index: 1050;
        /* Di atas konten lainnya */
        box-shadow: 2px 0px 5px rgba(0, 0, 0, 0.2);
    }

    .sidebar.show {
        left: 0;
        /* Tampilkan sidebar */
    }

    /* Navbar styling */
    .navbar-custom {
        background-color: #ff6600;
        box-shadow: 0px 3px 10px rgba(0, 0, 0, 0.1);
        position: fixed;
        /* Menjadikan navbar tetap pada posisi saat di-scroll */
        top: 0;
        width: 100%;
        z-index: 10;
        /* Pastikan navbar berada di atas konten lainnya */
        padding: 10px;

    }

    .navbar-custom .navbar-nav .nav-item {
        color: white;
    }

    .navbar-custom .navbar-nav .nav-item:hover {
        background-color: #ff4500;
        border-radius: 10 px;
    }

    .navbar-custom input {
        width: 250px;
        border-radius: 5px;
        padding: 5px;
        border: none;
    }

    /* Main content area */
    .content {
        width: 100%;
        padding: 20px;
        margin-top: 60px;
        /* Memberikan ruang agar konten tidak tertutup oleh navbar */
        transition: margin-left 0.3s ease, width 0.3s ease;
    }

    .content.shifted {

        margin-left: 250px;
        /* Geser jika sidebar aktif */
    }


    .sidebar a {
        color: #fff;
        text-decoration: none;
        padding: 12px;
        font-size: 18px;
        display: block;
        white-space: nowrap;
    }

    /* icon di samping tulisan navbar */
    .sidebar a i {
        font-size: 20px;
        /* Ukuran ikon diperbesar */
        margin-right: 10px;
        /* Jarak antara ikon dan teks */
    }

    .sidebar a:hover {
        background-color: #ff6600;
        color: #fff;
        border-radius: 5px;
    }

    .sidebar a.active {
        background-color: #ff4500;
        color: #fff;
    }

    .icon_garis_tiga {
        font-size: 28px;
        /* Sesuaikan ukuran ikon */
    }

    .navbar-brand.text-white {
        margin-left: 20px;
        /* Menggeser teks ke kanan */
    }
</style>

<body>
    <nav class="navbar navbar-expand-lg navbar-custom fixed-top">
        <div class="container-fluid">
            <span class="icon_garis_tiga" id="sidebarToggle"><i class="fas fa-bars"></i></span>
            <a class="navbar-brand text-white" href="#">Admin Dashboard</a>
            <div class="d-flex ms-auto me-3 align-items-center">
                <!-- Profil Section -->
                <div class="dropdown">
                    <button class="btn btn-outline-light dropdown-toggle" type="button" id="profileDropdown"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fas fa-user-circle"></i>
                        <?php
                        if (isset($_SESSION['username'])) {
                            echo htmlspecialchars($_SESSION['username']); // Menampilkan username login
                        } else {
                            echo "Guest";
                        }
                        ?>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="profileDropdown">
                        <li><a class="dropdown-item" href="#">Profile</a></li>
                        <li><a class="dropdown-item" href="#">Settings</a></li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li><a class="dropdown-item" href="logout.php">Logout</a></li>
                    </ul>

                </div>
            </div>
        </div>
    </nav>

    <!-- Sidebar -->
    <div class="sidebar" id="sidebar">
        <h4 class="text-center">Menu</h4>
        <hr class="text-white">
        <a href="navbar.php?p=dashboard"><i class="fas fa-home"></i> Dashboard</a>
        <a href="navbar.php?p=kegiatan"><i class="fas fa-walking"></i> Kegiatan</a>
        <a href="navbar.php?p=usulan"><i class="fa fa-table"></i>Daftar Usulan Kerjasama</a>
        <a href="navbar.php?p=crud"><i class=" 	fas fa-clipboard"></i> Data Kerjasama</a>
        <a href="navbar.php?p=jurusan"><i class="fas fa-users"></i> Tabel User Jurusan</a>
        <a href="navbar.php?p=mitra"><i class="fas fa-users"></i> Tabel User Mitra</a>
        
    </div>



    <!-- Main Content -->
    <div class="content" id="mainContent">

        <?php
        $page = isset($_GET['p']) ? $_GET['p'] : 'dashboard';
        if ($page == 'dashboard')
            include 'dashboardadmin.php';
        if ($page == 'kegiatan')
            include 'kegiatan.php';
        if ($page == 'usulan')
            include 'usulan.php';
        if ($page == 'crud')
            include 'crud.php';
        if ($page == 'jurusan')
            include 'jurusan.php';
            if ($page == 'mitra')
            include 'mitra.php';


        if (isset($_GET['query'])) {
            $query = $_GET['query'];

            // Sambungkan ke database
            $conn = new mysqli('localhost', 'username', 'password', 'database');
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            // Query data
            $sql = "SELECT * FROM your_table WHERE name LIKE ?";
            $stmt = $conn->prepare($sql);
            $likeQuery = "%" . $query . "%";
            $stmt->bind_param("s", $likeQuery);
            $stmt->execute();
            $result = $stmt->get_result();

            $data = [];
            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }

            echo json_encode($data);
            $conn->close();
        }



        ?>


        <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
        <script src="https://cdn.datatables.net/2.1.8/js/dataTables.js"></script>
        <script src="https://cdn.datatables.net/2.1.8/js/dataTables.bootstrap5.js"></script>
        <script>
            new DataTable("#Tabelkerjasama");
            new DataTable("#tabelmitra");
            new DataTable("#tabeljurusan");
            new DataTable("#tabelusermitra")

        </script>

        <script>
            // JavaScript untuk toggle sidebar
            const sidebar = document.getElementById('sidebar');
            const mainContent = document.getElementById('mainContent');
            const sidebarToggle = document.getElementById('sidebarToggle');

            sidebarToggle.addEventListener('click', () => {
                sidebar.classList.toggle('show');
                mainContent.classList.toggle('shifted');
                $(document).ready(function () {
                    $('#myTable').DataTable();
                })
            });
        </script>





</body>

</html>