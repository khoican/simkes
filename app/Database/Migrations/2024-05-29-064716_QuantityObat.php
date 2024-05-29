<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class QuantityObat extends Migration
{
    public function up()
    {
        $this->forge->addField( [
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'auto_increment' => true
            ],
            'id_obat' => [
                'type'           => 'INT',
                'constraint'     => 11
            ],
            'masuk' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'null'           => true
            ],
            'keluar' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'null'           => true
            ],
            'created_at' => [
                'type'           => 'DATETIME',
                'null'           => true
            ],
            'updated_at' => [
                'type'           => 'DATETIME',
                'null'           => true
            ]
        ]);

        $this->forge->addPrimaryKey('id');
        $this->forge->addForeignKey('id_obat', 'obats', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('quantity_obats');
    }

    public function down()
    {
        $this->forge->dropTable('quantity_obats');
    }
}