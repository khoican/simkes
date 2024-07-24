<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Alamat;
use App\Models\GeneralConcent;
use App\Models\Kunjungan;
use App\Models\Pasien;
use App\Models\Poli;
use CodeIgniter\HTTP\ResponseInterface;

class PasienController extends BaseController
{
    protected $pasienModel;
    protected $kunjunganModel;
    protected $alamatModel;
    protected $poliModel;
    protected $generalConsentModel;
    protected $db;

    public function __construct()
    {
        $this->pasienModel = new Pasien();
        $this->kunjunganModel = new Kunjungan();
        $this->alamatModel = new Alamat();
        $this->poliModel = new Poli();
        $this->generalConsentModel = new GeneralConcent();
        $this->db = db_connect();
    }
    
    public function index()
    {
        $pasiens = $this->pasienModel->getAllPasien();
        $polis = $this->poliModel->getAllPoli();
        return view('pages/pendaftaran', ['pasiens' => $pasiens, 'polis' => $polis]);
    }

    public function fetchPasien()
    {
        $primarySearch = $this->request->getVar('primarySearch');
        $secondarySearch = $this->request->getVar('secondarySearch');
        $start = $this->request->getVar('start', FILTER_VALIDATE_INT) ?? 0;
        $length = $this->request->getVar('length', FILTER_VALIDATE_INT) ?? 10;
        $order = $this->request->getVar('order') ?? [];
        $columns = $this->request->getVar('columns') ?? [];

        $orderColumnIndex = $order[0]['column'] ?? 0;
        $orderColumn = $columns[$orderColumnIndex]['data'] ?? 'no_rekam_medis';
        $orderDir = $order[0]['dir'] ?? 'asc';

        $result = $this->pasienModel->searchPasien($primarySearch, $secondarySearch, $start, $length, $orderColumn, $orderDir);

        return $this->response->setJSON([
            'draw' => $this->request->getVar('draw') ?? 1,
            'recordsTotal' => $result['recordsTotal'],
            'recordsFiltered' => $result['recordsTotal'],
            'data' => $result['data'],
        ]);
    }

    public function searchPasien()
    {
        $search = $this->request->getVar('search');
        $route = $this->request->getVar('route');
        $result = $this->pasienModel->searchEngine($search);

        if (isset($result)) {
            return redirect()->to('/'.$route.'/'.$result[0]->id);
        } else {
            session()->setFlashdata('error', 'Pasien tidak ditemukan');
            return redirect()->back()->withInput();
        }
    }

    public function getPasien($id) 
    {
        $pasien = $this->pasienModel->getPasienById($id);
        if ($pasien) {
            return $this->response->setJSON($pasien);
        } else {
            return $this->response->setStatusCode(404, 'Pasien not found');
        }
    }

    public function store()
    {
        $this->db->transStart();
        $generateRekmed = $this->pasienModel->generateNoRekmed();
        
        
        $poliId = intval($this->request->getPost('poli'));
        if ($poliId) {
            $dataAlamat = array(
                'alamat'       => $this->request->getPost('alamat'),
                'rt'           => $this->request->getPost('rt'),
                'rw'           => $this->request->getPost('rw'),
                'kelurahan'    => $this->request->getPost('kelurahan'),
                'kecamatan'    => $this->request->getPost('kecamatan'),
                'kota'         => $this->request->getPost('kota'),
            );
            $alamatId = $this->alamatModel->postAlamat($dataAlamat);
    
            $dataPasien = array(
                'no_rekam_medis'    => $generateRekmed,
                'nik'               => $this->request->getPost('nik'),
                'no_bpjs'           => $this->request->getPost('no_bpjs'),
                'nama'              => $this->request->getPost('nama'),
                'jk'                => $this->request->getPost('jk'),
                'tmp_lahir'         => $this->request->getPost('tmp_lahir'),
                'tgl_lahir'         => $this->request->getPost('tgl_lahir'),
                'gol_darah'         => $this->request->getPost('gol_darah'),
                'agama'             => $this->request->getPost('agama'),
                'pendidikan'        => $this->request->getPost('pendidikan'),
                'pekerjaan'         => $this->request->getPost('pekerjaan'),
                'kpl_keluarga'      => $this->request->getPost('kpl_keluarga'),
                'pss_dlm_keluarga'  => $this->request->getPost('pss_dlm_keluarga'),
                'pss_anak'          => $this->request->getPost('pss_anak'),
                'telepon'           => $this->request->getPost('telepon'),
                'telepon2'          => $this->request->getPost('telepon2'),
                'pembayaran'        => $this->request->getPost('pembayaran'),
                'knjn_sehat'        => $this->request->getPost('knjn_sehat') ? 1 : 0,
                'tkp'               => $this->request->getPost('tkp'),
                'id_alamat'         => $alamatId,
            );
            $pasienId = $this->pasienModel->postPasien($dataPasien);
            
            if (is_array($pasienId)) {
                session()->setFlashData('error', 'Gagal menambahkan pasien');
            } 
        
            $kodeAntrian = $this->kunjunganModel->generateAntrian($poliId);
            $dataKunjungan = array(
                'no_antrian'        => $kodeAntrian,
                'id_pasien'         => $pasienId,
                'id_poli'           => $poliId,
                'status'            => 'antrian',
            );
    
            $this->kunjunganModel->postKunjungan($dataKunjungan);
        } else {
            session()->setFlashData('error', 'Silahkan pilih poli tujuan terlebih dahulu');
        }

        $this->db->transComplete();
        if ($this->db->transStatus() === true) {
            session()->setFlashData('pesan', 'Pasien baru ditambahkan');
        } else {
            session()->setFlashData('error', 'Gagal menambahkan pasien');
        }
        
        return redirect()->to('/pendaftaran'); 
    }

