<?php
require_once __DIR__ . '/config/database.php';
require_once __DIR__ . '/includes/functions.php';
$pageTitle = 'Submit Concern';
$activePage = 'submit';
$error = '';
$reference = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    verify_csrf();
    $resident = trim((string)($_POST['resident_name'] ?? ''));
    $contact = trim((string)($_POST['contact_number'] ?? ''));
    $type = trim((string)($_POST['concern_type'] ?? ''));
    $subject = trim((string)($_POST['subject'] ?? ''));
    $details = trim((string)($_POST['details'] ?? ''));
    $allowed = ['Complaint', 'Service Request', 'Barangay Inquiry'];
    if ($resident === '' || $subject === '' || $details === '' || !in_array($type, $allowed, true)) {
        $error = 'Please complete all required fields and select a valid concern type.';
    } elseif (mb_strlen($resident) > 120 || mb_strlen($contact) > 40 || mb_strlen($subject) > 180 || mb_strlen($details) > 5000) {
        $error = 'One or more fields exceed the allowed length.';
    } else {
        $reference = 'BT-' . date('Ymd') . '-' . strtoupper(bin2hex(random_bytes(3)));
        $stmt = $pdo->prepare('INSERT INTO tickets (reference_no, resident_name, contact_number, concern_type, subject, details, status) VALUES (?, ?, ?, ?, ?, ?, ?)');
        $stmt->execute([$reference, $resident, $contact ?: null, $type, $subject, $details, 'Submitted']);
    }
}
require __DIR__ . '/includes/header.php';
?>
<main class="page">
  <p class="eyebrow">RESIDENT SERVICES</p><h1>Submit a concern</h1>
  <p class="lead">Fill out the form below. After successful submission, keep your reference number so you can check the status later.</p>
  <?php if ($reference): ?>
    <section class="success-card"><h2>Concern submitted successfully</h2><p>Your ticket reference number is:</p><p class="reference"><?= e($reference) ?></p><p>Save this number. You will need it to track your ticket.</p><a class="button" href="track.php?reference=<?= urlencode($reference) ?>">Track this ticket</a></section>
  <?php else: ?>
    <?php if ($error): ?><div class="alert"><?= e($error) ?></div><?php endif; ?>
    <form class="content-card" method="post" action="submit.php">
      <input type="hidden" name="csrf_token" value="<?= e(csrf_token()) ?>">
      <label for="resident_name">Resident name *</label><input id="resident_name" name="resident_name" maxlength="120" required value="<?= e($_POST['resident_name'] ?? '') ?>">
      <label for="contact_number">Contact number (optional)</label><input id="contact_number" name="contact_number" maxlength="40" value="<?= e($_POST['contact_number'] ?? '') ?>">
      <label for="concern_type">Concern type *</label><select id="concern_type" name="concern_type" required><option value="">Choose a concern type</option><?php foreach (['Complaint','Service Request','Barangay Inquiry'] as $option): ?><option <?= (($_POST['concern_type'] ?? '') === $option) ? 'selected' : '' ?>><?= e($option) ?></option><?php endforeach; ?></select>
      <label for="subject">Subject *</label><input id="subject" name="subject" maxlength="180" required placeholder="Short title of your concern" value="<?= e($_POST['subject'] ?? '') ?>">
      <label for="details">Details *</label><textarea id="details" name="details" rows="5" maxlength="5000" required placeholder="Describe your concern"><?= e($_POST['details'] ?? '') ?></textarea>
      <button class="button" type="submit">Submit Concern</button>
      <p class="small-note">This is a student prototype. Avoid including passwords or highly sensitive information.</p>
    </form>
  <?php endif; ?>
</main>
<?php require __DIR__ . '/includes/footer.php'; ?>
