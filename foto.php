<?php session_start(); ?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gallery - Roti Bakar Pak Ngah</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lato:wght@400;700&family=Montserrat:wght@700&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="foto.css">
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
                        <li class="nav-item"><a class="nav-link active" href="foto.php">Gallery</a></li>
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

    <main>
        <!-- Page Header -->
        <section class="page-header text-center">
            <div class="container">
                <h1 class="page-title">Galeri Rasa</h1>
                <p class="lead">Momen-momen hangat bersama Roti Bakar Pak Ngah.</p>
            </div>
        </section>

        <!-- Gallery Section -->
        <section class="container py-5">
            <div class="row" id="gallery-grid">
                <!-- Gallery items will be injected here by JavaScript -->
            </div>
        </section>
    </main>

    <footer class="bg-dark text-white mt-4 p-4">
        <div class="container">
            <div class="row">
                <div class="col-md-4 mb-3">
                    <h4>Roti Bakar Pak Ngah</h4>
                    <p class="text-white-50">Menjaga tradisi rasa sejak 1995.</p>
                </div>
                <div class="col-md-4 mb-3">
                    <h4>Navigasi</h4>
                    <ul class="list-unstyled">
                        <li><a href="index.php" class="text-white-50 text-decoration-none">Home</a></li>
                        <li><a href="about.php" class="text-white-50 text-decoration-none">About</a></li>
                        <li><a href="pemesan.php" class="text-white-50 text-decoration-none">Order</a></li>
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
        document.addEventListener("DOMContentLoaded", function() {
            const galleryItems = [
                { img: 'img/founder.jpeg', title: 'Sang Perintis', desc: 'Pak Ngah, pendiri usaha.' },
                { img: 'img/roti_isi_coklat_seres.jpg', title: 'Roti cokelat', desc: 'Awal hari yang sempurna.' },
                { img: 'img/R2.jpeg', title: 'Roti plain', desc: 'Selalu lebih dari cukup.' },
                { img: 'img/roti_sosis.jpg', title: 'Roti sosis', desc: 'Dibuat dengan hati.' },
                { img: 'img/R5.jpeg', title: 'Surga Roti', desc: 'Kelezatan di setiap gigitan.' },
                { img: 'img/R6.jpeg', title: 'Hangat & Segar', desc: 'Langsung dari panggangan.' },
                { img: 'img/roti_abon.jpg', title: 'Roti abon', desc: 'Menemani setiap momen.' },
                { img: 'img/roti_srikaya.jpg', title: 'Roti srikaya', desc: 'Rasa yang tak lekang oleh waktu.' }
            ];

            const galleryGrid = document.getElementById('gallery-grid');

            // Populate image cards
            galleryItems.forEach(item => {
                const col = document.createElement('div');
                col.className = 'col-md-6 col-lg-4';
                
                const galleryItem = document.createElement('div');
                galleryItem.className = 'gallery-item';
                
                galleryItem.innerHTML = `
                    <img src="${item.img}" alt="${item.title}" class="img-fluid">
                    <div class="gallery-caption">
                        <h5>${item.title}</h5>
                        <p>${item.desc}</p>
                    </div>
                `;
                col.appendChild(galleryItem);
                galleryGrid.appendChild(col);
            });

            // Add a text card if the grid is unbalanced
            if (galleryItems.length % 3 !== 0) {
                const col = document.createElement('div');
                col.className = 'col-md-6 col-lg-4';

                const textItem = document.createElement('a');
                textItem.href = 'pemesan.php';
                textItem.className = 'gallery-item gallery-item--text text-decoration-none';
                
                textItem.innerHTML = `
                    <div class="icon"><i class="fas fa-shopping-basket"></i></div>
                    <h5>Ingin Mencoba?</h5>
                    <p>Kelezatan roti kami hanya beberapa klik saja. Pesan sekarang dan nikmati kehangatannya di rumah Anda!</p>
                `;
                col.appendChild(textItem);
                galleryGrid.appendChild(col);
            }


            // Animation observer
            const animatedElements = document.querySelectorAll('.gallery-item');
            const observer = new IntersectionObserver((entries) => {
                entries.forEach((entry, index) => {
                    if (entry.isIntersecting) {
                        setTimeout(() => {
                            entry.target.classList.add('is-visible');
                        }, index * 100);
                        observer.unobserve(entry.target);
                    }
                });
            }, {
                threshold: 0.1
            });

            animatedElements.forEach(el => {
                observer.observe(el);
            });
        });
    </script>
</body>
</html>
