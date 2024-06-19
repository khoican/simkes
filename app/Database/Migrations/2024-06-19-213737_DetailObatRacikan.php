<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class DetailObatRacikan extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'auto_increment' => true
            ],
            'id_obat_racikan' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => true
            ],
            'id_obat' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => true
            ],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('id_obat_racikan', 'obat_racikans', 'id', 'cascade', 'cascade', 'detail_racikan');
        $this->forge->addForeignKey('id_obat', 'obats', 'id', 'cascade', 'cascade', 'obat_racikan');
        $this->forge->createTable('detail_obat_racikans');
    }

    public function down()
    {
        $this->forge->dropTable('detail_obat_racikans');
    }
}