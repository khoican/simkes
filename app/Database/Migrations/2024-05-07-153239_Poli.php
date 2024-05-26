<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Poli extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'auto_increment' => true
            ],
            'nama' => [
                'type' => 'VARCHAR',
                'constraint' => 255
            ],
            'kode' => [
                'type' => 'VARCHAR',
                'constraint' => 2
            ]

        ]);

        $this->forge->addKey('id', true);
        $this->forge->createTable('polis');
    }

    public function down()
    {
        $this->forge->dropTable('polis');
    }
}