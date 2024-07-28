<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class DiagnosaPasien extends Migration
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
                'null' => true
            ],
            'id_diagnosa' => [
                'type' => 'INT',
                'null' => true
            ],
            'id_rekmed' => [
                'type' => 'INT',
                'null' => true
            ],
            'status' => [
                'type' => 'ENUM',
                'constraint' => ['utama', 'sekunder'],
                'default' => 'sekunder'
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
        $this->forge->addForeignKey('id_pasien', 'pasiens', 'id', 'cascade', 'cascade', 'diagnosa_pasien');
        $this->forge->addForeignKey('id_diagnosa', 'diagnosas', 'id', 'cascade', 'cascade', 'diagnosa_diagnosa');
        $this->forge->addForeignKey('id_rekmed', 'rekmeds', 'id', 'cascade', 'cascade', 'diagnosa_rekmed');
        $this->forge->createTable('diagnosa_pasiens');
    }

    public function down()
    {
        $this->forge->dropTable('diagnosa_pasiens');
    }
}