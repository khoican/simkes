<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use Faker\Factory;

class AlamatSeeder extends Seeder
{
    public function run()
    {
        $faker = Factory::create('id_ID');

        $data = [];
        for ($i = 1; $i <= 10; $i++) {
            $data[] = [
                'alamat' => $faker->address,
                'rt' => $faker->numerify('#'),
                'rw' => $faker->numerify('#'),
                'kelurahan' => $faker->streetName,
                'kecamatan' => $faker->city,
                'kota' => $faker->city,
            ];
        }

        $this->db->table('alamats')->insertBatch($data);
    }
}