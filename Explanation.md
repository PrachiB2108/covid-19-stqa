# COVID-19 Information & Awareness Portal — Project Explanation

This guide explains the application, how to run it locally with SQLite, what each page does, how its test plan is organized, and how the current Vercel + Neon deployment is configured. It is intended as a detailed project handover and presentation reference.

> **Data and testing honesty:** The public-health figures on the Statistics page are labelled demonstration data, not live health statistics. The project documents 171 test cases, but that does **not** mean all 171 have been executed or passed. The Testing page and execution report distinguish recorded runs from pending manual work.

## Contents

1. [Project overview](#1-project-overview)
2. [Technology and request flow](#2-technology-and-request-flow)
3. [Pages and folders](#3-pages-and-folders)
4. [Database design](#4-database-design)
5. [Run locally with SQLite](#5-run-locally-with-sqlite)
6. [Security measures and limitations](#6-security-measures-and-limitations)
7. [Testing strategy and how to run tests](#7-testing-strategy-and-how-to-run-tests)
8. [Vercel and Neon deployment](#8-vercel-and-neon-deployment)
9. [Troubleshooting](#9-troubleshooting)
10. [Project references](#10-project-references)

## 1. Project overview

The application is an educational COVID-19 information and awareness portal. Alongside information pages, it demonstrates common dynamic website functions: account registration and authentication, form validation, user-specific dashboards, community comments, contact submissions, database persistence, and administrator moderation.

The testing materials are a major part of the project. They include a test plan, test cases using multiple testing approaches, automated PHP checks, a scripted HTTP test, an in-app test-results summary, and execution/defect records.

### Main features

- COVID-19 information, symptoms, prevention, vaccination, and safety guidance.
- Registration and login with client- and server-side validation.
- Password hashing, sessions, and protected user/admin pages.
- Authenticated comments and a contact form that can also accept guest submissions.
- Admin views for account, comment, and contact-submission management.
- Live counts of portal records and clearly labelled illustrative health figures.
- An in-app Testing page that summarizes recorded test evidence and links to reports.

## 2. Technology and request flow

### Technology

| Layer | Technologies |
|---|---|
| Browser interface | HTML, CSS, vanilla JavaScript |
| Server | PHP and PHP sessions |
| Database access | PDO |
| Local demo database | SQLite through PDO SQLite, when using PHP's built-in development server |
| Deployed database | PostgreSQL, provisioned with Neon |
| Hosting | Vercel PHP runtime |

### Typical form request

1. A PHP page renders the form using the shared page header and helper functions.
2. JavaScript can provide quick validation feedback in the browser.
3. On submit, a separate PHP action checks the HTTP method and CSRF token, then performs server-side validation. The server checks remain authoritative because browser validation can be bypassed.
4. Valid database operations use PDO prepared statements.
5. The application stores the result and returns a redirect/flash message or an updated page. Rendered user content is escaped before it is included in HTML.

### Shared components

- `includes/header.php` — document start, main navigation, shared scripts/styles, flash messages, and main-content start.
- `includes/footer.php` — shared footer and document end.
- `includes/functions.php` — database access bootstrap, URL helpers, HTML escaping, CSRF helpers, flash messages, and common form utilities.
- `includes/auth.php` — user/admin authentication state and access guards.
- `includes/validation.php` — server-side validation functions and regular expressions.
- `config/database.php` — PostgreSQL connection setup and the local SQLite fallback/schema initializer.
- `assets/js/script.js` — client-side validation and interactive behaviors such as navigation, password-strength feedback, character counters, and dismissible alerts.
- `assets/css/` — page and shared styles.
- `assets/images/` — illustrations used by the site.

## 3. Pages and folders

### Public pages

| Page | What it contains |
|---|---|
| `index.php` | Homepage, introductory content, major information links, and visual illustrations. |
| `about.php` | General COVID-19 information, spread, and awareness guidance. |
| `symptoms.php` | Common symptoms and warning signs for seeking urgent medical help. |
| `prevention.php` | Everyday prevention guidance and related illustrations. |
| `vaccination.php` | General vaccination information and expandable FAQ content. |
| `statistics.php` | Live database counts for portal activity (users, comments, and contact messages), plus separate sample public-health figures. The sample figures are not live data or medical guidance. |
| `testing.php` | Teacher/presenter-friendly test summary, recorded automated results, pending manual status, and links to detailed evidence. |
| `comments.php` | Publicly visible comments and, for signed-in users, the comment form. |
| `contact.php` | Contact/message submission form. |
| `register.php` | New user registration form. |
| `login.php` | User login form. |
| `dashboard.php` | Protected, signed-in user's account details and their own comments/contact history. |
| `logout.php` | Logs the user out and redirects to the login page. |

### Administrator pages

- `admin/login.php` — administrator sign-in.
- `admin/dashboard.php` — summary counts for records managed by the portal.
- `admin/users.php` — account list/management.
- `admin/comments.php` — comment moderation, including hide/show/delete actions.
- `admin/registrations.php` — contact submission list.
- `admin/_nav.php` — shared admin navigation.

Admin routes require an authenticated administrator. The SQL schema does not create a ready-to-use admin account; arrange/test the admin role using a controlled database setup rather than exposing privileged credentials.

### Form handlers and API

- `actions/register_action.php` — validates and processes registration.
- `actions/login_action.php` — checks credentials and creates an authenticated session.
- `actions/comment_action.php` — validates and saves a comment.
- `actions/contact_action.php` — validates and saves a contact submission.
- `api/health.php` — reports whether a database connection can be made. The successful JSON response is `{"status":"ok","database":"connected"}`; an unavailable database returns HTTP 503.
- `api/index.php` — Vercel dispatcher. It routes requests to an explicit allowlist of public PHP scripts; it is not a general-purpose file server.

## 4. Database design

The production PostgreSQL schema is in `database/covid_portal.sql`. It creates tables in the database to which it is connected; it does not create or drop the database itself.

| Table | Purpose and relationships |
|---|---|
| `users` | User name, email, phone, password hash, role, and creation timestamp. A case-insensitive unique email index prevents duplicate accounts with different email casing. Roles are constrained to `user` or `admin`. |
| `comments` | Comment text, visibility state, author ID, and creation timestamp. The author is a foreign key to `users`; deleting a user cascades to their comments. |
| `registrations` | Contact form submissions, including name, email, phone, message, and optional user ID. Guest submissions use a `NULL` user ID; deleting a user sets the related ID to `NULL`. |
| `sessions` | Session data and last activity timestamp for durable PHP sessions on Vercel's serverless functions. |

### Local SQLite schema

For a local demo, the application creates `database/covid_portal.sqlite` and its tables on the first database-backed request. `config/database.php` creates equivalent SQLite tables and indexes in code and turns on SQLite foreign-key enforcement for that connection. The SQLite schema is not imported from the PostgreSQL dump; data in SQLite is separate from the deployed Neon database.

## 5. Run locally with SQLite

### Requirements

- PHP **8.1 or newer** (the source uses PHP syntax introduced in PHP 8.1).
- PHP PDO and the `pdo_sqlite` extension enabled.
- A browser.
- No Composer or npm install is required by the current application.

To check the required SQLite driver, run `php -m` and confirm that `PDO` and `pdo_sqlite` appear. The `PDO_PGSQL` driver is not necessary for SQLite-only local demos.

### Steps

1. Open a terminal in the project directory (`covid-portal-main`).
2. Start PHP's built-in server:

   ```sh
   php -S localhost:8000
   ```

3. Visit `http://localhost:8000/` in a browser.
4. Open **Register** to create a test account, then log in. The first database-backed request initializes the SQLite file and schema automatically.
5. Test comments, the contact form, dashboard, statistics, and the Testing page.

The local database file is created at `database/covid_portal.sqlite`. It is ignored by Git and should not be committed. Remove that file only when you intentionally want to reset local demo data; it will be recreated on the next database-backed request.

### Important limits of SQLite fallback

SQLite fallback is intentionally enabled only when all of the following are true:

- The request is served by PHP's built-in server (`PHP_SAPI === 'cli-server'`).
- No usable PostgreSQL connection settings are configured.
- PHP has `pdo_sqlite` loaded.

It is a local demo convenience, not a production fallback. Vercel must have PostgreSQL settings. PHP's built-in server is for development and should not be used as a public production server.

## 6. Security measures and limitations

### Implemented protections

- Passwords are stored as password hashes using `password_hash()` and verified with `password_verify()`; plaintext passwords are not stored.
- PDO prepared statements are used for database queries.
- Validation runs on both the browser and server; server-side validation still runs if client JavaScript is bypassed.
- Form posts use CSRF tokens checked by the application.
- Login regenerates the session ID. Session cookies are configured `HttpOnly` and `SameSite=Lax`, with `Secure` when HTTPS is detected.
- Dashboard and admin routes have authentication/role checks.
- User-provided values are HTML-escaped before rendering to mitigate XSS.
- Unknown-email and wrong-password login attempts use a generic error.
- PHP errors are logged instead of displaying raw stack/error details to site visitors.
- PostgreSQL foreign keys enforce ownership and deletion behavior.

### Known limitations

The security test documentation notes missing login throttling/rate limiting, email verification, and password reset. Code-level safeguards do not replace running the security test procedures and recording their results. `.htaccess` behavior is web-server-specific and is not exercised by PHP's built-in server. Review `tests/security-testing.md` and record actual observations rather than claiming unperformed security cases passed.

## 7. Testing strategy and how to run tests

### Documented test inventory

The current summary lists **171 documented cases**:

| Type | Count | Focus |
|---|---:|---|
| Functional | 56 | End-user/admin behavior, forms, navigation, sessions, and page behavior. |
| Regex | 39 | Valid, invalid, boundary, empty, whitespace, and special-character inputs. |
| Black-box | 31 | Inputs/outputs tested from the interface without relying on implementation details; includes equivalence partitions and boundary values. |
| Integration | 9 | Interactions between browser forms, PHP handlers, sessions, and database. |
| Database | 16 | Schema, constraints, relationships, persistence, and delete behavior. |
| Security | 20 | Authentication/access control, injection, XSS, CSRF, and session-related procedures. |

These are documented test cases, **not** a count of passed tests. The manual execution report currently says the manual test execution is pending. Fill in test date, tester, environment, actual result, and status only after performing each test.

### Test types and execution

| Type | Where/how to use it | Current recorded evidence/status |
|---|---|---|
| PHP unit and regex checks | Run `php tests/unit/run_unit_tests.php`. This exercises the PHP regex case set and validation/helper functions; it does not need a database. | Historical builder run: 39 regex cases + 12 function checks = 51 passed, 0 failed. Run it again locally for fresh evidence. |
| JavaScript regex checks | Open `tests/regex-tester.html` via the local site, e.g. `http://localhost:8000/tests/regex-tester.html`. Compare its JavaScript outcomes to the PHP rules and try sample inputs. | Historical comparison: 39 cases, 0 mismatches against PHP. |
| Manual functional tests | Follow `tests/functional-test-cases.md` in the browser. Record outcomes in `tests/test-execution-report.md`. | The manual functional cases are marked not executed until you complete and record them. |
| Black-box tests | Use `tests/black-box-testing.md`; partition inputs into valid/invalid classes and exercise boundary values through the UI. | Documented scenarios; manual run/results pending. |
| White-box tests | Use `tests/white-box-testing.md` to reason about code paths/branches and select inputs to exercise them. | Coverage is not measured; do not report a coverage percentage. |
| Integration tests | Follow `tests/integration-testing.md` to check form → PHP → database → response flows. | Some database-backed flows have historical verification; the planned manual matrix remains to be filled accurately. |
| Database tests | Follow `tests/database-testing.md` against a disposable database; inspect constraints and persistence. | Manual execution status remains pending unless a result is specifically recorded. |
| Security tests | Follow `tests/security-testing.md` and use test accounts/payloads in a controlled environment. | Historical automated checks cover selected security behaviors; the security-case matrix is not thereby all passed. Record actual cases individually. |
| Scripted HTTP end-to-end | The Bash script is `tests/e2e/run_e2e.sh`. It requires Bash, `curl`, and a configured test deployment/database; read its header and supply the documented test/admin configuration before running. | Historical builder run: 56 of 56 scripted checks passed. This is separate from all 56 manual functional cases. |

**Database safety:** the HTTP E2E script creates/modifies records. Point it only at a disposable test database or deployment, never a valuable production database. Follow the script's own header and clean up test data afterward.

### Recorded automated results versus pending work

The execution report records a builder pre-check of 51/51 PHP unit checks, 39 JavaScript regex comparisons with no mismatches, and 56/56 scripted HTTP E2E checks. It also records PostgreSQL and production verification in its dated sections. Those are historical environment-specific results, not proof that every documented case has been run on a new machine or deployment.

The Testing page at `/testing.php` is a presentation summary, not a live test runner. It deliberately labels documented scope, historical recorded automation, and pending manual execution separately. Use `tests/test-execution-report.md` as the detailed record, `docs/test-summary.md` for counts, and `docs/bug-reports.md` for defect history.

## 8. Vercel and Neon deployment

### Current deployment references

- Public GitHub repository: <https://github.com/PrachiB2108/covid-19-stqa>
- Production application: <https://covid-19-stqa.vercel.app/>
- Testing summary: <https://covid-19-stqa.vercel.app/testing.php>
- Database health endpoint: <https://covid-19-stqa.vercel.app/api/health>

The deployed app was connected to a Neon PostgreSQL resource through Vercel. Environment variables are configured in Vercel/Neon; database URLs and passwords are secrets and must never be added to this document, source code, screenshots, or Git history.

### How requests are routed

`vercel.json` configures the community PHP runtime `vercel-php@0.9.0` for PHP functions under `api/`. Vercel serves `/assets/...` directly, maps `/api/health` to `api/health.php`, and sends other application paths through `api/index.php`. That dispatcher only permits scripts explicitly listed in its allowlist; when adding a new public PHP page, verify that it is present in the allowlist. The Testing page was added to that allowlist so it works in production.

Vercel function filesystems are ephemeral/read-only for durable application state. When `VERCEL` is present, `includes/functions.php` registers a PostgreSQL-backed PHP session handler. The `sessions` table must exist for persistent authenticated sessions across function invocations.

### Reproduce or update deployment

1. Push the project to a GitHub repository and import/link that repository in Vercel. The current Vercel project is connected to the GitHub repository, so pushes to the production branch trigger deployments.
2. Provision PostgreSQL (the current deployment uses Neon) and connect it to the Vercel project.
3. Set the database connection variables in Vercel Project Settings → Environment Variables for the environments you use. The app accepts `DATABASE_URL` or `POSTGRES_URL`, or the individual values `DB_HOST`, `DB_PORT`, `DB_NAME`, `DB_USER`, `DB_PASS`, and optional `DB_SSLMODE`. Do not paste credentials into chat or commit them. When using a hosted provider, configure its required TLS mode; a URL connection defaults to `require` if no `sslmode` is present.
4. Import `database/covid_portal.sql` into the target Neon database once. Use Neon’s SQL editor or a PostgreSQL client. The script creates the application tables and indexes; it does not create the Neon project/database and is not automatically run by the PHP app.
5. Deploy through the connected Git integration (or use the deployment controls in Vercel). Check that the deployment status is Ready and inspect build/runtime logs if it is not.
6. Verify `https://<deployment-domain>/api/health` returns HTTP 200 and `{"status":"ok","database":"connected"}`.
7. Smoke-test pages, CSS/images, registration/login/dashboard, comments, contact, logout, and the Testing page using disposable test data. Clean up test records when appropriate.

### Database connection details

- `DATABASE_URL` and `POSTGRES_URL` can contain the PostgreSQL URL. The URL scheme must be `postgres` or `postgresql`.
- Alternatively set `DB_HOST`, `DB_PORT` (defaults to `5432`), `DB_NAME`, `DB_USER`, `DB_PASS`, and `DB_SSLMODE` (defaults to `prefer`).
- For URL-based connections, the app defaults TLS `sslmode` to `require` unless the URL includes an explicit supported mode.
- Neon-specific code in `config/database.php` can pass the endpoint ID through PostgreSQL startup options for runtime/libpq compatibility.
- A successful Vercel build does not prove database connectivity. The health endpoint and a real database-backed user flow are required checks.

### Deployment records

`docs/VERCEL_POSTGRES_DEPLOYMENT.md`, `docs/VERCEL_POSTGRES_DEPLOYMENT_CHECKLIST.md`, and the deployment sections in `tests/test-execution-report.md` provide the detailed historical setup and verification record. Always check the current project and deployment URL in Vercel, because old documentation may refer to earlier deployments.

## 9. Troubleshooting

| Symptom | What to check |
|---|---|
| Local database-backed page reports an error | Confirm PHP is running via `php -S localhost:8000`, `pdo_sqlite` is enabled, and the request is using that development server. Check whether PostgreSQL variables are set unexpectedly and inspect `php-error.log` locally. |
| `could not find driver` locally | Enable/install the PHP PDO SQLite extension for the same PHP executable running the server. Restart the server afterward. |
| Vercel `/api/health` returns 503 | Confirm the Vercel environment variables are configured for Production, Neon is active/reachable, the URL/credentials/TLS mode are correct, and the schema is imported. Review Vercel runtime logs. Never expose secret values while troubleshooting. |
| Vercel page returns 404 but local PHP page works | Check `api/index.php`'s `$publicScripts` allowlist and `vercel.json` routes. New public PHP files must be added to the dispatcher allowlist, committed, and deployed. |
| Login works locally but not between deployed requests | Confirm the production `sessions` table exists and Vercel uses PostgreSQL session storage; Vercel function local files are not durable. |
| Test summary numbers appear to conflict | Separate documented counts, historical automated runs, and manual execution. Check `docs/test-summary.md` and `tests/test-execution-report.md`; do not mark pending tests as passed. |

## 10. Project references

- `README.md` — brief overview, local start, and test commands.
- `testing.php` — in-app presentation of the test inventory and recorded outcomes.
- `docs/test-plan.md` — scope, approach, and criteria.
- `tests/functional-test-cases.md`, `tests/regex-test-cases.md`, `tests/black-box-testing.md`, `tests/white-box-testing.md`, `tests/integration-testing.md`, `tests/database-testing.md`, `tests/security-testing.md`, and `tests/unit-testing.md` — testing design and case documents.
- `tests/test-execution-report.md` — detailed dated execution evidence and pending manual results.
- `docs/test-summary.md` — documented case totals and current manual status.
- `docs/bug-reports.md` and `docs/bug-taxonomy.md` — defect record and categories.
- `docs/acceptance-report.md` — acceptance checklist; update only after executing acceptance tests.
- `docs/demo-script.md`, `docs/screenshot-guide.md`, and `docs/viva-questions.md` — presentation and assessment preparation.
- `docs/VERCEL_POSTGRES_DEPLOYMENT.md` and `docs/VERCEL_POSTGRES_DEPLOYMENT_CHECKLIST.md` — hosting/database setup references.

> **Note:** Some older documentation may mention older local stacks or previous deployments. For the current local demo, follow the SQLite fallback described in `config/database.php`; for production, use Vercel + PostgreSQL/Neon and verify the live health endpoint.
