<!DOCTYPE html>
<html lang="id">
<head>

<style>
.card-profile {
    background: #f8faff;
    border-left: 5px solid #4e73df;
}
.card-employee {
    background: #f0fff4;
    border-left: 5px solid #1cc88a;
}
.card-dependent {
    background: #fffaf0;
    border-left: 5px solid #f6c23e;
}
</style>

    <meta charset="UTF-8">
    <title><?= $title ?? 'Aplikasi' ?></title>

    <!-- BOOTSTRAP -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container py-4">
    <?= $this->renderSection('content') ?>
</div>

</body>
</html>
