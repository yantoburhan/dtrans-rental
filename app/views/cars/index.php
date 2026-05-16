<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Lexend:wght@400;500;600;700&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

<div class="container catalog-wrapper py-5">
    
    <div class="d-flex justify-content-between align-items-center mb-4 pb-3 border-bottom border-light animate fade-up">
        <div>
            <h1 class="display-6 fw-bold text-dark-clean font-lexend mb-1">Mobil Tersedia</h1>
            <p class="text-muted small mb-0 font-secondary">Temukan kendaraan premium terbaik untuk kenyamanan perjalanan Anda</p>
        </div>
        <a href="<?= Env::get('APP_URL') ?>/customer/dashboard" class="btn btn-back-portal rounded-pill px-4 py-2 fw-semibold font-secondary">
            <i class="bi bi-arrow-left me-2"></i> Kembali ke Dashboard
        </a>
    </div>

    <div class="card card-filter-premium border-0 shadow-premium p-4 mb-5 animate fade-up delay-1">
        <div class="d-flex align-items-center gap-2 mb-3">
            <i class="bi bi-sliders text-primary fs-5"></i>
            <h5 class="fw-bold text-dark-clean font-lexend mb-0">Konsol Penyaringan</h5>
        </div>
        
        <form class="row g-3" method="GET" action="<?= Env::get('APP_URL') ?>/cars">
            <div class="col-xl-3 col-md-6">
                <label class="form-label text-muted small fw-medium font-secondary">Kategori Kendaraan</label>
                <div class="input-premium-icon">
                    <i class="bi bi-tags input-icon-left"></i>
                    <select name="category" class="form-select-premium font-secondary">
                        <option value="">Semua Kategori</option>
                        <option value="city_car" <?= ($filters['category'] ?? '') === 'city_car' ? 'selected' : '' ?>>City Car</option>
                        <option value="mpv" <?= ($filters['category'] ?? '') === 'mpv' ? 'selected' : '' ?>>MPV</option>
                        <option value="suv" <?= ($filters['category'] ?? '') === 'suv' ? 'selected' : '' ?>>SUV</option>
                        <option value="luxury" <?= ($filters['category'] ?? '') === 'luxury' ? 'selected' : '' ?>>Luxury</option>
                        <option value="pickup" <?= ($filters['category'] ?? '') === 'pickup' ? 'selected' : '' ?>>Pickup</option>
                        <option value="hiace" <?= ($filters['category'] ?? '') === 'hiace' ? 'selected' : '' ?>>Hiace</option>
                        <option value="electric" <?= ($filters['category'] ?? '') === 'electric' ? 'selected' : '' ?>>Electric (EV)</option>
                    </select>
                </div>
            </div>

            <div class="col-xl-3 col-md-6">
                <label class="form-label text-muted small fw-medium font-secondary">Transmisi</label>
                <div class="input-premium-icon">
                    <i class="bi bi-gear input-icon-left"></i>
                    <select name="transmission" class="form-select-premium font-secondary">
                        <option value="">Semua Transmisi</option>
                        <option value="automatic" <?= ($filters['transmission'] ?? '') === 'automatic' ? 'selected' : '' ?>>Automatic</option>
                        <option value="manual" <?= ($filters['transmission'] ?? '') === 'manual' ? 'selected' : '' ?>>Manual</option>
                    </select>
                </div>
            </div>

            <div class="col-xl-2 col-md-4">
                <label class="form-label text-muted small fw-medium font-secondary">Kapasitas (Kursi)</label>
                <div class="input-premium-icon">
                    <i class="bi bi-people input-icon-left"></i>
                    <input type="number" name="capacity" class="form-control-premium font-secondary" min="1" placeholder="Contoh: 7" value="<?= htmlspecialchars($filters['capacity'] ?? '') ?>">
                </div>
            </div>

            <div class="col-xl-2 col-md-4">
                <label class="form-label text-muted small fw-medium font-secondary">Tanggal Ambil</label>
                <div class="input-premium-icon">
                    <i class="bi bi-calendar-check input-icon-left text-primary"></i>
                    <input type="date" name="pickup_date" class="form-control-premium font-secondary" value="<?= htmlspecialchars($filters['pickup_date'] ?? '') ?>">
                </div>
            </div>

            <div class="col-xl-2 col-md-4">
                <label class="form-label text-muted small fw-medium font-secondary">Tanggal Kembali</label>
                <div class="input-premium-icon">
                    <i class="bi bi-calendar-x input-icon-left text-danger"></i>
                    <input type="date" name="return_date" class="form-control-premium font-secondary" value="<?= htmlspecialchars($filters['return_date'] ?? '') ?>">
                </div>
            </div>

            <div class="col-12 d-flex justify-content-end gap-2 mt-4 pt-2 border-top border-light">
                <a href="<?= Env::get('APP_URL') ?>/cars" class="btn btn-filter-reset rounded-pill px-4 py-2 fw-semibold font-secondary">
                    <i class="bi bi-arrow-counterclockwise"></i> Reset
                </a>
                <button class="btn btn-filter-submit rounded-pill px-4 py-2 fw-semibold font-secondary" type="submit">
                    <i class="bi bi-search me-1"></i> Terapkan Filter
                </button>
            </div>
        </form>
    </div>

    <?php if (empty($cars)): ?>
        <div class="card border-0 shadow-premium p-5 text-center animate fade-up delay-2">
            <div class="py-4">
                <div class="empty-fleet-icon text-muted opacity-30 mb-3">
                    <i class="bi bi-car-front display-3"></i>
                </div>
                <h5 class="fw-bold text-dark-clean font-lexend mb-1">Armada Tidak Ditemukan</h5>
                <p class="text-muted small font-secondary max-w-sm mx-auto mb-0">
                    Maaf, tidak ada kendaraan yang memenuhi kriteria pencarian Anda saat ini. Silakan ubah filter atau hubungi layanan konsumen kami.
                </p>
            </div>
        </div>
    <?php else: ?>
        <div class="row row-cols-1 row-cols-md-2 g-4">
            <?php foreach ($cars as $car): ?>
                <div class="col animate fade-up">
                    <div class="card h-100 border-0 shadow-premium fleet-premium-card overflow-hidden">
                        
                        <?php
                        $photo = '';
                        if (!empty($car['primary_photo'])) {
                            $photo = $car['primary_photo'];
                        } elseif (!empty($car['photo'])) {
                            $photo = $car['photo'];
                        }
                        ?>

                        <div class="fleet-image-wrapper position-relative">
                            <span class="badge badge-category-pill">
                                <i class="bi bi-bookmark-fill me-1 text-warning"></i> <?= ucfirst(str_replace('_', ' ', $car['category'])) ?>
                            </span>

                            <?php if (!empty($photo)): ?>
                                <img src="<?= Env::get('APP_URL') ?>/<?= htmlspecialchars($photo) ?>"
                                     class="fleet-img"
                                     alt="<?= htmlspecialchars($car['brand'] . ' ' . $car['model']) ?>">
                            <?php else: ?>
                                <div class="fleet-img-placeholder d-flex flex-column align-items-center justify-content-center text-muted">
                                    <i class="bi bi-image opacity-30 display-6 mb-2"></i>
                                    <span class="fs-8 fw-medium">Gambar Tidak Tersedia</span>
                                </div>
                            <?php endif; ?>
                        </div>

                        <div class="card-body p-4 d-flex flex-column">
                            <h4 class="fw-bold text-dark-clean font-lexend mb-3"><?= htmlspecialchars($car['brand'] . ' ' . $car['model']) ?></h4>
                            
                            <div class="row g-2 text-muted fs-8 font-secondary border-top border-bottom border-light py-3 mb-4">
                                <div class="col-6 d-flex align-items-center gap-2">
                                    <i class="bi bi-gear-fill text-indigo-soft"></i>
                                    <span><?= ucfirst($car['transmission']) ?></span>
                                </div>
                                <div class="col-6 d-flex align-items-center gap-2">
                                    <i class="bi bi-people-fill text-indigo-soft"></i>
                                    <span><?= htmlspecialchars($car['capacity']) ?> Kursi Penumpang</span>
                                </div>
                                <div class="col-6 d-flex align-items-center gap-2">
                                    <i class="bi bi-shield-check text-success"></i>
                                    <span>Asuransi Terproteksi</span>
                                </div>
                                <div class="col-6 d-flex align-items-center gap-2">
                                    <i class="bi bi-patch-check text-primary"></i>
                                    <span>Unit Prima & Bersih</span>
                                </div>
                            </div>
                            
                            <div class="mt-auto d-flex justify-content-between align-items-center pt-2">
                                <div>
                                    <span class="text-muted fs-9 d-block font-secondary text-uppercase tracking-wider">Tarif Sewa</span>
                                    <div class="fleet-price-tag font-lexend">
                                        <span class="currency">IDR</span> <?= number_format($car['daily_price'], 0, ',', '.') ?><span class="day">/hari</span>
                                    </div>
                                </div>
                                <a href="<?= Env::get('APP_URL') ?>/cars/<?= $car['id'] ?>" class="btn btn-fleet-action rounded-pill px-4 py-2.5 fw-bold font-secondary shadow-sm">
                                    Lihat Detail <i class="bi bi-arrow-right ms-1"></i>
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
    /* Premium Catalog Layout Variables */
    :root {
        --brand-blue-gradient: linear-gradient(135deg, #0B1530 0%, #1E3A8A 100%);
        --primary-indigo: #4F46E5;
        --text-dark-headline: #0F172A;
        --border-slate-soft: rgba(226, 232, 240, 0.8);
        --shadow-premium: 0 12px 40px rgba(15, 23, 42, 0.04);
        --shadow-hover: 0 24px 50px rgba(30, 58, 138, 0.1);
        --radius-premium: 20px;
    }

    .font-lexend { font-family: 'Lexend', sans-serif; }
    .font-secondary { font-family: 'Plus Jakarta Sans', sans-serif; }
    .text-dark-clean { color: var(--text-dark-headline); }
    .fs-8 { font-size: 0.8rem; }
    .fs-9 { font-size: 0.725rem; }
    .tracking-wider { letter-spacing: 0.05em; }

    /* Top Back Navigation Button */
    .btn-back-portal {
        background: #FFFFFF;
        color: #475569;
        border: 1px solid rgba(226, 232, 240, 1);
        transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
    }
    .btn-back-portal:hover {
        background: #F8FAFC;
        color: var(--text-dark-headline);
        transform: translateX(-2px);
    }

    /* Floating Filter Panel Console */
    .card-filter-premium {
        background: #FFFFFF;
        border-radius: var(--radius-premium);
        border: 1px solid var(--border-slate-soft);
    }
    .input-premium-icon {
        position: relative;
        display: flex;
        align-items: center;
    }
    .input-icon-left {
        position: absolute; left: 14px;
        color: #94A3B8;
        font-size: 0.95rem;
        z-index: 4;
    }
    .form-select-premium, .form-control-premium {
        width: 100%;
        padding: 11px 14px 11px 40px;
        background: #F8FAFC;
        border: 1px solid #E2E8F0;
        border-radius: 12px;
        color: var(--text-dark-headline);
        font-size: 0.875rem;
        transition: all 0.25s ease;
    }
    .form-select-premium:focus, .form-control-premium:focus {
        background: #FFFFFF;
        border-color: var(--primary-indigo);
        box-shadow: 0 0 0 4px rgba(79, 70, 229, 0.1);
        outline: none;
    }

    .btn-filter-reset {
        background: #F1F5F9; color: #475569; border: none;
        transition: background 0.2s;
    }
    .btn-filter-reset:hover { background: #E2E8F0; color: var(--text-dark-headline); }

    .btn-filter-submit {
        background: var(--brand-blue-gradient); color: #FFFFFF; border: none;
        box-shadow: 0 4px 12px rgba(30, 58, 138, 0.15);
        transition: all 0.3s ease;
    }
    .btn-filter-submit:hover {
        transform: translateY(-1px);
        box-shadow: 0 6px 20px rgba(30, 58, 138, 0.25);
        filter: brightness(1.1);
    }

    /* Immersive Fleet Cards System */
    .fleet-premium-card {
        background: #FFFFFF;
        border-radius: var(--radius-premium);
        border: 1px solid var(--border-slate-soft);
        box-shadow: var(--shadow-premium);
        transition: all 0.4s cubic-bezier(0.16, 1, 0.3, 1);
    }
    .fleet-premium-card:hover {
        transform: translateY(-6px);
        box-shadow: var(--shadow-hover);
        border-color: rgba(30, 58, 138, 0.1);
    }

    .fleet-image-wrapper {
        height: 230px;
        background: linear-gradient(180deg, #FAFAFA 0%, #F4F4F5 100%);
        overflow: hidden;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .fleet-img {
        height: 75%;
        width: auto;
        object-fit: contain;
        transition: transform 0.6s cubic-bezier(0.16, 1, 0.3, 1);
    }
    .fleet-premium-card:hover .fleet-img {
        transform: scale(1.06) translateY(-4px);
    }
    .fleet-img-placeholder { height: 100%; width: 100%; background: #F4F4F5; }

    /* Floating Micro Badge Category */
    .badge-category-pill {
        position: absolute; top: 16px; left: 16px; z-index: 5;
        background: #FFFFFF; color: var(--text-dark-headline);
        font-weight: 700; font-family: 'Plus Jakarta Sans', sans-serif;
        font-size: 0.75rem; padding: 6px 14px; border-radius: 30px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.06);
    }

    .text-indigo-soft { color: #818CF8; }

    /* Price Tag Layout & Action Button */
    .fleet-price-tag {
        font-size: 1.4rem; font-weight: 800; color: #1E3A8A;
        line-height: 1.2;
    }
    .fleet-price-tag .currency { font-size: 0.85rem; color: #94A3B8; font-weight: 500; }
    .fleet-price-tag .day { font-size: 0.8rem; color: #64748B; font-weight: 400; }

    .btn-fleet-action {
        background: var(--brand-blue-gradient); color: #FFFFFF !important; border: none;
        transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
    }
    .btn-fleet-action:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(30, 58, 138, 0.25);
    }

    /* Fluid Micro Animation Keyframe Setup */
    .animate { opacity: 0; will-change: transform, opacity; }
    .fade-up {
        transform: translateY(25px);
        transition: opacity 1s cubic-bezier(0.16, 1, 0.3, 1), transform 1s cubic-bezier(0.16, 1, 0.3, 1);
    }
    .animate.show { opacity: 1; transform: translateY(0); }
    .delay-1 { transition-delay: 0.12s; }
    .delay-2 { transition-delay: 0.24s; }

    @media (max-width: 767.98px) {
        .fleet-image-wrapper { height: 190px; }
        .catalog-wrapper { padding-top: 30px !important; }
    }
</style>

<script>
document.addEventListener("DOMContentLoaded", function () {
    // High-Performance Intersection Observer untuk trigger animasi masuk halaman
    const elements = document.querySelectorAll('.animate');
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('show');
                observer.unobserve(entry.target);
            }
        });
    }, { threshold: 0.02 });
    elements.forEach(el => observer.observe(el));
});
</script>