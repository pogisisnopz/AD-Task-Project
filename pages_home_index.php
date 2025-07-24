<?php
require_once '../../utils/auth.util.php';
requireLogin();
$user = getAuthenticatedUser();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Home - Mechanicus</title>
</head>
<body>
    <h1>Welcome, <?= htmlspecialchars($user['first_name']) ?>!</h1>
    <p>You are logged in as: <strong><?= $user['role'] ?></strong></p>
    <a href="../../logout.php">Logout</a>
</body>
</html>
