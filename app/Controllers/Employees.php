<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\EmployeeModel;

class Employees extends BaseController
{
    public function index()
    {
        $model = new EmployeeModel();

        $employees = $model
            ->orderBy('employee_id', 'DESC')
            ->findAll();

        return view('admin/employees/index', [
            'title'           => 'Data Karyawan',
            'employees'       => $employees,
            'totalEmployees'  => count($employees),
        ]);
    }
}
