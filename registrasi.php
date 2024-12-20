<?php
include 'koneksi.php'; // Pastikan koneksi sudah benar

if (isset($_POST['submit'])) {

    // Mengambil data dari form
    $username = mysqli_real_escape_string($koneksi, $_POST['username']);
    $nama = isset($_POST['nama']) ? mysqli_real_escape_string($koneksi, $_POST['nama']) : '';
    $email = isset($_POST['email']) ? mysqli_real_escape_string($koneksi, $_POST['email']) : null;
    $password = $_POST['password'];
    $konfir_password = $_POST['konfir_password'];
    $alamat = isset($_POST['alamat']) ? mysqli_real_escape_string($koneksi, $_POST['alamat']) : null;
    $level = isset($_POST['level']) ? $_POST['level'] : '';
    $kode_jurusan = ($level == 'Jurusan') ? mysqli_real_escape_string($koneksi, $_POST['kode_jurusan']) : null;

    // Validasi password dan konfirmasi password
    if ($password !== $konfir_password) {
        echo "<div class='alert alert-danger'>Password dan konfirmasi password tidak cocok!</div>";
        exit;
    }

    // Hash password untuk keamanan
    $password = password_hash($password, PASSWORD_BCRYPT);

    // Registrasi Mitra
    if ($level == 'Mitra') {
        $checkEmail = "SELECT 1 FROM data WHERE email = ? AND NOT EXISTS (SELECT 1 FROM user WHERE email = ?)";
        $stmtCheckEmail = mysqli_prepare($koneksi, $checkEmail);
        mysqli_stmt_bind_param($stmtCheckEmail, "ss", $email, $email);
        mysqli_stmt_execute($stmtCheckEmail);
        mysqli_stmt_store_result($stmtCheckEmail);

        if (mysqli_stmt_num_rows($stmtCheckEmail) == 0) {
            echo "<div class='alert alert-danger'>Email anda Belum terdaftar di Mitra!</div>";
            mysqli_stmt_close($stmtCheckEmail);
            exit;
        }
        mysqli_stmt_close($stmtCheckEmail);

        // Insert user untuk Mitra
        $sql = "INSERT INTO user (username, nama, email, alamat, password, level) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = mysqli_prepare($koneksi, $sql);
        mysqli_stmt_bind_param($stmt, "ssssss", $username, $nama, $email, $alamat, $password, $level);

        if (mysqli_stmt_execute($stmt)) {
            echo "<div class='alert alert-success'>Registrasi Mitra berhasil!</div>";
            header("Location: login.php"); // Menggunakan Location: untuk pengalihan
            exit;
        } else {
            echo "<div class='alert alert-danger'>Terjadi kesalahan saat registrasi!</div>";
        }
        mysqli_stmt_close($stmt);

        // Registrasi Jurusan
    } elseif ($level == 'Jurusan') {
        // Cek apakah kode jurusan sudah ada
        $checkJurusan = "SELECT * FROM jurusan WHERE kode_jurusan = ?";
        $stmtCheck = mysqli_prepare($koneksi, $checkJurusan);
        mysqli_stmt_bind_param($stmtCheck, "s", $kode_jurusan);
        mysqli_stmt_execute($stmtCheck);
        $resultCheck = mysqli_stmt_get_result($stmtCheck);

        if (mysqli_num_rows($resultCheck) > 0) {
            // Jika kode jurusan ditemukan, lakukan update
            $sql = "UPDATE jurusan SET username = ?, nama_jurusan = ?, password = ?, level = ?, status = 'Pending' WHERE kode_jurusan = ?";

            // Persiapkan dan bind parameter
            $stmt = mysqli_prepare($koneksi, $sql);
            mysqli_stmt_bind_param($stmt, "sssss", $username, $nama, $password, $level, $kode_jurusan);

            // Eksekusi statement
            if (mysqli_stmt_execute($stmt)) {
                echo "<div class='alert alert-success'>Berhasil Registrasi sebagai admin Jurusan!</div>";
                header("Location: index.php");
                exit;
            } else {
                echo "<div class='alert alert-danger'>Terjadi kesalahan saat update data!</div>";
            }

            // Tutup statement
            mysqli_stmt_close($stmt);
        } else {
            echo "<div class='alert alert-danger'>Kode jurusan tidak ditemukan!</div>";


            // Tutup statement pengecekan
            mysqli_stmt_close($stmtCheck);
        }

        // Registrasi Staf
    } elseif ($level == 'Staf') {
        $sql = "INSERT INTO user (username, nama, email, alamat, password, level) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = mysqli_prepare($koneksi, $sql);
        mysqli_stmt_bind_param($stmt, "ssssss", $username, $nama, $email, $alamat, $password, $level);

        if (mysqli_stmt_execute($stmt)) {
            echo "<div class='alert alert-success'>Registrasi Staf berhasil!</div>";
            header("Location: login.php"); // Menggunakan Location: untuk pengalihan
            exit;
        } else {
            echo "<div class='alert alert-danger'>Terjadi kesalahan saat registrasi!</div>";
        }
        mysqli_stmt_close($stmt);
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register Page</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(to bottom,#ff914d, #ffe6cc);
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .register-container {
            background-color: #fff5f0;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            max-width: 400px;
            width: 95%;
        }

        .register-container img {
            display: block;
            margin: 0 auto 20px;
            width: 80px;
        }

        .register-container h4 {
            text-align: center;
            margin-bottom: 20px;
            font-weight: bold;
        }

        .form-control {
            border-radius: 8px;
            margin-bottom: 15px;
        }

        .btn {
            background-color:rgb(233, 113, 34);
            color: white;
            border: none;
            border-radius: 8px;
            padding: 10px;
            width: 100%;
        }

        .btn:hover {
            background-color:rgb(192, 96, 22);
        }

        .toggle-password {
            position: absolute;
            right: 10px;
            top: 12px;
            cursor: pointer;
            color: #aaa;
        }

        .form-group {
            position: relative;
        }

        .checkbox {
            margin: 10px 0;
        }

        .text-link {
            color: #0056ff;
        }

        .text-link:hover {
            text-decoration: underline;
        }
    </style>
</head>

<body>
    <div class="register-container">
        <img src="logo_pnp.png" alt="Logo">
        <h4>Create an Account</h4>

        <?php if (isset($err) && $err) { ?>
            <div class="alert alert-danger">
                <ul><?php echo $err; ?></ul>
            </div>
        <?php } ?>
        <?php if (isset($sukses) && $sukses) { ?>
            <div class="alert alert-success">
                <ul><?php echo $sukses; ?></ul>
            </div>
        <?php } ?>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
            <div class="form-group">
                <input type="text" class="form-control" id="username" name="username" placeholder="Enter your username"
                    required>
            </div>
            <div class="form-group">
                <input type="text" class="form-control" id="nama" name="nama" placeholder="Enter your name" required>
            </div>

            <div class="form-group" id="email_group">
                <input type="email" class="form-control" id="email" name="email" placeholder="Enter your email">
            </div>

            <div class="form-group" id="alamat_group">
                <input type="text" class="form-control" id="alamat" name="alamat" placeholder="Enter your address">
            </div>

            <div class="form-group">
                <input type="password" class="form-control" id="password" name="password"
                    placeholder="Enter your password" required>
                <i class="toggle-password fas fa-eye"></i>
            </div>

            <div class="form-group">
                <input type="password" class="form-control" id="konfir_password" name="konfir_password"
                    placeholder="Confirm your password" required>
            </div>

            <div class="form-group">
                <label for="level" class="form-label">Level</label>
                <select class="form-select" id="level" name="level" required onchange="toggleFields(this.value)">
                    <option value="">Pilih Level</option>
                    <option value="Staf">Staf</option>
                    <option value="Jurusan">Jurusan</option>
                    <option value="Mitra">Mitra</option>
                </select>
            </div><br>

            <div class="form-group" id="kode_jurusan_group" style="display: none;">
                <input type="text" class="form-control" id="kode_jurusan" name="kode_jurusan"
                    placeholder="Enter Kode Jurusan">
            </div>

            <div class="checkbox">
                <input type="checkbox" id="terms" required>
                <label for="terms">I agree to the <a href="#" class="text-link">Terms & Conditions</a></label>
            </div>

            <div class="form-group text-center">
                <button type="submit" name="submit" class="btn">Register</button>
            </div>

            <div class="form-group text-center">
                <p>Already have an account? <a href="login.php" class="text-link">Login here</a></p>
            </div>
        </form>

    </div>

    <script>
        function toggleFields(level) {
            const emailGroup = document.getElementById('email_group');
            const alamatGroup = document.getElementById('alamat_group');
            const kodeJurusanGroup = document.getElementById('kode_jurusan_group');

            // Pastikan elemen tidak disembunyikan secara tidak sengaja
            if (level === 'Mitra') {
                emailGroup.style.display = 'block';
                alamatGroup.style.display = 'block';
                kodeJurusanGroup.style.display = 'none';
            } else if (level === 'Jurusan') {
                emailGroup.style.display = 'none';
                alamatGroup.style.display = 'none';
                kodeJurusanGroup.style.display = 'block';
            } else {
                emailGroup.style.display = 'block';
                alamatGroup.style.display = 'block';
                kodeJurusanGroup.style.display = 'none';
            }
        }



        document.querySelector('.toggle-password').addEventListener('click', function (e) {
            var passwordField = document.getElementById('password');
            var konfirPasswordField = document.getElementById('konfir_password');
            var type = passwordField.type === 'password' ? 'text' : 'password';
            passwordField.type = type;
            konfirPasswordField.type = type;
            this.classList.toggle('fa-eye-slash');
        });
    </script>
</body>

</html>