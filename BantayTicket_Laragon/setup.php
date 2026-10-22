<?php
// Run once locally, then delete this file.
require_once __DIR__ . '/includes/functions.php';
$host = '127.0.0.1';
$dbname = 'bantayticket';
$username = 'root';
$password = '';
$message = '';
$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $adminUser = trim((string)($_POST['admin_username'] ?? ''));
    $adminPass = (string)($_POST['admin_password'] ?? '');
    if (strlen($adminUser) < 4 || strlen($adminPass) < 12) {
        $error = 'Use a username with at least 4 characters and a password with at least 12 characters.';
    } else {
        try {
            $server = new PDO("mysql:host={$host};charset=utf8mb4", $username, $password, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
            $server->exec("CREATE DATABASE IF NOT EXISTS `bantayticket` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
            $pdo = new PDO("mysql:host={$host};dbname={$dbname};charset=utf8mb4", $username, $password, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
            $pdo->exec("CREATE TABLE IF NOT EXISTS admins (
                id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                username VARCHAR(80) NOT NULL UNIQUE,
                password_hash VARCHAR(255) NOT NULL,
                created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
            ) ENGINE=InnoDB");
            $pdo->exec("CREATE TABLE IF NOT EXISTS tickets (
                id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                reference_no VARCHAR(40) NOT NULL UNIQUE,
                resident_name VARCHAR(120) NOT NULL,
                contact_number VARCHAR(40) NULL,
                concern_type ENUM('Complaint','Service Request','Barangay Inquiry') NOT NULL,
                subject VARCHAR(180) NOT NULL,
                details TEXT NOT NULL,
                status ENUM('Submitted','In Review','In Progress','Resolved','Rejected') NOT NULL DEFAULT 'Submitted',
                public_update TEXT NULL,
                created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
                updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                INDEX idx_ticket_status (status),
                INDEX idx_ticket_created (created_at)
            ) ENGINE=InnoDB");
            $pdo->exec("CREATE TABLE IF NOT EXISTS announcements (
                id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                title VARCHAR(180) NOT NULL,
                body TEXT NOT NULL,
                is_published TINYINT(1) NOT NULL DEFAULT 1,
                created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
            ) ENGINE=InnoDB");
            $stmt = $pdo->prepare('SELECT id FROM admins WHERE username = ?');
            $stmt->execute([$adminUser]);
            if ($stmt->fetch()) {
                $error = 'That admin username already exists. Choose another username.';
            } else {
                $stmt = $pdo->prepare('INSERT INTO admins (username, password_hash) VALUES (?, ?)');
                $stmt->execute([$adminUser, password_hash($adminPass, PASSWORD_DEFAULT)]);
                $message = 'Setup completed. Test login now, then delete setup.php from the project folder.';
            }
        } catch (Throwable $e) {
            $error = 'Setup failed. Check that Laragon MySQL is running and config/database.php uses the correct credentials.';
        }
    }
}
?>
<!doctype html><html lang="en"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1"><title>BantayTicket Setup</title><link rel="stylesheet" href="assets/css/style.css"></head><body>
<main class="page"><p class="eyebrow">ONE-TIME INSTALLER</p><h1>BantayTicket setup</h1><p class="lead">This creates the local database tables and your first administrator account.</p>
<?php if ($message): ?><div class="success-card"><?= htmlspecialchars($message, ENT_QUOTES, 'UTF-8') ?><p><a class="button" href="admin/login.php">Go to admin login</a></p></div><?php endif; ?>
<?php if ($error): ?><div class="alert"><?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?></div><?php endif; ?>
<form class="content-card" method="post"><label for="admin_username">Create admin username</label><input id="admin_username" name="admin_username" minlength="4" maxlength="80" required><label for="admin_password">Create admin password (minimum 12 characters)</label><input id="admin_password" name="admin_password" type="password" minlength="12" required><button class="button" type="submit">Create Database and Admin</button><p class="small-note">Default Laragon database settings are root with a blank password. If yours differs, edit setup.php and config/database.php before running.</p></form>
</main></body></html>
