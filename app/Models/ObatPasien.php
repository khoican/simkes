<?php

namespace App\Models;

use CodeIgniter\Model;

class ObatPasien extends Model
{
    protected $table            = 'obat_pasien';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['id_pasien', 'id_obat', 'id_rekmed', 'qty', 'status'];

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
        'id_pasien' => 'required',
        'id_obat' => 'required',
        'id_rekmed' => 'required',
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

    public function postObatPasien ($data) {
        if ($this->insert($data) === false) {
            $errors = $this->errors();
            log_message('error', print_r($errors, true));
            return $errors;
        }
        return $this->db->insertID();
    }

    public function getObatPasienById ($id) {
        return $this->where('id', $id)->select('obat_pasien.*, obats.obat, obats.stok, obats.harga')->join('obats', 'obat_pasien.id_obat = obats.id')->first();
    }

    public function getObatPasienByRekmedId ($rekmedId) {
        return $this->where('id_rekmed', $rekmedId)->select('obat_pasien.*, obats.obat, obats.stok, obats.harga')->join('obats', 'obat_pasien.id_obat = obats.id')->findAll();
    }

    public function deleteObatPasienByRekmedId ($rekmedId) {
        $this->where('id_rekmed', $rekmedId)->set('id_obat', null)->set('id_pasien', null)->update();
        return $this->where('id_rekmed', $rekmedId)->delete();
    }

    public function updateObatPasien ($id, $data) {
        if ($this->update($id, $data) === false) {
            $errors = $this->errors();
            log_message('error', print_r($errors, true));
            return $errors;
        }
        return $this->db->affectedRows();
    }

    public function getTotalHargaByRekmedId ($rekmedId) {
        $total = 0;
        $obats = $this->getObatPasienByRekmedId($rekmedId);

        foreach($obats as $obat) {
            if ($obat['status'] == 'sudah') {
                $total += $obat['qty'] * $obat['harga'];
            }
        }
        return format_numerik($total);

    }

    public function pasien () {
        return $this->belongsTo(Pasien::class, 'id_pasien', 'id');
    } 

    public function rekmed  () {
        return $this->belongsTo(Rekmed::class, 'id_rekmed', 'id');
    }

    public function obat () {
        return $this->belongsTo(Obat::class, 'id_obat', 'id');
    }
}