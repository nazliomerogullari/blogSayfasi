<?php
session_start();
require 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email    = $_POST['email'];
    $password = md5($_POST['password']);

    $stmt = $conn->prepare("SELECT * FROM users WHERE email=? AND password=?");
    $stmt->bind_param("ss", $email, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($user = $result->fetch_assoc()) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        header("Location: index.php");
        exit();
    } else {
        echo "<p style='color:red;'>❌ Hatalı e-posta veya şifre!</p>";
    }
}
?>
<link rel="stylesheet" href="style.css">

<h2>Giriş Yap</h2>

<form method="POST">
  <label>E-posta:</label><br>
  <input type="email" name="email" required><br><br>

  <label>Şifre:</label><br>
  <input type="password" name="password" required><br><br>

  <button type="submit">Giriş Yap</button>
</form>

<p>Hesabınız yok mu? <a href="register.php">Kayıt Ol</a></p>
