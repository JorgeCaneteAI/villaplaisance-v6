<?php
declare(strict_types=1);

// ── ROOT — défini ici si exécution CLI (seeds) ────────────────────────────────
if (!defined('ROOT')) {
    define('ROOT', __DIR__);
}

// ── Variables d'environnement ─────────────────────────────────────────────────
$envFile = ROOT . '/.env';
if (file_exists($envFile)) {
    foreach (file($envFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) as $line) {
        if (str_starts_with(trim($line), '#')) continue;
        [$key, $value] = array_map('trim', explode('=', $line, 2));
        $_ENV[$key] = $value;
    }
}

// ── Constantes ────────────────────────────────────────────────────────────────
define('APP_ENV',  $_ENV['APP_ENV']  ?? 'production');
define('APP_URL',  $_ENV['APP_URL']  ?? '');

define('SUPPORTED_LANGS', ['fr', 'en', 'es', 'de']);
define('DEFAULT_LANG', 'fr');

// ── Affichage des erreurs ──────────────────────────────────────────────────────
if (APP_ENV === 'development') {
    ini_set('display_errors', '1');
    error_reporting(E_ALL);
} else {
    ini_set('display_errors', '0');
    error_reporting(0);
}

// ── Services core ─────────────────────────────────────────────────────────────
require ROOT . '/app/Services/Database.php';
require ROOT . '/app/Services/LangService.php';
require ROOT . '/app/Services/SeoService.php';
require ROOT . '/app/Services/BlockService.php';

// ── Autoloader PSR-4 minimal ──────────────────────────────────────────────────
require ROOT . '/app/Router.php';

spl_autoload_register(function (string $class): void {
    if (str_starts_with($class, 'Controllers\\')) {
        $file = ROOT . '/app/Controllers/' . str_replace('\\', '/', substr($class, strlen('Controllers\\'))) . '.php';
        if (file_exists($file)) require $file;
    }
});

// ── Session sécurisée ─────────────────────────────────────────────────────────
session_set_cookie_params([
    'lifetime' => 0,
    'path'     => '/',
    'secure'   => true,
    'httponly' => true,
    'samesite' => 'Strict',
]);
session_start();
