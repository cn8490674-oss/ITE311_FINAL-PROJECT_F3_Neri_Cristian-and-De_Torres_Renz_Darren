<?php
require_once __DIR__ . '/config/database.php';
require_once __DIR__ . '/includes/functions.php';
$pageTitle = 'Track Ticket';
$activePage = 'track';
$reference = strtoupper(trim((string)($_GET['reference'] ?? $_POST['reference'] ?? '')));
$ticket = null;
$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    verify_csrf();
}
if ($reference !== '') {
    $stmt = $pdo->prepare('SELECT reference_no, concern_type, subject, status, created_at, updated_at, public_update FROM tickets WHERE reference_no = ?');
    $stmt->execute([$reference]);
    $ticket = $stmt->fetch() ?: null;
    if (!$ticket) $error = 'No ticket was found with that reference number. Check the number and try again.';
}
require __DIR__ . '/includes/header.php';
?>
<main class="page">
  <p class="eyebrow">TICKET STATUS</p><h1>Track your ticket</h1>
  <p class="lead">Enter the reference number you received after submitting a concern.</p>
  <form class="content-card" method="post" action="track.php">
    <input type="hidden" name="csrf_token" value="<?= e(csrf_token()) ?>">
    <label for="reference">Ticket reference number</label>
    <input id="reference" name="reference" type="text" maxlength="40" placeholder="Example: BT-20261022-A1B2C3" value="<?= e($reference) ?>" required>
    <button class="button" type="submit">Check Status</button>
  </form>
  <?php if ($error): ?><div class="alert"><?= e($error) ?></div><?php endif; ?>
  <?php if ($ticket): ?>
    <section class="content-card">
      <p class="eyebrow">TICKET FOUND</p><h2><?= e($ticket['reference_no']) ?></h2>
      <p><strong>Type:</strong> <?= e($ticket['concern_type']) ?></p>
      <p><strong>Subject:</strong> <?= e($ticket['subject']) ?></p>
      <p><strong>Status:</strong> <span class="status"><?= e($ticket['status']) ?></span></p>
      <p><strong>Date submitted:</strong> <?= e(date('M d, Y h:i A', strtotime($ticket['created_at']))) ?></p>
      <?php if (!empty($ticket['public_update'])): ?><p><strong>Latest update:</strong> <?= nl2br(e($ticket['public_update'])) ?></p><?php endif; ?>
      <p class="small-note">For privacy, this page does not display resident names or contact numbers.</p>
    </section>
  <?php endif; ?>
</main>
<?php require __DIR__ . '/includes/footer.php'; ?>
