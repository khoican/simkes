<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class ObatRacikan extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'auto_increment' => true
            ],
            'id_pasien' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => true
            ],
            'id_rekmed' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => true
            ],
            'signa' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true
            ],
            'satuan' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true
            ],
            'ket' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true
            ],
            'jml_resep' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => true
            ],
            'jml_diberikan' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => true
            ],
            'status' => [
                'type' => 'ENUM',
                'constraint' => ['belum', 'sudah'],
                'default' => 'belum'
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true
            ]
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('id_pasien', 'pasiens', 'id', 'cascade', 'cascade', 'racikan_pasien');
        $this->forge->addForeignKey('id_rekmed', 'rekmeds', 'id', 'cascade', 'cascade', 'racikan_rekmed');
        $this->forge->createTable('obat_racikans');
        
    }

    public function down()
    {
        $this->forge->dropTable('obat_racikans');
    }
}