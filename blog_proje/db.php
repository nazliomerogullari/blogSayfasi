<?php
$host = "127.0.0.1:3307"; // PORTU BELİRTİYORUZ
$user = "root";
$pass = "";              // Şifre yok
$db   = "blog";

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Veritabanı bağlantı hatası: " . $conn->connect_error);
}
?>
