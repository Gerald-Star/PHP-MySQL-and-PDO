<?php
#index.php
require 'db.php';

$sql = "SELECT id, title, body FROM blogposts";

$stmt = $pdo->prepare($sql);
$stmt->execute();

$posts = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html>

<head>
  <title>Blog</title>
</head>

<body>

  <?php foreach ($posts as $post): ?>

  <h2><?= htmlspecialchars($post['title']) ?></h2>

  <p><?= nl2br(htmlspecialchars($post['body'])) ?></p>

  <hr>

  <?php endforeach; ?>

</body>

</html>