<?php
$pdo = $GLOBALS['pdo'] ?? null;

if (!$pdo instanceof PDO) {
    echo "Error: PDO object not initialized in create_users_table.php\n";
    exit(1);
}

try {
    echo "Starting transaction...\n";
    $pdo->beginTransaction();
    echo "Transaction started successfully.\n";

    $query = "
        CREATE TABLE IF NOT EXISTS users (
        id INT AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(50) NOT NULL,
        email VARCHAR(50) UNIQUE NOT NULL,
        mobile_number BIGINT NOT NULL,
        address VARCHAR(255) DEFAULT NULL,
        city VARCHAR(128) DEFAULT NULL,
        state  VARCHAR(2)   DEFAULT NULL,
        zip INT DEFAULT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
        ) ENGINE=InnoDB;";


    $pdo->exec($query);
    echo "Committing transaction...\n";
    $pdo->commit();
    echo "Migration ran successfully: users table created.\n";
} catch (PDOException $e) {
    if ($pdo->inTransaction()) {
        echo "Rolling back transaction...\n";
        $pdo->rollBack();
    } else {
        echo "No active transaction to roll back.\n";
    }
    echo "Migration failed: " . $e->getMessage() . "\n";
}