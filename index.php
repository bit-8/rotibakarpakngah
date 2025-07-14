<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home - Roti Bakar Pak Ngah</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lato:wght@400;700&family=Montserrat:wght@700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="index.css">
</head>
<body>
    <header class="shadow">
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

    <main>
        <!-- Hero Section -->
        <section class="hero-section text-center text-white">
            <div class="container">
                <h1 class="hero-title">Rasa Asli, Sejak Dulu</h1>
                <p class="hero-subtitle lead">Nikmati kelembutan roti bakar legendaris Pak Ngah, dibuat dengan resep turun-temurun tanpa bahan pengawet.</p>
                <a href="pemesan.php" class="btn btn-lg btn-light">Pesan Sekarang</a>
            </div>
        </section>

        <!-- About Section -->
        <section class="py-5">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-6">
                        <h2 class="section-title">Selamat Datang di Dunia Roti Pak Ngah</h2>
                        <p class="text-muted">Kami senang Anda telah berkunjung. Di sini, Anda akan menemukan cerita di balik roti bakar yang telah menjadi bagian dari kehangatan keluarga selama puluhan tahun. Kami berkomitmen untuk menjaga kualitas dan rasa yang otentik.</p>
                        <p class="text-muted">Jelajahi situs kami untuk melihat galeri, mempelajari sejarah kami, atau langsung melakukan pemesanan. Jika ada pertanyaan, jangan ragu untuk menghubungi kami.</p>
                    </div>
                    <div class="col-lg-6 mt-4 mt-lg-0">
                        <img src="img/roti13a.jpeg" alt="Roti Bakar Pak Ngah" class="img-fluid rounded shadow-sm">
                    </div>
                </div>
            </div>
        </section>

        <!-- Interview Section -->
        <section class="py-5 bg-light">
            <div class="container">
                <h2 class="section-title text-center">Cerita di Balik Adonan</h2>
                <p class="text-center text-muted mb-5">Dengarkan wawancara eksklusif bersama Ibu Erlina, penerus usaha Roti Bakar Pak Ngah.</p>
                <div class="interview-box">
                    <div class="audio-player-ui">
                        <img id="albumImage" src="img/logo.png" alt="Play Button" class="audio-artwork">
                        <div class="audio-info">
                            <h5 class="audio-title">Wawancara Eksklusif</h5>
                            <p class="audio-artist">Ibu Erlina - Roti Bakar Pak Ngah</p>
                        </div>
                        <audio id="audioPlayer" src="audio/wawancara.mp3"></audio>
                    </div>
                    <div class="transcript mt-4">
                        <div class="transcript-item">
                            <p><strong>Tanya:</strong> Apa yang menginspirasi usaha ini?</p>
                            <p><strong>Jawab:</strong> "Awalnya karena di rumah tidak ada kegiatan, jadi saya mencari ide untuk menambah penghasilan. Setelah mencoba membuat kerupuk dan gagal, saya beralih ke roti, belajar dari resep nenek dan menyempurnakannya."</p>
                        </div>
                        <div class="transcript-item">
                            <p><strong>Tanya:</strong> Apa tantangan terbesarnya?</p>
                            <p><strong>Jawab:</strong> "Dulu semuanya dibuat dengan tangan, tanpa mesin. Produksi sangat terbatas. Alhamdulillah setelah membeli mesin, kami bisa memproduksi lebih banyak untuk memenuhi permintaan."</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Video Section -->
        <section class="py-5">
            <div class="container">
                <h2 class="section-title text-center">Proses Pembuatan</h2>
                <div class="video-wrapper ratio ratio-16x9">
                    <iframe src="https://www.youtube.com/embed/sYeyi-ho9T4" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
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
        const audioPlayer = document.getElementById('audioPlayer');
        const albumImage = document.getElementById('albumImage');
        const playerUI = document.querySelector('.audio-player-ui');

        playerUI.addEventListener('click', () => {
            if (audioPlayer.paused) {
                audioPlayer.play();
                albumImage.classList.add('rotating');
            } else {
                audioPlayer.pause();
                albumImage.classList.remove('rotating');
            }
        });

        audioPlayer.addEventListener('ended', () => {
            albumImage.classList.remove('rotating');
        });
    </script>
</body>
</html>