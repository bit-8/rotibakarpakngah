<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us - Roti Bakar Pak Ngah</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lato:wght@400;700&family=Montserrat:wght@700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="about.css">
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
                        <li class="nav-item"><a class="nav-link active" href="about.php">About</a></li>
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
                <h1 class="page-title fade-in-up">Cerita Kami</h1>
                <p class="page-subtitle lead text-muted fade-in-up" style="transition-delay: 0.2s;">Mengenal lebih dekat perjalanan Roti Bakar Pak Ngah, sepotong demi sepotong.</p>
            </div>
        </section>

        <!-- Introduction Section -->
        <section class="py-5">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-6 fade-in-up">
                        <h2 class="section-title">Awal Mula Sebuah Rasa</h2>
                        <p>Roti Bakar Pak Ngah adalah merek lokal yang lahir dari kesederhanaan dan cinta. Lebih dari sekadar makanan, kami menyajikan kenangan. Produk kami berhasil mencuri perhatian karena keunikannya yang tanpa isi, memberikan kebebasan bagi setiap orang untuk berkreasi dengan topping favorit mereka. Dengan rasa yang khas, harga terjangkau, dan distribusi yang merakyat, kami terus berusaha menjadi bagian dari kehangatan setiap meja makan di seluruh penjuru.</p>
                    </div>
                    <div class="col-lg-6 mt-4 mt-lg-0 fade-in-up" style="transition-delay: 0.3s;">
                        <img src="img/roti1.jpeg" alt="Roti Bakar disajikan" class="img-fluid rounded shadow-sm">
                    </div>
                </div>
            </div>
        </section>

        <!-- History Timeline Section -->
        <section class="py-5 bg-light">
            <div class="container">
                <h2 class="section-title text-center mb-5 fade-in-up">Jejak Langkah Kami</h2>
                <div class="timeline">
                    <div class="timeline-item fade-in-up">
                        <div class="timeline-content">
                            <h4 class="timeline-title">Visi Sederhana</h4>
                            <p class="text-muted">Berawal dari usaha rumahan kecil dengan visi menghadirkan roti yang lezat dan sehat untuk semua. Distribusi pertama kami adalah ke warung-warung kopi dan toko kelontong, tempat di mana aroma roti bakar hangat berpadu dengan tawa dan cerita, menjadi bagian tak terpisahkan dari komunitas.</p>
                        </div>
                    </div>
                    <div class="timeline-item fade-in-up">
                        <div class="timeline-content">
                            <h4 class="timeline-title">Komitmen pada Kualitas</h4>
                            <p class="text-muted">Keunggulan utama kami adalah penggunaan bahan baku berkualitas tanpa pengawet. Ini memastikan produk kami aman dikonsumsi oleh siapa saja, dari anak-anak hingga orang dewasa. Kemasan toples transparan kami adalah janji kejujuran, memperlihatkan kesegaran roti di dalamnya.</p>
                        </div>
                    </div>
                    <div class="timeline-item fade-in-up">
                        <div class="timeline-content">
                            <h4 class="timeline-title">Fleksibilitas Rasa</h4>
                            <p class="text-muted">Daya tarik utama roti kami adalah rasanya yang netral namun lezat, sehingga cocok dipadukan dengan apa saja. Mulai dari selai manis, keju, susu, hingga lauk gurih seperti sarden dan sambal. Sebuah kanvas kosong untuk kreativitas kuliner Anda, sempurna untuk sarapan, bekal, atau camilan malam.</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Founder Section -->
        <section class="py-5">
            <div class="container">
                <div class="row justify-content-center text-center">
                    <div class="col-lg-8 fade-in-up">
                        <img src="img/founder.jpeg" alt="Pak Ngah" class="founder-img mb-4">
                        <h2 class="section-title">Pak Ngah, Sang Perintis</h2>
                        <p class="lead">"Kami tidak hanya menjual roti, kami berbagi kebahagiaan. Setiap potong roti adalah cerita tentang kerja keras, tradisi, dan harapan untuk selalu bisa menemani momen-momen berharga Anda. Dari keluarga kami, untuk keluarga Anda."</p>
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
