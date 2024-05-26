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
                'obat' => 'Paracetamol 500mg',
                'jenis' => 'Tablet',
                'bentuk' => 'Kapsul',
                'stok' => 100,
                'harga' => 50000,
            ],
            [
                'kode' => 'A02',
                'obat' => 'Paracetamol 1000mg',
                'jenis' => 'Tablet',
                'bentuk' => 'Kapsul',
                'stok' => 100,
                'harga' => 100000,
            ],
            [
                'kode' => 'A03',
                'obat' => 'Milanta 500mg',
                'jenis' => 'Tablet',
                'bentuk' => 'Kapsul',
                'stok' => 100,
                'harga' => 50000,
            ],
            [
                'kode' => 'A04',
                'obat' => 'Milanta 1000mg',
                'jenis' => 'Tablet',
                'bentuk' => 'Kapsul',
                'stok' => 100,
                'harga' => 100000,
            ],
            [
                'kode' => 'A05',
                'obat' => 'Asam Mefenamat 500mg',
                'jenis' => 'Tablet',
                'bentuk' => 'Kapsul',
                'stok' => 100,
                'harga' => 50000,
            ],
        ];
        $this->db->table('obats')->insertBatch($data);
    }
}