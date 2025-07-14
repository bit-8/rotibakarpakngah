<?php
session_start();
include 'db_connect.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $order_id = (int)$_POST['order_id'];
    $payment_method = $_POST['payment_method'];
    $user_id = (int)$_SESSION['user_id'];

    // Verify the order belongs to the user
    $stmt = $conn->prepare("SELECT * FROM orders WHERE id = ? AND user_id = ?");
    $stmt->bind_param("ii", $order_id, $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Update the payment method and reset payment status to pending
        $update_stmt = $conn->prepare("UPDATE orders SET payment_method = ?, payment_status = 'pending' WHERE id = ?");
        $update_stmt->bind_param("si", $payment_method, $order_id);
        if ($update_stmt->execute()) {
            $_SESSION['message'] = "Payment method for order #$order_id has been updated.";
        } else {
            $_SESSION['error'] = "Failed to update the payment method.";
        }
    } else {
        $_SESSION['error'] = "Invalid order or you don't have permission to change it.";
    }

    header('Location: payment.php?order_id=' . $order_id);
    exit();
} else {
    header('Location: payment.php?order_id=' . $order_id);
    exit();
}
?>