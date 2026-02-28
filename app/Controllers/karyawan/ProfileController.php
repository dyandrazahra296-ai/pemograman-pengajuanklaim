<?php

namespace App\Controllers\karyawan;

use App\Controllers\BaseController;
use App\Models\UserModel;
use App\Models\EmployeeModel;
use App\Models\DependentModel;

class ProfileController extends BaseController
{
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

    public function changePasswordView()
    {
        return view('karyawan/auth/change_password');
    }

    public function updatePassword()
    {
        $userModel = new UserModel();
        $userId    = session('user_id');

        $newPassword     = $this->request->getPost('new_password');
        $confirmPassword = $this->request->getPost('confirm_password');

        if ($newPassword !== $confirmPassword) {
            return redirect()->back()->with('error', 'Konfirmasi password tidak cocok!');
        }

        $userModel->update($userId, [
            'password' => password_hash($newPassword, PASSWORD_DEFAULT)
        ]);

        // SINKRON: Balik ke Dashboard Utama (MedicalClaim)
        return redirect()->to(base_url('karyawan/dashboard'))->with('success', 'Password berhasil diganti!');
    }

    public function edit()
    {
        $employee = (new EmployeeModel())->find(session('employee_id'));
        return view('karyawan/profile/edit', compact('employee'));
    }

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
