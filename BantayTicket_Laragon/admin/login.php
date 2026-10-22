<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../includes/functions.php';
if (is_admin()) { header('Location: dashboard.php'); exit; }
$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    verify_csrf();
    $username = trim((string)($_POST['username'] ?? ''));
    $password = (string)($_POST['password'] ?? '');
    $stmt = $pdo->prepare('SELECT id, username, password_hash FROM admins WHERE username = ?');
    $stmt->execute([$username]);
    $admin = $stmt->fetch();
    if ($admin && password_verify($password, $admin['password_hash'])) {
        session_regenerate_id(true);
        $_SESSION['admin_id'] = (int)$admin['id'];
        $_SESSION['admin_username'] = $admin['username'];
        header('Location: dashboard.php'); exit;
    }
    $error = 'Invalid username or password.';
}
$pageTitle = 'Admin Login';
$activePage = '';
$homePrefix = '../';
$assetPrefix = '../';
require __DIR__ . '/../includes/header.php';
?>
<main class="page">
  <p class="eyebrow">ADMINISTRATOR</p><h1>Admin login</h1><p class="lead">Sign in to manage tickets and announcements.</p>
  <?php if ($error): ?><div class="alert"><?= e($error) ?></div><?php endif; ?>
  <form class="content-card" method="post">
    <input type="hidden" name="csrf_token" value="<?= e(csrf_token()) ?>">
    <label for="username">Username</label><input id="username" name="username" autocomplete="username" required>
    <label for="password">Password</label><input id="password" name="password" type="password" autocomplete="current-password" required>
    <button class="button" type="submit">Log in</button>
    <p class="small-note">Run setup.php first to create the initial administrator account. Remove setup.php after installation.</p>
  </form>
</main>
<?php require __DIR__ . '/../includes/footer.php'; ?>
