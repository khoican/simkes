<?php

namespace App\Cells;

use App\Models\GeneralConcent;
use App\Models\Kunjungan;
use CodeIgniter\View\Cells\Cell;

class PasienDataCell extends Cell
{
    protected $kunjunganModel;
    protected $generalConsentModel;
    protected $pasienData = array();

    public function __construct()
    {
        $this->kunjunganModel = new Kunjungan();
        $this->generalConsentModel = new GeneralConcent();
    }

    public function mount($id): void
    {   
        if ($id != null) {
            $this->pasienData = $this->kunjunganModel->getKunjunganByPasienId($id);
            $this->generalConsentModel = $this->generalConsentModel->getGeneralConsentByPasienId($id);
        }
    }

    public function render(): string
    {
        return view('cells\pasien_data', ['pasienData' => $this->pasienData, 'generalConsent' => $this->generalConsentModel]);
    }
}