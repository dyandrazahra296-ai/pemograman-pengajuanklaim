<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Admin Panel | Klaim Obat</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Admin CSS -->
    <link rel="stylesheet" href="<?= base_url('css/admin.css') ?>">
</head>
<body>

<!-- ================= SIDEBAR ================= -->
<aside class="sidebar">
    <div class="sidebar-header">
        <h4>💊 Klaim Obat</h4>
        <span>Admin Control</span>
    </div>

    <nav class="sidebar-menu">

        <a href="<?= base_url('dashboard') ?>" class="<?= url_is('dashboard*') ? 'active' : '' ?>">
            🏠 Dashboard
        </a>

        <div class="menu-title">MASTER</div>

        <a href="<?= base_url('users') ?>" class="<?= url_is('users*') ? 'active' : '' ?>">
            👥 Manajemen User
        </a>

        <a href="<?= base_url('employees') ?>" class="<?= url_is('employees*') ? 'active' : '' ?>">
            🧑‍💼 Data Karyawan
        </a>

        <!-- KLAIM -->
        <div class="menu-title">KLAIM</div>

        <a href="<?= base_url('claims') ?>"
            class="<?= url_is('claims') ? 'active' : '' ?>">
         🧾 Klaim Masuk
        </a>
        <a href="<?= base_url('claims/history') ?>"
           class="<?= url_is('claims/history*') ? 'active' : '' ?>">
            📑 Riwayat Klaim
        </a>

        <!-- LAPORAN -->
        <div class="menu-title">LAPORAN</div>

        <a href="<?= base_url('reports') ?>"
           class="<?= url_is('reports*') ? 'active' : '' ?>">
            📊 Laporan
        </a>

    </nav>
</aside>

<!-- ================= MAIN ================= -->
<div class="main-wrapper">

    <!-- TOPBAR -->
    <header class="topbar">
        <div class="page-title"><?= esc($title ?? 'Dashboard') ?></div>

        <!-- USER DROPDOWN -->
        <div class="dropdown">
            <button
                class="user-box btn p-0 border-0 bg-transparent d-flex align-items-center gap-2"
                data-bs-toggle="dropdown"
                aria-expanded="false"
            >
                <div class="user-avatar">
                    <?= strtoupper(substr(session('username'), 0, 1)) ?>
                </div>

                <div class="user-info text-start">
                    <div class="user-name"><?= esc(session('username')) ?></div>
                    <div class="user-role"><?= esc(session('role')) ?></div>
                </div>
            </button>

            <ul class="dropdown-menu dropdown-menu-end shadow">
                <li>
                    <a class="dropdown-item" href="<?= base_url('profile') ?>">
                        👤 My Profile
                    </a>
                </li>
                <li><hr class="dropdown-divider"></li>
                <li>
                    <a class="dropdown-item text-danger" href="<?= base_url('logout') ?>">
                        🚪 Logout
                    </a>
                </li>
            </ul>
        </div>
    </header>

    <!-- CONTENT -->
    <main class="content">
        <?= $this->renderSection('content') ?>
    </main>

</div>

<!-- ================= JS ================= -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="<?= base_url('js/admin.js') ?>"></script>

<?php if (session()->getFlashdata('new_password')): ?>
<script>
Swal.fire({
    title: 'Password Baru',
    html: '<b><?= session()->getFlashdata('new_password') ?></b>',
    icon: 'success',
    confirmButtonText: 'OK'
});
</script>
<?php endif; ?>

</body>
</html>
