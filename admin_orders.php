<?php
session_start();
include 'db_connect.php';

// Admin access check
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

// Fetch all orders, sorted by customer name then by date
$orders_result = $conn->query("SELECT * FROM orders ORDER BY customer_name, created_at DESC");
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

        <form action="update_order_status.php" method="POST">
            <div class="card shadow-sm mb-4">
                <div class="card-body d-flex flex-wrap justify-content-end align-items-center">
                    <span class="me-3">For selected orders:</span>
                    <div class="me-3">
                        <label for="bulk_payment_status" class="visually-hidden">Payment Status</label>
                        <select name="payment_status" id="bulk_payment_status" class="form-select form-select-sm">
                            <option value="">-- Payment Status --</option>
                            <option value="pending">Pending</option>
                            <option value="paid">Paid</option>
                            <option value="failed">Failed</option>
                        </select>
                    </div>
                    <div class="me-3">
                        <label for="bulk_order_status" class="visually-hidden">Order Status</label>
                        <select name="order_status" id="bulk_order_status" class="form-select form-select-sm">
                            <option value="">-- Order Status --</option>
                            <option value="processing">Processing</option>
                            <option value="shipped">Shipped</option>
                            <option value="completed">Completed</option>
                            <option value="cancelled">Cancelled</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary btn-sm">Update Selected</button>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-striped table-hover align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th><input type="checkbox" id="select-all"></th>
                            <th>Order ID</th>
                            <th>Customer</th>
                            <th>Total Price</th>
                            <th>Payment Status</th>
                            <th>Order Status</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $current_customer = null;
                        if ($orders_result && $orders_result->num_rows > 0):
                            while($order = $orders_result->fetch_assoc()):
                                if ($current_customer !== $order['customer_name']):
                                    $current_customer = $order['customer_name'];
                        ?>
                                    <tr class="table-group-divider">
                                        <td colspan="7" class="bg-light fw-bold">
                                            Customer: <?php echo htmlspecialchars($current_customer); ?>
                                        </td>
                                    </tr>
                        <?php 
                                endif;
                        ?>
                                <tr>
                                    <td><input type="checkbox" name="order_ids[]" value="<?php echo $order['id']; ?>" class="order-checkbox"></td>
                                    <td><?php echo $order['id']; ?></td>
                                    <td><?php echo htmlspecialchars($order['customer_name']); ?></td>
                                    <td>Rp <?php echo number_format($order['total_price'], 0, ',', '.'); ?></td>
                                    <td><span class="badge bg-<?php echo $order['payment_status'] == 'paid' ? 'success' : 'warning'; ?>"><?php echo htmlspecialchars($order['payment_status']); ?></span></td>
                                    <td><span class="badge bg-info"><?php echo htmlspecialchars($order['order_status']); ?></span></td>
                                    <td><?php echo date("d M Y, H:i", strtotime($order['created_at'])); ?></td>
                                </tr>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr><td colspan="7" class="text-center">No orders found.</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </form>
    </main>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.getElementById('select-all').addEventListener('click', function(event) {
            const checkboxes = document.querySelectorAll('.order-checkbox');
            checkboxes.forEach(checkbox => {
                checkbox.checked = event.target.checked;
            });
        });
    </script>
</body>
</html>