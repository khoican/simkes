<?php

namespace App\Models;

use CodeIgniter\Model;

class Diagnosa extends Model
{
    protected $table            = 'diagnosas';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['kode', 'diagnosa'];

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
        'diagnosa' => 'required',
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

    public function getAllDiagnosa() {
        return $this->findAll();
    }

    public function getDiagnosaById($id) {
        return $this->where('id', $id)->first();
    }

    public function getMostDiagnosaPasien() {
        return $this->select('COUNT(diagnosa_pasiens.id_diagnosa) as total, diagnosa, kode')->join('diagnosa_pasiens', 'diagnosa_pasiens.id_diagnosa = diagnosas.id')->groupBy('id_diagnosa')->orderBy('total', 'DESC')->limit(10)->findAll();
    }

    public function getMostDiagnosaPasienByDate($from, $to) {
        return $this->select('COUNT(diagnosa_pasiens.id_diagnosa) as total, diagnosas.diagnosa, diagnosas.kode')
                ->join('diagnosa_pasiens', 'diagnosa_pasiens.id_diagnosa = diagnosas.id')
                ->where('DATE(diagnosa_pasiens.created_at) >=', $from)
                ->where('DATE(diagnosa_pasiens.created_at) <=', $to)
                ->groupBy('diagnosa_pasiens.id_diagnosa, diagnosas.diagnosa, diagnosas.kode')
                ->orderBy('total', 'DESC')
                ->limit(10)
                ->findAll();
    }

    public function getLastKodeDiagnosa() {
        $kode = $this->orderBy('id', 'desc')->first();

        if ($kode) {
            return $kode['kode'];
        }
    }

    public function generateKodeDiagnosa() {
        $lastKode = $this->getLastKodeDiagnosa();

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
        } else {{
            $newKode = 'A01';
        }}
        return $newKode;
    }

    public function postDiagnosa($data) {
        if ($this->insert($data) == false) {
            $errors = $this->errors();
            log_message('error', print_r($errors, true));
            return $errors;
        }
        return $this->db->insertID();
    }

    public function editDiagnosa($id, $data) {
        if ($this->update($id, $data) == false) {
            $errors = $this->errors();
            log_message('error', print_r($errors, true));
            return $errors;
        }
        return $this->db->affectedRows();
    }

    public function deleteDiagnosa($id) {
        if ($this->delete($id) == false) {
            $errors = $this->errors();
            log_message('error', print_r($errors, true));
            return $errors;
        }
        return $this->db->affectedRows();
    }
}