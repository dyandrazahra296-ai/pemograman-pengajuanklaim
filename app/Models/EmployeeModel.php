<?php

namespace App\Models;

use CodeIgniter\Model;

class EmployeeModel extends Model
{
    protected $table      = 'employees';
    protected $primaryKey = 'employee_id';

    protected $allowedFields = [
        'employee_code',
        'full_name',
        'department',
        'position',
        'is_active',
        'created_at',
        'updated_at'
    ];

    protected $useTimestamps = false;
}
