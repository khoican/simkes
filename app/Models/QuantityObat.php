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
        $result = $this->db->table('quantity_obats')
                        ->select('SUM(masuk) as total')
                        ->where('DATE(created_at)', date('Y-m-d'))
                        ->get()
                        ->getRowArray();
        return $result ? $result['total'] : '0';
    }

    public function getCountQuantityObatKeluar() {
        $result = $this->db->table('quantity_obats')
                        ->select('SUM(keluar) as total')
                        ->where('DATE(created_at)', date('Y-m-d'))
                        ->get()
                        ->getRowArray();
        return $result ? $result['total'] : '0';
    }

    public function getQuantityObat() {
        return $this->db->table('quantity_obats')
                        ->select('obats.id, obats.obat, obats.stok, SUM(quantity_obats.masuk) as masuk, SUM(quantity_obats.keluar) as keluar')
                        ->join('obats', 'obats.id = quantity_obats.id_obat')
                        ->groupBy('quantity_obats.id_obat, obats.id, obats.obat, obats.stok')
                        ->get()
                        ->getResultArray();
    }

    public function getQuantityObatByDate($from, $to) {
        return $this->select('obats.id, obats.obat, obats.kode, obats.stok, 
                             COALESCE(SUM(quantity_obats.masuk), 0) as masuk, COALESCE(SUM(quantity_obats.keluar), 0) as keluar')
                    ->join('obats', 'obats.id = quantity_obats.id_obat', 'left')
                    ->where('DATE(quantity_obats.created_at) >=', $from)
                    ->where('DATE(quantity_obats.created_at) <=', $to)
                    ->groupBy('quantity_obats.id_obat, obats.id, obats.obat, obats.kode, obats.stok')
                    ->orderBy('obats.kode', 'ASC')
                    ->findAll();
    }

    public function getQuantityObatByObatId($obatId, $qty) {
        return $this->where('id_obat', $obatId)->where('keluar', $qty)->first();
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