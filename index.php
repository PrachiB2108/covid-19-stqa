<?php
$pageTitle = 'Home'; $active = 'home';
require __DIR__ . '/includes/header.php';
?>
<section class="home-command">
  <div class="container">
    <div class="home-statusline"><span class="home-statusdot" aria-hidden="true"></span> Public health information desk <span>Educational resource</span></div>
    <div class="home-command-grid">
      <div class="home-command-copy">
        <p class="eyebrow">COVID-19 information portal</p>
        <h1>Clear information.<br><em>Calm decisions.</em></h1>
        <p class="lead">A practical guide to symptoms, protection, vaccination and reliable community information.</p>
        <div class="btn-row">
          <a class="btn" href="<?= e(url('about.php')) ?>">Explore the guide</a>
          <a class="btn btn-outline" href="<?= e(url('prevention.php')) ?>">View prevention steps</a>
        </div>
      </div>
      <div class="home-command-visual"><?= img('v2-hero.svg', 'COVID-19 awareness illustration showing a protective shield and virus particles', 'hero-img') ?></div>
    </div>
  </div>
</section>

<section class="home-route-section">
  <div class="container">
    <div class="home-section-heading"><span>01 / Navigate</span><h2>Choose your next step</h2></div>
    <div class="home-route-grid">
      <a class="home-route-card" href="<?= e(url('symptoms.php')) ?>"><span class="home-route-number">A</span><div><h3>Symptoms</h3><p>Recognise common signs and know when to seek urgent care.</p></div><span class="home-route-arrow" aria-hidden="true">→</span></a>
      <a class="home-route-card" href="<?= e(url('prevention.php')) ?>"><span class="home-route-number">B</span><div><h3>Prevention</h3><p>Build a simple everyday protection routine.</p></div><span class="home-route-arrow" aria-hidden="true">→</span></a>
      <a class="home-route-card" href="<?= e(url('vaccination.php')) ?>"><span class="home-route-number">C</span><div><h3>Vaccination</h3><p>Understand the basics before speaking with a clinician.</p></div><span class="home-route-arrow" aria-hidden="true">→</span></a>
      <a class="home-route-card home-route-alert" href="<?= e(url('symptoms.php#emergency')) ?>"><span class="home-route-number">!</span><div><h3>Emergency guidance</h3><p>Review warning signs that need urgent medical help.</p></div><span class="home-route-arrow" aria-hidden="true">→</span></a>
    </div>
  </div>
</section>

<section class="home-briefing">
  <div class="container home-briefing-grid">
    <div class="home-briefing-image"><?= img('v2-awareness.svg', 'Illustration of three people standing together with a message bubble', 'side-img') ?></div>
    <article class="home-briefing-copy">
      <p class="eyebrow">02 / The brief</p>
      <h2>What is COVID-19?</h2>
      <p>COVID-19 is an infectious disease caused by the SARS-CoV-2 virus. It can spread when an infected person breathes out small droplets and particles while talking, coughing, sneezing or breathing.</p>
      <p>Spread is more likely in crowded, closed and poorly ventilated spaces. Some infections are mild, but older adults and people with certain health conditions can become seriously ill.</p>
      <div class="home-briefing-note"><span>Key idea</span><p>Prevention habits help protect the people around you, especially those who are more vulnerable.</p></div>
      <a class="home-text-link" href="<?= e(url('about.php')) ?>">Read the full overview <span aria-hidden="true">→</span></a>
    </article>
  </div>
</section>

<section class="home-signals">
  <div class="container">
    <div class="home-section-heading"><span>03 / Signals</span><h2>Common symptoms</h2><a href="<?= e(url('symptoms.php')) ?>">Full symptoms guide →</a></div>
    <div class="home-signal-grid">
      <div class="home-signal-main"><span>Monitor</span><strong>How you feel</strong><p>Symptoms vary from none at all to severe illness. They can appear 2 to 14 days after exposure.</p></div>
      <ul class="home-signal-list"><li>Fever or chills</li><li>Cough</li><li>Fatigue</li><li>Sore throat</li><li>Difficulty breathing</li><li>Loss of taste or smell</li></ul>
    </div>
  </div>
</section>

<section class="home-protocol">
  <div class="container">
    <div class="home-section-heading"><span>04 / Protocol</span><h2>Prevention, made practical</h2></div>
    <div class="home-protocol-grid">
      <article><span>01</span><h3>Clean hands</h3><p>Wash with soap and water, or use an alcohol-based sanitiser.</p></article>
      <article><span>02</span><h3>Use layers</h3><p>Wear a well-fitting mask where guidance or risk calls for it.</p></article>
      <article><span>03</span><h3>Improve air</h3><p>Open windows and doors; meet outdoors when possible.</p></article>
      <article><span>04</span><h3>Pause when sick</h3><p>Avoid exposing others while you have symptoms.</p></article>
      <article><span>05</span><h3>Check guidance</h3><p>Follow advice from your health ministry or the WHO.</p></article>
    </div>
  </div>
</section>

<section class="home-factcheck">
  <div class="container">
    <div class="home-section-heading"><span>05 / Fact check</span><h2>Pause before you pass it on</h2></div>
    <div class="factcheck-grid">
      <article class="factcheck-card"><p class="factcheck-label">Myth</p><h3>Only people with obvious symptoms can spread COVID-19.</h3><p class="factcheck-answer"><strong>Fact:</strong> People may spread the virus before symptoms begin, or without ever noticing symptoms.</p></article>
      <article class="factcheck-card"><p class="factcheck-label">Myth</p><h3>Vaccination makes other protection steps unnecessary.</h3><p class="factcheck-answer"><strong>Fact:</strong> Vaccination works alongside ventilation, staying home when sick and following local guidance.</p></article>
      <article class="factcheck-card factcheck-source"><p class="factcheck-label">Check the source</p><h3>Medical claims need reliable evidence.</h3><p>Use official health authorities and your doctor for current advice and personal health decisions.</p><a href="<?= e(url('about.php')) ?>">Read our information approach →</a></article>
    </div>
  </div>
</section>

<section class="home-vaccine-stat">
  <div class="container home-vaccine-stat-grid">
    <div class="home-vaccine-copy"><p class="eyebrow">06 / Protection</p><h2>Vaccination is one layer of protection.</h2><p>Vaccines train the immune system to recognise the virus so the body can respond faster. Follow current advice from official health authorities and your doctor.</p><a class="btn btn-outline" href="<?= e(url('vaccination.php')) ?>">Read vaccination basics</a></div>
    <div class="home-vaccine-image"><?= img('v2-vaccine.svg', 'Illustration of a syringe with a drop of vaccine', 'side-img') ?></div>
    <a class="home-stat-link" href="<?= e(url('statistics.php')) ?>"><span>PORTAL DATA</span><strong>Statistics</strong><p>Explore sample figures and activity from this portal.</p><b aria-hidden="true">→</b></a>
  </div>
</section>

<section class="home-join">
  <div class="container home-join-inner">
    <div><p class="eyebrow">Community notes</p><h2>Keep the conversation useful.</h2><p>Create an account to share comments and questions with the community.</p></div>
    <div class="btn-row">
      <?php if (is_logged_in()): ?>
        <a class="btn" href="<?= e(url('comments.php')) ?>">Add a comment</a>
      <?php else: ?>
        <a class="btn" href="<?= e(url('register.php')) ?>">Create an account</a>
        <a class="btn btn-ghost" href="<?= e(url('comments.php')) ?>">Read comments</a>
      <?php endif; ?>
    </div>
  </div>
</section>
<?php require __DIR__ . '/includes/footer.php'; ?>
