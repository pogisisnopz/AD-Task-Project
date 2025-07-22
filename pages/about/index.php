<?php
require_once __DIR__ . '/../../bootstrap.php';
require_once __DIR__ . '/../../utils/auth.util.php';
require_once __DIR__ . '/../../layouts/main.layout.php';

// Check if the user is logged in
$loggedIn = isAuthenticated();
$user = $loggedIn ? getAuthenticatedUser() : null;

ob_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>The Sacred Creed - Mechanicus Health Emporium</title>
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@400;600;700&family=Roboto:wght@300;400;500&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />
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
        <li><a href="../../pages/home/">Sacred Home</a></li>
        <li><a href="../../pages/products/">Blessed Products</a></li>
        <li><a href="../../pages/about/" class="active">The Sacred Creed</a></li>
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
    <section class="page-header">
      <div class="white-box">
        <h1>The Sacred Creed</h1>
        <p>Our mission to bring blessed healing to the Emperor's people</p>
      </div>
    </section>

    <section class="about-content">
      <div class="about-section white-box">
        <h2><i class="fas fa-cog"></i> Our Sacred Mission</h2>
        <p>
          In the name of the Omnissiah and for the glory of the Emperor, the Mechanicus Health Emporium 
          stands as a beacon of healing in the grim darkness of the far future. We are devoted servants 
          of the Machine God, blessed with the sacred knowledge of healing and restoration.
        </p>
        <p>
          Our mission is to provide the finest medical supplies, blessed by the rituals of the Adeptus 
          Mechanicus and sanctified for the health and wellbeing of all loyal Imperial citizens.
        </p>
      </div>

      <div class="about-section white-box">
        <h2><i class="fas fa-users-cog"></i> The Sacred Brotherhood</h2>
        <p>
          Our Tech-Priests and Medicae specialists have dedicated their lives to the pursuit of perfect 
          health through the union of flesh and machine. Each product in our emporium has been carefully 
          crafted and blessed according to ancient STC patterns.
        </p>
        <div class="team-grid">
          <div class="team-member">
            <div class="member-icon">
              <i class="fas fa-user-tie"></i>
            </div>
            <h4>Tech-Dominus Healer</h4>
            <p>Supreme Medicae Specialist</p>
          </div>
          <div class="team-member">
            <div class="member-icon">
              <i class="fas fa-user-md"></i>
            </div>
            <h4>Magos Biologis</h4>
            <p>Master of Biological Sciences</p>
          </div>
          <div class="team-member">
            <div class="member-icon">
              <i class="fas fa-cogs"></i>
            </div>
            <h4>Tech-Priest Medicae</h4>
            <p>Sacred Equipment Specialist</p>
          </div>
        </div>
      </div>

      <div class="about-section white-box">
        <h2><i class="fas fa-award"></i> Sacred Principles</h2>
        <div class="principles-grid">
          <div class="principle">
            <i class="fas fa-shield-alt"></i>
            <h4>Quality Assurance</h4>
            <p>Every product blessed by the Omnissiah's sacred rituals</p>
          </div>
          <div class="principle">
            <i class="fas fa-shipping-fast"></i>
            <h4>Swift Delivery</h4>
            <p>Imperial courier networks ensure rapid deployment</p>
          </div>
          <div class="principle">
            <i class="fas fa-lock"></i>
            <h4>Sacred Security</h4>
            <p>Your health data protected by machine spirit encryption</p>
          </div>
          <div class="principle">
            <i class="fas fa-heart"></i>
            <h4>Compassionate Care</h4>
            <p>Healing in the Emperor's name with dignity and respect</p>
          </div>
        </div>
      </div>

      <div class="about-section white-box">
        <h2><i class="fas fa-history"></i> Sacred History</h2>
        <div class="timeline">
          <div class="timeline-item">
            <div class="timeline-year">M31.001</div>
            <div class="timeline-content">
              <h4>Foundation of the Emporium</h4>
              <p>Established during the Great Crusade to supply healing to the Emperor's armies</p>
            </div>
          </div>
          <div class="timeline-item">
            <div class="timeline-year">M35.500</div>
            <div class="timeline-content">
              <h4>Sacred STC Discovery</h4>
              <p>Ancient medical STC patterns recovered from a long-lost forge world</p>
            </div>
          </div>
          <div class="timeline-item">
            <div class="timeline-year">M41.999</div>
            <div class="timeline-content">
              <h4>Digital Blessing</h4>
              <p>Launch of our sacred digital emporium to serve all Imperial worlds</p>
            </div>
          </div>
        </div>
      </div>
    </section>
  </main>

  <style>
    .page-header {
      margin-bottom: 40px;
      text-align: center;
    }

    .page-header h1 {
      font-family: 'Cinzel', serif;
      font-size: 3em;
      color: var(--imperial-red);
      margin-bottom: 10px;
    }

    .about-content {
      max-width: 1200px;
      margin: 0 auto;
      display: flex;
      flex-direction: column;
      gap: 40px;
    }

    .about-section {
      padding: 40px;
    }

    .about-section h2 {
      font-family: 'Cinzel', serif;
      color: var(--imperial-red);
      margin-bottom: 25px;
      font-size: 2em;
      display: flex;
      align-items: center;
      gap: 15px;
    }

    .about-section h2 i {
      color: var(--primary-gold);
    }

    .about-section p {
      line-height: 1.8;
      margin-bottom: 20px;
      color: var(--dark-bronze);
      font-size: 1.1em;
    }

    .team-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
      gap: 30px;
      margin-top: 30px;
    }

    .team-member {
      text-align: center;
      padding: 20px;
      border: 2px solid var(--primary-gold);
      border-radius: 15px;
      transition: all 0.3s ease;
    }

    .team-member:hover {
      transform: translateY(-5px);
      box-shadow: 0 10px 25px rgba(0,0,0,0.2);
    }

    .member-icon {
      font-size: 3em;
      color: var(--primary-gold);
      margin-bottom: 15px;
    }

    .team-member h4 {
      font-family: 'Cinzel', serif;
      color: var(--imperial-red);
      margin-bottom: 10px;
    }

    .principles-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
      gap: 30px;
      margin-top: 30px;
    }

    .principle {
      text-align: center;
      padding: 30px 20px;
      border-radius: 15px;
      background: linear-gradient(135deg, rgba(218, 165, 32, 0.1), rgba(139, 68, 68, 0.1));
      border: 1px solid var(--primary-gold);
      transition: all 0.3s ease;
    }

    .principle:hover {
      transform: scale(1.05);
      box-shadow: 0 8px 20px rgba(0,0,0,0.2);
    }

    .principle i {
      font-size: 2.5em;
      color: var(--primary-gold);
      margin-bottom: 15px;
    }

    .principle h4 {
      font-family: 'Cinzel', serif;
      color: var(--imperial-red);
      margin-bottom: 10px;
    }

    .timeline {
      margin-top: 30px;
    }

    .timeline-item {
      display: flex;
      gap: 30px;
      margin-bottom: 30px;
      padding: 20px;
      border-left: 3px solid var(--primary-gold);
      position: relative;
    }

    .timeline-item::before {
      content: '';
      position: absolute;
      left: -8px;
      top: 25px;
      width: 13px;
      height: 13px;
      background: var(--primary-gold);
      border-radius: 50%;
    }

    .timeline-year {
      font-family: 'Cinzel', serif;
      font-weight: bold;
      color: var(--imperial-red);
      font-size: 1.2em;
      min-width: 100px;
    }

    .timeline-content h4 {
      font-family: 'Cinzel', serif;
      color: var(--dark-bronze);
      margin-bottom: 10px;
    }

    @media (max-width: 768px) {
      .about-section {
        padding: 20px;
      }

      .timeline-item {
        flex-direction: column;
        gap: 10px;
      }

      .team-grid,
      .principles-grid {
        grid-template-columns: 1fr;
      }
    }
  </style>
</body>
</html>

<?php
$content = ob_get_clean();
echo $content;
?>
