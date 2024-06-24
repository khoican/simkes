<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div class='d-flex gap-3 mt-5 border rounded-3 bg-white p-3'>
    <div class="col-3">
        <?= view_cell('PasienDataCell', ['id' => $id, 'search' => true]) ?>
    </div>

    <div class="w-100 p-3 border rounded-3">
        <form action="" method="post" accept-charset="utf-8" class="fs-6" id="rekmedForm">
            <?= csrf_field() ?>
            <input type="hidden" name="id_pasien" value="<?= $kunjungan['id_pasien'] ?>">
            <input type="hidden" name="id_poli" value="<?= $kunjungan['id_poli'] ?>">
            <input type="hidden" name="id_kunjungan" value="<?= $kunjungan['id_kunjungan'] ?>">
            <input type="hidden" name="method" id="method" value="<?= $method ?>">

            <div class="mb-5">
                <p class="mb-2 fs-5 fw-medium">Alergi</p>

                <div class="d-flex gap-3 w-100 ps-4">
                    <div class="w-100 row g-3 align-items-center">
                        <label for="makanan" class="col-sm-2 col-form-label">Makanan</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control form-control-sm" id="makanan" name="alergi_makanan"
                                value="<?php if($method != 'post') echo $kunjungan['alergi_makanan']; elseif(isset($latestRekmed)) echo $latestRekmed['alergi_makanan'] ?>">
                        </div>
                    </div>
                    <div class="w-100 row g-3 align-items-center">
                        <label for="obat" class="col-sm-2 col-form-label">Obat</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control form-control-sm" id="obat" name="alergi_obat"
                                value="<?php if($method != 'post') echo $kunjungan['alergi_obat']; elseif(isset($latestRekmed)) echo $latestRekmed['alergi_obat'] ?>">
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
                        value="<?php if($method != 'post') echo $kunjungan['rwt_pykt_terdahulu']; elseif(isset($latestRekmed)) echo $latestRekmed['rwt_pykt_terdahulu'] ?>">
                </div>
                <div class="w-100 mb-2">
                    <label for="rwt_pengobatan" class="form-label">Riwayat Pengobatan</label>
                    <input type="text" class="form-control form-control-sm" id="rwt_pengobatan" name="rwt_pengobatan"
                        value="<?php if($method != 'post') echo $kunjungan['rwt_pengobatan']; elseif(isset($latestRekmed)) echo $latestRekmed['rwt_pengobatan'] ?>">
                </div>
                <div class="w-100 mb-2">
                    <label for="rwt_pykt_keluarga" class="form-label">Riwayat Penyakit Keluarga</label>
                    <input type="text" class="form-control form-control-sm" id="rwt_pykt_keluarga"
                        name="rwt_pykt_keluarga"
                        value="<?php if($method != 'post') echo $kunjungan['rwt_pykt_keluarga']; elseif(isset($latestRekmed)) echo $latestRekmed['rwt_pykt_keluarga'] ?>">
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
                <div class="mb-3 row">
                    <div class="col-sm-4">
                        <label class="mb-1" for="bb">Berat Badan</label>
                        <div class="input-group">
                            <input type="number" class="form-control form-control-sm" id="bb" name="bb"
                                value="<?php if($method != 'post') echo $kunjungan['bb'] ?>">
                            <span class="input-group-text fs-6" id="basic-addon2">kg</span>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <label class="mb-1" for="tb">Tinggi Badan</label>
                        <div class="input-group">
                            <input type="number" class="form-control form-control-sm" id="tb" name="tb"
                                value="<?php if($method != 'post') echo $kunjungan['tb'] ?>">
                            <span class="input-group-text fs-6" id="basic-addon2">cm</span>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <label class="mb-1" for="imt">IMT</label>
                        <div class="input-group">
                            <input type="number" class="form-control form-control-sm" id="imt" name="imt"
                                value="<?php if($method != 'post') echo $kunjungan['imt'] ?>" readonly>
                            <span class="input-group-text fs-6" id="basic-addon2">kg/m<sup>2</sup></span>
                        </div>
                    </div>
                </div>
                <div class="mb-3 row">
                    <div class="col-sm-4">
                        <label class="mb-1" for="sistole">Sistole</label>
                        <div class="input-group">
                            <input type="number" class="form-control form-control-sm" id="sistole" name="sistole"
                                value="<?php if($method != 'post') echo $kunjungan['sistole'] ?>">
                            <span class="input-group-text fs-6" id="basic-addon2">mmHg</span>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <label class="mb-1" for="diastole">Diastole</label>
                        <div class="input-group">
                            <input type="number" class="form-control form-control-sm" id="diastole" name="diastole"
                                value="<?php if($method != 'post') echo $kunjungan['diastole'] ?>">
                            <span class="input-group-text fs-6" id="basic-addon2">mmHg</span>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <label class="mb-1" for="nadi">Nadi</label>
                        <div class="input-group">
                            <input type="number" class="form-control form-control-sm" id="nadi" name="nadi"
                                value="<?php if($method != 'post') echo $kunjungan['nadi'] ?>">
                            <span class="input-group-text fs-6" id="basic-addon2">bpm</span>
                        </div>
                    </div>
                </div>
                <div class="mb-3 row">
                    <div class="col-sm-4">
                        <label class="mb-1" for="rr">Respiratory Rate</label>
                        <div class="input-group">
                            <input type="number" class="form-control form-control-sm" id="rr" name="rr"
                                value="<?php if($method != 'post') echo $kunjungan['rr'] ?>">
                            <span class="input-group-text fs-6" id="basic-addon2">/ minute</span>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <label class="mb-1" for="suhu">Suhu (Celcius)</label>
                        <div class="input-group">
                            <input type="number" class="form-control form-control-sm" id="suhu" name="suhu"
                                value="<?php if($method != 'post') echo $kunjungan['suhu'] ?>">
                            <span class="input-group-text fs-6" id="basic-addon2">℃</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mb-5">
                <p class="mb-3 fs-5 fw-medium">Assesment Awal Nyeri (diisi bila ada keluhan nyeri)</p>

                <div class="row">
                    <div class="col-sm-4">
                        <img src="<?= base_url('images/nyeri.png') ?>" alt="" class="img-fluid">
                        <input type="range" class="form-range" min="0" max="10" id="nyeri"
                            value="<?php if($method != 'post') echo $kunjungan['skala_nyeri'] ?>">
                    </div>
                    <div class="col-sm-8">
                        <div class="row g-3 mb-3 align-items-center">
                            <label for="skala_nyeri" class="col-sm-3 col-form-label">Skala Nyeri</label>
                            <div class="col-sm-9">
                                <input type="number" class="form-control form-control-sm" id="skala_nyeri"
                                    name="skala_nyeri"
                                    value="<?php if($method != 'post') echo $kunjungan['skala_nyeri'] ?>">
                            </div>
                        </div>
                        <div class="row g-3 mb-3 align-items-center">
                            <label for="skala_nyeri" class="col-sm-3 col-form-label">Frekuensi Nyeri</label>
                            <div class="col-sm-9">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="frek_nyeri" id="frek_jarang"
                                        value="jarang"
                                        <?php if($method != 'post') if($kunjungan['frek_nyeri'] == 'jarang') echo 'checked' ?> />
                                    <label class="form-check-label" for="frek_jarang">Jarang</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="frek_nyeri"
                                        id="frek_hilang_timbul" value="hilang timbul"
                                        <?php if($method != 'post') if($kunjungan['frek_nyeri'] == 'hilang timbul') echo 'checked' ?> />
                                    <label class="form-check-label" for="frek_hilang_timbul">Hilang Timbul</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="frek_nyeri"
                                        id="frek_terus_menerus" value="terus menerus"
                                        <?php if($method != 'post') if($kunjungan['frek_nyeri'] == 'terus menerus') echo 'checked' ?> />
                                    <label class="form-check-label" for="frek_terus_menerus">Terus Menerus</label>
                                </div>
                            </div>
                        </div>
                        <div class="row g-3 mb-3 align-items-center">
                            <label for="lama_nyeri" class="col-sm-3 col-form-label">Lama Nyeri</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control form-control-sm" id="lama_nyeri"
                                    name="lama_nyeri"
                                    value="<?php if($method != 'post') echo $kunjungan['lama_nyeri'] ?>">
                            </div>
                        </div>
                        <div class="row g-3 mb-3 align-items-center">
                            <label for="menjalar" class="col-sm-3 col-form-label">Menjalar</label>
                            <div class="col-sm-9">
                                <div class="d-flex gap-2 w-100 align-items-center">
                                    <div class="" style="width: 50%;">
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="menjalar"
                                                id="menjalar_tidak" value="tidak"
                                                <?php if($method != 'post') if($kunjungan['menjalar'] == 'tidak') echo 'checked' ?> />
                                            <label class="form-check-label" for="menjalar_tidak">Tidak</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="menjalar"
                                                id="menjalar_iya" value="ya"
                                                <?php if($method != 'post') if($kunjungan['menjalar'] == 'ya') echo 'checked' ?> />
                                            <label class="form-check-label" for="menjalar_iya">Iya, ke</label>
                                        </div>
                                    </div>
                                    <input type="text" class="form-control form-control-sm" style="width: 50%;"
                                        id="menjalar_ket" name="menjalar_ket" placeholder="..."
                                        value="<?php if($method != 'post') echo $kunjungan['menjalar_ket'] ?>">
                                </div>
                            </div>
                        </div>
                        <div class="row g-3 mb-3 align-items-center">
                            <label for="kualitas_nyeri" class="col-sm-3 col-form-label">Kualitas Nyeri</label>
                            <div class="col-sm-9">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="kualitas_nyeri"
                                        id="kualitas_tumpul" value="tumpul"
                                        <?php if($method != 'post') if($kunjungan['kualitas_nyeri'] == 'tumpul') echo 'checked' ?> />
                                    <label class="form-check-label" for="kualitas_tumpul">Nyeri Tumpul</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="kualitas_nyeri" id="kualitas"
                                        value="tajam"
                                        <?php if($method != 'post') if($kunjungan['kualitas_nyeri'] == 'tajam') echo 'checked' ?> />
                                    <label class="form-check-label" for="kualitas">kualitas Tajam</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="kualitas_nyeri"
                                        id="kualitas_panas" value="panas"
                                        <?php if($method != 'post') if($kunjungan['kualitas_nyeri'] == 'panas') echo 'checked' ?> />
                                    <label class="form-check-label" for="kualitas_panas">Panas Terbakar</label>
                                </div>
                            </div>
                        </div>
                        <div class="row g-3 mb-3 align-items-center">
                            <label for="fakt_pemicu" class="col-sm-3 col-form-label">Faktor Pemicu</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control form-control-sm" id="fakt_pemicu"
                                    name="fakt_pemicu"
                                    value="<?php if($method != 'post') echo $kunjungan['fakt_pemicu'] ?>">
                            </div>
                        </div>
                        <div class="row g-3 mb-3 align-items-center">
                            <label for="fakt_pengurang" class="col-sm-3 col-form-label">Faktor Pereda</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control form-control-sm" id="fakt_pengurang"
                                    name="fakt_pengurang"
                                    value="<?php if($method != 'post') echo $kunjungan['fakt_pengurang'] ?>">
                            </div>
                        </div>
                        <div class="row g-3 mb-3 align-items-center">
                            <label for="lokasi_nyeri" class="col-sm-3 col-form-label">Lokasi Nyeri</label>
                            <div class="col-sm-9">
                                <select class="form-select form-select-sm" aria-label="Small select example"
                                    name="lokasi_nyeri" id="lokasi_nyeri">
                                    <option value="">Pilih lokasi nyeri</option>
                                    <option value="kepala"
                                        <?php if (isset($kunjungan['lokasi_nyeri']) && $kunjungan['lokasi_nyeri'] == 'kepala') echo 'selected'; ?>>
                                        Kepala</option>
                                    <option value="dada"
                                        <?php if (isset($kunjungan['lokasi_nyeri']) && $kunjungan['lokasi_nyeri'] == 'dada') echo 'selected'; ?>>
                                        Dada</option>
                                    <option value="perut"
                                        <?php if (isset($kunjungan['lokasi_nyeri']) && $kunjungan['lokasi_nyeri'] == 'perut') echo 'selected'; ?>>
                                        Perut</option>
                                    <option value="genetalia"
                                        <?php if (isset($kunjungan['lokasi_nyeri']) && $kunjungan['lokasi_nyeri'] == 'genetalia') echo 'selected'; ?>>
                                        Genetalia</option>
                                    <option value="anus"
                                        <?php if (isset($kunjungan['lokasi_nyeri']) && $kunjungan['lokasi_nyeri'] == 'anus') echo 'selected'; ?>>
                                        Anus</option>
                                    <option value="ekstremitas"
                                        <?php if (isset($kunjungan['lokasi_nyeri']) && $kunjungan['lokasi_nyeri'] == 'ekstremitas') echo 'selected'; ?>>
                                        Ekstremitas</option>
                                    <option value="sistem pernapasan"
                                        <?php if (isset($kunjungan['lokasi_nyeri']) && $kunjungan['lokasi_nyeri'] == 'sistem pernapasan') echo 'selected'; ?>>
                                        Sistem Pernapasan</option>
                                    <option value="sistem kardiovaskuler"
                                        <?php if (isset($kunjungan['lokasi_nyeri']) && $kunjungan['lokasi_nyeri'] == 'sistem kardiovaskuler') echo 'selected'; ?>>
                                        Sistem Kardiovaskuler</option>
                                    <option value="sistem neurologis"
                                        <?php if (isset($kunjungan['lokasi_nyeri']) && $kunjungan['lokasi_nyeri'] == 'sistem neurologis') echo 'selected'; ?>>
                                        Sistem Neurologis</option>
                                    <option value="sistem gastrointestinal"
                                        <?php if (isset($kunjungan['lokasi_nyeri']) && $kunjungan['lokasi_nyeri'] == 'sistem gastrointestinal') echo 'selected'; ?>>
                                        Sistem Gastrointestinal</option>
                                    <option value="sistem perkemihan"
                                        <?php if (isset($kunjungan['lokasi_nyeri']) && $kunjungan['lokasi_nyeri'] == 'sistem perkemihan') echo 'selected'; ?>>
                                        Sistem Perkemihan</option>
                                    <option value="sistem integumen"
                                        <?php if (isset($kunjungan['lokasi_nyeri']) && $kunjungan['lokasi_nyeri'] == 'sistem integumen') echo 'selected'; ?>>
                                        Sistem Integumen</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mb-5">
                <p class="mb-2 fs-5 fw-medium">Diagnosa</p>

                <div class="d-flex gap-3 mb-3">
                    <div class="w-50">
                        <p class="mb-1">Diagnosa Utama</p>
                        <select class="form-select-sm diagnosa text-capitalize" name="diagnosa-utama" data-width="100%"
                            data-placeholder="Pilih Diagnosa Utama">
                            <option></option>
                            <?php foreach($diagnosas as $diagnosa) : ?>
                            <?php 
                            $selected = '';
                            if ($method != 'post') {
                                foreach ($diagnosaPasiens as $diagnosaPasien) {
                                    if ($diagnosaPasien['id_diagnosa'] == $diagnosa['id'] && $diagnosaPasien['status'] == 'utama') {
                                        $selected = 'selected';
                                        break;
                                    }
                                }
                            }
                            ?>

                            <option value=" <?= $diagnosa['id'] ?>" class="text-uppercase" <?= $selected ?>>
                                <?= $diagnosa['kode'] ?> -
                                <?= $diagnosa['diagnosa'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="w-50">
                        <p class="mb-1">Diagnosa Sekunder</p>
                        <select class="form-select-sm diagnosa text-capitalize" name="diagnosa-sekunder"
                            data-width="100%" data-placeholder="Pilih Diagnosa Sekunder">
                            <option></option>
                            <?php foreach($diagnosas as $diagnosa) : 
                            $selected = '';
                            if ($method != 'post') {
                                foreach ($diagnosaPasiens as $diagnosaPasien) {
                                    if ($diagnosaPasien['id_diagnosa'] == $diagnosa['id'] && $diagnosaPasien['status'] == 'sekunder') {
                                        $selected = 'selected';
                                        break;
                                    }
                                }
                            }
                            ?>

                            <option value=" <?= $diagnosa['id'] ?>" class="text-uppercase" <?= $selected ?>>
                                <?= $diagnosa['kode'] ?> -
                                <?= $diagnosa['diagnosa'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="w-100 mb-3">
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

                        <option value="<?= $tindakan['id'] ?>" class="text-uppercase" <?= $selected ?>>
                            <?= $tindakan['kode'] ?> -
                            <?= $tindakan['tindakan'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>

            <div class="row g-3 mb-5 align-items-center">
                <label for="lokasi_nyeri" class="col-sm-2 col-form-label">Status Pulang</label>
                <div class="col-sm-10">
                    <select name="status_pulang" id="status_pulang" class="form-select form-select-sm">
                        <option selected>Pilih Status Pulang</option>
                        <option value="rujuk"
                            <?php if(isset($statusPulang) && $statusPulang == false) echo 'selected' ?>>Rujuk</option>
                        <option value="obat" <?php if(isset($statusPulang) && $statusPulang == true) echo 'selected' ?>>
                            Berobat Jalan</option>
                    </select>
                </div>
            </div>

            <div class="mb-5" id="resep-obat"
                style="<?php if(isset($statusPulang)) echo 'display: block'; else echo 'display: none' ?>">
                <p class="mb-2 fs-5 mt-4 fw-medium">Resep</p>
                <div class="d-flex gap-2 align-items-center mb-1">
                    <p class="mb-0" style="width: 35%;">Nama Obat</p>
                    <p class="mb-0" style="width: 15%;">Satuan</p>
                    <p class="mb-0" style="width: 10%;">Signa</p>
                    <p class="mb-0" style="width: 15%;">Keterangan</p>
                    <p class="mb-0" style="width: 15%;">Jumlah Resep</p>
                    <p class="mb-0" style="width: 5%;">Aksi</p>
                </div>
                <div id="resep">
                    <?php
                    if ($method != 'post' && count($obatPasiens) > 0) :
                        foreach ($obatPasiens as $index => $obatPasien) : ?>
                    <div class="d-flex gap-3 mb-2" id="resep-<?= $index ?>">
                        <select name="obat[]" data-width="35%" data-placeholder="Pilih Obat"
                            class="form-select-sm diagnosa w-75">
                            <option></option>
                            <?php foreach($obats as $obat) : 
                                        $selected = ($obat['id'] == $obatPasien['id_obat']) ? 'selected' : '';
                                    ?>
                            <option value="<?= $obat['id'] ?>" class="text-uppercase" <?= $selected ?>>
                                <?= $obat['kode'] ?> -
                                <?= $obat['obat'] ?></option>
                            <?php endforeach; ?>
                        </select>
                        <input type="text" class="form-control form-control-sm" style="width: 15%;" name="jml_resep[]"
                            value="<?= $obatPasien['jenis'] ?>">
                        <div class="d-flex align-items-center gap-1" style="width: 10%;">
                            <input type="number" class="form-control form-control-sm" style="width: 40%;" name="resep[]"
                                placeholder="" value="<?= substr($obatPasien['signa'], 0, 1) ?>">
                            <div class="d-flex align-items-center justify-content-center" style="width: 20%;">
                                <i class="bi bi-x fs-4"></i>
                            </div>
                            <input type="number" class="form-control form-control-sm" style="width: 40%;"
                                name="resep2[]" placeholder="" value="<?= substr($obatPasien['signa'], 4, 1) ?>">
                        </div>
                        <input type="text" class="form-control form-control-sm" style="width: 15%;" name="ket[]"
                            value="<?= $obatPasien['ket'] ?>">
                        <input type="text" class="form-control form-control-sm" style="width: 15%;" name="jml_resep[]"
                            value="<?= $obatPasien['jml_resep'] ?>">
                        <button type="button" class="btn btn-sm btn-danger fs-6 delete-resep" data-id="<?= $index ?>"
                            style="width: 5%;"><i class="bi bi-trash fs-6"></i></button>
                    </div>
                    <?php endforeach; 
                    else : ?>
                    <div class="d-flex gap-2 mb-2 resep-data" id="resep-0">
                        <select name="obat[]" data-width="35%" data-placeholder="Pilih Obat"
                            class="form-select-sm diagnosa w-75 id-obat" data-col="0">
                            <option></option>
                            <?php foreach($obats as $obat) :?>
                            <option value="<?= $obat['id'] ?>" class="text-uppercase"><?= $obat['kode'] ?> -
                                <?= $obat['obat'] ?></option>
                            <?php endforeach; ?>
                        </select>
                        <input type="text" class="form-control form-control-sm satuan-0" style="width: 15%;"
                            name="satuan[]">
                        <div class="d-flex align-items-center gap-1" style="width: 10%;">
                            <input type="number" class="form-control form-control-sm" style="width: 40%;"
                                name="resep[]">
                            <div class="d-flex align-items-center justify-content-center" style="width: 20%;">
                                <i class="bi bi-x fs-4"></i>
                            </div>
                            <input type="number" class="form-control form-control-sm" style="width: 40%;"
                                name="resep2[]">
                        </div>
                        <input type="text" class="form-control form-control-sm" style="width: 15%;" name="ket[]">
                        <input type="text" class="form-control form-control-sm" style="width: 15%;" name="jml_resep[]">
                        <button type="button" class="btn btn-sm btn-danger fs-6 delete-resep" data-id="0"
                            style="width: 5%;"><i class="bi bi-trash fs-6"></i></button>
                    </div>
                    <?php endif; ?>
                </div>
                <div class="text-end">
                    <button type="button" id="tambah" class="btn btn-primary btn-sm text-end"><i class="bi bi-plus"></i>
                        Tambah</button>
                </div>
            </div>

            <div id="onsubmit">
                <button type="submit" class="btn btn-primary rounded-pill" id='submit'>Simpan</button>
                <a href="/rekmed/<?= $id ?>" class="btn btn-outline-secondary rounded-pill">Batal</a>
            </div>
        </form>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('script') ?>
<script type="module">
$(document).ready(function() {
    $('#nyeri').on('input', function() {
        $('#skala_nyeri').val($(this).val());
    })

    $('#status_pulang').on('change', function() {
        if ($(this).val() == 'obat') {
            $('#resep-obat').show()
        } else {
            $('#resep-obat').hide()
        }
    })

    function method() {
        if ($('#method').val() == 'post') {
            console.log('POST');
            $('#rekmedForm').attr('action', '/rekmed/store/<?= $id ?>');
        } else if ($('#method').val() == 'edit') {
            console.log('PUT');
            $('#rekmedForm').attr('action', '/rekmed/update/<?= $kunjungan['id_kunjungan'] ?>');
        } else {
            $('.form-control').attr('readonly', true);
            $('.form-check-input, .form-select-sm').attr('disabled', true);
            $('#tambah, .delete-resep').remove();
            $('#submit').remove();
        }
    }
    method();

    function imt() {
        $('#bb, #tb').on('input', function() {
            let bb = Number($('#bb').val());
            let tb = Number($('#tb').val());

            if (bb > 0 && tb > 0) {
                let imtValue = bb / Math.pow((tb / 100), 2);
                $('#imt').val(imtValue.toFixed(2));
            } else {
                $('#imt').val('');
            }
        });
    }
    imt()

    function select2Style() {
        $('.diagnosa').select2({
            theme: "bootstrap-5",
            placeholder: $(this).data('placeholder'),
            selectionCssClass: 'select2--small',
            dropdownCssClass: 'select2--small',
            closeOnSelect: true,
            allowClear: true,
            width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('w-100') ? '100%' :
                'style',
        });
    }
    select2Style();

    $('#tambah').on('click', () => {
        let id = $('#resep').children().length;
        $('#resep').append(`
            <div class="d-flex gap-2 mb-2 resep-data" id="resep-${id}">
                <select name="obat[]" data-width="35%" data-placeholder="Pilih Obat"
                    class="form-select-sm diagnosa w-75 id-obat" data-col="${id}">
                    <option></option>
                    <?php foreach($obats as $obat) :?>
                    <option value="<?= $obat['id'] ?>" class="text-uppercase"><?= $obat['kode'] ?> -
                        <?= $obat['obat'] ?></option>
                    <?php endforeach; ?>
                </select>
                <input type="text" class="form-control form-control-sm satuan-${id}" style="width: 15%;" name="satuan[]">
                <div class="d-flex align-items-center gap-1" style="width: 10%;">
                    <input type="number" class="form-control form-control-sm" style="width: 40%;"
                        name="resep[]">
                    <div class="d-flex align-items-center justify-content-center" style="width: 20%;">
                        <i class="bi bi-x fs-4"></i>
                    </div>
                    <input type="number" class="form-control form-control-sm" style="width: 40%;"
                        name="resep2[]">
                </div>
                <input type="text" class="form-control form-control-sm" style="width: 15%;" name="ket[]">
                <input type="text" class="form-control form-control-sm" style="width: 15%;" name="jml_resep[]">
                <button type="button" class="btn btn-sm btn-danger fs-6 delete-resep" data-id="0"
                    style="width: 5%;"><i class="bi bi-trash fs-6"></i></button>
            </div>
        `);

        select2Style();
    })

    $('#resep').on('change', '.id-obat', function() {
        let obatId = $(this).val();
        let col = $(this).data('col');
        console.log('selected');

        if (obatId) {
            $.ajax({
                url: `/obat/${obatId}`,
                method: 'get',
                success: function(data) {
                    console.log(data);
                    $(`#resep-${col} .satuan-${col}`).val(data.jenis);
                },
                error: function(xhr, status, error) {
                    console.error('Terjadi kesalahan saat mengambil data obat:', error);
                }
            });
        }
    });

    $('#resep').on('click', 'button', function() {
        $(this).parent().remove();
    })
})
</script>


<?= $this->endSection() ?>