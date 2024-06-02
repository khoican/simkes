<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class Seed extends Seeder
{
    public function run()
    {
        $this->call('UserSeeder');
        $this->call('AlamatSeeder');
        $this->call('PasienSeeder');
        $this->call('PoliSeeder');
        $this->call('DiagnosaSeeder');
        $this->call('TindakanSeeder');
        $this->call('ObatSeeder');
    }
}