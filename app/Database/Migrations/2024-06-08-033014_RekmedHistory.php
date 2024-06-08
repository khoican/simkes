<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class RekmedHistory extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true
            ],
            'id_kunjungan' => [
                'type' => 'INT',
                'constraint' => 11
            ],
            'datang' => [
                'type' => 'TIME'
            ],
            'pulang' => [
                'type' => 'TIME'
            ],
            'created_at' => [
                'type' => 'DATETIME'
            ],
            'updated_at' => [
                'type' => 'DATETIME'
            ]
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('id_kunjungan', 'kunjungans', 'id', 'cascade', 'cascade');
        $this->forge->createTable('rekmed_history');
    }

    public function down()
    {
        $this->forge->dropTable('rekmed_history');
    }
}