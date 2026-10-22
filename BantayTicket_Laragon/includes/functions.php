<?php
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}
function e(?string $value): string {
    return htmlspecialchars($value ?? '', ENT_QUOTES, 'UTF-8');
}
function is_admin(): bool {
    return !empty($_SESSION['admin_id']);
}
function require_admin(): void {
    if (!is_admin()) {
        header('Location: login.php');
        exit;
    }
}
function csrf_token(): string {
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}
function verify_csrf(): void {
    $token = $_POST['csrf_token'] ?? '';
    if (!is_string($token) || !hash_equals($_SESSION['csrf_token'] ?? '', $token)) {
        http_response_code(400);
        exit('Invalid request token. Please go back and try again.');
    }
}
