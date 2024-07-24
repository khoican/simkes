<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Diagnosa;
use App\Models\DiagnosaPasien;
use App\Models\GeneralConcent;
use App\Models\Kunjungan;
use App\Models\Obat;
use App\Models\ObatPasien;
use App\Models\ObatRacikan;
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
    protected $obatRacikanModel;
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
        $this->obatRacikanModel = new ObatRacikan();
        $this->db = db_connect();
    }

    public function index() {
        $data = [
            'id' => null
        ];
        return view('pages/rekmed', $data);
    }

    public function periksaPasien($kunjunganId) {
        $kunjungan = $this->kunjunganModel->getKunjunganById($kunjunganId);
        $data = [
            'panggil'         => 0,
            'status'          => 'pemeriksaan',
        ];
        if ($this->kunjunganModel->updateKunjungan($kunjunganId, $data)) {
            return redirect()->to('/rekmed/'. $kunjungan['id_pasien']);
        }
    }

    public function getByUser($pasienId)
    {
        $kunjunganId = $this->kunjunganModel->getKunjunganByPasienId($pasienId);
        $rekmedPasiens = $this->rekmedModel->getRekmedByPasienId($pasienId);
        $generalConsent = $this->generalConsentModel->getGeneralConsentByPasienId($pasienId);
        $diagnosas = $this->diagnosaModel->getAllDiagnosa();
        $tindakans = $this->tindakanModel->getAllTindakan();
        $obats = $this->obatModel->getAllObat();

        $diagnosaPasiens = [];  
        foreach ($rekmedPasiens as $rekmedPasien) {
            $diagnosaPasiens[$rekmedPasien['id']] = $this->diagnosaPasienModel->getDiagnosaByRekmedId($rekmedPasien['id']);
        }

        return view('pages/rekmed', [
            'id' => $pasienId,
            'kunjunganId' => $kunjunganId,
            'rekmedPasiens' => $rekmedPasiens,
            'diagnosaPasiens' => $diagnosaPasiens,
            'generalConsent' => $generalConsent,
            'diagnosas' => $diagnosas,
            'tindakans' => $tindakans,
            'obats' => $obats
        ]);
    }


    public function show($id) {
        $method = 'show';
        $rekmedPasien = $this->rekmedModel->getRekmedById($id);
        $diagnosaPasiens = $this->diagnosaPasienModel->getDiagnosaByRekmedId($id);
        $tindakanPasiens = $this->tindakanPasienModel->getTindakanByRekmedId($id);
        $obatPasiens = $this->obatPasienModel->getObatPasienByRekmedId($id);
        $kunjunganId = $this->kunjunganModel->getKunjunganByRekmedId($id);
        $obatRacikan = $this->obatRacikanModel->getObatRacikan($rekmedPasien['id']);

        $rekmedPasien['id_kunjungan'] = $kunjunganId['id'];

        return $this->response->setJSON( [
            'id' => $rekmedPasien['id_pasien'], 
            'method' => $method, 
            'kunjungan' => $rekmedPasien, 
            'diagnosaPasiens' => $diagnosaPasiens, 
            'tindakanPasiens' => $tindakanPasiens, 
            'obatPasiens' => $obatPasiens,
            'obatRacikan' => $obatRacikan
        ]);
    }

    public function create($pasienId)
    {
        $method = 'post';
        $kunjungan = $this->kunjunganModel->getKunjunganByPasienId($pasienId);
        $diagnosas = $this->diagnosaModel->getAllDiagnosa();
        $tindakans = $this->tindakanModel->getAllTindakan();
        $latestRekmed = $this->rekmedModel->getLatestRekmedByPasienId($pasienId);
        $obats = $this->obatModel->getAllObat();

        return view('pages/rekmedForm', [
            'id' => $pasienId,
            'kunjunganId' => $kunjungan, 
            'method' => $method, 
            'kunjungan' => $kunjungan, 
            'diagnosas' => $diagnosas, 
            'tindakans' => $tindakans, 
            'latestRekmed' => $latestRekmed,
            'obats' => $obats]);
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
            'bb'                    => $this->request->getPost('bb'),
            'tb'                    => $this->request->getPost('tb'),
            'imt'                   => $this->request->getPost('imt'),
            'sistole'               => $this->request->getPost('sistole'),
            'diastole'              => $this->request->getPost('diastole'),
            'nadi'                  => $this->request->getPost('nadi'),
            'rr'                    => $this->request->getPost('rr'),
            'suhu'                  => $this->request->getPost('suhu'),
            'skala_nyeri'           => $this->request->getPost('skala_nyeri'),
            'frek_nyeri'            => $this->request->getPost('frek_nyeri'),
            'lama_nyeri'            => $this->request->getPost('lama_nyeri'),
            'menjalar'              => $this->request->getPost('menjalar'),
            'menjalar_ket'          => $this->request->getPost('menjalar_ket'),
            'kualitas_nyeri'        => $this->request->getPost('kualitas_nyeri'),
            'fakt_pemicu'           => $this->request->getPost('fakt_pemicu'),
            'fakt_pengurang'        => $this->request->getPost('fakt_pengurang'),
            'lokasi_nyeri'          => $this->request->getPost('lokasi_nyeri'),
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
        } else {
            session()->setFlashdata('error', 'Diagnosa sekunder harus diisi.');
            return redirect()->back()->withInput();
        }
        
        $idTindakans = $this->request->getVar('tindakan');
        if ($idTindakans != null) {
            foreach ($idTindakans as $key => $value) {
                $dataTindakan = [
                    'id_rekmed'            => $idRekmed,
                    'id_pasien'            => intval($id),
                    'id_tindakan'          => intval($value),
                ];
                $this->tindakanPasienModel->postTindakanPasien($dataTindakan);
            }
        } else {
            session()->setFlashdata('error', 'Tindakan harus diisi.');
            return redirect()->back()->withInput();
        }
        
        $idObats = $this->request->getVar('obat');
        $resep = $this->request->getVar('resep');
        $resep2 = $this->request->getVar('resep2');
        $jmlResep = $this->request->getVar('jml_resep');
        $ket = $this->request->getVar('ket');

        $status = 'selesai';
        if ($idObats[0] != null && $resep[0] != null && $resep2[0] != null) {
            foreach ($idObats as $index => $idObat) {
                if (isset($resep[$index]) && isset($resep2[$index])) {
                    $dataResep = [
                        'id_rekmed' => $idRekmed,
                        'id_pasien' => intval($id),
                        'id_obat'   => intval($idObat),
                        'signa'     => $resep[$index] . ' x ' . $resep2[$index],
                        'ket'       => $ket[$index],
                        'jml_resep' => $jmlResep[$index],
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
            'id_rekmed'       => $idRekmed,
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


        return redirect()->to('/rekmed/'. $id);
    }

    public function edit ($id)
    {
        $method = 'edit';
        $statusPulang = false;
        $rekmedPasien = $this->rekmedModel->getRekmedById($id);
        $diagnosas = $this->diagnosaModel->getAllDiagnosa();
        $tindakans = $this->tindakanModel->getAllTindakan();
        $obats = $this->obatModel->getAllObat();
        $diagnosaPasiens = $this->diagnosaPasienModel->getDiagnosaByRekmedId($id);
        $tindakanPasiens = $this->tindakanPasienModel->getTindakanByRekmedId($id);
        $obatPasiens = $this->obatPasienModel->getObatPasienByRekmedId($id);
        $kunjunganId = $this->kunjunganModel->getKunjunganByRekmedId($id);

        $rekmedPasien['id_kunjungan'] = $kunjunganId['id'];

        if (count($obatPasiens) > 0) {
            $statusPulang = true;
        }

        return view('pages/rekmedForm', [
            'id' => $rekmedPasien['id_pasien'], 
            'statusPulang' => $statusPulang,
            'method' => $method, 
            'kunjungan' => $rekmedPasien, 
            'diagnosas' => $diagnosas, 
            'tindakans' => $tindakans, 
            'obats' => $obats, 
            'diagnosaPasiens' => $diagnosaPasiens, 
            'tindakanPasiens' => $tindakanPasiens, 
            'obatPasiens' => $obatPasiens]);
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
            'bb'                    => $this->request->getPost('bb'),
            'tb'                    => $this->request->getPost('tb'),
            'imt'                   => $this->request->getPost('imt'),
            'sistole'               => $this->request->getPost('sistole'),
            'diastole'              => $this->request->getPost('diastole'),
            'nadi'                  => $this->request->getPost('nadi'),
            'rr'                    => $this->request->getPost('rr'),
            'suhu'                  => $this->request->getPost('suhu'),
            'skala_nyeri'           => $this->request->getPost('skala_nyeri'),
            'frek_nyeri'            => $this->request->getPost('frek_nyeri'),
            'lama_nyeri'            => $this->request->getPost('lama_nyeri'),
            'menjalar'              => $this->request->getPost('menjalar'),
            'menjalar_ket'          => $this->request->getPost('menjalar_ket'),
            'kualitas_nyeri'        => $this->request->getPost('kualitas_nyeri'),
            'fakt_pemicu'           => $this->request->getPost('fakt_pemicu'),
            'fakt_pengurang'        => $this->request->getPost('fakt_pengurang'),
            'lokasi_nyeri'          => $this->request->getPost('lokasi_nyeri'),
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
        } else {
            session()->setFlashdata('error', 'Diagnosa sekunder wajib diisi');
            return redirect()->back()->withInput();
        }
        
        $idTindakans = $this->request->getPost('tindakan');
        if ($idTindakans != null) {
            $this->tindakanPasienModel->deleteTindakanPasienByRekmedId($id);
            foreach ($idTindakans as $key => $value) {
                $dataTindakan = [
                    'id_rekmed'            => $id,
                    'id_pasien'            => intval($this->request->getPost('id_pasien')),
                    'id_tindakan'             => intval($value),
                ];
    
                $this->tindakanPasienModel->postTindakanPasien($dataTindakan);
            }
        } else {
            session()->setFlashdata('error', 'Tindakan wajib diisi');
            return redirect()->back()->withInput();
        }
        
        $idObats = $this->request->getPost('obat');
        $resep = $this->request->getPost('resep');
        $resep2 = $this->request->getPost('resep2');
        $ket = $this->request->getPost('ket');
        $jmlResep = $this->request->getPost('jml_resep');
        if ($idObats[0] != null && $resep[0] != null && $resep2[0] != null) {
            $this->obatPasienModel->deleteObatPasienByRekmedId($id);
            foreach ($idObats as $index => $idObat) {
                $dataResep = [
                    'id_rekmed'            => $id,
                    'id_pasien'            => intval($this->request->getPost('id_pasien')),
                    'id_obat'              => intval($idObat),
                    'signa'                => $resep[$index]. ' x '.$resep2[$index],
                    'ket'                  => $ket[$index],
                    'jml_resep'            => $jmlResep[$index] 
                ];
    
                $this->obatPasienModel->postObatPasien($dataResep);
            }
        }

        $this->db->transComplete();
        if ($this->db->transStatus() === true) {
            session()->setFlashData('pesan', 'Rekam medis berhasil diperbarui');
        } else {
            session()->setFlashData('error', 'Rekam medis gagal diperbarui');
        }

        $kunjunganId = $this->request->getPost('id_kunjungan');
        return redirect()->to('/rekmed/'. $this->request->getPost('id_pasien'));
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
        return redirect()->to('/rekmed/'. $kunjunganId);
    }
}