<?php session_start();
include 'koneksi.php'; // Pastikan koneksi sudah terhubung dengan benar
$success_message = ""; // Variabel untuk pesan sukses
$error_message = ""; // Variabel untuk pesan error

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
                    $success_message = "Anda berhasil Login";
                    header("Location: navbar.php?p=dashboard");
                    exit;
                
                } elseif ($level == 'Mitra') {
                    $success_message = "Anda berhasil Login";
                    header("Location: navbarMitra.php");
                    exit;
                } else {  
                    $error_message = "Username tidak ditemukan!";

                    // echo "Akses tidak dikenali.";
                }
            } else {
                $error_message = "Password yang Anda masukkan salah!";

            }
        } else {
            // Jika tidak ditemukan di user, cek di tabel jurusan
            $sqlJurusan = "SELECT username,status FROM jurusan WHERE username = ?";
            $stmtJurusan = mysqli_prepare($koneksi, $sqlJurusan);
            
            if ($stmtJurusan) {
                mysqli_stmt_bind_param($stmtJurusan, "s", $username);
                mysqli_stmt_execute($stmtJurusan);
                $resultJurusan = mysqli_stmt_get_result($stmtJurusan);
    
                if ($resultJurusan && mysqli_num_rows($resultJurusan) > 0) {
                    // Jika ditemukan di tabel jurusan, lanjutkan login
                    $jurusan = mysqli_fetch_assoc($resultJurusan);
                    $status = $jurusan['status'];
                  
                    if ($status == 'Approved') {
                        // Jika status aktif, lanjutkan login
                        $_SESSION['login'] = true;
                        $_SESSION['username'] = $username;
                        $_SESSION['level'] = 'Jurusan';
                        $success_message = "Anda berhasil Login";
                        header("Location: navbarJurusan.php");
                        exit;
                    } else {
                        // Jika status tidak aktif
                        $error_message = "Akun jurusan Anda belum aktif. Silakan hubungi admin.";
                    }
                  
                } else {
                    echo "Username tidak ditemukan di database!";
                    $error_message = "Username tidak ditemukan!";
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


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
            height: 500px;
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
            background-color: #e07845;
            color: white;
            border: none;
            padding: 9px 20px;
            width: 250px;
            cursor: pointer;
            box-shadow: 0px 3px 10px rgba(0, 0, 0, 0.3);
            border-radius: 10px;
            align-self: center;
            margin-top: auto;


        }

        .btn:hover {
            background-color: #f87707;
        }

        .checkbox {
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 10px; /*jarak tulisan dengan buttom login*/
            margin-top: 50px;
        }

        .checkbox input {
            margin-right: 10px;
        }

        .text-light {
            font-size: 0.9em;
        }

        .back-icon {
            display:
                <?= !empty($success_message) ? 'none' : 'block' ?>
            ;
        }

        .text {
            display: flex;
            justify-content: space-between;
            font-size: 12px;
            text-align: left;


        }

        .text-primary {
            font-size: 13px;
        }
    </style>
</head>

<body>
    <div class="container position-relative">
        <!-- icon back -->
        <a href="index.php" class="back-icon"
            style="position:absolute; bottom: 20px; right: 30px; text-decoration: none; color: #f87707;">
            <svg xmlns="http://www.w3.org/2000/svg" width="40" height="28" fill="currentColor" class="bi bi-arrow-left"
                viewBox="0 0 16 16">
                <path fill-rule="evenodd"
                    d="M15 8a.5.5 0 0 1-.5.5H3.707l4.147 4.146a.5.5 0 0 1-.708.708l-5-5a.5.5 0 0 1 0-.708l5-5a.5.5 0 1 1 .708.708L3.707 7.5H14.5A.5.5 0 0 1 15 8z" />
            </svg>

        </a>
        <img src="img/logo_pnp.png" alt="Logo" width="80" style="margin-bottom: 20px;">
        <h4>Login</h4>
        <?php if (!empty($success_message)) { ?>
            <div class="alert alert-success" role="alert">
                <h2 style="font-size: 2rem; font-weight: bold;">
                    <?php echo $success_message; ?>
            </div>
            <script>
                // Tunggu 3 detik, lalu alihkan ke halaman dashboard admin
                setTimeout(() => {
                    window.location.href = 'navbar.php?p=dashboard';
                }, 2000);
            </script>
        <?php } else { ?>
            <form action="login.php" method="POST">
                <input type="text" class="form-control" id="username" name="username" placeholder="Enter your username"
                    required>
                <input type="password" class="form-control" id="password" name="password" placeholder="Enter your password"
                    required>
                <p class="text text-center mt-3">You don't have an account? <a href="registrasi.php" class="text ">Create an
                        Account</a></p>


                <div class="checkbox">
                    <input type="checkbox" id="terms" required>
                    <label for="terms">I agree to the <a href="#" class="text-primary">Terms & Conditions</a></label>
                </div>
                <button type="submit" name="submit" class="btn btn-block">Login</button>

            </form>
        <?php } ?>
        <?php if (!empty($error_message)) { ?>
            <script>
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: '<?php echo $error_message; ?>'
                });
            </script>
        <?php } ?>
    </div>



    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Tampilkan notifikasi login sukses jika parameter login=success ada di URL
        const urlParams = new URLSearchParams(window.location.search);
        if (urlParams.get('login') === 'success') {
            Swal.fire({
                icon: 'success',
                title: 'Login Sukses',
                text: 'Selamat datang! Anda berhasil login.'
            });
        }
    </script>
</body>

</html>