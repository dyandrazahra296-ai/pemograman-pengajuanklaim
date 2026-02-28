<?php

namespace App\Controllers;

use App\Models\UserModel;

class Users extends BaseController
{
    protected $userModel;
    protected $SUPERADMIN_ID = 1;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    // ===============================
    // INDEX
    // ===============================
    public function index()
    {
        $data['users'] = $this->userModel->findAll();
        return view('admin/users/index', $data);
    }

    // ===============================
    // CREATE
    // ===============================
    public function create()
    {
        return view('admin/users/create');
    }

    // ===============================
    // STORE
    // ===============================
    public function store()
    {
        $this->userModel->insert([
            'username'      => $this->request->getPost('username'),
            'password_hash' => password_hash(
                $this->request->getPost('password'),
                PASSWORD_DEFAULT
            ),
            'role'          => $this->request->getPost('role'),
            'is_active'     => 1,
            'force_reset'   => 1, // ⬅️ user wajib ganti password pertama kali
            'created_at'    => date('Y-m-d H:i:s')
        ]);

        return redirect()->to('/users')
            ->with('success', 'User berhasil ditambahkan');
    }

    // ===============================
    // EDIT
    // ===============================
    public function edit($id)
    {
        $user = $this->userModel->where('user_id', $id)->first();

        if (! $user) {
            return redirect()->to('/users')
                ->with('error', 'User tidak ditemukan');
        }

        return view('admin/users/edit', [
            'user' => $user
        ]);
    }

    // ===============================
    // UPDATE (PROTEKSI SUPERADMIN)
    // ===============================
    public function update($id)
    {
        if (! $this->validate([
            'username' => 'required|min_length[4]|is_unique[users.username,user_id,' . $id . ']'
        ])) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Username sudah digunakan');
        }

        $data = [
            'username' => $this->request->getPost('username'),
        ];

        // ❌ SUPERADMIN TIDAK BOLEH DIUBAH ROLE & STATUS
        if ($id != $this->SUPERADMIN_ID) {
            $data['role']      = $this->request->getPost('role');
            $data['is_active'] = $this->request->getPost('is_active');
        }

        $this->userModel->update($id, $data);

        return redirect()->to('/users')
            ->with('success', 'User berhasil diperbarui');
    }

    // ===============================
    // DELETE (PROTEKSI SUPERADMIN)
    // ===============================
    public function delete($id)
    {
        // ❌ tidak bisa hapus diri sendiri
        if (session()->get('user_id') == $id) {
            return redirect()->to('/users')
                ->with('error', 'Tidak bisa menghapus akun sendiri');
        }

        // ❌ superadmin kebal
        if ($id == $this->SUPERADMIN_ID) {
            return redirect()->to('/users')
                ->with('error', 'Superadmin tidak bisa dihapus');
        }

        $user = $this->userModel->find($id);

        if (! $user) {
            return redirect()->to('/users')
                ->with('error', 'User tidak ditemukan');
        }

        $this->userModel->delete($id);

        return redirect()->to('/users')
            ->with('success', 'User berhasil dihapus');
    }

    // ===============================
    // RESET PASSWORD (STEP 1)
    // ===============================
    public function resetPassword($id)
    {
        // ❌ tidak reset diri sendiri
        if (session()->get('user_id') == $id) {
            return redirect()->to('/users')
                ->with('error', 'Tidak bisa reset password akun sendiri');
        }

        // ❌ superadmin kebal
        if ($id == $this->SUPERADMIN_ID) {
            return redirect()->to('/users')
                ->with('error', 'Password superadmin tidak bisa direset');
        }

        $user = $this->userModel->find($id);

        if (! $user) {
            return redirect()->to('/users')
                ->with('error', 'User tidak ditemukan');
        }

        $newPassword = 'user' . rand(1000, 9999);

        $this->userModel->update($id, [
            'password_hash' => password_hash($newPassword, PASSWORD_DEFAULT),
            'force_reset'   => 1
        ]);

        return redirect()->to('/users')
            ->with('success', 'Password berhasil direset')
            ->with('new_password', $newPassword);
    }

    // ===============================
    // TOGGLE STATUS (STEP 2 - AJAX)
    // ===============================
    public function toggleStatus()
    {
        if (! $this->request->isAJAX()) {
            return $this->response->setStatusCode(403);
        }

        $id = $this->request->getPost('id');

        $user = $this->userModel->find($id);

        if (! $user) {
            return $this->response->setJSON([
                'status' => false,
                'message' => 'User tidak ditemukan'
            ]);
        }

        // ❌ tidak bisa nonaktifkan diri sendiri
        if ($id == session('user_id')) {
            return $this->response->setJSON([
                'status' => false,
                'message' => 'Tidak bisa menonaktifkan akun sendiri'
            ]);
        }

        // ❌ superadmin kebal
        if ($id == $this->SUPERADMIN_ID) {
            return $this->response->setJSON([
                'status' => false,
                'message' => 'Superadmin tidak bisa dinonaktifkan'
            ]);
        }

        $newStatus = $user['is_active'] ? 0 : 1;

        $this->userModel->update($id, [
            'is_active' => $newStatus
        ]);

        return $this->response->setJSON([
            'status'    => true,
            'is_active'=> $newStatus
        ]);
    }
}
