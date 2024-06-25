<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Pasien extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'auto_increment' => true
            ],
            'no_rekam_medis' => [
                'type' => 'VARCHAR',
                'constraint' => 20
            ],
            'nik' => [
                'type' => 'VARCHAR',
                'constraint' => 16
            ],
            'no_bpjs' => [
                'type' => 'VARCHAR',
                'constraint' => 13,
                'null' => true
            ],
            'nama' => [
                'type' => 'VARCHAR',
                'constraint' => 255
            ],
            'jk' => [
                'type' => 'ENUM',
                'constraint' => ['l', 'p']
            ],
            'tmp_lahir' => [
                'type' => 'VARCHAR',
                'constraint' => 255
            ],
            'tgl_lahir' => [
                'type' => 'DATE'
            ],
            'gol_darah' => [
                'type' => 'ENUM',
                'constraint' => ['tidak tahu', 'a', 'b', 'ab', 'o'],
                'null' => true
            ],
            'agama' => [
                'type' => 'VARCHAR',
                'constraint' => 50
            ],
            'pendidikan' => [
                'type' => 'ENUM',
                'constraint' => ['tidak sekolah','sd', 'smp', 'sma', 'd1', 'd2', 'd3', 'd4', 's1', 's2', 's3']
            ],
            'pekerjaan' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true
            ],
            'kpl_keluarga' => [
                'type' => 'VARCHAR',
                'constraint' => 255
            ],
            'pss_dlm_keluarga' => [
                'type' => 'ENUM',
                'constraint' => ['kepala keluarga', 'ibu', 'anak']
            ],
            'pss_anak' => [
                'type' => 'INT',
                'constraint' => 3,
                'null' => true
            ],
            'telepon' => [
                'type' => 'VARCHAR',
                'constraint' => 15,
                'null' => true
            ],
            'telepon2' => [
                'type' => 'VARCHAR',
                'constraint' => 15,
                'null' => true
            ],
            'pembayaran' => [
                'type' => 'ENUM',
                'constraint' => ['umum', 'jkn', 'lainnya']
            ],
            'knjn_sehat' => [
                'type' => 'BOOLEAN',
                'default' => false,
                'null' => true
            ],
            'tkp' => [
                'type' => 'ENUM',
                'constraint' => ['rawat jalan', 'rawat inap', 'promotif'],
                'default' => 'rawat jalan'
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true
            ],
            'deleted_at' => [
                'type' => 'DATETIME',
                'null' => true
            ],
            'id_alamat' => [
                'type' => 'INT',
            ]
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('id_alamat', 'alamats', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('pasiens');
    }

    public function down()
    {
        $this->forge->dropTable('pasiens');
    }
}