<?php

// Start output buffering to prevent any output before headers
ob_start();

// Destroy all session data
session_unset();    // Unset all session variables
session_destroy();  // Destroy the session itself

// Optional: Clear session cookie
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// Clean output buffer before redirect
ob_end_clean();

// Redirect to login page (or homepage)
header("Location: index.php");
exit;
