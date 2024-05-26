<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Obat;
use CodeIgniter\HTTP\ResponseInterface;

class ObatController extends BaseController
{
    protected $obatModel;

    public function __construct()
    {
        $this->obatModel = new Obat();
    }

    public function index()
    {
        return view('pages/obat');
    }

    public function getObat()
    {
        $data = $this->obatModel->getAllObat();
        return $this->response->setJSON($data);
    }

    public function getObatById($id)
    {
        $data = $this->obatModel->getObatById($id);
        return $this->response->setJSON($data);
    }

    public function postObat() {
        $newKode = $this->obatModel->generateKodeObat();

        $data = [
            'kode' => $newKode,
            'obat' => $this->request->getPost('obat'),
            'jenis' => $this->request->getPost('jenis'),
            'bentuk' => $this->request->getPost('bentuk'),
            'stok' => $this->request->getPost('stok'),
            'harga' => $this->request->getPost('harga'),
        ];
        
        if ($this->obatModel->postObat($data)) {
            session()->setFlashdata('pesan', 'Data obat berhasil ditambahkan');
        } else {
            session()->setFlashdata('error', 'Data obat gagal ditambahkan');
        }

        return redirect()->to('/obat');
    }

    public function editObat($id) {
        $data = [
            'obat' => $this->request->getPost('obat'),
            'jenis' => $this->request->getPost('jenis'),
            'bentuk' => $this->request->getPost('bentuk'),
            'stok' => $this->request->getPost('stok'),
            'harga' => $this->request->getPost('harga'),
        ];

        if ($this->obatModel->updateObat($id, $data)) {
            session()->setFlashdata('pesan', 'Data obat berhasil diubah');
        } else {
            session()->setFlashdata('error', 'Data obat gagal diubah');
        }

        return redirect()->to('/obat');
    }

    public function deleteObat($id) {
        if ($this->obatModel->deleteObat($id)) {
            session()->setFlashdata('pesan', 'Data obat berhasil dihapus');
        } else {
            session()->setFlashdata('error', 'Data obat gagal dihapus');
        }

        return redirect()->to('/obat');
    }
}