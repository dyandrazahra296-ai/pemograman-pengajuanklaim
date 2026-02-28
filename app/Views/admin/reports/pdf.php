<!DOCTYPE html>
<html>
<head>
    <title>Laporan Klaim Medis</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #000;
            padding: 6px;
            font-size: 12px;
        }
        th {
            background: #eee;
        }
    </style>
</head>
<body>

<h3 align="center">Laporan Klaim Medis</h3>

<table>
    <tr>
        <th>No</th>
        <th>Tanggal</th>
        <th>Nominal</th>
        <th>Status</th>
    </tr>

    <?php $no=1; foreach($claims as $c): ?>
    <tr>
        <td><?= $no++ ?></td>
        <td><?= date('d-m-Y', strtotime($c['claim_date'])) ?></td>
        <td>Rp <?= number_format($c['claim_amount'], 0, ',', '.') ?></td>
        <td><?= $c['status'] ?></td>
    </tr>
    <?php endforeach; ?>
</table>

</body>
</html>
