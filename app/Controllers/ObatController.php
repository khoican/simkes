<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Obat;
use App\Models\QuantityObat;
use CodeIgniter\HTTP\ResponseInterface;

class ObatController extends BaseController
{
    protected $obatModel;
    protected $quantityObatModel;

    public function __construct()
    {
        $this->obatModel = new Obat();
        $this->quantityObatModel = new QuantityObat();
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
            'kode' => $this->request->getPost('kode'),
            'obat' => $this->request->getPost('obat'),
            'jenis' => $this->request->getPost('jenis'),
            'bentuk' => $this->request->getPost('bentuk'),
            'stok' => $this->request->getPost('stok'),
            'harga' => $this->request->getPost('harga'),
        ];
        
        $ObatId = $this->obatModel->postObat($data);
        if ($ObatId) {
            $dataStok = [
                'id_obat' => $ObatId,
                'masuk' => $this->request->getPost('stok'),
            ];

            $this->quantityObatModel->postQuantityObat($dataStok);

            session()->setFlashdata('pesan', 'Data obat berhasil ditambahkan');
        } else {
            session()->setFlashdata('error', 'Data obat gagal ditambahkan');
        }

        return redirect()->to('/obat');
    }

    public function editObat($id) {
        $data = [
            'kode' => $this->request->getPost('kode'),
            'obat' => $this->request->getPost('obat'),
            'jenis' => $this->request->getPost('jenis'),
            'bentuk' => $this->request->getPost('bentuk'),
            'harga' => $this->request->getPost('harga'),
        ];

        if ($this->obatModel->updateObat($id, $data)) {
            session()->setFlashdata('pesan', 'Data obat berhasil diubah');
        } else {
            session()->setFlashdata('error', 'Data obat gagal diubah');
        }

        return redirect()->to('/obat');
    }

    public function updateStok($id) {
        $obat = $this->obatModel->getObatById($id);

        $data = [
            'stok' => intval($obat['stok']) + intval($this->request->getPost('qty-masuk')),
        ];

        if ($this->obatModel->updateObat($id, $data)) {
            $updateStok = [
                'id_obat' => $id,
                'masuk' => $this->request->getPost('qty-masuk'),
            ];

            $this->quantityObatModel->postQuantityObat($updateStok);

            session()->setFlashdata('pesan', 'Stok obat berhasil ditambah');
        } else {
            session()->setFlashdata('error', 'Stok obat gagal diubah');
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