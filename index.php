<?php
require_once 'bootstrap.php';
require_once 'utils/auth.util.php';
require_once 'layouts/main.layout.php';



// Check if the user is logged in
$loggedIn = isAuthenticated();
$user = $loggedIn ? getAuthenticatedUser() : null;



ob_start();
?>

<div style="text-align: center; margin-top: 50px;">
    <h2>Welcome to the Project Dashboard</h2>

    <?php if ($loggedIn): ?>
        <p>Hello, <strong><?= htmlspecialchars($user['first_name'] . ' ' . $user['last_name']) ?></strong>!</p>
        <p>Role: <?= htmlspecialchars($user['role']) ?></p>
        <a href="logout.php" style="padding: 8px 16px; background-color: #dc3545; color: white; text-decoration: none; border-radius: 4px;">Logout</a>
    <?php else: ?>
        <p>You are not logged in.</p>
        <a href="login.php" style="padding: 8px 16px; background-color: #28a745; color: white; text-decoration: none; border-radius: 4px;">Login</a>
    <?php endif; ?>

    <br><br>
    <a href="index.php" style="padding: 6px 12px; background-color: #007bff; color: white; text-decoration: none; border-radius: 4px;">Home</a>
</div>

<?php
$content = ob_get_clean();

echo renderLayout("Dashboard", $content);
