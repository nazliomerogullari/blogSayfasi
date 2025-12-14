<?php
session_start();
require 'db.php';

if (!isset($_GET['id'])) {
    echo "Geçersiz istek.";
    exit();
}

$post_id = $_GET['id'];

$stmt = $conn->prepare("SELECT * FROM posts WHERE id=?");
$stmt->bind_param("i", $post_id);
$stmt->execute();
$result = $stmt->get_result();

if ($post = $result->fetch_assoc()):
?>
<link rel="stylesheet" href="style.css">

<h2><?= htmlspecialchars($post['title']) ?></h2>
<p><?= nl2br(htmlspecialchars($post['content'])) ?></p>
<p><small>Oluşturulma tarihi: <?= $post['created_at'] ?></small></p>
<p><a href="index.php">← Geri dön</a></p>

<?php else: ?>
    <p>Gönderi bulunamadı.</p>
    <p><a href="index.php">← Geri dön</a></p>
<?php endif; ?>
