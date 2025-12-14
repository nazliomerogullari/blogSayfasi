<?php
session_start();
require 'db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST['title'];
    $content = $_POST['content'];
    $user_id = $_SESSION['user_id'];

    $stmt = $conn->prepare("INSERT INTO posts (user_id, title, content) VALUES (?, ?, ?)");
    $stmt->bind_param("iss", $user_id, $title, $content);

    if ($stmt->execute()) {
        header("Location: index.php");
        exit();
    } else {
        echo "Gönderi eklenirken hata oluştu: " . $conn->error;
    }
}
?>
<link rel="stylesheet" href="style.css">
<h2>Yeni Gönderi Oluştur</h2>

<form method="POST">
  <label>Başlık:</label><br>
  <input type="text" name="title" required><br><br>

  <label>İçerik:</label><br>
  <textarea name="content" rows="5" cols="50" required></textarea><br><br>

  <button type="submit">Gönderiyi Ekle</button>
</form>
