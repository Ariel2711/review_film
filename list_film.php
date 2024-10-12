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
    <div style="display: flex; justify-content: space-between; align-items: center;">
        <h3><?php echo "Welcome, " . htmlspecialchars($_SESSION['username']); ?></h3>
        <a href="create_film.php" class="create-film-button">Create Film</a>
    </div>
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
                
                echo "<div class='film-actions'>";
                echo "<button class='edit-button' onclick=\"window.location.href='create_film.php?id_film=" . $row["id_film"] . "'\" title='Edit Film'>Edit</button>";
                echo "<button class='delete-button' onclick=\"confirm('Are you sure you want to delete this film?') ? location.href='delete_film.php?id_film=" . $row['id_film'] . "' : ''\" title='Delete Film'>Delete</button>";
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
