<?= $this->extend('admin/layout') ?>
<?= $this->section('content') ?>

<h4 class="mb-1">Riwayat Klaim</h4>
<p class="text-muted mb-4">
    Riwayat seluruh klaim yang telah diproses.
</p>

<div class="card-admin">
    <table class="table table-admin">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Tanggal</th>
                <th>Nominal</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>

        <?php if (empty($claims)): ?>
            <tr>
                <td colspan="5" class="text-center text-muted">
                    Belum ada riwayat klaim
                </td>
            </tr>
        <?php endif ?>

        <?php foreach ($claims as $i => $c): ?>
            <tr>
                <td><?= $i + 1 ?></td>

                <!-- NAMA -->
                <td>
                    <?= esc($c['emp_name'] ?? '-') ?>
                    <?php if (!empty($c['dep_name'])): ?>
                        <br>
                        <small class="text-muted">
                            (<?= esc($c['dep_name']) ?>)
                        </small>
                    <?php endif ?>
                </td>

                <td><?= date('d M Y', strtotime($c['claim_date'])) ?></td>
                <td>Rp <?= number_format($c['claim_amount'], 0, ',', '.') ?></td>

                <td>
                    <?php
                        $statusClass = match ($c['status']) {
                            'DISETUJUI_HRD'        => 'status-approved',
                            'DITOLAK_HRD'          => 'status-rejected',
                            'DIBAYARKAN_KEUANGAN'  => 'status-paid',
                            default                => 'status-pending',
                        };

                        $statusText = match ($c['status']) {
                            'DISETUJUI_HRD'        => 'Disetujui HRD',
                            'DITOLAK_HRD'          => 'Ditolak HRD',
                            'DIBAYARKAN_KEUANGAN'  => 'Sudah Dibayar',
                            default                => 'Pengajuan',
                        };
                    ?>

                    <span class="status-card <?= $statusClass ?>">
                        <?= $statusText ?>
                    </span>
                </td>
            </tr>
        <?php endforeach ?>

        </tbody>
    </table>
</div>

<?= $this->endSection() ?>
