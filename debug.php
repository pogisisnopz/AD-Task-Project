<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<h1>Debug Test</h1>";
echo "<p>PHP is working!</p>";
echo "<p>Current file: " . __FILE__ . "</p>";
echo "<p>Current time: " . date('Y-m-d H:i:s') . "</p>";

try {
    echo "<p>Testing bootstrap...</p>";
    require_once 'bootstrap.php';
    echo "<p>✅ Bootstrap loaded successfully</p>";
    
    echo "<p>Testing auth utils...</p>";
    require_once 'utils/auth.util.php';
    echo "<p>✅ Auth utils loaded successfully</p>";
    
    echo "<p>Testing authentication...</p>";
    $loggedIn = isAuthenticated();
    echo "<p>Authentication status: " . ($loggedIn ? "✅ LOGGED IN" : "❌ NOT LOGGED IN") . "</p>";
    
    if ($loggedIn) {
        $user = getAuthenticatedUser();
        echo "<p>User data: <pre>" . print_r($user, true) . "</pre></p>";
    } else {
        echo "<p>Should redirect to index.php (login page)</p>";
    }
    
} catch (Exception $e) {
    echo "<p>❌ ERROR: " . htmlspecialchars($e->getMessage()) . "</p>";
    echo "<p>Stack trace: <pre>" . htmlspecialchars($e->getTraceAsString()) . "</pre></p>";
}

echo "<hr>";
echo "<p><a href='index.php'>Go to Login Page</a></p>";
echo "<p><a href='signup.php'>Go to Signup Page</a></p>";
echo "<p><a href='pages/home/'>Go to Homepage</a></p>";
?>
