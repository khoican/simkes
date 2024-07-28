<?php

namespace App\Models;

use CodeIgniter\Model;
use Michalsn\Uuid\UuidModel;

class Kunjungan extends Model
{
    protected $table            = 'kunjungans';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['no_antrian', 'id_pasien', 'id_poli', 'panggil', 'id_rekmed', 'status'];

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
        'no_antrian' => 'permit_empty|',
        'id_pasien' => 'permit_empty',
        'id_poli' => 'permit_empty',
        'panggil' => 'permit_empty',
        'status' => 'permit_empty',
    ];
    protected $validationMessages   = [];
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

    public function calculateServiceTime() {
        $db = db_connect();
        $builder = $db->table($this->table);

        $builder->select('created_at, updated_at');
        $builder->where('status', 'selesai');
        $builder->where('DATE(created_at)', date('Y-m-d'));
        $results = $builder->get()->getResult();

        if (empty($results)) {
            log_message('error', 'No results found for status=selesai');
            return [
                'under' => 0,
                'over' => 0,
            ];
        }

        $under = 0;
        $over = 0;

        foreach ($results as $row) {
            $createdAt = strtotime($row->created_at);
            $updatedAt = strtotime($row->updated_at);

            if ($createdAt === false || $updatedAt === false) {
                log_message('error', 'Error parsing date: created_at=' . $row->created_at . ', updated_at=' . $row->updated_at);
                continue;
            }

            $diffSecond = $updatedAt - $createdAt;

            log_message('info', 'Time difference in seconds: ' . $diffSecond);

            $diffHour = $diffSecond / 3600;

            if ($diffHour <= 1) {
                $under++;
            } else {
                $over++;
            }
        }

        return [
            'under' => $under,
            'over' => $over,
        ];
    }

    public function getLastAntrian($poli) {
        $today = date('Y-m-d');
        $data = $this->where('id_poli', $poli)
                 ->like('created_at', $today, 'after')
                 ->orderBy('no_antrian', 'DESC')
                 ->first();
    return $data;
    }

    public function generateAntrian($poli) {
        $poliModel = new Poli();
        $kodePoli = $poliModel->getKodePoli($poli);
        $latestAntrian = $this->getLastAntrian($poli);
        
        if (!$latestAntrian) {
            $nomorAntrian = 1;
        } else {
            $getNumber = substr($latestAntrian['no_antrian'], 1);
            $nomorAntrian = $getNumber + 1;
        }

        $formatAntrian = $kodePoli.str_pad($nomorAntrian, 2, '0', STR_PAD_LEFT);
        return $formatAntrian;
    }

    public function getPasienId($id) {
        return $this->where('id', $id)->select('id_pasien')->first();
    }

    public function getPoliId($id) {
        return $this->where('id', $id)->select('id_poli')->first();
    }

    public function getAllKunjungan() {
    $today = date('Y-m-d');
    return $this->select('kunjungans.*, pasiens.*, pasiens.nama as nama_pasien, polis.*, alamats.*, kunjungans.id as id_kunjungan')
                ->join('pasiens', 'pasiens.id = kunjungans.id_pasien')
                ->join('polis', 'polis.id = kunjungans.id_poli')
                ->join('alamats', 'alamats.id = pasiens.id_alamat')
                ->where('DATE(kunjungans.created_at)', $today)
                ->findAll();
    }

    public function getKunjunganByDate($from, $to) {
        $today = date('Y-m-d');
    
        $sql = '
            SELECT 
                kunjungans.id AS id_kunjungan,
                kunjungans.created_at AS kunjungan_created_at,
                pasiens.no_rekam_medis AS no_rekam_medis,
                pasiens.id AS id_pasien,
                pasiens.no_bpjs AS no_bpjs,
                pasiens.nik AS nik,
                pasiens.tgl_lahir AS pasien_tgl_lahir,
                pasiens.nama AS nama,
                pasiens.jk AS jk,
                DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(), pasiens.tgl_lahir)), "%Y") + 0 AS usia,
                pasiens.created_at AS pasien_created_at,
                polis.id AS id_poli,
                polis.nama AS nama_poli,
                alamats.id AS id_alamat,
                alamats.alamat AS alamat,
                alamats.kelurahan AS kelurahan,
                alamats.kecamatan AS kecamatan,
                CASE 
                    WHEN DATE(pasiens.created_at) = DATE(?) THEN "baru" 
                    WHEN DATE(pasiens.created_at) < DATE(?) THEN "lama" 
                END AS status
            FROM kunjungans
            LEFT JOIN pasiens ON pasiens.id = kunjungans.id_pasien
            LEFT JOIN polis ON polis.id = kunjungans.id_poli
            LEFT JOIN alamats ON alamats.id = pasiens.id_alamat
            WHERE DATE(kunjungans.created_at) >= ?
            AND DATE(kunjungans.created_at) <= ?
            GROUP BY kunjungans.id, pasiens.id, polis.id, alamats.id, pasiens.created_at, pasiens.tgl_lahir, pasiens.no_rekam_medis, pasiens.no_bpjs, pasiens.nik, polis.nama, alamats.alamat, alamats.kelurahan, alamats.kecamatan, pasiens.jk
            ORDER BY kunjungans.created_at ASC';
        
        return $this->db->query($sql, [$today, $today, $from, $to])->getResultArray();
    }


    public function getKunjunganByStatus($status) {
        $today = date('Y-m-d');
        return $this->where('status', $status)->where('DATE(kunjungans.created_at)', $today)->select('kunjungans.*, pasiens.*, pasiens.nama as nama_pasien, polis.*, alamats.*, kunjungans.id as id_kunjungan')->join('pasiens', 'pasiens.id = kunjungans.id_pasien')->join('polis', 'polis.id = kunjungans.id_poli')->join('alamats', 'alamats.id = pasiens.id_alamat')->get()->getResultArray();
    }

    public function getKunjunganByPasienId($id) {
        return $this->where('id_pasien', $id)->select('kunjungans.id as id_kunjungan, kunjungans.id_pasien as id_pasien, kunjungans.id_poli as id_poli, kunjungans.no_antrian as no_antrian, kunjungans.created_at as created_at, kunjungans.updated_at as updated_at, kunjungans.status as status, pasiens.nama as nama_pasien, pasiens.no_rekam_medis as no_rekam_medis, pasiens.nik as nik, pasiens.no_bpjs as no_bpjs, pasiens.tgl_lahir as tgl_lahir, pasiens.agama as agama, pasiens.gol_darah as gol_darah, pasiens.pekerjaan as pekerjaan_pasien, polis.nama as nama_poli')->join('pasiens', 'pasiens.id = kunjungans.id_pasien')->select('TIMESTAMPDIFF(YEAR, pasiens.tgl_lahir, CURDATE()) AS usia')->join('polis', 'polis.id = kunjungans.id_poli')->orderBy('kunjungans.created_at', 'desc')->first();
    }

    public function getKunjunganById($id) {
        return $this->where('kunjungans.id', $id)->select('kunjungans.*, pasiens.pekerjaan as pekerjaan_pasien')->join('pasiens', 'pasiens.id = kunjungans.id_pasien')->first();
    }

    public function getKunjunganByRekmedId($rekmedId) {
        return $this->where('rekmeds.id', $rekmedId)->select('kunjungans.id')->join('rekmeds', 'kunjungans.id_pasien = rekmeds.id_pasien')->orderBy('kunjungans.created_at', 'desc')->first();
    }

    public function getCountKunjunganToday() {
        return $this->where('DATE(kunjungans.created_at)', date('Y-m-d'))->countAllResults();
    }

    public function getTotalKunjunganPerMonth($year, $month = null) {
       $builder = $this->db->table($this->table);

        if ($year) {
            if ($month != 'all') {
                $builder->select('DATE(created_at) as date, COUNT(*) as total')
                        ->where('YEAR(created_at)', $year)
                        ->where('MONTH(created_at)', $month)
                        ->groupBy('DATE(created_at)');
            } else {
                $builder->select('MONTH(created_at) as date, COUNT(*) as total')
                        ->where('YEAR(created_at)', $year)
                        ->groupBy('MONTH(created_at)');
            }
        } else {
            return null;
        }

        $query = $builder->get();
        $results = $query->getResultArray();

        // Format the results as [date: 'YYYY-MM-DD', count: total]
        $formattedResults = array_map(function($row) {
            return [
                'date' => $row['date'],
                'count' => $row['total']
            ];
        }, $results);

        return $formattedResults;
    }


    public function postKunjungan($data) {
        if ($this->insert($data)) {
            return true;
        } else {
            return false;
        }
        
    }

    public function updateKunjungan($id, $data) {
        if ($this->update($id, $data)) {
            return true;
        } else {
            return false;
        }
    }

    public function pasien() {
        return $this->belongsTo(Pasien::class, 'id_pasien', 'id');
    }

    public function poli() {
        return $this->belongsTo(Poli::class, 'id_poli', 'id');
    }
}