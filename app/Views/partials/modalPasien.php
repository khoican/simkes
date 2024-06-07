<div class="modal fade" id="exampleModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Tambah Data Pasien</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="pendaftaran/pasien/store" method="POST" class="fs-6" id="pasienForm"
                    accept-charset="utf-8" enctype="multipart/form-data">
                    <?= csrf_field() ?>
                    <input type="text" class="form-control form-control-sm" id="id_alamat" name="id_alamat" hidden>
                    <input type="text" class="form-control form-control-sm" id="no_rekam_medis" name="no_rekam_medis"
                        hidden>
                    <div class="d-flex gap-3 mb-3">
                        <div class="w-50  min-lenght" data-lenght="16">
                            <label for="nik" class="form-label">No. Identitas Pasien</label>
                            <input type="number" class="form-control form-control-sm" id="nik" name="nik" required>
                            <p class="note min-lenght-16 text-danger"></p>
                        </div>
                        <div class="w-50 min-lenght" data-lenght="13">
                            <label for="bpjs" class="form-label">No. BPJS</label>
                            <input type="number" class="form-control form-control-sm" id="bpjs" name="no_bpjs">
                            <p class="note min-lenght-13 text-danger"></p>
                        </div>
                    </div>
                    <div class="d-flex gap-3 mb-3">
                        <div class="w-50">
                            <label for="nama" class="form-label">Nama Lengkap</label>
                            <input type="text" class="form-control form-control-sm" id="nama" name="nama" required>
                        </div>
                        <div class="w-50">
                            <label class="form-label">Jenis Kelamin</label>
                            <select class="form-select form-select-sm" aria-label="Small select example" id="jk"
                                name="jk" required>
                                <option selected>Pilih Jenis Kelamin</option>
                                <option value="l">Laki-Laki</option>
                                <option value="p">Perempuan</option>
                            </select>
                        </div>
                    </div>
                    <div class="d-flex gap-3 mb-3">
                        <div class="w-50">
                            <label for="tgl_lahir" class="form-label">Tanggal Lahir</label>
                            <input type="date" class="form-control form-control-sm" id="tgl_lahir" name="tgl_lahir"
                                required>
                        </div>
                        <div class="w-50">
                            <label for="tmp_lahir" class="form-label">Tempat Lahir</label>
                            <input type="text" class="form-control form-control-sm" id="tmp_lahir" name="tmp_lahir"
                                required>
                        </div>
                    </div>
                    <div class="d-flex gap-3 mb-3">
                        <div class="w-50">
                            <label class="form-label">Golongan Darah</label>
                            <select class="form-select form-select-sm" aria-label="Small select example" id="gol_darah"
                                name="gol_darah" required>
                                <option value="tidak tahu" selected>Tidak Tahu</option>
                                <option value="a">A</option>
                                <option value="b">B</option>
                                <option value="o">O</option>
                                <option value="ab">AB</option>
                            </select>
                        </div>
                        <div class="w-50">
                            <label class="form-label">Agama</label>
                            <select class="form-select form-select-sm" aria-label="Small select example" id="agama"
                                name="agama" required>
                                <option selected>Silahkan Pilih Agama</option>
                                <option value="islam">Islam</option>
                                <option value="kristen">Kristen</option>
                                <option value="katolik">Katolik</option>
                                <option value="hindu">Hindu</option>
                                <option value="buddha">Buddha</option>
                                <option value="konghucu">Konghucu</option>
                            </select>
                        </div>
                    </div>
                    <div class="d-flex gap-3 mb-3">
                        <div class="w-50">
                            <label class="form-label">Pendidikan</label>
                            <select class="form-select form-select-sm" aria-label="Small select example" id="pendidikan"
                                name="pendidikan" required>
                                <option value="tidak sekolah">Tidak Sekolah</option>
                                <option value="sd">Sekolah Dasar</option>
                                <option value="smp">Sekolah Menengah Pertama</option>
                                <option value="sma">Sekolah Menengah Atas</option>
                                <option value="d1">Diploma 1</option>
                                <option value="d2">Diploma 2</option>
                                <option value="d3">Diploma 3</option>
                                <option value="d4">Diploma 4</option>
                                <option value="s1">Strata 1</option>
                                <option value="s2">Strata 2</option>
                                <option value="s3">Strata 3</option>
                            </select>
                        </div>
                        <div class="w-50">
                            <label for="pekerjaan" class="form-label">Pekerjaan</label>
                            <input type="text" class="form-control form-control-sm" id="pekerjaan" name="pekerjaan">
                        </div>
                    </div>
                    <div class="d-flex gap-3 mb-3">
                        <div class="d-flex gap-1 w-50">
                            <div class="w-50">
                                <label class="form-label">Posisi Dalam Keluarga</label>
                                <select class="form-select form-select-sm" aria-label="Small select example"
                                    name="pss_dlm_keluarga" id="pss_dlm_keluarga" required>
                                    <option selected>Pilih Posisi</option>
                                    <option value="kepala keluarga">Kepala keluarga</option>
                                    <option value="ibu">Ibu</option>
                                    <option value="anak">Anak</option>
                                </select>
                            </div>
                            <div class="w-50">
                                <label class="form-label">Posisi Anak</label>
                                <select class="form-select form-select-sm" aria-label="Small select example"
                                    name="pss_anak" id="pss_anak" disabled>
                                    <option selected>Pilih Posisi Anak</option>
                                    <?php for ($i = 1; $i <= 15; $i++): ?>
                                    <option value="<?= $i ?>">Anak <?= $i ?></option>
                                    <?php endfor; ?>
                                </select>
                            </div>
                        </div>
                        <div class="w-50">
                            <label for="kpl_keluarga" class="form-label">Nama Kepala Keluarga</label>
                            <input type="text" class="form-control form-control-sm" id="kpl_keluarga"
                                name="kpl_keluarga" required>
                        </div>
                    </div>
                    <div class="d-flex gap-3 mb-3">
                        <div class="w-50">
                            <label for="kota" class="form-label">Kota</label>
                            <input type="text" class="form-control form-control-sm" id="kota" name="kota" required>
                        </div>
                        <div class="w-50">
                            <label for="kecamatan" class="form-label">Kecamatan</label>
                            <input type="text" class="form-control form-control-sm" id="kecamatan" name="kecamatan"
                                required>
                        </div>
                    </div>
                    <div class="d-flex gap-3 mb-3">
                        <div class="d-flex gap-1 w-50">
                            <div class="w-25">
                                <label for="rt" class="form-label">Rt</label>
                                <input type="number" class="form-control form-control-sm" id="rt" name="rt" required>
                            </div>
                            <div class="w-25">
                                <label for="rw" class="form-label">Rw</label>
                                <input type="number" class="form-control form-control-sm" id="rw" name="rw" required>
                            </div>
                            <div class="w-50">
                                <label for="kelurahan" class="form-label">Kelurahan</label>
                                <input type="text" class="form-control form-control-sm" id="kelurahan" name="kelurahan"
                                    required>
                            </div>
                        </div>
                        <div class="w-50">
                            <label for="alamat" class="form-label">Alamat</label>
                            <input type="text" class="form-control form-control-sm" id="alamat" name="alamat" required>
                        </div>
                    </div>
                    <div class="d-flex gap-3 mb-3">
                        <div class="w-50">
                            <label for="telepon" class="form-label">Telepon</label>
                            <input type="number" class="form-control form-control-sm" id="telepon" name="telepon"
                                required>
                        </div>
                        <div class="w-50">
                            <label for="telepon2" class="form-label">Telepon 2</label>
                            <input type="number" class="form-control form-control-sm" id="telepon2" name="telepon2">
                        </div>
                    </div>
                    <div class="d-flex align-items-start gap-3 mb-3">
                        <div class="w-50">
                            <label class="form-label">Jenis Pembayaran</label>
                            <select class="form-select form-select-sm" aria-label="Small select example" id="pembayaran"
                                name="pembayaran" required>
                                <option selected>Pilih Jenis Pembayaran</option>
                                <option value="umum">Umum</option>
                                <option value="jkn">JKN</option>
                                <option value="lainnya">Lainnya</option>
                            </select>
                        </div>
                        <div class="w-50">
                            <div>
                                <label class="form-label">Unit Pelayanan Yang Dituju</label>
                                <select class="form-select form-select-sm" aria-label="Small select example" id="poli"
                                    name="poli" required>
                                    <option selected>Pilih Poli</option>
                                    <?php foreach ($polis as $key => $value) : ?>
                                    <option value="<?= $value['id'] ?>" class="text-uppercase">poli
                                        <?= $value['nama'] ?>
                                    </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="1" name="knjn_sehat"
                                    id="knjn_sehat">
                                <label class="form-check-label" for="knjn_sehat">
                                    Kunjungan Sehat
                                </label>
                            </div>

                            <div>
                                <label class="form-label mt-3 fw-medium">TKP</label>
                                <div class="">
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input tkp" type="radio" name="tkp" value="rawat jalan"
                                            id="flexRadioDefault1">
                                        <label class="form-check-label" for="flexRadioDefault1">
                                            Rawat Jalan
                                        </label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input tkp" type="radio" name="tkp" value="rawat inap"
                                            id="flexRadioDefault2">
                                        <label class="form-check-label" for="flexRadioDefault2">
                                            Rawat Inap
                                        </label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input tkp" type="radio" name="tkp" value="promotif"
                                            id="flexRadioDefault2">
                                        <label class="form-check-label" for="flexRadioDefault3">
                                            Promotif
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex gap-3 mb-3">
                        <div class="w-50">
                            <label for="tgl_antrian" class="form-label">Tanggal Antrian</label>
                            <input type="text" class="form-control form-control-sm" id="tgl_antrian">
                        </div>
                        <div class="w-50">
                            <label for="wkt_antrian" class="form-label">Waktu Antrian</label>
                            <input type="text" class="form-control form-control-sm" id="wkt_antrian">
                        </div>
                    </div>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </form>
            </div>
        </div>
    </div>
