<?php
session_start();
include 'db_connect.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST' || empty($_SESSION['cart'])) {
    // Redirect if not a POST request or if cart is empty
    header("Location: cart.php");
    exit();
}

// Get data from session and form
$cart = $_SESSION['cart'];
$payment_method = $_POST['payment_method'];
$user_id = isset($_SESSION['user_id']) ? (int)$_SESSION['user_id'] : null;
$customer_name = isset($_SESSION['username']) ? $_SESSION['username'] : 'Guest';

// Calculate total price and prepare cart details for DB
$total_price = 0;
foreach ($cart as $item) {
    $total_price += $item['price'] * $item['quantity'];
}
$cart_details_json = json_encode($cart);

// Insert the order into the database
$stmt = $conn->prepare(
    "INSERT INTO orders (user_id, customer_name, cart_details, total_price, payment_method) VALUES (?, ?, ?, ?, ?)"
);
$stmt->bind_param("isids", $user_id, $customer_name, $cart_details_json, $total_price, $payment_method);

if ($stmt->execute()) {
    // Get the ID of the order we just inserted
    $order_id = $stmt->insert_id;

    // Clear the shopping cart
    $_SESSION['cart'] = [];

    // Redirect to the payment page
    header("Location: payment.php?order_id=" . $order_id);
    exit();
} else {
    // Handle error
    die("Error placing order: " . $stmt->error);
}

$stmt->close();
$conn->close();
?>
