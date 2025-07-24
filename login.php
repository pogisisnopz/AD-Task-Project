<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // For now, skip authentication and just redirect
    $_SESSION['user'] = [
        'username' => $_POST['username'] ?? 'guest',
        'role' => 'guest',
        'first_name' => 'Guest',
        'last_name' => 'User',
    ];

header("Location: index.php");
exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
</head>
<body>
    <h2>Temporary Login</h2>
    <form method="POST" action="login.php">
        <label>Username: <input type="text" name="username" required></label><br>
        <label>Password: <input type="password" name="password" required></label><br>
        <button type="submit">Login</button>
    </form>
</body>
</html>


