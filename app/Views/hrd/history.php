<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard HRD - List Klaim</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        body { background-color: #f8f9fc; font-family: 'Inter', sans-serif; display: flex; min-height: 100vh; margin: 0; }
        .sidebar { width: 250px; background: white; border-right: 1px solid #e3e6f0; padding: 25px; position: fixed; height: 100%; }
        .main-content { margin-left: 250px; padding: 40px; width: calc(100% - 250px); }
        .nav-link { color: #858796; padding: 12px; border-radius: 8px; margin-bottom: 5px; text-decoration: none; display: flex; align-items: center; transition: 0.3s; }
        .nav-link.active { background: #0d6efd; color: white !important; font-weight: bold; }
        
        /* Efek Hover Logout */
        .nav-link.text-danger:hover { background: rgba(220, 53, 69, 0.1); color: #dc3545 !important; }
        
        .card { border: none; border-radius: 12px; box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.1); }
        .logo-text { color: #0d6efd; font-weight: bold; font-size: 1.25rem; margin-bottom: 2rem; display: block; text-decoration: none; }
        .badge { border-radius: 8px; font-weight: 500; }
    </style>
</head>
<body>

<div class="sidebar">
    <a href="#" class="logo-text">Klaim Obat</a>
    <nav>
        <a class="nav-link" href="<?= base_url('hrd/dashboard'); ?>">
            <i class="fas fa-home me-2"></i> Dashboard
        </a>
        <a class="nav-link active" href="<?= base_url('hrd/history'); ?>">
            <i class="fas fa-list me-2"></i> List Klaim
        </a>

        <hr class="my-3 text-muted">

        <a class="nav-link text-danger" href="javascript:void(0)" onclick="confirmLogout()">
            <i class="fas fa-sign-out-alt me-2"></i> <strong>Logout</strong>
        </a>
    </nav>
</div>

<div class="main-content">
    <h4 class="fw-bold mb-4 text-dark">Riwayat Klaim</h4>
    
    <div class="card p-4">
        <h6 class="fw-bold mb-4 text-primary">Riwayat Klaim Medis Terproses</h6>
        <div class="table-responsive">
            <table class="table align-middle">
                <thead>
                    <tr>
                        <th>TANGGAL</th>
                        <th>KARYAWAN & PASIEN</th>
                        <th>JUMLAH</th>
                        <th>FILE</th>
                        <th>STATUS</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(empty($claims)): ?>
                        <tr><td colspan="5" class="text-center py-5 text-muted small">Belum ada riwayat klaim yang diproses.</td></tr>
                    <?php else: ?>
                        <?php foreach($claims as $row): ?>
                        <tr>
                            <td><?= date('d/m/Y', strtotime($row['claim_date'])); ?></td>
                            <td>
                                <strong><?= $row['emp_name']; ?></strong><br>
                                <small class="text-muted">Pasien: <?= $row['dep_name'] ?: 'Diri Sendiri'; ?></small>
                            </td>
                            <td class="fw-bold">Rp <?= number_format($row['claim_amount'], 0, ',', '.'); ?></td>
                            <td class="text-center">
                                <?php if($row['receipt_file']): ?>
                                    <a href="<?= base_url('uploads/' . $row['receipt_file']); ?>" target="_blank">
                                        <i class="fas fa-file-image text-primary fa-lg"></i>
                                    </a>
                                <?php else: ?>
                                    <span class="text-muted">-</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <?php if($row['status'] == 'DISETUJUI_HRD'): ?>
                                    <span class="badge bg-success px-3 py-2"><i class="fas fa-check-circle me-1"></i> Setuju</span>
                                <?php else: ?>
                                    <span class="badge bg-danger px-3 py-2"><i class="fas fa-times-circle me-1"></i> Tolak</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    function confirmLogout() {
        Swal.fire({
            title: 'Konfirmasi Keluar',
            text: "Sesi kerja Anda akan berakhir. Pastikan tidak ada data yang tertunda.",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, Logout',
            cancelButtonText: 'Batal',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = "<?= base_url('logout'); ?>";
            }
        })
    }
</script>

</body>
</html>