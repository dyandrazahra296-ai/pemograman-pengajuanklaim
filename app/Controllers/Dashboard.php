<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Models\EmployeeModel;
use App\Models\MedicalClaimModel;

class Dashboard extends BaseController
{
    public function index()
    {
        $userModel     = new UserModel();
        $employeeModel = new EmployeeModel();
        $claimModel    = new MedicalClaimModel();

        /* ===============================
           USER STATISTIC
        =============================== */
        $totalUsers      = $userModel->countAllUsers();
        $activeUsers     = $userModel->countActiveUsers();
        $inactiveUsers   = $userModel->countInactiveUsers();
        $usersByRole     = $userModel->countByRole();

        /* ===============================
           EMPLOYEE
        =============================== */
        $totalEmployees  = $employeeModel->countAll();

        /* ===============================
           CLAIM STATISTIC
        =============================== */
        $pendingClaims  = $claimModel->where('status', 'PENGAJUAN')->countAllResults();

        $approvedClaims = $claimModel
            ->whereIn('status', [
                'DISETUJUI_HRD',
                'DIBAYARKAN_KEUANGAN'
            ])
            ->countAllResults();

        $rejectedClaims = $claimModel
            ->where('status', 'DITOLAK_HRD')
            ->countAllResults();

        /* ===============================
           CHART DINAMIS (KLAIM PER BULAN)
        =============================== */

        $year = date('Y');

        $chartQuery = $claimModel
            ->select("MONTH(created_at) as month, COUNT(*) as total")
            ->where("YEAR(created_at)", $year)
            ->groupBy("MONTH(created_at)")
            ->orderBy("MONTH(created_at)", "ASC")
            ->findAll();

        // Siapkan 12 bulan default 0
        $chartData = array_fill(1, 12, 0);

        foreach ($chartQuery as $row) {
            $chartData[(int)$row['month']] = (int)$row['total'];
        }

        // Label bulan
        $chartLabels = [
            'Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun',
            'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'
        ];

        // Reset index agar mulai dari 0
        $chartData = array_values($chartData);

        return view('admin/dashboard', [
            // user
            'totalUsers'    => $totalUsers,
            'activeUsers'   => $activeUsers,
            'inactiveUsers' => $inactiveUsers,
            'usersByRole'   => $usersByRole,

            // employee
            'totalEmployees' => $totalEmployees,

            // claim
            'pendingClaims'  => $pendingClaims,
            'approvedClaims' => $approvedClaims,
            'rejectedClaims' => $rejectedClaims,

            // chart
            'chartLabels' => $chartLabels,
            'chartData'   => $chartData,
        ]);
    }
}