<?php

declare(strict_types=1);

/**
 * Merge a phpMyAdmin SQL dump into the current Laravel MySQL database
 * without dropping existing data.
 *
 * Usage:
 *   php scripts/merge_dump.php database/imports/user_dump.sql
 */

function fail(string $message, int $code = 1): void
{
    fwrite(STDERR, $message . PHP_EOL);
    exit($code);
}

function loadEnvFile(string $path): array
{
    if (!is_file($path)) {
        fail(".env file not found at: {$path}");
    }

    $env = [];
    $lines = file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    if ($lines === false) {
        fail('Unable to read .env file.');
    }

    foreach ($lines as $line) {
        $trimmed = trim($line);
        if ($trimmed === '' || str_starts_with($trimmed, '#')) {
            continue;
        }

        $pos = strpos($trimmed, '=');
        if ($pos === false) {
            continue;
        }

        $key = trim(substr($trimmed, 0, $pos));
        $value = trim(substr($trimmed, $pos + 1));

        if ($value !== '' && (
            (str_starts_with($value, '"') && str_ends_with($value, '"')) ||
            (str_starts_with($value, "'") && str_ends_with($value, "'"))
        )) {
            $value = substr($value, 1, -1);
        }

        $env[$key] = $value;
    }

    return $env;
}

function pdoBase(array $env): PDO
{
    $host = $env['DB_HOST'] ?? '127.0.0.1';
    $port = $env['DB_PORT'] ?? '3306';
    $user = $env['DB_USERNAME'] ?? 'root';
    $pass = $env['DB_PASSWORD'] ?? '';

    $dsn = "mysql:host={$host};port={$port};charset=utf8mb4";

    return new PDO($dsn, $user, $pass, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::MYSQL_ATTR_MULTI_STATEMENTS => true,
    ]);
}

function executeSqlFile(PDO $pdo, string $path): void
{
    $sql = file_get_contents($path);
    if ($sql === false) {
        fail("Unable to read dump file: {$path}");
    }

    $len = strlen($sql);
    $buffer = '';
    $inSingle = false;
    $inDouble = false;
    $inBacktick = false;
    $escaped = false;

    for ($i = 0; $i < $len; $i++) {
        $ch = $sql[$i];
        $next = $i + 1 < $len ? $sql[$i + 1] : '';

        if (! $inSingle && ! $inDouble && ! $inBacktick) {
            if ($ch === '-' && $next === '-') {
                while ($i < $len && $sql[$i] !== "\n") {
                    $i++;
                }
                continue;
            }

            if ($ch === '/' && $next === '*') {
                $i += 2;
                while ($i < $len - 1 && !($sql[$i] === '*' && $sql[$i + 1] === '/')) {
                    $i++;
                }
                $i++;
                continue;
            }
        }

        if ($ch === '\\' && ($inSingle || $inDouble)) {
            $buffer .= $ch;
            $escaped = ! $escaped;
            continue;
        }

        if ($ch === "'" && ! $inDouble && ! $inBacktick && ! $escaped) {
            $inSingle = ! $inSingle;
        } elseif ($ch === '"' && ! $inSingle && ! $inBacktick && ! $escaped) {
            $inDouble = ! $inDouble;
        } elseif ($ch === '`' && ! $inSingle && ! $inDouble) {
            $inBacktick = ! $inBacktick;
        }

        $escaped = false;
        $buffer .= $ch;

        if ($ch === ';' && ! $inSingle && ! $inDouble && ! $inBacktick) {
            $statement = trim($buffer);
            $buffer = '';

            if ($statement === '' || str_starts_with($statement, 'START TRANSACTION') || str_starts_with($statement, 'COMMIT')) {
                continue;
            }

            $pdo->exec($statement);
        }
    }

    $tail = trim($buffer);
    if ($tail !== '') {
        $pdo->exec($tail);
    }
}

