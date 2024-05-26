<?php

namespace App\Cells;

use App\Models\Kunjungan;
use CodeIgniter\View\Cells\Cell;

class PasienDataCell extends Cell
{
    protected $kunjunganModel;
    protected $pasienData = array();

    public function __construct()
    {
        $this->kunjunganModel = new Kunjungan();
    }

    public function mount($id): void
    {   
        if ($id != null) {
            $this->pasienData = $this->kunjunganModel->getKunjunganByPasienId($id);
        }
    }

    public function render(): string
    {
        return view('cells\pasien_data', ['pasienData' => $this->pasienData]);
    }
}