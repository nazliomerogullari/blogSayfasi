<?php
session_start();
require 'db.php';
?>
<link rel="stylesheet" href="style.css">
<h2>Blog Uygulamasına Hoş Geldiniz</h2>

<?php if (isset($_SESSION['user_id'])): ?>

    <p>Merhaba, <strong><?= $_SESSION['username'] ?></strong>! <a href="logout.php">Çıkış yap</a></p>
    <p><a href="create.php">+ Yeni Gönderi Ekle</a></p>

    <hr>

    <?php
    $user_id = $_SESSION['user_id'];
    $stmt = $conn->prepare("SELECT * FROM posts WHERE user_id=? ORDER BY created_at DESC");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0):
        while ($post = $result->fetch_assoc()):
    ?>
        <div style="border:1px solid #ccc; padding:10px; margin-bottom:10px;">
            <h3><?= htmlspecialchars($post['title']) ?></h3>
            <p><?= substr(strip_tags($post['content']), 0, 100) ?>...</p>
            <a href="detail.php?id=<?= $post['id'] ?>">Detay</a> |
            <a href="edit.php?id=<?= $post['id'] ?>">Düzenle</a> |
            <a href="delete.php?id=<?= $post['id'] ?>">Sil</a>
        </div>
    <?php endwhile; else: ?>
        <p>Henüz gönderi yok.</p>
    <?php endif; ?>

<?php else: ?>
    <p>Lütfen <a href="login.php">giriş yapın</a> veya <a href="register.php">kayıt olun</a>.</p>
<?php endif; ?>
