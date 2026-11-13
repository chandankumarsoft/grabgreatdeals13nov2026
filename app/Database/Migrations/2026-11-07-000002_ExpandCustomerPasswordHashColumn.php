<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use RuntimeException;

class ExpandCustomerPasswordHashColumn extends Migration
{
    public function up()
    {
        if ($this->db->getPlatform() !== 'MySQLi') {
            throw new RuntimeException('The customer password migration requires MySQL or MariaDB.');
        }

        $this->forge->modifyColumn('tbl_customer', [
            'cus_password' => [
                'name'       => 'cus_password',
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
            ],
        ]);
    }

    public function down()
    {
        if ($this->db->getPlatform() !== 'MySQLi') {
            throw new RuntimeException('The customer password migration requires MySQL or MariaDB.');
        }

        $longPasswords = $this->db->table('tbl_customer')
            ->where('CHAR_LENGTH(cus_password) >', 100, false)
            ->countAllResults();
        if ($longPasswords > 0) {
            throw new RuntimeException('Cannot shrink cus_password: stored values exceed 100 characters.');
        }

        $this->forge->modifyColumn('tbl_customer', [
            'cus_password' => [
                'name'       => 'cus_password',
                'type'       => 'VARCHAR',
                'constraint' => 100,
                'null'       => true,
            ],
        ]);
    }
}
