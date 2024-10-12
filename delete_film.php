<?php
include 'db.php';

if (isset($_GET['id_film'])) {
    $stmt = $conn->prepare("DELETE FROM films WHERE id_film = ?");
    $stmt->bind_param("i", $_GET['id_film']);


    if ($stmt->execute()) {
        header("Location: index.php");
        exit();
    } else {
        header("Location: index.php");
    }


    $stmt->close();
}


$conn->close();
