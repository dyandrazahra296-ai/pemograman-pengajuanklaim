<?php

namespace App\Services;

use App\Models\MedicalClaimModel;
use App\Models\ClaimLimitModel;
use App\Models\ClaimApprovalModel;

/**
 * ===============================
 * Service Keuangan
 * Logika bisnis pencairan klaim
 * ===============================
 */
class KeuanganService
{
    protected $claimModel;
    protected $limitModel;
    protected $approvalModel;

    public function __construct()
    {
        $this->claimModel    = new MedicalClaimModel();
        $this->limitModel    = new ClaimLimitModel();
        $this->approvalModel = new ClaimApprovalModel();
    }

    public function prosesPembayaran($claimId, $data)
    {
        $klaim = $this->claimModel->find($claimId);

        // Update klaim
        $this->claimModel->update($claimId, [
            'claim_amount' => $data['claim_amount'],
            'status'       => 'DIBAYARKAN_KEUANGAN',
            'paid_at'      => date('Y-m-d H:i:s')
        ]);

        // Update plafon
        $this->limitModel
            ->where('employee_id', $klaim['employee_id'])
            ->set('used_amount', 'used_amount + '.$data['claim_amount'], false)
            ->update();

        // Simpan approval keuangan
        $this->approvalModel->insert([
            'claim_id'      => $claimId,
            'approval_role' => 'KEUANGAN',
            'status'        => 'APPROVED',
            'note'          => $data['note']
        ]);
    }
}
    