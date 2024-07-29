<?php

namespace App\Models;

use CodeIgniter\Model;

class GeneralConcent extends Model
{
    protected $table            = 'general_consent';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['nama', 'umur', 'alamat', 'no_telp', 'status', 'id_pasien'];

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
    protected $validationRules      = [
        'nama'  => "permit_empty",
        'umur'  => "permit_empty",
        'alamat' => "permit_empty",
        'status' => "permit_empty",
        'id_pasien' => "permit_empty",
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

    public function getGeneralConsentByPasienId($id) {
        return $this->where('id_pasien', $id)->first();
    }

    public function getDataPasienByPasienId($id) {
        return $this->select([
                'pasiens.nama as nama_pasien',
                'alamats.alamat as alamat_pasien',
                'alamats.kelurahan as kelurahan_pasien',
                'alamats.kecamatan as kecamatan_pasien',
                'DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(), pasiens.tgl_lahir)), "%Y") + 0 AS usia_pasien',
                'general_consent_wali.nama as nama_wali',
                'general_consent_wali.umur as umur_wali',
                'general_consent_wali.alamat as alamat_wali',
                'general_consent_wali.no_telp as no_telp_wali',
                'general_consent_wali.status as status_wali',
                'general_consent_wali.created_at as created_at_wali'
            ])
            ->from('pasiens')
            ->join('alamats', 'alamats.id = pasiens.id_alamat', 'left')
            ->join('general_consent as general_consent_wali', 'general_consent_wali.id_pasien = pasiens.id', 'left')
            ->where('pasiens.id', $id)
            ->first();
    }

    public function postGeneralConsent($data) {
        if ($this->insert($data) == false) {
            $errors = $this->errors();
            log_message('error', print_r($errors, true));
            return $errors;
        };

        return $this->insertID();
    }
}