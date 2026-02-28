<?= $this->extend('admin/layout') ?>
<?= $this->section('content') ?>

<h4 class="mb-4">Laporan Klaim Medis</h4>

<div class="row g-3 mb-4">
    <div class="col-md-3"><div class="stat-card blue"><h6>Pengajuan</h6><h2><?= $totalPengajuan ?></h2></div></div>
    <div class="col-md-3"><div class="stat-card green"><h6>Disetujui</h6><h2><?= $totalDisetujui ?></h2></div></div>
    <div class="col-md-3"><div class="stat-card red"><h6>Ditolak</h6><h2><?= $totalDitolak ?></h2></div></div>
    <div class="col-md-3"><div class="stat-card silver"><h6>Total Nominal</h6><h2>Rp <?= number_format($totalNominal,0,',','.') ?></h2></div></div>
</div>

<form method="get" action="<?= base_url('reports/filter') ?>" class="card-admin mb-4">
    <div class="row g-3">
        <div class="col-md-3">
            <input type="date" name="start_date" class="form-control">
        </div>
        <div class="col-md-3">
            <input type="date" name="end_date" class="form-control">
        </div>
        <div class="col-md-3">
            <select name="status" class="form-control">
                <option value="ALL">Semua Status</option>
                <option value="PENGAJUAN">Pengajuan</option>
                <option value="DISETUJUI_HRD">Disetujui HRD</option>
                <option value="DITOLAK_HRD">Ditolak HRD</option>
                <option value="DIBAYARKAN_KEUANGAN">Dibayarkan</option>
            </select>
        </div>
        <div class="col-md-3">
            <button class="btn btn-primary w-100">Filter</button>
        </div>
    </div>
</form>

<a href="<?= base_url('reports/export-pdf') ?>" class="btn btn-danger">Export PDF</a>
<a href="<?= base_url('reports/export-excel') ?>" class="btn btn-success">Export Excel</a>

<?= $this->endSection() ?>
