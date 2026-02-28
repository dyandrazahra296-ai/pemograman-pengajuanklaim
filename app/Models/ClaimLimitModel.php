<?php

namespace App\Models;

use CodeIgniter\Model;

class ClaimLimitModel extends Model
{
    protected $table      = 'claim_limits';
    protected $primaryKey = 'claim_limit_id';
    protected $returnType = 'array';

    protected $allowedFields = [
        'employee_id',
        'year',
        'max_claim_amount',
        'used_amount',
        'created_at'
    ];

    // TABEL TIDAK PUNYA updated_at
    protected $useTimestamps = false;

    /* =====================================================
       KARYAWAN
    ===================================================== */

    // Ambil plafon klaim tahun ini
    public function getPlafonTahunIni(int $employeeId)
    {
        return $this->where('employee_id', $employeeId)
                    ->where('year', date('Y'))
                    ->first();
    }

    // Auto create plafon kalau belum ada
    public function createPlafonIfNotExists(
        int $employeeId,
        int $defaultPlafon = 10000000
    ) {
        $plafon = $this->getPlafonTahunIni($employeeId);

        if (!$plafon) {
            $this->insert([
                'employee_id'      => $employeeId,
                'year'             => date('Y'),
                'max_claim_amount' => $defaultPlafon,
                'used_amount'      => 0,
                'created_at'       => date('Y-m-d H:i:s')
            ]);
        }

        return $this->getPlafonTahunIni($employeeId);
    }

    /* =====================================================
       ADMIN
    ===================================================== */

    // Ambil plafon employee tertentu (admin)
    public function getByEmployeeAndYear(int $employeeId, int $year)
    {
        return $this->where([
            'employee_id' => $employeeId,
            'year'        => $year
        ])->first();
    }

    // Update plafon (admin)
    public function updatePlafon(
        int $employeeId,
        int $year,
        int $maxClaimAmount
    ): bool {
        return (bool) $this->where([
            'employee_id' => $employeeId,
            'year'        => $year
        ])->set([
            'max_claim_amount' => $maxClaimAmount
        ])->update();
    }
}
