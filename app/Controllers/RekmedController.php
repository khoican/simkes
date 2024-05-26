<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Diagnosa;
use App\Models\DiagnosaPasien;
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

        $diagnosaPasiens = [];
        foreach ($rekmedPasiens as $rekmedPasien) {
            $diagnosaPasiens[$rekmedPasien['id']] = $this->diagnosaPasienModel->getDiagnosaByRekmedId($rekmedPasien['id']);
        }

        return view('pages/rekmed', ['pasienId' => $pasienId, 'kunjunganId' => $kunjunganId, 'rekmedPasiens' => $rekmedPasiens, 'diagnosaPasiens' => $diagnosaPasiens]);
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

        return view('pages/rekmedForm', ['method' => $method, 'kunjungan' => $rekmedPasien, 'diagnosas' => $diagnosas, 'tindakans' => $tindakans, 'obats' => $obats, 'diagnosaPasiens' => $diagnosaPasiens, 'tindakanPasiens' => $tindakanPasiens, 'obatPasiens' => $obatPasiens]);
    }

    public function create($kunjunganId)
    {
        $method = 'post';
        $kunjungan = $this->kunjunganModel->getKunjunganById($kunjunganId);
        $diagnosas = $this->diagnosaModel->getAllDiagnosa();
        $tindakans = $this->tindakanModel->getAllTindakan();
        $obats = $this->obatModel->getAllObat();
        return view('pages/rekmedForm', ['method' => $method, 'kunjungan' => $kunjungan, 'diagnosas' => $diagnosas, 'tindakans' => $tindakans, 'obats' => $obats]);
    }

    public function store($id)
    {
        $this->db->transStart();
        $isSuccess = false;
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

        $idDiagnosas = $this->request->getPost('diagnosa');
        foreach ($idDiagnosas as $key => $value) {
            $dataDiagnosa = [
                'id_rekmed'            => $idRekmed,
                'id_pasien'            => intval($id),
                'id_diagnosa'          => intval($value),
            ];
            $this->diagnosaPasienModel->postDiagnosaPasien($dataDiagnosa);
        };
        
        $idTindakans = $this->request->getPost('tindakan');
        foreach ($idTindakans as $key => $value) {
            $dataTindakan = [
                'id_rekmed'            => $idRekmed,
                'id_pasien'            => intval($id),
                'id_tindakan'             => intval($value),
            ];

            $this->tindakanPasienModel->postTindakanPasien($dataTindakan);
        }
        
        $idObats = $this->request->getPost('obat');
        $qtys = $this->request->getPost('qty');
        foreach ($idObats as $index => $idObat) {
            $dataResep = [
                'id_rekmed'            => $idRekmed,
                'id_pasien'            => intval($id),
                'id_obat'              => intval($idObat),
                'qty'                  => intval($qtys[$index]),
            ];

            if ($this->obatPasienModel->postObatPasien($dataResep)) {
                $isSuccess = true;
            }
        }

        if ($isSuccess) {
            $dataKunjungan = [
                'panggil'         => boolval(0),
                'status'          => 'antrian-obat',
            ];
    
            $this->kunjunganModel->updateKunjungan($kunjunganId, $dataKunjungan);
        }

        $this->db->transComplete();
        if ($this->db->transStatus() === true && $isSuccess) {
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

        return view('pages/rekmedForm', ['method' => $method, 'kunjungan' => $rekmedPasien, 'diagnosas' => $diagnosas, 'tindakans' => $tindakans, 'obats' => $obats, 'diagnosaPasiens' => $diagnosaPasiens, 'tindakanPasiens' => $tindakanPasiens, 'obatPasiens' => $obatPasiens]);
    }

    public function update($id) 
    {
        $this->db->transStart();
        $isSuccess = false;
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

        $idDiagnosas = $this->request->getPost('diagnosa');
        $this->diagnosaPasienModel->deleteDiagnosaPasienByRekmedId($id);
        foreach ($idDiagnosas as $key => $value) {
            $dataDiagnosa = [
                'id_rekmed'            => $id,
                'id_pasien'            => intval($this->request->getPost('id_pasien')),
                'id_diagnosa'          => intval($value),
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
        $qtys = $this->request->getPost('qty');
        $this->obatPasienModel->deleteObatPasienByRekmedId($id);
        foreach ($idObats as $index => $idObat) {
            $dataResep = [
                'id_rekmed'            => $id,
                'id_pasien'            => intval($this->request->getPost('id_pasien')),
                'id_obat'              => intval($idObat),
                'qty'                  => intval($qtys[$index]),
            ];

            if ($this->obatPasienModel->postObatPasien($dataResep)) {
                $isSuccess = true;
            }
        }

        $this->db->transComplete();
        if ($this->db->transStatus() === true && $isSuccess) {
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