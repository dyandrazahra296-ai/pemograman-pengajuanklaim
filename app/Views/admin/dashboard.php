<?= $this->extend('admin/layout') ?>
<?= $this->section('content') ?>
<?php $title = 'Dashboard'; ?>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<!-- ================= STAT CARDS ================= -->
<div class="row g-4 mb-4">

    <div class="col-md-3">
        <div class="stat-card blue">
            <h6>Total User</h6>
            <h2><?= $totalUsers ?></h2>
        </div>
    </div>

    <div class="col-md-3">
        <div class="stat-card green">
            <h6>User Aktif</h6>
            <h2><?= $activeUsers ?></h2>
        </div>
    </div>

    <div class="col-md-3">
        <div class="stat-card orange">
            <h6>User Nonaktif</h6>
            <h2><?= $inactiveUsers ?></h2>
        </div>
    </div>

    <div class="col-md-3">
        <div class="stat-card silver">
            <h6>Total Karyawan</h6>
            <h2><?= $totalEmployees ?></h2>
        </div>
    </div>

</div>

<!-- ================= KLAIM ================= -->
<div class="row g-4 mb-5">

    <div class="col-md-4">
        <div class="stat-card green">
            <h6>Klaim Disetujui</h6>
            <h2><?= $approvedClaims ?></h2>
        </div>
    </div>

    <div class="col-md-4">
        <div class="stat-card orange">
            <h6>Klaim Pending</h6>
            <h2><?= $pendingClaims ?></h2>
        </div>
    </div>

    <div class="col-md-4">
        <div class="stat-card red">
            <h6>Klaim Ditolak</h6>
            <h2><?= $rejectedClaims ?></h2>
        </div>
    </div>

</div>

<!-- ================= USER PER ROLE ================= -->
<div class="card-admin mb-5">
    <h5 class="mb-3">User Berdasarkan Role</h5>

    <table class="table table-admin">
        <thead>
            <tr>
                <th>Role</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($usersByRole as $r): ?>
                <tr>
                    <td>
                        <span class="badge-role role-<?= strtolower($r['role']) ?>">
                            <?= strtoupper($r['role']) ?>
                        </span>
                    </td>
                    <td><?= $r['total'] ?></td>
                </tr>
            <?php endforeach ?>
        </tbody>
    </table>
</div>

<!-- ================= CHART ================= -->
<div class="card-admin">
    <h5 class="mb-3">Statistik Klaim Bulanan</h5>
    <canvas id="klaimChart" height="120"></canvas>
</div>

<script>
new Chart(document.getElementById('klaimChart'), {
    type: 'line',
    data: {
        labels: <?= json_encode($chartLabels) ?>,
        datasets: [{
            label: 'Total Klaim',
            data: <?= json_encode($chartData) ?>,
            borderColor: '#5b6cff',
            backgroundColor: 'rgba(91,108,255,.15)',
            tension: 0.4,
            fill: true
        }]
    },
    options: {
        plugins: {
            legend: { display: false }
        },
        scales: {
            y: { beginAtZero: true }
        }
    }
});
</script>

<?= $this->endSection() ?>
