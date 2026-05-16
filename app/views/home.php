<!-- Google Fonts & Bootstrap Icons Premium Setup -->
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Lexend:wght@300;400;500;600;700;800&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

<!-- Hero Section: Ultra-Modern Cinematic Gradient -->
<div class="hero-premium position-relative overflow-hidden mb-5">
    <div class="hero-overlay-mesh"></div>
    <div class="container position-relative z-2">
        <div class="row align-items-center min-vh-60 py-5">
            <div class="col-lg-7 text-start animate fade-up">
                <div class="d-inline-flex align-items-center gap-2 bg-white bg-opacity-10 border border-white border-opacity-20 rounded-pill px-3 py-1.5 mb-4 backdrop-blur">
                    <span class="badge bg-success rounded-pill fw-bold fs-8">OFFICIAL</span>
                    <span class="text-white fs-7 fw-medium tracking-wide">Dtrans Rental & Travel Sumatra</span>
                </div>
                <h1 class="display-3 fw-black text-white lh-sm mb-3">
                    Premium Mobility <br><span class="text-gradient-gold">Without Compromise.</span>
                </h1>
                <p class="lead text-white-50 mb-4 max-w-xl font-secondary">
                    Nikmati perjalanan berkelas di Sumatra Utara dengan armada luxury terbaru dan layanan pengemudi profesional bersertifikasi.
                </p>
                <div class="d-flex flex-wrap gap-3">
                    <a href="<?= Env::get('APP_URL') ?>/cars" class="btn btn-premium-primary rounded-pill px-4 py-3 fw-bold shadow-lg">
                        Mulai Perjalanan <i class="bi bi-arrow-right-short fs-5 ms-1"></i>
                    </a>
                    <a href="#destinations" class="btn btn-premium-outline rounded-pill px-4 py-3 fw-bold text-white">
                        Eksplor Wisata
                    </a>
                </div>
            </div>
        </div>
    </div>
    <!-- Peta abstrak latar belakang mini untuk estetika travel -->
    <div class="hero-map-vector"></div>
</div>

