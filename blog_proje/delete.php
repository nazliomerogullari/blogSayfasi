<?php
session_start();
require 'db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if (!isset($_GET['id'])) {
    echo "Geçersiz istek.";
    exit();
}

$post_id = $_GET['id'];
$user_id = $_SESSION['user_id'];

// Bu kullanıcıya ait mi?
$stmt = $conn->prepare("DELETE FROM posts WHERE id=? AND user_id=?");
$stmt->bind_param("ii", $post_id, $user_id);

if ($stmt->execute()) {
    header("Location: index.php");
    exit();
} else {
    echo "Silme sırasında hata oluştu: " . $conn->error;
}
?>
