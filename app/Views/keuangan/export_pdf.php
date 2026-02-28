<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Klaim Keuangan</title>

    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            font-size: 11pt;
            color: #1f2937;
            margin: 20px;
        }

        header {
            display: flex;
            align-items: center;
            justify-content: flex-start;
            margin-bottom: 15px;
            border-bottom: 2px solid #4f46e5;
            padding-bottom: 5px;
        }

        header img {
            height: 50px;
            margin-right: 15px;
        }

        header h2 {
            flex: 1;
            text-align: center;
            color: #4f46e5;
            font-size: 18pt;
            margin: 0;
        }

        table {
            border-collapse: collapse;
            width: 100%;
            table-layout: auto; /* menyesuaikan lebar kolom */
            margin-top: 10px;
        }

        thead th {
            background-color: #4f46e5;
            color: white;
            font-weight: 600;
            padding: 8px;
            border: 1px solid #d1d5db;
            text-align: center;
        }

        tbody td {
            padding: 6px 8px;
            border: 1px solid #e5e7eb;
            text-align: center;
            word-wrap: break-word;
            font-size: 10pt;
        }

        tbody tr:nth-child(even) {
            background-color: #f9fafb;
        }

        .status-DIBAYARKAN_KEUANGAN {
            background-color: #16a34a;
            color: white;
            font-weight: 600;
            padding: 2px 6px;
            border-radius: 8px;
            display: inline-block;
            font-size: 9pt;
        }

        .status-DITOLAK_KEUANGAN {
            background-color: #dc2626;
            color: white;
            font-weight: 600;
            padding: 2px 6px;
            border-radius: 8px;
            display: inline-block;
            font-size: 9pt;
        }

        tfoot td {
            font-weight: 600;
            background-color: #e0e7ff;
            padding: 8px;
            text-align: center;
        }

        footer {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            font-size: 9pt;
            color: #6b7280;
            text-align: center;
        }

        .page-number:after {
            content: counter(page);
        }
    </style>
</head>
<body>

<header>
    <h2>LAPORAN KLAIM KEUANGAN</h2>
</header>

<table>
<thead>
<tr>
    <th>No</th>
    <th>Nama</th>
    <th>NIK</th>
    <th>Position</th>
    <th>Department</th>
    <th>ID Klaim</th>
    <th>Nominal</th>
    <th>Status</th>
    <th>Tanggal</th>
</tr>
</thead>
<tbody>
<?php
$total_all = 0;
$no=1; 
foreach ($klaim as $k):
    $total_all += $k['claim_amount'];
?>
<tr>
    <td><?= $no++ ?></td>
    <td><?= $k['full_name'] ?></td>
    <td><?= $k['employee_nik'] ?></td>
    <td><?= $k['position'] ?></td>
    <td><?= $k['department'] ?></td>
    <td><?= $k['claim_id'] ?></td>
    <td>Rp <?= number_format($k['claim_amount'],0,',','.') ?></td>
    <td class="status-<?= $k['status'] ?>"><?= $k['status'] ?></td>
    <td><?= !empty($k['paid_at']) ? date('d-m-Y H:i', strtotime($k['paid_at'])) : '-' ?></td>
</tr>
<?php endforeach ?>
</tbody>
<tfoot>
<tr>
    <td colspan="6">Total Keseluruhan</td>
    <td colspan="3">Rp <?= number_format($total_all,0,',','.') ?></td>
</tr>
</tfoot>
</table>

<footer>
    Dicetak pada: <?= date('d-m-Y H:i') ?> | Halaman <span class="page-number"></span>
</footer>

</body>
</html>
