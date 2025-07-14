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
<body>
    <header class="shadow-sm">
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="container">
                <a class="navbar-brand" href="index.php">
                    <img src="img/logo.png" alt="Logo" style="height: 50px;">
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item"><a class="nav-link" href="foto.php">Gallery</a></li>
                        <li class="nav-item"><a class="nav-link" href="about.php">About</a></li>
                        <li class="nav-item"><a class="nav-link" href="lainnya.php">More</a></li>
                        <?php if (isset($_SESSION['user_id'])): ?>
                            <?php if ($_SESSION['role'] === 'admin'): ?>
                                <li class="nav-item"><a class="nav-link" href="admin_dashboard.php">Dashboard</a></li>
                            <?php endif; ?>
                            <li class="nav-item"><span class="nav-link">Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?></span></li>
                            <li class="nav-item"><a class="nav-link" href="logout.php">Logout</a></li>
                        <?php else: ?>
                            <li class="nav-item"><a class="nav-link" href="login.php">Login</a></li>
                            <li class="nav-item"><a class="nav-link" href="signup.php">Sign Up</a></li>
                        <?php endif; ?>
                        <li class="nav-item"><a class="btn btn-primary ms-lg-3" href="pemesan.php">Order Now</a></li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    <main class="container my-5">
        <div class="text-center mb-5">
            <h1 class="form-title">Our Products</h1>
            <p class="form-subtitle text-muted">Choose your favorite Roti Bakar.</p>
        </div>
        
        <div class="row">
            <?php if ($products_result && $products_result->num_rows > 0): ?>
                <?php while($product = $products_result->fetch_assoc()): ?>
                <div class="col-md-4 mb-4">
                    <div class="card product-card h-100">
                        <img src="img/<?php echo htmlspecialchars($product['image']); ?>" class="card-img-top product-img" alt="<?php echo htmlspecialchars($product['name']); ?>">
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title"><?php echo htmlspecialchars($product['name']); ?></h5>
                            <p class="card-text flex-grow-1"><?php echo htmlspecialchars($product['description']); ?></p>
                            <p class="card-text product-price">Rp <?php echo number_format($product['price'], 2, ',', '.'); ?></p>
                            <a href="https://wa.me/62895334372186?text=Saya%20tertarik%20untuk%20memesan%20<?php echo urlencode($product['name']); ?>" class="btn btn-primary mt-auto">Order via WhatsApp</a>
                        </div>
                    </div>
                </div>
                <?php endwhile; ?>
            <?php else: ?>
                <div class="col">
                    <p class="text-center">No products available at the moment. Please check back later.</p>
                </div>
            <?php endif; ?>
        </div>
    </main>

    <!-- WhatsApp Chat -->
    <div class="whatsapp-fab" id="whatsappCircle">
        <i class="fab fa-whatsapp"></i>
    </div>
    <div class="whatsapp-chat-box" id="profileBox">
        <div class="chat-header">
            <img src="img/lutfi.jpg" alt="Profile" class="chat-avatar">
            <div class="chat-info">
                <h6 class="chat-name">Lutfi Ibnurahim</h6>
                <p class="chat-status">Online</p>
            </div>
        </div>
        <div class="chat-body">
            <p>Ada yang bisa kami bantu? Jangan ragu untuk bertanya!</p>
        </div>
        <a href="https://wa.me/62895334372186" target="_blank" class="chat-button">
            Chat Sekarang
        </a>
    </div>

    <footer class="bg-dark text-white mt-5 p-4">
        <div class="container">
            <div class="row">
                <div class="col-md-4 mb-3">
                    <h4>Roti Bakar Pak Ngah</h4>
                    <p class="text-white-50">Menjaga tradisi rasa sejak 1995.</p>
                </div>
                <div class="col-md-4 mb-3">
                    <h4>Navigasi</h4>
                    <ul class="list-unstyled">
                        <li><a href="foto.php" class="text-white-50 text-decoration-none">Gallery</a></li>
                        <li><a href="about.php" class="text-white-50 text-decoration-none">About</a></li>
                        <li><a href="lainnya.php" class="text-white-50 text-decoration-none">More</a></li>
                    </ul>
                </div>
                <div class="col-md-4 mb-3">
                    <h4>Hubungi Kami</h4>
                    <a href="https://www.instagram.com/natvhan__?igsh=bml6eGp0OWh6Z3N5" target="_blank" class="text-white-50 text-decoration-none me-3">Instagram</a>
                    <a href="https://www.facebook.com/profile.php?id=61552028236238&mibextid=ZbWKwL" target="_blank" class="text-white-50 text-decoration-none me-3">Facebook</a>
                    <a href="mailto:231220024@unumuhpnk.ac.id" class="text-white-50 text-decoration-none">Email</a>
                </div>
            </div>
            <div class="text-center text-white-50 pt-3 border-top border-secondary">
                <p>&copy; 2025 Denathan & Lutfi Ibnurahim. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script>
        const whatsappCircle = document.getElementById('whatsappCircle');
        const profileBox = document.getElementById('profileBox');
        whatsappCircle.addEventListener('click', function () {
            profileBox.classList.toggle('active');
        });
    </script>
</body>
</html>