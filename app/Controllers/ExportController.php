<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Diagnosa;
use App\Models\DiagnosaPasien;
use App\Models\Kunjungan;
use App\Models\Obat;
use App\Models\Tindakan;
use CodeIgniter\HTTP\ResponseInterface;
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

    public function __construct()
    {
        $this->diagnosaModel = new Diagnosa();
        $this->tindakanModel = new Tindakan();
        $this->obatModel = new Obat();
        $this->kunjunganModel = new Kunjungan();
    }

    public function index()
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