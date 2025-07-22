<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once __DIR__ . '/../../bootstrap.php';
require_once __DIR__ . '/../../utils/auth.util.php';
require_once __DIR__ . '/../../layouts/main.layout.php';

// Check if the user is logged in
$loggedIn = isAuthenticated();
$user = $loggedIn ? getAuthenticatedUser() : null;

// If not logged in, redirect to login
if (!$loggedIn) {
    // Clear any output buffer and redirect
    if (ob_get_level()) {
        ob_end_clean();
    }
    header("Location: ../../index.php");
    exit;
}

ob_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Sacred Home - Mechanicus Health Emporium</title>

  <!-- Fonts & Icons -->
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@400;600;700&family=Roboto:wght@300;400;500&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />

  <!-- Custom Styles -->
  <link rel="stylesheet" href="../../assets/css/style.css" />
  <script src="../../assets/js/cart.js"></script>
</head>
<body>
  <!-- HEADER -->
  <header class="header">
    <div class="top-bar">
      <div class="title">MECHANICUS HEALTH EMPORIUM</div>
      <a href="../../pages/cart/" class="cart" id="cart-link">Sacred Cart: ₱0.00</a>
    </div>
    <nav class="nav-bar">
      <ul>
        <li><a href="../../pages/home/" class="active">Sacred Home</a></li>
        <li><a href="../../pages/products/">Blessed Products</a></li>
        <li><a href="../../pages/about/">The Sacred Creed</a></li>
        <li><a href="../../pages/delivery/">Imperial Delivery</a></li>
        <li><a href="../../pages/privacy/">Privacy Protocols</a></li>
        <li><a href="../../pages/terms/">Terms of Service</a></li>
        <li><a href="../../pages/faq/">Sacred Knowledge</a></li>
        <li><a href="../../pages/cart/">Sacred Cart</a></li>
      </ul>
    </nav>
  </header>

  <!-- MAIN CONTENT -->
  <main class="main-content">
    <!-- Welcome Section -->
    <section class="welcome-section">
      <div class="white-box">
        <h2>Welcome back, <?= htmlspecialchars($user['first_name'] . ' ' . $user['last_name']) ?>!</h2>
        <p>Role: <?= htmlspecialchars($user['role']) ?></p>
        <a href="../../logout.php" class="btn btn-secondary">Sacred Logout</a>
      </div>
    </section>

    <section class="banner">
      <div class="banner-left white-box steam-effect"></div>
      <div class="banner-center white-box">
        <h1>BLESSED HEALING</h1>
        <p>For the Emperor's Glory!</p>
        <div class="action-buttons">
          <a href="../../pages/products/" class="btn btn-primary">Browse Sacred Products</a>
          <a href="../../pages/about/" class="btn btn-secondary">Learn Our Creed</a>
        </div>
      </div>
      <div class="banner-right white-box steam-effect"></div>
    </section>

    <section class="promo">
      <div class="promo-left white-box steam-effect"></div>
      <div class="promo-right white-box steam-effect"></div>
    </section>

    <section class="brands">
      <div class="brand white-box">Omnissiah Medical™</div>
      <div class="brand white-box">AdMech Diagnostics™</div>
      <div class="brand white-box">Imperial Remedies™</div>
      <div class="brand white-box">Tech-Priest Solutions™</div>
    </section>
  </main>
</body>
</html>

<?php
$content = ob_get_clean();
echo $content;
?>
