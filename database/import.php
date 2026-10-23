<?php
try {
    $host = '127.0.0.1';
    $port = 3306;
    $user = 'root';
    $pass = '';

    $pdo = new PDO("mysql:host={$host};port={$port}", $user, $pass, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ]);

    $sql = file_get_contents(__DIR__ . '/schema.sql');
    $pdo->exec($sql);

    echo "DATABASE & TABLES INITIALIZED SUCCESSFULLY!\n";
} catch (Exception $e) {
    echo "ERROR: " . $e->getMessage() . "\n";
    exit(1);
}
