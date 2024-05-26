<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class PoliSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'nama' => 'Poli Umum',
                'kode' => 'A'
            ],
            [
                'nama' => 'Poli KIA',
                'kode' => 'B'
            ],
            [
                'nama' => 'Poli Gigi',
                'kode' => 'C'
            ],
        ];

        foreach ($data as $row) {
            $this->db->table('polis')->insert($row);
        }
    }
}