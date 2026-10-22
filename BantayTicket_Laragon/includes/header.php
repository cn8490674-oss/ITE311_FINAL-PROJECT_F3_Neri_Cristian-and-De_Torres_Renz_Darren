<?php
require_once __DIR__ . '/functions.php';
$pageTitle = $pageTitle ?? 'BantayTicket';
$activePage = $activePage ?? '';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= e($pageTitle) ?> | BantayTicket</title>
  <link rel="stylesheet" href="<?= e($assetPrefix ?? '') ?>assets/css/style.css">
</head>
<body>
<header class="site-header">
  <a class="brand" href="<?= e($homePrefix ?? '') ?>index.php">BantayTicket</a>
  <nav aria-label="Main navigation">
    <a class="<?= $activePage === 'home' ? 'active' : '' ?>" href="<?= e($homePrefix ?? '') ?>index.php">Home</a>
    <a class="<?= $activePage === 'about' ? 'active' : '' ?>" href="<?= e($homePrefix ?? '') ?>about.php">About</a>
    <a class="<?= $activePage === 'submit' ? 'active' : '' ?>" href="<?= e($homePrefix ?? '') ?>submit.php">Submit Concern</a>
    <a class="<?= $activePage === 'track' ? 'active' : '' ?>" href="<?= e($homePrefix ?? '') ?>track.php">Track Ticket</a>
    <a href="<?= e($homePrefix ?? '') ?>admin/login.php">Admin</a>
  </nav>
</header>
