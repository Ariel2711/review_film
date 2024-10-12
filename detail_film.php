<?php
include 'header.php';
include 'db.php';

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

$id_film = $_GET['id_film'];
$sql = "SELECT * FROM films WHERE id_film = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id_film);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
} else {
    echo "Film tidak ditemukan.";
    exit();
}

?>

<div class="film-detail-container">
    <div class="back-button">
            <a href="list_film.php">
                <button>&laquo; Back</button>
            </a>
    </div>
    <div class="film-info">
        <h1><?php echo htmlspecialchars($row['title']); ?></h1>
        <p><strong>Sutradara:</strong> <?php echo htmlspecialchars($row['director']); ?></p>
        <p><strong>Rilis Tahun:</strong> <?php echo htmlspecialchars($row['release_year']); ?></p>
        <p><strong>Genre:</strong> <?php echo htmlspecialchars($row['genre']); ?></p>
        <p><strong>Durasi:</strong> <?php echo htmlspecialchars($row['duration']); ?> menit</p>
        <p><strong>Sinopsis:</strong> <?php echo htmlspecialchars($row['synopsis']); ?></p>
        <p><strong>Pemeran:</strong> <?php echo htmlspecialchars($row['cast']); ?></p>
        <p><strong>Rating:</strong> 
            <?php echo htmlspecialchars($row['rating']); ?> 
            <span class="star">&#9733;</span>
        </p>

        <?php if (!empty($row['trailer_url'])): ?>
            <p><strong>Trailer:</strong></p>
            <?php
                // Ubah URL YouTube menjadi embed URL
                function convertYouTubeUrlToEmbed($url) {
                    if (preg_match('/youtu\.be\/([a-zA-Z0-9_-]+)/', $url, $matches)) {
                        return "https://www.youtube.com/embed/" . $matches[1];
                    } elseif (preg_match('/youtube\.com\/watch\?v=([a-zA-Z0-9_-]+)/', $url, $matches)) {
                        return "https://www.youtube.com/embed/" . $matches[1];
                    } else {
                        return $url;
                    }
                }

                $embedUrl = convertYouTubeUrlToEmbed($row['trailer_url']);
            ?>
            <iframe width="560" height="315" src="<?php echo htmlspecialchars($embedUrl); ?>" frameborder="0" allowfullscreen></iframe>
        <?php endif; ?>
    </div>
    <div class="film-poster">
        <img src="<?php echo htmlspecialchars($row['poster_image']); ?>" alt="<?php echo htmlspecialchars($row['title']); ?>">
    </div>
</div>

<?php
$conn->close();
include 'footer.php';
?>
