<?php

namespace App\Models;

use CodeIgniter\Model;
use Michalsn\Uuid\UuidModel;

class Obat extends Model
{
    protected $table            = 'obats';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['kode', 'obat', 'jenis', 'bentuk', 'stok', 'harga'];

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
    protected $validationRules      = [
        'obat'           => "required",
        'jenis'          => "required",
        'bentuk'         => "required",
        'stok'           => "required",
        'harga'          => "required",
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

    public function getAllObat() {
        return $this->findAll();
    }

    public function getObatById($id) {
        return $this->find($id);
    }

    public function getLastKodeObat() {
        $kode = $this->orderBy('id', 'desc')->first();

        if($kode) {
            return $kode['kode'];
        }
    }

    public function generateKodeObat() {
        $lastKode = $this->getLastKodeObat();

        $newKode = '';
        if ($lastKode) {
            $letter = substr($lastKode, 0, 1);
            $number = substr($lastKode, 1, 2);
    
            if ($number < 99) {
                $number++;
            } else {
                $number = 1;
                $letter = chr(ord($letter) + 1);
            }
    
            $newKode = $letter.str_pad($number, 2, '0', STR_PAD_LEFT);
        } else {
            $newKode = 'A01';
        }
        return $newKode;
    }

    public function postObat($data) {
        if ($this->insert($data) === false) {
            $errors = $this->errors();
            log_message('error', print_r($errors, true));
            return $errors;
        }

        return $this->db->insertID();
    }

    public function updateObat($id, $data) {
        if ($this->update($id, $data) === false) {
            $errors = $this->errors();
            log_message('error', print_r($errors, true));
            return $errors;
        }

        return $this->db->affectedRows();
    }

    public function deleteObat($id) {
        if ($this->delete($id) === false) {
            $errors = $this->errors();
            log_message('error', print_r($errors, true));
            return $errors;
        }

        return $this->db->affectedRows();
    }
}