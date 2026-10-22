<?php
require_once __DIR__ . '/config/database.php';
$pageTitle = 'Home';
$activePage = 'home';
$announcements = $pdo->query("SELECT title, body, created_at FROM announcements WHERE is_published = 1 ORDER BY created_at DESC LIMIT 3")->fetchAll();
require __DIR__ . '/includes/header.php';
?>
<main>
  <section class="hero">
    <p class="eyebrow">BARANGAY BAGONG BUHAY</p>
    <h1>Your concern matters.</h1>
    <p>BantayTicket is a web-based complaint and service request ticketing prototype. Submit a concern, receive a reference number, and check its status online.</p>
    <div class="actions">
      <a class="button" href="submit.php">Submit a Concern</a>
      <a class="button button-light" href="track.php">Track a Ticket</a>
    </div>
  </section>
  <section class="section">
    <h2>How it works</h2>
    <div class="cards">
      <article class="card"><span class="number">01</span><h3>Submit</h3><p>Provide the details of your complaint, request, or inquiry.</p></article>
      <article class="card"><span class="number">02</span><h3>Get a reference</h3><p>Your submission is saved and assigned a unique ticket reference.</p></article>
      <article class="card"><span class="number">03</span><h3>Track</h3><p>Use your reference number to check the current ticket status.</p></article>
    </div>
  </section>
  <section class="notice"><h2>Barangay information</h2><p>For urgent concerns or official assistance, contact or visit your barangay office directly. This is a student project prototype.</p></section>
  <section class="section">
    <h2>Announcements</h2>
    <?php if (!$announcements): ?>
      <article class="content-card"><p>No announcements have been published yet.</p></article>
    <?php else: foreach ($announcements as $item): ?>
      <article class="content-card"><p class="eyebrow"><?= e(date('M d, Y', strtotime($item['created_at']))) ?></p><h3><?= e($item['title']) ?></h3><p><?= nl2br(e($item['body'])) ?></p></article>
    <?php endforeach; endif; ?>
  </section>
</main>
<?php require __DIR__ . '/includes/footer.php'; ?>
