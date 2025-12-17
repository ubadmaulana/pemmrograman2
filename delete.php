<?php include 'auth.php'; ?>

<?php
include 'config.php';
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    mysqli_query($conn, "DELETE FROM berita WHERE id=$id");
}
header("Location: index.php");
exit();
?>
