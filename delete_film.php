<?php
include 'db.php';

if (isset($_GET['id_film'])) {
    $stmt = $conn->prepare("SELECT poster_image FROM films WHERE id_film = ?");
    $stmt->bind_param("i", $_GET["id_film"]);
    $stmt->execute();
    $stmt->bind_result($imagePath);
    $stmt->fetch();
    $stmt->close();

    $stmt = $conn->prepare("DELETE FROM films WHERE id_film = ?");
    $stmt->bind_param("i", $_GET["id_film"]);

    if ($stmt->execute()) {
        if ($imagePath && file_exists($imagePath)) {
            unlink($imagePath);
        }
        header("Location: index.php");
        exit();
    } else {
        header("Location: index.php");
    }

    $stmt->close();
}

$conn->close();
