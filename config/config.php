<?php
define('DB_HOST', 'localhost');
define('DB_NAME', 'secure_login_mvc');
define('DB_USER', 'root');
define('DB_PASS', '');
define('BASE_URL', 'http://localhost/formulaire_php_mvc/');
define('APP_NAME', 'Formulaire d’identification sécurisé');
define('SESSION_TIMEOUT', 1800);
define('ENVIRONMENT', 'development');



if (ENVIRONMENT === 'development') {
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
} else {
    error_reporting(E_ALL);
    ini_set('display_errors', 0);
    ini_set('log_errors', 1);
    ini_set('error_log', __DIR__ . '/../logs/php_errors.log');
}

ini_set('session.cookie_httponly', 1);
ini_set('session.cookie_secure', 0);
ini_set('session.use_only_cookies', 1);
ini_set('session.cookie_samesite', 'Strict');
ini_set('session.use_strict_mode', 1);
ini_set('session.gc_maxlifetime', SESSION_TIMEOUT);

header("X-Content-Type-Options: nosniff");
header("X-Frame-Options: DENY");
header("X-XSS-Protection: 1; mode=block");
header("Referrer-Policy: strict-origin-when-cross-origin");

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity'] > SESSION_TIMEOUT)) {
    session_unset();
    session_destroy();
    session_start();
}
$_SESSION['last_activity'] = time();

spl_autoload_register(function($class) {
    $rootDir = dirname(__DIR__);
    $paths = [
        $rootDir . '/core/' . $class . '.php',
        $rootDir . '/app/models/' . $class . '.php',
        $rootDir . '/app/controllers/' . $class . '.php'
    ];
    foreach ($paths as $file) {
        if (file_exists($file)) {
            require_once $file;
            return;
        }
    }
});
