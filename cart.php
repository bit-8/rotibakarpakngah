<?php 
session_start();
include 'db_connect.php';

$cart_items = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];
$total_price = 0;
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping Cart - Roti Bakar Pak Ngah</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body class="d-flex flex-column min-vh-100">
    <header class="shadow-sm">
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="container">
                <a class="navbar-brand" href="index.php"><img src="img/logo.png" alt="Logo" style="height: 50px;"></a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item"><a class="nav-link" href="pemesan.php">Products</a></li>
                        <li class="nav-item"><a class="nav-link active" href="cart.php">
                            <i class="fas fa-shopping-cart"></i> Cart <span class="badge bg-primary" id="cart-count">0</span>
                        </a></li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    <main class="container my-5 flex-grow-1">
        <h1 class="text-center mb-4">Your Shopping Cart</h1>
        <div id="cart-container">
            <?php if (empty($cart_items)): ?>
                <div class="text-center">
                    <p>Your cart is empty. <a href="pemesan.php">Continue shopping</a>.</p>
                </div>
            <?php else: ?>
                <div class="table-responsive">
                    <table class="table align-middle">
                        <thead>
                            <tr>
                                <th scope="col">Product</th>
                                <th scope="col">Price</th>
                                <th scope="col" style="width: 120px;">Quantity</th>
                                <th scope="col" class="text-end">Total</th>
                                <th scope="col" class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($cart_items as $id => $item): ?>
                                <?php $item_total = $item['price'] * $item['quantity']; $total_price += $item_total; ?>
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <img src="img/<?php echo htmlspecialchars($item['image']); ?>" width="60" class="me-3 rounded">
                                            <span><?php echo htmlspecialchars($item['name']); ?></span>
                                        </div>
                                    </td>
                                    <td>Rp <?php echo number_format($item['price'], 0, ',', '.'); ?></td>
                                    <td>
                                        <input type="number" class="form-control quantity-input" value="<?php echo $item['quantity']; ?>" min="1" data-id="<?php echo $id; ?>">
                                    </td>
                                    <td class="text-end">Rp <?php echo number_format($item_total, 0, ',', '.'); ?></td>
                                    <td class="text-center">
                                        <button class="btn btn-danger btn-sm remove-btn" data-id="<?php echo $id; ?>"><i class="fas fa-trash-alt"></i></button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <div class="row justify-content-center mt-4">
                    <div class="col-12 col-md-8 col-lg-6 col-xl-5">
                        <div class="card shadow-sm">
                            <div class="card-body p-4">
                                <h4 class="card-title text-center">Cart Summary</h4>
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item d-flex justify-content-between px-0">
                                        <span>Subtotal</span>
                                        <strong>Rp <?php echo number_format($total_price, 0, ',', '.'); ?></strong>
                                    </li>
                                </ul>
                                <hr class="my-4">
                                <form action="checkout_handler.php" method="POST">
                                    <div class="payment-methods">
                                        <h5 class="text-center mb-3">Payment Method</h5>
                                        <div class="d-grid gap-3">
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="payment_method" id="qris" value="qris" required>
                                                <label class="form-check-label" for="qris">QRIS</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="payment_method" id="bank_transfer" value="bank_transfer" required>
                                                <label class="form-check-label" for="bank_transfer">Bank Transfer</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="d-grid mt-4">
                                        <button type="submit" class="btn btn-primary btn-lg">Proceed to Checkout</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </div>

        <?php
        // Show recent orders for logged-in users
        if (isset($_SESSION['user_id'])):
            $user_id = (int)$_SESSION['user_id'];
            $stmt = $conn->prepare("SELECT * FROM orders WHERE user_id = ? ORDER BY created_at DESC LIMIT 5");
            $stmt->bind_param("i", $user_id);
            $stmt->execute();
            $recent_orders = $stmt->get_result();
        ?>
            <?php if ($recent_orders->num_rows > 0): ?>
            <hr class="my-5">
            <div id="recent-orders" class="mt-5 bg-white p-3 p-md-4 rounded shadow-sm">
                <h2 class="text-center mb-4">My Recent Orders</h2>
                <div class="table-responsive">
                    <table class="table table-hover d-none d-md-table">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Total</th>
                                <th>Payment Method</th>
                                <th>Payment Status</th>
                                <th>Order Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while($order = $recent_orders->fetch_assoc()): ?>
                                <tr>
                                    <td><?php echo date("d M Y", strtotime($order['created_at'])); ?></td>
                                    <td>Rp <?php echo number_format($order['total_price'], 0, ',', '.'); ?></td>
                                    <td><?php echo htmlspecialchars(ucfirst($order['payment_method'])); ?></td>
                                    <td>
                                        <span class="badge 
                                            <?php echo $order['payment_status'] == 'paid' ? 'bg-success' : ($order['payment_status'] == 'failed' ? 'bg-danger' : 'bg-warning'); ?>">
                                            <?php echo htmlspecialchars(ucfirst($order['payment_status'])); ?>
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge bg-info">
                                            <?php echo htmlspecialchars(ucfirst($order['order_status'])); ?>
                                        </span>
                                    </td>
                                    <td>
                                        <?php if ($order['payment_status'] == 'pending'): ?>
                                            <a href="payment.php?order_id=<?php echo $order['id']; ?>" class="btn btn-primary btn-sm">Pay Now</a>
                                            <a href="cancel_order.php?id=<?php echo $order['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to cancel this order?');">
                                                Cancel
                                            </a>
                                        <?php elseif ($order['payment_status'] == 'paid'): ?>
                                            <a href="payment.php?order_id=<?php echo $order['id']; ?>" class="btn btn-info btn-sm">View Payment</a>
                                        <?php else: ?>
                                            <button class="btn btn-danger btn-sm" disabled>Failed</button>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>

                <div class="d-md-none">
                    <?php
                    // Reset pointer of result set to re-iterate for mobile view
                    $recent_orders->data_seek(0);
                    while($order = $recent_orders->fetch_assoc()):
                    ?>
                    <div class="card order-card">
                        <div class="card-header">
                            Order on <?php echo date("d M Y", strtotime($order['created_at'])); ?>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-6"><strong>Total:</strong></div>
                                <div class="col-6">Rp <?php echo number_format($order['total_price'], 0, ',', '.'); ?></div>
                                <div class="col-6"><strong>Payment:</strong></div>
                                <div class="col-6"><?php echo htmlspecialchars(ucfirst($order['payment_method'])); ?></div>
                                <div class="col-6"><strong>Status:</strong></div>
                                <div class="col-6">
                                    <span class="badge <?php echo $order['payment_status'] == 'paid' ? 'bg-success' : ($order['payment_status'] == 'failed' ? 'bg-danger' : 'bg-warning'); ?>">
                                        <?php echo htmlspecialchars(ucfirst($order['payment_status'])); ?>
                                    </span>
                                </div>
                                <div class="col-6"><strong>Order:</strong></div>
                                <div class="col-6">
                                    <span class="badge bg-info">
                                        <?php echo htmlspecialchars(ucfirst($order['order_status'])); ?>
                                    </span>
                                </div>
                            </div>
                            <hr>
                            <div class="text-center">
                                <?php if ($order['payment_status'] == 'pending'): ?>
                                    <a href="payment.php?order_id=<?php echo $order['id']; ?>" class="btn btn-primary btn-sm">Pay Now</a>
                                    <a href="cancel_order.php?id=<?php echo $order['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to cancel this order?');">
                                        Cancel
                                    </a>
                                <?php elseif ($order['payment_status'] == 'paid'): ?>
                                    <a href="payment.php?order_id=<?php echo $order['id']; ?>" class="btn btn-info btn-sm">View Payment</a>
                                <?php else: ?>
                                    <button class="btn btn-danger btn-sm" disabled>Failed</button>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    <?php endwhile; ?>
                </div>
                <div class="text-center mt-3">
                    <a href="my_orders.php" class="btn btn-outline-primary">View All Orders</a>
                </div>
            </div>
            <?php endif; ?>
        <?php endif; ?>
    </main>

    <footer class="bg-dark text-white mt-auto p-4">
        <div class="container text-center">
            <p>&copy; 2025 Denathan & Lutfi Ibnurahim. All rights reserved.</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="script.js"></script>
</body>
</html>
