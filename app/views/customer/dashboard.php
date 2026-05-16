<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Lexend:wght@400;500;600;700&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

<div class="container dashboard-wrapper py-5">
    
    <div class="row mb-5">
        <div class="col-12 animate fade-up">
            <div class="welcome-banner p-4 p-md-5 position-relative overflow-hidden">
                <div class="banner-overlay-glow"></div>
                <div class="position-relative z-2 d-md-flex justify-content-between align-items-center">
                    <div class="mb-4 mb-md-0">
                        <span class="badge bg-white bg-opacity-10 border border-white border-opacity-10 text-white rounded-pill px-3 py-1.5 fs-8 text-uppercase tracking-wider mb-2 d-inline-block">
                            <i class="bi bi-shield-check text-success me-1"></i> Customer Portal
                        </span>
                        <h2 class="display-6 text-white fw-bold font-lexend mb-1">
                            Welcome back, <?= htmlspecialchars(Session::get('user')['name']) ?>!
                        </h2>
                        <p class="text-white-50 mb-0 font-secondary fs-6">
                            Kelola pemesanan, perbarui profil, dan nikmati perjalanan Anda tanpa hambatan.
                        </p>
                    </div>
                    <div class="d-flex gap-2">
                        <a href="<?= Env::get('APP_URL') ?>/customer/bookings" class="btn btn-dash-primary rounded-pill px-4 py-2.5 fw-bold shadow-sm">
                            <i class="bi bi-calendar3 me-2"></i> Pesanan Saya
                        </a>
                        <a href="<?= Env::get('APP_URL') ?>/customer/profile" class="btn btn-dash-outline rounded-pill px-4 py-2.5 fw-bold text-white">
                            <i class="bi bi-pencil-square me-2"></i> Edit Profil
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        
        <div class="col-lg-8">
            <div class="card border-0 shadow-premium animate fade-up delay-1 h-100">
                <div class="card-header bg-white border-bottom border-light p-4 d-flex align-items-center gap-3">
                    <div class="icon-box-dash text-primary bg-primary bg-opacity-10 rounded-3">
                        <i class="bi bi-clock-history fs-5"></i>
                    </div>
                    <div>
                        <h5 class="fw-bold text-dark-clean mb-0 font-lexend">Aktivitas Terbaru</h5>
                        <p class="text-muted fs-8 mb-0">Riwayat transaksi dan pembaruan akun Anda</p>
                    </div>
                </div>
                <div class="card-body p-4 d-flex flex-column justify-content-center align-items-center py-5">
                    <div class="text-center py-4">
                        <div class="empty-state-icon mb-3 text-muted opacity-30">
                            <i class="bi bi-journal-x display-4"></i>
                        </div>
                        <h6 class="fw-semibold text-dark-clean mb-1">Belum Ada Aktivitas</h6>
                        <p class="text-muted small max-w-xs mx-auto mb-0">
                            Semua riwayat pemesanan atau perubahan akun Anda akan muncul di sini secara *real-time*.
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="d-flex flex-column gap-4">
                
                <div class="card border-0 shadow-premium card-widget-interactive animate fade-up delay-2">
                    <div class="card-body p-4 text-center position-relative overflow-hidden">
                        <div class="widget-accent-line bg-indigo"></div>
                        <div class="icon-shape-widget bg-indigo bg-opacity-10 text-indigo rounded-circle mx-auto mb-3">
                            <i class="bi bi-car-front-fill fs-3"></i>
                        </div>
                        <h5 class="fw-bold text-dark-clean font-lexend mb-1">Sewa Mobil Baru</h5>
                        <p class="small text-muted font-secondary px-3 mb-4">
                            Sewa kendaraan premium dengan driver handal atau sistem lepas kunci.
                        </p>
                        <a href="<?= Env::get('APP_URL') ?>/cars" class="btn btn-indigo-light w-100 rounded-pill py-2.5 fw-bold transition-all">
                            Cari Mobil Pilihan <i class="bi bi-chevron-right fs-8 ms-1"></i>
                        </a>
                    </div>
                </div>

                <div class="card border-0 shadow-premium card-widget-interactive animate fade-up delay-3">
                    <div class="card-body p-4 text-center position-relative overflow-hidden">
                        <div class="widget-accent-line bg-emerald"></div>
                        <div class="icon-shape-widget bg-emerald bg-opacity-10 text-emerald rounded-circle mx-auto mb-3">
                            <i class="bi bi-chat-left-dots-fill fs-3"></i>
                        </div>
                        <h5 class="fw-bold text-dark-clean font-lexend mb-1">Pusat Bantuan</h5>
                        <p class="small text-muted font-secondary px-3 mb-4">
                            Mengalami kendala? Tim CS kami siap membantu kelancaran perjalanan Anda.
                        </p>
                        <a href="<?= Env::get('APP_URL') ?>/customer/chat" class="btn btn-emerald-light w-100 rounded-pill py-2.5 fw-bold transition-all">
                            Mulai Live Chat <i class="bi bi-chat-fill fs-8 ms-1"></i>
                        </a>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<?php $alert = Session::getFlash('alert'); ?>
