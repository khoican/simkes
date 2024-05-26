<?php

namespace App\Models;

use CodeIgniter\Model;
use Michalsn\Uuid\UuidModel;

class Alamat extends Model
{
    protected $table            = 'alamats';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['alamat', 'rt', 'rw', 'kelurahan', 'kecamatan', 'kota'];

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
        'alamat'       => [
            'rules' => "required|min_length[1]|max_length[255]",
            'errors' => [
                'required'   => 'Alamat harus diisi',
                'min_length' => 'Minimal 1 karakter',
                'max_length' => 'Maksimal 255 karakter',
            ]
        ],
        'rt'           => [
            'rules' => "required|min_length[1]|max_length[3]|numeric",
            'errors' => [
                'required'   => 'RT harus diisi',
                'min_length' => 'Minimal 1 karakter',
                'max_length' => 'Maksimal 3 karakter',
                'numeric'    => 'Harus berupa angka',
            ]
        ],
        'rw'           => [
            'rules' => "required|min_length[1]|max_length[3]|numeric",
            'errors' => [
                'required'   => 'RW harus diisi',
                'min_length' => 'Minimal 1 karakter',
                'max_length' => 'Maksimal 3 karakter',
                'numeric'    => 'Harus berupa angka',
            ]
        ],
        'kelurahan'    => [
            'rules' => "required|min_length[1]|max_length[255]",
            'errors' => [
                'required'   => 'Kelurahan harus diisi',
                'min_length' => 'Minimal 1 karakter',
                'max_length' => 'Maksimal 255 karakter',
            ]
        ],
        'kecamatan'    => [
            'rules' => "required|min_length[1]|max_length[255]",
            'errors' => [
                'required'   => 'Kecamatan harus diisi',
                'min_length' => 'Minimal 1 karakter',
                'max_length' => 'Maksimal 255 karakter',
            ]
        ],
        'kota'         => [
            'rules' => "required|min_length[1]|max_length[255]",
            'errors' => [
                'required'   => 'Kota harus diisi',
                'min_length' => 'Minimal 1 karakter',
                'max_length' => 'Maksimal 255 karakter',
            ]
        ],
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

    public function getAllAlamat() {
        return $this->findAll();
    }

    public function getAlamatById($id) {
        return $this->find($id);
    }

    public function postAlamat($data) {
        if (!$this->validate($data)) {
            return $this->validator->error();
        }

        if ($this->insert($data)) {
            return $this->db->insertID();
        } 
    }

    public function updateAlamat($id, $data) {
        if (!$this->validate($data)) {
            return $this->validator->error();
        }

        if($this->update($id, $data)) {
            return true;
        }
    }

    public function pasien() {
        return $this->hasOne(Pasien::class, 'id', 'id_alamat');
    }

}