</div>

<?= $this->section('script') ?>
<script type="module">
$(document).ready(function() {
    function setNote() {
        $('.min-lenght').each(function() {
            let minLenght = $(this).data('lenght')
            $(this, '.form-control').on('input', function() {
                if ($(this).val().length < minLenght) {
                    $(`.min-lenght-${minLenght}`).html(
                        `<span class="fw-semibold">*</span> Minimal ${minLenght} karakter`
                    )
                } else {
                    $(`.min-lenght-${minLenght}`).text('')
                }
            })
        })
    }
    setNote();

    $('#nik').on('input', function() {
        if ($(this).val().length > 16) {
            $(this).val($(this).val().substring(0, 16));
        }
    })
    $('#bpjs').on('input', function() {
        if ($(this).val().length > 13) {
            $(this).val($(this).val().substring(0, 13));
        }
    })

    setInterval(function() {
        $('#tgl_antrian').val(moment().format('DD-MM-YYYY'));
        $('#wkt_antrian').val(moment().format('HH:mm:ss'));
    }, 1000);

    $(document).on('input', '#bpjs', function() {
        if ($(this).val()) {
            $('#pembayaran').val('jkn');
        } else {
            $('#pembayaran').val('umum');
        }
    });

    $(document).on('input', '#pss_dlm_keluarga', function() {
        if ($(this).val() === 'kepala keluarga') {
            $('#kpl_keluarga').val($('#nama').val());
        } else {
            $('#kpl_keluarga').val('');
        }
    });

    // handle dropdown posisi dalam keluarga dan dropdown posisi anak
    $('#pss_dlm_keluarga').on('change', function() {
        if ($(this).val() === 'anak') {
            $('#pss_anak').prop('disabled', false);
        } else {
            $('#pss_anak').prop('disabled', true);
        }
    });

    $('#add-pasien').on('click', function() {
        resetForm();
        $('#exampleModalLabel').text('Tambah Data Pasien');
        $('#pasienForm').attr('action', 'pendaftaran/pasien/store');
    });

    // fetch data pasien by id
    $('#dataTable tbody').on('click', '.edit-pasien', function() {
        let pasienId = $(this).data('id');
        $('#exampleModalLabel').text('Edit Data Pasien');
        $('#pasienForm').attr(
            'action',
            'pendaftaran/pasien/update/' + pasienId,
        );
        resetForm();

        $.ajax({
            url: '/pendaftaran/get-pasien/' + pasienId,
            method: 'GET',
            success: function(data) {
                $('#id_alamat').val(data.id_alamat);
                $('#no_rekam_medis').val(data.no_rekam_medis);
                $('#nik').val(data.nik);
                $('#bpjs').val(data.no_bpjs);
                $('#nama').val(data.nama);
                $('#jk').val(data.jk);
                $('#tgl_lahir').val(data.tgl_lahir);
                $('#tmp_lahir').val(data.tmp_lahir);
                $('#gol_darah').val(data.gol_darah);
                $('#agama').val(data.agama);
                $('#pendidikan').val(data.pendidikan);
                $('#pekerjaan').val(data.pekerjaan);
                $('#kpl_keluarga').val(data.kpl_keluarga);
                $('#pss_dlm_keluarga').val(data.pss_dlm_keluarga);
                $('#pss_anak').val(data.pss_anak);
                $('#rt').val(data.rt);
                $('#rw').val(data.rw);
                $('#kecamatan').val(data.kecamatan);
                $('#alamat').val(data.alamat);
                $('#kelurahan').val(data.kelurahan);
                $('#kota').val(data.kota);
                $('#telepon').val(data.telepon);
                $('#telepon2').val(data.telepon2);
                $('#pembayaran').val(data.pembayaran);
                $('#knjn_sehat').prop('checked', data.knjn_sehat == 1);
                $('input[name="tkp"][value="' + data.tkp + '"]').prop(
                    'checked',
                    true,
                );
                if (data.pss_dlm_keluarga === 'anak') {
                    $('#pss_anak').prop('disabled', false);
                } else {
                    $('#pss_anak').prop('disabled', true);
                }
            },
        });
    });

    $('#exampleModal').on('hidden.bs.modal', function() {
        resetForm();
    });

    function resetForm() {
        $('#pasienForm')[0].reset();
        $('#pss_anak').prop('disabled', true);
        $('#tgl_antrian').val(moment().format('DD-MM-YYYY'));
        $('#wkt_antrian').val(moment().format('HH:mm:ss'));
    }
})
</script>
<?= $this->endSection() ?>