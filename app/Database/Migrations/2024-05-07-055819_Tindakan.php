<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Tindakan extends Migration
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
            'tindakan' => [
                'type' => 'VARCHAR',
                'constraint' => 255
            ]
        ]);

        $this->forge->addKey('id', true);
        $this->forge->createTable('tindakans');
    }

    public function down()
    {
        $this->forge->dropTable('tindakans');
    }
}