<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Hasil Laporan Klaim</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-4">

    <h4 class="mb-3">📊 Hasil Laporan Klaim</h4>

    <div class="mb-3">
        <a href="<?= base_url('reports') ?>" class="btn btn-secondary btn-sm">⬅ Kembali</a>
        <a href="<?= base_url('reports/export-pdf') ?>" class="btn btn-danger btn-sm">📄 Export PDF</a>
        <a href="<?= base_url('reports/export-excel') ?>" class="btn btn-success btn-sm">📊 Export Excel</a>
    </div>

    <div class="table-responsive">
        <table class="table table-bordered table-striped">
            <thead class="table-dark text-center">
                <tr>
                    <th>No</th>
                    <th>Tanggal Klaim</th>
                    <th>Nominal</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($claims)): ?>
                    <tr>
                        <td colspan="4" class="text-center">Data tidak ditemukan</td>
                    </tr>
                <?php else: ?>
                    <?php $no = 1; foreach ($claims as $c): ?>
                        <tr>
                            <td class="text-center"><?= $no++ ?></td>
                            <td><?= date('d-m-Y', strtotime($c['claim_date'])) ?></td>
                            <td>Rp <?= number_format($c['claim_amount'], 0, ',', '.') ?></td>
                            <td class="text-center">
                                <span class="badge bg-info">
                                    <?= $c['status'] ?>
                                </span>
                            </td>
                        </tr>
                    <?php endforeach ?>
                <?php endif ?>
            </tbody>
        </table>
    </div>

</div>

</body>
</html>
