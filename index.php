<?php 
session_start();
include 'config.php'; 
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Portal Berita Mini</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* ====== TEMA GLOBAL ====== */
        body {
            background: radial-gradient(circle at top left, #e0e9ff 0%, #c7d8f9 40%, #b1c4f7 70%, #a2baf5 100%);
            background-attachment: fixed;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: #222;
        }
        .navbar {
            background: linear-gradient(90deg, #003b8e, #0056d2);
        }
        .navbar-brand {
            font-weight: 700;
            font-size: 1.4rem;
            letter-spacing: 0.5px;
        }
        .btn-warning {
            background-color: #ffc107 !important;
            border: none;
        }

        /* ====== HERO ====== */
        .hero {
            background: linear-gradient(to right, rgba(0, 0, 0, 0.55), rgba(0, 0, 0, 0.55)),
                        url('https://source.unsplash.com/1600x500/?news,city,world,breaking') center/cover no-repeat;
            color: #fff;
            text-align: center;
            padding: 100px 20px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.3);
        }
        .hero h1 {
            font-size: 3rem;
            font-weight: 800;
            text-shadow: 2px 3px 6px rgba(0,0,0,0.5);
        }
        .hero p {
            font-size: 1.1rem;
            opacity: 0.9;
            margin-top: 10px;
        }

        /* ====== BAGIAN BERITA ====== */
        .section-title {
            background: #0056d2;
            color: white;
            padding: 12px 0;
            border-radius: 8px;
            font-weight: bold;
            margin-bottom: 30px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.15);
        }

        .card {
            border: none;
            border-radius: 15px;
            overflow: hidden;
            background-color: #ffffffd9;
            backdrop-filter: blur(5px);
            transition: all 0.3s ease;
        }
        .card:hover {
            transform: translateY(-8px);
            box-shadow: 0 10px 25px rgba(0,0,0,0.25);
        }
        .card img {
            height: 200px;
            object-fit: cover;
            transition: all 0.3s ease;
        }
        .card:hover img {
            transform: scale(1.05);
        }
        .card-title a {
            text-decoration: none;
            color: #003b8e;
            transition: color 0.2s ease;
        }
        .card-title a:hover {
            color: #d00000;
        }

        /* ====== FOOTER ====== */
        footer {
            background: #003b8e;
            color: white;
            padding: 20px 0;
            text-align: center;
            margin-top: 100px;
            box-shadow: 0 -2px 10px rgba(0,0,0,0.2);
        }
    </style>
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark sticky-top shadow-sm">
  <div class="container">
    <a class="navbar-brand" href="index.php">📰 Portal Berita Mini</a>
    <div class="d-flex">
        <?php if (isset($_SESSION['login'])): ?>
            <span class="text-white me-3">
                Halo, <strong><?= $_SESSION['user']['nama']; ?></strong>
            </span>
            <a href="logout.php" class="btn btn-danger">Logout</a>
            <a href="add.php" class="btn btn-warning text-dark fw-bold">+ Tambah Berita</a>
        <?php else: ?>
            <a href="login.php" class="btn btn-light fw-bold">Login</a>
        <?php endif; ?>
    </div>

  </div>
</nav>

<!-- Hero Section -->
<section class="hero">
    <div class="hero-content">
        <h1>Portal Berita Mini</h1>
        <p>Menyajikan informasi terkini, terpercaya, dan menarik setiap hari</p>
    </div>
</section>

<!-- Konten Berita -->
<div class="container mt-5">
    <div class="row mb-4">
        <div class="col text-center">
            <h2 class="section-title">🗞️ Berita Terkini & Trending</h2>
        </div>
    </div>

    <div class="row">
        <?php
        $where = "";
        if (isset($_GET['search'])) {
            $search = mysqli_real_escape_string($conn, $_GET['search']);
            $where = "WHERE judul LIKE '%$search%' OR isi LIKE '%$search%' OR kategori LIKE '%$search%'";
        }

        $result = mysqli_query($conn, "SELECT * FROM berita $where ORDER BY id DESC");

        if (mysqli_num_rows($result) == 0) {
            echo "<div class='text-center text-muted'>Tidak ada berita ditemukan.</div>";
        }

        while ($row = mysqli_fetch_assoc($result)) {
            if (!empty($row['gambar'])) {
                $gambar = "uploads/" . htmlspecialchars($row['gambar']);
            } else {
                $kategori_gambar = ['breaking', 'world', 'politics', 'technology', 'sports', 'culture', 'finance', 'travel'];
                $random_kategori = $kategori_gambar[array_rand($kategori_gambar)];
                $gambar = "https://source.unsplash.com/600x400/?" . $random_kategori . "," . rand(1,1000);
            }
        ?>
        <div class="col-md-4 mb-4">
            <div class="card h-100 shadow-sm">
                <a href="view.php?id=<?= $row['id']; ?>">
                    <img src="<?= $gambar; ?>" class="card-img-top" alt="Gambar Berita">
                </a>
                <div class="card-body">
                    <h5 class="card-title">
                        <a href="view.php?id=<?= $row['id']; ?>">
                            <?= htmlspecialchars($row['judul']); ?>
                        </a>
                    </h5>
                    <span class="badge bg-danger"><?= htmlspecialchars($row['Kategori']); ?></span>
                    <p class="text-muted small mt-2">
                        Oleh <strong><?= htmlspecialchars($row['penulis']); ?></strong> | <?= $row['tanggal']; ?>
                    </p>
                    <p class="card-text"><?= nl2br(substr($row['isi'], 0, 120)); ?>...</p>
                    <a href="view.php?id=<?= $row['id']; ?>" class="btn btn-sm btn-primary">Baca Selengkapnya</a>
                    <?php if (isset($_SESSION['login'])): ?>
                        <a href="edit.php?id=<?= $row['id']; ?>" class="btn btn-sm btn-warning">Edit</a>
                        <a href="delete.php?id=<?= $row['id']; ?>" class="btn btn-sm btn-danger"
                        onclick="return confirm('Yakin hapus berita ini?')">Hapus</a>
                    <?php endif; ?>

                </div>
            </div>
        </div>
        <?php } ?>
    </div>
</div>

<footer>
    <p>© <?= date('Y'); ?> Portal Berita Mini | Dibuat oleh <strong>Ubad Maulana Meihardi</strong></p>
</footer>

</body>
</html>
