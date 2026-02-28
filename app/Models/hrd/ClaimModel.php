<?php

namespace App\Models\Hrd;
use CodeIgniter\Model;

class ClaimModel extends Model
{
    protected $table = 'medical_claims';
    protected $primaryKey = 'claim_id';
    protected $allowedFields = ['status', 'approved_at'];

    public function getPendingClaims()
    {
        return $this->db->table('medical_claims c')
            ->select('c.*, e.full_name as emp_name, d.full_name as dep_name')
            ->join('employees e', 'c.employee_id = e.employee_id')
            ->join('dependents d', 'c.dependent_id = d.dependent_id', 'left')
            ->where('c.status', 'PENGAJUAN')
            ->get()->getResultArray();
    }

    public function getClaimHistory()
    {
        return $this->db->table('medical_claims c')
            ->select('c.*, e.full_name as emp_name, d.full_name as dep_name')
            ->join('employees e', 'c.employee_id = e.employee_id')
            ->join('dependents d', 'c.dependent_id = d.dependent_id', 'left')
            ->whereIn('c.status', ['DISETUJUI_HRD', 'DITOLAK_HRD', 'DIBAYARKAN_KEUANGAN'])
            ->orderBy('c.approved_at', 'DESC')
            ->get()->getResultArray();
    }

    public function getStats()
    {
        return [
            'total_pending'  => $this->where('status', 'PENGAJUAN')->countAllResults(),
            'total_nominal'  => $this->selectSum('claim_amount')->where('status', 'DISETUJUI_HRD')->get()->getRow()->claim_amount ?? 0,
            'total_approved' => $this->where('status', 'DISETUJUI_HRD')->countAllResults()
        ];
    }
}