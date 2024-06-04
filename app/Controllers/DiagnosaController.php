<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Diagnosa;
use App\Models\DiagnosaPasien;
use CodeIgniter\HTTP\ResponseInterface;

class DiagnosaController extends BaseController
{
    protected $diagnosaModel;

    public function __construct()
    {
        $this->diagnosaModel = new Diagnosa();
    }

    public function index()
    {
        return view('pages/diagnosa');
    }

    public function getDiagnosa() {
        $diagnosa = $this->diagnosaModel->getAllDiagnosa();

        return $this->response->setJSON($diagnosa);
    }

    public function getDiagnosaById($id) {
        $diagnosa = $this->diagnosaModel->getDiagnosaById($id);
        return $this->response->setJSON($diagnosa);
    }

    public function postDiagnosa() {
        $newKode = $this->diagnosaModel->generateKodeDiagnosa();
        $data = [
            'kode' => $this->request->getPost('kode'),
            'diagnosa' => $this->request->getPost('diagnosa')
        ];

        if ($this->diagnosaModel->postDiagnosa($data)) {
            session()->setFlashdata('pesan', 'Berhasil menambahkan data diagnosa');
        } else {
            session()->setFlashdata('error', 'Gagal menambahkan data diagnosa');
        }

        return redirect()->to('/diagnosa');
    }

    public function editDiagnosa($id) {
        $data = [
            'kode' => $this->request->getPost('kode'),
            'diagnosa' => $this->request->getPost('diagnosa')
        ];

        if ($this->diagnosaModel->editDiagnosa($id, $data)) {
            session()->setFlashdata('pesan', 'Berhasil mengubah data diagnosa');
        } else {
            session()->setFlashdata('error', 'Gagal mengubah data diagnosa');
        }

        return redirect()->to('/diagnosa');
    }

    public function deleteDiagnosa($id) {
        if ($this->diagnosaModel->deleteDiagnosa($id)) {
            session()->setFlashdata('pesan', 'Berhasil menghapus data diagnosa');
        } else {
            session()->setFlashdata('error', 'Gagal menghapus data diagnosa');
        }

        return redirect()->to('/diagnosa');
    }
}