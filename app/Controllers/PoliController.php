<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Poli;
use CodeIgniter\HTTP\ResponseInterface;

class PoliController extends BaseController
{
    protected $poliModel;

    public function __construct()
    {
        $this->poliModel = new Poli();
    }

    public function index()
    {
        return view('pages/poli');
    }

    public function getPoli() {
        $polis = $this->poliModel->getAllPoli();

        return $this->response->setJSON($polis);
    }

    public function getPoliById($id) {
        $poli = $this->poliModel->getPoliById($id);

        return $this->response->setJSON($poli);
    }

    public function postPoli() {
        $newKode = $this->poliModel->generateKodePoli();

        $data = [
            'nama' => $this->request->getPost('nama'),
            'kode' => $newKode
        ];

        if ($this->poliModel->postPoli($data)) {
            session()->setFlashdata('pesan', 'Data poli berhasil ditambahkan');
        } else {
            session()->setFlashdata('error', 'Data poli gagal ditambahkan');
        }

        return redirect()->to('/poli');
    }

    public function editPoli($id) {
        $data = [
            'nama' => $this->request->getPost('nama')
        ];

        if ($this->poliModel->editPoli($id, $data)) {
            session()->setFlashdata('pesan', 'Data poli berhasil diubah');
        } else {
            session()->setFlashdata('error', 'Data poli gagal diubah');
        }

        return redirect()->to('/poli');
    }

    public function deletePoli($id) {
        if ($this->poliModel->deletePoli($id)) {
            session()->setFlashdata('pesan', 'Data poli berhasil dihapus');
        } else {
            session()->setFlashdata('error', 'Data poli gagal dihapus');
        }

        return redirect()->to('/poli');
    }
}