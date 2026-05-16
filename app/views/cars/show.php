<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Lexend:wght@400;500;600;700&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

<div class="container detail-fleet-wrapper py-5">
    
    <div class="d-flex justify-content-between align-items-center mb-4 pb-2 border-bottom border-light animate fade-up">
        <div class="d-flex align-items-center gap-2">
            <span class="badge bg-official rounded-pill px-3 py-1.5 font-secondary fs-9 fw-bold">OFFICIAL</span>
            <span class="text-muted font-secondary fs-8">Dtrans Rental & Travel Sumatra</span>
        </div>
        <a href="<?= Env::get('APP_URL') ?>/cars" class="btn btn-back-portal rounded-pill px-4 py-2 fw-semibold font-secondary fs-8">
            <i class="bi bi-arrow-left me-2"></i> Kembali ke Katalog
        </a>
    </div>

    <div class="row g-4 lg-g-5">
        
        <div class="col-lg-8 animate fade-up">
            <div class="card card-gallery-showcase border-0 shadow-premium overflow-hidden mb-4">
                
                <div class="floating-status-pill">
                     <?php if (($car['status'] ?? 'available') === 'available'): ?>
                        <!-- <span class="badge bg-success-premium"><span class="pulse-dot-green"></span> Ready Unit</span> -->
                    <?php else: ?>
                        <span class="badge bg-danger-premium">Booked</span>
                    <?php endif; ?>
                </div>

                <div class="gallery-display-canvas position-relative">
                    <?php if (!empty($car['photos'])): ?>
                        <div id="carGalleryPremium" class="carousel slide carousel-fade h-100" data-bs-ride="carousel">
                            <div class="carousel-indicators premium-indicators">
                                <?php foreach ($car['photos'] as $index => $photo): ?>
                                    <button type="button" data-bs-target="#carGalleryPremium" data-bs-slide-to="<?= $index ?>" class="<?= $index === 0 ? 'active' : '' ?>" aria-current="true"></button>
                                <?php endforeach; ?>
                            </div>
                            <div class="carousel-inner h-100">
                                <?php foreach ($car['photos'] as $index => $photo): ?>
                                    <div class="carousel-item h-100 <?= $index === 0 ? 'active' : '' ?>">
                                        <div class="gallery-image-container">
                                            <img src="<?= Env::get('APP_URL') ?>/<?= htmlspecialchars($photo['photo_path']) ?>" class="gallery-hero-img" alt="<?= htmlspecialchars($car['brand'] . ' ' . $car['model']) ?>">
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                            <?php if (count($car['photos']) > 1): ?>
                                <button class="carousel-control-prev premium-nav-btn ms-3" type="button" data-bs-target="#carGalleryPremium" data-bs-slide="prev">
                                    <i class="bi bi-chevron-left"></i>
                                </button>
                                <button class="carousel-control-next premium-nav-btn me-3" type="button" data-bs-target="#carGalleryPremium" data-bs-slide="next">
                                    <i class="bi bi-chevron-right"></i>
                                </button>
                            <?php endif; ?>
                        </div>
                    <?php else: ?>
                        <div class="gallery-image-container">
                            <?php 
                            $single_photo = !empty($car['primary_photo']) ? $car['primary_photo'] : (!empty($car['photo']) ? $car['photo'] : '');
                            if (!empty($single_photo)): 
                            ?>
                                <img src="<?= Env::get('APP_URL') ?>/<?= htmlspecialchars($single_photo) ?>" class="gallery-hero-img" alt="<?= htmlspecialchars($car['brand'] . ' ' . $car['model']) ?>">
                            <?php else: ?>
                                <div class="d-flex flex-column align-items-center justify-content-center text-muted">
                                    <i class="bi bi-image opacity-30 display-4 mb-2"></i>
                                    <span>Gambar Unit Belum Diunggah</span>
                                </div>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>
                </div>

                <div class="card-body p-4 p-md-5">
                    <h2 class="h3 fw-bold text-dark-clean font-lexend mb-4">Detail Armada: <?= htmlspecialchars($car['brand'] . ' ' . $car['model']) ?></h2>
                    
                    <div class="specs-table-box mb-4">
                        <div class="row g-0">
                            <div class="col-6 border-end border-bottom p-3">
                                <span class="d-block text-muted-label mb-1">Transmisi</span>
                                <h5 class="fw-bold text-dark-clean font-lexend mb-0"><?= ucfirst($car['transmission']) ?></h5>
                            </div>
                            <div class="col-6 border-bottom p-3">
                                <span class="d-block text-muted-label mb-1">Kapasitas</span>
                                <h5 class="fw-bold text-dark-clean font-lexend mb-0"><?= htmlspecialchars($car['capacity']) ?> Kursi</h5>
                            </div>
                            <div class="col-6 border-end p-3">
                                <span class="d-block text-muted-label mb-1">Tahun</span>
                                <h5 class="fw-bold text-dark-clean font-lexend mb-0"><?= htmlspecialchars($car['year'] ?? '2021') ?></h5>
                            </div>
                            <div class="col-6 p-3">
                                <span class="d-block text-muted-label mb-1">Bahan Bakar</span>
                                <h5 class="fw-bold text-dark-clean font-lexend mb-0">Pertamax / Diesel</h5>
                            </div>
                        </div>
                    </div>

                    <p class="text-body-clean font-secondary lh-relaxed mb-0">
                        <?= nl2br(htmlspecialchars($car['description'] ?? 'Unit kendaraan premium Dtrans yang selalu mendapatkan perawatan berkala, jaminan kebersihan tingkat tinggi, serta kenyamanan optimal untuk perjalanan jarak jauh maupun kebutuhan bisnis Anda.')) ?>
                    </p>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="sticky-sidebar-pro d-flex flex-column gap-4">
                
                <div class="card border-0 shadow-premium card-invoice-widget overflow-hidden animate fade-up delay-1">
                    <div class="widget-top-gradient"></div>
                    <div class="card-body p-4 position-relative z-2">
                        <h4 class="h5 fw-bold text-white font-lexend mb-4">Invoice Detail</h4>
                        
                        <div class="invoice-spec-list font-secondary fs-8 text-white-80 mb-4">
                            <div class="d-flex justify-content-between py-2.5 border-bottom border-white border-opacity-10">
                                <span>Tarif Sewa Unit</span>
                                <span class="fw-semibold">Rp <?= number_format($car['daily_price'], 0, ',', '.') ?></span>
                            </div>
                            <div class="d-flex justify-content-between py-2.5 border-bottom border-white border-opacity-10">
                                <span>Biaya Pengemudi</span>
                                <span class="fw-semibold">Rp <?= number_format($car['driver_price_per_day'] ?? 0, 0, ',', '.') ?></span>
                            </div>
                            <div class="d-flex justify-content-between py-2.5 border-bottom border-white border-opacity-10">
                                <span>Nomor Plat Kendaraan</span>
                                <span class="fw-bold text-warning"><?= htmlspecialchars($car['plate_number']) ?></span>
                            </div>
                            <div class="d-flex justify-content-between py-2.5 border-bottom border-white border-opacity-10">
                                <span>Kategori Kelas</span>
                                <span class="badge bg-white bg-opacity-20 text-dark border-0"><?= ucfirst($car['category']) ?></span>
                            </div>
                            <div class="d-flex justify-content-between py-3 font-lexend mt-2 fs-6 text-white border-top border-white border-opacity-20">
                                <span class="fw-bold">Total / Hari</span>
                                <span class="fw-bold text-gradient-gold">Rp <?= number_format(($car['daily_price'] + ($car['driver_price_per_day'] ?? 0)), 0, ',', '.') ?></span>
                            </div>
                        </div>

                        <div class="d-flex flex-column gap-2">
                            <a href="<?= Env::get('APP_URL') ?>/customer/bookings/create?car_id=<?= $car['id'] ?>" class="btn btn-booking-execute rounded-pill py-3 fw-bold font-secondary shadow-sm text-uppercase tracking-wide">
                                <i class="bi bi-calendar-check-fill me-2"></i> Pesan Sekarang
                            </a>
                        </div>
                    </div>
                </div>

                <div class="card border-0 bg-white border border-light p-3 rounded-4 shadow-sm animate fade-up delay-2">
                    <div class="d-flex gap-3 align-items-center font-secondary">
                        <i class="bi bi-patch-check-fill text-success fs-4"></i>
                        <div>
                            <h6 class="fw-bold text-dark-clean mb-0" style="font-size: 0.85rem;">Jaminan Sanitasi & Kebersihan</h6>
                            <p class="text-muted fs-9 mb-0">Setiap unit disterilisasi penuh sebelum jadwal penjemputan Anda.</p>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        
    </div>
