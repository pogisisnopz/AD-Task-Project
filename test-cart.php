<?php

require_once 'utils/cart.util.php';

echo "<h1>Cart System Test</h1>";

// Test adding items to cart
echo "<h3>Testing Add to Cart:</h3>";
$result1 = addToCart(1, 2); // Add 2 Sacred Healing Elixirs
$result2 = addToCart(3, 1); // Add 1 Imperial Combat Stim
echo "<p>Add product 1: " . ($result1 ? "✅ Success" : "❌ Failed") . "</p>";
echo "<p>Add product 3: " . ($result2 ? "✅ Success" : "❌ Failed") . "</p>";

// Test cart contents
echo "<h3>Cart Contents:</h3>";
$cartItems = getCartItems();
echo "<pre>" . print_r($cartItems, true) . "</pre>";

// Test cart totals
echo "<h3>Cart Summary:</h3>";
echo "<p>Total Items: " . getCartItemCount() . "</p>";
echo "<p>Total Price: " . formatPrice(getCartTotal()) . "</p>";

// Test product list
echo "<h3>Available Products:</h3>";
$products = getProducts();
foreach ($products as $product) {
    echo "<p>ID: {$product['id']} - {$product['name']} - " . formatPrice($product['price']) . "</p>";
}

// Clear cart for next test
clearCart();
echo "<p>Cart cleared for next test</p>";
?>