function mergeImportedData(PDO $pdo, string $targetDb, string $importDb): void
{
    $pdo->exec('SET FOREIGN_KEY_CHECKS=0');

    $pdo->beginTransaction();
    try {
        $pdo->exec(
            "INSERT INTO {$targetDb}.categories (name, slug, description, icon, created_at, updated_at)
             SELECT c.name, c.slug, c.description, c.icon, c.created_at, c.updated_at
             FROM {$importDb}.categories c
             ON DUPLICATE KEY UPDATE
                 name = VALUES(name),
                 description = VALUES(description),
                 icon = VALUES(icon),
                 updated_at = VALUES(updated_at)"
        );

        $pdo->exec(
            "INSERT INTO {$targetDb}.users (name, email, email_verified_at, password, role, avatar, remember_token, created_at, updated_at)
             SELECT u.name, u.email, u.email_verified_at, u.password, u.role, u.avatar, u.remember_token, u.created_at, u.updated_at
             FROM {$importDb}.users u
             ON DUPLICATE KEY UPDATE
                 name = VALUES(name),
                 email_verified_at = VALUES(email_verified_at),
                 password = VALUES(password),
                 role = VALUES(role),
                 avatar = VALUES(avatar),
                 remember_token = VALUES(remember_token),
                 updated_at = VALUES(updated_at)"
        );

        $pdo->exec(
            "INSERT INTO {$targetDb}.guides (title, slug, content, excerpt, category_id, user_id, status, featured_image, views, created_at, updated_at)
             SELECT g.title, g.slug, g.content, g.excerpt, tc.id, tu.id, g.status, g.featured_image, g.views, g.created_at, g.updated_at
             FROM {$importDb}.guides g
             JOIN {$importDb}.categories ic ON ic.id = g.category_id
             JOIN {$targetDb}.categories tc ON tc.slug = ic.slug
             JOIN {$importDb}.users iu ON iu.id = g.user_id
             JOIN {$targetDb}.users tu ON tu.email = iu.email
             ON DUPLICATE KEY UPDATE
                 title = VALUES(title),
                 content = VALUES(content),
                 excerpt = VALUES(excerpt),
                 category_id = VALUES(category_id),
                 user_id = VALUES(user_id),
                 status = VALUES(status),
                 featured_image = VALUES(featured_image),
                 views = GREATEST({$targetDb}.guides.views, VALUES(views)),
                 updated_at = VALUES(updated_at)"
        );

        $pdo->exec(
            "INSERT INTO {$targetDb}.contact_messages (id, name, email, subject, message, ip_address, user_agent, read_at, created_at, updated_at)
             SELECT id, name, email, subject, message, ip_address, user_agent, read_at, created_at, updated_at
             FROM {$importDb}.contact_messages
             ON DUPLICATE KEY UPDATE
                 name = VALUES(name),
                 email = VALUES(email),
                 subject = VALUES(subject),
                 message = VALUES(message),
                 ip_address = VALUES(ip_address),
                 user_agent = VALUES(user_agent),
                 read_at = VALUES(read_at),
                 updated_at = VALUES(updated_at)"
        );

        $pdo->exec(
            "INSERT INTO {$targetDb}.password_reset_tokens (email, token, created_at)
             SELECT email, token, created_at
             FROM {$importDb}.password_reset_tokens
             ON DUPLICATE KEY UPDATE
                 token = VALUES(token),
                 created_at = VALUES(created_at)"
        );

        $pdo->exec(
            "INSERT INTO {$targetDb}.tags (name, slug, created_at, updated_at)
             SELECT t.name, t.slug, t.created_at, t.updated_at
             FROM {$importDb}.tags t
             ON DUPLICATE KEY UPDATE
                 name = VALUES(name),
                 updated_at = VALUES(updated_at)"
        );

        $pdo->exec(
            "INSERT IGNORE INTO {$targetDb}.guide_tag (guide_id, tag_id)
             SELECT tg.id, tt.id
             FROM {$importDb}.guide_tag igt
             JOIN {$importDb}.guides ig ON ig.id = igt.guide_id
             JOIN {$targetDb}.guides tg ON tg.slug = ig.slug
             JOIN {$importDb}.tags it ON it.id = igt.tag_id
             JOIN {$targetDb}.tags tt ON tt.slug = it.slug"
        );

        $pdo->exec(
            "INSERT INTO {$targetDb}.guide_purchases (user_id, guide_id, amount, paid_at, created_at, updated_at)
             SELECT tu.id, tg.id, p.amount, p.paid_at, p.created_at, p.updated_at
             FROM {$importDb}.guide_purchases p
             JOIN {$importDb}.users iu ON iu.id = p.user_id
             JOIN {$targetDb}.users tu ON tu.email = iu.email
             JOIN {$importDb}.guides ig ON ig.id = p.guide_id
             JOIN {$targetDb}.guides tg ON tg.slug = ig.slug
             ON DUPLICATE KEY UPDATE
                 amount = VALUES(amount),
                 paid_at = VALUES(paid_at),
                 updated_at = VALUES(updated_at)"
        );

        $pdo->commit();
    } catch (Throwable $e) {
        if ($pdo->inTransaction()) {
            $pdo->rollBack();
        }
        throw $e;
    } finally {
        $pdo->exec('SET FOREIGN_KEY_CHECKS=1');
    }
}

$root = dirname(__DIR__);
$env = loadEnvFile($root . DIRECTORY_SEPARATOR . '.env');

if (($env['DB_CONNECTION'] ?? 'mysql') !== 'mysql') {
    fail('This merge script currently supports only MySQL/MariaDB DB_CONNECTION.');
}

$targetDb = $env['DB_DATABASE'] ?? '';
if ($targetDb === '') {
    fail('DB_DATABASE is missing in .env');
}

$dumpPathArg = $argv[1] ?? '';
if ($dumpPathArg === '') {
    fail('Usage: php scripts/merge_dump.php <path-to-sql-dump>');
}

$dumpPath = $dumpPathArg;
if (!preg_match('/^[a-zA-Z]:\\\\|^\\\\|^\//', $dumpPathArg)) {
    $dumpPath = $root . DIRECTORY_SEPARATOR . str_replace(['/', '\\'], DIRECTORY_SEPARATOR, $dumpPathArg);
}

if (!is_file($dumpPath)) {
    fail("Dump file not found: {$dumpPath}");
}

$importDb = $targetDb . '_import_' . date('Ymd_His');

try {
    $pdo = pdoBase($env);

    $pdo->exec("CREATE DATABASE `{$importDb}` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");

    $importPdo = new PDO(
        "mysql:host=" . ($env['DB_HOST'] ?? '127.0.0.1')
        . ";port=" . ($env['DB_PORT'] ?? '3306')
        . ";dbname={$importDb};charset=utf8mb4",
        $env['DB_USERNAME'] ?? 'root',
        $env['DB_PASSWORD'] ?? '',
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::MYSQL_ATTR_MULTI_STATEMENTS => true,
        ]
    );

    executeSqlFile($importPdo, $dumpPath);

    mergeImportedData($pdo, "`{$targetDb}`", "`{$importDb}`");

    $pdo->exec("DROP DATABASE `{$importDb}`");

    fwrite(STDOUT, "Merge complete. Imported dump data has been upserted into {$targetDb}." . PHP_EOL);
    exit(0);
} catch (Throwable $e) {
    try {
        if (isset($pdo)) {
            $pdo->exec("DROP DATABASE IF EXISTS `{$importDb}`");
        }
    } catch (Throwable $dropError) {
        // Ignore cleanup failures.
    }

    fail('Merge failed: ' . $e->getMessage());
}
