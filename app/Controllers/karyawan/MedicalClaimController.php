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
        $claims = $claimModel->where('employee_id', $employeeId)->orderBy('claim_date', 'DESC')->findAll();

        return view('karyawan/employee/dashboard', [
            'employee'   => $employee,
            'dependents' => $dependentModel->where('employee_id', $employeeId)->findAll(),
            'claims'     => $claims,
            'limit'      => $limit
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
        $claimModel = new MedicalClaimModel();
        
        $claimModel->insert([
            'employee_id'       => $employeeId,
            'dependent_id'      => $this->request->getPost('dependent_id') ?: null,
            'claim_date'        => $this->request->getPost('claim_date'),
            'claim_amount'      => $this->request->getPost('claim_amount'),
            'claim_description' => $this->request->getPost('claim_description'),
            'status'            => 'MENUNGGU_HRD',
            'created_at'        => date('Y-m-d H:i:s')
        ]);

        return redirect()->to(base_url('karyawan/dashboard'))->with('success', 'Klaim berhasil diajukan');
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