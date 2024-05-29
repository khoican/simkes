<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class TindakanSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'kode' => 'A01',
                'tindakan' => 'pengobatan 1',
            ],
            [
                'kode' => 'A02',
                'tindakan' => 'pengobatan 2',
            ],
            [
                'kode' => 'A03',
                'tindakan' => 'pengobatan 3',
            ],
        ];
        $this->db->table('tindakans')->insertBatch($data);
    }
}