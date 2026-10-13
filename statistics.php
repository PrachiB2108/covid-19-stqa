<?php
$pageTitle = 'Statistics'; $active = 'statistics';
require __DIR__ . '/includes/header.php';
$live = null;
try {
    $pdo = db();
    $live = [
        'Registered users' => (int)$pdo->query('SELECT COUNT(*) FROM users')->fetchColumn(),
        'Comments posted'  => (int)$pdo->query("SELECT COUNT(*) FROM comments WHERE status = 'visible'")->fetchColumn(),
        'Contact messages' => (int)$pdo->query('SELECT COUNT(*) FROM registrations')->fetchColumn(),
        'Information sections' => 6,
    ];
} catch (PDOException $ex) { log_error($ex); }
$sample = [['Sample cases (demo)', '12,345'], ['Sample recoveries (demo)', '11,200'], ['Sample vaccinations (demo)', '98,765'], ['Sample tests (demo)', '150,000']];
?>
<section class="page-hero stats-hero"><div class="container"><p class="eyebrow">Signal Desk / activity report</p><h1>Portal data desk</h1><p class="lead">A transparent snapshot of activity inside this academic portal. It does not report live public-health case data.</p></div></section>
<section class="section stats-overview">
  <div class="container">
    <div class="stats-heading"><div><span>LIVE DATABASE TOTALS</span><h2>How the desk is being used</h2></div><p>These counters reflect activity in this portal only.</p></div>
    <?php if ($live): ?>
      <div class="stats-metric-grid">
        <?php foreach ($live as $label => $n): ?><article class="stats-metric"><p class="stat-num"><?= (int)$n ?></p><p><?= e($label) ?></p><span>Live</span></article><?php endforeach; ?>
      </div>
    <?php else: ?>
      <p class="alert alert-error">Statistics are unavailable right now. <?= e(GENERIC_ERROR) ?></p>
    <?php endif; ?>
  </div>
</section>
<section class="section stats-sample">
  <div class="container stats-sample-grid">
    <div><p class="eyebrow">Display sample</p><h2>Illustrative figures, clearly marked</h2><p>These values exist only to demonstrate a data display. For current public-health figures, use the WHO COVID-19 dashboard or your national health ministry.</p><p class="disclaimer">Not live data. Not medical guidance.</p></div>
    <div class="stats-sample-list">
      <?php foreach ($sample as [$label, $number]): ?><div><span><?= e($label) ?></span><strong><?= e($number) ?></strong></div><?php endforeach; ?>
    </div>
  </div>
</section>
<?php require __DIR__ . '/includes/footer.php'; ?>
