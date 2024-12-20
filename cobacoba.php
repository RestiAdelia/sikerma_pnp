<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <style>
        body {
            background: linear-gradient(to bottom, #ffcc80, #ffa726);
            font-family: Arial, sans-serif;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .container {
            background-color: #fff;
            border-radius: 10px;
            padding: 30px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            max-width: 400px;
            text-align: center;
        }

        .container img {
            width: 100px;
            margin-bottom: 20px;
        }

        h4 {
            color: #333;
            font-weight: bold;
            margin-bottom: 20px;
        }

        .btn-primary {
            background-color: #1e88e5;
            border-color: #1e88e5;
            color: #fff;
            width: 100%;
            border-radius: 5px;
            padding: 10px;
        }

        .btn-primary:hover {
            background-color: #1565c0;
            border-color: #1565c0;
        }

        .register-link {
            margin-top: 10px;
            font-size: 14px;
            color: #333;
        }

        .register-link a {
            color: #1e88e5;
            text-decoration: none;
        }

        .register-link a:hover {
            text-decoration: underline;
        }
    </style>
</head>

<body>
    <div class="container">
        <img src="logo.png" alt="Logo"> <!-- Ganti dengan path logo -->
        <h4>Register</h4>
        <form id="registerForm" action="process_register.php" method="POST">
            <div class="mb-3">
                <input type="text" class="form-control" id="username" name="username" placeholder="Enter your username" required>
            </div>

            <div class="mb-3">
                <select class="form-select" id="level" name="level" onchange="toggleFields(this.value)" required>
                    <option value="">Select Level</option>
                    <option value="Staf">Staf</option>
                    <option value="Jurusan">Jurusan</option>
                    <option value="Mitra">Mitra</option>
                </select>
            </div>

            <div id="emailContainer" class="mb-3" style="display: none;">
                <input type="email" class="form-control" id="email" name="email" placeholder="Enter your email">
            </div>

            <div id="kodeJurusanContainer" class="mb-3" style="display: none;">
                <input type="text" class="form-control" id="kodeJurusan" name="kode_jurusan" placeholder="Enter Kode Jurusan">
            </div>

            <div class="mb-3">
                <input type="password" class="form-control" id="password" name="password" placeholder="Enter your password" required>
            </div>
            <div class="mb-3">
                <input type="password" class="form-control" id="confirm_password" name="confirm_password" placeholder="Confirm your password" required>
            </div>

            <button type="submit" class="btn btn-primary">Register</button>
            <div class="register-link">
                Already have an account? <a href="login.php">Login here</a>
            </div>
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

        // Validasi password dan confirm password
        const form = document.getElementById('registerForm');
        const password = document.getElementById('password');
        const confirmPassword = document.getElementById('confirm_password');

        form.addEventListener('submit', function (event) {
            if (password.value !== confirmPassword.value) {
                event.preventDefault();
                alert('Passwords do not match!');
            }
        });
    </script>
</body>

</html>
