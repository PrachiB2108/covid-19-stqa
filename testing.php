<?php
$pageTitle = 'Testing';
$active = 'testing';
require __DIR__ . '/includes/header.php';

$caseGroups = [
    ['Functional', 56, 'tests/functional-test-cases.md'],
    ['Regex', 39, 'tests/regex-test-cases.md'],
    ['Black-box', 31, 'tests/black-box-testing.md'],
    ['Integration', 9, 'tests/integration-testing.md'],
    ['Database', 16, 'tests/database-testing.md'],
    ['Security', 20, 'tests/security-testing.md'],
];

$reports = [
    ['Test execution report', 'Recorded automated, database, deployment, and manual test results.', 'tests/test-execution-report.md'],
    ['Test plan', 'Scope, approach, test environment, entry and exit criteria.', 'docs/test-plan.md'],
    ['Test summary', 'Case inventory and the current execution summary.', 'docs/test-summary.md'],
    ['Defect report', 'Defects found during testing and their resolution status.', 'docs/bug-reports.md'],
    ['Acceptance report', 'Requirements and acceptance criteria.', 'docs/acceptance-report.md'],
    ['Demo script', 'Suggested walkthrough for presenting the project.', 'docs/demo-script.md'],
];
?>
<section class="page-hero testing-hero">
  <div class="container">
    <p class="eyebrow">Signal Desk / software quality evidence</p>
    <h1>Test results desk</h1>
    <p class="lead">A clear view of what was tested, what passed in recorded automated runs, and what still needs manual execution.</p>
    <div class="testing-hero-meta">
      <span class="testing-status"><span aria-hidden="true"></span> Manual execution pending</span>
      <span>Last recorded automated pre-check: 3 October 2026</span>
    </div>
    <div class="btn-row testing-actions">
      <a class="btn" href="#recorded-runs">View recorded runs</a>
      <a class="btn btn-outline" href="<?= e('https://github.com/PrachiB2108/covid-19-stqa/blob/main/tests/test-execution-report.md') ?>">Open full execution report</a>
      <button class="btn btn-ghost" type="button" onclick="window.print()">Print / Save PDF</button>
    </div>
  </div>
</section>

<section class="section testing-notice-section" aria-label="Important status note">
  <div class="container">
    <div class="callout testing-notice">
      <strong>Read the results accurately.</strong>
      <p>The figures below are recorded pre-check results, not a live test runner. The 171 total is the number of documented test cases; manual test execution is still marked pending in the report. Do not describe all 171 as passed.</p>
    </div>
  </div>
</section>

<section class="section testing-summary" aria-labelledby="testing-summary-title">
  <div class="container">
    <div class="testing-section-heading">
      <div><p class="eyebrow">At a glance</p><h2 id="testing-summary-title">Evidence snapshot</h2></div>
      <p>Recorded automated checks are separate from the manual test plan.</p>
    </div>
    <div class="testing-metrics">
      <article class="testing-metric">
        <span class="testing-metric-label">Documented scope</span>
        <strong>171</strong>
        <span class="testing-metric-note">cases across six test areas</span>
      </article>
      <article class="testing-metric testing-metric-pass">
        <span class="testing-metric-label">PHP unit pre-check</span>
        <strong>51 / 51</strong>
        <span class="testing-metric-note">39 regex + 12 function checks passed</span>
      </article>
      <article class="testing-metric testing-metric-pass">
        <span class="testing-metric-label">Scripted end-to-end</span>
        <strong>56 / 56</strong>
        <span class="testing-metric-note">checks passed in the recorded run</span>
      </article>
      <article class="testing-metric testing-metric-pending">
        <span class="testing-metric-label">Manual execution</span>
        <strong>Pending</strong>
        <span class="testing-metric-note">record actual results before submission</span>
      </article>
    </div>
  </div>
</section>

