<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../includes/functions.php';
require_admin();
$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    verify_csrf();
    $action = (string)($_POST['action'] ?? '');
    if ($action === 'delete') {
        $id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
        if ($id) { $stmt = $pdo->prepare('DELETE FROM announcements WHERE id = ?'); $stmt->execute([$id]); }
        header('Location: announcements.php'); exit;
    }
    $title = trim((string)($_POST['title'] ?? ''));
    $body = trim((string)($_POST['body'] ?? ''));
    $published = isset($_POST['is_published']) ? 1 : 0;
    if ($title === '' || $body === '' || mb_strlen($title) > 180 || mb_strlen($body) > 5000) {
        $error = 'Enter a title and announcement text within the allowed length.';
    } else {
        $stmt = $pdo->prepare('INSERT INTO announcements (title, body, is_published) VALUES (?, ?, ?)');
        $stmt->execute([$title, $body, $published]);
        header('Location: announcements.php?added=1'); exit;
    }
}
$items = $pdo->query('SELECT id, title, body, is_published, created_at FROM announcements ORDER BY created_at DESC')->fetchAll();
$pageTitle = 'Manage Announcements'; $homePrefix = '../'; $assetPrefix = '../';
require __DIR__ . '/../includes/header.php';
?>
<main class="page">
  <p class="eyebrow">CONTENT MANAGEMENT</p><h1>Announcements</h1><p class="lead"><a href="dashboard.php">← Back to dashboard</a></p>
  <?php if (isset($_GET['added'])): ?><div class="success-card compact">Announcement added.</div><?php endif; ?>
  <?php if ($error): ?><div class="alert"><?= e($error) ?></div><?php endif; ?>
  <form class="content-card" method="post">
    <input type="hidden" name="csrf_token" value="<?= e(csrf_token()) ?>">
    <label for="title">Announcement title</label><input id="title" name="title" maxlength="180" required>
    <label for="body">Announcement details</label><textarea id="body" name="body" rows="5" maxlength="5000" required></textarea>
    <label class="checkbox-label"><input type="checkbox" name="is_published" checked> Publish on public homepage</label>
    <button class="button" type="submit">Add Announcement</button>
  </form>
  <h2>Existing announcements</h2>
  <?php if (!$items): ?><p>No announcements yet.</p><?php endif; ?>
  <?php foreach ($items as $item): ?><section class="content-card"><h3><?= e($item['title']) ?></h3><p><?= nl2br(e($item['body'])) ?></p><p class="small-note"><?= $item['is_published'] ? 'Published' : 'Draft' ?> · <?= e(date('M d, Y', strtotime($item['created_at']))) ?></p><form method="post" onsubmit="return confirm('Delete this announcement?');"><input type="hidden" name="csrf_token" value="<?= e(csrf_token()) ?>"><input type="hidden" name="action" value="delete"><input type="hidden" name="id" value="<?= (int)$item['id'] ?>"><button class="button button-danger" type="submit">Delete</button></form></section><?php endforeach; ?>
</main>
<?php require __DIR__ . '/../includes/footer.php'; ?>
