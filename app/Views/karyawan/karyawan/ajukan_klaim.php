<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Ajukan Klaim</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background: #e6f7ff;
            font-family: 'Segoe UI', sans-serif;
        }

        .main-content {
            margin-left: 250px;
            padding: 40px 20px;
        }

        .card {
            border: none;
            border-radius: 20px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.08);
            background: linear-gradient(145deg,#ffffff,#f0fff4);
            transition: 0.3s;
        }

        .card:hover {
            transform: translateY(-4px);
            box-shadow: 0 15px 35px rgba(0,0,0,0.12);
        }

        h4 {
            font-weight: 700;
            color: #0b6e4f;
        }

        .form-label {
            font-weight: 600;
            color: #0b6e4f;
        }

        .form-control, .form-select {
            border-radius: 12px;
        }

        .input-group-text {
            background: #d1fae5;
            border-radius: 12px 0 0 12px;
        }

        .btn-primary {
            border-radius: 12px;
            background: linear-gradient(90deg,#34d399,#3b82f6);
            border: none;
            font-weight: 600;
        }

        .btn-primary:hover {
            background: linear-gradient(90deg,#10b981,#2563eb);
        }

        .btn-outline-secondary {
            border-radius: 12px;
            border: 2px solid #34d399;
            font-weight: 600;
        }

        @media(max-width:768px){
            .main-content{
                margin-left:0;
            }
        }
    </style>
</head>
<body>

<?= view('karyawan/layout/sidebar') ?>

<div class="main-content">
    <div class="container py-4" style="max-width:720px">

        <div class="mb-4">
            <h4>Ajukan Klaim Pengobatan</h4>
            <p class="text-muted">Isi data klaim sesuai bukti pembayaran</p>
        </div>

        <div class="card p-4">

            <!-- FORM -->
            <form action="<?= base_url('karyawan/medical-claim/submit') ?>" 
                  method="post" 
                  enctype="multipart/form-data">

                <?= csrf_field() ?>

                <!-- TANGGUNGAN -->
                <div class="mb-3">
                    <label class="form-label">Atas Nama</label>
                    <select name="dependent_id" class="form-control">
                        <option value="">Diri Sendiri</option>
                        <?php foreach ($dependents as $d): ?>
                            <option value="<?= $d['dependent_id'] ?>">
                                <?= $d['full_name'] ?> (<?= $d['relationship'] ?>)
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <!-- TANGGAL -->
                <div class="mb-3">
                    <label class="form-label">Tanggal Klaim</label>
                    <input type="date" name="claim_date" class="form-control" required>
                </div>

                <!-- NOMINAL -->
                <div class="mb-3">
                    <label class="form-label">Nominal Klaim</label>
                    <div class="input-group">
                        <span class="input-group-text">Rp</span>
                        <input type="text" name="claim_amount" id="rupiah" class="form-control" required>                    </div>
                </div>

                <!-- DESKRIPSI -->
                <div class="mb-3">
                    <label class="form-label">Deskripsi</label>
                    <textarea name="claim_description" class="form-control"
                        placeholder="Contoh: Rawat jalan, obat, dll"></textarea>
                </div>

                <!-- UPLOAD -->
                <div class="mb-4">
                    <label class="form-label">Bukti Pembayaran</label>
                    <input type="file" name="proof" class="form-control">
                    <small class="text-muted">Format JPG / PNG / PDF</small>
                </div>

                <!-- BUTTON -->
                <div class="d-flex justify-content-between">
                    <a href="<?= base_url('karyawan/dashboard') ?>" class="btn btn-outline-secondary">
                        Kembali
                    </a>

                    <button type="submit" class="btn btn-primary px-4">
                        Kirim Klaim
                    </button>
                </div>

            </form>
        </div>
    </div>
</div>
<script>
document.getElementById('dependent').addEventListener('change', function () {
    const otherBox = document.getElementById('other-dependent');
    if (this.value === 'other') {
        otherBox.classList.remove('d-none');
    } else {
        otherBox.classList.add('d-none');
    }
});
</script>

</body>
</html>
