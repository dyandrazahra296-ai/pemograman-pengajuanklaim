<?php

namespace App\Models;

use CodeIgniter\Model;

class ClaimLimitModel extends Model
{
    protected $table      = 'claim_limits';
    protected $primaryKey = 'employee_id';

    protected $allowedFields = [
        'used_amount'
    ];
}
