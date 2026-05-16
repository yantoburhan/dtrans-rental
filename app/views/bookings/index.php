<?php $pageTitle = 'My Bookings'; ?>

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Lexend:wght@400;500;600;700&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

<div class="container bookings-dashboard-wrapper py-5">
    
    <div class="mb-5 pb-2 border-bottom border-light animate fade-up">
        <h1 class="display-6 fw-bold text-dark-clean font-lexend mb-1">Pesanan Saya</h1>
        <p class="text-muted small mb-0 font-secondary">Pantau status reservasi armada premium Anda secara real-time</p>
    </div>

    <?php if (empty($bookings)): ?>
        <div class="card border-0 shadow-premium p-5 text-center animate fade-up delay-1">
            <div class="py-4">
                <div class="empty-booking-icon text-muted opacity-30 mb-3">
                    <i class="bi bi-calendar-x display-3"></i>
                </div>
                <h5 class="fw-bold text-dark-clean font-lexend mb-1">Belum Ada Pesanan</h5>
                <p class="text-muted small font-secondary max-w-sm mx-auto mb-4">
                    Anda belum melakukan reservasi kendaraan saat ini. Jelajahi pilihan armada terbaik kami untuk mulai perjalanan Anda.
                </p>
                <a href="<?= Env::get('APP_URL') ?>/cars" class="btn btn-find-fleet rounded-pill px-4 py-2.5 fw-bold font-secondary fs-8 shadow-sm">
                    <i class="bi bi-search me-1"></i> Cari Mobil Sekarang
                </a>
            </div>
        </div>
    <?php else: ?>

        <div class="row g-4">
            <?php foreach ($bookings as $booking): ?>
                <div class="col-md-6 animate fade-up">
                    <div class="card card-booking-premium border-0 shadow-premium h-100 overflow-hidden">
                        
                        <?php 
                            $status_clean = strtolower($booking['status'] ?? 'pending');
                            $status_class = 'status-pending';
                            if (in_array($status_clean, ['approved', 'confirmed', 'success', 'paid'])) {
                                $status_class = 'status-approved';
                            } elseif (in_array($status_clean, ['cancelled', 'rejected', 'failed'])) {
                                $status_class = 'status-cancelled';
                            } elseif (in_array($status_clean, ['completed', 'done', 'finished'])) {
                                $status_class = 'status-completed';
                            }
                        ?>
                        <div class="booking-status-indicator-bar <?= $status_class ?>"></div>

                        <div class="card-body p-4 position-relative">
                            
                            <div class="d-flex justify-content-between align-items-start gap-2 mb-3">
                                <div>
                                    <h4 class="h5 fw-bold text-dark-clean font-lexend mb-1">
                                        <?= htmlspecialchars($booking['brand'] . ' ' . $booking['model']) ?>
                                    </h4>
                                    <div class="booking-code-badge font-secondary text-muted">
                                        <i class="bi bi-ticket-perforated me-1 text-indigo"></i> Kode: <span class="code-text"><?= htmlspecialchars($booking['booking_code']) ?></span>
                                    </div>
                                </div>
                                
                                <span class="badge badge-status-pill <?= $status_class ?> text-capitalize font-secondary">
                                    <?php if ($status_class === 'status-approved'): ?>
                                        <span class="status-dot"></span>
                                    <?php endif; ?>
                                    <?= htmlspecialchars($booking['status']) ?>
                                </span>
                            </div>

                            <div class="invoice-mini-panel p-3 rounded-3 mb-4 d-flex justify-content-between align-items-center">
                                <div>
                                    <span class="text-muted fs-9 text-uppercase tracking-wider font-secondary d-block mb-1">Total Pembayaran</span>
                                    <div class="booking-total-price font-lexend">
                                        <span class="currency">Rp</span> <?= number_format($booking['total_price'], 0, ',', '.') ?>
                                    </div>
                                </div>
                                <div class="text-end opacity-40">
                                    <i class="bi bi-wallet2 fs-3 text-dark-clean"></i>
                                </div>
                            </div>

                            <a href="<?= Env::get('APP_URL') ?>/customer/bookings/<?= $booking['booking_id'] ?>"
                               class="btn btn-booking-detail-action w-100 rounded-pill py-2.5 fw-semibold font-secondary fs-8 transition-all">
                                Lihat Detail Reservasi <i class="bi bi-arrow-right ms-1"></i>
                            </a>

                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

    <?php endif; ?>
</div>

