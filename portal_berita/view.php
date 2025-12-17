<?php 
include 'config.php'; 

if (!isset($_GET['id'])) {
    header("Location: index.php");
    exit;
}

$id = intval($_GET['id']);
$result = mysqli_query($conn, "SELECT * FROM berita WHERE id = $id");
$berita = mysqli_fetch_assoc($result);

if (!$berita) {
    echo "<div class='text-center mt-5'>Berita tidak ditemukan. <a href='index.php'>Kembali</a></div>";
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($berita['judul']); ?> - Portal Berita Mini</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f7f9fc;
        }
        .navbar-brand {
            font-weight: 700;
        }
        .hero-img {
            max-height: 400px;
            width: 100%;
            object-fit: cover;
            border-radius: 15px;
        }
        .content {
            background: white;
            border-radius: 15px;
            padding: 30px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.05);
        }
        footer {
            background: #0d6efd;
            color: white;
            padding: 10px 0;
            text-align: center;
            margin-top: 50px;
        }
        .btn-back {
            margin-top: 20px;
        }
    </style>
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-primary sticky-top">
  <div class="container">
    <a class="navbar-brand" href="index.php">📰 Portal Berita Mini</a>
  </div>
</nav>

<!-- Konten -->
<div class="container mt-4 mb-5">
    <div class="content">
        <h2 class="fw-bold text-primary"><?= htmlspecialchars($berita['judul']); ?></h2>
        <p class="text-muted mb-2">
            Oleh <strong><?= htmlspecialchars($berita['penulis']); ?></strong> | <?= $berita['tanggal']; ?> 
            <?php if (!empty($berita['kategori'])): ?>
                <span class="badge bg-secondary ms-2"><?= htmlspecialchars($berita['Kategori']); ?></span>
            <?php endif; ?>
        </p>

        <?php if (!empty($berita['gambar'])): ?>
            <img src="uploads/<?= htmlspecialchars($berita['gambar']); ?>" class="hero-img mb-4" alt="Gambar Berita">
        <?php else: ?>
            <img src="https://source.unsplash.com/1000x400/?news" class="hero-img mb-4" alt="Default Gambar">
        <?php endif; ?>

        <p style="text-align: justify; font-size: 1.05rem; line-height: 1.8;">
            <?= nl2br(htmlspecialchars($berita['isi'])); ?>
        </p>

        <a href="index.php" class="btn btn-secondary btn-back">← Kembali ke Beranda</a>
        <a href="edit.php?id=<?= $berita['id']; ?>" class="btn btn-warning">Edit</a>
        <a href="delete.php?id=<?= $berita['id']; ?>" class="btn btn-danger" onclick="return confirm('Yakin hapus berita ini?')">Hapus</a>
    </div>
</div>

<footer>
    <p>© <?= date('Y'); ?> Portal Berita Mini | Dibuat dengan ❤️ oleh Kamu</p>
</footer>

</body>
</html>
