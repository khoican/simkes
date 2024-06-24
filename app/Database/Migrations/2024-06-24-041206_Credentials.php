<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Credentials extends Migration
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
            'username' => [
                'type' => 'VARCHAR',
                'constraint' => 255
            ],
            'credential' => [
                'type' => 'TEXT',
            ]
        ]);

        $this->forge->addKey('id', true);
        $this->forge->createTable('credentials');
    }

    public function down()
    {
        $this->forge->dropTable('credentials', true);
    }
}