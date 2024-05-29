<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class PoliSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'nama' => 'umum',
                'kode' => 'A'
            ],
            [
                'nama' => 'kia',
                'kode' => 'B'
            ],
            [
                'nama' => 'gigi',
                'kode' => 'C'
            ],
        ];

        foreach ($data as $row) {
            $this->db->table('polis')->insert($row);
        }
    }
}