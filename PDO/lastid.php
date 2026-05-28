<?php 


require 'db.php';


$title = 'New blog post';
$body = 'This is the body of the new blog post';

$insertSql = "INSERT INTO blogposts(title, body) VALUES(:title, :body)";

$stmt = $pdo->prepare($insertSql);

$stmt ->execute([
  'title' => $title,
  'body' => $body
]);

echo "Last inserted ID: " . $pdo->lastInsertId();



?>