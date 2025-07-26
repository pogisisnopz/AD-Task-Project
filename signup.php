<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Start output buffering immediately
ob_start();

require_once 'bootstrap.php';
require_once 'utils/auth.util.php';

$error = '';
$success = '';
$showSignupForm = true;

// Check if user is already logged in
$loggedIn = isAuthenticated();
if ($loggedIn) {
    // Clear any output buffer and redirect to home
    if (ob_get_level()) {
        ob_end_clean();
    }
    header("Location: pages/home/");
    exit;
}

// Process form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get form data
    $username = trim($_POST['username'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $first_name = trim($_POST['first_name'] ?? '');
    $last_name = trim($_POST['last_name'] ?? '');
    $password = $_POST['password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';
    
    // Validation
    if (empty($username) || empty($email) || empty($first_name) || empty($last_name) || empty($password)) {
        $error = "❌ All fields are required";
    } elseif (strlen($username) < 3) {
        $error = "❌ Username must be at least 3 characters long";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "❌ Please enter a valid email address";
    } elseif (strlen($password) < 6) {
        $error = "❌ Password must be at least 6 characters long";
    } elseif ($password !== $confirm_password) {
        $error = "❌ Passwords do not match";
    } else {
        try {
            // Use the global $pdo from bootstrap.php
            global $pdo;
            
            // Check if username already exists
            $checkUsernameStmt = $pdo->prepare("SELECT COUNT(*) FROM users WHERE username = :username");
            $checkUsernameStmt->execute([':username' => $username]);
            
            if ($checkUsernameStmt->fetchColumn() > 0) {
                $error = "❌ Username already exists";
            } else {
                // Check if email already exists
                $checkEmailStmt = $pdo->prepare("SELECT COUNT(*) FROM users WHERE email = :email");
                $checkEmailStmt->execute([':email' => $email]);
                
                if ($checkEmailStmt->fetchColumn() > 0) {
                    $error = "❌ Email already registered";
                } else {
                    // Insert new user into database
                    $insertStmt = $pdo->prepare("
                        INSERT INTO users (username, email, first_name, last_name, password, role) 
                        VALUES (:username, :email, :first_name, :last_name, :password, :role)
                    ");
                    
                    $result = $insertStmt->execute([
                        ':username' => $username,
                        ':email' => $email,
                        ':first_name' => $first_name,
                        ':last_name' => $last_name,
                        ':password' => password_hash($password, PASSWORD_DEFAULT), // Properly hash the password
                        ':role' => 'user'
                    ]);
                    
                    if ($result) {
                        $success = "✅ Sacred account created successfully for " . htmlspecialchars($username) . "! You can now login.";
                        $showSignupForm = false;
                        
                        // Log the registration for development
                        error_log("New account created - Username: $username, Email: $email, Name: $first_name $last_name");
                    } else {
                        $error = "❌ Failed to create account. Please try again.";
                    }
                }
            }
            
        } catch (PDOException $e) {
            error_log("Registration database error: " . $e->getMessage());
            $error = "❌ Database error occurred. Please try again later.";
        }
    }
}

// Clear any previous output
if (ob_get_level()) {
    ob_clean();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Sacred Registration - Mechanicus Health Emporium</title>
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

  <!-- SIGNUP FORM -->
  <main class="main-content">
    <section class="signup-section">
      <div class="white-box signup-box">
        <h2><i class="fas fa-user-plus"></i> Sacred Registration</h2>
        <p>Join the blessed ranks of the Mechanicus Health Emporium</p>
        
        <?php if ($error): ?>
        <div class="error-message">
          <i class="fas fa-exclamation-triangle"></i>
          <?= htmlspecialchars($error) ?>
        </div>
        <?php endif; ?>
        
        <?php if ($success): ?>
        <div class="success-message">
          <i class="fas fa-check-circle"></i>
          <?= htmlspecialchars($success) ?>
        </div>
        <div class="navigation-links">
          <p><a href="index.php" class="btn btn-primary">🔐 Login Now</a></p>
          <p><a href="pages/products/" class="btn btn-secondary">🛍️ Browse Products</a></p>
        </div>
        <?php endif; ?>
        
        <?php if ($showSignupForm): ?>
        <form method="post" class="signup-form">
          <div class="form-row">
            <div class="form-group">
              <label for="first_name"><i class="fas fa-user"></i> First Name</label>
              <input type="text" id="first_name" name="first_name" required placeholder="Enter your first name" value="<?= htmlspecialchars($_POST['first_name'] ?? '') ?>">
            </div>
            <div class="form-group">
              <label for="last_name"><i class="fas fa-user"></i> Last Name</label>
              <input type="text" id="last_name" name="last_name" required placeholder="Enter your last name" value="<?= htmlspecialchars($_POST['last_name'] ?? '') ?>">
            </div>
          </div>
          
          <div class="form-group">
            <label for="username"><i class="fas fa-user-circle"></i> Username</label>
            <input type="text" id="username" name="username" required placeholder="Choose a username" value="<?= htmlspecialchars($_POST['username'] ?? '') ?>">
          </div>
          
          <div class="form-group">
            <label for="email"><i class="fas fa-envelope"></i> Email Address</label>
            <input type="email" id="email" name="email" required placeholder="Enter your email" value="<?= htmlspecialchars($_POST['email'] ?? '') ?>">
          </div>
          
          <div class="form-row">
            <div class="form-group">
              <label for="password"><i class="fas fa-lock"></i> Password</label>
              <input type="password" id="password" name="password" required placeholder="Create a password">
            </div>
            <div class="form-group">
              <label for="confirm_password"><i class="fas fa-lock"></i> Confirm Password</label>
              <input type="password" id="confirm_password" name="confirm_password" required placeholder="Confirm your password">
            </div>
          </div>
          
          <button type="submit" class="btn btn-signup">
            <i class="fas fa-user-plus"></i> Create Sacred Account
          </button>
        </form>
        
        <div class="signup-info">
          <h4>Sacred Account Benefits:</h4>
          <ul>
            <li><i class="fas fa-shopping-cart"></i> Access to blessed products</li>
            <li><i class="fas fa-truck"></i> Imperial delivery tracking</li>
            <li><i class="fas fa-star"></i> Exclusive Tech-Priest discounts</li>
            <li><i class="fas fa-cog"></i> Sacred order history</li>
          </ul>
        </div>
        
        <p class="login-link">
          Already have blessed access? <a href="index.php">Sacred Login</a>
        </p>
        <?php endif; ?>
      </div>
    </section>
  </main>

  <style>
    .signup-section {
      display: flex;
      justify-content: center;
      align-items: center;
      min-height: calc(100vh - 200px);
      padding: 40px 20px;
    }

    .signup-box {
      max-width: 600px;
      width: 100%;
      padding: 40px;
      text-align: center;
    }

    .signup-box h2 {
      font-family: 'Cinzel', serif;
      color: var(--imperial-red);
      font-size: 2em;
      margin-bottom: 10px;
    }

    .signup-box p {
      color: var(--dark-bronze);
      margin-bottom: 30px;
    }

    .signup-form {
      text-align: left;
      margin-bottom: 30px;
    }

    .form-row {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 20px;
      margin-bottom: 20px;
    }

    .form-group {
      margin-bottom: 20px;
    }

    .form-group label {
      display: block;
      margin-bottom: 8px;
      font-weight: bold;
      color: var(--imperial-red);
    }

    .form-group input {
      width: 100%;
      padding: 12px 15px;
      border: 2px solid var(--primary-gold);
      border-radius: 25px;
      font-size: 16px;
      background: rgba(245, 245, 220, 0.5);
      box-sizing: border-box;
    }

    .form-group input:focus {
      outline: none;
      border-color: var(--imperial-red);
      box-shadow: 0 0 10px rgba(139, 0, 0, 0.3);
    }

    .btn {
      padding: 12px 30px;
      border: none;
      border-radius: 25px;
      cursor: pointer;
      font-weight: bold;
      text-decoration: none;
      display: inline-block;
      text-align: center;
      transition: all 0.3s ease;
      font-size: 16px;
      margin: 5px;
    }

    .btn-signup {
      background: linear-gradient(135deg, var(--imperial-red), var(--dark-bronze));
      color: white;
      width: 100%;
      margin-bottom: 10px;
    }

    .btn-primary {
      background: linear-gradient(135deg, var(--imperial-red), var(--dark-bronze));
      color: white;
    }

    .btn-secondary {
      background: linear-gradient(135deg, var(--primary-gold), #f0d000);
      color: var(--dark-bronze);
    }

    .btn:hover {
      transform: scale(1.02);
      box-shadow: 0 5px 15px rgba(0,0,0,0.3);
    }

    .error-message, .success-message {
      padding: 15px;
      border-radius: 10px;
      margin-bottom: 20px;
      font-weight: bold;
    }

    .error-message {
      background: rgba(220, 53, 69, 0.1);
      border: 2px solid #dc3545;
      color: #dc3545;
    }

    .success-message {
      background: rgba(40, 167, 69, 0.1);
      border: 2px solid #28a745;
      color: #28a745;
    }

    .navigation-links {
      margin-top: 20px;
    }

    .navigation-links .btn {
      display: block;
      margin-bottom: 10px;
    }

    .signup-info {
      background: rgba(245, 245, 220, 0.3);
      padding: 20px;
      border-radius: 10px;
      margin: 20px 0;
      text-align: left;
    }

    .signup-info h4 {
      color: var(--imperial-red);
      margin-bottom: 15px;
      text-align: center;
    }

    .signup-info ul {
      list-style: none;
      padding: 0;
    }

    .signup-info li {
      padding: 8px 0;
      color: var(--dark-bronze);
    }

    .signup-info li i {
      color: var(--primary-gold);
      margin-right: 10px;
      width: 20px;
    }

    .login-link {
      margin-top: 20px;
      font-size: 0.9em;
    }

    .login-link a {
      color: var(--imperial-red);
      text-decoration: none;
      font-weight: bold;
    }

    .login-link a:hover {
      text-decoration: underline;
    }

    @media (max-width: 768px) {
      .signup-box {
        margin: 20px;
        padding: 30px 20px;
      }

      .form-row {
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
