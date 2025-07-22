<?php
// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();

// Simple authentication check
if (!isset($_SESSION['authenticated']) || $_SESSION['authenticated'] !== true) {
    header('Location: login_simple.php');
    exit();
}

$username = $_SESSION['username'] ?? 'Unknown User';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SteamHealth Industries - Main Dashboard</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;700&display=swap" rel="stylesheet">
</head>
<body>
    <div class="overlay">
        <nav class="main-nav">
            <div class="nav-brand">
                <img src="assets/img/nyebe_white.png" alt="SteamHealth Industries" class="brand-logo">
                <span class="brand-text">SteamHealth Industries</span>
            </div>
            <ul class="nav-links">
                <li><a href="#" class="nav-link active">Dashboard</a></li>
                <li><a href="pages/products/" class="nav-link">Products</a></li>
                <li><a href="pages/cart/" class="nav-link">Cart <span id="cartCount">0</span></a></li>
                <li><a href="pages/about/" class="nav-link">About</a></li>
                <li><a href="logout_simple.php" class="nav-link">Logout</a></li>
            </ul>
        </nav>

        <div class="dashboard-container">
            <h1 class="dashboard-title">Welcome to SteamHealth Industries, <?php echo htmlspecialchars($username); ?>!</h1>
            
            <div class="dashboard-grid">
                <div class="dashboard-card">
                    <h3>Medical Equipment Catalog</h3>
                    <p>Browse our extensive collection of steampunk medical devices and equipment.</p>
                    <a href="pages/products/" class="btn btn-primary">View Products</a>
                </div>

                <div class="dashboard-card">
                    <h3>Shopping Cart</h3>
                    <p>Review your selected items and proceed to checkout.</p>
                    <a href="pages/cart/" class="btn btn-secondary">View Cart</a>
                </div>

                <div class="dashboard-card">
                    <h3>Company Information</h3>
                    <p>Learn more about SteamHealth Industries and our mission.</p>
                    <a href="pages/about/" class="btn btn-tertiary">About Us</a>
                </div>

                <div class="dashboard-card">
                    <h3>Customer Support</h3>
                    <p>Get help with your orders and find answers to common questions.</p>
                    <a href="pages/faq/" class="btn btn-quaternary">FAQ & Support</a>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Update cart count
        function updateCartCount() {
            const cart = JSON.parse(localStorage.getItem('cart') || '[]');
            const count = cart.reduce((total, item) => total + item.quantity, 0);
            document.getElementById('cartCount').textContent = count;
        }

        // Initialize cart count on page load
        updateCartCount();

        // Navigation animation
        document.querySelectorAll('.nav-link').forEach(link => {
            link.addEventListener('mouseenter', function() {
                this.style.transform = 'translateY(-2px)';
            });
            
            link.addEventListener('mouseleave', function() {
                this.style.transform = 'translateY(0)';
            });
        });

        // Dashboard card animation
        document.querySelectorAll('.dashboard-card').forEach(card => {
            card.addEventListener('mouseenter', function() {
                this.style.transform = 'translateY(-5px) scale(1.02)';
            });
            
            card.addEventListener('mouseleave', function() {
                this.style.transform = 'translateY(0) scale(1)';
            });
        });
    </script>
</body>
</html>
