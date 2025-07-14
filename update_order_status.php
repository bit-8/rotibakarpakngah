<?php
session_start();
include 'db_connect.php';

// Admin access check
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $order_id = (int)$_POST['order_id'];
    $payment_status = $_POST['payment_status'];

    // Validate status
    $allowed_statuses = ['pending', 'paid', 'failed'];
    if (in_array($payment_status, $allowed_statuses)) {
        $stmt = $conn->prepare("UPDATE orders SET payment_status = ? WHERE id = ?");
        $stmt->bind_param("si", $payment_status, $order_id);
        
        if ($stmt->execute()) {
            // Success
            $_SESSION['message'] = "Order #$order_id status updated successfully.";
        } else {
            // Failure
            $_SESSION['message'] = "Error updating order status.";
        }
        $stmt->close();
    } else {
        $_SESSION['message'] = "Invalid status value.";
    }
}

header("Location: admin_orders.php");
exit();
?>
