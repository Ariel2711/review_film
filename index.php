<?php
include 'header.php';
include 'db.php';

if (isset($_SESSION['username'])) {
    header("Location: list_film.php");
} else {
    header("Location: login.php");
    exit;
}
?>

<?php include 'footer.php'; ?>
