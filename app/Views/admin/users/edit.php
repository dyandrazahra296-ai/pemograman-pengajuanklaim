<?= $this->extend('admin/layout') ?>
<?= $this->section('content') ?>

<h4 class="page-title mb-4">Edit User</h4>

<div class="card-admin" style="max-width: 500px;">
    <form method="post" action="/users/update/<?= $user['user_id'] ?>">

        <div class="form-group">
    <label>Username</label>
    <input type="text"
           name="username"
           class="form-control"
           value="<?= esc($user['username']) ?>"
           required>
</div>


        <div class="mb-3">
            <label class="form-label">Role</label>
            <select name="role" class="form-control" required>
                <?php
                $roles = ['ADMIN','HRD','KEUANGAN','KARYAWAN'];
                foreach ($roles as $role):
                ?>
                    <option value="<?= $role ?>"
                        <?= $user['role'] === $role ? 'selected' : '' ?>>
                        <?= $role ?>
                    </option>
                <?php endforeach ?>
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Status</label>
            <select name="is_active" class="form-control">
                <option value="1" <?= $user['is_active'] ? 'selected' : '' ?>>
                    Aktif
                </option>
                <option value="0" <?= ! $user['is_active'] ? 'selected' : '' ?>>
                    Nonaktif
                </option>
            </select>
        </div>

        <div class="d-flex gap-2">
            <button class="btn btn-success">Update</button>
            <a href="/users" class="btn btn-secondary">Batal</a>
        </div>
    </form>
</div>

<?= $this->endSection() ?>
