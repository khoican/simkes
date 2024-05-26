<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Kunjungan;
use CodeIgniter\HTTP\ResponseInterface;

class DashboardController extends BaseController
{
    protected $kunjunganModel;

    public function __construct() {
        $this->kunjunganModel = new Kunjungan();
    }
    public function index()
    {
        $countKunjungan = $this->kunjunganModel->getCountKunjunganToday();
        return view('pages/dashboard', ['countKunjungan' => $countKunjungan]);
    }
}