<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\MedicalClaimModel;
use App\Models\EmployeeModel;

class MedicalClaims extends BaseController
{
    /**
     * KLAIM MASUK (ADMIN)
     * Menampilkan klaim dengan status PENGAJUAN
     */
    public function index()
    {
        $claimModel    = new MedicalClaimModel();
        $employeeModel = new EmployeeModel();

        $claims = $claimModel
            ->where('status', 'PENGAJUAN')
            ->orderBy('created_at', 'DESC')
            ->findAll();

        foreach ($claims as &$c) {
            $employee = $employeeModel->find($c['employee_id']);
            // Diubah ke 'employee_name' agar sesuai dengan View index baris 44
            $c['employee_name'] = $employee['full_name'] ?? '-'; 
            $c['department']    = $employee['department'] ?? '-';
        }

        return view('admin/claims/index', [
            'claims'       => $claims,
            'totalPending' => count($claims),
        ]);
    }

    /**
     * RIWAYAT KLAIM (ADMIN)
     * Menampilkan semua status KECUALI PENGAJUAN
     */
    public function history()
    {
        $claimModel    = new MedicalClaimModel();
        $employeeModel = new EmployeeModel();

        // Ambil data yang statusnya sudah diproses
        $claims = $claimModel
            ->whereIn('status', ['DISETUJUI_HRD', 'DITOLAK_HRD', 'DIBAYARKAN_KEUANGAN'])
            ->orderBy('created_at', 'DESC')
            ->findAll();

        foreach ($claims as &$c) {
            $employee = $employeeModel->find($c['employee_id']);
            
            // Menggunakan 'emp_name' sesuai dengan View history
            $c['emp_name'] = $employee['full_name'] ?? '-'; 
            
            // Ambil nama tanggungan jika ada untuk kolom (Nama) di history
            $c['dep_name'] = $employee['dependent_name'] ?? '';
        }

        return view('admin/claims/history', [
            'claims' => $claims,
        ]);
    }
}