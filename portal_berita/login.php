
<?php
session_start();
include 'config.php';

if (isset($_SESSION['login'])) {
    header("Location: index.php");
    exit;
}

$error = "";

if (isset($_POST['login'])) {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = $_POST['password'];

    $query = mysqli_query($conn, "SELECT * FROM users WHERE username='$username'");
    if (mysqli_num_rows($query) === 1) {
        $user = mysqli_fetch_assoc($query);
        if (password_verify($password, $user['password'])) {
            $_SESSION['login'] = true;
            $_SESSION['user']  = $user;
            header("Location: index.php");
            exit;
        }
    }
    $error = "Username atau Password salah!";
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login | Portal Berita Mini</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        body {
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            background: radial-gradient(circle at top left, #1d4ed8, #020617);
            font-family: 'Segoe UI', sans-serif;
            padding: 20px;
        }

        .login-wrapper {
            width: 100%;
            max-width: 420px;
        }

        .back-btn {
            display: flex;
            align-items: center;
            gap: 8px;
            background: rgba(255,255,255,0.9);
            border-radius: 14px;
            padding: 10px 16px;
            margin-bottom: 15px;
            text-decoration: none;
            color: #000;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .back-btn:hover {
            transform: translateY(-2px);
            background: #fff;
        }

        .login-card {
            border-radius: 18px;
            animation: fadeUp 0.6s ease;
        }

        @keyframes fadeUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</head>

<body>

<div class="login-wrapper">

    <!-- Tombol Kembali -->
    <a href="index.php" class="back-btn shadow-sm">
        <i class="bi bi-arrow-left"></i>
        <span>Kembali ke Beranda</span>
    </a>

    <!-- CARD LOGIN -->
    <div class="card login-card shadow-lg">
        <div class="card-body p-4">

            <h4 class="text-center mb-4 fw-bold">
                🔐 Login
            </h4>

            <?php if ($error): ?>
                <div class="alert alert-danger"><?= $error; ?></div>
            <?php endif; ?>

            <form method="POST">
                <div class="mb-3">
                    <label class="form-label fw-semibold">Username</label>
                    <input type="text" name="username" class="form-control form-control-lg" required>
                </div>

                <div class="mb-4">
                    <label class="form-label fw-semibold">Password</label>
                    <input type="password" name="password" class="form-control form-control-lg" required>
                </div>

                <button name="login" class="btn btn-primary w-100 py-2">
                    Login
                </button>

                <div class="text-center mt-3">
                    Belum punya akun? <a href="register.php">Register</a>
                </div>
            </form>

        </div>
    </div>

</div>

</body>
</html> 

