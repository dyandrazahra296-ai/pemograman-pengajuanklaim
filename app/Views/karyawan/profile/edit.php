<?= $this->extend('karyawan/layout/main') ?>
<?= $this->section('content') ?>

<div class="container-fluid py-4">

    <div class="row justify-content-center">
        <div class="col-md-6">

            <div class="card shadow-sm border-0 rounded-4">
                <div class="card-body p-4">

                    <h5 class="fw-bold mb-4">Edit Profile</h5>

                    <form method="post" action="<?= base_url('/karyawan/profile/update') ?>">

                        <div class="mb-3">
                            <label class="form-label small text-muted">Nama Lengkap</label>
                            <input type="text" name="full_name"
                                   class="form-control rounded-3"
                                   value="<?= esc($employee['full_name']) ?>">
                        </div>

                        <div class="mb-3">
                            <label class="form-label small text-muted">Department</label>
                            <input type="text" name="department"
                                   class="form-control rounded-3"
                                   value="<?= esc($employee['department']) ?>">
                        </div>

                        <div class="mb-4">
                            <label class="form-label small text-muted">Position</label>
                            <input type="text" name="position"
                                   class="form-control rounded-3"
                                   value="<?= esc($employee['position']) ?>">
                        </div>

                        <button class="btn btn-dark w-100 rounded-3">
                            Simpan Perubahan
                        </button>

                        <a href="<?= base_url('/karyawan/profile') ?>"
                           class="btn btn-light w-100 mt-2">
                           Batal
                        </a>

                    </form>

                </div>
            </div>

        </div>
    </div>

</div>

<?= $this->endSection() ?>