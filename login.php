<?php
include 'header.php';
include 'db.php';

if (isset($_SESSION['username'])) {
    header("Location: list_film.php");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $sql = $conn->prepare("SELECT * FROM users WHERE email=?");
    $sql->bind_param("s", $email);
    $sql->execute();
    $result = $sql->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if (password_verify($password, $row['password'])) {
            $_SESSION['username'] = $row['username'];
            header("Location: index.php");
        } else {
            echo "<script>alert('Password salah!');</script>";
        }
    } else {
        echo "<script>alert('Username tidak ditemukan!');</script>";
    }
    
    $sql->close();
    $conn->close();
}
?>

<div class="auth-container">
    <h2>Login</h2>
    <form method="post" action="">
        <label for="email">Email:</label>
        <input type="text" name="email" id="email" required><br>

        <label for="password">Password:</label>
        <input type="password" name="password" id="password" required><br>

        <input type="submit" value="Login">
    </form>
    <a href="register.php" class="link-auth">Register here!</a>
</div>

<?php include 'footer.php'; ?>
