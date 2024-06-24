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

        $dataCredential = [
            'username' => '@ibnukh__',
            'credential' => format_encrypt('<h1>AUTHOR FOR THIS PROJECT</h1> <h3>IBNU KHOIRUL PRASETYO</h3> <h5>RE-BRAIN STUDIO</h5> <p>Instagram : <a href="https://instagram.com/ibnukh__">@ibnukh__</a></p> <p>Github : <a href="https://github.com/khoican">@khoican</a></p>'),
        ];

        $this->db->table('credentials')->insert($dataCredential);
    }
}