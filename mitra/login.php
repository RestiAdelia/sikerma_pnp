<?php session_start();
include 'koneksi.php'; // Pastikan koneksi sudah terhubung dengan benar

// Cek apakah form login sudah disubmit
if (isset($_POST['submit'])) {
    $username = mysqli_real_escape_string($koneksi, $_POST['username']);
    $password = $_POST['password'];

    // Query untuk mengecek apakah username ada di database user
    $sqlUser = "SELECT password, level FROM user WHERE username = ?";
    $stmtUser = mysqli_prepare($koneksi, $sqlUser);
    
    if ($stmtUser) {
        mysqli_stmt_bind_param($stmtUser, "s", $username);
        mysqli_stmt_execute($stmtUser);
        $resultUser = mysqli_stmt_get_result($stmtUser);
    
        if ($resultUser && mysqli_num_rows($resultUser) > 0) {
            $user = mysqli_fetch_assoc($resultUser);
            $hashed_password = $user['password'];
            $level = $user['level'];
    
            if (password_verify($password, $hashed_password)) {
                // Menyimpan session untuk login
                $_SESSION['login'] = true;
                $_SESSION['username'] = $username;
                $_SESSION['level'] = $level;
    
                if ($level == 'Staf') {
                    header("Location: navbar.php?p=dashboard");
                    exit;
                } elseif ($level == 'Jurusan') {
                    header("Location: jurusan.php");
                    exit;
                } elseif ($level == 'Mitra') {
                    header("Location: navbarMitra.php");
                    exit;
                } else {
                    echo "Akses tidak dikenali.";
                }
            } else {
                echo "Password yang Anda masukkan salah!";
            }
        } else {
            // Jika tidak ditemukan di user, cek di tabel jurusan
            $sqlJurusan = "SELECT username FROM jurusan WHERE username = ?";
            $stmtJurusan = mysqli_prepare($koneksi, $sqlJurusan);
            
            if ($stmtJurusan) {
                mysqli_stmt_bind_param($stmtJurusan, "s", $username);
                mysqli_stmt_execute($stmtJurusan);
                $resultJurusan = mysqli_stmt_get_result($stmtJurusan);
    
                if ($resultJurusan && mysqli_num_rows($resultJurusan) > 0) {
                    // Jika ditemukan di tabel jurusan, lanjutkan login
                    $_SESSION['login'] = true;
                    $_SESSION['username'] = $username;
                    $_SESSION['level'] = 'Jurusan';
                    header("Location: jurusan.php");
                    exit;
                } else {
                    echo "Username tidak ditemukan di database!";
                }
            } else {
                echo "Terjadi kesalahan saat memproses data!";
            }
        }
        mysqli_stmt_close($stmtUser);
    } else {
        echo "Terjadi kesalahan saat memproses data!";
    }
}
?>


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <style>
        /* Gradient background */
        body {
            background: linear-gradient(to bottom, #ff914d, #ffe6cc);
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .container {
            background-color: #fff5f0;
            border-radius: 10px;
            padding: 30px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            max-width: 400px;
            text-align: center;
        }

        .container h4 {
            font-weight: bold;
            margin-bottom: 20px;
        }

        .form-control {
            margin-bottom: 15px;
            border-radius: 8px;
        }

        .btn {
            background-color: #0056ff;
            color: white;
            border: none;
            border-radius: 8px;
            padding: 10px 20px;
            cursor: pointer;
        }

        .btn:hover {
            background-color: #003ebf;
        }

        .checkbox {
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 20px;
        }

        .checkbox input {
            margin-right: 10px;
        }

        .text-light {
            font-size: 0.9em;
        }
    </style>
</head>

<body>
    <div class="container">
        <img src="Logo_pnp.png" alt="Logo" width="80" style="margin-bottom: 20px;">
        <h4>Login</h4>
        <form action="login.php" method="POST">
            <input type="text" class="form-control" id="username" name="username" placeholder="Enter your username"
                required>
            <input type="password" class="form-control" id="password" name="password" placeholder="Enter your password"
                required>
            <div class="checkbox">
                <input type="checkbox" id="terms" required>
                <label for="terms">I agree to the <a href="#" class="text-primary">Terms & Conditions</a></label>
            </div>
            <button type="submit" name="submit" class="btn btn-block">Login</button>
        </form>
        <p class="mt-3">Don't have an account? <a href="registrasi.php" class="text-primary">Create an account</a></p>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Fungsi toggle untuk password
        document.querySelectorAll('.toggle-password').forEach(item => {
            item.addEventListener('click', function () {
                const input = this.previousElementSibling;
                if (input.type === 'password') {
                    input.type = 'text';
                    this.classList.remove('fa-eye');
                    this.classList.add('fa-eye-slash');
                } else {
                    input.type = 'password';
                    this.classList.remove('fa-eye-slash');
                    this.classList.add('fa-eye');
                }
            });
        });

    </script>
</body>

</html>