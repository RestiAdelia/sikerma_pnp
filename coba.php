<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="">
    <style>
        * {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

body {
    font-family: Arial, sans-serif;
    display: flex;
}

.container {
    display: flex;
    width: 100%;
}

.sidebar {
    background-color: #F26419;
    color: white;
    width: 250px;
    padding: 20px;
    height: 100vh;
}

.sidebar h2 {
    margin-bottom: 20px;
}

.sidebar-menu {
    list-style: none;
}

.sidebar-menu li {
    margin: 10px 0;
}

.sidebar-menu li a {
    color: white;
    text-decoration: none;
    font-size: 18px;
}

.main-content {
    flex: 1;
    padding: 20px;
}

.navbar {
    display: flex;
    justify-content: space-between;
    align-items: center;
    background-color: #FF8C00;
    padding: 10px;
    color: white;
}

.navbar-left h3 {
    margin-left: 20px;
}

.navbar-search input {
    padding: 5px;
    width: 200px;
    margin-right: 10px;
}

.navbar-right span {
    margin-right: 20px;
}

.card-container {
    display: flex;
    gap: 20px;
    margin-bottom: 20px;
}

.card {
    background-color: #fff;
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    width: 30%;
    text-align: center;
}

.card h4 {
    margin-bottom: 10px;
}

.card p {
    font-size: 24px;
    margin-bottom: 20px;
}

.card button {
    background-color: #FF8C00;
    color: white;
    padding: 10px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
}

.grafik {
    display: flex;
    gap: 20px;
    margin-bottom: 20px;
}

.grafik div {
    width: 48%;
}

.daftar-mitra table {
    width: 100%;
    border-collapse: collapse;
}

.daftar-mitra table, th, td {
    border: 1px solid #ddd;
}

.daftar-mitra th, td {
    padding: 10px;
    text-align: left;
}

.daftar-mitra th {
    background-color: #F26419;
    color: white;
}

@media (max-width: 768px) {
    .card-container {
        flex-direction: column;
    }

    .grafik {
        flex-direction: column;
    }
}

    </style>
</head>
<body>
    <div class="container">
        <!-- Sidebar -->
        <aside class="sidebar">
            <div class="sidebar-header">
                <h2>Admin Dashboard</h2>
            </div>
            <ul class="sidebar-menu">
                <li><a href="#">Dashboard</a></li>
                <li><a href="#">Grade</a></li>
                <li><a href="#">Input Kerjasama</a></li>
                <li><a href="#">Grafik</a></li>
                <li><a href="#">Daftar Kerjasama</a></li>
            </ul>
        </aside>

        <!-- Main Content -->
        <main class="main-content">
            <!-- Navbar -->
            <nav class="navbar">
                <div class="navbar-left">
                    <h3>Dashboard</h3>
                </div>
                <div class="navbar-search">
                    <input type="text" placeholder="search...">
                    <button>search</button>
                </div>
                <div class="navbar-right">
                    <span>Username</span>
                </div>
            </nav>

            <!-- Content Area -->
            <section class="dashboard-content">
                <div class="card-container">
                    <div class="card blue">
                        <h4>Jumlah Kerjasama</h4>
                        <p>1,234</p>
                        <button>Details</button>
                    </div>
                    <div class="card green">
                        <h4>Jumlah MoU</h4>
                        <p>12,987</p>
                        <button>Details</button>
                    </div>
                    <div class="card yellow">
                        <h4>Jumlah MoA</h4>
                        <p>567</p>
                        <button>Details</button>
                    </div>
                </div>

                <!-- Grafik -->
                <div class="grafik">
                    <div class="line-chart">
                        <h4>Grafik Data (Line)</h4>
                        <!-- Add chart here -->
                    </div>
                    <div class="bar-chart">
                        <h4>Grafik Data (Bar)</h4>
                        <!-- Add chart here -->
                    </div>
                </div>

                <!-- Daftar Mitra -->
                <div class="daftar-mitra">
                    <h4>Daftar Mitra Kerjasama</h4>
                    <table>
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Mitra</th>
                                <th>Email Mitra</th>
                                <th>MoU / MoA</th>
                                <th>Jenis Kerjasama</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>1</td>
                                <td>John Doe</td>
                                <td>john@example.com</td>
                                <td>MoU</td>
                                <td>Kerjasama 1</td>
                            </tr>
                            <tr>
                                <td>2</td>
                                <td>Jane Doe</td>
                                <td>jane@example.com</td>
                                <td>MoA</td>
                                <td>Kerjasama 2</td>
                            </tr>
                            <tr>
                                <td>3</td>
                                <td>Sam Smith</td>
                                <td>sam@example.com</td>
                                <td>MoU</td>
                                <td>Kerjasama 3</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </section>
        </main>
    </div>

    <script src="script.js"></script>
</body>
</html>
