<?php

namespace App\Controllers;
use App\Models\ClaimModel;

class HrdKeuangan extends BaseController
{
    protected $claimModel;

    public function __construct() {
        $this->claimModel = new ClaimModel();
    }

    public function index() {
        // Mengambil data dari model yang sudah tanpa join dependents
        $data['claims'] = $this->claimModel->getPendingClaims() ?: [];
        return view('hrd/approval_list', $data);
    }

    public function process($action, $id) {
        $hrd_id = session()->get('user_id') ?? 1; // Default ke ID 1 jika session kosong
        $status = ($action == 'approve') ? 'DISETUJUI_HRD' : 'DITOLAK_HRD';

        if ($this->claimModel->updateStatus($id, $status, $hrd_id)) {
            return redirect()->to('hrd/approvals')->with('message', 'Status pengajuan berhasil diperbarui.');
        }
        return redirect()->to('hrd/approvals')->with('error', 'Terjadi kesalahan saat memperbarui status.');
    }
}