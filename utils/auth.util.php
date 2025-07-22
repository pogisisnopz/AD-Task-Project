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
        header('Location: login.php');
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
    // Ensure session is started
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    
    // Check file-based users first
    $usersFile = __DIR__ . '/../data/users.json';
    if (file_exists($usersFile)) {
        $users = json_decode(file_get_contents($usersFile), true) ?: [];
        
        foreach ($users as $user) {
            if ($user['username'] === $username && password_verify($password, $user['password'])) {
                $_SESSION['user'] = [
                    'id' => count($users), // Simple ID based on position
                    'username' => $user['username'],
                    'first_name' => $user['first_name'],
                    'last_name' => $user['last_name'],
                    'email' => $user['email'],
                    'role' => $user['role']
                ];
                error_log("File-based authentication successful for: " . $username);
                return true;
            }
        }
    }
    
    // Fallback to hardcoded credentials since database is not set up
    $validCredentials = [
        'admin' => 'password',
        'john.smith' => 'p@ssW0rd1234'
    ];
    
    error_log("Authenticate function called with username: '$username', password: '$password'");
    error_log("Valid credentials: " . print_r($validCredentials, true));
    
    if (isset($validCredentials[$username]) && $validCredentials[$username] === $password) {
        $_SESSION['user'] = [
            'id' => 1,
            'username' => $username,
            'first_name' => $username === 'admin' ? 'Admin' : 'John',
            'last_name' => $username === 'admin' ? 'User' : 'Smith',
            'email' => $username === 'admin' ? 'admin@mechanicus.com' : 'john.smith@mechanicus.com',
            'role' => $username === 'admin' ? 'Tech-Dominus' : 'Tech-Priest'
        ];
        return true;
    }
    
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

