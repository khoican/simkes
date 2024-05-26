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
    protected $allowedFields    = ['alergi_makanan', 'alergi_obat', 'rwt_pykt_terdahulu', 'rwt_pengobatan', 'rwt_pykt_keluarga', 'keluhan', 'hgb_dgn_keluarga', 'sts_psikologi', 'keadaan', 'kesadaran', 'status', 'id_pasien', 'id_poli'];

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
        'keluhan'         => "required",
        'hbg_dgn_keluarga' => "required",
        'sts_psikologi'   => "required",
        'keadaan'         => "required",
        'kesadaran'       => "required",
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
        return $this->where('id_pasien', $id)->select('polis.nama as poli, rekmeds.*')->join('polis', 'polis.id = rekmeds.id_poli')->orderBy('rekmeds.id', 'DESC')->findAll();
    }

    public function getRekmedStatus($id) {
        $status = $this->where('id', $id)->first();
        return $status['status'];
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