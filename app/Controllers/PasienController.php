<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Alamat;
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

    public function __construct()
    {
        $this->pasienModel = new Pasien();
        $this->kunjunganModel = new Kunjungan();
        $this->alamatModel = new Alamat();
        $this->poliModel = new Poli();
    }
    
    public function index()
    {
        $pasiens = $this->pasienModel->getAllPasien();
        $polis = $this->poliModel->getAllPoli();
        return view('pages/pendaftaran', ['pasiens' => $pasiens, 'polis' => $polis]);
    }

    public function fetchPasien() 
    {
        $data = $this->pasienModel->getAllPasien();

        return $this->response->setJSON($data);
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

    public function create()
    {
        
    }

    public function store()
    {
        $generateRekmed = rand(300000000000000, 999999999999999);
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
            'knjn_sehat'        => $this->request->getPost('knjn_sehat'),
            'tkp'               => $this->request->getPost('tkp'),
            'id_alamat'         => $alamatId,
        );
        $pasienId = $this->pasienModel->postPasien($dataPasien);
        
        if ($pasienId == false) {
            session()->setFlashData('error', 'Gagal menambahkan pasien');
        } 
        
        $poliId = intval($this->request->getPost('poli'));
        $kodeAntrian = $this->kunjunganModel->generateAntrian($poliId);
        $dataKunjungan = array(
            'no_antrian'        => $kodeAntrian,
            'id_pasien'         => $pasienId,
            'id_poli'           => $poliId,
            'status'            => 'antrian',
        );

        $result = $this->kunjunganModel->postKunjungan($dataKunjungan);

        if ($result == true) {
            session()->setFlashData('pesan', 'Pasien baru ditambahkan');
        } else {
            session()->setFlashData('error', 'Gagal menambahkan pasien');
        }
        
        return redirect()->to('/pendaftaran'); 
    }

    public function edit($id) {

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
                'no_rekam_medis'    => $this->request->getPost('no_rekam_medis'),   
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
                'knjn_sehat'        => $this->request->getPost('knjn_sehat'),
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