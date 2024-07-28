<?php
namespace App\Libraries;

use \Mpdf\Mpdf;

class Pdf {
    public function generate($html, $filename = '', $stream = TRUE, $paper = 'A4', $orientation = 'portrait') {
        $mpdfConfig = [
            'mode' => 'utf-8',
            'format' => $paper,
            'orientation' => $orientation,
            'tempDir' => WRITEPATH . 'temp',
            'setAutoTopMargin' => 'stretch',
            'setAutoBottomMargin' => 'stretch',
            'autoScriptToLang' => true,
            'autoLangToFont' => true,
            'margin_top' => 10,
            'margin_right' => 10,
            'margin_bottom' => 10,
            'margin_left' => 10
        ];

        log_message('debug', 'mPDF configuration: ' . print_r($mpdfConfig, true));
        
        $mpdf = new Mpdf($mpdfConfig);

        log_message('debug', 'Starting mPDF rendering');
        $mpdf->WriteHTML($html);
        log_message('debug', 'Finished mPDF rendering');

        if ($stream) {
            $mpdf->Output($filename . '.pdf', 'I');
        } else {
            $dir = dirname($filename);
            if (!is_dir($dir)) {
                mkdir($dir, 0775, true); 
            }
            $mpdf->Output($filename, 'F'); 
        }
    }
}