    public function postGeneralConsent() {
        $data = [
            'nama'  => $this->request->getPost('nama'),
            'umur'  => $this->request->getPost('umur'),
            'alamat'  => $this->request->getPost('alamat'),
            'no_telp' => $this->request->getPost('no_telp'),
            'status'    => $this->request->getPost('status'),
            'id_pasien' => $this->request->getPost('id_pasien'),
        ];

        if ($this->generalConsentModel->postGeneralConsent($data)) {
            session()->setFlashdata('pesan', 'Data general consent berhasil ditambahkan');
        } else {
            session()->setFlashdata('error', 'Data general consent gagal ditambahkan');
        }

        return redirect()->back();
    }

    public function update($id)
    {
        $dataAlamat = array(
            'alamat'       => $this->request->getPost('alamat'),
            'rt'           => $this->request->getPost('rt'),
            'rw'           => $this->request->getPost('rw'),
            'kelurahan'    => $this->request->getPost('kelurahan'),
            'kecamatan'    => $this->request->getPost('kecamatan'),
            'kota'         => $this->request->getPost('kota'),
        );
        $alamatId = intval($this->request->getPost('id_alamat'));
        $alamats = $this->alamatModel->updateAlamat($alamatId, $dataAlamat);
        if ($alamats != true) {
            session()->setFlashdata('error', $alamats);
            return redirect()->back();
        } else {
            $dataPasien = array(
                'nik'               => $this->request->getPost('nik'),
                'no_bpjs'           => $this->request->getPost('no_bpjs'),
                'nama'              => $this->request->getPost('nama'),
                'jk'                => $this->request->getPost('jk'),
                'tmp_lahir'         => $this->request->getPost('tmp_lahir'),
                'tgl_lahir'         => $this->request->getPost('tgl_lahir'),
                'gol_darah'         => $this->request->getPost('gol_darah'),
                'agama'             => $this->request->getPost('agama'),
                'pendidikan'        => $this->request->getPost('pendidikan'),
                'pekerjaan'         => $this->request->getPost('pekerjaan'),
                'kpl_keluarga'      => $this->request->getPost('kpl_keluarga'),
                'pss_dlm_keluarga'  => $this->request->getPost('pss_dlm_keluarga'),
                'pss_anak'          => $this->request->getPost('pss_anak'),
                'telepon'           => $this->request->getPost('telepon'),
                'telepon2'          => $this->request->getPost('telepon2'),
                'pembayaran'        => $this->request->getPost('pembayaran'),
                'knjn_sehat'        => $this->request->getPost('knjn_sehat') ? 1 : 0,
                'tkp'               => $this->request->getPost('tkp'),
                'id_alamat'         => $alamatId,
            );
            $result = $this->pasienModel->updatePasien($id, $dataPasien);
            if ($result == 'success') {
                session()->setFlashData('pesan', 'Data pasien berhasil diperbarui');
            } else {
                session()->setFlashData('error', $result);
            }
        }

        return redirect()->to('/pendaftaran');
    }
}