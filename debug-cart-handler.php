<?php
// Simple cart handler debug
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<h1>Cart Handler Debug</h1>";

try {

    echo "<p>✅ Session started</p>";

    echo "<p>2. Loading bootstrap...</p>";
    require_once __DIR__ . '/../bootstrap.php';
    echo "<p>✅ Bootstrap loaded</p>";

    echo "<p>3. Loading cart utils...</p>";
    require_once __DIR__ . '/../utils/cart.util.php';
    echo "<p>✅ Cart utils loaded</p>";

    echo "<p>4. Testing cart functions...</p>";
    $products = getProducts();
    echo "<p>✅ Products loaded: " . count($products) . " items</p>";

    $cartItems = getCartItems();
    echo "<p>✅ Cart items: " . count($cartItems) . " items</p>";

    $total = getCartTotal();
    echo "<p>✅ Cart total: " . formatPrice($total) . "</p>";

    echo "<p>5. Testing add to cart...</p>";
    $result = addToCart(1, 1);
    echo "<p>✅ Add to cart result: " . ($result ? 'Success' : 'Failed') . "</p>";

    $cartItems = getCartItems();
    echo "<p>✅ Cart items after add: " . count($cartItems) . " items</p>";

    echo "<p>6. Session data:</p>";
    echo "<pre>" . print_r($_SESSION, true) . "</pre>";

} catch (Exception $e) {
    echo "<p>❌ Error: " . $e->getMessage() . "</p>";
    echo "<p>File: " . $e->getFile() . " Line: " . $e->getLine() . "</p>";
    echo "<pre>" . $e->getTraceAsString() . "</pre>";
}
?>
