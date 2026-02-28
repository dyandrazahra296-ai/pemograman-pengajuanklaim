<?php

namespace App\Models;

use CodeIgniter\Model;

class ClaimApprovalModel extends Model
{
    protected $table      = 'claim_approvals';
    protected $primaryKey = 'approval_id';
    protected $returnType = 'array';

    protected $allowedFields = [
        'claim_id',
        'approved_by',
        'approval_role',
        'status',
        'note',
        'approval_date'
    ];

    // approval_date DISET MANUAL
    protected $useTimestamps = false;

    /* =====================================================
       CREATE APPROVAL (ADMIN / HRD / KEUANGAN LOGIC)
    ===================================================== */

    public function createApproval(
        int $claimId,
        int $approvedBy,
        string $role,
        string $status,
        string $note = null
    ) {
        return $this->insert([
            'claim_id'       => $claimId,
            'approved_by'    => $approvedBy,
            'approval_role'  => strtolower($role),
            'status'         => $status,
            'note'           => $note,
            'approval_date'  => date('Y-m-d H:i:s')
        ]);
    }

    /* =====================================================
       HISTORY
    ===================================================== */

    public function getByClaim(int $claimId)
    {
        return $this->where('claim_id', $claimId)
                    ->orderBy('approval_date', 'ASC')
                    ->findAll();
    }

    /* =====================================================
       CHECK STATUS TERAKHIR
    ===================================================== */

    public function getLastApproval(int $claimId)
    {
        return $this->where('claim_id', $claimId)
                    ->orderBy('approval_date', 'DESC')
                    ->first();
    }
}