<section class="section section-tint" id="recorded-runs" aria-labelledby="recorded-runs-title">
  <div class="container">
    <div class="testing-section-heading">
      <div><p class="eyebrow">Recorded evidence · 3 October 2026</p><h2 id="recorded-runs-title">Automated and environment checks</h2></div>
      <p>These entries summarize the execution report. Each run records its own environment.</p>
    </div>
    <div class="table-wrap testing-table-wrap">
      <table class="testing-results-table">
        <thead><tr><th scope="col">Check</th><th scope="col">Recorded result</th><th scope="col">Environment / notes</th></tr></thead>
        <tbody>
          <tr><th scope="row">PHP regex + function checks</th><td><span class="result-pill result-pass">51 passed · 0 failed</span></td><td>Ubuntu 24.04, PHP 8.3.6; 39 regex cases and 12 function checks.</td></tr>
          <tr><th scope="row">JavaScript regex comparison</th><td><span class="result-pill result-pass">39 matched · 0 mismatches</span></td><td>Node.js comparison against the PHP regex results.</td></tr>
          <tr><th scope="row">Scripted end-to-end checks</th><td><span class="result-pill result-pass">56 passed · 0 failed</span></td><td>HTTP, validation, account flows, access control, comments, and admin checks.</td></tr>
          <tr><th scope="row">PostgreSQL migration verification</th><td><span class="result-pill result-pass">Recorded as passed</span></td><td>Local disposable PostgreSQL database; schema, authentication, user flows, and health endpoint.</td></tr>
          <tr><th scope="row">Vercel production verification</th><td><span class="result-pill result-pass">Recorded as passed</span></td><td>Production build, PostgreSQL health, registration/login flow, comments, contact, and logout.</td></tr>
          <tr><th scope="row">Manual browser / acceptance cases</th><td><span class="result-pill result-pending">Pending execution</span></td><td>Visual, responsive, keyboard, browser compatibility, and other human-observed checks still need results recorded.</td></tr>
        </tbody>
      </table>
    </div>
    <p class="testing-footnote">Coverage was not measured. Full environments, check details, and limitations are documented in the <a href="<?= e('https://github.com/PrachiB2108/covid-19-stqa/blob/main/tests/test-execution-report.md') ?>">execution report</a>.</p>
  </div>
</section>

<section class="section" aria-labelledby="test-scope-title">
  <div class="container">
    <div class="testing-section-heading">
      <div><p class="eyebrow">Planned test inventory</p><h2 id="test-scope-title">What the test plan covers</h2></div>
      <p>Counts below describe documented cases, not pass counts.</p>
    </div>
    <div class="testing-scope-grid">
      <?php foreach ($caseGroups as [$label, $count, $path]): ?>
        <a class="testing-scope-card" href="<?= e('https://github.com/PrachiB2108/covid-19-stqa/blob/main/' . $path) ?>">
          <span><?= e($label) ?></span><strong><?= (int)$count ?></strong><span class="testing-scope-link">View cases <span aria-hidden="true">→</span></span>
        </a>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<section class="section section-tint" aria-labelledby="quality-notes-title">
  <div class="container testing-bottom-grid">
    <div>
      <p class="eyebrow">Issues and follow-up</p>
      <h2 id="quality-notes-title">Defects are part of the evidence</h2>
      <p>The recorded pre-check found one application defect, BUG-001, which was fixed and retested. A test expectation was also corrected. Manual defect counts remain pending until the planned manual tests are run.</p>
      <a class="text-link" href="<?= e('https://github.com/PrachiB2108/covid-19-stqa/blob/main/docs/bug-reports.md') ?>">Review the defect report <span aria-hidden="true">→</span></a>
    </div>
    <div>
      <p class="eyebrow">Project documentation</p>
      <h2>Explore the test records</h2>
      <ul class="testing-report-links">
        <?php foreach ($reports as [$label, $description, $path]): ?>
          <li><a href="<?= e('https://github.com/PrachiB2108/covid-19-stqa/blob/main/' . $path) ?>"><strong><?= e($label) ?></strong><span><?= e($description) ?></span></a></li>
        <?php endforeach; ?>
      </ul>
    </div>
  </div>
</section>

<?php require __DIR__ . '/includes/footer.php'; ?>