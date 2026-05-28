<?php 

require 'db.php';

$deleteSql = "
    DELETE FROM blogposts
    WHERE id = :id

";

$stmt = $pdo->prepare($deleteSql);
$stmt->execute([
    ':id' => 4
]);

echo "Rows affected: " . $stmt->rowCount();



?>