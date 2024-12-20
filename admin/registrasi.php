<?php
include 'koneksi.php'; // Pastikan koneksi sudah benar
if (isset($_POST['submit'])) {
    $username = mysqli_real_escape_string($koneksi, $_POST['username']);
    $email = isset($_POST['email']) ? mysqli_real_escape_string($koneksi, $_POST['email']) : null;
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT); // Hash password
    $level = isset($_POST['level']) ? $_POST['level'] : ''; // Level dari form
    $kode_jurusan = ($level == 'Jurusan') ? mysqli_real_escape_string($koneksi, $_POST['kode_jurusan']) : null;


    // Proses untuk Mitra
    // Proses untuk Mitra
    if ($level == 'Mitra') {
        // Query untuk memastikan email ada di tabel `data` dan belum ada di tabel `user`
        $checkEmail = "SELECT 1 FROM data  WHERE email = ? AND NOT EXISTS (SELECT 1 FROM user WHERE email = ?)
    ";
        $stmtCheckEmail = mysqli_prepare($koneksi, $checkEmail);
        mysqli_stmt_bind_param($stmtCheckEmail, "ss", $email, $email);
        mysqli_stmt_execute($stmtCheckEmail);
        mysqli_stmt_store_result($stmtCheckEmail);

        // Jika email tidak ditemukan atau sudah terdaftar, tampilkan pesan error
        if (mysqli_stmt_num_rows($stmtCheckEmail) == 0) {
            echo "<div class='alert alert-danger'>Email anda Belum terdaftar di Mitra!</div>";
            mysqli_stmt_close($stmtCheckEmail);
            exit;
        }
        mysqli_stmt_close($stmtCheckEmail);

        // Jika email valid, masukkan data ke tabel `user`
        $sql = "INSERT INTO user (username, email, password, level) VALUES (?, ?, ?, ?)";
        $stmt = mysqli_prepare($koneksi, $sql);
        mysqli_stmt_bind_param($stmt, "ssss", $username, $email, $password, $level);
        if (mysqli_stmt_execute($stmt)) {
            echo "<div class='alert alert-success'>Registrasi Mitra berhasil!</div>";
        } else {
            echo "<div class='alert alert-danger'>Terjadi kesalahan saat registrasi!</div>";
        }
        mysqli_stmt_close($stmt);
    }

    // Proses untuk Jurusan
    elseif ($level == 'Jurusan') {

        // Cek kode jurusan
        $checkJurusan = "SELECT * FROM jurusan WHERE kode_jurusan = ?";
        $stmtCheck = mysqli_prepare($koneksi, $checkJurusan);
        mysqli_stmt_bind_param($stmtCheck, "s", $kode_jurusan);
        mysqli_stmt_execute($stmtCheck);
        $resultCheck = mysqli_stmt_get_result($stmtCheck);

        if (mysqli_num_rows($resultCheck) > 0) {
            echo "<div class='alert alert-danger'>Kode Jurusan sudah terdaftar untuk akun lain!</div>";
            exit;
        }

        $sql = "INSERT INTO jurusan (username, password, level) VALUES (?, ?, ?)";

        $stmt = mysqli_prepare($koneksi, $sql);
        mysqli_stmt_bind_param($stmt, "ssss", $username, $password, $level, $kode_jurusan);

        if (mysqli_stmt_execute($stmt)) {
            echo "<div class='alert alert-success'>Registrasi Jurusan berhasil!</div>";
        } else {
            echo "<div class='alert alert-danger'>Terjadi kesalahan saat registrasi!</div>";
        }
    }
    // Proses untuk Staf
    elseif ($level == 'Staf') {
        $sql = "INSERT INTO user (username, email, password, level) VALUES (?, ?, ?, ?)";
        $stmt = mysqli_prepare($koneksi, $sql);
        mysqli_stmt_bind_param($stmt, "ssss", $username, $email, $password, $level);
        if (mysqli_stmt_execute($stmt)) {
            echo "<div class='alert alert-success'>Registrasi Staf berhasil!</div>";
        } else {
            echo "<div class='alert alert-danger'>Terjadi kesalahan saat registrasi!</div>";
        }
    }
}

?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrasi</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        body {
            background: linear-gradient(to bottom, #4facfe, #00f2fe);
            font-family: Arial, sans-serif;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .container {
            background-color: white;
            border-radius: 10px;
            padding: 30px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            max-width: 400px;
        }
    </style>
</head>

<body>
    <div class="container">
        <h4 class="text-center">Registrasi</h4>
        <form action="" method="POST">
            <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input type="text" class="form-control" id="username" name="username" required>
            </div>
            <div class="mb-3" id="emailContainer" style="display: none;">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email">
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <div class="mb-3">
                <label for="confirm_password" class="form-label">Konfirmasi Password</label>
                <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
            </div>
            <div class="mb-3">
                <label for="level" class="form-label">Level</label>
                <select class="form-select" id="level" name="level" required onchange="toggleFields(this.value)">
                    <option value="">Pilih Level</option>
                    <option value="Staf">Staf</option>
                    <option value="Jurusan">Jurusan</option>
                    <option value="Mitra">Mitra</option>
                </select>
            </div>
            <div class="mb-3" id="kodeJurusanContainer" style="display: none;">
                <label for="kode_jurusan" class="form-label">Kode Jurusan</label>
                <input type="text" class="form-control" id="kode_jurusan" name="kode_jurusan">
            </div>
            <button type="submit" name="submit" class="btn btn-primary w-100">Register</button>
            <!-- Tombol Back -->
            <a href="login.php" class="btn btn-secondary w-100">
                <i class="bi bi-arrow-bar-left"></i> Kembali
            </a>

        </form>
    </div>

    <script>
        function toggleFields(level) {
            const emailContainer = document.getElementById('emailContainer');
            const kodeJurusanContainer = document.getElementById('kodeJurusanContainer');

            if (level === 'Mitra') {
                emailContainer.style.display = 'block';
                kodeJurusanContainer.style.display = 'none';
            } else if (level === 'Jurusan') {
                emailContainer.style.display = 'none';
                kodeJurusanContainer.style.display = 'block';
            } else {
                emailContainer.style.display = 'none';
                kodeJurusanContainer.style.display = 'none';
            }
        }
    </script>
</body>

</html>