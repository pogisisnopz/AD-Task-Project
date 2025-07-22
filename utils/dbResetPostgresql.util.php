<?php
declare(strict_types=1);

// 1) Composer autoload
require_once 'vendor/autoload.php';

// 2) Bootstrap for BASE_PATH, etc.
require_once 'bootstrap.php';

// 3) Env setter
$typeConfig = require_once UTILS_PATH . '/envSetter.util.php';

// PostgreSQL config
$host = $typeConfig['pgHost'];
$port = $typeConfig['pgPort'];
$username = $typeConfig['pgUser'];
$password = $typeConfig['pgPass'];
$dbname = $typeConfig['pgDb'];

// Connect to PostgreSQL
$dsn = "pgsql:host=$host;port=$port;dbname=$dbname";
$pdo = new PDO($dsn, $username, $password, [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
]);

// List of model files
$models = [
    'users.model.sql',
    'projects.model.sql',
    'project_users.model.sql',
    'tasks.model.sql',
];

foreach ($models as $filename) {
    $path = DATABASE_PATH . '/' . $filename;
    echo "Applying schema from {$path}…\n";

    $sql = file_get_contents($path);
    if ($sql === false) {
        throw new RuntimeException("❌ Could not read {$path}");
    } else {
        echo "✅ Creation Success from {$path}\n";
    }

    $pdo->exec($sql);
}

// Truncate tables
echo "Truncating tables…\n";
foreach (['project_users', 'tasks', 'projects', 'users'] as $table) {
    $pdo->exec("TRUNCATE TABLE {$table} RESTART IDENTITY CASCADE;");
}

echo "✅ PostgreSQL reset complete!\n";
