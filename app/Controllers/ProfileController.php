<?php

namespace App\Controllers;

use App\Models\UserModel;

class ProfileController extends BaseController
{
    protected $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    /**
     * =========================
     * HALAMAN PROFILE
     * =========================
     */
    public function index()
    {
        // safety check
        if (! session()->get('user_id')) {
            return redirect()->to('/login');
        }

        $user = $this->userModel->find(session('user_id'));

        if (! $user) {
            return redirect()->to('/login');
        }

        return view('profile/index', [
            'user' => $user
        ]);
    }

    /**
     * =========================
     * GANTI PASSWORD
     * =========================
     */
    public function changePassword()
    {
        if (! session()->get('user_id')) {
            return redirect()->to('/login');
        }

        $passwordLama = $this->request->getPost('old_password');
        $passwordBaru = $this->request->getPost('new_password');

        if (strlen($passwordBaru) < 6) {
            return redirect()->back()
                ->with('error', 'Password baru minimal 6 karakter');
        }

        $user = $this->userModel->find(session('user_id'));

        if (! password_verify($passwordLama, $user['password'])) {
            return redirect()->back()
                ->with('error', 'Password lama salah');
        }

        $this->userModel->update(session('user_id'), [
            'password'    => password_hash($passwordBaru, PASSWORD_DEFAULT),
            'force_reset' => 0
        ]);

        return redirect()->back()
            ->with('success', 'Password berhasil diubah');
    }
}
