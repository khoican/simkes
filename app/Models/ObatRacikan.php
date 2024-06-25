<?php

namespace App\Models;

use CodeIgniter\Model;

class ObatRacikan extends Model
{
    protected $table            = 'obat_racikans';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['id_pasien', 'id_rekmed', 'signa', 'ket', 'jml_resep', 'jml_diberikan', 'status', 'satuan'];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected array $casts = [];
    protected array $castHandlers = [];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

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

    protected $detailObatRacikanModel;

    public function __construct()
    {
        parent::__construct();
        $this->detailObatRacikanModel = new \App\Models\DetailObatRacikan();
    }

    public function getTotalHargaObatRacikan($rekmedId) {
        $total = 0;
        $obatRacikan = $this->getObatRacikanByRekmedId($rekmedId);

        foreach ($obatRacikan as $racikan) {
            $detailObatRacikan = $this->detailObatRacikanModel->getDetailObatRacikanByObatRacikanId($racikan['id']);
            foreach ($detailObatRacikan as $item) {
                $total += intval($item['harga']);
            };
        }
        return $total;
    }

    public function getObatRacikanByRekmedId($rekmedId) {
        return $this->where('id_rekmed', $rekmedId)->findAll();
    }

    public function getObatRacikan($rekmedId) {
        $obatRacikan = $this->getObatRacikanByRekmedId($rekmedId);
        $data = [];

        foreach ($obatRacikan as $racikan) {
            $detailObatRacikan = $this->detailObatRacikanModel->getDetailObatRacikanByObatRacikanId($racikan['id']);
            $racikan['detail_obat'] = $detailObatRacikan;
            $data[] = $racikan;
        }

        return $data;
    }

    public function getObatRacikanById($id) {
        return $this->where('id', $id)->first();
    }

    public function postObatRacikan($data) {
        if (!$this->insert($data)) {
            $errors = $this->errors();
            log_message('error', print_r($errors, true));
            return $errors;
        }

        return $this->insertID();
    }

    public function deleteObatRacikan($id) {
        if ($this->delete($id) === false) {
            $errors = $this->errors();
            log_message('error', print_r($errors, true));
            return $errors;
        }

        return $this->db->affectedRows();
    }
}