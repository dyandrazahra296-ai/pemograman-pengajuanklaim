<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

<style>
    .sidebar {
        position: fixed;
        top: 0;
        left: 0;
        width: 280px;
        height: 100vh;
        background: linear-gradient(180deg, #1f2933, #111827);
        padding: 28px 22px;
        color: #fff;
        box-shadow: 6px 0 18px rgba(0,0,0,.18);
        z-index: 1000;
    }

    .sidebar h5 {
        font-weight: 600;
        margin-bottom: 36px;
        display: flex;
        align-items: center;
        gap: 10px;
        font-size: 18px;
        color: #fff;
    }

    .sidebar a {
        display: flex;
        align-items: center;
        gap: 14px;
        color: #cbd5e1;
        text-decoration: none;
        padding: 14px 18px; 
        margin-bottom: 10px;
        border-radius: 12px;
        transition: all .25s ease;
        font-size: 15px;
    }

    .sidebar a i {
        width: 22px;
        text-align: center;
        font-size: 16px;
    }

    .sidebar a:hover {
        background: rgba(255,255,255,.1);
        color: #fff;
    }

    .sidebar a.active {
        background: #2563eb;
        color: #fff;
        font-weight: 600;
    }

    .sidebar hr {
        border-color: rgba(255,255,255,.15);
        margin: 24px 0;
        opacity: 1;
    }

    .text-danger-custom {
        color: #f87171 !important; /* Warna merah yang lebih soft untuk dark theme */
    }

    .text-danger-custom:hover {
        background: rgba(239, 68, 68, 0.15) !important;
    }

    /* Main Content */
    .main-content {
        margin-left: 280px; 
        padding: 32px;
    }

    /* MOBILE */
    @media (max-width: 768px) {
        .sidebar {
            position: relative;
            width: 100%;
            height: auto;
            padding: 20px;
        }
        .main-content {
            margin-left: 0;
            padding: 20px;
        }
    }
</style>

<div class="sidebar">
    <h5><i class="fa-solid fa-heart-pulse text-primary"></i> Medical Claim</h5>

    <a href="<?= base_url('karyawan/dashboard') ?>" class="<?= url_is('karyawan/dashboard*') ? 'active' : '' ?>">
        <i class="fa-solid fa-chart-line"></i> Dashboard
    </a>

    <a href="<?= base_url('karyawan/medical-claim') ?>" class="<?= url_is('karyawan/medical-claim*') ? 'active' : '' ?>">
        <i class="fa-solid fa-file-medical"></i> Ajukan Klaim
    </a>

    <a href="<?= base_url('karyawan/change-password') ?>" class="<?= url_is('karyawan/change-password*') ? 'active' : '' ?>">
        <i class="fa-solid fa-key"></i> Ganti Password
    </a>

    <hr>

    <a href="<?= base_url('karyawan/profile') ?>" class="<?= url_is('karyawan/profile') ? 'active' : '' ?>">
        <i class="fa-solid fa-user"></i> Profile
    </a>

    <a href="<?= base_url('logout') ?>" class="text-danger-custom">
        <i class="fa-solid fa-right-from-bracket"></i> Logout
    </a>
</div>