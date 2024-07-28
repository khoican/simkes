<?php

namespace App\Models;

use CodeIgniter\Model;

class TindakanPasien extends Model
{
    protected $table            = 'tindakan_pasiens';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['id_pasien', 'id_tindakan', 'id_rekmed'];

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
    protected $validationRules      = [];
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

    public function getMostTindakanPasien() {
        return $this->select('tindakans.tindakan, COUNT(tindakan_pasiens.id_pasien) as total')
                    ->join('tindakans', 'tindakan_pasiens.id_tindakan = tindakans.id')
                    ->groupBy('tindakans.tindakan')
                    ->orderBy('total', 'DESC')
                    ->limit(10)
                    ->findAll();
    }

    public function postTindakanPasien($data) {
        if ($this->insert($data) === false) {
            $errors = $this->errors();
            log_message('error', print_r($errors, true));
            return $errors;
        }
        return $this->db->insertID();
    }

    public function getTindakanByRekmedId($rekmedId) {
        return $this->where('id_rekmed', $rekmedId)->select('tindakans.tindakan, tindakan_pasiens.*')->join('tindakans', 'tindakan_pasiens.id_tindakan = tindakans.id')->findAll();
    }

    public function deleteTindakanPasienByRekmedId($rekmedId) {
        $this->where('id_rekmed', $rekmedId)->set('id_tindakan', null)->set('id_pasien', null)->delete();
        return $this->where('id_rekmed', $rekmedId)->delete();
    }
}