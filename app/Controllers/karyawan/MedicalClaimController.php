<?php

namespace App\Controllers\Karyawan;

use App\Controllers\BaseController;
use App\Models\ClaimLimitModel;
use App\Models\MedicalClaimModel;
use App\Models\DependentModel;
use App\Models\EmployeeModel;

class MedicalClaimController extends BaseController
{
    public function index()
    {
        $employeeId = session('employee_id');
        if (!$employeeId) return redirect()->to('/login');

        $year = date('Y');
        $limitModel     = new ClaimLimitModel();
        $claimModel     = new MedicalClaimModel();
        $dependentModel = new DependentModel();
        $employeeModel  = new EmployeeModel();

        $employee = $employeeModel->find($employeeId);
        if (!$employee) return "Data profil karyawan tidak ditemukan.";

        $limit = $limitModel->where(['employee_id' => $employeeId, 'year' => $year])->first();
        $claims = $claimModel
             ->select('medical_claims.*, dependents.full_name, dependents.relationship')
             ->join('dependents', 'dependents.dependent_id = medical_claims.dependent_id', 'left')
             ->where('medical_claims.employee_id', $employeeId)
             ->orderBy('claim_date', 'DESC')
             ->findAll();

             // =====================
// HITUNG CHART BULANAN
// =====================
$chartBulanan = array_fill(0, 6, 0); // Jan–Jun

foreach ($claims as $c) {
    $bulan = (int) date('n', strtotime($c['claim_date'])); // 1-12
    if ($bulan <= 6) {
        $chartBulanan[$bulan - 1]++;
    }
}

// =====================
// KOMPOSISI KLAIM
// =====================
$komposisi = [0, 0, 0]; 
// [karyawan, pasangan, anak]

foreach ($claims as $c) {
    if (empty($c['dependent_id'])) {
        $komposisi[0]++; // karyawan
    } else {
        $rel = strtolower($c['relationship'] ?? '');
        if (str_contains($rel, 'istri') || str_contains($rel, 'suami')) {
            $komposisi[1]++;
        } else {
            $komposisi[2]++;
        }
    }
}
        return view('karyawan/employee/dashboard', [
    'employee'      => $employee,
    'dependents'    => $dependentModel->where('employee_id', $employeeId)->findAll(),
    'claims'        => $claims,
    'limit'         => $limit,
    'chartBulanan'  => $chartBulanan,
    'komposisi'     => $komposisi
]);
    }

    public function create()
    {
        $employeeId = session('employee_id');
        $dependentModel = new DependentModel();
        return view('karyawan/karyawan/ajukan_klaim', [
            'dependents' => $dependentModel->where('employee_id', $employeeId)->findAll()
        ]);
    }

    public function submitClaim()
{
    $employeeId = session('employee_id');
    $claimModel = new \App\Models\MedicalClaimModel();

    $claimModel->insert([
        'employee_id'       => $employeeId,
        'dependent_id'      => $this->request->getPost('dependent_id') ?: null,
        'claim_date'        => $this->request->getPost('claim_date'),
        'claim_amount'      => str_replace('.', '', $this->request->getPost('claim_amount')),
        'claim_description' => $this->request->getPost('claim_description'),
        'status'            => 'PENGAJUAN', // ✅ WAJIB INI
        'created_at'        => date('Y-m-d H:i:s')
    ]);

    return redirect()->to(base_url('karyawan/dashboard'))
        ->with('success', 'Klaim berhasil diajukan');
}
    // Menampilkan form pengajuan plafon
public function ajukanPlafon()
{
    $employeeId = session('employee_id');
    if (!$employeeId) return redirect()->to('/login');

    return view('karyawan/karyawan/ajukan_plafon');
}

// Memproses penyimpanan plafon ke database
public function submitPlafon()
{
    $employeeId = session('employee_id');
    $limitModel = new ClaimLimitModel();

    $year = date('Y'); // Atau ambil dari input jika fleksibel

    // Cek apakah plafon untuk tahun ini sudah pernah diajukan
    $existingLimit = $limitModel->where(['employee_id' => $employeeId, 'year' => $year])->first();
    
    if ($existingLimit) {
        return redirect()->back()->with('error', 'Plafon untuk tahun ' . $year . ' sudah ada.');
    }

    $limitModel->insert([
        'employee_id'    => $employeeId,
        'year'           => $year,
        'total_limit'    => $this->request->getPost('total_limit'),
        'remaining_limit'=> $this->request->getPost('total_limit'), // Awalnya sisa = total
        'status'         => 'PENDING', // Biasanya butuh approval HRD
        'created_at'     => date('Y-m-d H:i:s')
    ]);

    return redirect()->to(base_url('karyawan/dashboard'))->with('success', 'Pengajuan plafon berhasil dikirim.');
}
}
