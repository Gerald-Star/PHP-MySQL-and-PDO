<?php 

require 'prepared.php';

$message = '';



?>

<!DOCTYPE html>
<html>

<head>
  <title>Blog</title>
</head>

<body>

  <h1>Create Post</h1>

  <?php if ($message): ?>

  <p><?= htmlspecialchars($message) ?></p>

  <?php endif; ?>

  <form method="POST">

    <input type="text" name="title" placeholder="Title">

    <br><br>

    <textarea name="body" placeholder="Body"></textarea>

    <br><br>

    <button type="submit">
      Save
    </button>

  </form>

</body>

</html>