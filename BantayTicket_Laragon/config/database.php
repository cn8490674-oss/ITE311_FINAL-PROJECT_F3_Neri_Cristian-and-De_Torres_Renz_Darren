<?php
declare(strict_types=1);

$host = '127.0.0.1';
$dbname = 'bantayticket';
$username = 'root';
$password = ''; // Default Laragon MySQL setup is often blank. Change if yours has a password.

try {
    $pdo = new PDO(
        "mysql:host={$host};dbname={$dbname};charset=utf8mb4",
        $username,
        $password,
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
        ]
    );
} catch (PDOException $e) {
    http_response_code(500);
    exit('Database connection failed. Check Laragon MySQL, database name, and config/database.php settings.');
}
