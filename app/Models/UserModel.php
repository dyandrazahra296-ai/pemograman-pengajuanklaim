<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table      = 'users';
    protected $primaryKey = 'user_id';
    protected $returnType = 'array';

    protected $allowedFields = [
        'employee_id',
        'username',
        'password_hash',
        'full_name',
        'role',
        'is_active',
        'force_reset',
        'last_login',
        'created_at',
        'updated_at'
    ];

    protected $useTimestamps = false;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    /* ===============================
       AUTH
    =============================== */

    public function getActiveUserByUsername(string $username)
    {
        return $this->where([
            'username'  => $username,
            'is_active' => 1
        ])->first();
    }

    /* ===============================
       ADMIN DASHBOARD
    =============================== */

    public function countAllUsers(): int
    {
        return $this->countAllResults();
    }

    public function countActiveUsers(): int
    {
        return $this->where('is_active', 1)->countAllResults();
    }

    public function countInactiveUsers(): int
    {
        return $this->where('is_active', 0)->countAllResults();
    }

    public function countByRole(): array
    {
        return $this->select('role, COUNT(*) as total')
                    ->groupBy('role')
                    ->findAll();
    }

    /* ===============================
       ROLE CHECK (OPTIONAL)
    =============================== */

    public function isRole(int $userId, string $role): bool
    {
        return (bool) $this->where([
            'user_id' => $userId,
            'role'    => $role
        ])->countAllResults();
    }
}
