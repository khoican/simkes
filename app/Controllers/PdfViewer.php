<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class PdfViewer extends BaseController
{

    public function index($template)
    {
        return view('reports/pdf_viewer', ['template' => $template]);
    }
}