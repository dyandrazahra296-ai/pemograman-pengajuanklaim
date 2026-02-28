<?= $this->extend('admin/layout') ?>
<?= $this->section('content') ?>

<h4 class="mb-1">Klaim Masuk</h4>
<p class="text-muted mb-4">
    Daftar klaim kesehatan yang masih <b>menunggu proses</b>.
</p>

<div class="row g-3 mb-4">
    <div class="col-md-4">
        <div class="stat-card orange">
            <h6>Klaim Pending</h6>
            <h2><?= $totalPending ?></h2>
        </div>
    </div>
</div>

<div class="card-admin">
    <table class="table table-admin">
        <thead>
            <tr>
                <th>No</th>
                <th>Karyawan</th>
                <th>Departemen</th>
                <th>Tanggal</th>
                <th>Nominal</th>
                <th>Deskripsi</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>

        <?php if (empty($claims)): ?>
            <tr>
                <td colspan="7" class="text-center text-muted">
                    Tidak ada klaim masuk
                </td>
            </tr>
        <?php endif; ?>

        <?php foreach ($claims as $i => $c): ?>
            <tr>
                <td><?= $i + 1 ?></td>
                <td><?= esc($c['employee_name']) ?></td>
                <td><?= esc($c['department']) ?></td>
                <td><?= date('d M Y', strtotime($c['claim_date'])) ?></td>
                <td>Rp <?= number_format($c['claim_amount'], 0, ',', '.') ?></td>
                <td><?= esc($c['claim_description']) ?></td>
                <td>
                    <span class="status-badge status-inactive">
                        PENGAJUAN
                    </span>
                </td>
            </tr>
        <?php endforeach; ?>

        </tbody>
    </table>
</div>

<?= $this->endSection() ?>
