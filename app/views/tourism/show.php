<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Lexend:wght@400;500;600;700&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

<div class="container detail-destination-wrapper py-5">
    
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-3 mb-4 pb-2 border-bottom border-light animate fade-up">
        <div>
            <div class="d-flex align-items-center gap-2 mb-2">
                <span class="badge bg-explore rounded-pill px-3 py-1.5 font-secondary fs-9 fw-bold">EKSPLORASI</span>
                <span class="text-muted font-secondary fs-8"><i class="bi bi-geo-alt-fill text-danger me-1"></i> <?= htmlspecialchars($destination['location'] ?? 'Sumatra') ?></span>
            </div>
            <h1 class="display-6 fw-bold text-dark-clean font-lexend mb-0"><?= htmlspecialchars($destination['name']) ?></h1>
        </div>
        <a href="<?= Env::get('APP_URL') ?>/tourism" class="btn btn-back-portal rounded-pill px-4 py-2 fw-semibold font-secondary fs-8">
            <i class="bi bi-arrow-left me-2"></i> Kembali ke Wisata
        </a>
    </div>

    <?php if (!empty($destination['photos'])): ?>
        <div class="card card-gallery-showcase border-0 shadow-premium overflow-hidden mb-4 animate fade-up">
            <div class="gallery-display-canvas position-relative">
                <div id="destinationGalleryPremium" class="carousel slide carousel-fade h-100" data-bs-ride="carousel">
                    <div class="carousel-indicators premium-indicators">
                        <?php foreach ($destination['photos'] as $index => $photo): ?>
                            <button type="button" data-bs-target="#destinationGalleryPremium" data-bs-slide-to="<?= $index ?>" class="<?= $index === 0 ? 'active' : '' ?>" aria-current="true"></button>
                        <?php endforeach; ?>
                    </div>
                    
                    <div class="carousel-inner h-100">
                        <?php foreach ($destination['photos'] as $index => $photo): ?>
                            <div class="carousel-item h-100 <?= $index === 0 ? 'active' : '' ?>">
                                <div class="gallery-image-container">
                                    <img src="<?= Env::get('APP_URL') ?>/<?= htmlspecialchars($photo['photo_path']) ?>" class="gallery-hero-img" alt="<?= htmlspecialchars($destination['name']) ?>">
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>

                    <?php if (count($destination['photos']) > 1): ?>
                        <button class="carousel-control-prev premium-nav-btn ms-3" type="button" data-bs-target="#destinationGalleryPremium" data-bs-slide="prev">
                            <i class="bi bi-chevron-left"></i>
                        </button>
                        <button class="carousel-control-next premium-nav-btn me-3" type="button" data-bs-target="#destinationGalleryPremium" data-bs-slide="next">
                            <i class="bi bi-chevron-right"></i>
                        </button>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <div class="row g-4 lg-g-5">
        
        <div class="col-lg-8 animate fade-up">
            <div class="card border-0 shadow-premium rounded-4 p-4 p-md-5 bg-white mb-4">
                <h3 class="h4 fw-bold text-dark-clean font-lexend mb-4 position-relative pb-2">
                    Tentang Destinasi
                    <span class="position-absolute bottom-0 start-0 bg-primary-indigo" style="width: 40px; height: 3px; border-radius: 2px;"></span>
                </h3>
                <p class="text-body-clean font-secondary lh-relaxed mb-0">
                    <?= nl2br(htmlspecialchars($destination['description'] ?? 'Belum ada deskripsi mendalam untuk destinasi ini.')) ?>
                </p>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="sticky-sidebar-pro d-flex flex-column gap-4">
                
                <div class="card border-0 shadow-premium card-invoice-widget overflow-hidden animate fade-up delay-1">
                    <div class="widget-top-gradient"></div>
                    <div class="card-body p-4 position-relative z-2">
                        <h4 class="h5 fw-bold text-white font-lexend mb-4">Detail Informasi</h4>
                        
                        <div class="invoice-spec-list font-secondary fs-8 text-white-80 mb-4">
                            <div class="d-flex justify-content-between py-2.5 border-bottom border-white border-opacity-10 align-items-center">
                                <span><i class="bi bi-geo-alt me-2 text-warning"></i>Lokasi</span>
                                <span class="fw-semibold text-end text-white"><?= htmlspecialchars($destination['location'] ?? 'Sumatra Utara') ?></span>
                            </div>
                            <div class="d-flex justify-content-between py-2.5 border-bottom border-white border-opacity-10 align-items-center">
                                <span><i class="bi bi-ticket-perforated me-2 text-warning"></i>Estimasi Tiket</span>
                                <span class="fw-bold text-white">Rp <?= number_format($destination['price_per_person'] ?? 0, 0, ',', '.') ?> <small class="fw-normal text-white-50">/ orang</small></span>
                            </div>
                            <div class="d-flex justify-content-between py-2.5 border-bottom border-white border-opacity-10 align-items-center">
                                <span><i class="bi bi-car-front me-2 text-warning"></i>Rekomendasi Unit</span>
                                <span class="badge bg-light bg-opacity-20 text-black border-0 py-1.5 px-2.5"><?= htmlspecialchars($destination['recommended_vehicle'] ?? 'SUV / MPV') ?></span>
                            </div>
                        </div>

                        <div class="d-flex flex-column gap-2">
                            <a href="<?= Env::get('APP_URL') ?>/cars" class="btn btn-booking-execute rounded-pill py-3 fw-bold font-secondary shadow-sm text-uppercase tracking-wide">
                                <i class="bi bi-calendar-check-fill me-2"></i> Sewa Mobil untuk Trip Ini
                            </a>
                        </div>
                    </div>
                </div>

                <div class="card border-0 bg-white border border-light p-3 rounded-4 shadow-sm animate fade-up delay-2">
                    <div class="d-flex gap-3 align-items-center font-secondary">
                        <i class="bi bi-shield-check text-success fs-3"></i>
                        <div>
                            <h6 class="fw-bold text-dark-clean mb-0" style="font-size: 0.85rem;">Perjalanan Terencana & Aman</h6>
                            <p class="text-muted fs-9 mb-0">Supir Dtrans telah berpengalaman menempuh rute medan jalan menuju destinasi ini.</p>
                        </div>
                    </div>
                </div>

            </div>
        </div>

    </div>
