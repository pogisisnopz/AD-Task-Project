<?php
// Simple standalone cart handler for testing
error_reporting(E_ALL);
ini_set('display_errors', 0); // Don't show errors in JSON response

// Start session
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Initialize cart
if (!isset($_SESSION['simple_cart'])) {
    $_SESSION['simple_cart'] = [];
}

header('Content-Type: application/json');

// Debug what we're receiving
$method = $_SERVER['REQUEST_METHOD'] ?? 'UNKNOWN';
$postData = $_POST;
$getData = $_GET;
$rawInput = file_get_contents('php://input');

// Get request data - try multiple methods
$data = [];
if ($method === 'POST') {
    // Try POST data first
    if (!empty($_POST)) {
        $data = $_POST;
    } else {
        // Try to parse raw input
        parse_str($rawInput, $data);
    }
} else {
    $data = $_GET;
}

$action = $data['action'] ?? '';

// Simple products array
$products = [
    1 => ['id' => 1, 'name' => 'Sacred Healing Elixir', 'price' => 299.99],
    2 => ['id' => 2, 'name' => 'Diagnostic Tool', 'price' => 1999.99],
    3 => ['id' => 3, 'name' => 'Combat Stim', 'price' => 599.99]
];

// If no action, return debug info
if (empty($action)) {
    echo json_encode([
        'success' => false,
        'message' => 'No action received',
        'debug' => [
            'method' => $method,
            'postData' => $postData,
            'getData' => $getData,
            'rawInput' => $rawInput,
            'parsedData' => $data
        ]
    ]);
    exit;
}

try {
    switch ($action) {
        case 'add':
            $productId = (int)($data['product_id'] ?? 0);
            $quantity = (int)($data['quantity'] ?? 1);
            
            if (isset($products[$productId])) {
                if (isset($_SESSION['simple_cart'][$productId])) {
                    $_SESSION['simple_cart'][$productId]['quantity'] += $quantity;
                } else {
                    $_SESSION['simple_cart'][$productId] = [
                        'product' => $products[$productId],
                        'quantity' => $quantity
                    ];
                }
                
                // Calculate totals
                $totalItems = 0;
                $totalPrice = 0;
                foreach ($_SESSION['simple_cart'] as $item) {
                    $totalItems += $item['quantity'];
                    $totalPrice += $item['product']['price'] * $item['quantity'];
                }
                
                echo json_encode([
                    'success' => true,
                    'message' => 'Item added to cart!',
                    'cartCount' => $totalItems,
                    'cartTotal' => '₱' . number_format($totalPrice, 2)
                ]);
            } else {
                echo json_encode(['success' => false, 'message' => 'Product not found']);
            }
            break;
            
        case 'get_count':
            $totalItems = 0;
            $totalPrice = 0;
            foreach ($_SESSION['simple_cart'] as $item) {
                $totalItems += $item['quantity'];
                $totalPrice += $item['product']['price'] * $item['quantity'];
            }
            
            echo json_encode([
                'success' => true,
                'cartCount' => $totalItems,
                'cartTotal' => '₱' . number_format($totalPrice, 2)
            ]);
            break;
            
        case 'remove':
            $productId = (int)($data['product_id'] ?? 0);
            if (isset($_SESSION['simple_cart'][$productId])) {
                unset($_SESSION['simple_cart'][$productId]);
            }
            
            $totalItems = 0;
            $totalPrice = 0;
            foreach ($_SESSION['simple_cart'] as $item) {
                $totalItems += $item['quantity'];
                $totalPrice += $item['product']['price'] * $item['quantity'];
            }
            
            echo json_encode([
                'success' => true,
                'message' => 'Item removed',
                'cartCount' => $totalItems,
                'cartTotal' => '₱' . number_format($totalPrice, 2)
            ]);
            break;
            
        default:
            echo json_encode([
                'success' => false, 
                'message' => "Invalid action: '$action'",
                'debug' => [
                    'method' => $method,
                    'action' => $action,
                    'allData' => $data
                ]
            ]);
    }
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => 'Server error: ' . $e->getMessage()]);
}
?>
