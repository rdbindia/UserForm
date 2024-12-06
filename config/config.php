<?php

$config = require __DIR__ . '/database.php';

try {
    $dsn = "mysql:host={$config['host']};port={$config['port']};dbname={$config['database']};charset={$config['charset']}";
    $pdo = new PDO($dsn, $config['username'], $config['password']);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Database connection successful!\n";
    return $pdo;
} catch (PDOException $e) {
    echo "Database connection failed: " . $e->getMessage() . "\n";
    return false;
}