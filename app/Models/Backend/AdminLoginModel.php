<?php

namespace App\Models\Backend;

use CodeIgniter\Database\BaseConnection;

final class AdminLoginModel
{
    public function __construct(private readonly ?BaseConnection $database = null)
    {
    }

    public function findUserByEmail(string $email): ?object
    {
        $user = $this->db()->table('tbl_user')
            ->where('user_email', $email)
            ->get()
            ->getRow();

        return $user === null ? null : (object) $user;
    }

    public function userEmailExists(string $email): bool
    {
        return $this->db()->table('tbl_user')
            ->where('user_email', $email)
            ->countAllResults() > 0;
    }

    /**
     * @param array{name: string, email: string, mobile: string, adminrole: string, password: string} $data
     */
    public function pendingAdminExists(array $data): bool
    {
        return $this->db()->table('tbl_admin_user')
            ->groupStart()
            ->where('email', $data['email'])
            ->orWhere('mobile', $data['mobile'])
            ->groupEnd()
            ->countAllResults() > 0;
    }

    /**
     * @param array{name: string, email: string, mobile: string, adminrole: string, password: string} $data
     */
    public function createPendingAdmin(array $data): bool
    {
        return $this->db()->table('tbl_admin_user')->insert($data);
    }

    /**
     * @param array{username: string, user_email: string, user_password: string, user_role: int, user_status: int} $data
     */
    public function createUser(array $data): bool
    {
        return $this->db()->table('tbl_user')->insert($data);
    }

    private function db(): BaseConnection
    {
        return $this->database ?? db_connect();
    }
}