<style>
    /* Premium Architecture System Variables */
    :root {
        --brand-blue-gradient: linear-gradient(135deg, #070F2B 0%, #1B1A55 100%);
        --primary-indigo: #4F46E5;
        --text-dark-headline: #0F172A;
        --border-slate-soft: rgba(226, 232, 240, 0.8);
        --shadow-premium: 0 12px 35px rgba(15, 23, 42, 0.04);
        --shadow-hover: 0 20px 45px rgba(15, 23, 42, 0.08);
        --radius-premium: 18px;
        
        /* Status Colors Palettes */
        --color-success: #10B981;
        --color-warning: #F59E0B;
        --color-danger: #EF4444;
        --color-info: #3B82F6;
    }

    body { background-color: #F8FAFC; }
    .font-lexend { font-family: 'Lexend', sans-serif; }
    .font-secondary { font-family: 'Plus Jakarta Sans', sans-serif; }
    .text-dark-clean { color: var(--text-dark-headline); }
    .fs-8 { font-size: 0.825rem; }
    .fs-9 { font-size: 0.725rem; }
    .tracking-wider { letter-spacing: 0.05em; }

    /* Empty Fleet State Styling UI */
    .btn-find-fleet {
        background: var(--brand-blue-gradient); color: #FFFFFF !important; border: none;
        transition: all 0.3s ease;
    }
    .btn-find-fleet:hover { transform: translateY(-1px); box-shadow: 0 8px 20px rgba(27, 26, 85, 0.2); }

    /* Custom Cards Structure Blueprint */
    .card-booking-premium {
        background: #FFFFFF;
        border: 1px solid var(--border-slate-soft);
        border-radius: var(--radius-premium);
        box-shadow: var(--shadow-premium);
        transition: all 0.35s cubic-bezier(0.16, 1, 0.3, 1);
    }
    .card-booking-premium:hover {
        transform: translateY(-4px);
        box-shadow: var(--shadow-hover);
        border-color: rgba(79, 70, 229, 0.15);
    }

    /* Top Status Bar Colors mapping */
    .booking-status-indicator-bar { height: 4px; width: 100%; }
    .booking-status-indicator-bar.status-pending { background-color: var(--color-warning); }
    .booking-status-indicator-bar.status-approved { background-color: var(--color-success); }
    .booking-status-indicator-bar.status-cancelled { background-color: var(--color-danger); }
    .booking-status-indicator-bar.status-completed { background-color: var(--color-info); }

    /* Technical Metadata Code Badge */
    .booking-code-badge { font-size: 0.775rem; background: #F1F5F9; padding: 3px 10px; border-radius: 6px; display: inline-block; margin-top: 4px; }
    .booking-code-badge .code-text { font-family: 'Courier New', Courier, monospace; font-weight: 700; color: #334155; }
    .text-indigo { color: var(--primary-indigo); }

    /* Dynamic Badges Pill Controls */
    .badge-status-pill {
        font-weight: 700; font-size: 0.725rem; padding: 6px 12px; border-radius: 30px;
        display: flex; align-items: center; gap: 5px; border: 1px solid transparent;
    }
    .badge-status-pill.status-pending { background-color: #FEF3C7; color: #D97706; border-color: #FDE68A; }
    .badge-status-pill.status-approved { background-color: #D1FAE5; color: #059669; border-color: #A7F3D0; }
    .badge-status-pill.status-cancelled { background-color: #FEE2E2; color: #DC2626; border-color: #FECACA; }
    .badge-status-pill.status-completed { background-color: #DBEAFE; color: #2563EB; border-color: #BFDBFE; }

    .status-dot { width: 6px; height: 6px; background-color: #059669; border-radius: 50%; display: inline-block; animation: blinker 1.8s linear infinite; }

    /* Mini Invoice Grid View */
    .invoice-mini-panel { background-color: #F8FAFC; border: 1px solid #E2E8F0; }
    .booking-total-price { font-size: 1.25rem; font-weight: 700; color: #1E3A8A; line-height: 1; }
    .booking-total-price .currency { font-size: 0.85rem; color: #94A3B8; font-weight: 500; }

    /* Executive Actions Layout configuration */
    .btn-booking-detail-action {
        background-color: #FFFFFF; color: #475569; border: 1px solid #E2E8F0;
    }
    .btn-booking-detail-action:hover {
        background: var(--brand-blue-gradient); color: #FFFFFF !important; border-color: transparent;
        box-shadow: 0 6px 15px rgba(27, 26, 85, 0.15);
    }

    /* Fluid Micro Animation Engine Setup */
    .animate { opacity: 0; will-change: transform, opacity; }
    .fade-up {
        transform: translateY(15px);
        transition: opacity 0.6s cubic-bezier(0.16, 1, 0.3, 1), transform 0.6s cubic-bezier(0.16, 1, 0.3, 1);
    }
    .animate.show { opacity: 1; transform: translateY(0); }
    .delay-1 { transition-delay: 0.1s; }

    @keyframes blinker { 50% { opacity: 0.4; } }
</style>

<script>
document.addEventListener("DOMContentLoaded", function () {
    // High-Efficiency Intersection Observer untuk trigger animasi masuk halaman
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