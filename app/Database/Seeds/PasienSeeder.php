<?php

namespace App\Database\Seeds;

use App\Models\Alamat;
use CodeIgniter\Database\Seeder;
use Faker\Factory;

class PasienSeeder extends Seeder
{
    public function run()
    {
        $faker = Factory::create('id_ID'); 

        $alamatModel = new Alamat();
        $alamatIds = $alamatModel->findAll();
        $alamatIds = array_column($alamatIds, 'id');

        $data = [];
        for ($i = 0; $i < 10000; $i++) {
             $pss_dlm_keluarga = $faker->randomElement(['kepala keluarga', 'ibu', 'anak']);
            $pss_anak = null;
            if ($pss_dlm_keluarga == 'anak') {
                $pss_anak = $faker->numberBetween(1, 15);
            }
            $data[] = [
                'no_rekam_medis' => $faker->numerify('00000000-000#####'),
                'nik' => $faker->numerify('################'),
                'no_bpjs' => $faker->optional()->numerify('################'),
                'nama' => $faker->name,
                'jk' => $faker->randomElement(['l', 'p']),
                'tmp_lahir' => $faker->city,
                'tgl_lahir' => $faker->date(),
                'gol_darah' => $faker->optional()->randomElement(['a', 'b', 'ab', 'o']),
                'agama' => $faker->randomElement(['islam', 'kristen', 'katolik', 'hindu', 'buddha', 'konghucu']),
                'pendidikan' => $faker->randomElement(['tidak sekolah', 'sd', 'smp', 'sma', 'd1', 'd2', 'd3', 's1', 's2', 's3']),
                'pekerjaan' => $faker->jobTitle,
                'kpl_keluarga' => $faker->name,
                'pss_dlm_keluarga' => $pss_dlm_keluarga,
                'pss_anak' => $pss_anak,
                'telepon' => $faker->optional()->phoneNumber,
                'telepon2' => $faker->optional()->phoneNumber,
                'pembayaran' => $faker->randomElement(['umum', 'bpjs', 'lainnya']),
                'knjn_sehat' => $faker->boolean,
                'tkp' => $faker->randomElement(['rawat jalan', 'rawat inap', 'promotif']),
                'id_alamat' => $faker->randomElement($alamatIds),
            ];
        }

        $this->db->table('pasiens')->insertBatch($data);
    }
}