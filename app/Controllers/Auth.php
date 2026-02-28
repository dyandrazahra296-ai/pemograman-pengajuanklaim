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

        // =====================================================
        // 1️⃣ CEK DI TABEL USERS (ADMIN / HRD / KEUANGAN)
        // =====================================================
        $user = $userModel->where('username', $username)->first();

        if ($user) {

            if (!password_verify($password, $user['password_hash'])) {
            return redirect()->back()->with('error', 'Username atau password salah');
            }

            $role = strtolower(trim($user['role']));

            session()->set([
                'user_id'     => $user['user_id'],
                'employee_id' => $user['employee_id'] ?? null,
                'username'    => $user['username'],
                'role'        => $role,
                'logged_in'   => true
            ]);

            session()->regenerate(true);

            return $this->redirectByRole($role);
        }

        // =====================================================
        // 2️⃣ CEK DI TABEL EMPLOYEES (LOGIN NIK KARYAWAN)
        // =====================================================
        $employee = $employeeModel
            ->where('employee_nik', $username)
            ->first();

        if ($employee) {

            // Default password = NIK
            if ($password !== $employee['employee_nik']) {
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