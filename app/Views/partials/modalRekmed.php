<div class="modal fade" id="rekmedModal" tabindex="-1" aria-labelledby="rekmedModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="rekmedModalLabel">Rekam Medis</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body fs-6" id="rekmedModalBody">
                <div class="mb-5">
                    <p class="mb-2 fs-5 fw-medium">Alergi</p>

                    <div class="d-flex gap-3 w-100 ps-4">
                        <div class="w-100 row g-3 align-items-center">
                            <label for="makanan" class="col-sm-2 col-form-label">Makanan</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control form-control-sm" id="makanan"
                                    name="alergi_makanan" value="">
                            </div>
                        </div>
                        <div class="w-100 row g-3 align-items-center">
                            <label for="obat" class="col-sm-2 col-form-label">Obat</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control form-control-sm" id="obat" name="alergi_obat"
                                    value="">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mb-5">
                    <p class="mb-2 fs-5 fw-medium">Riwayat Kesehatan</p>

                    <div class="w-100 mb-2">
                        <label for="rwt_pykt_terdahulu" class="form-label">Riwayat Penyakit Terdahulu</label>
                        <input type="text" class="form-control form-control-sm" id="rwt_pykt_terdahulu"
                            name="rwt_pykt_terdahulu" value="">
                    </div>
                    <div class="w-100 mb-2">
                        <label for="rwt_pengobatan" class="form-label">Riwayat Pengobatan</label>
                        <input type="text" class="form-control form-control-sm" id="rwt_pengobatan"
                            name="rwt_pengobatan" value="">
                    </div>
                    <div class="w-100 mb-2">
                        <label for="rwt_pykt_keluarga" class="form-label">Riwayat Penyakit Keluarga</label>
                        <input type="text" class="form-control form-control-sm" id="rwt_pykt_keluarga"
                            name="rwt_pykt_keluarga" value="">
                    </div>
                </div>

                <div class="mb-5">
                    <p class="mb-2 fs-5 fw-medium">Pemeriksaan Subjektif</p>

                    <div class="w-100 mb-2">
                        <label for="keluhan" class="form-label">Keluhan Utama</label>
                        <input type="text" class="form-control form-control-sm" id="keluhan" name="keluhan" value="">
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
                                        value="baik">
                                    <label class="form-check-label" for="baik">Baik</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="hbg_dgn_keluarga" id="tidak-baik"
                                        value="tidak baik">
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
                                        value="tenang">
                                    <label class="form-check-label" for="tenang">Tenang</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="sts_psikologi" id="lemas"
                                        value="lemas">
                                    <label class="form-check-label" for="lemas">Lemas</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="sts_psikologi" id="takut"
                                        value="takut">
                                    <label class="form-check-label" for="takut">Takut</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="sts_psikologi" id="marah"
                                        value="marah">
                                    <label class="form-check-label" for="marah">Marah</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="sts_psikologi" id="sedih"
                                        value="sedih">
                                    <label class="form-check-label" for="sedih">Sedih</label>
                                </div>
                            </fieldset>
                        </div>
                    </div>

                    <div class="row g-3 align-items-center">
                        <label for="pekerjaan" class="col-sm-2 col-form-label">Pekerjaan</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control form-control-sm" id="pekerjaan" name="pekerjaan"
                                readonly>
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
                                        value="baik">
                                    <label class="form-check-label" for="keadaan-baik">Baik</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="keadaan" id="sedang"
                                        value="sedang">
                                    <label class="form-check-label" for="sedang">Sedang</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="keadaan" id="cukup"
                                        value="cukup">
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
                                        value="compos mentis">
                                    <label class="form-check-label" for="compos-mentis">Compos Mentis</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="kesadaran" id="samnolen"
                                        value="samnolen">
                                    <label class="form-check-label" for="samnolen">Samnolen</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="kesadaran" id="stupor"
                                        value="stupor">
                                    <label class="form-check-label" for="stupor">Stupor</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="kesadaran" id="coma"
                                        value="coma">
                                    <label class="form-check-label" for="coma">Coma</label>
                                </div>
                            </fieldset>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <div class="col-sm-4">
                            <label class="mb-1" for="bb">Berat Badan</label>
                            <input type="number" class="form-control form-control-sm" id="bb" name="bb" value="">
                        </div>
                        <div class="col-sm-4">
                            <label class="mb-1" for="tb">Tinggi Badan</label>
                            <input type="number" class="form-control form-control-sm" id="tb" name="tb" value="">
                        </div>
                        <div class="col-sm-4">
                            <label class="mb-1" for="imt">IMT</label>
                            <input type="number" class="form-control form-control-sm" id="imt" name="imt" value="">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <div class="col-sm-4">
                            <label class="mb-1" for="sistole">Sistole</label>
                            <input type="number" class="form-control form-control-sm" id="sistole" name="sistole"
                                value="">
                        </div>
                        <div class="col-sm-4">
                            <label class="mb-1" for="diastole">Diastole</label>
                            <input type="number" class="form-control form-control-sm" id="diastole" name="diastole"
                                value="">
                        </div>
                        <div class="col-sm-4">
                            <label class="mb-1" for="nadi">Nadi</label>
                            <input type="number" class="form-control form-control-sm" id="nadi" name="nadi" value="">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <div class="col-sm-4">
                            <label class="mb-1" for="rr">RR</label>
                            <input type="number" class="form-control form-control-sm" id="rr" name="rr" value="">
                        </div>
                        <div class="col-sm-4">
                            <label class="mb-1" for="suhu">Suhu (Celcius)</label>
                            <input type="number" class="form-control form-control-sm" id="suhu" name="suhu" value="">
                        </div>
                    </div>
                </div>

                <div class="mb-5">
                    <p class="mb-3 fs-5 fw-medium">Assesment Awal Nyeri (diisi bila ada keluhan nyeri)</p>

                    <div class="row">
                        <div class="col-sm-4">
                            <img src="<?= base_url('images/nyeri.png') ?>" alt="" class="img-fluid">
                            <input type="range" class="form-range" min="0" max="10" id="nyeri" value="">
                        </div>
                        <div class="col-sm-8">
                            <div class="row g-3 mb-3 align-items-center">
                                <label for="skala_nyeri" class="col-sm-3 col-form-label">Skala Nyeri</label>
                                <div class="col-sm-9">
                                    <input type="number" class="form-control form-control-sm" id="skala_nyeri"
                                        name="skala_nyeri" value="">
                                </div>
                            </div>
                            <div class="row g-3 mb-3 align-items-center">
                                <label for="skala_nyeri" class="col-sm-3 col-form-label">Frekuensi Nyeri</label>
                                <div class="col-sm-9">
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="frek_nyeri" id="frek_jarang"
                                            value="jarang" />
                                        <label class="form-check-label" for="frek_jarang">Jarang</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="frek_nyeri"
                                            id="frek_hilang_timbul" value="hilang timbul" />
                                        <label class="form-check-label" for="frek_hilang_timbul">Hilang Timbul</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="frek_nyeri"
                                            id="frek_terus_menerus" value="terus menerus" />
                                        <label class="form-check-label" for="frek_terus_menerus">Terus Menerus</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row g-3 mb-3 align-items-center">
                                <label for="lama_nyeri" class="col-sm-3 col-form-label">Lama Nyeri</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control form-control-sm" id="lama_nyeri"
                                        name="lama_nyeri" value="">
                                </div>
                            </div>
                            <div class="row g-3 mb-3 align-items-center">
                                <label for="menjalar" class="col-sm-3 col-form-label">Menjalar</label>
                                <div class="col-sm-9">
                                    <div class="d-flex gap-2 w-100 align-items-center">
                                        <div class="" style="width: 50%;">
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="menjalar"
                                                    id="menjalar_tidak" value="tidak" />
                                                <label class="form-check-label" for="menjalar_tidak">Tidak</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="menjalar"
                                                    id="menjalar_iya" value="ya" />
                                                <label class="form-check-label" for="menjalar_iya">Iya, ke</label>
                                            </div>
                                        </div>
                                        <input type="text" class="form-control form-control-sm" style="width: 50%;"
                                            id="menjalar_ket" name="menjalar_ket" placeholder="..." value="">
                                    </div>
                                </div>
                            </div>
                            <div class="row g-3 mb-3 align-items-center">
                                <label for="kualitas_nyeri" class="col-sm-3 col-form-label">Kualitas Nyeri</label>
                                <div class="col-sm-9">
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="kualitas_nyeri"
                                            id="kualitas_tumpul" value="tumpul" />
                                        <label class="form-check-label" for="kualitas_tumpul">Nyeri Tumpul</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="kualitas_nyeri" id="kualitas"
                                            value="tajam" />
                                        <label class="form-check-label" for="kualitas">kualitas Tajam</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="kualitas_nyeri"
                                            id="kualitas_panas" value="panas" />
                                        <label class="form-check-label" for="kualitas_panas">Panas Terbakar</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row g-3 mb-3 align-items-center">
                                <label for="fakt_pemicu" class="col-sm-3 col-form-label">Faktor Pemicu</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control form-control-sm" id="fakt_pemicu"
                                        name="fakt_pemicu" value="">
                                </div>
                            </div>
                            <div class="row g-3 mb-3 align-items-center">
                                <label for="fakt_pengurang" class="col-sm-3 col-form-label">Faktor Pereda</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control form-control-sm" id="fakt_pengurang"
                                        name="fakt_pengurang" value="">
                                </div>
                            </div>
                            <div class="row g-3 mb-3 align-items-center">
                                <label for="lokasi_nyeri" class="col-sm-3 col-form-label">Lokasi Nyeri</label>
                                <div class="col-sm-9">
                                    <select class="form-select form-select-sm" aria-label="Small select example"
                                        name="lokasi_nyeri" id="lokasi_nyeri">
                                        <option value="kepala">
                                            Kepala</option>
                                        <option value="dada">
                                            Dada</option>
                                        <option value="perut">
                                            Perut</option>
                                        <option value="genetalia">
                                            Genetalia</option>
                                        <option value="anus">
                                            Anus</option>
                                        <option value="ekstremitas">
                                            Ekstremitas</option>
                                        <option value="sistem pernapasan">
                                            Sistem Pernapasan</option>
                                        <option value="sistem kardiovaskuler">
                                            Sistem Kardiovaskuler</option>
                                        <option value="sistem neurologis">
                                            Sistem Neurologis</option>
                                        <option value="sistem gastrointestinal">
                                            Sistem Gastrointestinal</option>
                                        <option value="sistem perkemihan">
                                            Sistem Perkemihan</option>
                                        <option value="sistem integumen">
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
                            <input type="text" class="form-control form-control-sm" name="diagnosa-utama"
                                id="diagnosa-utama">
                        </div>
                        <div class="w-50">
                            <p class="mb-1">Diagnosa Sekunder</p>
                            <input type="text" class="form-control form-control-sm" name="diagnosa-sekunder"
                                id="diagnosa-sekunder">
                        </div>
                    </div>
                    <div class="w-100 mb-5">
                        <p class="mb-1">Tindakan Terhadap Pasien</p>
                        <input type="text" class="form-control form-control-sm" name="tindakan" id="tindakan">
                    </div>
                    <div class="mb-5">
                        <p class="mb-1 fs-5 mt-4 fw-medium">Resep</p>
                        <div class="d-flex gap-2 align-items-center mb-1">
                            <p class="mb-0" style="width: 25%;">Nama Obat</p>
                            <p class="mb-0" style="width: 10%;">Satuan</p>
                            <p class="mb-0" style="width: 20%;">Signa</p>
                            <p class="mb-0" style="width: 15%;">Keterangan</p>
                            <p class="mb-0" style="width: 15%;">Jumlah Resep</p>
                            <p class="mb-0" style="width: 15%;">Jumlah Diberikan</p>
                        </div>
                        <div id="resep">
                        </div>
                    </div>
                    <div class="mb-5">
                        <p class="mb-1 fs-5 mt-4 fw-medium">Obat Racikan</p>
                        <div class="d-flex gap-2 align-items-center mb-1">
                            <p class="mb-0" style="width: 25%;">Campuran Obat</p>
                            <p class="mb-0" style="width: 10%;">Satuan</p>
                            <p class="mb-0" style="width: 20%;">Signa</p>
                            <p class="mb-0" style="width: 15%;">Keterangan</p>
                            <p class="mb-0" style="width: 15%;">Jumlah Resep</p>
                            <p class="mb-0" style="width: 15%;">Jumlah Diberikan</p>
                        </div>
                        <div id="resep-racikan">
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<?= $this->section('script') ?>
<script type="module">
$(document).ready(function() {
    $('.show-modal').on('click', function() {
        const id = $(this).data('id');

        $.ajax({
            url: '/rekmed/user/' + id,
            type: 'GET',
            success: function(data) {
                console.log(data);
                $('#makanan').val(data.kunjungan.alergi_makanan)
                $('#obat').val(data.kunjungan.alergi_obat)
                $('#rwt_pykt_terdahulu').val(data.kunjungan.rwt_pykt_terdahulu)
                $('#rwt_pengobatan').val(data.kunjungan.rwt_pengobatan)
                $('#rwt_pykt_pengobatan').val(data.kunjungan.rwt_pykt_pengobatan)
                $('#keluhan').val(data.kunjungan.keluhan)
                $('#pekerjaan').val(data.kunjungan.pekerjaan_pasien)
                $('#tb').val(data.kunjungan.tb)
                $('#bb').val(data.kunjungan.bb)
                $('#imt').val(data.kunjungan.imt)
                $('#sistole').val(data.kunjungan.sistole)
                $('#diastole').val(data.kunjungan.diastole)
                $('#rr').val(data.kunjungan.rr)
                $('#nadi').val(data.kunjungan.nadi)
                $('#suhu').val(data.kunjungan.suhu)
                $('#nyeri').val(data.kunjungan.skala_nyeri)
                $('#skala_nyeri').val(data.kunjungan.skala_nyeri)
                $('#lama_nyeri').val(data.kunjungan.lama_nyeri)
                $('#menjalar_ket').val(data.kunjungan.menjalar_ket)
                $('#fakt_pemicu').val(data.kunjungan.fakt_pemicu)
                $('#fakt_pengurang').val(data.kunjungan.fakt_pengurang)
                $('#lokasi_nyeri').val(data.kunjungan.lokasi_nyeri)
                $('input[name="frek_nyeri"][value="' + data.kunjungan.frek_nyeri + '"]')
                    .prop('checked', true)
                $('input[name="menjalar"][value="' + data.kunjungan.menjalar + '"]').prop(
                    'checked', true)
                $('input[name="kualitas_nyeri"][value="' + data.kunjungan.kualitas_nyeri +
                    '"]').prop('checked', true)

                data.diagnosaPasiens.forEach(diagnosa => {
                    $('#diagnosa-utama').val(diagnosa.status == 'utama' ? diagnosa
                        .diagnosa : '')
                    $('#diagnosa-sekunder').val(diagnosa.status == 'sekunder' ?
                        diagnosa.diagnosa : '')
                });

                let dataTindakan = ''
                if (data.tindakanPasiens.length > 0) {
                    let counter = 0
                    data.tindakanPasiens.forEach(tindakan => {
                        counter++
                        dataTindakan +=
                            `${tindakan.tindakan}${counter < data.tindakanPasiens.length ? ', ' : ''}`
                    })
                }
                $('#tindakan').val(dataTindakan)

                data.obatPasiens.forEach(obat => {
                    $('#resep').append(
                        `
                        <div class="d-flex gap-3 mb-2" id="resep-0">
                            <input type="text" class="form-control form-control-sm" id="resep-obat" value='${obat.obat}' readonly style="width: 25%;">
                            <input type="text" class="form-control form-control-sm" id="resep-obat" value='${obat.jenis}' readonly style="width: 10%;">
                            <div class="d-flex align-items-center gap-1" style="width: 20%;">
                                <input type="text" class="form-control form-control-sm" style="width: 40%;" value='${obat.signa.split('x')[0]}' readonly>
                                <div class="d-flex align-items-center justify-content-center" style="width: 20%;">
                                    <i class="bi bi-x fs-4"></i>
                                </div>
                                <input type="text" class="form-control form-control-sm" style="width: 40%;" value='${obat.signa.split('x')[1]}' readonly>
                            </div>
                            <input type="text" class="form-control form-control-sm" id="resep-obat" value='${obat.ket}' readonly style="width: 25%;">
                            <input type="text" class="form-control form-control-sm" id="resep-obat" value='${obat.jml_resep}' readonly style="width: 15%;">
                            <input type="text" class="form-control form-control-sm" id="resep-obat" value='${obat.jml_diberikan}' readonly style="width: 15%;">
                        </div>
                        `
                    )
                })

                data.obatRacikan.forEach(racikan => {
                    let dataRacikan = ''
                    if (racikan.detail_obat.length > 0) {
                        let counter = 0
                        racikan.detail_obat.forEach(item => {
                            counter++
                            dataRacikan +=
                                `${item.obat}${counter < racikan.detail_obat.length ? ', ' : ''}`
                        })
                    }
                    $('#resep-racikan').append(
                        `
                        <div class="d-flex gap-3 mb-2" id="resep-0">
                            <input type="text" class="form-control form-control-sm" id="resep-obat" value='${dataRacikan}' readonly style="width: 25%;">
                            <input type="text" class="form-control form-control-sm" id="resep-obat" value='${racikan.satuan}' readonly style="width: 10%;">
                            <div class="d-flex align-items-center gap-1" style="width: 20%;">
                                <input type="text" class="form-control form-control-sm" style="width: 40%;" value='${racikan.signa.split('x')[0]}' readonly>
                                <div class="d-flex align-items-center justify-content-center" style="width: 20%;">
                                    <i class="bi bi-x fs-4"></i>
                                </div>
                                <input type="text" class="form-control form-control-sm" style="width: 40%;" value='${racikan.signa.split('x')[1]}' readonly>
                            </div>
                            <input type="text" class="form-control form-control-sm" id="resep-obat" value='${racikan.ket}' readonly style="width: 25%;">
                            <input type="text" class="form-control form-control-sm" id="resep-obat" value='${racikan.jml_resep}' readonly style="width: 15%;">
                            <input type="text" class="form-control form-control-sm" id="resep-obat" value='${racikan.jml_diberikan}' readonly style="width: 15%;">
                        </div>
                        `
                    )
                })
            }
        })
    })

    $('#rekmedModalBody .form-control').attr('readonly', true);
    $('#rekmedModalBody .form-check-input, #rekmedModalBody .form-select-sm').attr('disabled', true);

    $('#rekmedModal').on('hidden.bs.modal', function() {
        $('#resep').html('')
        $('#resep-racikan').html('')
    })
})
</script>
<?= $this->endSection() ?>