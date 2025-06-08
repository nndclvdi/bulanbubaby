<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <title>Bulanbu baby - Perlengkapan Bayi Terlengkap</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Arial', sans-serif;
            background: linear-gradient(135deg, #1e3a8a 0%, #0f1729 50%, #1e40af 100%);
            min-height: 100vh;
            color: #e2e8f0;
            position: relative;
            overflow-x: hidden;
        }

        /* Moon and Stars Background */
        .moon {
            position: fixed;
            top: 10%;
            right: 10%;
            width: 120px;
            height: 120px;
            background: radial-gradient(circle at 30% 30%, #fef3c7, #f59e0b);
            border-radius: 50%;
            box-shadow: 0 0 50px rgba(245, 158, 11, 0.3);
            z-index: 1;
            animation: moonGlow 4s ease-in-out infinite alternate;
        }

        .stars {
            position: fixed;
            width: 100%;
            height: 100%;
            background-image: 
                radial-gradient(2px 2px at 20% 30%, #fbbf24, transparent),
                radial-gradient(2px 2px at 40% 70%, #fcd34d, transparent),
                radial-gradient(1px 1px at 90% 40%, #fef3c7, transparent),
                radial-gradient(1px 1px at 60% 10%, #fbbf24, transparent),
                radial-gradient(2px 2px at 80% 80%, #fcd34d, transparent);
            animation: twinkle 3s ease-in-out infinite alternate;
            z-index: 1;
        }

        @keyframes moonGlow {
            0% { box-shadow: 0 0 50px rgba(245, 158, 11, 0.3); }
            100% { box-shadow: 0 0 80px rgba(245, 158, 11, 0.5); }
        }

        @keyframes twinkle {
            0% { opacity: 0.7; }
            100% { opacity: 1; }
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
            position: relative;
            z-index: 2;
        }

        .navbar {
            padding-top: 0.3rem !important;
            padding-bottom: 0.3rem !important;
        }

        .navbar-brand {
            font-size: 1rem;
            padding-top: 0.2rem;
            padding-bottom: 0.2rem;
        }

        .navbar-nav .nav-link {
            padding-top: 0.3rem !important;
            padding-bottom: 0.3rem !important;
            font-size: 0.9rem;
        }

        header {
            text-align: center;
            margin-bottom: 50px;
            padding: 40px 0;
        }

        .logo {
            font-size: 3rem;
            font-weight: bold;
            color: #fbbf24;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
            margin-bottom: 10px;
        }

        .tagline {
            font-size: 1.2rem;
            color: #cbd5e1;
            font-style: italic;
        }

        .nav-menu {
            display: flex;
            justify-content: center;
            gap: 30px;
            margin: 40px 0;
            flex-wrap: wrap;
        }        

        .nav-item {
            background: rgba(64, 108, 252, 0.3);
            padding: 15px 30px;
            border-radius: 25px;
            text-decoration: none;
            color: #e2e8f0;
            font-weight: 600;
            border: 2px solid rgba(137, 177, 251, 0.3);
            transition: all 0.3s ease;
            backdrop-filter: blur(10px);
            position: relative;
            overflow: hidden;
        }

        .nav-item:hover {
            background: rgba(251, 191, 36, 0.2);
            border-color: #fbbf24;
            transform: translateY(-3px);
            box-shadow: 0 10px 20px rgba(251, 191, 36, 0.2);
        }

        .nav-item::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: linear-gradient(45deg, transparent, rgba(8, 70, 196, 0.1), transparent);
            transform: rotate(45deg);
            transition: all 0.5s;
            opacity: 0;
        }

        .nav-item:hover::before {
            animation: shine 0.5s ease-in-out;
        }

        @keyframes shine {
            0% { transform: translateX(-100%) rotate(45deg); opacity: 0; }
            50% { opacity: 1; }
            100% { transform: translateX(100%) rotate(45deg); opacity: 0; }
        }

        .hero-section {
            background: rgba(15, 23, 42, 0.7);
            border-radius: 20px;
            padding: 50px;
            margin: 50px 0;
            text-align: center;
            border: 1px solid rgba(251, 191, 36, 0.2);
            backdrop-filter: blur(15px);
        }

        .hero-title {
            font-size: 2.5rem;
            color: #fbbf24;
            margin-bottom: 20px;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
        }

        .hero-description {
            font-size: 1.1rem;
            line-height: 1.6;
            color: #cbd5e1;
            max-width: 800px;
            margin: 0 auto 30px;
        }

        .features-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 30px;
            margin: 50px 0;
        }

        .feature-card {
            background: rgba(30, 64, 175, 0.2);
            padding: 30px;
            border-radius: 15px;
            border: 1px solid rgba(251, 191, 36, 0.3);
            backdrop-filter: blur(10px);
            transition: all 0.3s ease;
            text-align: center;
        }

        .feature-card:hover,
        .feature-card.card-hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 30px rgba(251, 191, 36, 0.1);
            border-color: #fbbf24;
            background: rgba(251, 191, 36, 0.1) !important;
        }

        .feature-icon {
            font-size: 3rem;
            margin-bottom: 20px;
            color: #fbbf24;
        }

        .feature-title {
            font-size: 1.3rem;
            color: #fbbf24;
            margin-bottom: 15px;
            font-weight: 600;
        }

        .feature-description {
            color: #cbd5e1;
            line-height: 1.5;
        }

        .cta-section {
            background: linear-gradient(135deg, rgba(251, 191, 36, 0.1), rgba(30, 64, 175, 0.1));
            padding: 40px;
            border-radius: 20px;
            text-align: center;
            margin: 50px 0;
            border: 2px solid rgba(251, 191, 36, 0.3);
        }

        .cta-button {
            display: inline-block;
            background: linear-gradient(135deg, #fbbf24, #f59e0b);
            color: #1e3a8a;
            padding: 15px 40px;
            border-radius: 30px;
            text-decoration: none;
            font-weight: bold;
            font-size: 1.1rem;
            transition: all 0.3s ease;
            box-shadow: 0 5px 15px rgba(251, 191, 36, 0.3);
        }

        .cta-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(251, 191, 36, 0.4);
        }

        footer {
            text-align: center;
            padding: 40px 0;
            border-top: 1px solid rgba(251, 191, 36, 0.2);
            margin-top: 50px;
        }

        .footer-text {
            color: #94a3b8;
            margin-bottom: 10px;
        }

        @media (max-width: 768px) {
            .logo {
                font-size: 2rem;
            }
            
            .hero-title {
                font-size: 2rem;
            }
            
            .hero-section {
                padding: 30px 20px;
            }
            
            .nav-menu {
                gap: 15px;
            }
            
            .nav-item {
                padding: 12px 20px;
                font-size: 0.9rem;
            }
        }
    </style>
</head>
<body>
    <div class="stars"></div>
    <div class="moon"></div>
    
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark sticky-top">
        <div class="container">
            <a class="navbar-brand" href="index.html"><img src="image/logo.png" alt="Logo Bayi" width="50" height="50"></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link active" href="index.html">Beranda</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="produk.html">Produk</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="tentangkami.html">Tentang Kami</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="kontak.html">Kontak</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="blog.html">Blog</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="ulasan.html">Ulasan Kami</a>
                    </li>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="logout.php">Logout</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container">
        <header>
            <div class="logo">🌙 Bulanbu Baby Store</div>
            <div class="tagline">Perlengkapan Bayi Terlengkap di Malang</div>
        </header>

        <section class="hero-section">
            <h1 class="hero-title">Selamat Datang di Bulanbu Baby Store</h1>
            <p class="hero-description">
                Temukan perlengkapan bayi terbaik untuk buah hati Anda. Kami menyediakan berbagai macam 
                produk berkualitas tinggi mulai dari baju bayi, mainan edukatif, popok nyaman, hingga 
                makanan bergizi untuk mendukung tumbuh kembang si kecil.
            </p>
        </section>

        <section class="features-grid">
            <div class="feature-card">
                <img src="image/logobaju.png" alt="Logo Bayi" width="50" height="50">
                <h3 class="feature-title">Koleksi Baju Bayi</h3>
                <p class="feature-description">
                    Baju bayi dengan bahan berkualitas tinggi, berbagai ukuran dan warna menarik. 
                    Cocok untuk berbagai usia dan kebutuhan harian si kecil.
                </p>
            </div>

            <div class="feature-card">
                 <img src="image/logomainan.png" alt="Logo Bayi" width="50" height="50">
                <h3 class="feature-title">Mainan Edukatif</h3>
                <p class="feature-description">
                    Mainan yang tidak hanya menghibur tapi juga mendukung perkembangan motorik 
                    dan kognitif bayi dengan berbagai pilihan merk terpercaya.
                </p>
            </div>

            <div class="feature-card">
                <img src="image/logopopok.png" alt="Logo Bayi" width="50" height="50">
                <h3 class="feature-title">Popok Premium</h3>
                <p class="feature-description">
                    Popok dengan daya serap tinggi dan bahan yang aman untuk kulit sensitif bayi. 
                    Tersedia dalam berbagai ukuran dan tipe.
                </p>
            </div>

            <div class="feature-card">
                 <img src="image/logomakanan.png" alt="Logo Bayi" width="50" height="50">
                <h3 class="feature-title">Makanan Bergizi</h3>
                <p class="feature-description">
                    Makanan bayi dengan nutrisi lengkap, berbagai rasa dan bentuk yang sesuai 
                    dengan tahapan perkembangan usia bayi.
                </p>
            </div>
        </section>

        <section class="cta-section">
            <h2 style="color: #fbbf24; margin-bottom: 20px; font-size: 1.8rem;">
                Mulai Berbelanja Sekarang
            </h2>
            <p style="color: #cbd5e1; margin-bottom: 30px; font-size: 1.1rem;">
                Jelajahi katalog lengkap kami dan temukan produk terbaik untuk si kecil
            </p>
            <a href="produk.html" class="cta-button">Lihat Semua Produk</a>
        </section>

        <footer>
            <p class="footer-text">© 2025 Bulanbu Baby Store - Perlengkapan Bayi Terpercaya</p>

            <div style="margin-top: 20px; display: flex; justify-content: center; gap: 30px; flex-wrap: wrap;">
                <a href="https://www.instagram.com/bulanbu.baby?utm_source=ig_web_button_share_sheet&igsh=ZGp4YWxraTA5dG4x" target="_blank" style="color: #fbbf24; text-decoration: none; display: flex; align-items: center; gap: 8px; font-size: 1rem;">
                    <img src="image/instagram.jpg" alt="Instagram" width="24" height="24">Instagram
                </a>
                <a href="https://www.tiktok.com/@bulanbu.baby?_t=8rHGLh6KYiu&_r=1" target="_blank" style="color: #fbbf24; text-decoration: none; display: flex; align-items: center; gap: 8px; font-size: 1rem;">
                    <img src="image/tiktok.jpg" alt="TikTok" width="24" height="24">TikTok
                </a>
                <a href="https://api.whatsapp.com/send?phone=6289528513034&text=Hola%20Bubun%21%20mau%20minta%20informasi%20dong.." target="_blank" style="color: #fbbf24; text-decoration: none; display: flex; align-items: center; gap: 8px; font-size: 1rem;">
                    <img src="image/whatsapp.jpg" alt="WhatsApp" width="24" height="24">WhatsApp
                </a>
            </div>
        </footer>
    </div>

    <!-- Optimized Bootstrap JavaScript -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js" defer></script>

    <script>
        // Optimized interaction effects
        document.addEventListener('DOMContentLoaded', function() {
            // Remove preventDefault from navbar links to allow normal navigation
            // Only apply to category menu items, not main navbar
            const categoryNavItems = document.querySelectorAll('.nav-menu .nav-item');
            categoryNavItems.forEach(item => {
                item.addEventListener('click', function(e) {
                    // Only prevent default for category items that don't have proper links
                    if (this.getAttribute('href') === '#') {
                        e.preventDefault();
                    }
                    // Add visual feedback
                    this.style.transform = 'scale(0.95)';
                    setTimeout(() => {
                        this.style.transform = '';
                    }, 150);
                });
            });

            // Optimized parallax effect with throttling
            let ticking = false;
            const moon = document.querySelector('.moon');
            
            function updateMoon() {
                const scrolled = window.pageYOffset;
                moon.style.transform = `translateY(${scrolled * 0.5}px)`;
                ticking = false;
            }

            window.addEventListener('scroll', () => {
                if (!ticking) {
                    requestAnimationFrame(updateMoon);
                    ticking = true;
                }
            });

            // Optimized hover effects using CSS classes instead of inline styles
            const featureCards = document.querySelectorAll('.feature-card');
            featureCards.forEach(card => {
                card.addEventListener('mouseenter', function() {
                    this.classList.add('card-hover');
                });
                
                card.addEventListener('mouseleave', function() {
                    this.classList.remove('card-hover');
                });
            });

            // Add loading indicator for navigation
            const navLinks = document.querySelectorAll('.navbar-nav .nav-link');
            navLinks.forEach(link => {
                link.addEventListener('click', function() {
                    if (this.getAttribute('href') !== '#' && !this.getAttribute('href').startsWith('http')) {
                        // Show loading state
                        this.style.opacity = '0.7';
                        this.innerHTML += ' <span class="spinner-border spinner-border-sm ms-1" role="status"></span>';
                    }
                });
            });
        });
    </script>
</body>
</html>