<?php

#Why this is better: easier to reuse across environments (dev / staging / prod)
# cleaner configuration management easier to move DB credentials to a config file later

$host = 'localhost';
$db   = 'testdb';
$user = 'root';
$pass = '';

try {
    $pdo = new PDO(
    "mysql:host=$host;dbname=$db;charset=utf8mb4",
    $user,
    $pass
);

    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    # Switched from query() → prepare() + execute() for better security and flexibility.
    $sql = "SELECT id, title, body FROM blogposts"; 
    $stmt = $pdo->prepare($sql); 
    $stmt->execute();

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo $row['id'] . " - " . $row['title'] .  " - " . $row['body'] . "<br>";
        #echo "Created at: " . $row['created_at'] . "<br><br>";
        echo $row['id'] . "<br>";
        echo $row['title'] . "<br>";
        echo $row['body'] . "<br>";
        echo "<prev>";
        print_r($row);
        echo "</prev><hr>";

    }

} catch (PDOException $e) {
    die("Database error: " . $e->getMessage());
}
?>