<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\DiagnosaPasien;
use App\Models\Kunjungan;
use App\Models\Pasien;
use App\Models\QuantityObat;
use App\Models\TindakanPasien;
use CodeIgniter\HTTP\ResponseInterface;

class DashboardController extends BaseController
{
    protected $kunjunganModel;
    protected $diagnosaPasienModel;
    protected $tindakanPasienModel;
    protected $pasienModel;
    protected $quantityObatModel;

    public function __construct() {
        $this->kunjunganModel = new Kunjungan();
        $this->diagnosaPasienModel = new DiagnosaPasien();
        $this->tindakanPasienModel = new TindakanPasien();
        $this->pasienModel = new Pasien();
        $this->quantityObatModel = new QuantityObat();
    }
    public function index()
    {
        $mostDiagnosa = $this->diagnosaPasienModel->getMostDiagnosaPasien();
        $mostTindakan = $this->tindakanPasienModel->getMostTindakanPasien();
        $countKunjungan = $this->kunjunganModel->getCountKunjunganToday();
        $countPasien = $this->pasienModel->getCountNewPasien();
        $countObatMasuk = '';
        if ($this->quantityObatModel->getCountQuantityObatMasuk() != null) {
            $countObatMasuk = $this->quantityObatModel->getCountQuantityObatMasuk();
        } else {
            $countObatMasuk = 0;
        }
        $countObatKeluar = '';
        if ($this->quantityObatModel->getCountQuantityObatKeluar() != null) {
            $countObatKeluar = $this->quantityObatModel->getCountQuantityObatKeluar();
        } else {
            $countObatKeluar = 0;
        }
        
        return view('pages/dashboard/main', ['countKunjungan' => $countKunjungan, 'mostDiagnosa' => $mostDiagnosa, 'mostTindakan' => $mostTindakan, 'countPasien' => $countPasien, 'countObatMasuk' => $countObatMasuk, 'countObatKeluar' => $countObatKeluar]);
    }
    
    public function getTotalKunjungan($year, $month) {
        $kunjungan = $this->kunjunganModel->getTotalKunjunganPerMonth($year, $month);
        
        return $this->response->setJSON($kunjungan);
    }
}