<?php
/**
 * PostgreSQL connection settings. Provide credentials through environment
 * variables; never commit them to this file or the repository.
 */
// Local development may override these in the shell. Vercel values belong in
// Project Settings > Environment Variables and must never be committed here.
define('DB_HOST', getenv('DB_HOST') ?: '');
define('DB_NAME', getenv('DB_NAME') ?: '');
define('DB_USER', getenv('DB_USER') ?: '');
define('DB_PASS', getenv('DB_PASS') ?: '');
define('DB_PORT', getenv('DB_PORT') ?: '5432');
define('DB_SSLMODE', getenv('DB_SSLMODE') ?: 'prefer');
define('DB_URL', getenv('DATABASE_URL') ?: (getenv('POSTGRES_URL') ?: ''));

// Usually leave null: the app detects whether it is at the domain root or in a subfolder.
define('BASE_URL_OVERRIDE', null);

/**
 * Returns a shared PDO connection (prepared statements, exceptions on error).
 */
function db(): PDO
{
    static $pdo = null;
    if ($pdo === null) {
        if (DB_URL !== '') {
            $url = parse_url(DB_URL);
            if (!$url || !in_array(strtolower((string)($url['scheme'] ?? '')), ['postgres', 'postgresql'], true)) {
                throw new PDOException('The PostgreSQL database URL is invalid.');
            }
            $query = [];
            parse_str((string)($url['query'] ?? ''), $query);
            $host = (string)($url['host'] ?? '');
            $port = (string)($url['port'] ?? '5432');
            $name = ltrim((string)($url['path'] ?? ''), '/');
            $user = rawurldecode((string)($url['user'] ?? ''));
            $pass = rawurldecode((string)($url['pass'] ?? ''));
            $sslmode = (string)($query['sslmode'] ?? 'require');
        } else {
            $host = DB_HOST;
            $port = DB_PORT;
            $name = DB_NAME;
            $user = DB_USER;
            $pass = DB_PASS;
            $sslmode = DB_SSLMODE;
        }
        if ($host === '' || $name === '' || $user === '') {
            // Keep the site usable for local demos without requiring PostgreSQL.
            // Deployed environments must continue to provide PostgreSQL settings.
            if (PHP_SAPI === 'cli-server' && extension_loaded('pdo_sqlite')) {
                $pdo = new PDO('sqlite:' . dirname(__DIR__) . '/database/covid_portal.sqlite', null, null, [
                    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    PDO::ATTR_EMULATE_PREPARES   => false,
                ]);
                $pdo->exec('PRAGMA foreign_keys = ON');
                initialize_local_sqlite_schema($pdo);
                return $pdo;
            }
            throw new PDOException('PostgreSQL environment variables are not configured.');
        }
        if (!in_array($sslmode, ['disable', 'allow', 'prefer', 'require', 'verify-ca', 'verify-full'], true)) {
            throw new PDOException('The PostgreSQL SSL mode is invalid.');
        }
        $dsn = 'pgsql:host=' . $host . ';port=' . $port . ';dbname=' . $name . ';sslmode=' . $sslmode;
        $options = $query['options'] ?? '';
        if ($options === '' && preg_match('/\.neon\.tech$/i', $host)) {
            // Some serverless PHP runtimes ship libpq without Neon SNI support.
            // Neon accepts the endpoint ID through PostgreSQL's startup options.
            $endpointId = preg_replace('/-pooler$/i', '', explode('.', $host, 2)[0]);
            if (str_starts_with($endpointId, 'ep-')) {
                $options = 'endpoint=' . $endpointId;
            }
        }
        if ($options !== '') {
            $dsn .= ";options='" . str_replace("'", "''", $options) . "'";
        }
        $options = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ];
        $pdo = new PDO($dsn, $user, $pass, $options);
    }
    return $pdo;
}

/** Create the local demo schema; the production schema remains PostgreSQL. */
function initialize_local_sqlite_schema(PDO $pdo): void
{
        $pdo->exec(<<<'SQL'
CREATE TABLE IF NOT EXISTS users (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    full_name TEXT NOT NULL,
    email TEXT NOT NULL,
    phone TEXT NOT NULL,
    password TEXT NOT NULL,
    role TEXT NOT NULL DEFAULT 'user' CHECK (role IN ('user', 'admin')),
    created_at TEXT NOT NULL DEFAULT CURRENT_TIMESTAMP
);
CREATE UNIQUE INDEX IF NOT EXISTS uq_users_email ON users (LOWER(email));
CREATE TABLE IF NOT EXISTS comments (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    user_id INTEGER NOT NULL REFERENCES users(id) ON DELETE CASCADE,
    comment TEXT NOT NULL,
    status TEXT NOT NULL DEFAULT 'visible' CHECK (status IN ('visible', 'hidden')),
    created_at TEXT NOT NULL DEFAULT CURRENT_TIMESTAMP
);
CREATE INDEX IF NOT EXISTS idx_comments_user ON comments (user_id);
CREATE TABLE IF NOT EXISTS registrations (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    user_id INTEGER NULL REFERENCES users(id) ON DELETE SET NULL,
    name TEXT NOT NULL,
    email TEXT NOT NULL,
    phone TEXT NOT NULL,
    message TEXT NOT NULL,
    created_at TEXT NOT NULL DEFAULT CURRENT_TIMESTAMP
);
CREATE INDEX IF NOT EXISTS idx_reg_user ON registrations (user_id);
CREATE TABLE IF NOT EXISTS sessions (
    session_id TEXT PRIMARY KEY,
    session_data TEXT NOT NULL,
    last_activity INTEGER NOT NULL
);
CREATE INDEX IF NOT EXISTS idx_sessions_activity ON sessions (last_activity);
SQL);
}
