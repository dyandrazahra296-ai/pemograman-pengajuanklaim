<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Keuangan</title>

    <!-- CSS GLOBAL -->
    <link rel="stylesheet" href="<?= base_url('css/keuangan-ui.css') ?>">
    <!-- CSS KHUSUS DASHBOARD -->
    <link rel="stylesheet" href="<?= base_url('css/keuangan.css') ?>">
</head>
<body>

<div class="wrapper">

    <!-- SIDEBAR -->
    <div class="sidebar">
        <h2>💊 Klaim Obat</h2>
        <a href="<?= base_url('keuangan') ?>" class="active">Dashboard</a>
        <a href="<?= base_url('keuangan/klaim') ?>">Klaim</a>
        <a href="<?= base_url('keuangan/riwayat') ?>">Riwayat</a>
        <a href="<?= base_url('logout') ?>" class="text-danger-custom">
        <i class="fa-solid fa-right-from-bracket"></i> Logout
    </a>
    </div>

    <!-- MAIN CONTENT -->
    <div class="main">
        <div class="topbar">
            <h1>Dashboard Statistik Per Karyawan</h1>
        </div>

        <?php
        $karyawanData = is_array($karyawanData ?? []) ? $karyawanData : [];
        ?>

        <!-- SEARCH + NAV -->
        <div class="dashboard-controls">
            <button class="nav-btn" onclick="prevKaryawan()">◀</button>
            <input type="text" id="searchNama" class="search-box" placeholder="Cari nama karyawan...">
            <button class="nav-btn" onclick="searchKaryawan()">Search</button>
            <button class="nav-btn" onclick="nextKaryawan()">▶</button>
        </div>

        <!-- KARYAWAN CARD -->
        <div class="karyawan-card">

            <h2 id="namaKaryawan">-</h2>

            <div class="stats-row">
                <div class="stat-box klaim">
                    <div>Total Klaim</div>
                    <h3 id="totalKlaim">0</h3>
                </div>

                <div class="stat-box total">
                    <div>Total Nominal</div>
                    <h3 id="totalNominal">0</h3>
                </div>

                <div class="stat-box limit">
                    <div>Plafon</div>
                    <h3 id="limitKlaim">0</h3>
                </div>
            </div>

            <!-- PROGRESS LIMIT -->
            <div class="limit-progress-wrapper">
                <div class="limit-progress-bar">
                    <div id="limitProgressFill"></div>
                </div>
                <div id="limitPersenText" class="limit-text"></div>
            </div>

            <!-- CHART -->
            <div class="chart-wrapper">
                <canvas id="chartKaryawan"></canvas>
            </div>

        </div>
    </div>
</div>

<!-- FOOTER -->
<div class="footer">
    &copy; <?= date('Y') ?> Dashboard Keuangan
</div>

<!-- MODERN POPUP -->
<div id="popupOverlay" class="modern-popup-overlay">
    <div id="modernPopup" class="modern-popup">
        <p id="popupMessage">Nama tidak ditemukan!</p>
        <button onclick="closePopup()">OK</button>
    </div>
</div>

<!-- SCRIPT -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    window.karyawanData = <?= json_encode($karyawanData) ?>;
</script>
<script src="<?= base_url('js/keuangan.js') ?>"></script>

</body>
</html>
