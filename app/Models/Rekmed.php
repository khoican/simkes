<?php

namespace App\Models;

use CodeIgniter\Model;
use Michalsn\Uuid\UuidModel;

class Rekmed extends Model
{
    protected $table            = 'rekmeds';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['alergi_makanan', 'alergi_obat', 'rwt_pykt_terdahulu', 'rwt_pengobatan', 'rwt_pykt_keluarga', 'keluhan', 'hgb_dgn_keluarga', 'sts_psikologi', 'keadaan', 'kesadaran', 'bb', 'tb', 'imt', 'sistole', 'diastole', 'nadi', 'rr', 'suhu', 'skala_nyeri', 'frek_nyeri', 'lama_nyeri', 'menjalar', 'menjalar_ket', 'kualitas_nyeri', 'fakt_pemicu', 'fakt_pengurang',  'lokasi_nyeri', 'status', 'id_pasien', 'id_poli'];

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
        'alergi_makanan'  => "permit_empty",
        'alergi_obat'     => "permit_empty",
        'rwt_pykt_terdahulu' => "permit_empty",
        'rwt_pengobatan'  => "permit_empty",
        'rwt_pykt_keluarga' => "permit_empty",
        'keluhan'         => "permit_empty",
        'hbg_dgn_keluarga' => "permit_empty",
        'sts_psikologi'   => "permit_empty",
        'keadaan'         => "permit_empty",
        'kesadaran'       => "permit_empty",
        'tb'              => "permit_empty",
        'bb'              => "permit_empty",
        'imt'             => "permit_empty",
        'sistole'         => "permit_empty",
        'diastole'        => "permit_empty",
        'nadi'            => "permit_empty",
        'rr'              => "permit_empty",
        'suhu'            => "permit_empty",
        'skala_nyeri'     => "permit_empty",
        'frek_nyeri'      => "permit_empty",
        'lama_nyeri'      => "permit_empty",
        'menjalar'        => "permit_empty",
        'menjalar_ket'    => "permit_empty",
        'kualitas_nyeri'  => "permit_empty",
        'fakt_pemicu'     => "permit_empty",
        'fakt_pengurang'  => "permit_empty",
        'lokasi_nyeri'    => "permit_empty",
        'id_pasien'       => "required",
        'id_poli'         => "required",
    ];
    protected $validationMessages   = [
        'keluhan'         => [
            'required' => 'Keluhan harus diisi.'
        ],
        'hbg_dgn_keluarga' => [
            'required' => 'HGB Dgn Keluarga harus diisi.'
        ],
        'sts_psikologi'   => [
            'required' => 'Status Psikologi harus diisi.'
        ],
        'keadaan'         => [
            'required' => 'Keadaan harus diisi.'
        ],
        'kesadaran'       => [
            'required' => 'Kesadaran harus diisi.'
        ],
        'id_poli'         => [
            'required' => 'Poli harus diisi.'
        ],
    ];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];

    public function getAllRekmed() {
        return $this->findAll();
    }

    public function getRekmedById($id) {
        return $this->where('rekmeds.id', $id)->select('rekmeds.*, polis.nama as poli, pasiens.pekerjaan as pekerjaan_pasien')->join('polis', 'polis.id = rekmeds.id_poli')->join('pasiens', 'pasiens.id = rekmeds.id_pasien')->first();
    }

    public function getRekmedByPasienId($id) {
        return $this->where('rekmeds.id_pasien', $id)->select('polis.nama as poli, rekmeds.*, kunjungans.created_at as created_at, kunjungans.updated_at as updated_at, kunjungans.status as status_kunjungan')->join('polis', 'polis.id = rekmeds.id_poli')->join('kunjungans', 'kunjungans.id_rekmed = rekmeds.id')->orderBy('rekmeds.id', 'DESC')->findAll();
    }

    public function getRekmedStatus($id) {
        $status = $this->where('id', $id)->first();
        return $status['status'];
    }

    public function getLatestRekmedByPasienId($id) {
        return $this->where('id_pasien', $id)->select('rekmeds.*')->first();
    }

    public function postRekmed($data) {
        if ($this->insert($data) === false) {
            $errors = $this->errors();
            log_message('error', print_r($errors, true));
            return $errors;
        }
        return $this->db->insertID();
    }

    public function editRekmed($id, $data) {
        if ($this->update($id, $data) === false) {
            $errors = $this->errors();
            log_message('error', print_r($errors, true));
            return $errors;
        }
        return $this->db->affectedRows();
    }

    public function deleteRekmed($id) {
        if ($this->delete($id) === false) {
            $errors = $this->errors();
            log_message('error', print_r($errors, true));
            return $errors;
        }
        return $this->db->affectedRows();
    }

    public function pasien() {
        return $this->belongsTo(Pasien::class, 'id_pasien', 'id');
    }

    public function poli() {
        return $this->belongsTo(Poli::class, 'id_poli', 'id');
    }
}