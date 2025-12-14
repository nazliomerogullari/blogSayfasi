<?php
require 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $email    = $_POST['email'];
    $password = md5($_POST['password']);

    $stmt = $conn->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $username, $email, $password);

    if ($stmt->execute()) {
        header("Location: login.php");
        exit();
    } else {
        echo "Kayıt sırasında hata oluştu: " . $conn->error;
    }
}
?>
<link rel="stylesheet" href="style.css">

<h2>Kayıt Ol</h2>

<form method="POST">
  <label>Kullanıcı Adı:</label><br>
  <input type="text" name="username" required><br><br>

  <label>E-posta:</label><br>
  <input type="email" name="email" required><br><br>

  <label>Şifre:</label><br>
  <input type="password" name="password" required><br><br>

  <button type="submit">Kayıt Ol</button>
</form>

<p>Zaten hesabınız var mı? <a href="login.php">Giriş Yap</a></p>