</div>

<style>
    /* Premium Design Architecture Variables */
    :root {
        --brand-blue-gradient: linear-gradient(135deg, #070F2B 0%, #1B1A55 100%);
        --primary-indigo: #4F46E5;
        --text-dark-headline: #0F172A;
        --text-body: #475569;
        --border-slate-soft: rgba(226, 232, 240, 0.8);
        --shadow-premium: 0 12px 40px rgba(15, 23, 42, 0.04);
        --radius-premium: 20px;
    }

    body { background-color: #F8FAFC; }
    .font-lexend { font-family: 'Lexend', sans-serif; }
    .font-secondary { font-family: 'Plus Jakarta Sans', sans-serif; }
    .text-dark-clean { color: var(--text-dark-headline); }
    .text-body-clean { color: var(--text-body); }
    .text-white-80 { color: rgba(255, 255, 255, 0.8); }
    .fs-8 { font-size: 0.825rem; }
    .fs-9 { font-size: 0.75rem; }
    .tracking-wide { letter-spacing: 0.04em; }
    .lh-relaxed { line-height: 1.8; }

    .bg-explore { background-color: rgba(79, 70, 229, 0.1); color: var(--primary-indigo); }
    .btn-back-portal { background: #FFFFFF; color: #475569; border: 1px solid #E2E8F0; transition: all 0.25s ease; }
    .btn-back-portal:hover { background: #F8FAFC; color: var(--text-dark-headline); transform: translateX(-2px); }

    /* FIX: CANVAS PREVENT IMAGE FROM SHRINKING */
    .card-gallery-showcase { background: #FFFFFF; border-radius: var(--radius-premium); border: 1px solid var(--border-slate-soft); }
    
    .gallery-display-canvas { 
        height: 440px; 
        background: linear-gradient(180deg, #F8FAFC 0%, #E2E8F0 100%); 
    }
    .gallery-image-container {
        width: 100%;
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .gallery-hero-img { 
        width: 100%;
        height: 100%;
        object-fit: cover; /* Mengisi penuh ruang canvas seperti galeri travel profesional */
    }

    /* Carousel Premium Nav Buttons */
    .premium-indicators button { width: 30px; height: 4px; background-color: rgba(255,255,255,0.4); border-radius: 10px; border: none; }
    .premium-indicators button.active { background-color: #FFFFFF; }
    .premium-nav-btn { width: 40px; height: 40px; background: rgba(255, 255, 255, 0.85); backdrop-filter: blur(4px); border-radius: 50%; color: #000; opacity: 1; top: 50%; transform: translateY(-50%); border: none; transition: all 0.2s; z-index: 5; }
    .premium-nav-btn:hover { background: #FFFFFF; color: var(--primary-indigo); scale: 1.05; }

    /* Right Sidebar Sticky Components */
    .sticky-sidebar-pro { position: sticky; top: 30px; }
    .card-invoice-widget { background: var(--brand-blue-gradient); border-radius: var(--radius-premium); box-shadow: 0 20px 40px rgba(7, 15, 43, 0.15); }
    .widget-top-gradient { height: 4px; background: linear-gradient(90deg, #F6D167 0%, #DF9E1B 100%); }

    /* Call to Action Booking Button */
    .btn-booking-execute { background: linear-gradient(90deg, #F6D167 0%, #DF9E1B 100%); color: #070F2B !important; border: none; transition: all 0.3s ease; }
    .btn-booking-execute:hover { transform: translateY(-2px); box-shadow: 0 10px 25px rgba(223, 158, 27, 0.35); }

    /* Fluid Animation Engine */
    .animate { opacity: 0; will-change: transform, opacity; }
    .fade-up { transform: translateY(20px); transition: opacity 0.8s cubic-bezier(0.16, 1, 0.3, 1), transform 0.8s cubic-bezier(0.16, 1, 0.3, 1); }
    .animate.show { opacity: 1; transform: translateY(0); }
    .delay-1 { transition-delay: 0.12s; }
    .delay-2 { transition-delay: 0.24s; }

    @media (max-width: 991.98px) {
        .sticky-sidebar-pro { position: static; }
        .gallery-display-canvas { height: 280px; }
    }
</style>

<script>
document.addEventListener("DOMContentLoaded", function () {
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