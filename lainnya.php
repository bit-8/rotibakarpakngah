<?php session_start(); ?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Informasi Lainnya - Roti Bakar Pak Ngah</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" xintegrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lato:wght@400;700&family=Montserrat:wght@700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="lainnya.css">
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
                        <li class="nav-item"><a class="nav-link active" href="lainnya.php">More</a></li>
                        <?php if (isset($_SESSION['user_id'])): ?>
                            <?php if ($_SESSION['role'] === 'admin'): ?>
                                <li class="nav-item"><a class="nav-link" href="admin_dashboard_extended.php">Dashboard</a></li>
                                <li class="nav-item"><a class="nav-link" href="admin_dashboard_extended.php">Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?></a></li>
                            <?php else: ?>
                                <li class="nav-item"><span class="nav-link">Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?></span></li>
                            <?php endif; ?>
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
                <h1 class="page-title fade-in-up">Temukan Kami</h1>
                <p class="page-subtitle lead text-muted fade-in-up" style="transition-delay: 0.2s;">Informasi lokasi, kontak, dan detail lainnya.</p>
            </div>
        </section>

        <!-- Location Section -->
        <section class="py-5">
            <div class="container">
                <div class="row g-4 align-items-stretch">
                    <div class="col-lg-6 fade-in-up">
                        <div class="info-card">
                            <h3 class="mb-3">Kunjungi Kedai Kami</h3>
                            <p><strong>Alamat:</strong><br>Jalan Tanjung Raya II, Jalan Tani, Kelurahan Saigon, Kecamatan Pontianak Timur, Kota Pontianak, Kalimantan Barat 78132.</p>
                            <p><strong>Jam Operasional:</strong></p>
                            <ul>
                                <li>Senin - Jumat: 01.00 - 21.00 WIB</li>
                                <li>Sabtu & Minggu: Tutup</li>
                            </ul>
                            <p><strong>Kontak Pemesanan:</strong><br>Telepon: 0858-2266-6497</p>
                            <p class="mt-3">Kami selalu siap menyambut Anda dengan aroma roti bakar yang hangat dan pelayanan yang ramah.</p>
                        </div>
                    </div>
                    <div class="col-lg-6 fade-in-up" style="transition-delay: 0.3s;">
                        <div class="map-container">
                            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3989.81734076448!2d109.3698196759068!3d-0.0401495999441864!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e1d596315fdd673%3A0x407cad81723c258a!2sRoti%20Bakar%20pakngah!5e0!3m2!1sid!2sid!4v1625825169468!5m2!1sid!2sid" width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Quality & Video Section -->
        <section class="py-5 bg-light">
            <div class="container">
                <div class="row g-4 align-items-center">
                    <div class="col-lg-6 order-lg-2 fade-in-up">
                        <h2 class="section-title">Kualitas Tanpa Kompromi</h2>
                        <p class="text-muted">Roti kami dibuat tanpa bahan pengawet, sehingga aman dikonsumsi oleh semua kalangan. Proses produksi higienis memastikan setiap roti tetap segar dan lezat. Kemasan toples transparan menjaga kualitasnya hingga sampai ke tangan Anda, dengan setiap toples berisi 20 buah roti yang siap dinikmati.</p>
                    </div>
                    <div class="col-lg-6 order-lg-1 fade-in-up" style="transition-delay: 0.3s;">
                        <div class="video-container ratio ratio-16x9">
                            <iframe src="https://www.youtube.com/embed/sYeyi-ho9T4" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

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
                        <li><a href="pemesan.php" class="text-white-50 text-decoration-none">Order</a></li>
                        <li><a href="about.php" class="text-white-50 text-decoration-none">About</a></li>
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

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" xintegrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const animatedElements = document.querySelectorAll('.fade-in-up');

            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('is-visible');
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
