<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Diagnosa extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'auto_increment' => true
            ],
            'kode' => [
                'type' => 'VARCHAR',
                'constraint' => 5
            ],
            'diagnosa' => [
                'type' => 'VARCHAR',
                'constraint' => 255
            ]
        ]);

        $this->forge->addKey('id', true);
        $this->forge->createTable('diagnosas');
    }

    public function down()
    {
        $this->forge->dropTable('diagnosas');
    }
}