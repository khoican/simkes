<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Kunjungan extends Migration
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
            'id_pasien' => [
                'type' => 'INT',
            ],
            'id_poli' => [
                'type' => 'INT',
            ],
            'id_rekmed' => [
                'type' => 'INT',
                'null' => true
            ],
            'status' => [
                'type' => 'ENUM',
                'constraint' => ['antrian', 'pemeriksaan', 'antrian-obat', 'pengambilan-obat', 'selesai'],
                'default' => 'antrian'
            ],
            'panggil' => [
                'type' => 'BOOLEAN',
                'default' => false
            ],
            'created_at' => [
                'type' => 'DATETIME',
            ],
            'updated_at' => [
                'type' => 'DATETIME',
            ]
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('id_pasien', 'pasiens', 'id', 'cascade', 'cascade', 'kunjungan_pasien');
        $this->forge->addForeignKey('id_poli', 'polis', 'id', 'cascade', 'cascade', 'kunjungan_poli');
        $this->forge->addForeignKey('id_rekmed', 'rekmeds', 'id', 'cascade', 'cascade', 'kunjungan_rekmed');
        $this->forge->createTable('kunjungans');

    }

    public function down()
    {
        $this->forge->dropTable('kunjungans');
    }
}