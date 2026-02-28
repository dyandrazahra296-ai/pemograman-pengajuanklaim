<?php

namespace App\Models;

use CodeIgniter\Model;

class DependentModel extends Model
{
    protected $table = 'dependents';
    protected $primaryKey = 'dependent_id';
    protected $returnType = 'array';

    protected $allowedFields = [
        'employee_id',
        'full_name',
        'relationship',
        'birth_date',
        'is_active',
        'created_at'
    ];

    // TABEL TIDAK PUNYA updated_at
    protected $useTimestamps = false;
}
