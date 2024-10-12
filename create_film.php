<?php
include 'header.php';
include 'db.php';

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $director = $_POST['director'];
    $release_year = $_POST['release_year'];
    $genre = $_POST['genre'];
    $duration = $_POST['duration'];
    $synopsis = $_POST['synopsis'];
    $cast = $_POST['cast'];
    $review = $_POST['review'];
    $rating = $_POST['rating'];
    $trailer_url = $_POST['trailer_url'];

    $target_path = "images/";
    $target_path = $target_path . basename($_FILES['uploadedfile']['name']); 

    if ($_FILES['uploadedfile']['error'] !== UPLOAD_ERR_OK) {
        echo "<script>alert('File upload error: " . $_FILES['uploadedfile']['error'] . "');</script>";
        echo "<script>window.location.href = 'index.php';</script>";
        exit();
    }

    if (!move_uploaded_file($_FILES['uploadedfile']['tmp_name'], $target_path)) {
        echo "<script>alert('There was an error uploading the file, please try again!');</script>";
        echo "<script>window.location.href = 'index.php';</script>";
        exit();
    }

    if (isset($_POST['film_id'])) {
        $film_id = $_POST['film_id'];

        $sql = "UPDATE films SET title=?, director=?, release_year=?, genre=?, duration=?, synopsis=?, cast=?, review=?, rating=?, trailer_url=?, poster_image=? WHERE id_film=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssisisssissi", $title, $director, $release_year, $genre, $duration, $synopsis, $cast, $review, $rating, $trailer_url, $target_path, $film_id);

        if ($stmt->execute()) {
            echo "<script>alert('Film updated successfully');</script>";
            echo "<script>window.location.href = 'index.php';</script>";
        } else {
            echo "<script>alert('Error: " . $stmt->error . "')</script>";
            echo "<script>window.location.href = 'index.php';</script>";
        }
    } else {
        $sql = "INSERT INTO films (title, director, release_year, genre, duration, synopsis, cast, review, rating, trailer_url, poster_image) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssisisssiss", $title, $director, $release_year, $genre, $duration, $synopsis, $cast, $review, $rating, $trailer_url, $target_path);

        if ($stmt->execute()) {
            echo "<script>alert('Film created successfully');</script>";
            echo "<script>window.location.href = 'index.php';</script>";
        } else {
            echo "<script>alert('Insert Error: " . $stmt->error . "');</script>";
            echo "<script>window.location.href = 'index.php';</script>";
        }
    }

    $stmt->close();
}

$film_id = isset($_GET['id_film']) ? (int)$_GET['id_film'] : null;
$film = null;

if ($film_id) {
    $sql = "SELECT * FROM films WHERE id_film=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $film_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $film = $result->fetch_assoc();
    }
    $stmt->close();
}
?>

<div class="insert-film-container">
    <h2><?php echo $film ? 'Edit Film' : 'Tambah Film Baru'; ?></h2>
    <form enctype="multipart/form-data" method="POST" action="">
        <?php if ($film): ?>
            <input type="hidden" name="film_id" value="<?php echo $film['id_film']; ?>">
        <?php endif; ?>

        <label for="title">Judul Film:</label>
        <input type="text" id="title" name="title" value="<?php echo $film['title'] ?? ''; ?>" required>

        <label for="director">Sutradara:</label>
        <input type="text" id="director" name="director" value="<?php echo $film['director'] ?? ''; ?>" required>

        <label for="release_year">Rilis Tahun:</label>
        <input type="number" id="release_year" name="release_year" value="<?php echo $film['release_year'] ?? ''; ?>" required>

        <label for="genre">Genre:</label>
        <input type="text" id="genre" name="genre" value="<?php echo $film['genre'] ?? ''; ?>" required>

        <label for="duration">Durasi (menit):</label>
        <input type="number" id="duration" name="duration" value="<?php echo $film['duration'] ?? ''; ?>" required>

        <label for="synopsis">Sinopsis:</label>
        <textarea id="synopsis" name="synopsis" required><?php echo $film['synopsis'] ?? ''; ?></textarea>

        <label for="cast">Pemeran:</label>
        <input type="text" id="cast" name="cast" value="<?php echo $film['cast'] ?? ''; ?>" required>

        <label for="review">Review:</label>
        <textarea id="review" name="review" required><?php echo $film['review'] ?? ''; ?></textarea>

        <label for="rating">Rating:</label>
        <input type="number" step="0.1" id="rating" name="rating" value="<?php echo $film['rating'] ?? ''; ?>" required>

        <label for="trailer_url">Trailer URL:</label>
        <input type="url" id="trailer_url" name="trailer_url" value="<?php echo $film['trailer_url'] ?? ''; ?>">

        <label for="poster_image">Poster URL:</label>
        <input name="uploadedfile" type="file" /> <br>

        <?php if ($film): ?>
            <label>Poster Gambar:</label>
            <?php if (!empty($film['poster_image'])): ?>
                <img src="<?php echo $film['poster_image']; ?>" alt="Poster Film" style="width: 200px; height: auto;">
            <?php else: ?>
                <p>Tidak ada gambar poster tersedia.</p>
            <?php endif; ?>
        <?php endif; ?>

        <input type="submit" value="<?php echo $film ? 'Update Film' : 'Tambah Film'; ?>">
    </form>
</div>

<?php
$conn->close();
include 'footer.php';
?>
