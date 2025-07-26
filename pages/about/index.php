<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// ⛔ DO NOT include auth files or redirect anything right now
require_once __DIR__ . '/../../bootstrap.php';
require_once __DIR__ . '/../../layouts/main.layout.php';

// 🧪 Fake logged-in user
$user = [
    'first_name' => 'Test',
    'last_name' => 'User',
    'role' => 'Guest'
];

ob_start();
?>
