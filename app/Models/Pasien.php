<?php

namespace App\Models;

use CodeIgniter\Model;
use Michalsn\Uuid\UuidModel;

class Pasien extends Model
{
    protected $table            = 'pasiens';
    protected $primaryKey       = "id";
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['no_rekam_medis' ,'nik', 'no_bpjs', 'nama', 'jk', 'tmp_lahir', 'tgl_lahir', 'gol_darah', 'agama', 'pendidikan', 'pekerjaan','kpl_keluarga', 'pss_dlm_keluarga', 'pss_anak', 'telepon', 'telepon2', 'pembayaran', 'knjn_sehat', 'tkp', 'id_alamat'];

    protected bool $allowEmptyInserts = true;
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
    protected $validationRules = [
        'nik' => 'required',
        'no_bpjs' => 'permit_empty',
        'nama' => 'required',
        'jk' => 'required',
        'tmp_lahir' => 'required',
        'tgl_lahir' => 'required',
        'telepon' => 'required',
        'telepon2' => 'permit_empty',
        'pembayaran' => 'required',
        'knjn_sehat' => 'permit_empty',
        'tkp' => 'required',
        'pss_dlm_keluarga' => 'required',
        'pss_anak' => 'permit_empty',
        'kpl_keluarga' => 'required',
        'pekerjaan' => 'required',
        'pendidikan' => 'required',
        'agama' => 'required',
        'gol_darah' => 'permit_empty',
    ];
    protected $validationMessages   = [
        'nik' => [
            'required' => 'NIK harus diisi'
        ],
        'tkp' => [
            'required' => 'Tanda Kependudukan harus diisi'
        ],
        'pembayaran' => [
            'required' => 'Pembayaran harus diisi'
        ],
        'kpl_keluarga' => [
            'required' => 'Kepala Keluarga harus diisi'
        ],
        'pekerjaan' => [
            'required' => 'Pekerjaan harus diisi'
        ],
        'pendidikan' => [
            'required' => 'Pendidikan harus diisi'
        ],
        'agama' => [
            'required' => 'Agama harus diisi'
        ],
        'jk' => [
            'required' => 'Jenis Kelamin harus diisi'
        ],
        'tmp_lahir' => [
            'required' => 'Tempat Lahir harus diisi'
        ],
        'tgl_lahir' => [
            'required' => 'Tanggal Lahir harus diisi'
        ],
        'telepon' => [
            'required' => 'Telepon harus diisi'
        ],
        'pss_dlm_keluarga' => [
            'required' => 'Status Keluarga harus diisi'
        ],
        'knjn_sehat' => [
            'required' => 'Kesehatan harus diisi'
        ],
    ];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = ['addCreateAt'];
    protected $afterInsert    = [];
    protected $beforeUpdate   = ['addUpdateAt'];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];

    protected function addCreateAt(array $data) {
        $data['data']['created_at'] = date('Y-m-d H:i:s');
        $data['data']['updated_at'] = date('Y-m-d H:i:s');
        return $data;
    }

    protected function addUpdateAt(array $data) {
        $data['data']['updated_at'] = date('Y-m-d H:i:s');
        return $data;
    }

    public function getCountNewPasien() {
        return $this->db->table($this->table)->where('created_at', date('Y-m-d'))->countAllResults();
    }

    public function getAllPasien() {
        return $this->db->table($this->table)->select('pasiens.id as pasien_id, alamats.id as alamat_id, pasiens.*, alamats.*')->join('alamats', 'alamats.id = pasiens.id_alamat')->orderBy('pasiens.created_at', 'DESC')->get()->getResultArray();
    }

    public function getPasienById($id) {
        return $this->select('pasiens.*, alamats.*')
                    ->join('alamats', 'pasiens.id_alamat = alamats.id')
                    ->where('pasiens.id', $id)
                    ->first();
    }

    public function getLatestNoRekmed() {
        $norm = $this->orderBy('id', 'DESC')->first();

        if ($norm) {
            return $norm['no_rekam_medis'];
        }

        return null;
    }

    public function generateNoRekmed() {
        $norm = $this->getLatestNoRekmed();
        $defaultKode = '00000000';
        $newrm = '';
        if ($norm !== null) {
            $currentrm = substr($norm, -8);
            $newKode = intval($currentrm) + 1;
            $newrm = $defaultKode.'-'.str_pad($newKode, 8, '0', STR_PAD_LEFT);
        } else {
            $newrm = $defaultKode.'-00000001';
        };

        return $newrm;
    } 

    public function postPasien($data) {
        if ($this->insert($data)) {
            $response = $this->db->insertID();
            return $response;
        } 

        return false;
    }

    public function updatePasien($id, $data) {
       if($this->update( $id, $data)) {
           return 'success';
       } else {
           return [$this->errors(), $this->validationErrors()];
       }
    }

    public function kunjungan() {
        return $this->hasMany(Kunjungan::class, 'id', 'id_pasien');
    }

    public function alamat() {
        return $this->belongsTo(Alamat::class, 'id_alamat', 'id');
    }
}