<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class ObatPasien extends Migration
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
            'id_obat' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => true
            ],
            'note' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
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
        $this->forge->addForeignKey('id_pasien', 'pasiens', 'id', 'cascade', 'cascade', 'resep_pasien');
        $this->forge->addForeignKey('id_rekmed', 'rekmeds', 'id', 'cascade', 'cascade', 'resep_rekmed');
        $this->forge->addForeignKey('id_obat', 'obats', 'id', 'cascade', 'cascade', 'resep_obat');
        $this->forge->createTable('obat_pasien');
    }

    public function down()
    {
        $this->forge->dropTable('obat_pasien');
    }
}