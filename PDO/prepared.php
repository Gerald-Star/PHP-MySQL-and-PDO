<?php

require 'db.php';

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $title = trim($_POST['title']);
    $body  = trim($_POST['body']);

    if (!empty($title) && !empty($body)) {

        try {

            $sql = "
                INSERT INTO blogposts (title, body)
                VALUES (:title, :body)
            ";

            $stmt = $pdo->prepare($sql);

            $stmt->execute([
                ':title' => $title,
                ':body'  => $body
            ]);

            $message = 'Post added successfully.';
            echo 'Post created successfully.';

        } catch (PDOException $e) {

            $message = 'Insert failed: ' . $e->getMessage();
        }

    } else {

        $message = 'All fields are required.';
    }
}
?>