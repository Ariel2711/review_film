<?php
include 'header.php';
include 'db.php';

if (isset($_SESSION['username'])) {
    header("Location: list_film.php");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

    $sql = $conn->prepare("INSERT INTO users (email, username, password) VALUES (?, ?, ?)");
    $sql->bind_param("sss",$email, $username, $password);

    if ($sql->execute()) {
        echo "<script>alert('Pendaftaran berhasil!');</script>";
        echo "<script>window.location.href = 'login.php';</script>";
    } else {
        echo "<script>alert('Error: " . $sql->error . "');</script>";
    }
    
    $sql->close();
    $conn->close();
}
?>

<div class="auth-container">
    <h2>Register</h2>
    <form method="post" action="">
        <label for="email">Email:</label>
        <input type="text" name="email" id="email" required><br>

        <label for="username">Username:</label>
        <input type="text" name="username" id="username" required><br>

        <label for="password">Password:</label>
        <input type="password" name="password" id="password" required><br>

        <input type="submit" value="Register">
    </form>
    <a href="login.php" class="link-auth">Login here!</a>
</div>

<?php include 'footer.php'; ?>
