<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Alamat extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'auto_increment' => true
            ],
            'alamat' => [
                'type' => 'VARCHAR',
                'constraint' => 255
            ],
            'rt' => [
                'type' => 'INT',
                'constraint' => 5
            ],
            'rw' => [
                'type' => 'INT',
                'constraint' => 5
            ],
            'kelurahan' => [
                'type' => 'VARCHAR',
                'constraint' => 255
            ],
            'kecamatan' => [
                'type' => 'VARCHAR',
                'constraint' => 255
            ],
            'kota' => [
                'type' => 'VARCHAR',
                'constraint' => 255
            ],

        ]);

        $this->forge->addKey('id', true);
        $this->forge->createTable('alamats');
    }

    public function down()
    {
        $this->forge->dropTable('alamats');
    }
}