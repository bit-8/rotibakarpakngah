<?php
session_start();
include 'db_connect.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

if (isset($_GET['id'])) {
    $order_id = (int)$_GET['id'];
    $user_id = (int)$_SESSION['user_id'];

    // Verify the order belongs to the user and is pending
    $stmt = $conn->prepare("SELECT * FROM orders WHERE id = ? AND user_id = ? AND payment_status = 'pending'");
    $stmt->bind_param("ii", $order_id, $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Update the order status to 'cancelled'
        $update_stmt = $conn->prepare("UPDATE orders SET order_status = 'cancelled' WHERE id = ?");
        $update_stmt->bind_param("i", $order_id);
        if ($update_stmt->execute()) {
            $_SESSION['message'] = "Order #$order_id has been cancelled.";
        } else {
            $_SESSION['error'] = "Failed to cancel the order.";
        }
    } else {
        $_SESSION['error'] = "Invalid order or you don't have permission to cancel it.";
    }

    header('Location: cart.php');
    exit();
} else {
    header('Location: cart.php');
    exit();
}
?>