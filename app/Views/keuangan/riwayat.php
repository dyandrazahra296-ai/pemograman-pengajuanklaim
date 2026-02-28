<!DOCTYPE html>
<html>
<head>
    <title>Riwayat Pencairan</title>

    <link rel="stylesheet" href="<?= base_url('css/keuangan-ui.css') ?>">

    <style>
        .filter-box{
            background:#fff;
            padding:15px;
            border-radius:10px;
            box-shadow:0 2px 8px rgba(0,0,0,0.05);
            margin-bottom:20px;
        }

        .filter-box input{
            padding:8px;
            border:1px solid #ddd;
            border-radius:6px;
        }

        .filter-box button,
        .filter-box a{
            padding:8px 14px;
            border-radius:6px;
            text-decoration:none;
            font-size:14px;
        }

        .btn-primary{
            background:#2563eb;
            color:#fff;
            border:none;
        }

        .btn-secondary{
            background:#6b7280;
            color:#fff;
        }

        .table-wrapper{
            max-height:450px;
            overflow:auto;
            border:1px solid #ddd;
            border-radius:20px;
        }

        table{
            width:100%;
            border-collapse:collapse;
            background:#fff;
        }

        th, td{
            padding:10px;
            border-bottom:1px solid #eee;
            text-align:center;
        }

        th{
            background:#f9fafb;
            position:sticky;
            top:0;
            z-index:2;
        }

        .status-bayar{
            background:#22c55e;
            color:#fff;
            padding:4px 10px;
            border-radius:6px;
            font-size:12px;
            font-weight:600;
        }

        .status-tolak{
            background:#ef4444;
            color:#fff;
            padding:4px 10px;
            border-radius:6px;
            font-size:12px;
            font-weight:600;
        }

        .pagination-wrapper{
            margin-top:25px;
            display:flex;
            justify-content:center;
        }

        .pagination{
            display:flex;
            list-style:none;
            gap:6px;
            padding:0;
        }

        .pagination li{
            display:inline-block;
        }

        .pagination li a{
            display:block;
            padding:8px 14px;
            border-radius:8px;
            background:#f3f4f6;
            text-decoration:none;
            color:#333;
            font-weight:500;
            transition:0.2s ease;
        }

        .pagination li a:hover{
            background:#2563eb;
            color:#fff;
        }

        .pagination li.active a{
            background:#2563eb;
            color:#fff;
            font-weight:bold;
        }

        .pagination li.disabled a{
            background:#e5e7eb;
            color:#999;
            pointer-events:none;
        }

        .text-danger-custom {
        color: #f87171 !important; /* Warna merah yang lebih soft untuk dark theme */
    }

    .text-danger-custom:hover {
        background: rgba(239, 68, 68, 0.15) !important;
    }

    </style>
</head>

<body>

<div class="wrapper">

    <!-- ================= SIDEBAR ================= -->
    <div class="sidebar">
        <h2>💊 Klaim Obat</h2>

        <a href="<?= base_url('keuangan') ?>">Dashboard</a>
        <a href="<?= base_url('keuangan/klaim') ?>">Klaim</a>
        <a href="<?= base_url('keuangan/riwayat') ?>" class="active">Riwayat</a>
        <a href="<?= base_url('logout') ?>" class="text-danger-custom">
        <i class="fa-solid fa-right-from-bracket"></i> Logout
    </a>
    </div>

    <!-- ================= MAIN ================= -->
    <div class="main">

        <h1>Riwayat Pencairan</h1>

        <!-- ================= FILTER ================= -->
        <div class="filter-box">
            <form method="get" style="display:flex; gap:10px; flex-wrap:wrap; align-items:center;">

                <input type="text" name="keyword"
                       placeholder="Cari Nama / NIK"
                       value="<?= esc($_GET['keyword'] ?? '') ?>">

                <input type="date" name="start"
                       value="<?= esc($_GET['start'] ?? '') ?>">

                <input type="date" name="end"
                       value="<?= esc($_GET['end'] ?? '') ?>">

                <button type="submit" class="btn-primary">Filter</button>

                <a href="<?= base_url('keuangan/riwayat') ?>" class="btn-secondary">
                    Reset
                </a>

                <a href="<?= base_url('keuangan/export/pdf') . '?' . http_build_query($_GET) ?>"
                   target="_blank"
                   class="btn-primary">
                    Export PDF
                </a>

            </form>
        </div>

        <!-- ================= TABLE ================= -->
        <div class="table-wrapper">
            <table>
                <tr>
                    <th>ID</th>
                    <th>Nama</th>
                    <th>NIK</th>
                    <th>Position</th>
                    <th>Department</th>
                    <th>Nominal</th>
                    <th>Status</th>
                    <th>Tanggal Proses</th>
                </tr>

                <?php if(!empty($klaim)): ?>

                    <?php foreach ($klaim as $k): ?>
                        <tr>
                            <td><?= $k['claim_id'] ?></td>
                            <td><?= esc($k['full_name']) ?></td>
                            <td><?= esc($k['employee_nik']) ?></td>
                            <td><?= esc($k['position']) ?></td>
                            <td><?= esc($k['department']) ?></td>

                            <td>
                                Rp <?= number_format($k['claim_amount'],0,',','.') ?>
                            </td>

                            <td>
                                <?php if($k['status'] === 'DIBAYARKAN_KEUANGAN'): ?>
                                    <span class="status-bayar">DIBAYAR</span>
                                <?php elseif($k['status'] === 'DITOLAK_KEUANGAN'): ?>
                                    <span class="status-tolak">DITOLAK</span>
                                <?php else: ?>
                                    -
                                <?php endif; ?>
                            </td>

                            <td>
                                <?= !empty($k['paid_at'])
                                    ? date('d-m-Y H:i', strtotime($k['paid_at']))
                                    : date('d-m-Y H:i') ?>
                            </td>

                        </tr>
                    <?php endforeach ?>

                <?php else: ?>

                    <tr>
                        <td colspan="8" style="padding:20px;">
                            Tidak ada data ditemukan
                        </td>
                    </tr>

                <?php endif; ?>

            </table>
        </div>

        <!-- ================= PAGINATION ================= -->
        <div class="pagination-wrapper">
    <?= $pager->links() ?>
</div>

    </div>
</div>

</body>
</html>
