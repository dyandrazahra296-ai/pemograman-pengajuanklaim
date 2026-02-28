<?php

namespace App\Models;

use CodeIgniter\Model;

class ClaimApprovalModel extends Model
{
    protected $table      = 'claim_approvals';
    protected $primaryKey = 'approval_id';

    protected $allowedFields = [
        'claim_id',
        'approval_role',
        'status',
        'note'
    ];
}
