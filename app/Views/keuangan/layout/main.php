<!DOCTYPE html>
<html>
<head>
    <title>Keuangan</title>
    <link rel="stylesheet" href="<?= base_url('assets/css/keuangan.css') ?>">
</head>
<body>

<nav>
    <a href="/keuangan">Dashboard</a>
    <a href="/keuangan/klaim">Klaim</a>
    <a href="/keuangan/riwayat">Riwayat</a>
</nav>

<main>
    <?= $this->renderSection('content') ?>
</main>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="<?= base_url('assets/js/keuangan.js') ?>"></script>
</body>
</html>
