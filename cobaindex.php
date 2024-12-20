<!-- <?php
session_start();
if (!isset($_SESSION['login'])) {
    header("Location: login.php");
    exit;
}

include 'koneksi.php'; // Pastikan file koneksi.php sudah di-include
?> -->
<!DOCTYPE html>
<html lang="en">

<head>

    <style>
        .content {
            margin-left: 250px;
            padding: 20px;
            background-color: #f8f9fa;
        }

        /* Navbar styling */
        .navbar-custom {
            background-color: #ff6600;
            box-shadow: 0px 3px 10px rgba(0, 0, 0, 0.1);
        }

        .navbar-custom .navbar-nav .nav-item {
            color: white;
        }


        /* Styling for the content section */
        .card-stats {
            display: flex;
            justify-content: space-between;
            gap: 20px;
            margin-bottom: 30px;
        }

        .card-stats .card {
            flex: 1;
            background-color: #ffcc99;
            color: #fff;
            border: none;
            box-shadow: 0px 3px 10px rgba(0, 0, 0, 0.1);
        }

        .card-stats .card-header {
            background-color: #ff6600;
        }

        .card-stats .card-body {
            background-color: #ff9933;
        }
    </style>
</head>

<body>
    <div id="content">
        <!-- Default content on page load -->
        <h5 class="mb-4">Welcome to the Dashboard</h5>
        <div class="row mb-4">
            <div class="col-md-4">
                <div class="card bg-primary text-white shadow">
                    <div class="card-body">
                        <h5 class="card-title">Jumlah Kerjasama</h5>
                        <p class="card-text fs-3">1,234</p>
                    </div>
                    <div class="card-footer d-flex justify-content-between align-items-center">
                        <a href="jumlah_kerjasama.php" class="text-white text-decoration-none">
                            <span>Details</span>
                        </a>
                        <i class="fas fa-users"></i>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card bg-success text-white shadow">
                    <div class="card-body">
                        <h5 class="card-title">Jumlah MoU</h5>
                        <p class="card-text fs-3">$12,345</p>
                    </div>
                    <div class="card-footer d-flex justify-content-between align-items-center">
                        <a href="jumlah_mou.php" class="text-white">
                            <span>Details</span>
                        </a>
                        <i class="fas fa-dollar-sign"></i>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card bg-warning text-white shadow">
                    <div class="card-body">
                        <h5 class="card-title">Jumlah MoA</h5>
                        <p class="card-text fs-3">567</p>
                    </div>
                    <div class="card-footer d-flex justify-content-between align-items-center">
                        <a href="jumlah_moa.php" class="text-white">
                            <span>Details</span>
                        </a>
                        <i class="fas fa-shopping-cart"></i>
                    </div>
                </div>
            </div>
        </div>

    </div>
    
    <?php
    include 'grafik.php';
    ?>

</body>

</html>