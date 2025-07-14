<?php
session_start();
include 'db_connect.php';

// Admin access check
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $order_ids = isset($_POST['order_ids']) ? (array)$_POST['order_ids'] : [];
    $payment_status = $_POST['payment_status'];
    $order_status = $_POST['order_status'];

    if (empty($order_ids)) {
        $_SESSION['message'] = "No orders selected for update.";
        header("Location: admin_orders.php");
        exit();
    }

    if (empty($payment_status) && empty($order_status)) {
        $_SESSION['message'] = "No status selected to update.";
        header("Location: admin_orders.php");
        exit();
    }

    // Build the query dynamically based on which statuses are being updated
    $query_parts = [];
    $params = [];
    $types = "";

    if (!empty($payment_status)) {
        $query_parts[] = "payment_status = ?";
        $params[] = $payment_status;
        $types .= "s";
    }
    if (!empty($order_status)) {
        $query_parts[] = "order_status = ?";
        $params[] = $order_status;
        $types .= "s";
    }

    // Create placeholders for the IN clause
    $id_placeholders = implode(',', array_fill(0, count($order_ids), '?'));
    $types .= str_repeat('i', count($order_ids));
    
    foreach ($order_ids as $id) {
        $params[] = (int)$id;
    }

    $sql = "UPDATE orders SET " . implode(', ', $query_parts) . " WHERE id IN (" . $id_placeholders . ")";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param($types, ...$params);

    if ($stmt->execute()) {
        $count = $stmt->affected_rows;
        $_SESSION['message'] = "$count order(s) updated successfully.";
    } else {
        $_SESSION['message'] = "Error updating orders: " . $conn->error;
    }
    $stmt->close();
}

header("Location: admin_orders.php");
exit();
?>
