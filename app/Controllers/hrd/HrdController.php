<?php
namespace App\Controllers\Hrd; // Pastikan H kapital

use App\Controllers\BaseController; // Wajib tambah ini!
use App\Models\hrd\ClaimModel;

class HrdController extends BaseController {
    protected $claimModel;
    public function __construct() { $this->claimModel = new ClaimModel(); }

    public function index() {
        $data = ['stats' => $this->claimModel->getStats(), 'claims' => $this->claimModel->getPendingClaims()];
        return view('hrd/dashboard', $data);
    }

    public function history() {
        $data['claims'] = $this->claimModel->getClaimHistory();
        return view('hrd/history', $data);
    }

    public function process($action, $id) {
        $status = ($action == 'approve') ? 'DISETUJUI_HRD' : 'DITOLAK_HRD';
        $this->claimModel->update($id, [
            'status' => $status, 
            'approved_at' => date('Y-m-d H:i:s')
        ]);
        return redirect()->to(base_url('hrd/dashboard'));
    }

    

}