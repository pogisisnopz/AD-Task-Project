<?php
session_start();
require_once 'utils/auth.util.php';

$username = 'admin';
$password = 'password';

if (authenticate($username, $password)) {
    echo "✅ Logged in as $username!";
    print_r($_SESSION['user']);
} else {
    echo "❌ Failed to authenticate.";
}
