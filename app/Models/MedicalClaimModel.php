<?php

namespace App\Models;

use CodeIgniter\Model;

class MedicalClaimModel extends Model
{
    protected $table      = 'medical_claims';
    protected $primaryKey = 'claim_id';
    protected $returnType = 'array';

    protected $allowedFields = [
        'employee_id',
        'dependent_id',
        'claim_date',
        'claim_amount',
        'claim_description',
        'receipt_file',
        'status',
        'created_at',
        'approved_at',
        'paid_at'
    ];

    // TABEL TIDAK PUNYA updated_at
    protected $useTimestamps = false;

    /* =====================================================
       KARYAWAN DASHBOARD
    ===================================================== */

    // Total klaim tahun ini
    public function totalKlaimTahunan(int $employeeId): int
    {
        return $this->where('employee_id', $employeeId)
                    ->where('YEAR(claim_date)', date('Y'), false)
                    ->countAllResults();
    }

    // Total klaim dibayar tahun ini
    public function totalTerpakaiTahunan(int $employeeId): float
    {
        return (float) (
            $this->selectSum('claim_amount')
                 ->where('employee_id', $employeeId)
                 ->where('status', 'DIBAYARKAN_KEUANGAN')
                 ->where('YEAR(claim_date)', date('Y'), false)
                 ->get()
                 ->getRow()
                 ->claim_amount ?? 0
        );
    }

    // Riwayat klaim karyawan
    public function riwayatTahunan(int $employeeId): array
    {
        return $this->where('employee_id', $employeeId)
                    ->where('YEAR(claim_date)', date('Y'), false)
                    ->orderBy('claim_date', 'DESC')
                    ->findAll();
    }

    // Grafik klaim per bulan
    public function klaimPerBulan(int $employeeId): array
    {
        return $this->select('MONTH(claim_date) AS bulan, COUNT(*) AS total')
                    ->where('employee_id', $employeeId)
                    ->where('YEAR(claim_date)', date('Y'), false)
                    ->groupBy('bulan')
                    ->orderBy('bulan')
                    ->findAll();
    }

    // Statistik status klaim
    public function statusTahunan(int $employeeId): array
    {
        return $this->select('status, COUNT(*) AS total')
                    ->where('employee_id', $employeeId)
                    ->where('YEAR(claim_date)', date('Y'), false)
                    ->groupBy('status')
                    ->findAll();
    }

    /* =====================================================
       ADMIN
    ===================================================== */

    // Klaim masuk (pending)
    public function klaimMasuk(): array
    {
        return $this->where('status', 'PENGAJUAN')
                    ->orderBy('created_at', 'DESC')
                    ->findAll();
    }

    // Semua klaim
    public function semuaKlaim(): array
    {
        return $this->orderBy('created_at', 'DESC')
                    ->findAll();
    }

    // Rekap status klaim
    public function rekapStatus(): array
    {
        return $this->select('status, COUNT(*) AS total')
                    ->groupBy('status')
                    ->findAll();
    }

    // Data laporan klaim (admin report)
    public function getReportData(array $filters): array
    {
        $builder = $this->select('medical_claims.*, employees.full_name')
                        ->join('employees', 'employees.employee_id = medical_claims.employee_id');

        if (!empty($filters['status'])) {
            $builder->where('medical_claims.status', $filters['status']);
        }

        if (!empty($filters['start_date']) && !empty($filters['end_date'])) {
            $builder->where('claim_date >=', $filters['start_date'])
                    ->where('claim_date <=', $filters['end_date']);
        }

        return $builder->orderBy('claim_date', 'DESC')->findAll();
    }
}
