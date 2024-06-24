<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Rekmed extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'auto_increment' => true
            ],
            'alergi_makanan' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true
            ],
            'alergi_obat' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true
            ],
            'rwt_pykt_terdahulu' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true
            ],
            'rwt_pengobatan' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true
            ],
            'rwt_pykt_keluarga' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true
            ],
            'keluhan' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true
            ],
            'hbg_dgn_keluarga' => [
                'type' => 'ENUM',
                'constraint' => ['baik', 'tidak baik'],
                'default' => 'baik',
            ],
            'sts_psikologi' => [
                'type' => 'ENUM',
                'constraint' => ['tenang', 'lemas', 'takut', 'marah', 'sedih'],
                'default' => 'tenang',
            ],
            'keadaan' => [
                'type' => 'ENUM',
                'constraint' => ['baik', 'sedang', 'cukup'],
                'default' => 'baik',
            ],
            'kesadaran' => [
                'type' => 'ENUM',
                'constraint' => ['compos mentis', 'samnolen', 'stupor', 'coma'],
                'default' => 'compos mentis',
            ],
            'bb' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => true
            ],
            'tb' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => true
            ],
            'imt' => [
                'type' => 'FLOAT',
                'constraint' => 11,
                'null' => true
            ],
            'sistole' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => true
            ],
            'diastole' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => true
            ],
            'nadi' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => true
            ],
            'rr' => [
                'type' => 'VARCHAR',
                'constraint' => 225,
                'null' => true
            ],
            'suhu' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => true
            ],
            'skala_nyeri' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => true
            ],
            'frek_nyeri' => [
                'type' => 'ENUM',
                'constraint' => ['jarang', 'hilang timbul', 'terus menerus'],
                'null' => true
            ],
            'lama_nyeri' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true
            ],
            'menjalar' => [
                'type' => 'ENUM',
                'constraint' => ['ya', 'tidak'],
                'null' => true
            ],
            'menjalar_ket' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true
            ],
            'kualitas_nyeri' => [
                'type' => 'ENUM',
                'constraint' => ['tumpul', 'tajam', 'panas'],
                'null' => true
            ],
            'fakt_pemicu' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true
            ],
            'fakt_pengurang' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true
            ],
            'lokasi_nyeri' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true
            ],
            'status' => [
                'type' => 'ENUM',
                'constraint' => ['proses', 'selesai', 'tanpa obat'],
                'default' => 'proses',
            ],
            'id_pasien' => [
                'type' => 'INT',
            ],
            'id_poli' => [
                'type' => 'INT',
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true
            ],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('id_pasien', 'pasiens', 'id', 'CASCADE', 'CASCADE', 'pasien_rekmed');
        $this->forge->addForeignKey('id_poli', 'polis', 'id', 'CASCADE', 'CASCADE', 'poli_rekmed');
        $this->forge->createTable('rekmeds');
    }

    public function down()
    {
        $this->forge->dropTable('rekmeds');
    }
}