<?php
require_once 'bootstrap.php';
require_once 'utils/auth.util.php';
require_once 'layouts/main.layout.php';

$error = '';

// Check if REQUEST_METHOD is set (this avoids CLI warnings)
if (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    if (authenticate($username, $password)) {
        header("Location: index.php");
        exit;
    } else {
        $error = "❌ Invalid credentials.";
    }
}

ob_start();
?>
<h2>Login</h2>
<?php if ($error): ?>
    <p style="color:red;"><?= htmlspecialchars($error) ?></p>
<?php endif; ?>
<form method="post">
    <label>Username: <input type="text" name="username" required></label><br>
    <label>Password: <input type="password" name="password" required></label><br>
    <button type="submit">Login</button>
</form>
<?php
$content = ob_get_clean();

echo renderLayout("Login", $content);
