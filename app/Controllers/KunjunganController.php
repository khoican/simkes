<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Kunjungan;
use App\Models\KunjunganHistory;
use App\Models\Pasien;
use App\Models\Poli;
use App\Models\Rekmed;
use CodeIgniter\HTTP\ResponseInterface;

class KunjunganController extends BaseController
{
    protected $kunjunganModel;
    protected $pasienModel;
    protected $rekmedModel;
    protected $poliModel;
    protected $kunjunganHistoryModel;

    public function __construct()
    {
        $this->kunjunganModel = new Kunjungan();
        $this->pasienModel = new Pasien();
        $this->rekmedModel = new Rekmed();
        $this->poliModel = new Poli();
        $this->kunjunganHistoryModel = new KunjunganHistory();
    }

    public function pemeriksaan()
    {
        $kunjungans = [];
        $poliId = $this->poliModel->getAllPoli();

        foreach ($poliId as $poli) {
            $kunjungans[$poli['id']] = $this->kunjunganHistoryModel->getKunjunganHstoryByPoli($poli['id'], 'pemeriksaan');
        }
        return view('pages/pemeriksaan', [ 'kunjungans' => $kunjungans, 'polis' => $poliId]);
    }

    public function apotek() {
        $kunjungans = [];
        $poliId = $this->poliModel->getAllPoli();

        foreach ($poliId as $poli) {
            $kunjungans[$poli['id']] = $this->kunjunganHistoryModel->getKunjunganHstoryByPoli($poli['id'], 'apotek');
        }

        return view('pages/apotek', [ 'kunjungans' => $kunjungans, 'polis' => $poliId]);
    }

    public function getKunjunganStatus($status) {
        if ($status != 'all') {
            $kunjungans = $this->kunjunganModel->getKunjunganByStatus($status);
        } else {
            $kunjungans = $this->kunjunganModel->getAllKunjungan();
        }
        return $this->response->setJSON($kunjungans);
    }

    public function generateAntrian() {
        $polis = $this->poliModel->getAllPoli();

        $antrianData = [];
        foreach ($polis as $poli) {
            $antrian = $this->kunjunganModel->generateAntrian($poli['id']);

            $antrianData[] = [
                'id' => $poli['id'],
                'nama' => $poli['nama'],
                'antrian' => $antrian,
            ];
        }
        return $this->response->setJSON($antrianData);
    }

    public function getServiceTime() {
        $serviceTime = $this->kunjunganModel->calculateServiceTime();
        return $this->response->setJSON($serviceTime);
    }

    public function show($id)
    {
        $pasien = $this->pasienModel->getPasienById($id);
        $rekmed = $this->rekmedModel->getRekmedByPasienId($id);
    }

    public function store()
    {
        $data = array(
            'no_antrian'      => $this->request->getPost('no_antrian'),
            'id_pasien'       => $this->request->getPost('id_pasien'),
            'id_poli'         => $this->request->getPost('id_poli'),
            'status'          => 'antrian',
        );
        $result = $this->kunjunganModel->postKunjungan($data);

        if ($result) {
            session()->setFlashData('pesan', 'Antrian ditambahkan');
        } else {
            session()->setFlashData('error', 'Antrian gagal ditambahkan');
        }
        return redirect()->to('/pendaftaran'); 
    }

    public function panggilAntrian($id) {
        $data = [
            'panggil' => 1,
        ];
        $result = $this->kunjunganModel->updateKunjungan($id, $data);
        if ($result) {
            $dataKunjungan = [
                'no_antrian' => $this->request->getPost('no_antrian'),
                'id_poli'    => $this->request->getPost('id_poli'),
                'status'     => $this->request->getPost('status'),
            ];

            $this->kunjunganHistoryModel->postKunjunganHistory($dataKunjungan);

            session()->setFlashData('pesan', 'Pasien dipanggil');
        } else {
            session()->setFlashData('error', 'Gagal Memanggil Pasien');
        }
        return redirect()->back();
    }

    public function update($id)
    {
        $data = [
            'panggil'         => boolval($this->request->getPost('panggil')),
            'status'          => $this->request->getPost('status'),
        ];
        $result = $this->kunjunganModel->updateKunjungan($id, $data);

        if ($result) {
            session()->setFlashData('pesan', 'Antrian ditambahkan');
        } else {
            session()->setFlashData('error', 'Antrian gagal ditambahkan');
        }

        return redirect()->back();
    }
}