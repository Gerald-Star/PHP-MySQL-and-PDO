<?php

#update.php

require 'db.php';

$newTitle = 'MovieTitle';
$newBody  = 'Updated body content.';


$updateSql = "
    UPDATE blogposts
    SET title = :title, body = :body
    WHERE id = :id
";

$stmt = $pdo->prepare($updateSql);

$stmt->execute([
    ':title' => $newTitle,
    ':body'  => $newBody,
    ':id'    => 1
]);

echo "Update completed.";
#echo "Rows affected: " . $stmt->rowCount();

?>