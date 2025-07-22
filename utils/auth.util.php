<?php
declare(strict_types=1);

// Start session if not started already
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Check if user is logged in
function isAuthenticated(): bool {
    return isset($_SESSION['user']);
}

// Get logged-in user data
function getAuthenticatedUser(): ?array {
    return $_SESSION['user'] ?? null;
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
    session_destroy();
}

function authenticate(string $username, string $password): bool {
    global $pdo;

    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = :username");
    $stmt->execute([':username' => $username]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user'] = $user;
        return true;
    }

    return false;
}

