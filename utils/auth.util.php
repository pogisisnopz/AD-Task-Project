<?php
declare(strict_types=1);

// Note: session_start() should be called by the main files before including this file

// Check if user is logged in
function isAuthenticated(): bool {
    // Ensure session is started
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    
    // Check both the full user session and simple auth flag
    return isset($_SESSION['user']) || isset($_SESSION['simple_auth']);
}

// Get logged-in user data
function getAuthenticatedUser(): ?array {
    // Try to get from full user session first
    if (isset($_SESSION['user'])) {
        return $_SESSION['user'];
    }
    
    // Fall back to simple auth
    if (isset($_SESSION['simple_auth']) && isset($_SESSION['simple_user'])) {
        $username = $_SESSION['simple_user'];
        return [
            'id' => 1,
            'username' => $username,
            'first_name' => $username === 'admin' ? 'Admin' : 'John',
            'last_name' => $username === 'admin' ? 'User' : 'Smith',
            'email' => $username === 'admin' ? 'admin@mechanicus.com' : 'john.smith@mechanicus.com',
            'role' => $username === 'admin' ? 'Tech-Dominus' : 'Tech-Priest'
        ];
    }
    
    return null;
}

// Require login for protected pages
function requireLogin(): void {
    if (!isAuthenticated()) {
        header('Location: uin.php');
        exit;
    }
}

function logout(): void {
    unset($_SESSION['user']);
    unset($_SESSION['simple_auth']);
    unset($_SESSION['simple_user']);
    session_destroy();
}

function authenticate(string $username, string $password): bool {
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    error_log("🔐 Trying to authenticate user: $username");

    $validCredentials = [
        'admin' => 'password',
        'john.smith' => 'p@ssW0rd1234'
    ];

    if (isset($validCredentials[$username]) && $validCredentials[$username] === $password) {
        $_SESSION['user'] = [
            'id' => 1,
            'username' => $username,
            'first_name' => $username === 'admin' ? 'Admin' : 'John',
            'last_name' => $username === 'admin' ? 'User' : 'Smith',
            'email' => $username === 'admin' ? 'admin@mechanicus.com' : 'john.smith@mechanicus.com',
            'role' => $username === 'admin' ? 'Tech-Dominus' : 'Tech-Priest'
        ];
        error_log("✅ AUTH SUCCESS for $username");
        return true;
    }

    error_log("❌ AUTH FAILED for $username");
    return false;

    /*
    // Original database code (commented out since no database connection exists)
    global $pdo;

    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = :username");
    $stmt->execute([':username' => $username]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user'] = $user;
        return true;
    }

    return false;
    */
}