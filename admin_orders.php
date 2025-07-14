<?php
session_start();
include 'db_connect.php';

// Admin access check
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

// Fetch all orders
$orders_result = $conn->query("SELECT * FROM orders ORDER BY created_at DESC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - All Orders</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header class="shadow-sm">
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="container">
                <a class="navbar-brand" href="admin_dashboard.php">Admin Panel</a>
                <div class="collapse navbar-collapse">
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item"><a class="nav-link" href="admin_prod.php">Manage Products</a></li>
                        <li class="nav-item"><a class="nav-link active" href="admin_orders.php">View Orders</a></li>
                        <li class="nav-item"><a class="nav-link" href="logout.php">Logout</a></li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    <main class="container my-5">
        <h1 class="text-center mb-4">All Customer Orders</h1>

        <?php if (isset($_SESSION['message'])): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <?php echo $_SESSION['message']; unset($_SESSION['message']); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>Order ID</th>
                        <th>Customer</th>
                        <th>Total Price</th>
                        <th>Payment Method</th>
                        <th>Payment Status</th>
                        <th>Order Status</th>
                        <th>Date</th>
                        <th>Details</th>
                        <th>Update Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($orders_result && $orders_result->num_rows > 0): ?>
                        <?php while($order = $orders_result->fetch_assoc()): ?>
                            <tr>
                                <td><?php echo $order['id']; ?></td>
                                <td><?php echo htmlspecialchars($order['customer_name']); ?></td>
                                <td>Rp <?php echo number_format($order['total_price'], 0, ',', '.'); ?></td>
                                <td><?php echo htmlspecialchars($order['payment_method']); ?></td>
                                <td><span class="badge bg-warning"><?php echo htmlspecialchars($order['payment_status']); ?></span></td>
                                <td><span class="badge bg-info"><?php echo htmlspecialchars($order['order_status']); ?></span></td>
                                <td><?php echo date("d M Y, H:i", strtotime($order['created_at'])); ?></td>
                                <td><button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#orderModal<?php echo $order['id']; ?>">View</button></td>
                                <td>
                                    <form action="update_order_status.php" method="POST" class="d-flex">
                                        <input type="hidden" name="order_id" value="<?php echo $order['id']; ?>">
                                        <select name="payment_status" class="form-select form-select-sm me-2">
                                            <option value="pending" <?php if($order['payment_status'] == 'pending') echo 'selected'; ?>>Pending</option>
                                            <option value="paid" <?php if($order['payment_status'] == 'paid') echo 'selected'; ?>>Paid</option>
                                            <option value="failed" <?php if($order['payment_status'] == 'failed') echo 'selected'; ?>>Failed</option>
                                        </select>
                                        <button type="submit" class="btn btn-sm btn-success">Save</button>
                                    </form>
                                </td>
                            </tr>

                            <!-- Modal for order details -->
                            <div class="modal fade" id="orderModal<?php echo $order['id']; ?>" tabindex="-1">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Order Details #<?php echo $order['id']; ?></h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body">
                                            <?php $cart = json_decode($order['cart_details'], true); ?>
                                            <ul class="list-group">
                                                <?php foreach($cart as $item): ?>
                                                    <li class="list-group-item">
                                                        <?php echo htmlspecialchars($item['name']); ?> (x<?php echo $item['quantity']; ?>)
                                                    </li>
                                                <?php endforeach; ?>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr><td colspan="9" class="text-center">No orders found.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </main>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
