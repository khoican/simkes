<?php

namespace App\Models;

use CodeIgniter\Model;
use Michalsn\Uuid\UuidModel;

class Kunjungan extends Model
{
    protected $table            = 'kunjungans';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['no_antrian', 'id_pasien', 'id_poli', 'panggil', 'status'];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected array $casts = [];
    protected array $castHandlers = [];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [
        'no_antrian' => 'permit_empty|',
        'id_pasien' => 'permit_empty',
        'id_poli' => 'permit_empty',
        'panggil' => 'permit_empty',
        'status' => 'permit_empty',
    ];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = ['addCreateAt'];
    protected $afterInsert    = [];
    protected $beforeUpdate   = ['addUpdateAt'];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];
    
    protected function addCreateAt(array $data) {
        $data['data']['created_at'] = date('Y-m-d H:i:s');
        $data['data']['updated_at'] = date('Y-m-d H:i:s');
        return $data;
    }

    protected function addUpdateAt(array $data) {
        $data['data']['updated_at'] = date('Y-m-d H:i:s');
        return $data;
    }

    protected function getLastAntrian($poli) {
        $today = date('Y-m-d');
        $data = $this->where('id_poli', $poli)
                 ->like('created_at', $today, 'after')
                 ->orderBy('no_antrian', 'DESC')
                 ->first();
    return $data;
    }

    public function generateAntrian($poli) {
        $poliModel = new Poli();
        $kodePoli = $poliModel->getKodePoli($poli);
        $latestAntrian = $this->getLastAntrian($poli);
        
        if (!$latestAntrian) {
            $nomorAntrian = 1;
        } else {
            $getNumber = substr($latestAntrian['no_antrian'], 1);
            $nomorAntrian = $getNumber + 1;
        }

        $formatAntrian = $kodePoli.str_pad($nomorAntrian, 2, '0', STR_PAD_LEFT);
        return $formatAntrian;
    }

    public function getPasienId($id) {
        return $this->where('id', $id)->select('id_pasien')->first();
    }

    public function getPoliId($id) {
        return $this->where('id', $id)->select('id_poli')->first();
    }

    public function getKunjunganByStatus($status) {
        $today = date('Y-m-d');
        return $this->where('status', $status)->where('DATE(kunjungans.created_at)', $today)->select('kunjungans.*, pasiens.*, pasiens.nama as nama_pasien, polis.*, alamats.*, kunjungans.id as id_kunjungan')->join('pasiens', 'pasiens.id = kunjungans.id_pasien')->join('polis', 'polis.id = kunjungans.id_poli')->join('alamats', 'alamats.id = pasiens.id_alamat')->get()->getResultArray();
    }

    public function getKunjunganByPasienId($id) {
        return $this->where('id_pasien', $id)->select('kunjungans.id as id_kunjungan, kunjungans.no_antrian as no_antrian, kunjungans.created_at as created_at, kunjungans.status as status, pasiens.nama as nama_pasien, pasiens.no_rekam_medis as no_rekam_medis, pasiens.nik as nik, pasiens.no_bpjs as no_bpjs, pasiens.tgl_lahir as tgl_lahir, pasiens.agama as agama, pasiens.gol_darah as gol_darah, polis.nama as nama_poli')->join('pasiens', 'pasiens.id = kunjungans.id_pasien')->select('TIMESTAMPDIFF(YEAR, pasiens.tgl_lahir, CURDATE()) AS usia')->join('polis', 'polis.id = kunjungans.id_poli')->first();
    }

    public function getKunjunganById($id) {
        return $this->where('kunjungans.id', $id)->select('kunjungans.*, pasiens.pekerjaan as pekerjaan_pasien')->join('pasiens', 'pasiens.id = kunjungans.id_pasien')->first();
    }

    public function getCountKunjunganToday() {
        return $this->where('DATE(kunjungans.created_at)', date('Y-m-d'))->countAllResults();
    }

    public function postKunjungan($data) {
        if ($this->insert($data)) {
            return true;
        } else {
            return false;
        }
        
    }

    public function updateKunjungan($id, $data) {
        if ($this->update($id, $data)) {
            return true;
        } else {
            return false;
        }
    }

    public function pasien() {
        return $this->belongsTo(Pasien::class, 'id_pasien', 'id');
    }

    public function poli() {
        return $this->belongsTo(Poli::class, 'id_poli', 'id');
    }
}