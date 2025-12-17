<?php include 'auth.php'; ?>

<?php
ob_start(); // 🔹 Mencegah error header already sent
include 'config.php';

$id = $_GET['id'];
$result = mysqli_query($conn, "SELECT * FROM berita WHERE id=$id");
$data = mysqli_fetch_assoc($result);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Berita</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
    <h3 class="mb-4 text-center">✏️ Edit Berita</h3>
    <form action="" method="POST" enctype="multipart/form-data" class="card p-4 shadow-sm">
        <div class="mb-3">
            <label>Judul Berita</label>
            <input type="text" name="judul" class="form-control" value="<?= $data['judul']; ?>" required>
        </div>

        <div class="mb-3">
            <label>Isi Berita</label>
            <textarea name="isi" class="form-control" rows="6" required><?= $data['isi']; ?></textarea>
        </div>

        <div class="mb-3">
            <label>Penulis</label>
            <input type="text" name="penulis" class="form-control" value="<?= $data['penulis']; ?>" required>
        </div>

        <div class="mb-3">
            <label>Kategori</label>
            <select name="Kategori" class="form-select" required>
                <?php
                $kategori_tersedia = ['Teknologi', 'Olahraga', 'Pendidikan', 'Politik', 'Hiburan', 'Kesehatan'];
                $kategori_saat_ini = $data['Kategori'] ?? '';
                foreach ($kategori_tersedia as $kategori) {
                    $selected = ($kategori_saat_ini == $kategori) ? 'selected' : '';
                    echo "<option value='$kategori' $selected>$kategori</option>";
                }
                ?>
            </select>
        </div>


        <div class="mb-3">
            <label>Gambar</label><br>
            <?php if (!empty($data['gambar'])): ?>
                <img src="uploads/<?= $data['gambar']; ?>" width="150" class="mb-2 rounded">
            <?php endif; ?>
            <input type="file" name="gambar" class="form-control">
        </div>
        <div class="mx-5 text-center">
            <button type="submit" name="update" class="btn btn-success">Perbarui</button>
            <a href="index.php" class="btn btn-secondary">Kembali</a>
        </div>
    </form>

    <?php
    if (isset($_POST['update'])) {
        $judul = mysqli_real_escape_string($conn, $_POST['judul']);
        $isi = mysqli_real_escape_string($conn, $_POST['isi']);
        $penulis = mysqli_real_escape_string($conn, $_POST['penulis']);
        $kategori = mysqli_real_escape_string($conn, $_POST['Kategori']);
        $gambar = $_FILES['gambar']['name'];

        // Jika user upload gambar baru
        if ($gambar != '') {
            $target_dir = "uploads/";
            $target_file = $target_dir . basename($gambar);
            move_uploaded_file($_FILES['gambar']['tmp_name'], $target_file);
            $query = "UPDATE berita SET judul='$judul', isi='$isi', penulis='$penulis', kategori='$kategori', gambar='$gambar' WHERE id=$id";
        } else {
            $query = "UPDATE berita SET judul='$judul', isi='$isi', penulis='$penulis', kategori='$kategori' WHERE id=$id";
        }

        if (mysqli_query($conn, $query)) {
            echo "<div class='alert alert-success mt-3'>✅ Berita berhasil diperbarui!</div>";
            header("refresh:1;url=index.php");
        } else {
            echo "<div class='alert alert-danger mt-3'>❌ Gagal memperbarui berita: " . mysqli_error($conn) . "</div>";
        }
    }
    ?>
</div>

</body>
</html>
<?php ob_end_flush(); // 🔹 Menutup output buffering ?>
