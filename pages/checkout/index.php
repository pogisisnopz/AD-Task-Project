<?php
require_once __DIR__ . '/../../bootstrap.php';
require_once __DIR__ . '/../../utils/auth.util.php';
require_once __DIR__ . '/../../layouts/main.layout.php';

$loggedIn = isAuthenticated();
$user = $loggedIn ? getAuthenticatedUser() : null;

ob_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Sacred Checkout - Mechanicus Health Emporium</title>
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@400;600;700&family=Roboto:wght@300;400;500&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />
  <link rel="stylesheet" href="../../assets/css/style.css" />
  <script src="../../assets/js/cart.js"></script>
</head>
<body>

<header class="header">
  <div class="top-bar">
    <div class="title">MECHANICUS HEALTH EMPORIUM</div>
    <a href="../../pages/cart/index.php" class="cart" id="cart-link">Sacred Cart: ₱0.00</a>
  </div>
  <nav class="nav-bar">
    <ul>
      <li><a href="../../pages/home/index.php">Sacred Home</a></li>
      <li><a href="../../pages/products/index.php">Blessed Products</a></li>
      <li><a href="../../pages/about/index.php">The Sacred Creed</a></li>
      <li><a href="../../pages/delivery/index.php">Imperial Delivery</a></li>
      <li><a href="../../pages/privacy/index.php">Privacy Protocols</a></li>
      <li><a href="../../pages/terms/index.php">Terms of Service</a></li>
      <li><a href="../../pages/faq/index.php">Sacred Knowledge</a></li>
      <li><a href="../../pages/cart/index.php">Sacred Cart</a></li>
    </ul>
  </nav>
</header>

<main class="main-content">
  <section class="page-header">
    <div class="white-box">
      <h1>Sacred Checkout</h1>
      <p>Complete your blessed transaction</p>
    </div>
  </section>

  <section class="checkout-content">
    <div class="checkout-form white-box">
      <h2>Shipping Information</h2>
      <form id="checkout-form">
        <div class="form-group">
          <label for="full-name">Full Name</label>
          <input type="text" id="full-name" name="full-name" required>
        </div>
        <div class="form-group">
          <label for="email">Email Address</label>
          <input type="email" id="email" name="email" required>
        </div>
        <div class="form-group">
          <label for="address">Address</label>
          <textarea id="address" name="address" rows="3" required></textarea>
        </div>
        <div class="form-row">
          <div class="form-group">
            <label for="city">City</label>
            <input type="text" id="city" name="city" required>
          </div>
          <div class="form-group">
            <label for="postal">Postal Code</label>
            <input type="text" id="postal" name="postal" required>
          </div>
        </div>

        <h3>Payment Method</h3>
        <div class="payment-methods">
          <label class="payment-option">
            <input type="radio" name="payment" value="credit" checked>
            <span>Credit Card</span>
          </label>
          <label class="payment-option">
            <input type="radio" name="payment" value="debit">
            <span>Debit Card</span>
          </label>
          <label class="payment-option">
            <input type="radio" name="payment" value="paypal">
            <span>PayPal</span>
          </label>
        </div>

        <div class="form-group">
          <label for="card-number">Card Number</label>
          <input type="text" id="card-number" name="card-number" required>
        </div>
        <div class="form-row">
          <div class="form-group">
            <label for="expiry">Expiry Date</label>
            <input type="text" id="expiry" name="expiry" placeholder="MM/YY" required>
          </div>
          <div class="form-group">
            <label for="cvv">CVV</label>
            <input type="text" id="cvv" name="cvv" required>
          </div>
        </div>

        <button type="submit" class="btn btn-complete">Complete Sacred Order</button>
      </form>
    </div>

    <div class="order-summary white-box">
      <h3>Order Summary</h3>
      <div class="summary-items" id="checkout-cart-items">
        <p>Loading cart...</p>
      </div>
      <div class="summary-totals">
        <div class="summary-line"><span>Subtotal:</span><span id="checkout-subtotal">₱0.00</span></div>
        <div class="summary-line"><span>Shipping:</span><span id="checkout-shipping">₱99.00</span></div>
        <div class="summary-line"><span>Tax:</span><span id="checkout-tax">₱0.00</span></div>
        <div class="summary-line total"><span>Total:</span><span id="checkout-total">₱99.00</span></div>
      </div>
    </div>
  </section>
</main>

<script>
document.addEventListener('DOMContentLoaded', function () {
  let currentTotals = { subtotal: 0, tax: 0, shipping: 0, total: 0 }; // Store current totals

  function displayCheckoutSummary() {
    const cart = MechaCart.getCart();
    const cartItemsDiv = document.getElementById('checkout-cart-items');
    const cartEntries = Object.entries(cart);
    if (cartEntries.length === 0) {
      cartItemsDiv.innerHTML = '<p>No items in cart</p>';
      updateCheckoutTotals(0);
      return;
    }

    let subtotal = 0;
    let itemsHtml = '';

    cartEntries.forEach(([productId, item]) => {
      if (item.product) {
        const itemTotal = item.product.price * item.quantity;
        subtotal += itemTotal;
        itemsHtml += `<div class="checkout-item">
          <span>${item.product.name} × ${item.quantity}</span>
          <span>₱${itemTotal.toFixed(2)}</span>
        </div>`;
      }
    });

    cartItemsDiv.innerHTML = itemsHtml;
    updateCheckoutTotals(subtotal);
  }

  function updateCheckoutTotals(subtotal) {
    const tax = subtotal * 0.12;
    const shipping = subtotal > 0 ? 99 : 0;
    const total = subtotal + tax + shipping;

    // Update the global totals object
    currentTotals = { subtotal, tax, shipping, total };

    document.getElementById('checkout-subtotal').textContent = `₱${subtotal.toFixed(2)}`;
    document.getElementById('checkout-tax').textContent = `₱${tax.toFixed(2)}`;
    document.getElementById('checkout-shipping').textContent = `₱${shipping.toFixed(2)}`;
    document.getElementById('checkout-total').textContent = `₱${total.toFixed(2)}`;
  }

  displayCheckoutSummary();

  document.getElementById('checkout-form').addEventListener('submit', function (e) {
    e.preventDefault();

    const orderData = {
      items: MechaCart.getCart(),
      customerInfo: {
        name: document.getElementById('full-name').value,
        email: document.getElementById('email').value,
        address: document.getElementById('address').value,
        city: document.getElementById('city').value,
        postal: document.getElementById('postal').value,
        payment: document.querySelector('input[name="payment"]:checked').value
      },
      totals: currentTotals, // NEW: Include calculated totals
      orderDate: new Date().toISOString(),
      orderId: 'ORD-' + Date.now()
    };

    // Send to PHP backend for DB saving
    fetch('/process_checkout.php', {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify(orderData)
      })
    .then(response => response.json())
    .then(result => {
      if (result.success) {
        MechaCart.clearCart();
        localStorage.setItem('currentOrder', JSON.stringify(orderData));
        window.location.href = '../../pages/order-confirmation/index.php';
      } else {
        alert('❌ Order failed: ' + result.error);
        console.error('Server error:', result.error); // Better error logging
      }
    })
    .catch(error => {
      console.error('❌ Order error:', error);
      alert('❌ Unexpected error occurred.');
    });
  });
});
</script>

</body>
</html>

<?php
$content = ob_get_clean();
echo $content;
?>