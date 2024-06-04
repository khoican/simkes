<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div class='d-flex gap-3 mt-5 border rounded-3 bg-white p-3'>
    <div class="col-3">
        <?= view_cell('PasienDataCell', ['id' => $pasienId]) ?>
    </div>

    <div class="w-100">

        <?php foreach ($rekmedPasiens as $rekmedPasien) : ?>
        <div
            class="w-100 fs-6 border border-primary d-flex align-items-center py-2 px-3 rounded-3 border border-primary mb-1">
            <div class="col-2">
                <p class="mb-0"><?= format_date($rekmedPasien['created_at']) ?></p>
            </div>
            <div class="col-3">
                <p class="mb-0 fw-medium">Keluhan : <span
                        class="text-capitalize fw-normal"><?= $rekmedPasien['keluhan'] ?></span>
                </p>
            </div>
            <div class="col-3">
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
            <div class="col-2 d-flex justify-content-center">
                <div class="btn btn-sm btn-success">
                    <p class="mb-0 text-uppercase"><?= $rekmedPasien['poli'] ?></p>
                </div>
            </div>
            <div class="col-2 d-flex gap-1 justify-content-center">
                <a href="/pemeriksaan/<?= $kunjunganId ?>/show/<?= $rekmedPasien['id'] ?>"
                    class="btn btn-sm h-100 btn-primary">
                    <i class="bi bi-eye-fill fs-4"></i>
                </a>
                <a href="/pemeriksaan/<?= $kunjunganId ?>/edit/<?= $rekmedPasien['id'] ?>"
                    class="btn btn-sm h-100 btn-warning">
                    <i class="bi bi-pencil-square fs-4"></i>
                </a>
                <form action="/rekmed/delete/<?= $rekmedPasien['id'] ?>/<?= $kunjunganId ?>" method="post">
                    <?= csrf_field() ?>
                    <button type="submit" class="btn btn-sm h-100 btn-danger">
                        <i class="bi bi-trash-fill fs-4"></i>
                    </button>
                </form>
            </div>
        </div>
        <?php endforeach ?>

        <div class="w-100 h-auto mt-5 d-flex flex-column justify-content-center align-items-center">
            <a href="/pemeriksaan/<?= $kunjunganId ?>/new" class="btn btn-primary rounded-circle">
                <i class="bi bi-plus fs-2 text-white mb-0"></i>
            </a>
            <p class="fs-5 ms-3 mb-0 fw-medium">Rekam Medis</p>
        </div>
    </div>
</div>

<?= $this->endSection() ?>