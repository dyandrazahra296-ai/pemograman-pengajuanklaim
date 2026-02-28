<aside class="sidebar">
    <div class="sidebar-header">
        <h4>💊 Klaim Obat</h4>
        <span>Admin Control</span>
    </div>

    <nav class="sidebar-menu">
        <a href="<?= base_url('dashboard') ?>">🏠 Dashboard</a>

        <div class="menu-title">MASTER</div>
        <a href="<?= base_url('users') ?>">👥 Manajemen User</a>
        <a href="<?= base_url('employees') ?>">🧑‍💼 Data Karyawan</a>

        <div class="menu-title">KLAIM</div>
        <a href="<?= base_url('claims') ?>">🧾 Klaim Masuk</a>
        <a href="<?= base_url('claims/history') ?>">📑 Riwayat Klaim</a>

        <div class="menu-title">LAPORAN</div>
        <a href="<?= base_url('reports') ?>">📊 Laporan Bulanan</a>

        <a href="<?= base_url('logout') ?>" class="logout">🚪 Logout</a>
    </nav>
</aside>
