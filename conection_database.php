<?php
include_once "config.php";

$dsn = DB_DRIVER.":host=".DB_HOST.";dbname=".DB_NAME;

// Attempt to connect
try {
    $pdo = new PDO($dsn, DB_USER, DB_PASS);
    // Set PDO to throw exceptions on errors
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // echo "Connected successfully";
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
    exit;
}