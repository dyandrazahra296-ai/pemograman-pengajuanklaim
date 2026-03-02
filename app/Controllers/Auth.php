<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UserModel;
use App\Models\EmployeeModel;

class Auth extends BaseController
{
    public function login()
    {
        if (session()->get('logged_in') === true) {
            return $this->redirectByRole(session()->get('role'));
        }

        return view('auth/login');
    }

    public function process()
{
    $username = trim($this->request->getPost('username'));
    $password = trim($this->request->getPost('password'));

    $userModel     = new UserModel();
    $employeeModel = new EmployeeModel();

    // ===== CEK TABEL USERS =====
    $user = $userModel->where('username', $username)->first();
    if ($user) {
        if (!password_verify($password, $user['password_hash'])) {
            return redirect()->back()->with('error', 'Username atau password salah');
        }

        session()->set([
            'user_id'     => $user['user_id'],
            'employee_id' => $user['employee_id'] ?? null,
            'username'    => $user['username'],
            'role'        => strtolower($user['role']),
            'logged_in'   => true
        ]);
        session()->regenerate(true);

        return $this->redirectByRole(strtolower($user['role']));
    }

    // ===== CEK TABEL EMPLOYEES =====
    $employee = $employeeModel->where('employee_nik', $username)->first();
    if ($employee) {

        $loginValid = false;

        // Kasus pertama login: password masih NIK
        if (empty($employee['password']) || $employee['password'] === $employee['employee_nik']) {
            if ($password === $employee['employee_nik']) {
                $loginValid = true;
            }
        } 
        // Kasus password sudah di-hash
        elseif (password_verify($password, $employee['password'])) {
            $loginValid = true;
        }

        if (!$loginValid) {
            return redirect()->back()->with('error', 'Password salah');
        }

        session()->set([
            'employee_id' => $employee['employee_id'],
            'username'    => $employee['full_name'],
            'role'        => 'karyawan',
            'logged_in'   => true
        ]);
        session()->regenerate(true);

        return redirect()->to('/karyawan/dashboard');
    }

    return back()->with('error', 'Username / NIK tidak ditemukan');
}

// ===== CHANGE PASSWORD =====
public function changePassword()
{
    $session = session();
    $employeeId = $session->get('employee_id');

    if (!$employeeId) {
        return redirect()->to('/login')->with('error', 'Session habis, silakan login ulang');
    }

    $old = $this->request->getPost('old_password');
    $new = $this->request->getPost('new_password');
    $confirm = $this->request->getPost('confirm_password');

    $employeeModel = new EmployeeModel();
    $employee = $employeeModel->find($employeeId);

    if (!$employee) {
        return redirect()->back()->with('error', 'User tidak ditemukan');
    }

    $oldPasswordValid = false;

    // Kasus pertama kali login: password masih NIK
    if (empty($employee['password']) || $employee['password'] === $employee['employee_nik']) {
        if ($old === $employee['employee_nik']) {
            $oldPasswordValid = true;
        }
    }
    // Kasus password sudah di-hash
    elseif (password_verify($old, $employee['password'])) {
        $oldPasswordValid = true;
    }

    if (!$oldPasswordValid) {
        return redirect()->back()->with('error', 'Password lama salah');
    }

    if ($new !== $confirm) {
        return redirect()->back()->with('error', 'Konfirmasi password tidak cocok');
    }

    if (strlen($new) < 8) {
        return redirect()->back()->with('error', 'Password minimal 8 karakter');
    }

    // Update password dengan hash
    $employeeModel->update($employeeId, [
        'password' => password_hash($new, PASSWORD_DEFAULT)
    ]);

    // logout supaya login ulang pakai password baru
    $session->destroy();

    return redirect()->to('/login')->with('success', 'Password berhasil diganti. Silakan login ulang.');
}

    private function redirectByRole(string $role)
    {
        switch ($role) {

            case 'admin':
                return redirect()->to('/dashboard');

            case 'hrd':
                return redirect()->to('/hrd/dashboard');

            case 'keuangan':
                return redirect()->to('/keuangan/dashboard');

            case 'karyawan':
                return redirect()->to('/karyawan/dashboard');

            default:
                session()->destroy();
                return redirect()->to('/login')
                    ->with('error', 'Role tidak terdaftar');
        }
    }

   
    
    public function logout()
    {
        session()->destroy();
        return redirect()->to('/login');
    }
}
