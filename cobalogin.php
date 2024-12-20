<?php
session_start();
require_once 'koneksi.php'; // Pastikan file koneksi sudah dibuat dan terhubung dengan benar

// Cek apakah form login sudah disubmit
if (isset($_POST['submit'])) {
    $username = mysqli_real_escape_string($koneksi, $_POST['username']);
    $password = $_POST['password'];

    // Query untuk mengambil hash password dan level dari database berdasarkan username
    $sql = "SELECT password, level FROM user WHERE username = ?";
    $stmt = mysqli_prepare($koneksi, $sql);
    
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "s", $username);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if ($result && mysqli_num_rows($result) > 0) {
            $user = mysqli_fetch_assoc($result);
            $hashed_password = $user['password'];
            $level = $user['level'];

            // Verifikasi password yang dimasukkan dengan hash password yang disimpan
            if (password_verify($password, $hashed_password)) {
                // Login sukses
                $_SESSION['login'] = true;
                $_SESSION['username'] = $username;
                $_SESSION['level'] = $level;

                // Tentukan akses berdasarkan level
                $page = isset($_GET['page']) ? $_GET['page'] : 'home';

                if ($level == 'Admin') {
                    header("Location: navbar.php?p=dashboard");
                } elseif ($level == 'jurusan') {
                   
                } elseif ($level == 'mitra') {
                    header("Location: dashboard_mitra.php");
                } else {
                    echo "Akses tidak dikenali.";
                }

                // Redirect ke halaman dashboard
                header("Location: navbar.php?p=dashboard");
                exit;
            } else {
                // Password salah
                echo "Password yang Anda masukkan salah!";
            }
        } else {
            // Username tidak ditemukan
            echo "Username tidak ditemukan!";
        }

        mysqli_stmt_close($stmt);
    } else {
        // Query gagal
        echo "Terjadi kesalahan saat memproses data!";
    }
}

?>
