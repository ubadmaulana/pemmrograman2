<?php
session_start();
include 'config.php';

$error = "";
$success = "";

if (isset($_POST['register'])) {
    $nama     = mysqli_real_escape_string($conn, $_POST['nama']);
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = $_POST['password'];
    $confirm  = $_POST['confirm'];

    // Validasi
    if ($password !== $confirm) {
        $error = "Password dan Konfirmasi tidak sama!";
    } else {
        // Cek username
        $cek = mysqli_query($conn, "SELECT id FROM users WHERE username='$username'");
        if (mysqli_num_rows($cek) > 0) {
            $error = "Username sudah digunakan!";
        } else {
            $hash = password_hash($password, PASSWORD_DEFAULT);
            mysqli_query($conn, "INSERT INTO users (nama, username, password, role)
                                 VALUES ('$nama', '$username', '$hash', 'editor')");
            $success = "Registrasi berhasil! Silakan login.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Register Akun</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light d-flex justify-content-center align-items-center vh-100">

<div class="card shadow" style="width: 450px;">
    <div class="card-body">
        <h4 class="text-center mb-4">📝 Register Akun</h4>

        <?php if ($error): ?>
            <div class="alert alert-danger"><?= $error; ?></div>
        <?php endif; ?>

        <?php if ($success): ?>
            <div class="alert alert-success">
                <?= $success; ?> <a href="login.php">Login</a>
            </div>
        <?php endif; ?>

        <form method="POST">
            <div class="mb-3">
                <label>Nama Lengkap</label>
                <input type="text" name="nama" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>Username</label>
                <input type="text" name="username" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>Password</label>
                <input type="password" name="password" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>Konfirmasi Password</label>
                <input type="password" name="confirm" class="form-control" required>
            </div>

            <button name="register" class="btn btn-primary w-100">Register</button>
        </form>

        <div class="text-center mt-3">
            Sudah punya akun? <a href="login.php">Login</a>
        </div>
    </div>
</div>

</body>
</html>
