<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Diagnosa;
use App\Models\DiagnosaPasien;
use App\Models\GeneralConcent;
use App\Models\Kunjungan;
use App\Models\Obat;
use App\Models\ObatPasien;
use App\Models\Rekmed;
use App\Models\Tindakan;
use App\Models\TindakanPasien;
use CodeIgniter\HTTP\ResponseInterface;

class RekmedController extends BaseController
{
    protected $rekmedModel;
    protected $kunjunganModel;
    protected $obatModel;
    protected $diagnosaModel;
    protected $tindakanModel;
    protected $diagnosaPasienModel;
    protected $tindakanPasienModel;
    protected $obatPasienModel;
    protected $generalConsentModel;
    protected $db;

    public function __construct() 
    {
        $this->rekmedModel = new Rekmed();
        $this->kunjunganModel = new Kunjungan();
        $this->obatModel = new Obat();
        $this->diagnosaModel = new Diagnosa();
        $this->tindakanModel = new Tindakan();
        $this->diagnosaPasienModel = new DiagnosaPasien();
        $this->tindakanPasienModel = new TindakanPasien();
        $this->obatPasienModel = new ObatPasien();
        $this->generalConsentModel = new GeneralConcent();
        $this->db = db_connect();
    }

    public function periksaPasien($kunjunganId) {
        $data = [
            'panggil'         => 0,
            'status'          => 'pemeriksaan',
        ];
        if ($this->kunjunganModel->updateKunjungan($kunjunganId, $data)) {
            return redirect()->to('/pemeriksaan/'. $kunjunganId);
        }
    }

    public function getByUser ($kunjunganId)
    {   
        $pasienId = $this->kunjunganModel->getPasienId($kunjunganId);
        $rekmedPasiens = $this->rekmedModel->getRekmedByPasienId($pasienId);
        $generalConsent = $this->generalConsentModel->getGeneralConsentByPasienId($pasienId);

        $diagnosaPasiens = [];
        foreach ($rekmedPasiens as $rekmedPasien) {
            $diagnosaPasiens[$rekmedPasien['id']] = $this->diagnosaPasienModel->getDiagnosaByRekmedId($rekmedPasien['id']);
        }

        return view('pages/rekmed', ['pasienId' => $pasienId, 'kunjunganId' => $kunjunganId, 'rekmedPasiens' => $rekmedPasiens, 'diagnosaPasiens' => $diagnosaPasiens, 'generalConsent' => $generalConsent]);
    }

    public function show($id) {
        $method = 'show';
        $rekmedPasien = $this->rekmedModel->getRekmedById($id);
        $diagnosas = $this->diagnosaModel->getAllDiagnosa();
        $tindakans = $this->tindakanModel->getAllTindakan();
        $obats = $this->obatModel->getAllObat();
        $diagnosaPasiens = $this->diagnosaPasienModel->getDiagnosaByRekmedId($id);
        $tindakanPasiens = $this->tindakanPasienModel->getTindakanByRekmedId($id);
        $obatPasiens = $this->obatPasienModel->getObatPasienByRekmedId($id);
        $kunjunganId = $this->kunjunganModel->getKunjunganByRekmedId($id);

        return view('pages/rekmedForm', ['kunjunganId' => $kunjunganId, 'method' => $method, 'kunjungan' => $rekmedPasien, 'diagnosas' => $diagnosas, 'tindakans' => $tindakans, 'obats' => $obats, 'diagnosaPasiens' => $diagnosaPasiens, 'tindakanPasiens' => $tindakanPasiens, 'obatPasiens' => $obatPasiens]);
    }

    public function create($kunjunganId)
    {
        $method = 'post';
        $kunjungan = $this->kunjunganModel->getKunjunganById($kunjunganId);
        $diagnosas = $this->diagnosaModel->getAllDiagnosa();
        $tindakans = $this->tindakanModel->getAllTindakan();
        $obats = $this->obatModel->getAllObat();
        return view('pages/rekmedForm', ['kunjunganId' => ['id' => $kunjunganId], 'method' => $method, 'kunjungan' => $kunjungan, 'diagnosas' => $diagnosas, 'tindakans' => $tindakans, 'obats' => $obats]);
    }

