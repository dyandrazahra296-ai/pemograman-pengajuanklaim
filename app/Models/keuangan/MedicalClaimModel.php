<?php

namespace App\Models\Keuangan;

use CodeIgniter\Model;

/**
 * ======================================
 * Model Medical Claims
 * tabel : medical_claims
 * ======================================
 */
class MedicalClaimModel extends Model
{
    protected $table      = 'medical_claims';
    protected $primaryKey = 'claim_id';

    protected $allowedFields = [
        'employee_id',
        'dependent_id',
        'claim_amount',
        'status',
        'paid_at'
    ];


    /* ======================================
       Chart Klaim Bulanan
       dipakai di dashboard chart
    ====================================== */
    public function getChartKlaimBulanan()
    {
        return $this->select("
                MONTH(paid_at) as bulan,
                SUM(claim_amount) as total
            ")
            ->where('status', 'DIBAYARKAN_KEUANGAN')
            ->groupBy('MONTH(paid_at)')
            ->findAll();
    }



    /* ======================================
       Klaim SUDAH dibayar + data karyawan
       dipakai RIWAYAT & PDF
    ====================================== */
    public function getPaidWithEmployee()
    {
        return $this->select("
                medical_claims.*,
                e.full_name,
                e.nik,
                e.position,
                e.department
            ")
            ->join('employees e', 'e.employee_id = medical_claims.employee_id')
            ->where('medical_claims.status', 'DIBAYARKAN_KEUANGAN')
            ->orderBy('medical_claims.paid_at', 'DESC')
            ->findAll();
    }



    /* ======================================
       Klaim disetujui HRD + data karyawan
       dipakai halaman klaim keuangan
    ====================================== */
    public function getApprovedWithEmployee()
    {
        return $this->select("
                medical_claims.*,
                e.full_name,
                e.nik,
                e.position,
                e.department
            ")
            ->join('employees e', 'e.employee_id = medical_claims.employee_id')
            ->where('medical_claims.status', 'DISETUJUI_HRD')
            ->orderBy('medical_claims.created_at', 'DESC')
            ->findAll();
    }
}