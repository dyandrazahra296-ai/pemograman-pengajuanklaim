<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login | Admin Panel</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/css/admin.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

    <style>
        .login-wrapper {
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            background: linear-gradient(135deg, #f4f7fc, #eef2ff);
        }

        .login-card {
            width: 420px;
            background: var(--bg-card);
            padding: 42px;
            border-radius: 28px;
            box-shadow: 0 30px 80px rgba(91,108,255,.2);
            animation: floatIn .8s ease;
            border: 1px solid rgba(255,255,255,0.4);
            backdrop-filter: blur(10px);
        }

        @keyframes floatIn {
            from { opacity: 0; transform: translateY(40px) scale(.95); }
            to { opacity: 1; transform: translateY(0) scale(1); }
        }

        .login-title {
            font-size: 26px;
            font-weight: 700;
            color: var(--primary);
            text-align: center;
        }

        .login-sub {
            font-size: 13px;
            color: var(--text-muted);
            text-align: center;
            margin-bottom: 32px;
        }

        /* Grouping untuk Ikon */
        .input-group-custom {
            position: relative;
            display: flex;
            align-items: center;
        }

        .input-icon {
            position: absolute;
            left: 18px;
            color: var(--text-muted);
            transition: all 0.3s ease;
            z-index: 10;
        }

        .form-control {
            border-radius: 14px;
            padding: 14px 16px 14px 48px !important; /* Padding kiri ekstra untuk ikon */
            border: 1px solid #e2e8f0;
            width: 100%;
        }

        .form-control:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(91,108,255,.25);
        }

        /* Ikon berubah warna saat input fokus */
        .form-control:focus + .input-icon,
        .input-group-custom:focus-within .input-icon {
            color: var(--primary);
        }

        .btn-login {
            width: 100%;
            padding: 14px;
            border-radius: 16px;
            border: none;
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            color: #fff;
            font-weight: 600;
            box-shadow: 0 18px 40px rgba(91,108,255,.35);
            transition: all .35s ease;
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 10px;
        }

        .btn-login:hover {
            transform: translateY(-3px);
            box-shadow: 0 28px 60px rgba(91,108,255,.45);
        }
    </style>
</head>
<body class="page-loaded">

<div class="login-wrapper">
    <form class="login-card" method="post" action="/login">
        <div class="login-title">Admin Panel</div>
        <div class="login-sub">Silakan login untuk melanjutkan</div>

        <?php if (session()->getFlashdata('error')): ?>
            <div class="alert alert-danger text-center py-2 mb-4" style="border-radius: 12px; font-size: 13px;">
                <?= session()->getFlashdata('error') ?>
            </div>
        <?php endif; ?>

        <div class="mb-3 input-group-custom">
            <i class="fa-solid fa-user input-icon"></i>
            <input type="text" name="username" class="form-control" placeholder="Username" required>
        </div>

        <div class="mb-4 input-group-custom">
            <i class="fa-solid fa-lock input-icon"></i>
            <input type="password" name="password" class="form-control" placeholder="Password" required>
        </div>

        <button type="submit" class="btn-login" id="loginBtn">
            <span class="btn-text">Login</span>
            <span class="btn-loader" style="display: none;"></span>
        </button>
    </form>
</div>

<div id="page-loader">
    <div class="loader-ring"></div>
    <div class="loader-text">Preparing Dashboard...</div>
</div>

<script src="/js/admin.js"></script>

</body>
</html>