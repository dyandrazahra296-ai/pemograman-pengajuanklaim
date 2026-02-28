<?= $this->extend('admin/layout') ?>
<?= $this->section('content') ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="page-title mb-0">Manajemen User</h4>
    <a href="/users/create" class="btn btn-primary">
        + Tambah User
    </a>
</div>

<?php if (session()->getFlashdata('success')) : ?>
    <div class="alert alert-success">
        <?= session()->getFlashdata('success') ?>
    </div>
<?php endif; ?>

<?php if (session()->getFlashdata('error')) : ?>
    <div class="alert alert-danger">
        <?= session()->getFlashdata('error') ?>
    </div>
<?php endif; ?>

<div class="card-admin">
    <table class="table table-admin">
        <thead>
            <tr>
                <th width="5%">#</th>
                <th width="40%">Username</th>
                <th width="20%" class="text-center">Role</th>
                <th width="15%" class="text-center">Status</th>
                <th width="20%" class="text-center">Aksi</th>
            </tr>
        </thead>

        <tbody>
        <?php if (empty($users)) : ?>
            <tr>
                <td colspan="5" class="text-center text-muted py-4">
                    Belum ada data user
                </td>
            </tr>
        <?php endif; ?>

        <?php foreach ($users as $i => $u): ?>
            <tr>
                <td><?= $i + 1 ?></td>

                <!-- USERNAME -->
                <td>
                    <strong><?= esc($u['username']) ?></strong>
                </td>

                <!-- ROLE -->
                <td class="role-cell">
                    <div class="role-wrapper">
                        <span class="badge-role role-<?= strtolower($u['role']) ?>">
                            <?= strtoupper($u['role']) ?>
                        </span>
                    </div>
                </td>

                <!-- STATUS -->
                <td class="text-center">
                    <span class="status-badge <?= $u['is_active'] ? 'status-active' : 'status-inactive' ?>"
                            data-id="<?= $u['user_id'] ?>"
                            onclick="toggleStatus(this)">
                        <?= $u['is_active'] ? 'Aktif' : 'Nonaktif' ?>
                    </span>
                </td>

                <!-- AKSI -->
                <td class="text-center">
                    <div class="action-group">

                        <!-- EDIT -->
                        <a href="/users/edit/<?= $u['user_id'] ?>"
                           class="btn btn-sm btn-warning"
                           title="Edit User">
                            ✏️
                        </a>

                        <!-- DELETE -->
                        <button type="button"
                                class="btn btn-sm btn-danger btn-delete"
                                data-id="<?= $u['user_id'] ?>"
                                data-name="<?= esc($u['username']) ?>"
                                title="Hapus User">
                            🗑️
                        </button>

                        <!-- RESET PASSWORD -->
                        <button type="button"
                                class="btn btn-sm btn-secondary btn-reset"
                                data-id="<?= $u['user_id'] ?>"
                                data-name="<?= esc($u['username']) ?>"
                                title="Reset Password">
                            🔑
                        </button>

                    </div>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?= $this->endSection() ?>
