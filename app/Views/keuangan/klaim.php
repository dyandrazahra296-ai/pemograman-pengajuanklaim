<!DOCTYPE html>
<html>
<head>
    <title>Klaim Disetujui HRD</title>
    <link rel="stylesheet" href="<?= base_url('css/keuangan-ui.css') ?>">
</head>
<body>

<div class="wrapper">

<div class="sidebar">
    <h2>💊 Klaim Obat</h2>
    <a href="<?= base_url('keuangan') ?>">Dashboard</a>
    <a href="<?= base_url('keuangan/klaim') ?>" class="active">Klaim</a>
    <a href="<?= base_url('keuangan/riwayat') ?>">Riwayat</a>
    <a href="<?= base_url('logout') ?>" class="text-danger-custom">
        <i class="fa-solid fa-right-from-bracket"></i> Logout
    </a>
</div>

<div class="main">

<h1>Klaim Disetujui HRD</h1>

<table>
<tr>
    <th>ID</th>
    <th>Nama</th>
    <th>NIK</th>
    <th>Position</th>
    <th>Department</th>
    <th>Nominal</th>
    <th>Aksi</th>
</tr>

<?php foreach ($klaim as $k): ?>
<tr>
    <td><?= $k['claim_id'] ?></td>
    <td><?= $k['full_name'] ?></td>
    <td><?= $k['employee_nik'] ?></td>
    <td><?= $k['position'] ?></td>
    <td><?= $k['department'] ?></td>
    <td>Rp <?= number_format($k['claim_amount'],0,',','.') ?></td>

    <td>
        <div style="display:flex; gap:6px">

            <form method="post" action="<?= base_url('keuangan/bayar/'.$k['claim_id']) ?>">
                <button class="btn btn-success">Bayarkan</button>
            </form>

            <form method="post"
                  action="<?= base_url('keuangan/tolak/'.$k['claim_id']) ?>"
                  onsubmit="return confirm('Yakin mau tolak klaim ini?')">

                <button class="btn btn-danger">Tolak</button>
            </form>

        </div>
    </td>
</tr>
<?php endforeach ?>

</table>

</div>
</div>
</body>
</html>
