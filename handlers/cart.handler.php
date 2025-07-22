<?php
// Ensure session is started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/../bootstrap.php';
require_once __DIR__ . '/../utils/cart.util.php';

header('Content-Type: application/json');

// Add debugging
error_log("Cart handler called - Method: " . ($_SERVER['REQUEST_METHOD'] ?? 'UNKNOWN'));
error_log("POST data: " . print_r($_POST, true));

// Handle both POST and GET for testing
if (isset($_SERVER['REQUEST_METHOD']) && ($_SERVER['REQUEST_METHOD'] === 'POST' || $_SERVER['REQUEST_METHOD'] === 'GET')) {
    
    // Get data from POST or GET
    $data = $_SERVER['REQUEST_METHOD'] === 'POST' ? $_POST : $_GET;
    $action = $data['action'] ?? '';
    
    error_log("Action: " . $action);
    
    switch ($action) {
        case 'add':
            $productId = (int)($data['product_id'] ?? 0);
            $quantity = (int)($data['quantity'] ?? 1);
            
            error_log("Adding to cart - Product ID: $productId, Quantity: $quantity");
            
            if (addToCart($productId, $quantity)) {
                echo json_encode([
                    'success' => true,
                    'message' => 'Item added to Sacred Cart!',
                    'cartCount' => getCartItemCount(),
                    'cartTotal' => formatPrice(getCartTotal())
                ]);
            } else {
                echo json_encode([
                    'success' => false,
                    'message' => 'Failed to add item to cart'
                ]);
            }
            break;
            
        case 'remove':
            $productId = (int)($data['product_id'] ?? 0);
            
            if (removeFromCart($productId)) {
                echo json_encode([
                    'success' => true,
                    'message' => 'Item removed from cart',
                    'cartCount' => getCartItemCount(),
                    'cartTotal' => formatPrice(getCartTotal())
                ]);
            } else {
                echo json_encode([
                    'success' => false,
                    'message' => 'Failed to remove item'
                ]);
            }
            break;
            
        case 'update':
            $productId = (int)($data['product_id'] ?? 0);
            $quantity = (int)($data['quantity'] ?? 1);
            
            if (updateCartQuantity($productId, $quantity)) {
                echo json_encode([
                    'success' => true,
                    'message' => 'Cart updated',
                    'cartCount' => getCartItemCount(),
                    'cartTotal' => formatPrice(getCartTotal())
                ]);
            } else {
                echo json_encode([
                    'success' => false,
                    'message' => 'Failed to update cart'
                ]);
            }
            break;
            
        case 'get_count':
            echo json_encode([
                'success' => true,
                'cartCount' => getCartItemCount(),
                'cartTotal' => formatPrice(getCartTotal())
            ]);
            break;
            
        default:
            echo json_encode([
                'success' => false,
                'message' => 'Invalid action'
            ]);
    }
} else {
    echo json_encode([
        'success' => false,
        'message' => 'Invalid request method'
    ]);
}
?>
