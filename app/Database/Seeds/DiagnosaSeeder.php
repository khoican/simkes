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
                'diagnosa' => 'diabetes',
            ],
            [
                'kode' => 'A02',
                'diagnosa' => 'hipertensi',
            ],
            [
                'kode' => 'A03',
                'diagnosa' => 'asma',
            ],
            [
                'kode' => 'A04',
                'diagnosa' => 'covid-19',
            ],
            [
                'kode' => 'A05',
                'diagnosa' => 'diare',
            ],
        ];
        $this->db->table('diagnosas')->insertBatch($data);
    }
}