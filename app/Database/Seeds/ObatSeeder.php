<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class ObatSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'kode' => 'A01',
                'obat' => 'paracetamol',
                'jenis' => 'tablet',
                'bentuk' => 'kapsul',
                'stok' => 100,
                'harga' => 50000,
            ],
            [
                'kode' => 'A02',
                'obat' => 'bisolvon',
                'jenis' => 'tablet',
                'bentuk' => 'kapsul',
                'stok' => 100,
                'harga' => 100000,
            ],
            [
                'kode' => 'A03',
                'obat' => 'longatin',
                'jenis' => 'tablet',
                'bentuk' => 'kapsul',
                'stok' => 100,
                'harga' => 50000,
            ],
            [
                'kode' => 'A04',
                'obat' => 'profilas',
                'jenis' => 'tablet',
                'bentuk' => 'kapsul',
                'stok' => 100,
                'harga' => 100000,
            ],
            [
                'kode' => 'A05',
                'obat' => 'avil',
                'jenis' => 'tablet',
                'bentuk' => 'kapsul',
                'stok' => 100,
                'harga' => 50000,
            ],
        ];
        $this->db->table('obats')->insertBatch($data);
    }
}