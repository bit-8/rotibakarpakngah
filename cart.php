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
                <div class="collapse navbar-collapse">
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
                <div class="row justify-content-end">
                    <div class="col-md-5 col-lg-4">
                        <div class="card shadow-sm">
                            <div class="card-body">
                                <h4 class="card-title">Cart Summary</h4>
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item d-flex justify-content-between">
                                        <span>Subtotal</span>
                                        <strong>Rp <?php echo number_format($total_price, 0, ',', '.'); ?></strong>
                                    </li>
                                </ul>
                                <hr>
                                <div class="payment-methods mt-3">
                                    <h5 class="text-center">Payment Method</h5>
                                    <p class="text-muted text-center small">This is a placeholder</p>
                                    <div class="d-grid gap-2">
                                        <button class="btn btn-outline-primary disabled"><i class="fab fa-cc-visa me-2"></i>Credit Card</button>
                                        <button class="btn btn-outline-primary disabled"><i class="fas fa-university me-2"></i>Bank Transfer</button>
                                        <button class="btn btn-outline-primary disabled"><i class="fas fa-money-bill-wave me-2"></i>Cash on Delivery</button>
                                    </div>
                                </div>
                                <div class="d-grid mt-4">
                                    <button class="btn btn-primary btn-lg">Proceed to Checkout</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </main>

    <footer class="bg-dark text-white mt-auto p-4">
        <div class="container text-center">
            <p>&copy; 2025 Denathan & Lutfi Ibnurahim. All rights reserved.</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="script.js"></script>
</body>
</html>
