<?php
/** Usage: set $pageTitle and $active before including. */
require_once __DIR__ . '/auth.php';
$pageTitle = $pageTitle ?? 'COVID-19 Information & Awareness Portal';
$active    = $active ?? '';
$nav = [
    'home' => ['index.php', 'Home'], 'about' => ['about.php', 'About'],
    'symptoms' => ['symptoms.php', 'Symptoms'], 'prevention' => ['prevention.php', 'Prevention'],
    'vaccination' => ['vaccination.php', 'Vaccination'], 'statistics' => ['statistics.php', 'Statistics'],
    'testing' => ['testing.php', 'Testing'],
  'comments' => ['comments.php', 'Notes'], 'contact' => ['contact.php', 'Contact'],
];
?><!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?= e($pageTitle) ?> | Signal Desk</title>
  <meta name="description" content="Signal Desk: practical COVID-19 information, prevention guidance and community notes.">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=DM+Mono:wght@400;500&family=Manrope:wght@400;500;600;700;800&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="<?= e(url('assets/css/revamp.css')) ?>">
  <?php if ($active === 'home'): ?><link rel="stylesheet" href="<?= e(url('assets/css/home-revamp.css')) ?>"><?php endif; ?>
  <?php if (in_array($active, ['home', 'statistics'], true)): ?><link rel="stylesheet" href="<?= e(url('assets/css/insight-panels.css')) ?>"><?php endif; ?>
  <?php if ($active === 'testing'): ?><link rel="stylesheet" href="<?= e(url('assets/css/testing.css')) ?>"><?php endif; ?>
  <script src="<?= e(url('assets/js/script.js')) ?>" defer></script>
</head>
<body class="page-<?= e($active) ?>">
<a class="skip-link" href="#main">Skip to content</a>
<div class="shell">
<header class="site-header">
  <div class="sidebar-top">
    <a class="brand" href="<?= e(url('index.php')) ?>"><span class="brand-mark" aria-hidden="true"></span>SIGNAL DESK</a>
    <button class="nav-toggle" aria-expanded="false" aria-controls="site-nav" aria-label="Toggle menu">Menu</button>
  </div>
    <nav id="site-nav" class="site-nav" aria-label="Main">
      <ul>
        <?php foreach ($nav as $key => [$file, $label]): ?>
          <li><a href="<?= e(url($file)) ?>" <?= $active === $key ? 'aria-current="page"' : '' ?>><?= e($label) ?></a></li>
        <?php endforeach; ?>
        <?php if (is_logged_in()): ?>
          <li><a href="<?= e(url('dashboard.php')) ?>" <?= $active === 'dashboard' ? 'aria-current="page"' : '' ?>>Dashboard</a></li>
          <li><a class="btn btn-small btn-outline" href="<?= e(url('logout.php')) ?>">Logout</a></li>
        <?php else: ?>
          <li><a class="btn btn-small btn-outline" href="<?= e(url('login.php')) ?>">Login</a></li>
          <li><a class="btn btn-small" href="<?= e(url('register.php')) ?>">Register</a></li>
        <?php endif; ?>
      </ul>
    </nav>
</header>
<div class="content">
<?php $flashes = pull_flash(); if ($flashes): ?>
<div class="flash-area" aria-live="polite">
  <?php foreach ($flashes as $f): ?>
    <div class="alert alert-<?= e($f['type']) ?>" role="<?= $f['type'] === 'error' ? 'alert' : 'status' ?>">
      <span><?= e($f['msg']) ?></span><button class="alert-close" aria-label="Dismiss message">&times;</button>
    </div>
  <?php endforeach; ?>
</div>
<?php endif; ?>
<main id="main">
