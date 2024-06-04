<?php

namespace App\Models;

use CodeIgniter\Model;

class KunjunganHistory extends Model
{
    protected $table            = 'kunjungan_history';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['no_antrian', 'id_poli', 'status'];

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

    public function postKunjunganHistory($data) {
        if ($this->insert($data) == false) {
            $error = $this->errors();
            log_message('error', print_r($error, true));
            return $error;
        }

        return true;
    }

    public function getKunjunganHstoryByPoli($id, $status) {
        $kunjungans = $this->select('kunjungan_history.*, polis.*')->where('id_poli', $id)->where('status', $status)->where('DATE(created_at)', date('Y-m-d'))->join('polis', 'kunjungan_history.id_poli = polis.id')->orderBy('created_at', 'DESC')->first();
        if ($kunjungans) {
            return $kunjungans;
        }
        return null;
    }
}