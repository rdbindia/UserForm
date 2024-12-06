<?php

$pdo = require_once __DIR__ . '/../config/config.php';

if (!$pdo instanceof PDO) {
    echo "Error: PDO object not initialized in run_migrations.php\n";
    var_dump($pdo);
    exit(1);
}

$GLOBALS['pdo'] = $pdo;

echo "Running migrations...\n";

$files = glob(__DIR__ . "/migrations/*.php");
echo "Found migrations: " . implode(", ", $files) . "\n";

foreach ($files as $file) {
    $migrationName = basename($file);
    echo "Processing migration: $migrationName\n";

    $stmt = $pdo->prepare("SELECT COUNT(*) FROM migrations WHERE migration = :migration");
    $stmt->execute([':migration' => $migrationName]);
    if ($stmt->fetchColumn() > 0) {
        echo "Skipping already executed migration: $migrationName\n";
        continue;
    }

    require_once $file;

    $stmt = $pdo->prepare("INSERT INTO migrations (migration) VALUES (:migration)");
    $stmt->execute([':migration' => $migrationName]);

    echo "Migration executed: $migrationName\n";
}

echo "All migrations processed.\n";