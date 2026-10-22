<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../includes/functions.php';
require_admin();
$error = '';
$statuses = ['Submitted','In Review','In Progress','Resolved','Rejected'];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    verify_csrf();
    $id = filter_input(INPUT_POST, 'ticket_id', FILTER_VALIDATE_INT);
    $status = (string)($_POST['status'] ?? '');
    $update = trim((string)($_POST['public_update'] ?? ''));
    if (!$id || !in_array($status, $statuses, true) || mb_strlen($update) > 2000) {
        $error = 'Please check the status and update text.';
    } else {
        $stmt = $pdo->prepare('UPDATE tickets SET status = ?, public_update = ?, updated_at = CURRENT_TIMESTAMP WHERE id = ?');
        $stmt->execute([$status, $update ?: null, $id]);
        header('Location: tickets.php?updated=1'); exit;
    }
}
$tickets = $pdo->query('SELECT id, reference_no, resident_name, contact_number, concern_type, subject, details, status, public_update, created_at FROM tickets ORDER BY created_at DESC')->fetchAll();
$pageTitle = 'Manage Tickets'; $homePrefix = '../'; $assetPrefix = '../';
require __DIR__ . '/../includes/header.php';
?>
<main>
  <p class="eyebrow">ADMINISTRATION</p><h1>Manage tickets</h1>
  <p class="lead"><a href="dashboard.php">← Back to dashboard</a></p>
  <?php if (isset($_GET['updated'])): ?><div class="success-card compact">Ticket updated successfully.</div><?php endif; ?>
  <?php if ($error): ?><div class="alert"><?= e($error) ?></div><?php endif; ?>
  <?php if (!$tickets): ?><section class="content-card"><p>No tickets have been submitted yet.</p></section><?php endif; ?>
  <?php foreach ($tickets as $t): ?>
    <section class="content-card ticket-admin">
      <div class="ticket-heading"><div><p class="eyebrow"><?= e($t['reference_no']) ?></p><h2><?= e($t['subject']) ?></h2></div><span class="status"><?= e($t['status']) ?></span></div>
      <p><strong>Resident:</strong> <?= e($t['resident_name']) ?> · <strong>Contact:</strong> <?= e($t['contact_number'] ?: 'Not provided') ?></p>
      <p><strong>Type:</strong> <?= e($t['concern_type']) ?> · <strong>Submitted:</strong> <?= e(date('M d, Y h:i A', strtotime($t['created_at']))) ?></p>
      <p><?= nl2br(e($t['details'])) ?></p>
      <form method="post" class="admin-form">
        <input type="hidden" name="csrf_token" value="<?= e(csrf_token()) ?>"><input type="hidden" name="ticket_id" value="<?= (int)$t['id'] ?>">
        <label for="status-<?= (int)$t['id'] ?>">Status</label><select id="status-<?= (int)$t['id'] ?>" name="status"><?php foreach ($statuses as $s): ?><option <?= $t['status'] === $s ? 'selected' : '' ?>><?= e($s) ?></option><?php endforeach; ?></select>
        <label for="update-<?= (int)$t['id'] ?>">Public update (visible to resident)</label><textarea id="update-<?= (int)$t['id'] ?>" name="public_update" rows="2" maxlength="2000"><?= e($t['public_update']) ?></textarea>
        <button class="button" type="submit">Save Update</button>
      </form>
    </section>
  <?php endforeach; ?>
</main>
<?php require __DIR__ . '/../includes/footer.php'; ?>
