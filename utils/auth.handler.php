<?php
declare(strict_types=1);


// Load environment
require_once __DIR__ . '/../bootstrap.php';
$typeConfig = require_once UTILS_PATH . '/envSetter.util.php';

// Connect to DB
$dsn = "pgsql:host={$typeConfig['pgHost']};port={$typeConfig['pgPort']};dbname={$typeConfig['pgDb']}";
$pdo = new PDO($dsn, $typeConfig['pgUser'], $typeConfig['pgPass'], [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
]);

// Get credentials from POST
$username = $_POST['username'] ?? '';
$password = $_POST['password'] ?? '';

// Query user by username
$stmt = $pdo->prepare("SELECT * FROM users WHERE username = :username");
$stmt->execute([':username' => $username]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

// Check password
if ($user && password_verify($password, $user['password'])) {
    // Auth success: save to session
    $_SESSION['user'] = $user;
    header('Location: /index.php');
    exit;
} else {
    // Auth failed: redirect back with error
    header('Location: /index.php?error=1');
    exit;
}