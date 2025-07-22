<?php
// Show all PHP errors (for debugging)
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Load the layout system
require_once '../layout.php'; // adjust if needed

// Dummy fallback if isAuthenticated() is not yet defined
if (!function_exists('isAuthenticated')) {
    function isAuthenticated() {
        return false; // or return isset($_SESSION['user']);
    }
}

// Sign-up form HTML
$signupForm = '
<div class="signup-container">
    <h2>Sign Up</h2>
    <form action="../register.php" method="POST">
        <input type="text" name="username" placeholder="Username" required><br>
        <input type="email" name="email" placeholder="Email" required><br>
        <input type="password" name="password" placeholder="Password" required><br>
        <button type="submit">Register</button>
    </form>
    <p>Already have an account? <a href="../login.php">Log In</a></p>
</div>
';

// Render the page
echo renderLayout('Sign Up', $signupForm);
