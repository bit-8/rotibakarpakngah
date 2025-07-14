<?php
session_start();
include 'db_connect.php';

if (!isset($_GET['order_id'])) {
    header("Location: cart.php");
    exit();
}

$order_id = (int)$_GET['order_id'];

// Fetch order details
$stmt = $conn->prepare("SELECT * FROM orders WHERE id = ?");
$stmt->bind_param("i", $order_id);
$stmt->execute();
$result = $stmt->get_result();
$order = $result->fetch_assoc();

if (!$order) {
    die("Order not found.");
}

$cart_details = json_decode($order['cart_details'], true);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment - Order #<?php echo $order['id']; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body class="bg-light">
    <main class="container my-5">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card shadow-sm">
                    <div class="card-header text-center bg-primary text-white">
                        <h2>Complete Your Payment</h2>
                    </div>
                    <div class="card-body p-4">
                        <h4 class="text-center">Order #<?php echo $order['id']; ?></h4>
                        <p class="text-center text-muted">Please complete the payment of <strong>Rp <?php echo number_format($order['total_price'], 0, ',', '.'); ?></strong> using your selected method.</p>
                        
                        <hr>

                        <!-- Payment Instructions -->
                        <div id="payment-instructions">
                            <?php if ($order['payment_method'] === 'qris'): ?>
                                <div class="text-center">
                                    <h5>Scan QRIS Code</h5>
                                    <p>Use your mobile banking or e-wallet app to scan the code below.</p>
                                    <img src="img/qris.jpeg" alt="QRIS" class="img-fluid" style="max-width: 250px;">
                                </div>
                            <?php elseif ($order['payment_method'] === 'bank_transfer'): ?>
                                <div>
                                    <h5 class="text-center">Bank Transfer</h5>
                                    <p class="text-center">Transfer to one of the following accounts:</p>
                                    <ul class="list-group">
                                        <li class="list-group-item"><strong>BCA:</strong> 312-111-921 (a/n Roti Bakar Pak Ngah)</li>
                                        <li class="list-group-item"><strong>Mandiri:</strong> 021-421-012 (a/n Roti Bakar Pak Ngah)</li>
                                        <li class="list-group-item"><strong>BNI:</strong> 112-233-4455 (a/n Roti Bakar Pak Ngah)</li>
                                    </ul>
                                </div>
                            <?php endif; ?>
                        </div>

                        <hr>

                        <!-- Order Summary -->
                        <h5>Order Summary</h5>
                        <ul class="list-group mb-3">
                            <?php foreach ($cart_details as $item): ?>
                                <li class="list-group-item d-flex justify-content-between lh-sm">
                                    <div>
                                        <h6 class="my-0"><?php echo htmlspecialchars($item['name']); ?></h6>
                                        <small class="text-muted">Quantity: <?php echo $item['quantity']; ?></small>
                                    </div>
                                    <span class="text-muted">Rp <?php echo number_format($item['price'] * $item['quantity'], 0, ',', '.'); ?></span>
                                </li>
                            <?php endforeach; ?>
                            <li class="list-group-item d-flex justify-content-between">
                                <span>Total (IDR)</span>
                                <strong>Rp <?php echo number_format($order['total_price'], 0, ',', '.'); ?></strong>
                            </li>
                        </ul>

                        <div class="text-center mt-4">
                            <p>After payment, your order status will be updated by our team.</p>
                            <a href="cart.php" class="btn btn-secondary">Back to Cart</a>
                            <?php if ($order['payment_status'] == 'pending'): ?>
                                <button class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#changePaymentModal">
                                    Change Payment Method
                                </button>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Change Payment Method Modal -->
        <div class="modal fade" id="changePaymentModal" tabindex="-1" aria-labelledby="changePaymentModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="changePaymentModalLabel">Change Payment Method</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="update_payment_method.php" method="POST">
                            <input type="hidden" name="order_id" value="<?php echo $order['id']; ?>">
                            <div class="payment-methods mt-3">
                                <h5 class="text-center">Select New Payment Method</h5>
                                <div class="d-grid gap-2">
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
                                <button type="submit" class="btn btn-primary">Update Payment</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
