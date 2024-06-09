<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class DiagnosaSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'kode' => 'A01',
                'diagnosa' => 'diagnosa 1',
            ],
            [
                'kode' => 'A02',
                'diagnosa' => 'diagnosa 2',
            ],
            [
                'kode' => 'A03',
                'diagnosa' => 'diagnosa 3',
            ],
            [
                'kode' => 'A04',
                'diagnosa' => 'diagnosa 4',
            ],
            [
                'kode' => 'A05',
                'diagnosa' => 'diagnosa 5',
            ],
        ];
        $this->db->table('diagnosas')->insertBatch($data);
    }
}