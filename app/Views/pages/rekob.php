<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div class='d-flex gap-4 mt-5 border rounded-3 bg-white p-3'>
    <div class="col-3">
        <?= view_cell('PasienDataCell',['searchEvent' => true, 'id' => $id]) ?>
    </div>

    <div class="w-100">

        <?php if(isset($rekmedPasiens)) : foreach ($rekmedPasiens as $rekmedPasien) : ?>
        <div
            class="w-100 fs-6 border border-primary d-flex align-items-center gap-3 py-2 px-3 rounded-3 border border-primary mb-1">
            <div style="width: 10%;" class="center">
                <p class="mb-0"><?= format_date($rekmedPasien['created_at']) ?></p>
            </div>
            <div class="text-center" style="width: 15%;">
                <?php if($rekmedPasien['status_kunjungan'] == 'selesai') : 
                    $end = format_time($rekmedPasien['updated_at']); ?>
                <p class="mb-0 bg-success p-1 rounded-3 fw-medium text-white">
                    <?= format_time($rekmedPasien['created_at']) ?> -
                    <?= $end ?></p>
                <?php else : ?>
                <p class=" mb-0 bg-info-subtle p-1 rounded-3 fw-medium"><?= format_time($rekmedPasien['created_at']) ?>
                    - PROSES
                </p>
                <?php endif; ?>
            </div>
            <div style="width: 25%;">
                <p class="mb-0 fw-medium">Keluhan : <span
                        class="text-capitalize fw-normal"><?= $rekmedPasien['keluhan'] ?></span>
                </p>
            </div>
            <div style="width: 20%;">
                <p class="mb-0 fw-medium">Diagnosa :
                    <?php if(isset($diagnosaPasiens[$rekmedPasien['id']])) :
                    $counter = 0;
                    foreach($diagnosaPasiens[$rekmedPasien['id']] as $diagnosa) : 
                    $counter++;
                    ?>
                    <span
                        class="text-capitalize fw-normal"><?= $diagnosa['diagnosa'] ?><?php if($counter < count($diagnosaPasiens[$rekmedPasien['id']])) : ?>,
                        <?php endif; ?>
                    </span>
                    <?php endforeach;
                    endif ?>
                </p>
            </div>
            <div class="d-flex justify-content-center" style="width: 15%;">
                <div class="btn btn-sm btn-success">
                    <p class="mb-0 text-uppercase"><?= $rekmedPasien['poli'] ?></p>
                </div>
            </div>
            <div class="d-flex gap-1 justify-content-center" style="width: 15%;">
                <button type="button" class="btn btn-sm h-100 btn-primary show-modal" data-bs-toggle="modal"
                    data-bs-target="#rekmedModal" data-id="<?= $rekmedPasien['id'] ?>">
                    <i class="bi bi-eye-fill fs-4"></i>
                </button>

                <?php if(session()->get('role') != 'apotek') : ?>
                <a href="/rekmed/<?= $id ?>/edit/<?= $rekmedPasien['id'] ?>" class="btn btn-sm h-100 btn-warning">
                    <i class="bi bi-pencil-square fs-4"></i>
                </a>
                <form action="/rekmed/delete/<?= $rekmedPasien['id'] ?>/<?= $id ?>" method="post">
                    <?= csrf_field() ?>
                    <button type="submit" class="btn btn-sm h-100 btn-danger">
                        <i class="bi bi-trash-fill fs-4"></i>
                    </button>
                </form>
                <?php endif; ?>
            </div>
        </div>
        <?php endforeach; endif ?>

        <?php if(session()->get('role') != 'apotek') : ?>
        <?php 
        if (empty($id)) : ?>

        <p class="fs-6 fw-light text-center">Silahkan cari pasien pada kolom pencarian</p>
        <?php 
        elseif (empty($kunjunganId)) : ?>

        <p class="fs-6 fw-light text-center">Pasien belum melakukan pendaftaran kunjungan ke poli tertuju, silahkan
            daftarkan
            terlebih dahulu</p>
        <?php else :
            if (empty($generalConsent)) : ?>
        <div class="w-100 h-auto mt-5 d-flex flex-column justify-content-center align-items-center">
            <button type="button" class="btn btn-sm btn-primary mb-3" data-bs-toggle="modal"
                data-bs-target="#exampleModal">
                <i class="bi bi-plus"></i> General Consent
            </button>
            <p class="fs-6 fw-light">Tambahkan General Consent terlebih dahulu sebelum menambahkan data rekam
                medis!</p>
        </div>

        <?php else : ?>
        <div class="w-100 h-auto mt-5 d-flex flex-column justify-content-center align-items-center">
            <a href="/rekmed/<?= $id ?>/new" class="btn btn-primary rounded-circle">
                <i class="bi bi-plus fs-2 text-white mb-0"></i>
            </a>
            <p class="fs-5 ms-3 mb-0 fw-medium">Rekam Medis</p>
        </div>
        <?php endif; endif; endif; ?>
    </div>
</div>

<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content fs-6">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">General Consent</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="/pemeriksaan/general-consent" method="post">
                <?= csrf_field() ?>
                <input type="hidden" name="id_pasien" value="<?= $id ?>">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="nama" class="col-form-label">Nama Wali</label>
                        <input type="text" class="form-control form-control-sm" id="nama" name="nama">
                    </div>
                    <div class="mb-3">
                        <label for="umur" class="col-form-label">Umur Wali</label>
                        <input type="number" class="form-control form-control-sm" id="umur" name="umur">
                    </div>
                    <div class="mb-3">
                        <label for="alamat" class="col-form-label">Alamat Wali</label>
                        <input type="text" class="form-control form-control-sm" id="alamat" name="alamat">
                    </div>
                    <div class="mb-3">
                        <label for="no_telp" class="col-form-label">No Telepon Wali</label>
                        <input type="number" class="form-control form-control-sm" id="no_telp" name="no_telp">
                    </div>
                    <div class="mb-3">
                        <label for="status" class="col-form-label">Status Hubungan</label>
                        <select class="form-select form-select-sm" aria-label="Small select example" id="status"
                            name="status">
                            <option selected>Pilih hubungan wali dengan pasien</option>
                            <option value="ayah">Ayah</option>
                            <option value="ibu">Ibu</option>
                            <option value="suami">Suami</option>
                            <option value="istri">Istri</option>
                            <option value="paman">Paman</option>
                            <option value="tante">Tante</option>
                            <option value="kakak">Kakak</option>
                            <option value="adik">Adik</option>
                            <option value="kaket">Kakek</option>
                            <option value="nenek">Nenek</option>
                            <option value="saudara">Saudara</option>
                            <option value="lainnya">lainnya</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Tambah Data</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?= $this->include('partials/modalRekmed.php') ?>

<?= $this->endSection() ?>