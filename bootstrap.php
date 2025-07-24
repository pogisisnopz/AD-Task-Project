<?php
require_once __DIR__ . '/vendor/autoload.php';

// ✅ Set session cookie options BEFORE starting session
session_set_cookie_params([
    'lifetime' => 0,
    'path' => '/',
    'secure' => false,
    'httponly' => true,
    'samesite' => 'Lax',
]);

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

define('BASE_PATH', realpath(__DIR__));
define('UTILS_PATH', realpath(BASE_PATH . '/utils'));
define('DATABASE_PATH', realpath(BASE_PATH . '/database'));
define('HANDLERS_PATH', BASE_PATH . '/handlers');
define('DUMMIES_PATH', BASE_PATH . '/staticDatas/dummies');
chdir(BASE_PATH);

// Load .env
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->safeLoad();

// Database connection
$host = $_ENV['PG_HOST'] ?? getenv('PG_HOST');
$port = $_ENV['PG_PORT'] ?? getenv('PG_PORT');
$dbname = $_ENV['PG_DB'] ?? getenv('PG_DB');
$user = $_ENV['PG_USER'] ?? getenv('PG_USER');
$pass = $_ENV['PG_PASS'] ?? getenv('PG_PASS');
$dsn = "pgsql:host=$host;port=$port;dbname=$dbname";

try {
    $pdo = new PDO($dsn, $user, $pass, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ]);
} catch (PDOException $e) {
    die("❌ Database connection failed: " . $e->getMessage());
}
