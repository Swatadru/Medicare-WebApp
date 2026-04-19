<?php
require_once __DIR__ . '/env_loader.php';

$driver = $_ENV['DB_DRIVER'] ?? 'sqlite';
$host = $_ENV['DB_HOST'] ?? 'localhost';
$port = $_ENV['DB_PORT'] ?? '3306';
$dbname = $_ENV['DB_NAME'] ?? 'medicare_db';
$user = $_ENV['DB_USER'] ?? 'root';
$pass = $_ENV['DB_PASS'] ?? '';

try {
    if ($driver === 'sqlite') {
        $dbPath = dirname(__DIR__, 2) . '/medicare.sqlite';
        $dsn = 'sqlite:' . $dbPath;
        $conn = new PDO($dsn);
    } else {
        $dsn = "$driver:host=$host;port=$port;dbname=$dbname";
        $conn = new PDO($dsn, $user, $pass);
    }
    
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Database Connection failed: " . $e->getMessage());
}
?>
