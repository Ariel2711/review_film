<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FilmVerse</title>
    <link rel="icon" href="images/icon.ico" type="image/x-icon">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="nav">
        <a href="index.php" class="nav-link">
            <div class="circle">
                <img src="images/icon.png" alt="Home Icon" class="nav-icon">
            </div>
            <span class="nav-text">FilmVerse</span>
        </a>
        <?php
        if (isset($_SESSION['username'])) {
            echo '<a href="logout.php" class="logout-link">Logout</a>';
        }
        ?>
    </div>
</body>
</html>
