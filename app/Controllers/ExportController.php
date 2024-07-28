<?php
namespace App\Controllers;

use App\Controllers\BaseController;
use App\Database\Migrations\QuantityObat;
use App\Libraries\Pdf;
use App\Models\Diagnosa;
use App\Models\DiagnosaPasien;
use App\Models\Kunjungan;
use App\Models\Obat;
use App\Models\QuantityObat as ModelsQuantityObat;
use App\Models\Tindakan;
use CodeIgniter\HTTP\ResponseInterface;
use Mpdf\Mpdf;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\Color;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class ExportController extends BaseController
{   
    protected $diagnosaModel;
    protected $tindakanModel;
    protected $obatModel;
    protected $kunjunganModel;
    protected $quantityObatModel;

    public function __construct()
    {
        $this->diagnosaModel = new Diagnosa();
        $this->tindakanModel = new Tindakan();
        $this->obatModel = new Obat();
        $this->quantityObatModel = new ModelsQuantityObat();
        $this->kunjunganModel = new Kunjungan();
    }

    public function index($status) {
        return view('pages/laporan', ['status' => $status]);
    }

    public function kunjunganPdf() {
        set_time_limit(120);

        $pdf = new Mpdf(['mode' => 'utf-8', 'format' => 'A4', 'margin_top' => 60, 'margin_right' => 10, 'margin_bottom' => 10, 'margin_left' => 10, 'orientation' => 'L']);
        $template = 'kunjungan';
        $title = 'Laporan Kunjungan Pasien';

        $from = $this->request->getPost('dari');
        $to = $this->request->getPost('sampai');
        $data = $this->kunjunganModel->getKunjunganByDate($from, $to);
        
        $filePath = 'uploads/' . $template . '.pdf';

        $headerHTML = '
            <div style="text-align: center; line-height: 1;">
                <h1 style="font-size: 14px; font-weight: bold;">PEMERINTAH KABUPATEN JEMBER</h1>
                <h1 style="font-size: 14px; font-weight: bold;">DINAS KESEHATAN</h1>
                <h1 style="font-size: 14px; font-weight: bold;">UNIT PELAKSANA TEKNIS DAERAH PUSKESMAS SUMBERSARI</h1>
                <p style="font-size: 11px;">Alamat: Jl. Letjen Panjaitan No. 42 - 0331-337344</p>
                <p style="font-size: 11px;">website : pkmsumbersarijember.com email : pkmsumbersari.jember@gmail.com</p>
                <h1 style="font-size: 14px; font-weight: bold;">JEMBER</h1>
            </div>
            <hr />';

        $pdf->SetHTMLHeader($headerHTML);

        $tableHTML = '
            <style>
                .table {
                    width: 100%;
                    border-collapse: collapse;
                    margin: 20px 0;
                    font-size: 12px;
                }
                .table th,
                .table td {
                    border: 1px solid #ddd;
                    padding: 8px;
                }
                .table th {
                    background-color: #f2f2f2;
                    text-align: left;
                }
            </style>
            <main style="font-size: 12px;">
                <h1 style="font-size: 12px; font-weight: bold;">' . $title . '</h1>
                <table class="table">
                    <thead>
                        <tr>
                            <th>No. RM</th>
                            <th>NIK/th>
                            <th>No. BPJS</th>
                            <th>Nama Pasien</th>
                            <th>Umur</th>
                            <th>Alamat</th>
                            <th>Jenis Kelamin</th>
                            <th>Tujuan</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>';
        
        if (count($data) == 0) {
            $tableHTML .= '
                    <tr>
                        <td colspan="3">Tidak ada data</td>
                    </tr>';
        } else {
            foreach ($data as $row) {
                $tableHTML .= '
                    <tr>
                        <td>' . $row['no_rekam_medis'] . '</td>
                        <td>' . $row['nik'] . '</td>
                        <td>' . $row['no_bpjs'] . '</td>
                        <td>' . $row['nama'] . '</td>
                        <td>' . $row['usia'] . '</td>
                        <td>' . $row['alamat'] . ', ' . $row['kelurahan'] . ' - ' . $row['kecamatan'] . '</td>';
                        
                if($row['jk'] == 'l') {
                    $tableHTML .= '<td>Laki-laki</td>';
                } else if ($row['jk'] == 'p') {
                    $tableHTML .= '<td>Perempuan</td>';
                }

                $tableHTML .= '
                        <td style="text-transform: capitalize">' . $row['nama_poli'] . '</td>
                        <td style="text-transform: capitalize">' . $row['status'] . '</td>
                    </tr>';
            }
        }

        $tableHTML .= '
                    </tbody>
                </table>
            </main>';

        $pdf->WriteHTML($tableHTML);

        $pdf->Output($filePath, 'F');

        return redirect()->to(base_url('laporan/view/kunjungan'));
    }

    public function diagnosaPdf() {
        set_time_limit(120);

        $pdf = new Mpdf(['mode' => 'utf-8', 'format' => 'A4', 'margin_top' => 60, 'margin_right' => 10, 'margin_bottom' => 10, 'margin_left' => 10]);
        $template = 'diagnosa';
        $title = 'Laporan Diagnosa Penyakit Terbanyak';

        $from = $this->request->getPost('dari');
        $to = $this->request->getPost('sampai');
        $data = $this->diagnosaModel->getMostDiagnosaPasienByDate($from, $to);
        
        $filePath = 'uploads/' . $template . '.pdf';

        $headerHTML = '
            <div style="text-align: center; line-height: 1;">
                <h1 style="font-size: 14px; font-weight: bold;">PEMERINTAH KABUPATEN JEMBER</h1>
                <h1 style="font-size: 14px; font-weight: bold;">DINAS KESEHATAN</h1>
                <h1 style="font-size: 14px; font-weight: bold;">UNIT PELAKSANA TEKNIS DAERAH PUSKESMAS SUMBERSARI</h1>
                <p style="font-size: 11px;">Alamat: Jl. Letjen Panjaitan No. 42 - 0331-337344</p>
                <p style="font-size: 11px;">website : pkmsumbersarijember.com email : pkmsumbersari.jember@gmail.com</p>
                <h1 style="font-size: 14px; font-weight: bold;">JEMBER</h1>
            </div>
            <hr />';

        $pdf->SetHTMLHeader($headerHTML);

        $tableHTML = '
            <style>
                .table {
                    width: 100%;
                    border-collapse: collapse;
                    margin: 20px 0;
                    font-size: 12px;
                }
                .table th,
                .table td {
                    border: 1px solid #ddd;
                    padding: 8px;
                }
                .table th {
                    background-color: #f2f2f2;
                    text-align: left;
                }
            </style>
            <main style="font-size: 12px;">
                <h1 style="font-size: 12px; font-weight: bold;">' . $title . '</h1>
                <table class="table">
                    <thead>
                        <tr>
                            <th>Kode</th>
                            <th>Diagnosa Penyakit</th>
                            <th>Jumlah</th>
                        </tr>
                    </thead>
                    <tbody>';
        
        if (count($data) == 0) {
            $tableHTML .= '
                    <tr>
                        <td colspan="3">Tidak ada data</td>
                    </tr>';
        } else {
            foreach ($data as $row) {
                $tableHTML .= '
                    <tr>
                        <td>' . $row['kode'] . '</td>
                        <td>' . $row['diagnosa'] . '</td>
                        <td>' . $row['total'] . '</td>
                    </tr>';
            }
        }

        $tableHTML .= '
                    </tbody>
                </table>
            </main>';

        $pdf->WriteHTML($tableHTML);

        $pdf->Output($filePath, 'F');

        return redirect()->to(base_url('laporan/view/diagnosa'));
    }

    public function tindakanPdf() {
        set_time_limit(120);

        $pdf = new Mpdf(['mode' => 'utf-8', 'format' => 'A4', 'margin_top' => 60, 'margin_right' => 10, 'margin_bottom' => 10, 'margin_left' => 10]);
        $template = 'tindakan';
        $title = 'Laporan Tindakan Terbanyak';

        $from = $this->request->getPost('dari');
        $to = $this->request->getPost('sampai');
        $data = $this->tindakanModel->getMostTindakanPasienByDate($from, $to);
        
        $filePath = 'uploads/' . $template . '.pdf';

        $headerHTML = '
            <div style="text-align: center; line-height: 1;">
                <h1 style="font-size: 14px; font-weight: bold;">PEMERINTAH KABUPATEN JEMBER</h1>
                <h1 style="font-size: 14px; font-weight: bold;">DINAS KESEHATAN</h1>
                <h1 style="font-size: 14px; font-weight: bold;">UNIT PELAKSANA TEKNIS DAERAH PUSKESMAS SUMBERSARI</h1>
                <p style="font-size: 11px;">Alamat: Jl. Letjen Panjaitan No. 42 - 0331-337344</p>
                <p style="font-size: 11px;">website : pkmsumbersarijember.com email : pkmsumbersari.jember@gmail.com</p>
                <h1 style="font-size: 14px; font-weight: bold;">JEMBER</h1>
            </div>
            <hr />';

        $pdf->SetHTMLHeader($headerHTML);

        $tableHTML = '
            <style>
                .table {
                    width: 100%;
                    border-collapse: collapse;
                    margin: 20px 0;
                    font-size: 12px;
                }
                .table th,
                .table td {
                    border: 1px solid #ddd;
                    padding: 8px;
                }
                .table th {
                    background-color: #f2f2f2;
                    text-align: left;
                }
            </style>
            <main style="font-size: 12px;">
                <h1 style="font-size: 12px; font-weight: bold;">' . $title . '</h1>
                <table class="table">
                    <thead>
                        <tr>
                            <th>Kode</th>
                            <th>Tindakan</th>
                            <th>Jumlah</th>
                        </tr>
                    </thead>
                    <tbody>';
        
        if (count($data) == 0) {
            $tableHTML .= '
                    <tr>
                        <td colspan="3">Tidak ada data</td>
                    </tr>';
        } else {
            foreach ($data as $row) {
                $tableHTML .= '
                    <tr>
                        <td>' . $row['kode'] . '</td>
                        <td>' . $row['tindakan'] . '</td>
                        <td>' . $row['total'] . '</td>
                    </tr>';
            }
        }

        $tableHTML .= '
                    </tbody>
                </table>
            </main>';

        $pdf->WriteHTML($tableHTML);

        $pdf->Output($filePath, 'F');

        return redirect()->to(base_url('laporan/view/tindakan'));
    }

    public function obatPdf() {
        set_time_limit(120);

        $pdf = new Mpdf(['mode' => 'utf-8', 'format' => 'A4', 'margin_top' => 60, 'margin_right' => 10, 'margin_bottom' => 10, 'margin_left' => 10]);
        $template = 'obat';
        $title = 'Laporan Stok Obat';

        $from = $this->request->getPost('dari');
        $to = $this->request->getPost('sampai');
        $data = $this->quantityObatModel->getQuantityObatByDate($from, $to);
        
        $filePath = 'uploads/' . $template . '.pdf';

        $headerHTML = '
            <div style="text-align: center; line-height: 1;">
                <h1 style="font-size: 14px; font-weight: bold;">PEMERINTAH KABUPATEN JEMBER</h1>
                <h1 style="font-size: 14px; font-weight: bold;">DINAS KESEHATAN</h1>
                <h1 style="font-size: 14px; font-weight: bold;">UNIT PELAKSANA TEKNIS DAERAH PUSKESMAS SUMBERSARI</h1>
                <p style="font-size: 11px;">Alamat: Jl. Letjen Panjaitan No. 42 - 0331-337344</p>
                <p style="font-size: 11px;">website : pkmsumbersarijember.com email : pkmsumbersari.jember@gmail.com</p>
                <h1 style="font-size: 14px; font-weight: bold;">JEMBER</h1>
            </div>
            <hr />';

        $pdf->SetHTMLHeader($headerHTML);

        $tableHTML = '
            <style>
                .table {
                    width: 100%;
                    border-collapse: collapse;
                    margin: 20px 0;
                    font-size: 12px;
                }
                .table th,
                .table td {
                    border: 1px solid #ddd;
                    padding: 8px;
                }
                .table th {
                    background-color: #f2f2f2;
                    text-align: left;
                }
            </style>
            <main style="font-size: 12px;">
                <h1 style="font-size: 12px; font-weight: bold;">' . $title . '</h1>
                <table class="table">
                    <thead>
                        <tr>
                            <th>Kode</th>
                            <th>Nama Obat</th>
                            <th>Qty Masuk</th>
                            <th>Qty Keluar</th>
                            <th>Stok</th>
                        </tr>
                    </thead>
                    <tbody>';
        
        if (count($data) == 0) {
            $tableHTML .= '
                    <tr>
                        <td colspan="3">Tidak ada data</td>
                    </tr>';
        } else {
            foreach ($data as $row) {
                $tableHTML .= '
                    <tr>
                        <td>' . $row['kode'] . '</td>
                        <td>' . $row['obat'] . '</td>
                        <td>' . $row['masuk'] . '</td>
                        <td>' . $row['keluar'] . '</td>
                        <td>' . $row['stok'] . '</td>
                    </tr>';
            }
        }

        $tableHTML .= '
                    </tbody>
                </table>
            </main>';

        $pdf->WriteHTML($tableHTML);

        $pdf->Output($filePath, 'F');

        return redirect()->to(base_url('laporan/view/obat'));
    }

    public function notuse()
    {
        $spreadsheet = new Spreadsheet();

        $sheet1 = $spreadsheet->getActiveSheet();
        $sheet1->setTitle('Diagnosa Data');
        $this->diagnosa($sheet1);

        $sheet2 = $spreadsheet->createSheet();
        $sheet2->setTitle('Tindakan Data');
        $this->tindakan($sheet2);

        $filename = 'report_simkes.xlsx';

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');
        header('Cache-Control: max-age=1');
        header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
        header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT');
        header('Cache-Control: cache, must-revalidate');
        header('Pragma: public');

        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
        exit();
    }

    public function diagnosa($sheet) 
    {
        $dataDiagnosa = $this->diagnosaModel->getMostDiagnosaPasien();

        $headerStyleArray = [
            'font' => [
                'bold' => true,
                'color' => ['argb' => Color::COLOR_WHITE],
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['argb' => '00008B'],
            ],
        ];

        $sheet->setCellValue('A1', 'No')
              ->setCellValue('B1', 'Nama Diagnosa')
              ->setCellValue('C1', 'Kode Diagnosa')
              ->setCellValue('D1', 'Jumlah');

        $sheet->getStyle('A1:D1')->applyFromArray($headerStyleArray);

        $row = 2;
        foreach($dataDiagnosa as $data) {
            $sheet->setCellValue('A'.$row, $row - 1);
            $sheet->setCellValue('B'.$row, ucfirst($data['diagnosa']));
            $sheet->setCellValue('C'.$row, ucfirst($data['kode']));
            $sheet->setCellValue('D'.$row, $data['total']);
            $row++;
        }
    }

    public function tindakan($sheet) 
    {
        $dataDiagnosa = $this->tindakanModel->getMostTindakanPasien();

        $headerStyleArray = [
            'font' => [
                'bold' => true,
                'color' => ['argb' => Color::COLOR_WHITE],
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['argb' => '00008B'],
            ],
        ];

        $sheet->setCellValue('A1', 'No')
              ->setCellValue('B1', 'Nama Tindakan')
              ->setCellValue('C1', 'Kode Tindakan')
              ->setCellValue('D1', 'Jumlah');

        $sheet->getStyle('A1:D1')->applyFromArray($headerStyleArray);

        $row = 2;
        foreach($dataDiagnosa as $data) {
            $sheet->setCellValue('A'.$row, $row - 1);
            $sheet->setCellValue('B'.$row, ucfirst($data['tindakan']));
            $sheet->setCellValue('C'.$row, ucfirst($data['kode']));
            $sheet->setCellValue('D'.$row, $data['total']);
            $row++;
        }
    }
    
}