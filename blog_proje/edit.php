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

// Önce bu gönderi mevcut mu ve bu kullanıcıya mı ait?
$stmt = $conn->prepare("SELECT * FROM posts WHERE id=? AND user_id=?");
$stmt->bind_param("ii", $post_id, $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($post = $result->fetch_assoc()):

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $title = $_POST['title'];
        $content = $_POST['content'];

        $update = $conn->prepare("UPDATE posts SET title=?, content=? WHERE id=? AND user_id=?");
        $update->bind_param("ssii", $title, $content, $post_id, $user_id);

        if ($update->execute()) {
            header("Location: index.php");
            exit();
        } else {
            echo "Güncelleme sırasında hata oluştu: " . $conn->error;
        }
    }
?>
<link rel="stylesheet" href="style.css">

<h2>Gönderiyi Düzenle</h2>

<form method="POST">
  <label>Başlık:</label><br>
  <input type="text" name="title" value="<?= htmlspecialchars($post['title']) ?>" required><br><br>

  <label>İçerik:</label><br>
  <textarea name="content" rows="5" cols="50" required><?= htmlspecialchars($post['content']) ?></textarea><br><br>

  <button type="submit">Kaydet</button>
</form>

<p><a href="index.php">← Geri dön</a></p>

<?php else: ?>
    <p>Gönderi bulunamadı ya da bu gönderiyi düzenleme yetkiniz yok.</p>
    <p><a href="index.php">← Geri dön</a></p>
<?php endif; ?>
