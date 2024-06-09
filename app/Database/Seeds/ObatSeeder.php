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
                'obat' => 'obat 1',
                'jenis' => 'tablet',
                'bentuk' => 'ada',
                'stok' => 100,
                'harga' => 50000,
            ],
            [
                'kode' => 'A02',
                'obat' => 'obat 2',
                'jenis' => 'tablet',
                'bentuk' => 'ada',
                'stok' => 100,
                'harga' => 100000,
            ],
            [
                'kode' => 'A03',
                'obat' => 'obat 3',
                'jenis' => 'tablet',
                'bentuk' => 'ada',
                'stok' => 100,
                'harga' => 50000,
            ],
            [
                'kode' => 'A04',
                'obat' => 'obat 4',
                'jenis' => 'tablet',
                'bentuk' => 'ada',
                'stok' => 100,
                'harga' => 100000,
            ],
            [
                'kode' => 'A05',
                'obat' => 'obat 5',
                'jenis' => 'tablet',
                'bentuk' => 'ada',
                'stok' => 100,
                'harga' => 50000,
            ],
        ];
        $this->db->table('obats')->insertBatch($data);
    }
}