<div class="container mb-5">
    <div class="row g-4 lg-g-5">
        <!-- Main Content (Left Column) -->
        <div class="col-lg-8">

            <!-- Section: Featured Cars -->
            <section class="mb-5 animate fade-up delay-1">
                <div class="d-flex justify-content-between align-items-end mb-4 border-bottom border-light pb-3">
                    <div>
                        <h2 class="section-title-premium mb-1">Armada Pilihan Terbaik</h2>
                        <p class="text-muted small mb-0">Kendaraan prima, bersih, dan siap menempuh perjalanan jauh</p>
                    </div>
                    <a href="<?= Env::get('APP_URL') ?>/cars" class="btn-view-all">
                        Lihat Semua <i class="bi bi-arrow-up-right fs-7 ms-1"></i>
                    </a>
                </div>

                <?php if (!empty($featuredCars)): ?>
                    <div class="row g-4">
                        <?php foreach ($featuredCars as $car): ?>
                            <div class="col-md-6 animate fade-up">
                                <div class="card h-100 pro-car-card">
                                    <!-- Badges di atas gambar -->
                                    <span class="badge-status-car bg-white text-dark shadow-sm">
                                        <i class="bi bi-star-fill text-warning me-1"></i> Terlaris
                                    </span>
                                    
                                    <?php if (!empty($car['primary_photo'])): ?>
                                        <div class="ratio ratio-16x10 overflow-hidden pro-img-wrapper">
                                            <img src="<?= htmlspecialchars($car['primary_photo']) ?>" class="card-img-top" alt="<?= htmlspecialchars($car['brand']) ?>">
                                        </div>
                                    <?php else: ?>
                                        <div class="ratio ratio-16x10 bg-soft-grey d-flex align-items-center justify-content-center text-muted">
                                            <i class="bi bi-car-front-fill fs-1 opacity-20"></i>
                                        </div>
                                    <?php endif; ?>

                                    <div class="card-body p-4 d-flex flex-column">
                                        <span class="text-primary text-uppercase font-secondary fw-bold fs-8 tracking-wider mb-1">
                                            <?= htmlspecialchars($car['category'] ?? 'Premium SUV') ?>
                                        </span>
                                        <h5 class="fw-bold text-dark-clean mb-3"><?= htmlspecialchars($car['brand'] . ' ' . $car['model']) ?></h5>
                                        
                                        <!-- Penambahan Grid Spesifikasi Mobil Komponen Resmi (UX Krusial) -->
                                        <div class="row g-2 mb-4 text-muted fs-7 border-top border-bottom border-light py-2.5 my-2">
                                            <div class="col-6"><i class="bi bi-gear-fill text-primary-soft me-2"></i>Automatic</div>
                                            <div class="col-6"><i class="bi bi-people-fill text-primary-soft me-2"></i>7 Kursi</div>
                                            <div class="col-6"><i class="bi bi-fuel-pump-fill text-primary-soft me-2"></i>Pertamax / Diesel</div>
                                            <div class="col-6"><i class="bi bi-shield-check-fill text-success me-2"></i>Asuransi</div>
                                        </div>
                                        
                                        <div class="mt-auto d-flex justify-content-between align-items-center pt-2">
                                            <div>
                                                <div class="text-muted fs-8">Harga per hari</div>
                                                <div class="pro-price">
                                                    <span class="currency">IDR</span> <?= number_format($car['daily_price'] ?? 0, 0, ',', '.') ?>
                                                </div>
                                            </div>
                                            <span class="btn-pro-action">
                                                <i class="bi bi-arrow-right"></i>
                                            </span>
                                        </div>
                                        <a href="<?= Env::get('APP_URL') ?>/cars/<?= htmlspecialchars($car['id']) ?>" class="stretched-link"></a>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <div class="alert alert-premium text-center p-5">
                        <i class="bi bi-inbox-fill text-muted fs-1 d-block mb-3 opacity-30"></i>
                        <h6 class="fw-bold text-dark">Armada Belum Tersedia</h6>
                        <p class="text-muted small mb-0">Silakan hubungi admin via WhatsApp untuk pemesanan manual.</p>
                    </div>
                <?php endif; ?>
            </section>

            <!-- Section: Top Destinations -->
            <section id="destinations" class="mb-5 animate fade-up delay-2">
                <div class="d-flex justify-content-between align-items-end mb-4 border-bottom border-light pb-3">
                    <div>
                        <h2 class="section-title-premium mb-1">Destinasi Terpopuler</h2>
                        <p class="text-muted small mb-0">Rekomendasi tempat wisata ikonik di Sumatra Utara</p>
                    </div>
                    <a href="<?= Env::get('APP_URL') ?>/tourism" class="btn-view-all">
                        Eksplor Rute <i class="bi bi-compass fs-7 ms-1"></i>
                    </a>
                </div>

                <?php if (!empty($destinations)): ?>
                    <div class="row g-4">
                        <?php foreach ($destinations as $destination): ?>
                            <div class="col-md-6 animate fade-up">
                                <div class="card h-100 pro-destination-card overflow-hidden border-0 shadow-sm">
                                    <div class="position-relative overflow-hidden ratio ratio-4x3">
                                        <?php if (!empty($destination['image'])): ?>
                                            <img src="<?= htmlspecialchars($destination['image']) ?>" class="card-img-top dest-img" alt="<?= htmlspecialchars($destination['name']) ?>">
                                        <?php endif; ?>
                                        <div class="dest-card-gradient"></div>
                                        <div class="dest-card-content p-4 text-white">
                                            <span class="badge bg-blur rounded-pill fs-8 mb-2 px-2.5 py-1">📍 North Sumatra</span>
                                            <h4 class="fw-bold mb-1 tracking-tight"><?= htmlspecialchars($destination['name']) ?></h4>
                                            <p class="text-white-50 small text-truncate-2 mb-0">
                                                <?= htmlspecialchars($destination['description'] ?? '') ?>
                                            </p>
                                        </div>
                                    </div>
                                    <a href="<?= Env::get('APP_URL') ?>/tourism/<?= htmlspecialchars($destination['id']) ?>" class="stretched-link"></a>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <div class="alert alert-premium text-center p-5">
                        <i class="bi bi-geo-alt-fill text-muted fs-1 d-block mb-3 opacity-30"></i>
                        <h6 class="fw-bold text-dark">Destinasi Belum Diperbarui</h6>
                    </div>
                <?php endif; ?>
            </section>

        </div>

        <!-- Sidebar (Right Column) -->
        <div class="col-lg-4">
            <div class="sticky-sidebar-pro">
                
                <!-- Component: Drivers Profile List -->
                <div class="card p-4 mb-4 border-0 shadow-pro-sm animate fade-up delay-3 bg-white">
                    <div class="d-flex align-items-center mb-4 pb-2 border-bottom border-light">
                        <div class="icon-box-premium rounded-3 me-3">
                            <i class="bi bi-patch-check-fill fs-4 text-primary"></i>
                        </div>
                        <div>
                            <h3 class="section-title-premium h5 mb-0">Verified Drivers</h3>
                            <p class="text-muted fs-8 mb-0">Ramah, berpengalaman & hafal rute</p>
                        </div>
                    </div>

                    <?php if (!empty($bestDrivers)): ?>
                        <div class="driver-premium-stack">
                            <?php foreach ($bestDrivers as $driver): ?>
                                <div class="d-flex justify-content-between align-items-center p-3 mb-3 bg-light bg-opacity-50 rounded-3 border border-light-subtle hover-border-primary transition-all">
                                    <div class="d-flex align-items-center gap-3">
                                        <div class="avatar-pseudo rounded-circle bg-primary text-white fw-bold d-flex align-items-center justify-content-center">
                                            <?= strtoupper(substr($driver['full_name'], 0, 1)) ?>
                                        </div>
                                        <div>
                                            <strong class="text-dark-clean d-block fs-6 mb-0"><?= htmlspecialchars($driver['full_name']) ?></strong>
                                            <div class="fs-8 text-muted">
                                                <span class="badge bg-success-subtle text-success fs-9 border border-success border-opacity-10 py-0.5 px-2">Aktif</span>
                                                • <?= htmlspecialchars($driver['experience'] ?? 'Tour Guide') ?>
                                            </div>
                                        </div>
                                    </div>
                                    <span class="badge-pro-rating">
                                        <i class="bi bi-star-fill text-warning me-1"></i><?= htmlspecialchars($driver['rating'] ?? '5.0') ?>
                                    </span>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php else: ?>
                        <p class="text-muted text-center py-4 mb-0 small">Belum ada pengemudi terjadwal.</p>
                    <?php endif; ?>
                </div>

                <!-- Component: Call to Action Card widget -->
                <div class="card cta-pro-widget text-center p-4 overflow-hidden border-0 animate fade-up delay-4">
                    <div class="cta-glow-dot"></div>
                    <div class="position-relative z-2 py-4">
                        <h4 class="fw-bold text-white mb-2">Butuh Bantuan Cepat?</h4>
                        <p class="text-white-50 fs-7 mb-4">Konsultasikan rute perjalanan dan jenis kendaraan Anda bersama tim CS kami 24/7.</p>
                        <a href="https://wa.me/#" target="_blank" class="btn btn-whatsapp w-100 rounded-pill py-2.5 fw-bold shadow-sm d-flex align-items-center justify-content-center gap-2">
                            <i class="bi bi-whatsapp"></i> Hubungi via WhatsApp
                        </a>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<style>
    /* Global Variables - Professional Brand Identity Refresh */
    :root {
        --brand-primary: #1E3A8A;       /* Deep Luxury Navy */
        --brand-accent: #0284C7;        /* Clean Professional Light Blue */
        --brand-gold: #D97706;          /* Elegant Amber Gold */
        --bg-clean-light: #F8FAFC;      /* Pure Slate Mist */
        --text-headline: #0F172A;       /* Deep Charcoal (Nyaman di mata) */
        --text-body: #475569;           /* Secondary Slate Text */
        --radius-premium: 20px;
        --radius-smooth: 12px;
        --shadow-premium: 0 10px 40px rgba(15, 23, 42, 0.05);
        --shadow-hover: 0 20px 50px rgba(30, 58, 138, 0.1);
    }

    body {
        background-color: var(--bg-clean-light);
        font-family: 'Plus Jakarta Sans', sans-serif;
        color: var(--text-body);
        -webkit-font-smoothing: antialiased;
    }

    h1, h2, h3, h4, h5, .section-title-premium {
        font-family: 'Lexend', sans-serif;
        color: var(--text-headline);
        font-weight: 700;
    }

    /* Hero Premium Section Rules */
    .hero-premium {
        background: linear-gradient(135deg, #0B1530 0%, #1E3A8A 100%);
        border-radius: 0 0 40px 40px;
        padding: 80px 0;
    }
    .hero-overlay-mesh {
        position: absolute;
        top: 0; left: 0; width: 100%; height: 100%;
        background-image: radial-gradient(rgba(2, 132, 199, 0.15) 1px, transparent 0);
        background-size: 24px 24px;
        pointer-events: none;
    }
    .text-gradient-gold {
        background: linear-gradient(90deg, #FBBF24, #F59E0B);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }
    .min-vh-60 { min-vh: 60vh; }
    .backdrop-blur { backdrop-filter: blur(8px); }

    /* Button Utilities */
    .btn-premium-primary {
        background: linear-gradient(135deg, var(--brand-accent), #0369A1);
        color: white !important;
        border: none;
        transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
    }
    .btn-premium-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 24px rgba(2, 132, 199, 0.4);
    }
    .btn-premium-outline {
        border: 2px solid rgba(255, 255, 255, 0.2);
        background: transparent;
        transition: all 0.3s ease;
    }
    .btn-premium-outline:hover {
        background: rgba(255, 255, 255, 0.1);
        border-color: white;
    }
    .btn-view-all {
        color: var(--brand-accent);
        text-decoration: none;
        font-weight: 700;
        font-size: 0.9rem;
        transition: all 0.2s ease;
    }
    .btn-view-all:hover { color: var(--brand-primary); }

    /* Cards Architecture Refinement */
    .pro-car-card {
        border: 1px solid rgba(226, 232, 240, 0.7);
        border-radius: var(--radius-premium);
        box-shadow: var(--shadow-premium);
        background: #ffffff;
        transition: all 0.4s cubic-bezier(0.16, 1, 0.3, 1);
        position: relative;
    }
    .pro-car-card:hover {
        transform: translateY(-6px);
        box-shadow: var(--shadow-hover);
        border-color: rgba(30, 58, 138, 0.15);
    }
    .badge-status-car {
        position: absolute;
        top: 16px; left: 16px;
        z-index: 3;
        padding: 6px 14px;
        border-radius: 30px;
        font-size: 0.75rem;
        font-weight: 700;
    }
    .pro-img-wrapper img {
        transition: transform 0.6s ease;
        object-fit: cover;
    }
    .pro-car-card:hover .pro-img-wrapper img {
        transform: scale(1.04);
    }

    /* Details Grid inside Car Card */
    .text-primary-soft { color: #64748B; opacity: 0.8; }
    .pro-price {
        font-family: 'Lexend', sans-serif;
        font-weight: 800;
        font-size: 1.3rem;
        color: var(--brand-primary);
    }
    .pro-price .currency { font-size: 0.8rem; font-weight: 500; color: #94A3B8; }
    .btn-pro-action {
        width: 38px; height: 38px;
        border-radius: 50%;
        background: #F1F5F9;
        color: var(--brand-primary);
        display: flex; align-items: center; justify-content: center;
        transition: all 0.3s ease;
    }
    .pro-car-card:hover .btn-pro-action {
        background: var(--brand-primary);
        color: white;
    }

    /* Premium Immersive Destination Cards */
    .pro-destination-card {
        border-radius: var(--radius-premium);
    }
    .dest-img {
        object-fit: cover;
        transition: transform 0.8s cubic-bezier(0.16, 1, 0.3, 1);
    }
    .pro-destination-card:hover .dest-img {
        transform: scale(1.08);
    }
    .dest-card-gradient {
        position: absolute;
        bottom: 0; left: 0; width: 100%; height: 75%;
        background: linear-gradient(to top, rgba(15, 23, 42, 0.95) 0%, rgba(15, 23, 42, 0.4) 50%, rgba(0,0,0,0) 100%);
        z-index: 1;
    }
    .dest-card-content {
        position: absolute;
        bottom: 0; left: 0; width: 100%;
        z-index: 2;
    }
    .bg-blur { background: rgba(255, 255, 255, 0.15); backdrop-filter: blur(10px); border: 1px solid rgba(255,255,255,0.1); }
    .text-truncate-2 {
        display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;
    }

    /* Drivers Stack Component */
    .avatar-pseudo { width: 36px; height: 36px; font-size: 0.9rem; }
    .badge-pro-rating {
        background: #FEF3C7; color: #92400E; font-weight: 700;
        padding: 4px 10px; border-radius: 30px; font-size: 0.8rem;
    }
    .hover-border-primary:hover {
        border-color: rgba(2, 132, 199, 0.3) !important;
        background: #FFF !important;
    }

    /* Corporate Call To Action Sidebar Widget */
    .cta-pro-widget {
        background: linear-gradient(135deg, #1E3A8A 0%, #0F172A 100%);
    }
    .cta-glow-dot {
        position: absolute; top: -50px; right: -50px; width: 150px; height: 150px;
        background: rgba(2, 132, 199, 0.3); border-radius: 50%; filter: blur(40px);
    }
    .btn-whatsapp {
        background: #25D366; color: white; border: none;
        transition: all 0.3s ease;
    }
    .btn-whatsapp:hover { background: #1EA952; color: white; transform: translateY(-2px); }

    /* Layout Positioning Utilities */
    .sticky-sidebar-pro { position: sticky; top: 30px; }
    .fs-8 { font-size: 0.785rem; }
    .fs-9 { font-size: 0.7rem; }
    .font-secondary { font-family: 'Plus Jakarta Sans', sans-serif; }
    .text-dark-clean { color: #1E293B; }
    .lh-sm { line-height: 1.25 !important; }

    /* Cinematic Smooth Loading Animations */
    .animate { opacity: 0; will-change: transform, opacity; }
    .fade-up {
        transform: translateY(25px);
        transition: opacity 1s cubic-bezier(0.16, 1, 0.3, 1), transform 1s cubic-bezier(0.16, 1, 0.3, 1);
    }
    .animate.show { opacity: 1; transform: translateY(0); }
    .delay-1 { transition-delay: 0.15s; }
    .delay-2 { transition-delay: 0.3s; }
    .delay-3 { transition-delay: 0.4s; }
    .delay-4 { transition-delay: 0.5s; }

    @media (max-width: 991.98px) {
        .hero-premium { padding: 50px 0; border-radius: 0 0 24px 24px; }
        .hero-premium h1 { font-size: 2.4rem; }
        .sticky-sidebar-pro { position: static; }
    }
</style>

<script>
document.addEventListener("DOMContentLoaded", function () {
    // Advanced Intersection Observer API dengan trigger performa tinggi
    const elements = document.querySelectorAll('.animate');
    
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('show');
                observer.unobserve(entry.target); // Mencegah proses kalkulasi berulang
            }
        });
    }, {
        threshold: 0.02,
        rootMargin: "0px 0px -20px 0px"
    });

    elements.forEach(el => observer.observe(el));
});
</script>