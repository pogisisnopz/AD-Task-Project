<?php
session_start();
require_once 'bootstrap.php';
require_once 'utils/auth.util.php';

$error = '';

// DEBUG: Log request
file_put_contents('php://stderr', "Form submitted method: {$_SERVER['REQUEST_METHOD']}\n");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    // DEBUG: Print to error log
    error_log("Login attempt for username: $username");

    if (authenticate($username, $password)) {
        error_log("Login success for: $username");
        header('Location: pages/home/');
        exit;
    } else {
        error_log("Login failed for: $username");
        $error = "❌ Invalid username or password.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
</head>
<body>
    <h2>Login</h2>

    <?php if ($error): ?>
        <p style="color: red;"><?= htmlspecialchars($error) ?></p>
    <?php endif; ?>

    <form method="POST">
        <label>Username: <input type="text" name="username" required></label><br>
        <label>Password: <input type="password" name="password" required></label><br>
        <button type="submit">Login</button>
    </form>
</body>
</html>