    public function store($id)
    {
        $this->db->transStart();
        $kunjunganId = $this->request->getPost('id_kunjungan');

        $dataRekmed = [
            'alergi_makanan'        => $this->request->getPost('alergi_makanan'),
            'alergi_obat'           => $this->request->getPost('alergi_obat'),
            'rwt_pykt_terdahulu'    => $this->request->getPost('rwt_pykt_terdahulu'),
            'rwt_pengobatan'        => $this->request->getPost('rwt_pengobatan'),
            'rwt_pykt_keluarga'     => $this->request->getPost('rwt_pykt_keluarga'),
            'keluhan'               => $this->request->getPost('keluhan'),
            'hbg_dgn_keluarga'      => $this->request->getPost('hbg_dgn_keluarga'),
            'sts_psikologi'         => $this->request->getPost('sts_psikologi'),
            'keadaan'               => $this->request->getPost('keadaan'),
            'kesadaran'             => $this->request->getPost('kesadaran'),
            'id_pasien'             => intval($id),
            'id_poli'               => intval($this->request->getPost('id_poli')),
        ];
        
        $idRekmed = $this->rekmedModel->postRekmed($dataRekmed);
        
        $idDiagnosaUtama = $this->request->getPost('diagnosa-utama');
        $idDiagnosaSekunder = $this->request->getPost('diagnosa-sekunder');
        if ($idDiagnosaUtama != null) {
            $dataDiagnosa = [
                'id_rekmed'            => $idRekmed,
                'id_pasien'            => intval($id),
                'id_diagnosa'          => intval($idDiagnosaUtama),
                'status'               => 'utama'
            ];
            $this->diagnosaPasienModel->postDiagnosaPasien($dataDiagnosa);
        }

        if ($idDiagnosaSekunder != null) {
            $dataDiagnosa = [
                'id_rekmed'            => $idRekmed,
                'id_pasien'            => intval($id),
                'id_diagnosa'          => intval($idDiagnosaSekunder),
                'status'               => 'sekunder'
            ];
            $this->diagnosaPasienModel->postDiagnosaPasien($dataDiagnosa);
        }
        
        $idTindakans = $this->request->getPost('tindakan');
        foreach ($idTindakans as $key => $value) {
            $dataTindakan = [
                'id_rekmed'            => $idRekmed,
                'id_pasien'            => intval($id),
                'id_tindakan'             => intval($value),
            ];
            
            $this->tindakanPasienModel->postTindakanPasien($dataTindakan);
        }
        
        $idObats = $this->request->getVar('obat');
        $resep = $this->request->getVar('resep');
        $resep2 = $this->request->getVar('resep2');

        $status = 'selesai';
        if ($idObats[0] != null && $resep[0] != null && $resep2[0] != null) {
            foreach ($idObats as $index => $idObat) {
                if (isset($resep[$index]) && isset($resep2[$index])) {
                    $dataResep = [
                        'id_rekmed' => $idRekmed,
                        'id_pasien' => intval($id),
                        'id_obat'   => intval($idObat),
                        'note'      => $resep[$index] . ' x ' . $resep2[$index],
                    ];
                    $result = $this->obatPasienModel->postObatPasien($dataResep);
                    $status = 'antrian-obat';

                    
                    if (!$result) {
                        log_message('error', 'Error inserting Obat Pasien: ' . print_r($this->obatPasienModel->errors(), true));
                        $this->db->transRollback();
                        return redirect()->back()->withInput()->with('error', 'Gagal menambahkan obat untuk pasien');
                    }
                }
            }
        } else {
            $this->rekmedModel->editRekmed($idRekmed, ['status' => 'tanpa obat']);
        }
        
        $dataKunjungan = [
            'panggil'         => boolval(0),
            'status'          => $status,
        ];
        
        $this->kunjunganModel->updateKunjungan($kunjunganId, $dataKunjungan);
        
        $this->db->transComplete();
        if ($this->db->transStatus() === true) {
            session()->setFlashData('pesan', 'Rekam medis berhasil ditambahkan');
        } else {
            session()->setFlashData('error', 'Rekam medis gagal ditambahkan');
        }


        return redirect()->to('/pemeriksaan/'. $kunjunganId);
    }

    public function edit ($id)
    {
        $method = 'edit';
        $rekmedPasien = $this->rekmedModel->getRekmedById($id);
        $diagnosas = $this->diagnosaModel->getAllDiagnosa();
        $tindakans = $this->tindakanModel->getAllTindakan();
        $obats = $this->obatModel->getAllObat();
        $diagnosaPasiens = $this->diagnosaPasienModel->getDiagnosaByRekmedId($id);
        $tindakanPasiens = $this->tindakanPasienModel->getTindakanByRekmedId($id);
        $obatPasiens = $this->obatPasienModel->getObatPasienByRekmedId($id);
        $kunjunganId = $this->kunjunganModel->getKunjunganByRekmedId($id);

        return view('pages/rekmedForm', ['kunjunganId' => $kunjunganId, 'method' => $method, 'kunjungan' => $rekmedPasien, 'diagnosas' => $diagnosas, 'tindakans' => $tindakans, 'obats' => $obats, 'diagnosaPasiens' => $diagnosaPasiens, 'tindakanPasiens' => $tindakanPasiens, 'obatPasiens' => $obatPasiens]);
    }

