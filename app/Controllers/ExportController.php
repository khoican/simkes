<?php
namespace App\Controllers;

use App\Controllers\BaseController;
use App\Database\Migrations\QuantityObat;
use App\Libraries\Pdf;
use App\Models\Diagnosa;
use App\Models\DiagnosaPasien;
use App\Models\GeneralConcent;
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
    protected $generalConsentModel;

    public function __construct()
    {
        $this->diagnosaModel = new Diagnosa();
        $this->tindakanModel = new Tindakan();
        $this->obatModel = new Obat();
        $this->quantityObatModel = new ModelsQuantityObat();
        $this->kunjunganModel = new Kunjungan();
        $this->generalConsentModel = new GeneralConcent();
    }

    public function index($status) {
        $uploadPath = FCPATH . 'uploads';
        if (!is_dir($uploadPath)) {
            mkdir($uploadPath, 0777, true);
        }

        return view('pages/laporan', ['status' => $status]);
    }

    public function generalConsentPdf() {
        $uploadPath = FCPATH . 'uploads';
        if (!is_dir($uploadPath)) {
            mkdir($uploadPath, 0777, true);
        }

        set_time_limit(120);

        $pdf = new Mpdf(['mode' => 'utf-8', 'format' => 'A4', 'margin_top' => 60, 'margin_right' => 10, 'margin_bottom' => 10, 'margin_left' => 10, 'orientation' => 'P']);
        $template = 'general_consent';
        $title = 'Persetujuan Umum / General Consent';

        $id = $this->request->getVar('id');
        $data = $this->generalConsentModel->getDataPasienByPasienId($id);
        
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
                ol li {
                    counter-increment: list-item;
                    line-height: 1.5;
                    position: relative;
                    padding-left: 2em; /* Spasi untuk penomoran */
                    margin-bottom: 1em; /* Menambahkan jarak antar item */
                    text-align: justify;
                }

                ol li::before {
                    content: counter(list-item) ") ";
                    position: absolute;
                    left: 0;
                    top: 0;
                }
            </style>

            <main style="font-size: 12px; line-height: 1">
                <h1 style="font-size: 12px; font-weight: bold; text-align: center; text-decoration: underline">' . $title . '</h1>

                <p style="font-size: 12px; font-weight: bold; margin-top: 20px;">PASIEN/WALI HUKUM HARUS MEMBACA, MEMAHAMI, DAN MENGISI INFORM CONSENT</p>
                <p style="font-size: 12px; margin-top: 20px;">Yang bertanda tangan di bawah ini</p>

                <table>
                    <tr>
                        <td style="width: 20%">Nama</td>
                        <td style="width: 1%">:</td>
                        <td style="width: 70%; text-transform: capitalize;">' . $data['nama_pasien'] . '</td>
                    </tr>
                    <tr>
                        <td style="width: 20%">Umur</td>
                        <td style="width: 1%">:</td>
                        <td style="width: 70%; text-transform: capitalize;">' . $data['usia_pasien'] . '</td>
                    </tr>
                    <tr>
                        <td style="width: 20%">Alamat</td>
                        <td style="width: 1%">:</td>
                        <td style="width: 70%; text-transform: capitalize;">' . $data['alamat_pasien'] . ' ,' .$data['kelurahan_pasien'] . ', ' . $data['kecamatan_pasien'] . '</td>
                    </tr>
                </table>

                <p style="font-size: 12px; margin-top: 20px;">Yang bertanda tangan di bawah ini : <b style="font-style: italic">(di isi bila diwakili wali hukum)</b></p>

                <table>
                    <tr>
                        <td style="width: 20%">Nama</td>
                        <td style="width: 1%">:</td>
                        <td style="width: 70%; text-transform: capitalize;">' . $data['nama_wali'] . '</td>
                    </tr>
                    <tr>
                        <td style="width: 20%">Umur</td>
                        <td style="width: 1%">:</td>
                        <td style="width: 70%; text-transform: capitalize;">' . $data['umur_wali'] . '</td>
                    </tr>
                    <tr>
                        <td style="width: 20%">Alamat</td>
                        <td style="width: 1%">:</td>
                        <td style="width: 70%; text-transform: capitalize;">' . $data['alamat_wali'] . '</td>
                    </tr>
                    <tr>
                        <td style="width: 20%">Nomor Telp</td>
                        <td style="width: 1%">:</td>
                        <td style="width: 70%">' . $data['no_telp_wali'] . '</td>
                    </tr>
                    <tr>
                        <td style="width: 20%">Status Hubungan Keluarga</td>
                        <td style="width: 1%">:</td>
                        <td style="width: 70%; text-transform: capitalize;">' . $data['status_wali'] . '</td>
                    </tr>
                </table>

                <p style="font-size: 12px; margin-top: 20px;">Selanjutnya Selaku pasien/wali hukum Puskesmas dengan ini menyatakan persetujuan :</p>

                <ol>
                    <li style="font-size: 12px;">Saya menyetujui untuk perawatan di Puskesmas sebagai pasien rawat jalan / inap</li>
                    <li style="font-size: 12px;"><b>HAK DAN KEWAJIBAN SEBAGAI PASIEN</b>, saya mengakui bahwa dalam proses pendaftaranuntuk mendapatkan perawatan di Puskesmas dan penandatanganan dokumen ini, saya telah mendapatkan informasi tentang hak dan kewajiban saya sebagai pasien</li>

                    <ol class="list-alpha" style="list-style-type: lower-alpha;">
                        <li><b>HAK PASIEN</b></li>
                        <ol class="list-number-2">
                            <li>Memperoleh informasi mengenai tata tertib dan peraturan yang berlaku di Puskesmas;</li>
                            <li>Memperoleh informasi tentang hak dan kewajiban Pasien;</li>
                            <li>Memperoleh layanan yang manusiawi, adil, jujur, dan tanpa diskriminasi;</li>
                            <li>Memperoleh layanan kesehatan yang bermutu sesuai dengan standar profesi dan standar prosedur operasional;</li>
                            <li>Memperoleh layanan yang efektif dan efisien sehingga Pasien terhindar dari kerugian fisik dan materi;</li>
                            <li>Mengajukan pengaduan atas kualitas pelayanan yang didapatkan;</li>
                            <li>Memilih dokter, dokter gigi, dan kelas perawatan sesuai dengan keinginannya dan peraturan yang berlaku di Puskesmas;</li>
                            <li>Memilih dokter, dokter gigi, dan kelas perawatan sesuai dengan keinginannya dan peraturan yang berlaku di Puskesmas;</li>
                            <li>Meminta konsultasi tentang penyakit yang dideritanya kepada dokter lain yang mempunyai surat izin praktik baik di dalam maupun di luar Puskesmas;</li>
                            <li>Mendapatkan privasi dan kerahasiaan penyakit yang diderita termasuk data medisnya;</li>
                            <li>Mendapat informasi yang meliputi diagnosis dan tata cara tindakan medis, tujuan tindakanmedis, alternatif tindakan, risiko dan komplikasi yang mungkin terjadi, dan prognosis terhadap tindakan yang dilakukan serta perkiraan biaya pengobatan;</li>
                            <li>Memberikan persetujuan atau menolak atas tindakan yang akan dilakukan oleh tenaga kesehatan terhadap penyakit yang dideritanya;</li>
                            <li>Didampingi keluarganya dalam keadaan kritis;</li>
                            <li>Menjalankan ibadah sesuai agama atau kepercayaan yang dianutnya selama hal itu tidak mengganggu Pasien lainnya;</li>
                            <li>Memperoleh keamanan dan keselamatan dirinya selama dalam perawatan di Puskesmas;</li>
                            <li>Mengajukan usul, saran, perbaikan atas perlakuan Puskesmas terhadap dirinya;</li>
                            <li>Menolak pelayanan bimbingan rohani yang tidak sesuai dengan agama dan kepercayaan yang dianut;</li>
                            <li>Menggugat dan/atau menuntut Puskesmas apabila Puskesmas diduga memberikan pelayanan yang tidak sesuai dengan standar baik secara perdata ataupun pidana; dan</li>
                        </ol>

                        <li>Mengeluhkan pelayanan Puskesmas yang tidak sesuai dengan standar pelayanan melalui mediacetak dan elektronik sesuai dengan ketentuan peraturan perundang-undangan <b>KEWAJIBAN PASIEN</b></li>
                        <ol class="list-number-2">
                            <li>Mematuhi peraturan yang berlaku di Puskesmas;</li>
                            <li>Menggunakan fasilitas Puskesmas secara bertanggung jawab;</li>
                            <li>Menghormati hak Pasien lain, pengunjung, dan hak tenaga kesehatan serta petugas lainnyayang bekerja di Puskesmas;</li>
                            <li>Memberikan informasi yang jujur, lengkap dan akurat sesuai dengan kemampuan dan pengetahuannya tentang masalah kesehatannya;</li>
                            <li>Memberikan informasi mengenai kemampuan finansial dan jaminan kesehatan yang dimilikinya.</li>
                        </ol>

                    </ol>

                    <li><b>PERSETUJUAN PELAYANAN KESEHATAN,</b></li>
                    <ol class="list-number-2"  style="list-style-type: lower-alpha;">
                        <li>Saya menyetujui dan memberikan persetujuan untuk mendapat pelayanan kesehatan di Puskesmasdandengan ini saya meminta dan memberikan kuasa kepada pihak Puskesmas , dokter, dokter gigi, perawat, bidan, dan tenaga kesehatan lainnya untuk memberikan pelayanan dan tindakan medis, asuhan keperawatan ataupun asuhan kebidanan</li>
                    </ol>

                    <li><b>PRIVASI</b>, saya memberi kuasa kepada Puskesmas untuk menjaga privasi dan kerahasiaan penyakit saya selama dalam perawatan.</li>

                    <li><b>RAHASIA KEDOKTERAN,</b> saya setuju Puskesmas wajib menjamin rahasia kedokteran sayabaikkepentingan perawatan atau pengobatan, kecuali menggunakan sendiri atau orang lain yang saya beri kuasa kepada penjamin.</li>

                    <li><b>MEMBUKA RAHASIA KEDOKTERAN,</b> saya setuju membuka rahasia kedokteran terkait dengan kondisi kesehatan dan pengobatan yang saya terima kepada :</li>
                    <ol class="list-number-2" style="list-style-type: lower-alpha;">
                        <li>Dokter dan tenaga kesehatan lain yang memberikan pelayanan kepada saya.</li>
                        <li>Perusahaan asuransi kesehatan atau BPJS atau pihak lain yang menjamin pembiayaan saya dan lembaga Pemerintah.</li>
                        <li>Saya memberikan wewenang kepada Puskesmas untuk memberikan informasi tentang diagnosadanhasil pelayanan dan pengobatan saya kepada anggota keluarga saya yaitu :.............</li>
                    </ol>

                    <li><b>BARANG PRIBADI</b>, saya setuju untuk tidak membawa barang-barang berharga yang tidak diperlukanselama dalam perawatan. Saya memahami dan menyetujui Puskesmas tidak bertanggung jawab terhadap kehilangan, kerusakan, atau pencurian barang berharga.</li>

                    <li><b>PENGAJUAN KELUHAN,</b> saya menyatakan bahwa saya telah menerima informasi tentang adanyatatacara mengajukan dan mengatasi keluhan terkait pelayanan medis yang diberikan terhadap diri saya. Saya setuju mengakui tata cara mengajukan keluhan sesuai prosedur yang ada.</li>

                    <li><b>KEWAJIBAN PEMBAYARAN,</b> saya menyetujui baik sebagai pasien atau sebagai wali, bahwa sesuai pertimbangan tarif pelayanan, biaya pelayanan berdasarkan acuan biaya dan ketentuan Puskesmas. Saya juga menyadari dan memahami bahwa :</li>
                    <ol class="list-number-2" style="list-style-type: lower-alpha;">
                        <li>Apabila ada biaya pemeriksaan/tindakan/perawatan yang tidak ditanggung oleh penjamin, maka saya bersedia melunasi biaya.</li>
                        <li>Apabila Puskesmas membutuhkan proses hukum untuk menagih pelayanan Puskesmas dari saya, saya memahami bahwa saya bertanggung jawab untuk membayar semua biaya yang disebabkan dan proses hukum tersebut.</li>
                    </ol>

                    <li><b>SAYA TELAH MENERIMA INFORMASI TENTANG:</b></li>
                    <ol class="list-number-2" style="list-style-type: lower-alpha;">
                        <li>Alur pendaftaran Puskesmas</li>
                        <li>Alur Pelayanan Puskesmas</li>
                        <li>Pelayanan yang tersedia di Puskesmas</li>
                        <li>Tarif biaya pelayanan</li>
                    </ol>
                </ol>

                <p style="text-align: justify; line-height: 1.5">Melalui dokumen ini saya menegaskan kembali, bahwa saya mempercayakan kepada tenaga medis dan tenaga kesehatan di Puskesmas untuk memberikan perawatan, diagnosik dan terapi kepada saya/………………………. sebagai pasien rawat jalan/inap termasuk semua pemeriksaan penunjang yang dibutuhkan untuk pengobatan. <b>SAYA TELAH MEMBACA DAN SEPENUHNYA SETUJU </b>dengan setiap pernyataan yang terdapat pada formulir ini dan menandatangani tanpa paksaan dan dengan kesadaranpenuh.</p>

                <p>Jember, ' . format_date($data['created_at_wali']) . '</p>
            </main>';

        $pdf->WriteHTML($tableHTML);

        $pdf->Output($filePath, 'F');

        return redirect()->to(base_url('laporan/view/general_consent'));
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