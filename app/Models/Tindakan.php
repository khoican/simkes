<?php

namespace App\Models;

use CodeIgniter\Model;

class Tindakan extends Model
{
    protected $table            = 'tindakans';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['kode', 'tindakan'];

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
        'tindakan' => 'required',
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

    public function getAllTindakan() {
        return $this->findAll();
    }

    public function getMostTindakanPasien() {
        return $this->select('COUNT(tindakan_pasiens.id_tindakan) as total, tindakan, kode')->join('tindakan_pasiens', 'tindakan_pasiens.id_tindakan = tindakans.id')->groupBy('id_tindakan')->orderBy('total', 'DESC')->limit(10)->findAll();
    }

    public function getMostTindakanPasienByDate($from, $to) {
        return $this->select('COUNT(tindakan_pasiens.id_tindakan) as total, tindakans.tindakan, tindakans.kode')
                ->join('tindakan_pasiens', 'tindakan_pasiens.id_tindakan = tindakans.id')
                ->where('DATE(tindakan_pasiens.created_at) >=', $from)
                ->where('DATE(tindakan_pasiens.created_at) <=', $to)
                ->groupBy('tindakan_pasiens.id_tindakan, tindakans.tindakan, tindakans.kode')
                ->orderBy('total', 'DESC')
                ->limit(10)
                ->findAll();
    }

    public function getTindakanById($id) {
        return $this->where('id', $id)->first();
    }

    public function getLastKodeTindakan() {
        $kode = $this->orderBy('id', 'desc')->first();

        if ($kode) {
            return $kode['kode'];
        }
    }

    public function generateKodeTindakan() {
        $lastKode = $this->getLastKodeTindakan();

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

    public function postTindakan($data) {
        if($this->insert($data) == false) {
            $errors = $this->errors();
            log_message('error', print_r($errors, true));
            return $errors;
        }

        return $this->db->insertID();
    }

    public function editTindakan($id, $data) {
        if($this->update($id, $data) == false) {
            $errors = $this->errors();
            log_message('error', print_r($errors, true));
            return $errors;
        }

        return $this->db->affectedRows();
    }

    public function deleteTindakan($id) {
        if($this->delete($id) == false) {
            $errors = $this->errors();
            log_message('error', print_r($errors, true));
            return $errors;
        }

        return $this->db->affectedRows();
    }
}