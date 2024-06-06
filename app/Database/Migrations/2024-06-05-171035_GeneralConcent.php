<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class GeneralConcent extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 5,
                'unsigned' => true,
                'auto_increment' => true
            ],
            'nama' => [
                'type' => 'VARCHAR',
                'constraint' => 255
            ],
            'umur' => [
                'type' => 'INT',
                'constraint' => 11
            ],
            'alamat' => [
                'type' => 'VARCHAR',
                'constraint' => 255
            ],
            'no_telp' => [
                'type' => 'VARCHAR',
                'constraint' => 255
            ],
            'status' => [
                'type' => 'ENUM',
                'constraint' => ['ayah', 'ibu', 'paman', 'tante', 'kakak', 'adik', 'kakek', 'suami', 'istri', 'nenek', 'saudara', 'lainnya']
            ],
            'id_pasien' => [
                'type' => 'INT',
                'constraint' => 11
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
        $this->forge->addForeignKey('id_pasien', 'pasiens', 'id', 'CASCADE', 'CASCADE', 'general_consent_pasien');
        $this->forge->createTable('general_consent');
    }

    public function down()
    {
        $this->forge->dropTable('general_consent');
    }
}