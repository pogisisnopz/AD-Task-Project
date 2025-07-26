<?php


// Check if user is logged in
if (!isset($_SESSION['user'])) {
    header("Location: login_simple.php");
    exit;
}

$user = $_SESSION['user'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Mechanicus Health Emporium - Warhammer Steampunk Healthcare</title>

  <!-- Fonts & Icons -->
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@400;600;700&family=Roboto:wght@300;400;500&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />

  <!-- Custom Styles -->
  <link rel="stylesheet" href="assets/css/style.css" />
</head>
<body>
  <!-- HEADER -->
  <header class="header">
    <div class="top-bar">
      <div class="title">MECHANICUS HEALTH EMPORIUM</div>
      <a href="pages/cart/" class="cart">Sacred Cart: ₱0.00 (0)</a>
    </div>
    <nav class="nav-bar">
      <ul>
        <li><a href="index_simple.php" class="active">Sacred Home</a></li>
        <li><a href="pages/products/">Blessed Products</a></li>
        <li><a href="pages/about/">The Sacred Creed</a></li>
        <li><a href="pages/delivery/">Imperial Delivery</a></li>
        <li><a href="pages/privacy/">Privacy Protocols</a></li>
        <li><a href="pages/terms/">Terms of Service</a></li>
        <li><a href="pages/faq/">Sacred Knowledge</a></li>
        <li><a href="pages/cart/">Sacred Cart</a></li>
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
        <a href="logout_simple.php" class="btn btn-secondary">Sacred Logout</a>
      </div>
    </section>

    <section class="banner">
      <div class="banner-left white-box steam-effect"></div>
      <div class="banner-center white-box">
        <h1>BLESSED HEALING</h1>
        <p>For the Emperor's Glory!</p>
        <div class="action-buttons">
          <a href="pages/products/" class="btn btn-primary">Browse Sacred Products</a>
          <a href="pages/about/" class="btn btn-secondary">Learn Our Creed</a>
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
      <div class="brand white-box">Imperial Healing Co.</div>
      <div class="brand white-box">Sacred Instruments Ltd.</div>
      <div class="brand white-box">Blessed Pharmaceuticals</div>
    </section>
  </main>

  <style>
    .welcome-section {
      margin-bottom: 40px;
      text-align: center;
    }

    .welcome-section h2 {
      font-family: 'Cinzel', serif;
      color: var(--imperial-red);
      margin-bottom: 10px;
    }

    .welcome-section p {
      color: var(--dark-bronze);
      margin-bottom: 20px;
    }
  </style>
</body>
</html>