</div>

<style>
    /* Premium Design Variables */
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
    .lh-relaxed { line-height: 1.75; }

    .bg-official { background-color: #10B981; color: white; }
    .btn-back-portal { background: #FFFFFF; color: #475569; border: 1px solid #E2E8F0; transition: all 0.25s ease; }
    .btn-back-portal:hover { background: #F8FAFC; color: var(--text-dark-headline); transform: translateX(-2px); }

    /* FIX: PERBAIKAN TOTAL AREA CANVAS GAMBAR MOBIL */
    .card-gallery-showcase { background: #FFFFFF; border-radius: var(--radius-premium); border: 1px solid var(--border-slate-soft); }
    
    .gallery-display-canvas { 
        height: 420px; /* Mengatur tinggi konstan yang ideal */
        background: linear-gradient(180deg, #F8FAFC 0%, #E2E8F0 100%); 
    }
    
    .gallery-image-container {
        width: 100%;
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 2rem;
    }

    /* Memaksa gambar besar proporsional dan berada tepat di tengah tanpa terpotong */
    .gallery-hero-img { 
        max-width: 100%;
        max-height: 100%;
        object-fit: contain; 
        filter: drop-shadow(0 15px 30px rgba(0, 0, 0, 0.12)); 
    }

    /* Floating Pills & Indicators */
    .floating-status-pill { position: absolute; top: 20px; left: 20px; z-index: 10; }
    .bg-success-premium { background: #FFFFFF; color: #10B981; font-weight: 700; padding: 8px 16px; border-radius: 30px; font-size: 0.75rem; box-shadow: 0 4px 15px rgba(0,0,0,0.06); display: flex; align-items: center; gap: 6px; }
    .pulse-dot-green { width: 7px; height: 7px; background-color: #10B981; border-radius: 50%; display: inline-block; box-shadow: 0 0 0 rgba(16, 185, 129, 0.4); animation: pulseGreen 2s infinite; }

    .premium-indicators button { width: 30px; height: 4px; background-color: rgba(0,0,0,0.15); border-radius: 10px; border: none; }
    .premium-indicators button.active { background-color: var(--primary-indigo); }
    .premium-nav-btn { width: 40px; height: 40px; background: rgba(255, 255, 255, 0.9); border-radius: 50%; color: #000; opacity: 1; top: 50%; transform: translateY(-50%); border: 1px solid #E2E8F0; transition: all 0.2s; z-index: 5; }
    .premium-nav-btn:hover { background: #FFFFFF; color: var(--primary-indigo); }

    /* Grid Specs Box Layout */
    .specs-table-box { border: 1px solid #E2E8F0; border-radius: 14px; background-color: #FFFFFF; overflow: hidden; }
    .text-muted-label { font-size: 0.75rem; color: #94A3B8; font-weight: 500; }

    /* Right Sidebar Sticky */
    .sticky-sidebar-pro { position: sticky; top: 30px; }
    .card-invoice-widget { background: var(--brand-blue-gradient); border-radius: var(--radius-premium); box-shadow: 0 20px 40px rgba(7, 15, 43, 0.15); }
    .widget-top-gradient { height: 4px; background: linear-gradient(90deg, #F6D167 0%, #DF9E1B 100%); }
    .text-gradient-gold { background: linear-gradient(90deg, #F6D167 0%, #DF9E1B 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent; }

    /* Execution Button */
    .btn-booking-execute { background: linear-gradient(90deg, #F6D167 0%, #DF9E1B 100%); color: #070F2B !important; border: none; transition: all 0.3s ease; }
    .btn-booking-execute:hover { transform: translateY(-2px); box-shadow: 0 10px 25px rgba(223, 158, 27, 0.35); }

    /* Animations */
    .animate { opacity: 0; will-change: transform, opacity; }
    .fade-up { transform: translateY(20px); transition: opacity 0.8s cubic-bezier(0.16, 1, 0.3, 1), transform 0.8s cubic-bezier(0.16, 1, 0.3, 1); }
    .animate.show { opacity: 1; transform: translateY(0); }
    .delay-1 { transition-delay: 0.12s; }
    .delay-2 { transition-delay: 0.24s; }

    @keyframes pulseGreen {
        0% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(16, 185, 129, 0.5); }
        70% { transform: scale(1); box-shadow: 0 0 0 6px rgba(16, 185, 129, 0); }
        100% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(16, 185, 129, 0); }
    }

    @media (max-width: 991.98px) {
        .sticky-sidebar-pro { position: static; }
        .gallery-display-canvas { height: 280px; }
        .gallery-image-container { padding: 1rem; }
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