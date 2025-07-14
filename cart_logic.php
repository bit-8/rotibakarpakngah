<?php
session_start();
include 'db_connect.php';

// Initialize cart if it doesn't exist
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

$response = ['status' => 'error', 'message' => 'Invalid request'];

// Handle Add to Cart
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'add') {
    $product_id = (int)$_POST['product_id'];
    $quantity = (int)$_POST['quantity'];

    if ($quantity > 0 && $product_id > 0) {
        // Fetch product details from DB to ensure data integrity
        $stmt = $conn->prepare("SELECT name, price, image FROM products WHERE id = ?");
        $stmt->bind_param("i", $product_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($product = $result->fetch_assoc()) {
            if (isset($_SESSION['cart'][$product_id])) {
                // If product is already in cart, update quantity
                $_SESSION['cart'][$product_id]['quantity'] += $quantity;
            } else {
                // If new, add to cart
                $_SESSION['cart'][$product_id] = [
                    'name' => $product['name'],
                    'price' => $product['price'],
                    'image' => $product['image'],
                    'quantity' => $quantity
                ];
            }
            $response = ['status' => 'success', 'message' => 'Product added to cart.'];
        } else {
            $response['message'] = 'Product not found.';
        }
        $stmt->close();
    } else {
        $response['message'] = 'Invalid product ID or quantity.';
    }
}

// Handle Update Cart
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'update') {
    $product_id = (int)$_POST['product_id'];
    $quantity = (int)$_POST['quantity'];

    if (isset($_SESSION['cart'][$product_id]) && $quantity > 0) {
        $_SESSION['cart'][$product_id]['quantity'] = $quantity;
        $response = ['status' => 'success', 'message' => 'Cart updated.'];
    } else if (isset($_SESSION['cart'][$product_id]) && $quantity <= 0) {
        unset($_SESSION['cart'][$product_id]);
        $response = ['status' => 'success', 'message' => 'Product removed from cart.'];
    }
    else {
        $response['message'] = 'Invalid product or quantity for update.';
    }
}

// Handle Remove from Cart
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'remove') {
    $product_id = (int)$_POST['product_id'];

    if (isset($_SESSION['cart'][$product_id])) {
        unset($_SESSION['cart'][$product_id]);
        $response = ['status' => 'success', 'message' => 'Product removed from cart.'];
    } else {
        $response['message'] = 'Product not found in cart.';
    }
}

// Get Cart Count
if (isset($_GET['action']) && $_GET['action'] === 'count') {
    $count = 0;
    foreach ($_SESSION['cart'] as $item) {
        $count += $item['quantity'];
    }
    $response = ['status' => 'success', 'count' => $count];
}


header('Content-Type: application/json');
echo json_encode($response);
$conn->close();
?>
