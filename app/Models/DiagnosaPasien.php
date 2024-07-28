<?php

namespace App\Models;

use CodeIgniter\Model;

class DiagnosaPasien extends Model
{
    protected $table            = 'diagnosa_pasiens';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['id_pasien', 'id_diagnosa', 'id_rekmed', 'status'];

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
        'id_pasien' => 'required',
        'id_diagnosa' => 'required',
        'id_rekmed' => 'required',
    ];
    protected $validationMessages   = [];
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

    public function getMostDiagnosaPasien() {
        return $this->select('COUNT(id_diagnosa) as total, diagnosas.diagnosa')->join('diagnosas', 'diagnosa_pasiens.id_diagnosa = diagnosas.id')->groupBy('diagnosa')->orderBy('total', 'DESC')->limit(10)->findAll();
    }

    public function getDiagnosaByRekmedId($rekmedId) {
        return $this->where('id_rekmed', $rekmedId)->select('diagnosas.diagnosa, diagnosas.kode, diagnosa_pasiens.*')->join('diagnosas', 'diagnosa_pasiens.id_diagnosa = diagnosas.id')->findAll();
    }

    public function postDiagnosaPasien($data) {
        if ($this->insert($data) === false) {
            $errors = $this->errors();
            log_message('error', print_r($errors, true));
            return $errors;
        }
        return $this->db->insertID();
    }

    public function deleteDiagnosaPasienByRekmedId($rekmedId) {
        $this->where('id_rekmed', $rekmedId)->set('id_pasien', null)->set('id_diagnosa', null)->update();
        return $this->where('id_rekmed', $rekmedId)->delete();
    }
}