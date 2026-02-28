<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Ajukan Klaim</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        /* ================= BODY ================= */
        body {
            background: #e6f7ff; /* biru muda lembut */
            font-family: 'Segoe UI', sans-serif;
            margin: 0;
            padding: 0;
        }

        /* ================= MAIN CONTENT ================= */
        .main-content {
            margin-left: 250px; /* Sesuaikan dengan sidebar jika ada */
            padding: 40px 20px;
        }

        /* ================= CARD ================= */
        .card {
            border: none;
            border-radius: 20px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.08);
            background: linear-gradient(145deg, #ffffff, #f0fff4); /* putih-hijau muda */
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.12);
        }

        /* ================= HEADINGS ================= */
        h4.fw-semibold {
            font-weight: 700;
            color: #0b6e4f; /* hijau tua */
        }

        p.text-muted {
            color: #4b5563; /* abu gelap */
        }

        /* ================= FORM ELEMENTS ================= */
        .form-label {
            font-weight: 600;
            color: #0b6e4f; /* hijau */
        }

        .form-control {
            border-radius: 12px;
            border: 1px solid #ced4da;
            padding: 10px 12px;
            transition: border-color 0.3s, box-shadow 0.3s;
        }

        .form-control:focus {
            border-color: #0d6efd; /* biru fokus */
            box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.25);
        }

        .form-select {
            border-radius: 12px;
            border: 1px solid #ced4da;
            padding: 10px 12px;
            transition: border-color 0.3s, box-shadow 0.3s;
        }

        .form-select:focus {
            border-color: #facc15; /* kuning fokus */
            box-shadow: 0 0 0 0.2rem rgba(250, 204, 21, 0.25);
        }

        .input-group-text {
            background: #d1fae5; /* hijau muda */
            border-radius: 12px 0 0 12px;
            border: 1px solid #ced4da;
            font-weight: 500;
            color: #065f46;
        }

        .form-text {
            font-size: 13px;
            color: #6c757d;
        }

        /* ================= BUTTONS ================= */
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

        .btn-outline-secondary {
            border-radius: 12px;
            padding: 10px 20px;
            font-weight: 600;
            color: #065f46;
            border: 2px solid #34d399;
            transition: background 0.3s, color 0.3s, transform 0.2s;
        }

        .btn-outline-secondary:hover {
            background: #34d399;
            color: #fff;
            transform: translateY(-2px);
        }

        /* ================= RESPONSIVE ================= */
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
    <div class="container py-4" style="max-width:720px">

        <div class="mb-4">
            <h4 class="fw-semibold">Ajukan Klaim Pengobatan</h4>
            <p class="text-muted mb-0">
                Isi data klaim sesuai bukti pembayaran
            </p>
        </div>

        <div class="card p-4">
            <form action="<?= base_url('/claims/submit') ?>" 
                  method="post" 
                  enctype="multipart/form-data">

                <?= csrf_field() ?>

<select name="dependent_id" id="dependent" class="form-control">
    <option value="">Diri Sendiri</option>
    <?php foreach ($dependents as $d): ?>
        <option value="<?= $d['dependent_id'] ?>">
            <?= $d['full_name'] ?> (<?= $d['relationship'] ?>)
        </option>
    <?php endforeach; ?>
</select>




                <!-- MUNCUL JIKA PILIH LAINNYA -->
                <div class="mb-3 d-none" id="other-dependent">
                    <label class="form-label">Keterangan Tanggungan</label>
                    <input type="text" 
                           name="dependent_other" 
                           class="form-control"
                           placeholder="Contoh: Orang Tua / Saudara">
                </div>

                <!-- NOMINAL -->
                <div class="mb-3">
                    <label class="form-label">Nominal Klaim</label>
                    <div class="input-group">
                        <span class="input-group-text">Rp</span>
                        <input type="number" name="amount" class="form-control" required>
                    </div>
                    <div class="form-text">
                        Masukkan sesuai nominal di bukti pembayaran
                    </div>
                </div>

                <!-- UPLOAD BUKTI -->
                <div class="mb-4">
                    <label class="form-label">Bukti Pembayaran</label>
                    <input type="file" name="proof" class="form-control" required>
                    <div class="form-text">
                        Format JPG / PNG / PDF • Maksimal 2MB
                    </div>
                </div>


                <!-- ACTION -->
                <div class="d-flex justify-content-between">
                    <a href="<?= base_url('/dashboard') ?>" class="btn btn-outline-secondary">
                        Kembali
                    </a>

                    <button class="btn btn-primary px-4">
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