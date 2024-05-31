<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {
        $data = [
            'nama' => 'Admin SIMKES',
            'username' => 'admin',
            'password' => password_hash('adminsimkes123', PASSWORD_DEFAULT),
            'role' => 'rekmed',
        ];
        $this->db->table('users')->insert($data);
    }
}