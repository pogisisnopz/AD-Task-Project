<?php
// Cart utility functions

// Ensure session is started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Initialize cart if it doesn't exist
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Sample products data
function getProducts() {
    return [
        1 => [
            'id' => 1,
            'name' => 'Sacred Healing Elixir',
            'description' => 'Blessed by the Emperor\'s grace, cures minor ailments',
            'price' => 299.99,
            'category' => 'medicine',
            'icon' => 'fas fa-pills'
        ],
        2 => [
            'id' => 2,
            'name' => 'Omnissiah\'s Diagnostic Tool',
            'description' => 'Advanced medical scanner blessed with machine spirit',
            'price' => 1999.99,
            'category' => 'equipment',
            'icon' => 'fas fa-stethoscope'
        ],
        3 => [
            'id' => 3,
            'name' => 'Imperial Combat Stim',
            'description' => 'Emergency healing injection for battlefield wounds',
            'price' => 599.99,
            'category' => 'medicine',
            'icon' => 'fas fa-syringe'
        ],
        4 => [
            'id' => 4,
            'name' => 'Blessed Vitamins',
            'description' => 'Essential nutrients blessed for optimal health',
            'price' => 149.99,
            'category' => 'supplements',
            'icon' => 'fas fa-capsules'
        ],
        5 => [
            'id' => 5,
            'name' => 'Medicae\'s Surgery Kit',
            'description' => 'Complete surgical tools blessed by the Omnissiah',
            'price' => 2499.99,
            'category' => 'tools',
            'icon' => 'fas fa-user-md'
        ],
        6 => [
            'id' => 6,
            'name' => 'Sacred Thermometer',
            'description' => 'Precision temperature measurement device',
            'price' => 99.99,
            'category' => 'equipment',
            'icon' => 'fas fa-thermometer-half'
        ]
    ];
}

// Add item to cart
function addToCart($productId, $quantity = 1) {
    $products = getProducts();
    
    if (!isset($products[$productId])) {
        return false;
    }
    
    if (isset($_SESSION['cart'][$productId])) {
        $_SESSION['cart'][$productId]['quantity'] += $quantity;
    } else {
        $_SESSION['cart'][$productId] = [
            'product' => $products[$productId],
            'quantity' => $quantity
        ];
    }
    
    return true;
}

// Remove item from cart
function removeFromCart($productId) {
    if (isset($_SESSION['cart'][$productId])) {
        unset($_SESSION['cart'][$productId]);
        return true;
    }
    return false;
}

// Update cart item quantity
function updateCartQuantity($productId, $quantity) {
    if (isset($_SESSION['cart'][$productId])) {
        if ($quantity <= 0) {
            removeFromCart($productId);
        } else {
            $_SESSION['cart'][$productId]['quantity'] = $quantity;
        }
        return true;
    }
    return false;
}

// Get cart items
function getCartItems() {
    return $_SESSION['cart'] ?? [];
}

// Get cart total
function getCartTotal() {
    $total = 0;
    $cartItems = getCartItems();
    
    foreach ($cartItems as $item) {
        $total += $item['product']['price'] * $item['quantity'];
    }
    
    return $total;
}

// Get cart item count
function getCartItemCount() {
    $count = 0;
    $cartItems = getCartItems();
    
    foreach ($cartItems as $item) {
        $count += $item['quantity'];
    }
    
    return $count;
}

// Clear cart
function clearCart() {
    $_SESSION['cart'] = [];
}

// Format price
function formatPrice($price) {
    return '₱' . number_format($price, 2);
}
?>
