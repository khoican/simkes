<?php

namespace App\Models;

use CodeIgniter\Model;

class RekmedHistory extends Model
{
    protected $table            = 'rekmed_history';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['id_rekmed', 'datang', 'pulang'];

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

    public function postRekmedHistory($data) {
        if ($this->insert( $data ) === false) {
            $errors = $this->errors();
            log_message('error', print_r($errors, true));
            return $errors;
        }

        return $this->getInsertID();
    }

    public function editRekmedHistory($id, $data) {
        if ($this->where('id_kunjungan', $id)->set($data)->update() === false) {
            $errors = $this->errors();
            log_message('error', print_r($errors, true));
            return $errors;
        }

        return $this->db->affectedRows();
    }
}