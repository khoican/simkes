<?php

namespace App\Models;

use CodeIgniter\Model;

class DetailObatRacikan extends Model
{
    protected $table            = 'detail_obat_racikans';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['id_obat_racikan', 'id_obat'];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected array $casts = [];
    protected array $castHandlers = [];

    // Dates
    protected $useTimestamps = false;
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

    public function getDetailObatRacikanByObatRacikanId($obatRacikanId) {
        return $this->select('obats.obat, obats.id, (obats.harga * obat_racikans.jml_resep) AS harga')
                    ->join('obats', 'obats.id = detail_obat_racikans.id_obat')
                    ->join('obat_racikans', 'obat_racikans.id = detail_obat_racikans.id_obat_racikan')
                    ->where('detail_obat_racikans.id_obat_racikan', $obatRacikanId)
                    ->findAll();
    }

    public function getDetailObatRacikan($obatRacikanId) {
        return $this->select('detail_obat_racikans.*')->where('detail_obat_racikans.id_obat_racikan', $obatRacikanId)->findAll();
    }

    public function postDetailObatRacikan($data) {
        if($this->insert($data) == false) {
            $errors = $this->errors();
            log_message('error', print_r($errors, true));
            return $errors;
        }

        return $this->db->insertID();
    }

    public function deleteDetailObatRacikan($id) {
        if($this->delete($id) == false) {
            $errors = $this->errors();
            log_message('error', print_r($errors, true));
            return $errors;
        }

        return $this->db->affectedRows();
    }
}