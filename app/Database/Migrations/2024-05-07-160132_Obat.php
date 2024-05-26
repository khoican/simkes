<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Obat extends Migration
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
                'constraint' => 255
            ],
            'obat' => [
                'type' => 'VARCHAR',
                'constraint' => 255
            ],
            'jenis' => [
                'type' => 'VARCHAR',
                'constraint' => 255
            ],
            'bentuk' => [
                'type' => 'VARCHAR',
                'constraint' => 255
            ],
            'stok' => [
                'type' => 'INT',
            ],
            'harga' => [
                'type' => 'INT',
            ]
        ]);

        $this->forge->addKey('id', true);
        $this->forge->createTable('obats');
    }

    public function down()
    {
        $this->forge->dropTable('obats');
    }
}