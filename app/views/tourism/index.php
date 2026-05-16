<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Lexend:wght@400;500;600;700&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

<div class="container tourism-catalog-wrapper py-5">
    
    <div class="d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center gap-3 mb-5 pb-2 border-bottom border-light animate fade-up">
        <div>
            <span class="badge bg-explore rounded-pill px-3 py-1.5 font-secondary fs-9 fw-bold mb-2 d-inline-block">EKSPLORASI SUMATRA</span>
            <h1 class="display-6 fw-bold text-dark-clean font-lexend mb-1">Destinasi Wisata</h1>
            <p class="text-muted small mb-0 font-secondary">Temukan keindahan alam dan tempat ikonik terbaik bersama Dtrans</p>
        </div>
        <a href="<?= Env::get('APP_URL') ?>" class="btn btn-back-home rounded-pill px-4 py-2.5 fw-semibold font-secondary fs-8 shadow-sm">
            <i class="bi bi-house-door me-2"></i> Kembali ke Beranda
        </a>
    </div>

    <?php if (empty($destinations)): ?>
        <div class="card border-0 shadow-premium p-5 text-center animate fade-up delay-1">
            <div class="py-5">
                <div class="text-muted opacity-30 mb-3">
                    <i class="bi bi-map display-3"></i>
                </div>
                <h5 class="fw-bold text-dark-clean font-lexend mb-1">Belum Ada Destinasi</h5>
                <p class="text-muted small font-secondary mb-0">Paket perjalanan atau destinasi wisata saat ini sedang diperbarui.</p>
            </div>
        </div>
    <?php else: ?>
        
        <div class="row row-cols-1 row-cols-md-2 row-cols-xl-3 g-4">
            <?php foreach ($destinations as $index => $destination): ?>
                <div class="col animate fade-up">
                    <div class="card card-destination-premium border-0 shadow-premium h-100 overflow-hidden d-flex flex-column">
                        
                        <div class="destination-image-canvas position-relative overflow-hidden">
                            <?php if (!empty($destination['primary_photo'])): ?>
                                <img src="<?= Env::get('APP_URL') ?>/<?= htmlspecialchars($destination['primary_photo']) ?>" class="destination-hero-img" alt="<?= htmlspecialchars($destination['name']) ?>">
                            <?php else: ?>
                                <div class="w-100 h-100 d-flex flex-column align-items-center justify-content-center text-muted canvas-bg-empty">
                                    <i class="bi bi-compass opacity-30 display-6 mb-2"></i>
                                    <span class="fs-9 font-secondary">Dtrans Landscape Gallery</span>
                                </div>
                            <?php endif; ?>
                            
                            <div class="destination-location-overlay px-3 py-2 rounded-3">
                                <i class="bi bi-geo-alt-fill text-warning me-1"></i>
                                <span><?= htmlspecialchars($destination['location'] ?? 'Sumatra Utara') ?></span>
                            </div>
                        </div>

                        <div class="card-body p-4 d-flex flex-column flex-grow-1">
                            <h4 class="h5 fw-bold text-dark-clean font-lexend mb-2 title-truncate">
                                <?= htmlspecialchars($destination['name']) ?>
                            </h4>
                            
                            <p class="text-body-clean font-secondary fs-8 lh-base mb-4 description-truncate-box">
                                <?= htmlspecialchars($destination['description'] ?? 'Jelajahi pesona keindahan tersembunyi destinasi ini bersama layanan sewa mobil premium dan supir berpengalaman dari Dtrans.') ?>
                            </p>
                            
                            <div class="mt-auto pt-2">
                                <a href="<?= Env::get('APP_URL') ?>/tourism/<?= $destination['id'] ?>" class="btn btn-explore-action w-100 rounded-pill py-2.5 fw-semibold font-secondary fs-8 transition-all">
                                    Lihat Detail Destinasi <i class="bi bi-arrow-right ms-1"></i>
                                </a>
                            </div>
                        </div>

                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        
    <?php endif; ?>
</div>

