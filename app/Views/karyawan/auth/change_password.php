<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Ganti Password</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: #e6f7ff; /* biru muda lembut */
            font-family: 'Segoe UI', sans-serif;
            margin: 0;
            padding: 0;
        }

        .main-content {
            margin-left: 250px; /* sesuaikan dengan sidebar */
            padding: 40px 20px;
        }

        .card {
            background: linear-gradient(145deg, #ffffff, #f0fff4); /* putih ke hijau muda */
            border-radius: 20px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.08);
            padding: 30px 25px;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.12);
        }

        h4 {
            color: #0b6e4f; /* hijau tua */
            font-weight: 700;
        }

        .form-label {
            font-weight: 600;
            color: #0b6e4f;
        }

        .form-control {
            border-radius: 12px;
            border: 1px solid #ced4da;
            padding: 10px 12px;
            transition: border-color 0.3s, box-shadow 0.3s;
        }

        .form-control:focus {
            border-color: #3b82f6; /* biru */
            box-shadow: 0 0 0 0.2rem rgba(59, 130, 246, 0.25);
        }

        .btn-primary {
            border-radius: 12px;
            padding: 10px 20px;
            font-weight: 600;
            background: linear-gradient(90deg, #34d399, #3b82f6); /* hijau ke biru */
            border: none;
            color: #fff;
            transition: background 0.3s, transform 0.2s;
        }

        .btn-primary:hover {
            background: linear-gradient(90deg, #10b981, #2563eb);
            transform: translateY(-2px);
        }

        .btn-secondary {
            border-radius: 12px;
            padding: 10px 20px;
            font-weight: 600;
            color: #065f46;
            border: 2px solid #34d399;
            background: #ffffff;
            transition: background 0.3s, color 0.3s, transform 0.2s;
        }

        .btn-secondary:hover {
            background: #34d399;
            color: #fff;
            transform: translateY(-2px);
        }

        .text-muted {
            font-size: 13px;
        }

        @media (max-width: 768px) {
            .main-content {
                margin-left: 0;
                padding: 20px 15px;
            }
        }

    </style>
</head>
<body>

<?= view('karyawan/layout/sidebar') ?>

<div class="main-content">
    <div class="container" style="max-width:520px">

        <div class="card">
            <h4 class="mb-4">🔐 Ganti Password</h4>

            <?php if (session()->getFlashdata('error')): ?>
                <div class="alert alert-danger">
                    <?= session()->getFlashdata('error') ?>
                </div>
            <?php endif; ?>

            <form method="post" action="<?= base_url('change-password') ?>">
                <?= csrf_field() ?>

                <div class="mb-3">
                    <label class="form-label">Password Lama</label>
                    <input type="password" name="old_password" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Password Baru</label>
                    <input type="password" name="new_password" class="form-control" required>
                    <small class="text-muted">Minimal 8 karakter</small>
                </div>

                <div class="mb-4">
                    <label class="form-label">Konfirmasi Password Baru</label>
                    <input type="password" name="confirm_password" class="form-control" required>
                </div>

                <div class="d-flex justify-content-between">
                    <button class="btn btn-primary">
                        Simpan Password
                    </button>
                    <a href="<?= base_url('/medical-claims') ?>" class="btn btn-secondary">
                        Batal
                    </a>
                </div>
            </form>
        </div>

    </div>
</div>

</body>
</html>
