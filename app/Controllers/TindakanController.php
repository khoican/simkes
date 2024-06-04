<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Tindakan;
use CodeIgniter\HTTP\ResponseInterface;

class TindakanController extends BaseController
{
    protected $tindakanModel;

    public function __construct()
    {
        $this->tindakanModel = new Tindakan();
    }

    public function index()
    {
        return view('pages/tindakan');
    }

    public function getTindakan()
    {
        $tindakan = $this->tindakanModel->getAllTindakan();
        return $this->response->setJSON($tindakan);
    }

    public function getTindakanById($id)
    {
        $tindakan = $this->tindakanModel->getTindakanById($id);
        return $this->response->setJSON($tindakan);
    }

    public function postTindakan() {
        $newKode = $this->tindakanModel->generateKodeTindakan();
        $data = [
            'kode' => $this->request->getPost('kode'),
            'tindakan' => $this->request->getPost('tindakan')
        ];

        if($this->tindakanModel->postTindakan($data)) {
            session()->setFlashdata('pesan', 'Berhasil menambahkan data tindakan');
        } else {
            session()->setFlashdata('error', 'Gagal menambahkan data tindakan');
        }

        return redirect()->to('/tindakan');
    }

    public function editTindakan($id) {
        $data = [
            'kode' => $this->request->getPost('kode'),
            'tindakan' => $this->request->getPost('tindakan')
        ];

        if($this->tindakanModel->editTindakan($id, $data)) {
            session()->setFlashdata('pesan', 'Berhasil mengubah data tindakan');
        } else {
            session()->setFlashdata('error', 'Gagal mengubah data tindakan');
        }

        return redirect()->to('/tindakan');
    }

    public function deleteTindakan($id) {
        if($this->tindakanModel->deleteTindakan($id)) {
            session()->setFlashdata('pesan', 'Berhasil menghapus data tindakan');
        } else {
            session()->setFlashdata('error', 'Gagal menghapus data tindakan');
        }

        return redirect()->to('/tindakan');
    }
}