<style>
    /* Premium UI System Variables */
    :root {
        --brand-blue-gradient: linear-gradient(135deg, #070F2B 0%, #1B1A55 100%);
        --primary-indigo: #4F46E5;
        --text-dark-headline: #0F172A;
        --text-body: #475569;
        --border-slate-soft: rgba(226, 232, 240, 0.8);
        --shadow-premium: 0 12px 35px rgba(15, 23, 42, 0.04);
        --shadow-hover: 0 20px 45px rgba(15, 23, 42, 0.08);
        --radius-premium: 20px;
    }

    body { background-color: #F8FAFC; }
    .font-lexend { font-family: 'Lexend', sans-serif; }
    .font-secondary { font-family: 'Plus Jakarta Sans', sans-serif; }
    .text-dark-clean { color: var(--text-dark-headline); }
    .text-body-clean { color: var(--text-body); }
    .fs-8 { font-size: 0.825rem; }
    .fs-9 { font-size: 0.75rem; }

    /* Top Navigation Elements */
    .bg-explore { background-color: rgba(79, 70, 229, 0.1); color: var(--primary-indigo); }
    .btn-back-home {
        background: #FFFFFF; color: #475569; border: 1px solid #E2E8F0; transition: all 0.25s ease;
    }
    .btn-back-home:hover { background: #F8FAFC; color: var(--text-dark-headline); transform: translateY(-1px); }

    /* Card Layout & Image Fix (Mencegah Gambar Mengecil / Rusak) */
    .card-destination-premium {
        background: #FFFFFF;
        border: 1px solid var(--border-slate-soft);
        border-radius: var(--radius-premium);
        box-shadow: var(--shadow-premium);
        transition: all 0.4s cubic-bezier(0.16, 1, 0.3, 1);
    }
    .card-destination-premium:hover {
        transform: translateY(-5px);
        box-shadow: var(--shadow-hover);
        border-color: rgba(79, 70, 229, 0.15);
    }
    .card-destination-premium:hover .destination-hero-img {
        transform: scale(1.06);
    }

    /* Canvas Pembungkus Gambar - Menjaga Rasio Tetap Besar dan Seimbang */
    .destination-image-canvas {
        height: 240px;
        width: 100%;
        background-color: #F1F5F9;
    }
    .destination-hero-img {
        width: 100%;
        height: 100%;
        object-fit: cover; /* Memaksa gambar mengisi penuh area tanpa distorsi atau mengecil */
        transition: transform 0.6s cubic-bezier(0.16, 1, 0.3, 1);
    }
    .canvas-bg-empty {
        background: linear-gradient(180deg, #F8FAFC 0%, #E2E8F0 100%);
    }

    /* Floating Location Glassmorphism Badge */
    .destination-location-overlay {
        position: absolute; bottom: 15px; left: 15px;
        background: rgba(15, 23, 42, 0.65);
        backdrop-filter: blur(8px); -webkit-backdrop-filter: blur(8px);
        color: #FFFFFF; font-size: 0.75rem; font-weight: 600;
        font-family: 'Plus Jakarta Sans', sans-serif;
        border: 1px solid rgba(255, 255, 255, 0.15);
        z-index: 2;
    }

    /* Text Truncation Optimization */
    .title-truncate {
        display: -webkit-box; -webkit-line-clamp: 1; -webkit-box-orient: vertical; overflow: hidden;
    }
    .description-truncate-box {
        display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; overflow: hidden;
        height: 4.5rem; /* Menjaga tinggi deskripsi seragam agar baris tombol sejajar */
    }

    /* Interactive Bottom Buttons */
    .btn-explore-action {
        background-color: #FFFFFF; color: #475569; border: 1px solid #E2E8F0;
    }
    .btn-explore-action:hover {
        background: var(--brand-blue-gradient); color: #FFFFFF !important; border-color: transparent;
        box-shadow: 0 6px 15px rgba(27, 26, 85, 0.15);
    }

    /* Fluid In-View Animation Engine */
    .animate { opacity: 0; will-change: transform, opacity; }
    .fade-up {
        transform: translateY(20px);
        transition: opacity 0.8s cubic-bezier(0.16, 1, 0.3, 1), transform 0.8s cubic-bezier(0.16, 1, 0.3, 1);
    }
    .animate.show { opacity: 1; transform: translateY(0); }

    @media (max-width: 575.98px) {
        .destination-image-canvas { height: 200px; }
    }
</style>

<script>
document.addEventListener("DOMContentLoaded", function () {
    // Intersection Observer untuk animasi muat halaman (staggered entry)
    const elements = document.querySelectorAll('.animate');
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('show');
                observer.unobserve(entry.target);
            }
        });
    }, { threshold: 0.01 });
    elements.forEach(el => observer.observe(el));
});
</script>