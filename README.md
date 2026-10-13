# 🦠 COVID-19 Information & Awareness Portal

A dynamic COVID-19 Information & Awareness Portal with user accounts, community features, and documented software testing.

## 🎯 Problem Statement

To develop a dynamic website for COVID-19 information and awareness using HTML, CSS, JavaScript and PHP, with a relational database to store user account, comment, and registration form details, and to validate the system using Regular Expression test cases.


## ✨ Features

- COVID-19 information and awareness pages
- Symptoms, prevention and vaccination information
- Statistics with clearly labelled demonstration data
- User registration and login
- Secure password hashing and session authentication
- Personalized user dashboard
- Authenticated comments
- Contact/registration form
- Admin dashboard and management
- Comment moderation
- Regular Expression and automated testing
- Responsive and accessibility-focused UI

## 🛠️ Tech Stack

**Frontend:** HTML5, CSS3, Vanilla JavaScript

**Backend:** PHP, PDO, PHP Sessions

**Database:** PostgreSQL / Neon PostgreSQL

**Deployment:** Vercel

**Testing:** PHP regex/unit tests, JavaScript checks, functional, black-box, integration, database, security and end-to-end testing

## 🗂️ Project Structure

```text
covid-portal/
├── admin/
├── api/
├── assets/
│   ├── css/
│   ├── js/
│   └── images/
├── config/
├── database/
├── docs/
├── includes/
├── tests/
├── about.php
├── comments.php
├── contact.php
├── dashboard.php
├── index.php
├── login.php
├── prevention.php
├── register.php
├── statistics.php
├── symptoms.php
└── vaccination.php
```

## 🔐 Security

- Bcrypt password hashing
- PDO prepared statements
- CSRF protection
- Session ID regeneration
- Role-based authorization
- Protected user/admin routes
- Output escaping against XSS
- Generic authentication errors
- Server-side validation
- PostgreSQL foreign-key constraints
- Production credentials stored as environment variables

## 🧪 Testing

The project includes comprehensive software testing documentation.

For the full project walkthrough—including page descriptions, local SQLite setup, testing strategy, and Vercel + Neon deployment—see [Explanation.md](Explanation.md).

For a presentation-friendly overview in the running app, open `testing.php` (select **Testing** in the main navigation). It summarizes recorded automated checks and links to the detailed reports. Manual cases remain pending until they are actually run and recorded.

### Automated results

- **39 regex cases + 12 function checks:** 51/51 passed
- **JavaScript regex comparison:** 0 mismatches
- **End-to-end checks:** 56/56 passed

### PostgreSQL verification

Verified:

- Schema import
- PDO PostgreSQL connection
- `DATABASE_URL` connection
- Registration and duplicate-email validation
- Login → session → dashboard
- Comments and contact history
- Statistics and health endpoint
- Logout and protected dashboard
- Foreign-key and cascade behavior

### Production verification

Verified on Vercel:

- Production build
- Homepage
- PostgreSQL connection
- Statistics
- Register → Login → Dashboard
- Comments
- Contact form
- Logout
- Protected dashboard
- Test-data cleanup

Detailed results are available in `tests/test-execution-report.md`.

## 🚀 Live Demo

**https://covid-19-stqa.vercel.app/**

## ▶️ Local Setup

### 1. Clone

```bash
git clone https://github.com/PrachiB2108/covid-19-stqa.git
cd covid-19-stqa
```

### 2. Configure PostgreSQL (optional for local demos)

When running with PHP's built-in development server and no PostgreSQL environment
variables, the app uses a local SQLite database at `database/covid_portal.sqlite`
for registration, login, comments, and contact forms. Enable PHP's `pdo_sqlite`
extension. This local fallback is not used in production; deployed environments
must use PostgreSQL.

Set environment variables:

```env
DB_HOST=your-host
DB_PORT=5432
DB_NAME=your-database
DB_USER=your-user
DB_PASS=your-password
```

Or use:

```env
DATABASE_URL=your-postgresql-connection-string
```

Never commit real credentials.

### 3. Import the schema

Use:

```text
database/covid_portal.sql
```

### 4. Start locally

```bash
php -S localhost:8000
```

Open `http://localhost:8000`.

## 🧪 Running Tests

```bash
php tests/unit/run_unit_tests.php
```

```bash
bash tests/e2e/run_e2e.sh
```

See `docs/` for the complete manual test documentation.

## 📚 Testing Documentation

Includes:

- Test Plan
- Functional Test Cases
- Black-Box Testing
- Integration Testing
- Database Testing
- Security Testing
- Regex Testing
- Bug Reports
- Test Execution Report
- Acceptance Report
- Test Summary
- Demo Script
- Viva Questions
- Screenshot Guide

## 📊 Test Summary

| Area | Result |
|---|---|
| Regex + function checks | 51/51 passed |
| Automated E2E checks | 56/56 passed |
| PostgreSQL migration | Passed |
| Registration | Passed |
| Login | Passed |
| Session + Dashboard | Passed |
| Comments | Passed |
| Contact form | Passed |
| Logout | Passed |
| Vercel production build | Passed |
| Production DB health | Passed |
| Production authentication flow | Passed |

⭐ Developed as an educational COVID-19 information and awareness portal.

