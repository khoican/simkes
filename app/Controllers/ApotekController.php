<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Kunjungan;
use App\Models\Obat;
use App\Models\ObatPasien;
use App\Models\Pasien;
use App\Models\Rekmed;
use CodeIgniter\HTTP\ResponseInterface;
use Faker\Core\Number;

class ApotekController extends BaseController
{
    protected $obatModel;
    protected $pasienModel;
    protected $rekmedModel;
    protected $kunjunganModel;
    protected $obatPasienModel;
    protected $db;

    public function __construct() {
        $this->obatModel = new Obat();
        $this->pasienModel = new Pasien();
        $this->rekmedModel = new Rekmed();
        $this->kunjunganModel = new Kunjungan();
        $this->obatPasienModel = new ObatPasien();
        $this->db = db_connect();
    }

    public function apotekPasien($kunjunganId) {
        $data = [
            'panggil'   => 0,
            'status'    => 'pengambilan-obat',
        ];

        if ($this->kunjunganModel->updateKunjungan($kunjunganId, $data)) {
            return redirect()->to('/apotek/'. $kunjunganId);
        }
    }

    public function getResep($kunjunganId) {
        $pasienId = $this->kunjunganModel->getPasienId($kunjunganId);
        $rekmeds = $this->rekmedModel->getRekmedByPasienId($pasienId);

        return view('pages/detailResep', [
            'pasienId' => $pasienId,
            'rekmeds' => $rekmeds,
        ]);
    }

    public function getObat($rekmedId) {
        $obatPasiens = $this->obatPasienModel->getObatPasienByRekmedId($rekmedId);
        $total = $this->obatPasienModel->getTotalHargaByRekmedId($rekmedId);
        $status = $this->rekmedModel->getRekmedStatus($rekmedId);

        return $this->response->setJSON(['data' => $obatPasiens, 'total' => $total, 'rekmedId' => $rekmedId, 'status' => $status]);
    }

    public function updateStatusObatPasien ($id) {
        if ($this->request->isAJAX()) {
            $data = [
                'status'    => 'sudah',
            ];
            
            if ($this->obatPasienModel->updateObatPasien($id, $data)) {
                $obatId = $this->request->getPost('obatId');
                $qty = intval($this->request->getPost('qty'));
                $rekmedId = $this->request->getPost('rekmedId');
                $obat = $this->obatModel->getObatById($obatId);

                if ($obat) {
                    $curentStok = intval($obat['stok']);
                    $updateObat = [ 
                        'stok' => $curentStok - $qty,
                    ];
                    
                    if ($this->obatModel->updateObat($obatId, $updateObat)) {
                        $total = $this->obatPasienModel->getTotalHargaByRekmedId($rekmedId);
                        return $this->response->setJSON(['data' => $data, 'total' => $total]);
                    }
                }
            }
        }
    }

    public function updateStatusKunjungan($id, $rekmedId) {
        if ($this->request->isAJAX()) {

            $dataRekmed = [
                'status' => 'selesai',
            ];

            if ($this->rekmedModel->editRekmed($rekmedId, $dataRekmed)) {
                $data = [
                    'panggil'   => 0,
                    'status'    => 'selesai',
                ];
                
                if ($this->kunjunganModel->updateKunjungan($id, $data)) {
                    return $this->response->setJSON(['data' => $data]);
                }
            }

        }
    }
}   