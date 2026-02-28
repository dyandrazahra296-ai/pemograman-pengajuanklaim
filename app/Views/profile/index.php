<?= $this->extend('admin/layout') ?>
<?= $this->section('content') ?>

<h4 class="mb-4">Profil Saya</h4>

<?php if (session()->getFlashdata('error')) : ?>
    <div class="alert alert-danger">
        <?= session()->getFlashdata('error') ?>
    </div>
<?php endif; ?>

<?php if (session()->getFlashdata('success')) : ?>
    <div class="alert alert-success">
        <?= session()->getFlashdata('success') ?>
    </div>
<?php endif; ?>

<div class="card-admin" style="max-width: 500px;">
    <form method="post" action="/profile/change-password">

        <div class="form-group mb-3">
            <label>Username</label>
            <input type="text"
                   class="form-control"
                   value="<?= esc($user['username']) ?>"
                   readonly>
        </div>

        <div class="form-group mb-3">
            <label>Password Lama</label>
            <input type="password"
                   name="old_password"
                   class="form-control"
                   required>
        </div>

        <div class="form-group mb-3">
            <label>Password Baru</label>
            <input type="password"
                   name="new_password"
                   class="form-control"
                   required>
        </div>

        <button class="btn btn-primary">
            Simpan Password Baru
        </button>

    </form>
</div>

<?= $this->endSection() ?>
