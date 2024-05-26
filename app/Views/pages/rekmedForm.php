<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div class='d-flex gap-3 mt-5 border rounded-3 bg-white p-3'>
    <div class="col-3">
        <?= view_cell('PasienDataCell', ['id' => $kunjungan['id_pasien']]) ?>
    </div>

    <div class="w-100 p-3 border rounded-3">
        <form action="" method="post" accept-charset="utf-8" class="fs-6" id="rekmedForm">
            <?= csrf_field() ?>
            <input type="hidden" name="id_pasien" value="<?= $kunjungan['id_pasien'] ?>">
            <input type="hidden" name="id_poli" value="<?= $kunjungan['id_poli'] ?>">
            <input type="hidden" name="id_kunjungan" value="<?= $kunjungan['id'] ?>">
            <input type="hidden" name="method" id="method" value="<?= $method ?>">

            <div class="mb-5">
                <p class="mb-2 fs-5 fw-medium">Alergi</p>

                <div class="d-flex gap-3 w-100 ps-4">
                    <div class="w-100 row g-3 align-items-center">
                        <label for="makanan" class="col-sm-2 col-form-label">Makanan</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control form-control-sm" id="makanan" name="alergi_makanan"
                                value="<?php if($method != 'post') echo $kunjungan['alergi_makanan'] ?>">
                        </div>
                    </div>
                    <div class="w-100 row g-3 align-items-center">
                        <label for="obat" class="col-sm-2 col-form-label">Obat</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control form-control-sm" id="obat" name="alergi_obat"
                                value="<?php if($method != 'post') echo $kunjungan['alergi_obat'] ?>">
                        </div>
                    </div>
                </div>
            </div>

            <div class="mb-5">
                <p class="mb-2 fs-5 fw-medium">Riwayat Kesehatan</p>

                <div class="w-100 mb-2">
                    <label for="rwt_pykt_terdahulu" class="form-label">Riwayat Penyakit Terdahulu</label>
                    <input type="text" class="form-control form-control-sm" id="rwt_pykt_terdahulu"
                        name="rwt_pykt_terdahulu"
                        value="<?php if($method != 'post') echo $kunjungan['rwt_pykt_terdahulu'] ?>">
                </div>
                <div class="w-100 mb-2">
                    <label for="rwt_pengobatan" class="form-label">Riwayat Pengobatan</label>
                    <input type="text" class="form-control form-control-sm" id="rwt_pengobatan" name="rwt_pengobatan"
                        value="<?php if($method != 'post') echo $kunjungan['rwt_pengobatan'] ?>">
                </div>
                <div class="w-100 mb-2">
                    <label for="rwt_pykt_keluarga" class="form-label">Riwayat Penyakit Keluarga</label>
                    <input type="text" class="form-control form-control-sm" id="rwt_pykt_keluarga"
                        name="rwt_pykt_keluarga"
                        value="<?php if($method != 'post') echo $kunjungan['rwt_pykt_keluarga'] ?>">
                </div>
            </div>

            <div class="mb-5">
                <p class="mb-2 fs-5 fw-medium">Pemeriksaan Subjektif</p>

                <div class="w-100 mb-2">
                    <label for="keluhan" class="form-label">Keluhan Utama</label>
                    <input type="text" class="form-control form-control-sm" id="keluhan" name="keluhan"
                        value="<?php if($method != 'post') echo $kunjungan['keluhan'] ?>">
                </div>
            </div>

            <div class="mb-5">
                <p class="mb-2 fs-5 fw-medium">Riwayat Psikososial dan Ekonomi</p>

                <div class="row mb-1">
                    <p class="col-4">Hubungan Pasien Dengan Keluarga</p>

                    <div class="col-8">
                        <fieldset id="hbg-dgn-keluarga">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="hbg_dgn_keluarga" id="baik"
                                    value="baik"
                                    <?php if($method != 'post') if($kunjungan['hbg_dgn_keluarga'] == 'baik') echo 'checked' ?>>
                                <label class="form-check-label" for="baik">Baik</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="hbg_dgn_keluarga" id="tidak-baik"
                                    value="tidak baik"
                                    <?php if($method != 'post') if($kunjungan['hbg_dgn_keluarga'] == 'tidak baik') echo 'checked' ?>>
                                <label class="form-check-label" for="tidak-baik">Tidak Baik</label>
                            </div>
                        </fieldset>
                    </div>
                </div>
                <div class="row mb-1">
                    <p class="col-4">Status Psikologi</p>

                    <div class="col-8">
                        <fieldset id="sts-psikologi">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="sts_psikologi" id="tenang"
                                    value="tenang"
                                    <?php if($method != 'post') if($kunjungan['sts_psikologi'] == 'tenang') echo 'checked' ?>>
                                <label class="form-check-label" for="tenang">Tenang</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="sts_psikologi" id="lemas"
                                    value="lemas"
                                    <?php if($method != 'post') if($kunjungan['sts_psikologi'] == 'lemas') echo 'checked' ?>>
                                <label class="form-check-label" for="lemas">Lemas</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="sts_psikologi" id="takut"
                                    value="takut"
                                    <?php if($method != 'post') if($kunjungan['sts_psikologi'] == 'takut') echo 'checked' ?>>
                                <label class="form-check-label" for="takut">Takut</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="sts_psikologi" id="marah"
                                    value="marah"
                                    <?php if($method != 'post') if($kunjungan['sts_psikologi'] == 'marah') echo 'checked' ?>>
                                <label class="form-check-label" for="marah">Marah</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="sts_psikologi" id="sedih"
                                    value="sedih"
                                    <?php if($method != 'post') if($kunjungan['sts_psikologi'] == 'sedih') echo 'checked' ?>>
                                <label class="form-check-label" for="sedih">Sedih</label>
                            </div>
                        </fieldset>
                    </div>
                </div>

                <div class="row g-3 align-items-center">
                    <label for="pekerjaan" class="col-sm-2 col-form-label">Pekerjaan</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control form-control-sm" id="pekerjaan" name="pekerjaan"
                            value="<?= $kunjungan['pekerjaan_pasien'] ?>" readonly>
                    </div>
                </div>
            </div>

            <div class="mb-5">
                <p class="mb-2 fs-5 fw-medium">Pemeriksaan Objektif</p>

                <div class="row mb-1">
                    <p class="col-4">Keadaan Umum</p>

                    <div class="col-8">
                        <fieldset id="keadaan">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="keadaan" id="keadaan-baik"
                                    value="baik"
                                    <?php if($method != 'post') if($kunjungan['keadaan'] == 'baik') echo 'checked' ?>>
                                <label class="form-check-label" for="keadaan-baik">Baik</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="keadaan" id="sedang" value="sedang"
                                    <?php if($method != 'post') if($kunjungan['keadaan'] == 'sedang') echo 'checked' ?>>
                                <label class="form-check-label" for="sedang">Sedang</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="keadaan" id="cukup" value="cukup"
                                    <?php if($method != 'post') if($kunjungan['keadaan'] == 'cukup') echo 'checked' ?>>
                                <label class="form-check-label" for="cukup">Cukup</label>
                            </div>
                        </fieldset>
                    </div>
                </div>
                <div class="row mb-1">
                    <p class="col-4">Kesadaran</p>

                    <div class="col-8">
                        <fieldset id="kesadaran">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="kesadaran" id="compos-mentis"
                                    value="compos mentis"
                                    <?php if($method != 'post') if($kunjungan['kesadaran'] == 'compos mentis') echo 'checked' ?>>
                                <label class="form-check-label" for="compos-mentis">Compos Mentis</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="kesadaran" id="samnolen"
                                    value="samnolen"
                                    <?php if($method != 'post') if($kunjungan['kesadaran'] == 'samnolen') echo 'checked' ?>>
                                <label class="form-check-label" for="samnolen">Samnolen</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="kesadaran" id="stupor" value="stupor"
                                    <?php if($method != 'post') if($kunjungan['kesadaran'] == 'stupor') echo 'checked' ?>>
                                <label class="form-check-label" for="stupor">Stupor</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="kesadaran" id="coma" value="coma"
                                    <?php if($method != 'post') if($kunjungan['kesadaran'] == 'coma') echo 'checked' ?>>
                                <label class="form-check-label" for="coma">Coma</label>
                            </div>
                        </fieldset>
                    </div>
                </div>
            </div>

            <div class="mb-5">
                <p class="mb-2 fs-5 fw-medium">Pemeriksaan Assessment</p>

                <div class="d-flex gap-3 mb-3">
                    <div class="w-50">
                        <p class="mb-1">Diagnosa Pasien</p>
                        <select class="form-select-sm diagnosa text-capitalize" name="diagnosa[]" data-width="100%"
                            data-placeholder="Pilih Diagnosa" multiple>
                            <?php foreach($diagnosas as $diagnosa) : ?>
                            <?php 
                            $selected = '';
                            if ($method != 'post') {
                                foreach ($diagnosaPasiens as $diagnosaPasien) {
                                    if ($diagnosaPasien['id_diagnosa'] == $diagnosa['id']) {
                                        $selected = 'selected';
                                        break;
                                    }
                                }
                            }
                            ?>

                            <option value=" <?= $diagnosa['id'] ?>" <?= $selected ?>>
                                <?= $diagnosa['kode'] ?> -
                                <?= $diagnosa['diagnosa'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="w-50">
                        <p class="mb-1">Tindakan Terhadap Pasien</p>
                        <select class="form-select-sm diagnosa" name="tindakan[]" data-width="100%"
                            data-placeholder="Pilih Tindakan" multiple>
                            <?php foreach($tindakans as $tindakan) : ?>

                            <?php 
                            $selected = '';
                            if ($method != 'post') {
                                foreach ($tindakanPasiens as $tindakanPasien) {
                                    if ($tindakanPasien['id_tindakan'] == $tindakan['id']) {
                                        $selected = 'selected';
                                        break;
                                    }
                                }
                            }
                            ?>

                            <option value="<?= $tindakan['id'] ?>" <?= $selected ?>><?= $tindakan['kode'] ?> -
                                <?= $tindakan['tindakan'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>

                <div class="d-flex justify-content-between align-items-center mb-1">
                    <p class="mb-0">Resep Obat</p>
                    <div class="btn btn-sm btn-primary fs-6" id="tambah">
                        <i class="bi bi-plus fs-6"></i>
                        Tambah Resep
                    </div>
                </div>
                <div id="resep">
                    <?php
                    if ($method != 'post') :
                        foreach ($obatPasiens as $index => $obatPasien) : ?>
                    <div class="d-flex gap-3 mb-2" id="resep-<?= $index ?>">
                        <select name="obat[]" data-width="75%" data-placeholder="Pilih Obat"
                            class="form-select-sm diagnosa w-75">
                            <option></option>
                            <?php foreach($obats as $obat) : 
                                        $selected = ($obat['id'] == $obatPasien['id_obat']) ? 'selected' : '';
                                    ?>
                            <option value="<?= $obat['id'] ?>" <?= $selected ?>><?= $obat['kode'] ?> -
                                <?= $obat['obat'] ?></option>
                            <?php endforeach; ?>
                        </select>
                        <input type="number" class="form-control form-control-sm" style="width: 20%;" name="qty[]"
                            placeholder="Quantity" value="<?= $obatPasien['qty'] ?>">
                        <button type="button" class="btn btn-sm btn-danger fs-6 delete-resep" data-id="<?= $index ?>"
                            style="width: 5%;"><i class="bi bi-trash fs-6"></i></button>
                    </div>
                    <?php endforeach; 
                    else : ?>
                    <div class="d-flex gap-3 mb-2" id="resep-0">
                        <select name="obat[]" data-width="75%" data-placeholder="Pilih Obat"
                            class="form-select-sm diagnosa w-75">
                            <option></option>
                            <?php foreach($obats as $obat) :?>
                            <option value="<?= $obat['id'] ?>"><?= $obat['kode'] ?> -
                                <?= $obat['obat'] ?></option>
                            <?php endforeach; ?>
                        </select>
                        <input type="number" class="form-control form-control-sm" style="width: 20%;" name="qty[]"
                            placeholder="Quantity">
                        <button type="button" class="btn btn-sm btn-danger fs-6 delete-resep" data-id="0"
                            style="width: 5%;"><i class="bi bi-trash fs-6"></i></button>
                    </div>
                    <?php endif; ?>
                </div>
            </div>

            <div id="onsubmit">
                <button type="submit" class="btn btn-primary rounded-pill">Simpan</button>
                <a href="/pemeriksaan" class="btn btn-outline-secondary rounded-pill">Batal</a>
            </div>
        </form>
    </div>
</div>

<script>
$(document).ready(function() {
    function method() {
        if ($('#method').val() == 'post') {
            console.log('POST');
            $('#rekmedForm').attr('action', '/rekmed/store/<?= $kunjungan['id_pasien'] ?>');
        } else if ($('#method').val() == 'edit') {
            console.log('PUT');
            $('#rekmedForm').attr('action', '/rekmed/update/<?= $kunjungan['id'] ?>');
        } else {
            $('.form-control').attr('readonly', true);
            $('.form-check-input, .form-select-sm').attr('disabled', true);
            $('#tambah, .delete-resep').remove();
            $('#onsubmit').remove();
        }
    }
    method();

    function select2Style() {
        $('.diagnosa').select2({
            theme: "bootstrap-5",
            placeholder: $(this).data('placeholder'),
            selectionCssClass: 'select2--small',
            dropdownCssClass: 'select2--small',
            closeOnSelect: true,
            width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('w-100') ? '100%' :
                'style',
        });
    }
    select2Style();

    $('#tambah').on('click', () => {
        let id = $('#resep').children().length;
        $('#resep').append(`
            <div class="d-flex gap-3 mb-2" id="resep-${id}">
                <select name="obat[]" data-width="75%" data-placeholder="Pilih Obat"
                    class="form-select-sm diagnosa w-75">
                    <option></option>
                    <option></option>
                    <?php foreach($obats as $obat) : ?>
                    <option value="<?= $obat['id'] ?>"><?= $obat['kode'] ?> - <?= $obat['obat'] ?></option>
                    <?php endforeach; ?>
                </select>
                <input type="number" class="form-control form-control-sm" style="width: 20%;" name="qty[]"
                    placeholder="Quantity">
                <button type="button" class="btn btn-sm btn-danger fs-6" data-id="${id}" style="width: 5%;"><i
                        class="bi bi-trash fs-6"></i></button>
            </div>
        `);

        select2Style();
    })

    $('#resep').on('click', 'button', function() {
        $(this).parent().remove();
    })
})
</script>


<?= $this->endSection() ?>