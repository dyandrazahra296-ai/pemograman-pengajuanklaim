<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard | Klaim Karyawan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <style>
        body { background: #f4f6f9; font-family: 'Segoe UI', sans-serif; }
        .card { border: none; border-radius: 10px; box-shadow: 0 4px 12px rgba(0,0,0,.05); }
        .stat-card { color: #fff; padding: 20px; border-radius: 8px; }
        .bg-plafon { background: #0d6efd; }
        .bg-used { background: #ffc107; color: #000; }
        .bg-remaining { background: #198754; }
        .bg-total-claim { background: #0dcaf0; }
        .stat-value { font-size: 22px; font-weight: 700; }
        .chart-container { height: 250px; }
    </style>
</head>
<body>
<?= view('karyawan/layout/sidebar') ?>

<div class="container py-4">

<?php
$total  = $limit['max_claim_amount'] ?? 0;
$used   = $limit['used_amount'] ?? 0;
$remain = $total - $used;
$countClaims = count($claims ?? []);
?>

<div class="mb-4">
    <h4>Medical-Claim</h4>
    <small class="text-muted">
        Selamat Datang, <?= esc($employee['full_name'] ?? 'User') ?>
    </small>
</div>

<!-- STAT -->
<div class="row g-3 mb-4">
    <div class="col-md-3">
        <div class="card stat-card bg-plafon">
            Total Plafon
            <div class="stat-value">Rp <?= number_format($total,0,',','.') ?></div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card stat-card bg-used">
            Terpakai
            <div class="stat-value">Rp <?= number_format($used,0,',','.') ?></div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card stat-card bg-remaining">
            Sisa
            <div class="stat-value">Rp <?= number_format($remain,0,',','.') ?></div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card stat-card bg-total-claim">
            Total Klaim
            <div class="stat-value"><?= $countClaims ?></div>
        </div>
    </div>
</div>

<!-- CHART -->
<div class="row g-4 mb-4">
    <div class="col-md-6">
        <div class="card p-3">
            <h6>Grafik Klaim Bulanan</h6>
            <div class="chart-container">
                <canvas id="barChart"></canvas>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card p-3">
            <h6>Komposisi Klaim</h6>
            <div class="chart-container">
                <canvas id="pieChart"></canvas>
            </div>
        </div>
    </div>
</div>

<!-- TABLE -->
<div class="card p-4">
    <h5>Riwayat Klaim</h5>
    <table class="table table-hover">
        <thead>
        <tr>
            <th>Tanggal</th>
            <th>Untuk</th>
            <th>Jumlah</th>
            <th>Status</th>
        </tr>
        </thead>
        <tbody>
        <?php if (empty($claims)): ?>
            <tr><td colspan="4" class="text-center">Belum ada data</td></tr>
        <?php else: foreach ($claims as $c): ?>
            <tr>
                <td><?= date('Y-m-d', strtotime($c['claim_date'])) ?></td>
               <td>
<?php if ($c['dependent_id']): ?>
    <?= $c['full_name'] ?> (<?= $c['relationship'] ?>)
<?php else: ?>
    Diri Sendiri
<?php endif; ?>
</td>

                <td>Rp <?= number_format($c['claim_amount'],0,',','.') ?></td>
                <td>
<?php
$status = strtoupper($c['status']);

switch ($status) {

    case 'DIBAYARKAN_KEUANGAN':
        echo '<span class="badge bg-primary">Dibayarkan</span>';
        break;

    case 'DISETUJUI_HRD':
        echo '<span class="badge bg-success">Disetujui HRD</span>';
        break;

    case 'DITOLAK_HRD':
        echo '<span class="badge bg-danger">Ditolak HRD</span>';
        break;

    case 'PENGAJUAN':
    default:
        echo '<span class="badge bg-warning text-dark">Menunggu</span>';
}
?>
</td>
            </tr> 
        <?php endforeach; endif; ?>
        </tbody>
    </table>
</div>

</div>

<script>
// BAR
new Chart(document.getElementById('barChart'), {
    type: 'bar',
    data: {
        labels: ['Jan','Feb','Mar','Apr','Mei','Jun'],
        datasets: [{
            label: 'Jumlah Klaim',
            data: <?= json_encode($chartBulanan ?? [0,0,0,0,0,0]) ?>,
            backgroundColor: '#9ad0f5'
        }]
    },
    options: { maintainAspectRatio:false }
});

// PIE
new Chart(document.getElementById('pieChart'), {
    type: 'pie',
    data: {
        labels: ['Karyawan','Pasangan','Anak'],
        datasets: [{
            data: <?= json_encode($komposisi ?? [0,0,0]) ?>,
            backgroundColor: ['#0d6efd','#ffc107','#198754']
        }]
    },
    options: { maintainAspectRatio:false }
});

const rupiah = document.getElementById('rupiah');

rupiah.addEventListener('input', function(e) {
    let value = this.value.replace(/\D/g, '');
    this.value = new Intl.NumberFormat('id-ID').format(value);
});
</script>

</body>
</html>
