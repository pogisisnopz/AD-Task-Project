<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "TEST PAGE WORKS!<br>";
echo "PHP is working<br>";
echo "Current file: " . __FILE__ . "<br>";
echo "Current directory: " . __DIR__ . "<br>";

try {
    require_once 'bootstrap.php';
    echo "Bootstrap loaded successfully<br>";
    
    require_once 'utils/auth.util.php';
    echo "Auth utils loaded successfully<br>";
    
    $loggedIn = isAuthenticated();
    echo "Authentication check: " . ($loggedIn ? "TRUE" : "FALSE") . "<br>";
    
    if (!$loggedIn) {
        echo "Not logged in, should redirect to login.php<br>";
    } else {
        $user = getAuthenticatedUser();
        echo "User data: " . print_r($user, true) . "<br>";
    }
    
} catch (Exception $e) {
    echo "ERROR: " . $e->getMessage() . "<br>";
    echo "Stack trace: " . $e->getTraceAsString() . "<br>";
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Debug Test</title>
</head>
<body>
    <h1>Debug Test Page</h1>
    <p>If you see this, the basic PHP is working.</p>
</body>
</html>
