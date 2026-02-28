<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard HRD</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        body { background-color: #f8f9fc; font-family: 'Inter', sans-serif; display: flex; min-height: 100vh; margin: 0; }
        .sidebar { width: 250px; background: white; border-right: 1px solid #e3e6f0; padding: 25px; position: fixed; height: 100%; }
        .main-content { margin-left: 250px; padding: 40px; width: calc(100% - 250px); }
        .nav-link { color: #858796; padding: 12px; border-radius: 8px; margin-bottom: 5px; text-decoration: none; display: flex; align-items: center; transition: 0.3s; }
        .nav-link.active { background: #0d6efd; color: white !important; font-weight: bold; }
        
        /* Style Tambahan buat Logout biar serius */
        .nav-link.text-danger:hover { background: rgba(220, 53, 69, 0.1); color: #dc3545 !important; }
        
        .card { border: none; border-radius: 12px; box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.1); }
        .logo-text { color: #0d6efd; font-weight: bold; font-size: 1.25rem; margin-bottom: 2rem; display: block; text-decoration: none; }
        .stat-card { border-left: 4px solid #0d6efd; }
    </style>
</head>
<body>

<div class="sidebar">
    <a href="#" class="logo-text">Klaim Obat</a>
    <nav>
        <a class="nav-link active" href="<?= base_url('hrd/dashboard'); ?>">
            <i class="fas fa-home me-2"></i> Dashboard
        </a>
        <a class="nav-link" href="<?= base_url('hrd/history'); ?>">
            <i class="fas fa-list me-2"></i> List Klaim
        </a>

        <hr class="my-3 text-muted">

        <a class="nav-link text-danger" href="javascript:void(0)" onclick="confirmLogout()">
            <i class="fas fa-sign-out-alt me-2"></i> <strong>Logout</strong>
        </a>
    </nav>
</div>

<div class="main-content text-dark">
    <h4 class="fw-bold mb-4">Dashboard HRD</h4>
    
    <div class="row mb-4">
        <div class="col-md-4"><div class="card p-3 stat-card"><small class="text-primary fw-bold">ANTREAN</small><div class="h4 fw-bold"><?= count($claims); ?></div></div></div>
        <div class="col-md-4"><div class="card p-3 stat-card" style="border-left-color: #1cc88a;"><small class="text-success fw-bold">TOTAL APPROVED</small><div class="h4 fw-bold">Rp <?= number_format($stats['total_nominal'], 0, ',', '.'); ?></div></div></div>
        <div class="col-md-4"><div class="card p-3 stat-card" style="border-left-color: #36b9cc;"><small class="text-info fw-bold">SELESAI</small><div class="h4 fw-bold"><?= $stats['total_approved']; ?></div></div></div>
    </div>

    <div class="card p-4">
        <h6 class="fw-bold mb-4 text-primary">Persetujuan Klaim Terbaru</h6>
        <div class="table-responsive">
            <table class="table align-middle">
                <thead>
                    <tr>
                        <th>TANGGAL</th>
                        <th>KARYAWAN</th>
                        <th>PASIEN</th>
                        <th>JUMLAH</th>
                        <th>FILE</th>
                        <th>AKSI</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($claims as $row): ?>
                    <tr>
                        <td><?= date('d/m/Y', strtotime($row['claim_date'])); ?></td>
                        <td><strong><?= $row['emp_name']; ?></strong></td>
                        <td class="text-muted small"><?= $row['dep_name'] ?: 'Diri Sendiri'; ?></td>
                        <td class="fw-bold">Rp <?= number_format($row['claim_amount'], 0, ',', '.'); ?></td>
                        <td class="text-center">
                            <?php if($row['receipt_file']): ?>
                                <a href="<?= base_url('uploads/' . $row['receipt_file']); ?>" target="_blank">
                                    <i class="fas fa-file-image text-primary fa-lg"></i>
                                </a>
                            <?php else: ?>
                                <span class="text-muted small">-</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <a href="<?= base_url('hrd/process/approve/'.$row['claim_id']); ?>" class="btn btn-sm btn-success px-3">Setuju</a>
                            <a href="<?= base_url('hrd/process/reject/'.$row['claim_id']); ?>" class="btn btn-sm btn-danger px-3">Tolak</a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    function confirmLogout() {
        Swal.fire({
            title: 'Sesi akan berakhir',
            text: "Apakah Anda yakin ingin keluar dari sistem HRD?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6', // Warna biru primer
            cancelButtonColor: '#d33',    // Warna merah
            confirmButtonText: 'Ya, Keluar',
            cancelButtonText: 'Batal',
            reverseButtons: true,
            scrollbarPadding: false
        }).then((result) => {
            if (result.isConfirmed) {
                // Proses pengalihan ke link logout CI4 kamu
                window.location.href = "<?= base_url('logout'); ?>";
            }
        })
    }
</script>

</body>
</html>