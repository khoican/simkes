<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\DetailObatRacikan;
use App\Models\DiagnosaPasien;
use App\Models\Kunjungan;
use App\Models\Obat;
use App\Models\ObatPasien;
use App\Models\ObatRacikan;
use App\Models\Pasien;
use App\Models\QuantityObat;
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
    protected $quantityObatModel;
    protected $diagnosaPasienModel;
    protected $obatRacikanModel;
    protected $detailObatRacikanModel;
    protected $db;

    public function __construct() {
        $this->obatModel = new Obat();
        $this->pasienModel = new Pasien();
        $this->rekmedModel = new Rekmed();
        $this->kunjunganModel = new Kunjungan();
        $this->obatPasienModel = new ObatPasien();
        $this->quantityObatModel = new QuantityObat();
        $this->diagnosaPasienModel = new DiagnosaPasien();
        $this->obatRacikanModel = new ObatRacikan();
        $this->detailObatRacikanModel = new DetailObatRacikan();
        $this->db = db_connect();
    }

    public function index() {
        $data = [
            'id' => null
        ];
        return view('pages/rekob', $data);
    }

    public function apotekPasien($kunjunganId) {
        $pasienId = $this->kunjunganModel->getKunjunganById($kunjunganId);
        $data = [
            'panggil'   => 0,
            'status'    => 'pengambilan-obat',
        ];

        if ($this->kunjunganModel->updateKunjungan($kunjunganId, $data)) {
            return redirect()->to('/rekob/'. $pasienId['id_pasien']);
        }
    }

    public function getResepByRekmedId($pasienId, $rekmedId) {
        $kunjunganId = $this->kunjunganModel->getKunjunganByPasienId($pasienId);
        $diagnosaPasiens = $this->diagnosaPasienModel->getDiagnosaByRekmedId($rekmedId);
        $obatPasiens = $this->obatPasienModel->getObatPasienByRekmedId($rekmedId);
        $obats = $this->obatModel->getAllObat();
        $obatRacikan = $this->obatRacikanModel->getObatRacikan($rekmedId);
        $totalObatPasien = $this->obatPasienModel->getTotalHargaByRekmedIdNonFormating($rekmedId);
        $totalObatRacikan = $this->obatRacikanModel->getTotalHargaObatRacikan($rekmedId);
        $rekmed = $this->rekmedModel->getRekmedById($rekmedId);

        $total = intval($totalObatPasien) + intval($totalObatRacikan);
        $total = format_numerik($total);

        return view('pages/detailResepByRekmed', [
            'kunjunganId' => $kunjunganId,
            'pasienId' => $pasienId,
            'rekmedId' => $rekmedId,
            'diagnosaPasiens' => $diagnosaPasiens,
            'obatPasiens' => $obatPasiens,
            'obats' => $obats,
            'total' => $total,
            'rekmed' => $rekmed,
            'obatRacikans' => $obatRacikan
        ]);
    }

    public function getResep($pasienId) {
        $kunjunganId = $this->kunjunganModel->getKunjunganByPasienId($pasienId);
        $rekmeds = $this->rekmedModel->getRekmedByPasienId($pasienId);
        return view('pages/detailResep', [
            'pasienId' => $pasienId,
            'rekmeds' => $rekmeds,
            'kunjunganId' => $kunjunganId
        ]);
    }

    public function getObat($rekmedId) {
        $obatPasiens = $this->obatPasienModel->getObatPasienByRekmedId($rekmedId);
        $total = $this->obatPasienModel->getTotalHargaByRekmedId($rekmedId);
        $status = $this->rekmedModel->getRekmedStatus($rekmedId);

        return $this->response->setJSON(['data' => $obatPasiens, 'total' => $total, 'rekmedId' => $rekmedId, 'status' => $status]);
    }

    public function addObatPasien()
    {
        if ($this->request->isAJAX()) {
            $idObat = $this->request->getPost('id_obat');
            $idRekmed = $this->request->getPost('id_rekmed');
            $data = [
                'id_pasien' => $this->request->getPost('id_pasien'),
                'id_rekmed' => $idRekmed,
                'id_obat' => $idObat,
                'signa' => $this->request->getPost('signa'),
                'ket' => $this->request->getPost('ket'),
                'jml_resep' => $this->request->getPost('jml_resep'),
                'jml_diberikan' => $this->request->getPost('jml_diberikan'),
                'status' => 'sudah',
            ];

            $idObatPasien = $this->obatPasienModel->postObatPasien($data);
            
            if ($idObatPasien) {
                $obat = $this->obatModel->getObatById($idObat);

                if ($obat) {
                    $currentStok = intval($obat['stok']);
                    $decrementStok = intval($this->request->getPost('jml_diberikan'));

                    $updateStok = [
                        'stok' => $currentStok - $decrementStok, 
                    ];

                    if($this->obatModel->updateObat($idObat, $updateStok)) {
                        $updateQuantity = [
                            'id_obat' => $idObat,
                            'keluar' => intval($this->request->getPost('jml_diberikan'))
                        ];
                        $this->quantityObatModel->postQuantityObat($updateQuantity);

                        $newData = $this->obatPasienModel->getObatPasienById($idObatPasien);
                        $totalObatPasien = $this->obatPasienModel->getTotalHargaByRekmedIdNonFormating($idRekmed);
                        $totalObatRacikan = $this->obatRacikanModel->getTotalHargaObatRacikan($idRekmed);

                        $total = intval($totalObatPasien) + intval($totalObatRacikan);
                        $total = format_numerik($total);

                        return $this->response->setJSON(['data' => $newData, 'total' => $total]);
                    }

                } else {
                    return $this->response->setJSON(['error' => 'Obat tidak ditemukan']);
                }
            } else {
                return $this->response->setJSON(['error' => 'Gagal menyimpan data obat pasien']);
            }
        }
    }

    public function addObatRacikan() {
        if($this->request->isAJAX()) {
            $idObats = $this->request->getPost('id_obat');
            $idRekmed = $this->request->getPost('id_rekmed');

            $data = [
                'id_pasien' => $this->request->getPost('id_pasien'),
                'id_rekmed' => $idRekmed,
                'ket' => $this->request->getPost('ket'),
                'signa' => $this->request->getPost('signa'),
                'satuan' => $this->request->getPost('satuan'),
                'ket' => $this->request->getPost('ket'),
                'jml_resep' => $this->request->getPost('jml_resep'),
                'jml_diberikan' => $this->request->getPost('jml_resep'),
                'status' =>'sudah',
            ];
            $obatRacikanId = $this->obatRacikanModel->postObatRacikan($data);

            if($obatRacikanId) {
                $success = true;
                $responses = [];

                foreach($idObats as $index => $idObat) {
                    $dataRacikan = [
                        'id_obat_racikan' => $obatRacikanId,
                        'id_obat' => $idObat
                    ];

                    $detailObat = $this->detailObatRacikanModel->postDetailObatRacikan($dataRacikan);
                    
                    $obat = $this->obatModel->getObatById($idObat);
                    $curentStok = intval($obat['stok']);
                    $updateObat = [ 
                        'stok' => $curentStok - intval($this->request->getPost('jml_resep')),
                    ];

                    if ($this->obatModel->updateObat($idObat, $updateObat)) {
                        $updateQuantity = [
                            'id_obat' => $idObat,
                            'keluar' => intval($this->request->getPost('jml_resep'))
                        ];
                        $this->quantityObatModel->postQuantityObat($updateQuantity);
                    }
                    
                    if(!$detailObat) {
                        $success = false;
                        $responses = [
                            'status' => false,
                            'message' => 'Gagal menambahkan detail obat racikan',
                            'data' => $dataRacikan
                        ];
                    }
                }

                if ($success) {
                    $totalObatPasien = $this->obatPasienModel->getTotalHargaByRekmedIdNonFormating($idRekmed);
                    $totalObatRacikan = $this->obatRacikanModel->getTotalHargaObatRacikan($idRekmed);

                    $total = intval($totalObatPasien) + intval($totalObatRacikan);
                    $total = format_numerik($total);

                    return $this->response->setJSON([
                        'status' => true,
                        'message' => 'Berhasil menambahkan detail obat racikan',
                        'id' => $obatRacikanId,
                        'data' => $data,
                        'total' => $total
                    ]);
                } else {
                    return $this->response->setJSON([
                        'status' => false,
                        'message' => 'Gagal menambahkan obat racikan lebih dari 1 obat',
                        'data' => $responses,
                    ]);
                }
            } else {
                return $this->response->setJSON([
                    'status' => false,
                    'message' => 'Gagal menambahkan obat racikan',
                ]);
            }

        };
    }

    public function updateStatusObatPasien ($id) {
        if ($this->request->isAJAX()) {
            $data = [
                'jml_diberikan' => intval($this->request->getPost('jml_diberikan')),
                'status'    => 'sudah',
            ];
            
            if ($this->obatPasienModel->updateObatPasien($id, $data)) {
                $obatId = $this->request->getPost('obatId');
                $rekmedId = $this->request->getPost('rekmedId');
                $obat = $this->obatModel->getObatById($obatId);
                if ($obat) {
                    $curentStok = intval($obat['stok']);
                    $updateObat = [ 
                        'stok' => $curentStok - intval($this->request->getPost('jml_diberikan')),
                    ];
                    
                    if ($this->obatModel->updateObat($obatId, $updateObat)) {
                        $updateQuantity = [
                            'id_obat' => $obatId,
                            'keluar' => intval($this->request->getPost('jml_diberikan'))
                        ];
                        $this->quantityObatModel->postQuantityObat($updateQuantity);

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

    public function deleteObatPasien($id) {
        if ($this->request->isAJAX()) {
            if ($this->obatPasienModel->deleteObatPasienById($id)) {
                $idRekmed = $this->request->getPost('id_rekmed');

                $totalObatPasien = $this->obatPasienModel->getTotalHargaByRekmedIdNonFormating($idRekmed);
                $totalObatRacikan = $this->obatRacikanModel->getTotalHargaObatRacikan($idRekmed);

                $total = intval($totalObatPasien) + intval($totalObatRacikan);
                $total = format_numerik($total);

                $jml = $this->request->getPost('jml');
                if ($jml != 0) {
                    $idObat = $this->request->getPost('id_obat');
                    $obat = $this->obatModel->getObatById($idObat);

                    $curentStok = intval($obat['stok']);
                    $updateObat = [ 
                        'stok' => $curentStok + intval($jml),
                    ];
                    
                    $this->obatModel->updateObat($idObat, $updateObat);
    
                    $idQuantityObat = $this->quantityObatModel->getQuantityObatByObatId($idObat, $jml);
                    if ($idQuantityObat) {
                        $this->quantityObatModel->deleteQuantityObat($idQuantityObat['id']);
    
                        return $this->response->setJSON([
                            'status' => true,
                            'message' => 'Berhasil menghapus detail obat',
                            'total' => $total
                        ]);
                    } else {
                        return $this->response->setJSON([
                            'status' => false,
                            'message' => 'Gagal menghapus detail obat',
                        ]);
                    }
                }

                return $this->response->setJSON([
                            'status' => true,
                            'message' => 'Berhasil menghapus detail obat',
                            'total' => $total
                        ]);
            } else {
                return $this->response->setJSON([
                    'status' => false,
                    'message' => 'Gagal menghapus detail obat',
                ]);
            }
        }
    }

    public function deleteObatRacikan($id) {
        if ($this->request->isAJAX()) {
            $this->db->transStart();
            
            try {
                $obatRacikan = $this->obatRacikanModel->getObatRacikanById($id);
                $detailObatRacikan = $this->detailObatRacikanModel->getDetailObatRacikan($id);
                $jml = $obatRacikan['jml_diberikan'];
                $idRekmed = $obatRacikan['id_rekmed'];

                foreach ($detailObatRacikan as $item) {
                    $itemId = $item['id'];
                    $obatId = $item['id_obat'];

                    if ($this->detailObatRacikanModel->deleteDetailObatRacikan($itemId)) {
                        $obat = $this->obatModel->getObatById($obatId);
                        $currentStok = intval($obat['stok']);
                        $updateObat = ['stok' => $currentStok + intval($jml)];

                        $this->obatModel->updateObat($obatId, $updateObat);

                        $idQuantityObat = $this->quantityObatModel->getQuantityObatByObatId($obatId, $jml);
                        if ($idQuantityObat) {
                            $this->quantityObatModel->deleteQuantityObat($idQuantityObat['id']);
                        }
                    }
                }

                $totalObatPasien = $this->obatPasienModel->getTotalHargaByRekmedIdNonFormating($idRekmed);
                $totalObatRacikan = $this->obatRacikanModel->getTotalHargaObatRacikan($idRekmed);
                $total = intval($totalObatPasien) + intval($totalObatRacikan);
                $totalFormatted = format_numerik($total);

                if ($this->obatRacikanModel->deleteObatRacikan($id)) {
                    $this->db->transComplete();

                    return $this->response->setJSON([
                        'status' => true,
                        'message' => 'Berhasil menghapus obat racikan',
                        'id' => $id,
                        'total' => $totalFormatted
                    ]);
                } else {
                    $this->db->transRollback();

                    return $this->response->setJSON([
                        'status' => false,
                        'message' => 'Gagal menghapus obat racikan',
                        'total' => $totalFormatted
                    ]);
                }
            } catch (\Exception $e) {
                $this->db->transRollback();

                return $this->response->setJSON([
                    'status' => false,
                    'message' => 'Terjadi kesalahan: ' . $e->getMessage()
                ]);
            }
        }
    }

}   