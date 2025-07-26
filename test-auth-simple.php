<?php
// Create this as minimal_test.php in your root directory
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<h1>Minimal Authentication Test</h1>";
echo "<p>Testing basic session and authentication without redirects...</p>";

// Start session manually to see what happens
echo "<h2>1. Starting Session</h2>";
session_start();
echo "Session ID: " . session_id() . "<br>";
echo "Session Status: " . (session_status() === PHP_SESSION_ACTIVE ? 'Active' : 'Inactive') . "<br>";

// Load bootstrap and auth
echo "<h2>2. Loading Bootstrap and Auth</h2>";
require_once 'bootstrap.php';
require_once 'utils/auth.util.php';
echo "Bootstrap and Auth loaded successfully<br>";

// Test authentication status
echo "<h2>3. Testing Authentication</h2>";
echo "Is Authenticated: " . (isAuthenticated() ? 'YES' : 'NO') . "<br>";

$user = getAuthenticatedUser();
echo "User Data: " . ($user ? json_encode($user) : 'NULL') . "<br>";

// Show current session
echo "<h2>4. Current Session Data</h2>";
echo "<pre>";
print_r($_SESSION);
echo "</pre>";

// Test bypass
if (isset($_POST['test_bypass'])) {
    echo "<h2>5. Testing Bypass</h2>";
    if (setBypassAuth('admin')) {
        echo "✅ Bypass successful!<br>";
        echo "New auth status: " . (isAuthenticated() ? 'YES' : 'NO') . "<br>";
        echo "New user data: " . json_encode(getAuthenticatedUser()) . "<br>";
        echo "Session after bypass:<br>";
        echo "<pre>";
        print_r($_SESSION);
        echo "</pre>";
    } else {
        echo "❌ Bypass failed!<br>";
    }
}

// Test regular auth
if (isset($_POST['test_auth'])) {
    echo "<h2>5. Testing Regular Auth</h2>";
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';
    
    if (authenticate($username, $password)) {
        echo "✅ Authentication successful!<br>";
        echo "New auth status: " . (isAuthenticated() ? 'YES' : 'NO') . "<br>";
        echo "New user data: " . json_encode(getAuthenticatedUser()) . "<br>";
        echo "Session after auth:<br>";
        echo "<pre>";
        print_r($_SESSION);
        echo "</pre>";
    } else {
        echo "❌ Authentication failed!<br>";
    }
}

// Test logout
if (isset($_POST['test_logout'])) {
    echo "<h2>5. Testing Logout</h2>";
    logout();
    echo "✅ Logout completed<br>";
    echo "Auth status after logout: " . (isAuthenticated() ? 'YES' : 'NO') . "<br>";
}
?>

<style>
    body { font-family: Arial, sans-serif; margin: 20px; }
    h1, h2 { color: #333; }
    pre { background: #f5f5f5; padding: 10px; border: 1px solid #ddd; }
    form { margin: 10px 0; padding: 10px; border: 1px solid #ccc; }
    button { padding: 8px 16px; margin: 5px; }
</style>

<form method="post">
    <h3>Test Bypass Authentication</h3>
    <button type="submit" name="test_bypass">Test Bypass</button>
</form>

<form method="post">
    <h3>Test Regular Authentication</h3>
    <input type="text" name="username" placeholder="Username" value="admin">
    <input type="password" name="password" placeholder="Password" value="password">
    <button type="submit" name="test_auth">Test Auth</button>
</form>

<form method="post">
    <h3>Test Logout</h3>
    <button type="submit" name="test_logout">Test Logout</button>
</form>

<hr>
<h2>Links to Test Navigation</h2>
<a href="index.php">Go to Login Page</a> | 
<a href="pages/home/">Go to Home Page</a> | 
<a href="minimal_test.php">Refresh This Page</a>

<hr>
<h2>Check Error Log</h2>
<p>Check your PHP error log for detailed authentication flow messages.</p>