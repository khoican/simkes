<?php

namespace App\Cells;

use App\Models\GeneralConcent;
use App\Models\Kunjungan;
use App\Models\Pasien;
use CodeIgniter\View\Cells\Cell;

class PasienDataCell extends Cell
{
    protected $kunjunganModel;
    protected $generalConsentModel;
    protected $pasienModel;
    protected $kunjunganData = [];
    protected $pasienData = [];
    protected $generalConsent = [];

    public function __construct()
    {
        $this->pasienModel = new Pasien();
        $this->kunjunganModel = new Kunjungan();
        $this->generalConsentModel = new GeneralConcent();
    }

    public function mount($id): void
    {
        if ($id != null) {
            $this->pasienData = $this->pasienModel->getPasienById($id);
            $this->kunjunganData = $this->kunjunganModel->getKunjunganByPasienId($id);
            $this->generalConsent = $this->generalConsentModel->getGeneralConsentByPasienId($id);
        }
    }

    public function render(): string
    {
        return view('cells/pasien_data', [
            'pasienData' => $this->pasienData,
            'kunjunganData' => $this->kunjunganData,
            'generalConsent' => $this->generalConsent
        ]);
    }
}