<?php

namespace App\Controllers\karyawan;

use App\Controllers\BaseController;
use App\Models\EmployeeModel;
use App\Models\UserModel;

class ProfileController extends BaseController
{
    // Halaman profil
    public function index()
    {
        if (!session('logged_in')) {
            return redirect()->to('/login');
        }

        $employeeModel = new EmployeeModel();
        $userModel = new UserModel();

        $employee = $employeeModel->find(session('employee_id'));
        $user = $userModel->find(session('user_id'));

        $employee['email'] = $user['email'] ?? '-';

        return view('karyawan/profile/index', compact('employee'));
    }

    // Tampilkan halaman ganti password
    public function changePasswordView()
    {
        return view('karyawan/auth/change_password');
    }

    // Proses update password
  public function updatePassword()
{
    $session = session();
    $employeeId = $session->get('employee_id');

    if (!$employeeId) {
        return redirect()->to('/login')->with('error', 'Session habis, silakan login ulang');
    }

    $oldPassword     = $this->request->getPost('old_password');
    $newPassword     = $this->request->getPost('new_password');
    $confirmPassword = $this->request->getPost('confirm_password');

    // Validasi password baru
    if ($newPassword !== $confirmPassword) {
        return redirect()->back()->with('error', 'Konfirmasi password tidak cocok');
    }

    if (strlen($newPassword) < 8) {
        return redirect()->back()->with('error', 'Password minimal 8 karakter');
    }

    $employeeModel = new EmployeeModel();
    $employee      = $employeeModel->find($employeeId);

    if (!$employee) {
        return redirect()->back()->with('error', 'User tidak ditemukan');
    }

    $passwordField = 'password';
    $oldPasswordValid = false;

    // =====================================================
    // 1️⃣ Kasus pertama login: password masih NIK (plain)
    // =====================================================
    if (empty($employee[$passwordField]) || $employee[$passwordField] === $employee['employee_nik']) {
        if ($oldPassword === $employee['employee_nik']) {
            $oldPasswordValid = true;
        }
    }
    // =====================================================
    // 2️⃣ Kasus password sudah di-hash
    // =====================================================
    elseif (password_verify($oldPassword, $employee[$passwordField])) {
        $oldPasswordValid = true;
    }

    if (!$oldPasswordValid) {
        return redirect()->back()->with('error', 'Password lama salah');
    }

    // =====================================================
    // Update password baru (hash)
    // =====================================================
    $employeeModel->update($employeeId, [
        $passwordField => password_hash($newPassword, PASSWORD_DEFAULT)
    ]);

    // Logout otomatis supaya login ulang pakai password baru
    $session->destroy();

    return redirect()->to('/login')->with('success', 'Password berhasil diganti. Silakan login ulang.');

}
    // Edit profil
    public function edit()
    {
        $employee = (new EmployeeModel())->find(session('employee_id'));
        return view('karyawan/profile/edit', compact('employee'));
    }

    // Update profil
    public function update()
    {
        $employeeModel = new EmployeeModel();

        $employeeModel->update(session('employee_id'), [
            'full_name'  => $this->request->getPost('full_name'),
            'position'   => $this->request->getPost('position'),
            'department' => $this->request->getPost('department'),
        ]);

        return redirect()->to('karyawan/profile')->with('success', 'Profile updated');
    }
}
