<?php

namespace App\Models;

use CodeIgniter\Model;

class QuantityObat extends Model
{
    protected $table            = 'quantity_obats';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['id_obat', 'masuk', 'keluar'];

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

    public function getCountQuantityObatMasuk() {
        return $this->select('SUM(masuk) as total')->where('created_at', date('Y-m-d'))->get()->getRow('total');
    }

    public function getCountQuantityObatKeluar() {
        return $this->select('SUM(keluar) as total')->where('created_at', date('Y-m-d'))->get()->getRow('total');
    }

    public function getQuantityObat() {
    return $this->db->table('quantity_obats')
                    ->select('obats.id, obats.obat, obats.stok, SUM(quantity_obats.masuk) as masuk, SUM(quantity_obats.keluar) as keluar')
                    ->join('obats', 'obats.id = quantity_obats.id_obat')
                    ->groupBy('quantity_obats.id_obat, obats.id, obats.obat, obats.stok')
                    ->get()
                    ->getResultArray();
    }


    public function postQuantityObat($data) {
        if ($this->insert($data) === false) {
            $errors = $this->errors();
            log_message('error', print_r($errors, true));
            return $errors;
        }
        return $this->db->insertID();
    }

    public function deleteQuantityObat($id) {
        if ($this->delete($id) === false) {
            $errors = $this->errors();
            log_message('error', print_r($errors, true));
            return $errors;
        }
        return true;
    }
}