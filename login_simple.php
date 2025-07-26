<?php

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Sacred Login - Mechanicus Health Emporium</title>
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@400;600;700&family=Roboto:wght@300;400;500&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />
  <link rel="stylesheet" href="assets/css/style.css" />
</head>
<body>
  <!-- HEADER -->
  <header class="header">
    <div class="top-bar">
      <div class="title">MECHANICUS HEALTH EMPORIUM</div>
    </div>
  </header>

  <!-- LOGIN FORM -->
  <main class="main-content">
    <section class="login-section">
      <div class="white-box login-box">
        <h2><i class="fas fa-cog"></i> Sacred Authentication</h2>
        <p>Enter your blessed credentials to access the Sacred Emporium</p>
        
        <?php if ($error): ?>
        <div class="error-message">
          <i class="fas fa-exclamation-triangle"></i>
          <?= htmlspecialchars($error) ?>
        </div>
        <?php endif; ?>
        
        <form method="post" class="login-form">
          <div class="form-group">
            <label for="username"><i class="fas fa-user"></i> Username</label>
            <input type="text" id="username" name="username" required placeholder="Enter your username">
          </div>
          <div class="form-group">
            <label for="password"><i class="fas fa-lock"></i> Password</label>
            <input type="password" id="password" name="password" required placeholder="Enter your password">
          </div>
          <button type="submit" class="btn btn-login">
            <i class="fas fa-sign-in-alt"></i> Sacred Login
          </button>
        </form>
        
        <div class="login-info">
          <h4>Test Credentials:</h4>
          <p><strong>Admin:</strong> username: admin, password: password</p>
          <p><strong>User:</strong> username: john.smith, password: p@ssW0rd1234</p>
        </div>
        
        <p class="signup-link">
          Don't have blessed access? <a href="layouts/signup.php">Request Sacred Account</a>
        </p>
      </div>
    </section>
  </main>

  <style>
    .login-section {
      display: flex;
      justify-content: center;
      align-items: center;
      min-height: calc(100vh - 200px);
      padding: 40px 20px;
    }

    .login-box {
      max-width: 500px;
      width: 100%;
      padding: 40px;
      text-align: center;
    }

    .login-box h2 {
      font-family: 'Cinzel', serif;
      color: var(--imperial-red);
      margin-bottom: 15px;
      font-size: 2.2em;
    }

    .login-box h2 i {
      color: var(--primary-gold);
      margin-right: 10px;
    }

    .login-box p {
      color: var(--dark-bronze);
      margin-bottom: 30px;
      font-style: italic;
    }

    .error-message {
      background: rgba(220, 53, 69, 0.1);
      border: 2px solid #dc3545;
      color: #dc3545;
      padding: 15px;
      border-radius: 8px;
      margin-bottom: 20px;
      display: flex;
      align-items: center;
      gap: 10px;
    }

    .login-form {
      text-align: left;
      margin-bottom: 30px;
    }

    .form-group {
      margin-bottom: 20px;
    }

    .form-group label {
      display: block;
      margin-bottom: 8px;
      font-weight: bold;
      color: var(--dark-bronze);
      display: flex;
      align-items: center;
      gap: 8px;
    }

    .form-group input {
      width: 100%;
      padding: 12px 15px;
      border: 2px solid var(--primary-gold);
      border-radius: 8px;
      font-size: 16px;
      transition: all 0.3s ease;
      background: rgba(255,255,255,0.9);
    }

    .form-group input:focus {
      outline: none;
      border-color: var(--imperial-red);
      box-shadow: 0 0 10px rgba(218, 165, 32, 0.3);
    }

    .btn-login {
      width: 100%;
      padding: 15px;
      background: linear-gradient(135deg, var(--primary-gold), var(--imperial-red));
      color: white;
      border: none;
      border-radius: 25px;
      font-size: 18px;
      font-weight: bold;
      cursor: pointer;
      transition: all 0.3s ease;
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 10px;
    }

    .btn-login:hover {
      transform: scale(1.02);
      box-shadow: 0 5px 15px rgba(0,0,0,0.3);
      background: linear-gradient(135deg, var(--imperial-red), var(--primary-gold));
    }

    .login-info {
      background: rgba(218, 165, 32, 0.1);
      border: 1px solid var(--primary-gold);
      border-radius: 8px;
      padding: 20px;
      margin-bottom: 20px;
      text-align: left;
    }

    .login-info h4 {
      font-family: 'Cinzel', serif;
      color: var(--imperial-red);
      margin-bottom: 10px;
    }

    .login-info p {
      margin: 5px 0;
      font-size: 0.9em;
      color: var(--dark-bronze);
    }

    .signup-link {
      color: var(--dark-bronze);
    }

    .signup-link a {
      color: var(--imperial-red);
      text-decoration: none;
      font-weight: bold;
    }

    .signup-link a:hover {
      color: var(--primary-gold);
    }

    @media (max-width: 768px) {
      .login-box {
        padding: 20px;
        margin: 20px;
      }
    }
  </style>
</body>
</html>
