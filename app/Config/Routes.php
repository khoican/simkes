<?php
use CodeIgniter\Router\RouteCollection;

/**
* @var RouteCollection $routes
*/

$routes->get('/login', function() {
    return view('pages/auth/login');
});

$routes->post('user/login', 'UserController::auth');

// Home
$routes->get('/', 'DashboardController::index', ['filters' => 'auth']);
$routes->get('dashboard/kunjungan/total/(:num)/(:any)', 'DashboardController::getTotalKunjungan/$1/$2');

// Pasien
$routes->group('pasien', ['filters' => 'auth'], function($routes) {
    $routes->post('search', 'PasienController::searchPasien');
});

// Pendaftaran (Pasien)
$routes->group('pendaftaran', ['filters' => 'auth'], function($routes) {
    $routes->get('/', 'PasienController::index');
    $routes->post('get-pasien', 'PasienController::fetchPasien');
    $routes->get('get-pasien/(:num)', 'PasienController::getPasien/$1');
    $routes->post('pasien/store', 'PasienController::store');
    $routes->post('pasien/update/(:num)', 'PasienController::update/$1');
});

// Pemeriksaan
$routes->group('pemeriksaan', ['filters' => 'auth'], function($routes) {
    $routes->get('/', 'KunjunganController::pemeriksaan');
    $routes->post('(:num)', 'RekmedController::periksaPasien/$1');
    $routes->post('general-consent', 'PasienController::postGeneralConsent');
    $routes->post('generalConsentPdf', 'ExportController::generalConsentPdf');
});

// Apotek
$routes->group('apotek', ['filters' => 'auth'], function($routes) {
    $routes->get('/', 'KunjunganController::apotek');
    $routes->post('(:num)', 'ApotekController::apotekPasien/$1');
    $routes->get('obat/(:num)', 'ApotekController::getObat/$1');
    $routes->post('obat/update/(:num)', 'ApotekController::updateStatusObatPasien/$1');
    $routes->post('obat/add', 'ApotekController::addObatPasien');
    $routes->post('kunjungan/update/(:num)/(:num)', 'ApotekController::updateStatusKunjungan/$1/$2');
    $routes->post('obatracikan/add', 'ApotekController::addObatRacikan');
    $routes->post('obat/delete/(:num)', 'ApotekController::deleteObatPasien/$1');
    $routes->post('obatracikan/delete/(:num)', 'ApotekController::deleteObatRacikan/$1');
});

$routes->group('rekob', ['filters' => 'auth'], function($routes) {
    $routes->get('/', 'ApotekController::index');
    $routes->get('(:num)/detail/(:num)', 'ApotekController::getResepByRekmedId/$1/$2');
    $routes->get('(:num)', 'ApotekController::getResep/$1');
});

// Kunjungan
$routes->group('kunjungan', ['filters' => 'auth'], function($routes) {
    $routes->get('generate-antrian', 'KunjunganController::generateAntrian');
    $routes->get('(:any)', 'KunjunganController::getKunjunganStatus/$1');
    $routes->post('store', 'KunjunganController::store');
    $routes->post('panggil/(:num)', 'KunjunganController::panggilAntrian/$1');
    $routes->put('update/(:num)', 'KunjunganController::update/$1');
    $routes->get('servicetime', 'KunjunganController::getServiceTime');
});

// Rekam Medis
$routes->group('rekmed', ['filters' => 'auth'], function($routes) {
    $routes->get('/', 'RekmedController::index');
    $routes->get('(:num)', 'RekmedController::getByUser/$1');
    $routes->get('(:num)/new', 'RekmedController::create/$1');
    $routes->get('(:num)/edit/(:num)', 'RekmedController::edit/$2');
    $routes->get('user/(:num)', 'RekmedController::show/$1');
    $routes->post('store/(:num)', 'RekmedController::store/$1');
    $routes->post('update/(:num)', 'RekmedController::update/$1');
    $routes->post('delete/(:num)/(:num)', 'RekmedController::delete/$1/$2');
});

// Poli
$routes->group('poli', ['filters' => 'auth'], function($routes) {
    $routes->get('/', 'PoliController::index');
    $routes->get('all', 'PoliController::getPoli');
    $routes->get('(:num)', 'PoliController::getPoliById/$1');
    $routes->post('store', 'PoliController::postPoli');
    $routes->post('update/(:num)', 'PoliController::editPoli/$1');
    $routes->post('delete/(:num)', 'PoliController::deletePoli/$1');
});

// Diagnosa
$routes->group('diagnosa', ['filters' => 'auth'], function($routes) {
    $routes->get('/', 'DiagnosaController::index');
    $routes->get('all', 'DiagnosaController::getDiagnosa');
    $routes->get('(:num)', 'DiagnosaController::getDiagnosaById/$1');
    $routes->post('store', 'DiagnosaController::postDiagnosa');
    $routes->post('update/(:num)', 'DiagnosaController::editDiagnosa/$1');
    $routes->post('delete/(:num)', 'DiagnosaController::deleteDiagnosa/$1');
});

// Tindakan
$routes->group('tindakan', ['filters' => 'auth'], function($routes) {
    $routes->get('/', 'TindakanController::index');
    $routes->get('all', 'TindakanController::getTindakan');
    $routes->get('(:num)', 'TindakanController::getTindakanById/$1');
    $routes->post('store', 'TindakanController::postTindakan');
    $routes->post('update/(:num)', 'TindakanController::editTindakan/$1');
    $routes->post('delete/(:num)', 'TindakanController::deleteTindakan/$1');
});

// Obat
$routes->group('obat',['filters' => 'auth'], function($routes) {
    $routes->get('/', 'ObatController::index');
    $routes->get('all', 'ObatController::getObat');
    $routes->get('(:num)', 'ObatController::getObatById/$1');
    $routes->post('store', 'ObatController::postObat');
    $routes->post('update/(:num)', 'ObatController::editObat/$1');
    $routes->post('updateStok/(:num)', 'ObatController::updateStok/$1');
    $routes->post('delete/(:num)', 'ObatController::deleteObat/$1');
});

// User
$routes->group('user', ['filters' => 'auth'], function($routes) {
    $routes->get('/', 'UserController::index');
    $routes->get('all', 'UserController::getUser');
    $routes->get('(:num)', 'UserController::getUserById/$1');
    $routes->post('store', 'UserController::postUser');
    $routes->post('update/(:num)', 'UserController::editUser/$1');
    $routes->post('changepassword/(:num)', 'UserController::changePassword/$1');
    $routes->post('delete/(:num)', 'UserController::deleteUser/$1');
    $routes->post('logout', 'UserController::logout');
});

$routes->group('laporan', ['filters' => 'auth'], function($routes) {
    $routes->get('view/(:any)', 'PdfViewer::index/$1');
    $routes->get('(:any)', 'ExportController::index/$1');
    $routes->post('diagnosa', 'ExportController::diagnosaPdf');
    $routes->post('tindakan', 'ExportController::tindakanPdf');
    $routes->post('obat', 'ExportController::obatPdf');
    $routes->post('kunjungan', 'ExportController::kunjunganPdf');
});