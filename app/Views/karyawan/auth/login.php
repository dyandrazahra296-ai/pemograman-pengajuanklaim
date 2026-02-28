<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container d-flex justify-content-center align-items-center" style="height:100vh">
    <div class="card p-4 shadow" style="width:360px">
        <h5 class="mb-3 text-center">Login</h5>

        <?php if (session()->getFlashdata('error')): ?>
            <div class="alert alert-danger">
                <?= session()->getFlashdata('error') ?>
            </div>
        <?php endif ?>

        <form action="<?= base_url('/login') ?>" method="post">
            <?= csrf_field() ?>

            <input type="text" name="username" class="form-control mb-3" placeholder="Username" required>
            <input type="password" name="password" class="form-control mb-3" placeholder="Password" required>

            <button class="btn btn-primary w-100">Login</button>
        </form>
    </div>
</div>

</body>
</html>
