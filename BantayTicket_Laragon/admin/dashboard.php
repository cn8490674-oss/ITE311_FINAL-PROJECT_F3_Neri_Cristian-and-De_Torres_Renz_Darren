<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../includes/functions.php';
require_admin();
$total = (int)$pdo->query('SELECT COUNT(*) FROM tickets')->fetchColumn();
$submitted = (int)$pdo->query("SELECT COUNT(*) FROM tickets WHERE status = 'Submitted'")->fetchColumn();
$progress = (int)$pdo->query("SELECT COUNT(*) FROM tickets WHERE status = 'In Progress'")->fetchColumn();
$resolved = (int)$pdo->query("SELECT COUNT(*) FROM tickets WHERE status = 'Resolved'")->fetchColumn();
$pageTitle = 'Admin Dashboard'; $homePrefix = '../'; $assetPrefix = '../';
require __DIR__ . '/../includes/header.php';
?>
<main>
  <p class="eyebrow">CONTENT MANAGEMENT SYSTEM</p><h1>Admin dashboard</h1>
  <p class="lead">Signed in as <?= e($_SESSION['admin_username'] ?? 'Admin') ?>.</p>
  <div class="admin-links"><a class="button" href="tickets.php">Manage Tickets</a><a class="button button-light" href="announcements.php">Manage Announcements</a><a class="button button-light" href="logout.php">Log out</a></div>
  <section class="cards stats">
    <article class="card"><span class="number">ALL TICKETS</span><h2><?= $total ?></h2></article>
    <article class="card"><span class="number">SUBMITTED</span><h2><?= $submitted ?></h2></article>
    <article class="card"><span class="number">IN PROGRESS</span><h2><?= $progress ?></h2></article>
    <article class="card"><span class="number">RESOLVED</span><h2><?= $resolved ?></h2></article>
  </section>
  <section class="notice"><h2>Administrator reminder</h2><p>Only authorized personnel should access resident records. This prototype should be tested locally before any real deployment.</p></section>
</main>
<?php require __DIR__ . '/../includes/footer.php'; ?>
