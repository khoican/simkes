<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class KunjunganHistory extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'auto_increment' => true
            ],
            'no_antrian' => [
                'type' => 'VARCHAR',
                'constraint' => 10
            ],
            'status' => [
                'type' => 'ENUM',
                'constraint' => ['pemeriksaan', 'apotek']
            ],
            'id_poli' => [
                'type' => 'INT',
                'constraint' => 11
            ],
            'created_at' => [
                'type' => 'TIMESTAMP',
                'null' => true
            ],
            'updated_at' => [
                'type' => 'TIMESTAMP',
                'null' => true
            ],
            'deleted_at' => [
                'type' => 'TIMESTAMP',
                'null' => true
            ]
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('id_poli', 'polis', 'id', 'cascade', 'cascade', 'polis_id');
        $this->forge->createTable('kunjungan_history');
    }

    public function down()
    {
        $this->forge->dropTable('kunjungan_history');
    }
}