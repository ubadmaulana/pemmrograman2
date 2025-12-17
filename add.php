<?php
include 'auth.php';
include 'config.php';
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tambah Berita</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5 mb-5">
    <div class="card p-4 shadow">
        <h3 class="text-center mb-4 text-primary">📝 Tambah Berita</h3>

        <form method="POST" enctype="multipart/form-data">
            <div class="mb-3">
                <label>Judul</label>
                <input type="text" name="judul" class="form-control" required>
            </div>

            <div class="mb-3">
                <label>Isi Berita</label>
                <textarea name="isi" class="form-control" rows="6" required></textarea>
            </div>

            <div class="mb-3">
                <label>Kategori</label>
                <select name="kategori" class="form-select" required>
                    <option value="">-- Pilih --</option>
                    <option>Teknologi</option>
                    <option>Olahraga</option>
                    <option>Pendidikan</option>
                    <option>Politik</option>
                </select>
            </div>

            <div class="mb-3">
                <label>Gambar</label>
                <input type="file" name="gambar" class="form-control">
            </div>

            <div class="text-center">
                <button name="submit" class="btn btn-primary">Simpan</button>
                <a href="index.php" class="btn btn-secondary">Kembali</a>
            </div>
        </form>

        <?php
        if (isset($_POST['submit'])) {

            $judul = mysqli_real_escape_string($conn, $_POST['judul']);
            $isi = mysqli_real_escape_string($conn, $_POST['isi']);
            $kategori = mysqli_real_escape_string($conn, $_POST['kategori']);

            $penulis = $_SESSION['user']['nama'];
            $user_id = $_SESSION['user']['id'];

            $gambar = "";
            if (!empty($_FILES['gambar']['name'])) {
                $gambar = time() . '_' . $_FILES['gambar']['name'];
                move_uploaded_file($_FILES['gambar']['tmp_name'], "uploads/$gambar");
            }

            $tanggal = date("Y-m-d");

            $query = "INSERT INTO berita 
            (judul, isi, penulis, kategori, gambar, tanggal, user_id)
            VALUES 
            ('$judul', '$isi', '$penulis', '$kategori', '$gambar', '$tanggal', '$user_id')";

            if (mysqli_query($conn, $query)) {
                echo "<div class='alert alert-success mt-3'>Berita berhasil ditambahkan</div>";
                header("refresh:1;url=index.php");
            }
        }
        ?>
    </div>
</div>

</body>
</html>
