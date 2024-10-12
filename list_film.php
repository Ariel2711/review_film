<?php
include 'header.php';
include 'db.php';

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

$sql = "SELECT * FROM films";
$result = $conn->query($sql);
?>

<div class="film-container">
    
    <?php echo "<h3>Welcome, " . $_SESSION['username'] . "</h3>"; ?>
    <h3>Daftar Film</h3>
    <div class="film-grid">
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<div class='film-card'>";
                echo "<a href='detail_film.php?id_film=" . $row["id_film"] . "'>";
                echo "<img src='" . htmlspecialchars($row["poster_image"]) . "' alt='" . htmlspecialchars($row["title"]) . "' class='film-image'>";
                echo "<h3>" . htmlspecialchars($row["title"]) . "</h3>";
                echo "</a>";
                $rating = (float)$row["rating"];
                echo "<div class='film-rating'>";
                echo "&#9733; " . $rating . "/10";
                echo "</div>";
                echo "</div>";
            }
        } else {
            echo "<p>Tidak ada film.</p>";
        }
        ?>
    </div>
</div>

<?php
$conn->close();
include 'footer.php';
?>
