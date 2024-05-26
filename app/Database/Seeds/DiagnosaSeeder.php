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
                'diagnosa' => 'Diabetes',
            ],
            [
                'kode' => 'A02',
                'diagnosa' => 'Hipertensi',
            ],
            [
                'kode' => 'A03',
                'diagnosa' => 'Asma',
            ],
            [
                'kode' => 'A04',
                'diagnosa' => 'Covid-19',
            ],
            [
                'kode' => 'A05',
                'diagnosa' => 'Diare',
            ],
        ];
        $this->db->table('diagnosas')->insertBatch($data);
    }
}