<?php if ($alert): ?>
    <div class="floating-alert-premium d-flex align-items-center gap-3 alert-<?= htmlspecialchars($alert['type']) ?> p-3 shadow-lg" role="alert">
        <div class="alert-icon-shield">
            <?php if($alert['type'] == 'success'): ?>
                <i class="bi bi-check-circle-fill fs-5"></i>
            <?php else: ?>
                <i class="bi bi-exclamation-triangle-fill fs-5"></i>
            <?php endif; ?>
        </div>
        <div class="alert-message-content">
            <strong class="d-block fs-7 text-dark-clean">Sistem Informasi</strong>
            <span class="fs-8 text-muted"><?= htmlspecialchars($alert['message']) ?></span>
        </div>
        <button type="button" class="btn-close-dash ms-auto" data-bs-dismiss="alert" aria-label="Close">
            <i class="bi bi-x-lg"></i>
        </button>
    </div>
<?php endif; ?>

<style>
    /* Premium Dashboard Layout Variables */
    :root {
        --dash-navy-gradient: linear-gradient(135deg, #0B1530 0%, #1E3A8A 100%);
        --primary-indigo: #4F46E5;
        --primary-indigo-dark: #4338CA;
        --emerald-success: #10B981;
        --text-headline: #0F172A;
        --text-body-muted: #64748B;
        --shadow-premium: 0 12px 40px rgba(15, 23, 42, 0.04);
        --shadow-hover: 0 20px 45px rgba(79, 70, 229, 0.08);
        --radius-dash: 20px;
    }

    .font-lexend { font-family: 'Lexend', sans-serif; }
    .font-secondary { font-family: 'Plus Jakarta Sans', sans-serif; }
    .text-dark-clean { color: var(--text-headline); }
    .fs-8 { font-size: 0.785rem; }
    .fs-9 { font-size: 0.7rem; }

    /* Welcome Banner Styling */
    .welcome-banner {
        background: var(--dash-navy-gradient);
        border-radius: var(--radius-dash);
        border: 1px solid rgba(255, 255, 255, 0.05);
        box-shadow: 0 20px 40px rgba(15, 23, 42, 0.15);
    }
    .banner-overlay-glow {
        position: absolute; top: -50px; right: -50px; width: 250px; height: 250px;
        background: radial-gradient(circle, rgba(2, 132, 199, 0.25) 0%, rgba(0,0,0,0) 70%);
        filter: blur(30px);
        pointer-events: none;
    }

    /* Premium Dashboard Buttons */
    .btn-dash-primary {
        background: #FFFFFF;
        color: #1E3A8A !important;
        border: none;
        transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
    }
    .btn-dash-primary:hover {
        transform: translateY(-2px);
        background: #F8FAFC;
        box-shadow: 0 8px 20px rgba(255, 255, 255, 0.2);
    }
    .btn-dash-outline {
        background: rgba(255, 255, 255, 0.04);
        border: 1px solid rgba(255, 255, 255, 0.15);
        backdrop-filter: blur(10px);
        transition: all 0.3s ease;
    }
    .btn-dash-outline:hover {
        background: rgba(255, 255, 255, 0.1);
        border-color: rgba(255, 255, 255, 0.3);
    }

    /* Cards Structure Modification */
    .shadow-premium {
        box-shadow: var(--shadow-premium);
        border: 1px solid rgba(226, 232, 240, 0.8);
        border-radius: var(--radius-dash);
    }
    .icon-box-dash {
        width: 44px; height: 44px;
        display: flex; align-items: center; justify-content: center;
    }

    /* Interactive Widgets Side */
    .card-widget-interactive {
        background: #FFFFFF;
        transition: all 0.4s cubic-bezier(0.16, 1, 0.3, 1);
    }
    .card-widget-interactive:hover {
        transform: translateY(-5px);
        box-shadow: var(--shadow-hover);
    }
    .widget-accent-line {
        position: absolute; top: 0; left: 0; width: 100%; height: 4px;
    }
    .widget-accent-line.bg-indigo { background: var(--primary-indigo); }
    .widget-accent-line.bg-emerald { background: var(--emerald-success); }
    
    .icon-shape-widget {
        width: 64px; height: 64px;
        display: flex; align-items: center; justify-content: center;
    }
    .bg-indigo { background-color: rgba(79, 70, 229, 1); }
    .text-indigo { color: var(--primary-indigo); }
    .bg-emerald { background-color: rgba(16, 185, 129, 1); }
    .text-emerald { color: var(--emerald-success); }

    /* Action Links for Widgets */
    .btn-indigo-light {
        background: #EEF2FF; color: var(--primary-indigo); border: none;
    }
    .btn-indigo-light:hover { background: var(--primary-indigo); color: white; }
    
    .btn-emerald-light {
        background: #ECFDF5; color: var(--emerald-success); border: none;
    }
    .btn-emerald-light:hover { background: var(--emerald-success); color: white; }

    /* Corporate Flash Toast / Alert Notification */
    .floating-alert-premium {
        position: fixed;
        bottom: 30px;
        right: 30px;
        z-index: 9999;
        min-width: 340px;
        max-width: 440px;
        background: #FFFFFF;
        border-radius: 16px;
        border-left: 5px solid var(--primary-indigo);
        box-shadow: 0 20px 50px rgba(15, 23, 42, 0.15);
        animation: slideInLeftDash 0.5s cubic-bezier(0.16, 1, 0.3, 1);
        will-change: transform, opacity;
    }
    .floating-alert-premium.alert-success { border-left-color: var(--emerald-success); }
    .floating-alert-premium.alert-success .alert-icon-shield { color: var(--emerald-success); }
    .floating-alert-premium.alert-danger { border-left-color: #EF4444; }
    .floating-alert-premium.alert-danger .alert-icon-shield { color: #EF4444; }
    
    .alert-icon-shield { display: flex; align-items: center; }
    .btn-close-dash {
        background: transparent; border: none; color: var(--text-body-muted);
        font-size: 0.85rem; transition: color 0.2s;
    }
    .btn-close-dash:hover { color: var(--text-headline); }

    /* Advanced Fluid Scroll Animations */
    .animate { opacity: 0; will-change: transform, opacity; }
    .fade-up {
        transform: translateY(25px);
        transition: opacity 1s cubic-bezier(0.16, 1, 0.3, 1), transform 1s cubic-bezier(0.16, 1, 0.3, 1);
    }
    .animate.show { opacity: 1; transform: translateY(0); }
    .delay-1 { transition-delay: 0.12s; }
    .delay-2 { transition-delay: 0.24s; }
    .delay-3 { transition-delay: 0.36s; }

    @keyframes slideInLeftDash {
        from { opacity: 0; transform: translateY(30px) scale(0.95); }
        to { opacity: 1; transform: translateY(0) scale(1); }
    }

    @media (max-width: 767.98px) {
        .welcome-banner { padding: 30px 20px; }
        .floating-alert-premium { right: 15px; left: 15px; bottom: 20px; min-width: auto; }
    }
</style>

<script>
document.addEventListener("DOMContentLoaded", function () {
    // Staggered Fade-in Observer
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

    // Toast Alert Push Notification Modern Controller
    const alertBox = document.querySelector('.floating-alert-premium');
    if (alertBox) {
        setTimeout(() => {
            alertBox.style.transition = 'all 0.6s cubic-bezier(0.16, 1, 0.3, 1)';
            alertBox.style.opacity = '0';
            alertBox.style.transform = 'translateY(20px) scale(0.95)';
            setTimeout(() => { alertBox.remove(); }, 600);
        }, 4000);
    }
});
</script>