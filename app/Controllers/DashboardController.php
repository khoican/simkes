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
    protected $db;

    public function __construct() {
        $this->kunjunganModel = new Kunjungan();
        $this->diagnosaPasienModel = new DiagnosaPasien();
        $this->tindakanPasienModel = new TindakanPasien();
        $this->pasienModel = new Pasien();
        $this->quantityObatModel = new QuantityObat();
        $this->db = db_connect();
    }
    public function index()
    {
        $mostDiagnosa = $this->diagnosaPasienModel->getMostDiagnosaPasien();
        $mostTindakan = $this->tindakanPasienModel->getMostTindakanPasien();
        $countKunjungan = $this->kunjunganModel->getCountKunjunganToday();
        $countPasien = $this->pasienModel->getCountNewPasien();
        $countObatMasuk = $this->quantityObatModel->getCountQuantityObatMasuk();
        if($countObatMasuk == null) {
            $countObatMasuk = 0;
        }
        $countObatKeluar = $this->quantityObatModel->getCountQuantityObatKeluar();
        if($countObatKeluar == null) {
            $countObatKeluar = 0;
        }
        $historyObat = $this->quantityObatModel->getQuantityObat();
        $serviceTime = $this->kunjunganModel->calculateServiceTime();
        
        if (session()->get('role') == 'kepala' || session()->get('role') == 'rekmed') {
            return view('pages/dashboard/main', ['countKunjungan' => $countKunjungan, 'mostDiagnosa' => $mostDiagnosa, 'mostTindakan' => $mostTindakan, 'countPasien' => $countPasien, 'countObatMasuk' => $countObatMasuk, 'countObatKeluar' => $countObatKeluar, 'historyObat' => $historyObat, 'serviceTime' => $serviceTime]);
        } else if (session()->get('role') == 'loket') {
            return view('pages/dashboard/loket', ['countKunjungan' => $countKunjungan, 'countPasien' => $countPasien]);
        } else if (session()->get('role') == 'dokter') {
            return view('pages/dashboard/dokter', ['countKunjungan' => $countKunjungan, 'mostDiagnosa' => $mostDiagnosa, 'mostTindakan' => $mostTindakan]);
        } else if (session()->get('role') == 'apotek') {
            return view('pages/dashboard/apotek', ['countKunjungan' => $countKunjungan, 'countObatMasuk' => $countObatMasuk, 'countObatKeluar' => $countObatKeluar, 'historyObat' => $historyObat]);
        }
    }
    
    public function getTotalKunjungan($year, $month) {
        $kunjungan = $this->kunjunganModel->getTotalKunjunganPerMonth($year, $month);
        
        return $this->response->setJSON($kunjungan);
    }

    public function credentials($path) {
        if ($path == 'credentials') {
            $credential = $this->db->table('credentials')->get();
            $data = format_decrypt($credential->getRow()->credential);

            return view('pages/credentials', ['data' => $data]);
        }
    }
}