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
                'tindakan' => 'Pengobatan',
            ],
            [
                'kode' => 'A02',
                'tindakan' => 'Pengobatan Khusus',
            ],
            [
                'kode' => 'A03',
                'tindakan' => 'Pengobatan Khusus 2',
            ],
        ];
        $this->db->table('tindakans')->insertBatch($data);
    }
}