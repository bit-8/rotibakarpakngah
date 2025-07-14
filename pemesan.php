<?php 
session_start(); 
include 'db_connect.php';

// Fetch all products
$products_result = $conn->query("SELECT * FROM products ORDER BY created_at DESC");
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pemesanan - Roti Bakar Pak Ngah</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lato:wght@400;700&family=Montserrat:wght@700&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="pemesan.css">
    <style>
        .product-card {
            transition: transform .2s;
            border: 1px solid #ddd;
            border-radius: 10px;
            overflow: hidden;
        }
        .product-card:hover {
            transform: scale(1.05);
            box-shadow: 0 4px 20px rgba(0,0,0,0.1);
        }
        .product-img {
            height: 200px;
            object-fit: cover;
        }
        .product-price {
            font-weight: bold;
            color: #007bff;
        }
    </style>
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
                    <ul class="navbar-nav ms-auto align-items-center">
                    <li class="nav-item"><a class="nav-link" href="cart.php">
                    <i class="fas fa-shopping-cart"></i> Cart <span class="badge bg-primary" id="cart-count">0</span>
                    </a></li>
                        <li class="nav-item"><a class="nav-link" href="foto.php">Gallery</a></li>
                        <li class="nav-item"><a class="nav-link" href="about.php">About</a></li>
                        <li class="nav-item"><a class="nav-link" href="lainnya.php">More</a></li>
                        <?php if (isset($_SESSION['user_id'])): ?>
                            <li class="nav-item"><a class="nav-link" href="my_orders.php">My Orders</a></li>
                            <?php if ($_SESSION['role'] === 'admin'): ?>
                                <li class="nav-item"><a class="nav-link" href="admin_dashboard.php">Dashboard</a></li>
                            <?php endif; ?>
                            <li class="nav-item"><span class="nav-link">Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?></span></li>
                            <li class="nav-item"><a class="nav-link" href="logout.php">Logout</a></li>
                        <?php else: ?>
                            <li class="nav-item"><a class="nav-link" href="login.php">Login</a></li>
                            <li class="nav-item"><a class="nav-link" href="signup.php">Sign Up</a></li>
                        <?php endif; ?>
                        <li class="nav-item"><a class="btn btn-primary ms-lg-3 active" href="pemesan.php" aria-current="page">Order Now</a></li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    <main class="container my-5 flex-grow-1">
        <div class="text-center mb-5">
            <h2 class="section-title">Our Products</h2>
            <p class="text-muted">Choose your favorites.</p>
        </div>
        
        <div class="row gy-4">
            <?php if ($products_result && $products_result->num_rows > 0): ?>
                <?php while($product = $products_result->fetch_assoc()): ?>
                <div class="col-lg-4 col-md-6">
                    <div class="card h-100 shadow-sm border-0">
                        <img src="img/<?php echo htmlspecialchars($product['image']); ?>" class="card-img-top" alt="<?php echo htmlspecialchars($product['name']); ?>" style="height: 220px; object-fit: cover;">
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title"><?php echo htmlspecialchars($product['name']); ?></h5>
                            <p class="card-text text-muted flex-grow-1"><?php echo htmlspecialchars($product['description']); ?></p>
                            <p class="h5 text-primary fw-bold">Rp <?php echo number_format($product['price'], 0, ',', '.'); ?></p>
                            <?php if (isset($_SESSION['user_id'])): ?>
                                <form class="add-to-cart-form mt-3">
                                    <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
                                    <div class="input-group">
                                        <input type="number" class="form-control" name="quantity" value="1" min="1" aria-label="Quantity">
                                        <button class="btn btn-primary" type="submit">
                                            <i class="fas fa-cart-plus me-2"></i>Add
                                        </button>
                                    </div>
                                </form>
                            <?php else: ?>
                                <a href="signup.php?redirect=pemesan" class="btn btn-primary mt-3">
                                    <i class="fas fa-cart-plus me-2"></i>Add to Cart
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                <?php endwhile; ?>
            <?php else: ?>
                <div class="col-12">
                    <p class="text-center fs-5 text-muted">No products available at the moment. Please check back later.</p>
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
