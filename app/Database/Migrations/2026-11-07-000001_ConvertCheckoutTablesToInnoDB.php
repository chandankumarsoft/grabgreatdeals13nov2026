<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use RuntimeException;

class ConvertCheckoutTablesToInnoDB extends Migration
{
    private const TABLES = [
        'tbl_order',
        'tbl_order_details',
        'tbl_payment',
        'tbl_billing',
        'tbl_shipping',
        'tbl_product',
    ];

    public function up()
    {
        $this->convertTables('InnoDB');
    }

    public function down()
    {
        $this->convertTables('MyISAM');
    }

    private function convertTables(string $engine): void
    {
        if ($this->db->getPlatform() !== 'MySQLi') {
            throw new RuntimeException('The checkout table engine migration requires MySQL or MariaDB.');
        }

        foreach (self::TABLES as $table) {
            $tableName = $this->db->escapeIdentifiers($this->db->prefixTable($table));
            $this->db->query("ALTER TABLE {$tableName} ENGINE={$engine}");
        }
    }
}
