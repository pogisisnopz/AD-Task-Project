<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<h1>Session Debug</h1>";
echo "<p>PHP is working!</p>";
echo "<p>Current file: " . __FILE__ . "</p>";
echo "<p>Current time: " . date('Y-m-d H:i:s') . "</p>";
echo "<p>Session ID: " . session_id() . "</p>";
echo "<p>Session Status: " . session_status() . "</p>";
echo "<h3>Session Data:</h3>";
echo "<pre>" . print_r($_SESSION, true) . "</pre>";

// Test authentication
require_once 'utils/auth.util.php';
echo "<h3>Authentication Test:</h3>";
$isAuth = isAuthenticated();
echo "<p>Is Authenticated: " . ($isAuth ? 'YES' : 'NO') . "</p>";
if ($isAuth) {
    $user = getAuthenticatedUser();
    echo "<p>User Data: <pre>" . print_r($user, true) . "</pre></p>";
}

echo "<p><a href='login.php'>Go to Login</a></p>";
echo "<p><a href='index.php'>Go to Homepage</a></p>";
?>
