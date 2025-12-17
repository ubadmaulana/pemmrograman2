<?php
$host = "localhost";
$user = "root";
$pass = "";
$db   = "portal_berita";

$conn = mysqli_connect($host, $user, $pass, $db);

if (!$conn) {
    die("Koneksi database gagal: " . mysqli_connect_error());
}
?>
