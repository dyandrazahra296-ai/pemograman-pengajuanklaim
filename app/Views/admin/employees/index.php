<?= $this->extend('admin/layout') ?>
<?= $this->section('content') ?>

<h4 class="mb-1">Data Karyawan</h4>
<p class="text-muted mb-4">
    Data ini bersifat <b>monitoring</b> dan dikelola oleh sistem HRD.
</p>

<!-- STAT -->
<div class="row g-3 mb-4">
    <div class="col-md-4">
        <div class="stat-card silver">
            <h6>Total Karyawan</h6>
            <h2><?= count($employees) ?></h2>
        </div>
    </div>
</div>

<!-- TABLE -->
<div class="card-admin">
    <table class="table table-admin">
        <thead>
            <tr>
                <th>No</th>
                <th>NIK</th>
                <th>Nama</th>
                <th>Departemen</th>
                <th>Jabatan</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($employees)): ?>
                <tr>
                    <td colspan="5" class="text-center text-muted">
                        Data karyawan belum tersedia
                    </td>
                </tr>
            <?php else: ?>
                <?php foreach ($employees as $i => $e): ?>
                    <tr>
                        <td><?= $i + 1 ?></td>
                        <td><?= esc($e['employee_nik']) ?></td>
                        <td><?= esc($e['full_name']) ?></td>
                        <td><?= esc($e['department']) ?></td>
                        <td><?= esc($e['position']) ?></td>
                    </tr>
                <?php endforeach ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?= $this->endSection() ?>
