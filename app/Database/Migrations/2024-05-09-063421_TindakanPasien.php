<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class TindakanPasien extends Migration
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
            'id_tindakan' => [
                'type' => 'INT',
                'null' => true
            ],
            'id_rekmed' => [
                'type' => 'INT',
                'null' => true
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
        $this->forge->addForeignKey('id_pasien', 'pasiens', 'id', 'cascade', 'cascade', 'tindakan_pasien');
        $this->forge->addForeignKey('id_tindakan', 'tindakans', 'id', 'cascade', 'cascade', 'tindakan_tindakan');
        $this->forge->addForeignKey('id_rekmed', 'rekmeds', 'id', 'cascade', 'cascade', 'tindakan_rekmed');
        $this->forge->createTable('tindakan_pasiens');
    }

    public function down()
    {
        $this->forge->dropTable('tindakan_pasiens');
    }
}