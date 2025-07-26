<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<h1>Simple Login Test</h1>";

if (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';
    
    echo "<p>Form submitted!</p>";
    echo "<p>Username: " . htmlspecialchars($username) . "</p>";
    echo "<p>Password: " . htmlspecialchars($password) . "</p>";
    
    if ($username === 'admin' && $password === 'password') {
        $_SESSION['user'] = ['username' => $username];
        echo "<p>✅ Login successful! Setting session...</p>";
        echo "<p><a href='debug.php'>Go to debug page</a></p>";
        echo "<p><a href='index.php'>Go to homepage</a></p>";
    } else {
        echo "<p>❌ Login failed</p>";
    }
} else {
    echo '<form method="post">
        <p>Username: <input type="text" name="username" value="admin"></p>
        <p>Password: <input type="password" name="password" value="password"></p>
        <p><button type="submit">Login</button></p>
    </form>';
}
?>
