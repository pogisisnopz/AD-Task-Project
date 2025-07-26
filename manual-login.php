<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<h1>Manual Session Test</h1>";

if (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';
    
    echo "<p>Form submitted with username: " . htmlspecialchars($username) . "</p>";
    
    if ($username === 'admin' && $password === 'password') {
        $_SESSION['user'] = [
            'id' => 1,
            'username' => 'admin',
            'first_name' => 'Admin',
            'last_name' => 'User'
        ];
        echo "<p>✅ Session set manually!</p>";
        echo "<p>Session data: <pre>" . print_r($_SESSION, true) . "</pre></p>";
        echo "<p><a href='session-debug.php'>Check session in debug page</a></p>";
        echo "<p><a href='index.php'>Try accessing homepage</a></p>";
    } else {
        echo "<p>❌ Wrong credentials</p>";
    }
} else {
    echo '<form method="post">
        <p>Username: <input type="text" name="username" value="admin"></p>
        <p>Password: <input type="password" name="password" value="password"></p>
        <p><button type="submit">Set Session Manually</button></p>
    </form>';
}

echo "<p>Current session data: <pre>" . print_r($_SESSION, true) . "</pre></p>";
?>
