<?php
# This file demonstrates how to use PDO to connect to a MySQL database and fetch data from a table.
# It also shows how to separate configuration into a separate file for better maintainability and security.
# db.php
$config = require 'config.php';

try {

    $pdo = new PDO(
        "mysql:host={$config['host']};dbname={$config['db']};charset=utf8mb4",
        $config['user'],
        $config['pass']
    );

    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

} catch (PDOException $e) {

    die("Connection failed: " . $e->getMessage());
}