    public function update($id) 
    {
        $this->db->transStart();
        $dataRekmed = [
            'alergi_makanan'        => $this->request->getPost('alergi_makanan'),
            'alergi_obat'           => $this->request->getPost('alergi_obat'),
            'rwt_pykt_terdahulu'    => $this->request->getPost('rwt_pykt_terdahulu'),
            'rwt_pengobatan'        => $this->request->getPost('rwt_pengobatan'),
            'rwt_pykt_keluarga'     => $this->request->getPost('rwt_pykt_keluarga'),
            'keluhan'               => $this->request->getPost('keluhan'),
            'hbg_dgn_keluarga'      => $this->request->getPost('hbg_dgn_keluarga'),
            'sts_psikologi'         => $this->request->getPost('sts_psikologi'),
            'keadaan'               => $this->request->getPost('keadaan'),
            'kesadaran'             => $this->request->getPost('kesadaran'),
            'id_pasien'             => intval($this->request->getPost('id_pasien')),
            'id_poli'               => intval($this->request->getPost('id_poli')),
        ];
        $this->rekmedModel->editRekmed($id, $dataRekmed);

        $idDiagnosaUtama = $this->request->getPost('diagnosa-utama');
        $idDiagnosaSekunder = $this->request->getPost('diagnosa-sekunder');
        $this->diagnosaPasienModel->deleteDiagnosaPasienByRekmedId($id);
        if ($idDiagnosaUtama != null) {
            $dataDiagnosa = [
                'id_rekmed'            => $id,
                'id_pasien'            => intval($this->request->getPost('id_pasien')),
                'id_diagnosa'          => intval($idDiagnosaUtama),
                'status'               => 'utama',
            ];
            $this->diagnosaPasienModel->postDiagnosaPasien($dataDiagnosa);
        };

        if ($idDiagnosaSekunder != null) {
            $dataDiagnosa = [
                'id_rekmed'            => $id,
                'id_pasien'            => intval($this->request->getPost('id_pasien')),
                'id_diagnosa'          => intval($idDiagnosaSekunder),
                'status'               => 'sekunder',
            ];
            $this->diagnosaPasienModel->postDiagnosaPasien($dataDiagnosa);
        };
        
        $idTindakans = $this->request->getPost('tindakan');
        $this->tindakanPasienModel->deleteTindakanPasienByRekmedId($id);
        foreach ($idTindakans as $key => $value) {
            $dataTindakan = [
                'id_rekmed'            => $id,
                'id_pasien'            => intval($this->request->getPost('id_pasien')),
                'id_tindakan'             => intval($value),
            ];

            $this->tindakanPasienModel->postTindakanPasien($dataTindakan);
        }
        
        $idObats = $this->request->getPost('obat');
        $resep = $this->request->getPost('resep');
        $resep2 = $this->request->getPost('resep2');
        $this->obatPasienModel->deleteObatPasienByRekmedId($id);
        foreach ($idObats as $index => $idObat) {
            $dataResep = [
                'id_rekmed'            => $id,
                'id_pasien'            => intval($this->request->getPost('id_pasien')),
                'id_obat'              => intval($idObat),
                'note'                  => $resep[$index]. ' x '.$resep2[$index],
            ];

            $this->obatPasienModel->postObatPasien($dataResep);
        }

        $this->db->transComplete();
        if ($this->db->transStatus() === true) {
            session()->setFlashData('pesan', 'Rekam medis berhasil diperbarui');
        } else {
            session()->setFlashData('error', 'Rekam medis gagal diperbarui');
        }

        $kunjunganId = $this->request->getPost('id_kunjungan');
        return redirect()->to('/pemeriksaan/'. $kunjunganId);
    }

    public function delete($id, $kunjunganId) 
    {   
        $this->db->transStart();

        $this->rekmedModel->deleteRekmed($id);
        $this->diagnosaPasienModel->deleteDiagnosaPasienByRekmedId($id);
        $this->tindakanPasienModel->deleteTindakanPasienByRekmedId($id);
        $this->obatPasienModel->deleteObatPasienByRekmedId($id);

        $this->db->transComplete();
        if ($this->db->transStatus() === true) {
            session()->setFlashData('pesan', 'Rekam medis berhasil di hapus');
        } else {
            session()->setFlashData('error', 'Rekam medis gagal di hapus');
        }
        return redirect()->to('/pemeriksaan/'. $kunjunganId);
    }
}