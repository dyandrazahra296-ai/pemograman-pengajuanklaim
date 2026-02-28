<?= $this->extend('karyawan/layout/main') ?>
<?= $this->section('content') ?>

<div class="container-fluid py-4">

    <div class="row justify-content-center">
        <div class="col-md-6">

            <div class="card shadow-sm border-0 rounded-4">
                <div class="card-body text-center p-4">

                    <!-- Avatar -->
                    <div class="avatar-gradient mx-auto mb-3">
                        <?= strtoupper(substr($employee['full_name'],0,1)) ?>
                    </div>

                    <h5 class="fw-bold mb-1">
                        <?= esc($employee['full_name']) ?>
                    </h5>

                    <small class="text-muted">
                        <?= esc($employee['email'] ?? '-') ?>
                    </small>

                    <hr>

                    <div class="text-start small mt-3">
                        <p><b>NIK:</b> <?= esc($employee['employee_nik'] ?? '-') ?></p>
                        <p><b>Department:</b> <?= esc($employee['department'] ?? '-') ?></p>
                        <p><b>Position:</b> <?= esc($employee['position'] ?? '-') ?></p>
                        <p><b>Salary:</b> 
                            Rp <?= number_format($employee['base_salary'] ?? 0,0,',','.') ?>
                        </p>
                    </div>

                    <!-- BUTTON EDIT -->
                    <a href="<?= base_url('karyawan/profile/edit') ?>"
                       class="btn btn-dark w-100 mt-3 rounded-3">
                        Edit Profile
                    </a>
                    <a href="#"
                    onclick="window.history.back(); return false;"
                    class="btn btn-light w-100 mt-2">
                    Kembali
                    </a>

                </div>
            </div>

        </div>
    </div>

</div>

<style>
.avatar-gradient{
    width:80px;
    height:80px;
    border-radius:50%;
    display:flex;
    align-items:center;
    justify-content:center;
    font-weight:bold;
    font-size:28px;
    color:white;
    background: linear-gradient(135deg,#4f46e5,#06b6d4);
}
</style>

<?= $this->endSection() ?>