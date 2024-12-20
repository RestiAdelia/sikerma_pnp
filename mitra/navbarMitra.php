<?php
// Memastikan session hanya dimulai sekali
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/2.1.8/css/dataTables.bootstrap5.css">

    <style>
        body {
            font-family: 'Arial', sans-serif;
            padding-top: 60px;
        }

        .navbar {
            background: linear-gradient(to bottom, #ff6600, #ff9933);
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 1030;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .navbar .navbar-brand {
            color: white;
            font-weight: bold;
        }

        .sidebar {
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            width: 250px;
            background: linear-gradient(to bottom, #ff6600, #ff9933);
            color: white;
            padding-top: 20px;
            box-shadow: 2px 0px 5px rgba(0, 0, 0, 0.2);
            transform: translateX(0);
            transition: transform 0.3s ease;
            z-index: 1000;
        }

        .content {
            margin-left: 250px;
            padding: 20px;
        }

        .sidebar a {
            color: white;
            text-decoration: none;
            padding: 12px;
            display: block;
        }

        .sidebar a:hover {
            background-color: #ff4500;
            border-radius: 5px;
        }

        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-250px);
            }

            .content {
                margin-left: 0;
            }
        }

        #sidebarToggle {
            display: none;
        }

        @media (max-width: 768px) {
            #sidebarToggle {
                display: inline-block;
            }
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg">
        <div class="container-fluid">
            <button id="sidebarToggle" class="btn btn-light d-lg-none">☰</button>
            <a class="navbar-brand" href="#">Mitra Dashboard</a>

            <form class="d-flex ms-auto me-3" role="search" action="#" method="GET">
                <input class="form-control me-2" type="search" name="query" placeholder="Search" aria-label="Search">
                <button class="btn btn-light" type="submit">
                    <i class="bi bi-search"></i>
                </button>
            </form>

            <div>
                <a href="#" title="Profile">
                    <i class="bi bi-person-circle me-3 text-white" style="font-size: 1.5rem;"></i>
                </a>
                <a href="logout.php" title="Logout">
                    <i class="bi bi-box-arrow-right text-white" style="font-size: 1.5rem;"></i>
                </a>
            </div>
        </div>
    </nav>

    <div class="sidebar">
        <a href="?p=dashboard">Dashboard</a>
        <a href="?p=grafik">Grafik</a>
        <a href="?p=daftarmitra">Daftar Mitra</a>
        <a href="?p=usulan">Daftar Usulan</a>
    </div>

    <div class="content">
        <?php
        $allowed_pages = ['dashboard', 'grafik', 'daftarmitra', 'usulan'];
        $page = isset($_GET['p']) && in_array($_GET['p'], $allowed_pages) ? $_GET['p'] : 'dashboard';
        include "$page.php";
        ?>
    </div>

    <script>
        document.getElementById('sidebarToggle').addEventListener('click', function () {
            const sidebar = document.querySelector('.sidebar');
            if (sidebar.style.transform === 'translateX(0px)') {
                sidebar.style.transform = 'translateX(-250px)';
            } else {
                sidebar.style.transform = 'translateX(0px)';
            }
        });
    </script>
</body>

</html>
