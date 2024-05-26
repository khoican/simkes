<?php

namespace App\Models;

use CodeIgniter\Model;
use Michalsn\Uuid\UuidModel;

class Poli extends Model
{
    protected $table            = 'polis';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['nama', 'kode'];

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

    public function getAllPoli() {
        return $this->findAll();
    }

    public function getPoliById($id) {
        return $this->find($id);
    }

    public function getKodePoli($id) {
        return $this->find($id)['kode'];
    }

    public function getLastKodePoli() {
        $kode = $this->orderBy('id', 'DESC')->first();

        if ($kode) {
            return $kode['kode'];
        }   
    }

    public function generateKodePoli() {
        $lastKode = $this->getLastKodePoli();

        $kode = '';
        if ($lastKode == null) {
            $kode = 'A';
        } else {
            $kode = chr(ord($lastKode) + 1);
        }

        return $kode;
    }

    public function postPoli($data) {
        if ($this->insert($data) === false) {
            $error = $this->errors();
            log_message('error', print_r($error, true));
            return $error;
        }

        return $this->db->insertID();
    }

    public function editPoli($id, $data) {
        if ($this->update($id, $data) === false) {
            $error = $this->errors();
            log_message('error', print_r($error, true));
            return $error;
        }

        return $this->db->affectedRows();
    }

    public function deletePoli($id) {
        if ($this->delete($id) === false) {
            $error = $this->errors();
            log_message('error', print_r($error, true));
            return $error;
        }

        return $this->db->affectedRows();
    }

    public function kunjungan() {
        return $this->hasMany(Kunjungan::class, 'id', 'id_poli');
    }
}