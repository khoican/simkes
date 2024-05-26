<?php

namespace App\Models;

use CodeIgniter\Model;
use Michalsn\Uuid\UuidModel;

class User extends Model
{
    protected $table            = 'users';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['username', 'password', 'role', 'nama'];

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
        'nama'               => "required",
        'username'           => "required|min_length[1]",
        'password'           => "required|min_length[1]",
        'role'               => "required",
    ];
    protected $validationMessages   = [
        'username' => [
            'required' => 'Username Wajib Diisi'
        ],
        'password' => [
            'required' => 'Password Wajib Diisi'
        ],
        'role' => [
            'required' => 'Role Wajib Diisi'
        ],
        'nama' => [
            'required' => 'Nama Wajib Diisi'
        ],
    ];
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

    public function getAllUser() {
        return $this->findAll();
    }

    public function getUserById($id) {
        return $this->find($id);
    }

    public function usernameExists($username) {
        if ($this->where('username', $username)->countAllResults() > 0) {
            return $this->where('username', $username)->first();
        }
    }

    public function postUser($data) {
        if ($this->insert($data) == false) {
            $error = $this->errors();
            log_message('error', print_r($error, true));
            return $error;
        }

        return $this->insertID();
    }

    public function editUser($id, $data) {
        if ($this->update($id, $data) == false) {
            $error = $this->errors();
            log_message('error', print_r($error, true));
            return $error;
        }

        return $this->db->affectedRows();
    }

    public function deleteUser($id) {
        if ($this->delete($id) == false) {
            $error = $this->errors();
            log_message('error', print_r($error, true));
            return $error;
        }

        return $this->db->affectedRows();
    }

}