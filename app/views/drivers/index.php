<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Lexend:wght@400;500;600;700&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

<div class="container driver-catalog-wrapper py-5">
    
    <div class="d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center gap-3 mb-5 pb-2 border-bottom border-light animate fade-up">
        <div>
            <span class="badge bg-driver rounded-pill px-3 py-1.5 font-secondary fs-9 fw-bold mb-2 d-inline-block">LAYANAN SUPIR</span>
            <h1 class="display-6 fw-bold text-dark-clean font-lexend mb-1">Pengemudi Kami</h1>
            <p class="text-muted small mb-0 font-secondary">Didukung oleh kru profesional, berpengalaman, dan berlisensi resmi</p>
        </div>
        <a href="<?= Env::get('APP_URL') ?>" class="btn btn-back-home rounded-pill px-4 py-2.5 fw-semibold font-secondary fs-8 shadow-sm">
            <i class="bi bi-house-door me-2"></i> Kembali ke Beranda
        </a>
    </div>

    <?php if (empty($drivers)): ?>
        <div class="card border-0 shadow-premium p-5 text-center animate fade-up delay-1">
            <div class="py-5">
                <div class="text-muted opacity-30 mb-3">
                    <i class="bi bi-person-x display-3"></i>
                </div>
                <h5 class="fw-bold text-dark-clean font-lexend mb-1">Pengemudi Tidak Tersedia</h5>
                <p class="text-muted small font-secondary mb-0">Seluruh pengemudi kami saat ini sedang bertugas dalam perjalanan.</p>
            </div>
        </div>
    <?php else: ?>
        
        <div class="row row-cols-1 row-cols-md-2 row-cols-xl-3 g-4">
            <?php foreach ($drivers as $driver): ?>
                <div class="col animate fade-up">
                    <div class="card card-driver-premium border-0 shadow-premium h-100 overflow-hidden d-flex flex-column">
                        
                        <div class="driver-avatar-canvas position-relative overflow-hidden">
                            <?php if (!empty($driver['photo'])): ?>
                                <img src="<?= Env::get('APP_URL') ?>/<?= htmlspecialchars($driver['photo']) ?>" class="driver-profile-img" alt="<?= htmlspecialchars($driver['full_name']) ?>">
                            <?php else: ?>
                                <div class="w-100 h-100 d-flex flex-column align-items-center justify-content-center text-muted canvas-bg-empty">
                                    <i class="bi bi-person-circle opacity-20 display-4 mb-2"></i>
                                    <span class="fs-9 font-secondary text-uppercase tracking-wider">Dtrans Crew</span>
                                </div>
                            <?php endif; ?>

                            <div class="driver-experience-overlay px-3 py-1.5 rounded-pill">
                                <i class="bi bi-patch-check-fill text-info me-1"></i>
                                <span>Jam Terbang: <strong><?= htmlspecialchars($driver['experience'] ?? 0) ?> Tahun</strong></span>
                            </div>
                        </div>

                        <div class="card-body p-4 d-flex flex-column flex-grow-1">
                            
                            <div class="d-flex align-items-center gap-2 mb-2">
                                <div class="star-rating-box text-warning fs-8">
                                    <i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star-fill"></i>
                                </div>
                                <span class="fw-bold text-dark-clean font-secondary mt-0.5" style="font-size: 0.85rem;">
                                    <?= number_format($driver['avg_rating'] ?? 5.0, 1) ?>
                                </span>
                            </div>

                            <h4 class="h5 fw-bold text-dark-clean font-lexend mb-3 title-truncate">
                                <?= htmlspecialchars($driver['full_name']) ?>
                            </h4>
                            
                            <div class="driver-meta-panel p-3 rounded-3 mb-4 font-secondary fs-8 flex-grow-1">
                                <div class="d-flex justify-content-between py-1.5 border-bottom border-light">
                                    <span class="text-muted">Komunikasi</span>
                                    <span class="fw-semibold text-dark-clean text-truncate max-w-150"><?= htmlspecialchars($driver['languages'] ?? 'Indonesia') ?></span>
                                </div>
                                <div class="d-flex justify-content-between py-1.5">
                                    <span class="text-muted">Status Lisensi</span>
                                    <span class="badge bg-success bg-opacity-10 text-success fw-bold border-0 px-2 py-0.5">Aktif (SIM A/B)</span>
                                </div>
                            </div>
                            
                            <div class="mt-auto">
                                <a href="<?= Env::get('APP_URL') ?>/cars" class="btn btn-driver-action w-100 rounded-pill py-2.5 fw-semibold font-secondary fs-8 transition-all">
                                    Pesan Mobil & Supir Ini <i class="bi bi-arrow-right ms-1"></i>
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
    /* Premium UI System Blueprint */
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
    .fs-8 { font-size: 0.825rem; }
    .fs-9 { font-size: 0.75rem; }
    .max-w-150 { max-width: 150px; }

    /* Top Nav Elements Styling */
    .bg-driver { background-color: rgba(79, 70, 229, 0.1); color: var(--primary-indigo); }
    .btn-back-home { background: #FFFFFF; color: #475569; border: 1px solid #E2E8F0; transition: all 0.25s ease; }
    .btn-back-home:hover { background: #F8FAFC; color: var(--text-dark-headline); transform: translateY(-1px); }

    /* Card & Profile Image Alignment Layout (Anti-Shrink System) */
    .card-driver-premium {
        background: #FFFFFF;
        border: 1px solid var(--border-slate-soft);
        border-radius: var(--radius-premium);
        box-shadow: var(--shadow-premium);
        transition: all 0.4s cubic-bezier(0.16, 1, 0.3, 1);
    }
    .card-driver-premium:hover {
        transform: translateY(-5px);
        box-shadow: var(--shadow-hover);
        border-color: rgba(79, 70, 229, 0.15);
    }
    .card-driver-premium:hover .driver-profile-img {
        transform: scale(1.04);
    }

    /* Canvas Pembungkus Foto Supir - Mengunci Ukuran Agar Tetap Proporsional */
    .driver-avatar-canvas {
        height: 280px;
        width: 100%;
        background-color: #F8FAFC;
    }
    .driver-profile-img {
        width: 100%;
        height: 100%;
        object-fit: cover; /* Memotong foto secara rapi tanpa merusak aspek rasio asli */
        object-position: center top; /* Fokus ke area wajah/tubuh atas supir */
        transition: transform 0.5s cubic-bezier(0.16, 1, 0.3, 1);
    }
    .canvas-bg-empty {
        background: linear-gradient(180deg, #F8FAFC 0%, #E2E8F0 100%);
    }

    /* Floating Experience Layer Glassmorphism */
    .driver-experience-overlay {
        position: absolute; bottom: 15px; left: 15px;
        background: rgba(15, 23, 42, 0.75);
        backdrop-filter: blur(8px); -webkit-backdrop-filter: blur(8px);
        color: #FFFFFF; font-size: 0.725rem;
        font-family: 'Plus Jakarta Sans', sans-serif;
        border: 1px solid rgba(255, 255, 255, 0.15);
        z-index: 2;
    }

    /* Details Panel UI */
    .driver-meta-panel {
        background-color: #F8FAFC;
        border: 1px solid #E2E8F0;
    }
    .title-truncate {
        display: -webkit-box; -webkit-line-clamp: 1; -webkit-box-orient: vertical; overflow: hidden;
    }

    /* Bottom Core Action Button */
    .btn-driver-action {
        background-color: #FFFFFF; color: #475569; border: 1px solid #E2E8F0;
    }
    .btn-driver-action:hover {
        background: var(--brand-blue-gradient); color: #FFFFFF !important; border-color: transparent;
        box-shadow: 0 6px 15px rgba(27, 26, 85, 0.15);
    }

    /* Page Loading Animation Blueprint */
    .animate { opacity: 0; will-change: transform, opacity; }
    .fade-up {
        transform: translateY(20px);
        transition: opacity 0.8s cubic-bezier(0.16, 1, 0.3, 1), transform 0.8s cubic-bezier(0.16, 1, 0.3, 1);
    }
    .animate.show { opacity: 1; transform: translateY(0); }

    @media (max-width: 575.98px) {
        .driver-avatar-canvas { height: 250px; }
    }
</style>

<script>
document.addEventListener("DOMContentLoaded", function () {
    // Observer Trigger Engine untuk Efek Muat Masuk Halaman
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