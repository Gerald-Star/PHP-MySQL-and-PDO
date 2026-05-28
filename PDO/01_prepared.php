<?php

require 'db.php';

try {

    $title = 'PDO Classes';
    $body  = 'PHP Data Objects (PDO) is a lightweight, consistent interface for accessing databases in PHP.';

    $sql = "
        INSERT INTO blogposts (title, body)
        VALUES (:title, :body)
    ";

    $stmt = $pdo->prepare($sql);

    $stmt->execute([
        ':title' => $title,
        ':body'  => $body
    ]);

    echo 'Post created successfully.';

} catch (PDOException $e) {

    die('Insert failed: ' . $e->getMessage());
}