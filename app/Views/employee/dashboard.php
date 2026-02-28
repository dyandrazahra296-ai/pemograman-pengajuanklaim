<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard | Medical Claim</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background: #f4f6f9;
            font-family: 'Segoe UI', sans-serif;
        }
        .card {
            border: none;
            border-radius: 14px;
            box-shadow: 0 8px 25px rgba(0,0,0,.08);
        }
        .stat-value {
            font-size: 28px;
            font-weight: 600;
        }
        .stat-label {
            color: #6c757d;
            font-size: 14px;
        }
    </style>
</head>
<body>

<?= view('layout/sidebar') ?>

<div class="container py-4">

    <!-- HEADER -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4>Halo 👋</h4>
        <a href="<?= base_url('/logout') ?>" class="btn btn-outline-danger btn-sm">
            Logout
        </a>
    </div>

    <!-- =======================
         INFO LIMIT
    ======================== -->
    <?php if (!empty($limit)): ?>
    <div class="row mb-4">

        <div class="col-md-4">
            <div class="card p-4">
                <div class="stat-label">Plafon Tahunan</div>
                <div class="stat-value">
                    Rp <?= number_format($limit['total_limit'] ?? 0, 0, ',', '.') ?>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card p-4">
                <div class="stat-label">Sudah Digunakan</div>
                <div class="stat-value text-warning">
                    Rp <?= number_format($limit['used_amount'] ?? 0, 0, ',', '.') ?>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card p-4">
                <div class="stat-label">Sisa Plafon</div>
                <div class="stat-value text-success">
                    Rp <?= number_format(
                        ($limit['total_limit'] ?? 0) - ($limit['used_amount'] ?? 0),
                        0,
                        ',',
                        '.'
                    ) ?>
                </div>
            </div>
        </div>

    </div>
    <?php endif; ?>

    <!-- =======================
         KONDISI PLAFON
    ======================== -->
    <?php if (empty($limit)): ?>

        <div class="alert alert-info">
            Kamu belum memiliki plafon klaim.
            Silakan ajukan plafon terlebih dahulu.
        </div>

        <form action="<?= base_url('/claims/limit') ?>" method="post">
            <?= csrf_field() ?>
            <button type="submit" class="btn btn-primary">
                Ajukan Plafon
            </button>
        </form>

    <?php else: ?>

        <?php if (($limit['status'] ?? '') === 'DISETUJUI_HRD'): ?>
            <a href="<?= base_url('/claims/create') ?>" class="btn btn-primary mb-4">
                Ajukan Klaim
            </a>
        <?php else: ?>
            <div class="alert alert-warning">
                Plafon sedang <strong>menunggu persetujuan HRD</strong>.
            </div>
        <?php endif; ?>

    <?php endif; ?>

    <!-- =======================
         RIWAYAT KLAIM
    ======================== -->
    <div class="card p-4 mt-4">
        <h5 class="mb-3">Riwayat Pengajuan Klaim</h5>

        <table class="table table-bordered table-striped align-middle">
            <thead class="table-light">
                <tr>
                    <th width="5%">No</th>
                    <th>Tanggal</th>
                    <th>Nominal</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
            <?php if (empty($claims)): ?>
                <tr>
                    <td colspan="4" class="text-center text-muted">
                        Belum ada pengajuan klaim
                    </td>
                </tr>
            <?php else: ?>
                <?php $no = 1; foreach ($claims as $c): ?>
                    <tr>
                        <td><?= $no++ ?></td>
                        <td><?= date('d-m-Y', strtotime($c['claim_date'])) ?></td>
                        <td>Rp <?= number_format($c['amount'] ?? 0, 0, ',', '.') ?></td>
                        <td>
                            <?php if ($c['status'] === 'MENUNGGU_HRD'): ?>
                                <span class="badge bg-warning text-dark">Menunggu HRD</span>
                            <?php elseif ($c['status'] === 'DISETUJUI_HRD'): ?>
                                <span class="badge bg-success">Disetujui</span>
                            <?php else: ?>
                                <span class="badge bg-danger">Ditolak</span>
                            <?php endif ?>
                        </td>
                    </tr>
                <?php endforeach ?>
            <?php endif; ?>
            </tbody>
        </table>
    </div>

</div>

</body>
</html>
