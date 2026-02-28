<?= $this->extend('admin/layout') ?>
<?= $this->section('content') ?>

<h4 class="mb-4">Tambah User</h4>

<form method="post" action="/users/store">
    <div class="mb-3">
        <label>Username</label>
        <input type="text" name="username" class="form-control" required>
    </div>

    <div class="mb-3">
        <label>Password</label>
        <input type="password" name="password" class="form-control" required>
    </div>

    <div class="mb-3">
        <label>Role</label>
        <select name="role" class="form-control" required>
            <option value="ADMIN">ADMIN</option>
            <option value="HRD">HRD</option>
            <option value="KEUANGAN">KEUANGAN</option>
            <option value="KARYAWAN">KARYAWAN</option>
        </select>
    </div>

    <button class="btn btn-success">Simpan</button>
    <a href="/users" class="btn btn-secondary">Kembali</a>
</form>

<?= $this->endSection() ?>
