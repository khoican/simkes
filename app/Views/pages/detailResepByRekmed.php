<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div class='d-flex gap-3 mt-5 border rounded-3 bg-white p-3'>
    <div class="col-3">
        <?= view_cell('PasienDataCell', ['id' => $pasienId]) ?>
    </div>

    <div class="w-100">
        <div class="mb-5">
            <p class="fw-semibold mb-2 fs-6">Diagnosa Pasien</p>
            <table class="table-hover table fs-6">
                <thead class="table-primary">
                    <tr>
                        <th style="width: 20%;">Kode</th>
                        <th>Diagnosa</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($diagnosaPasiens as $diagnosaPasien) : ?>
                    <tr class="text-capitalize">
                        <td><?= esc($diagnosaPasien['kode']) ?></td>
                        <td><?= esc($diagnosaPasien['diagnosa']) ?></td>
                    </tr>
                    <?php endforeach ?>
                </tbody>
            </table>
        </div>
        <div class="mb-5">
            <p class="fw-semibold mb-2 fs-6">Resep Dokter</p>
            <table class="table-hover table fs-6">
                <thead class="table-primary">
                    <tr class="text-center">
                        <th style="width: 35%;">Nama Obat</th>
                        <th style="width: 5%;">Satuan</th>
                        <th style="width: 10%;">Keterangan</th>
                        <th style="width: 10%;">Signa</th>
                        <th style="width: 13%;">Jumlah Resep</th>
                        <th style="width: 16%;">Jumlah Diberikan</th>
                        <th style="width: 10%;">Aksi</th>
                    </tr>
                </thead>
                <tbody id="resep-data">
                    <?php foreach($obatPasiens as $obatPasien) : ?>
                    <tr class="text-center align-middle text-capitalize resep-obat-<?= $obatPasien['id'] ?>">
                        <td><?= esc($obatPasien['kode']) ?> - <?= esc($obatPasien['obat']) ?></td>
                        <td><?= esc($obatPasien['jenis']) ?></td>
                        <td><?= esc($obatPasien['ket']) ?></td>
                        <td><?= esc($obatPasien['signa']) ?></td>
                        <td><?= esc($obatPasien['jml_resep']) ?></td>
                        <form class="submit" method="post" data-id="<?= $obatPasien['id'] ?>">
                            <td>
                                <input type="hidden" class="id_obat-<?= $obatPasien['id'] ?>" name="id_obat"
                                    id="id_obat" value="<?= $obatPasien['id_obat'] ?>">
                                <input type="hidden" class="id_rekmed-<?= $obatPasien['id'] ?>" name="id_rekmed"
                                    id="id_rekmed" value="<?= $obatPasien['id_rekmed'] ?>">
                                <input type="hidden" class="harga-<?= $obatPasien['id'] ?>" name="harga" id="harga"
                                    value="<?= $obatPasien['harga'] ?>">
                                <input type="number" class="form-control form-control-sm qty-<?= $obatPasien['id'] ?>"
                                    name="jml_diberikan" id="jml_diberikan"
                                    value="<?= esc(intval($obatPasien['jml_diberikan'])) ?>"
                                    <?php if($obatPasien['status'] == 'sudah') echo 'readonly' ?>>
                            </td>
                            <td>
                                <button type="submit"
                                    class="btn btn-primary btn-sm add-<?= $obatPasien['id'] ?> <?php if($obatPasien['status'] == 'sudah') echo 'disabled' ?>">
                                    <i class="bi bi-plus"></i>
                                </button>
                        </form>
                        <button type="button" class="btn btn-danger btn-sm delete delete-<?= $obatPasien['id'] ?>"
                            data-id-obatpasien="<?= $obatPasien['id'] ?>" data-id-obat="<?= $obatPasien['id_obat'] ?>"
                            data-jml="<?= $obatPasien['jml_diberikan'] ?>"
                            data-id-rekmed="<?= $obatPasien['id_rekmed'] ?>">
                            <i class="bi bi-trash"></i>
                        </button>
                        </td>
                    </tr>
                    <?php endforeach ?>
                </tbody>
            </table>

            <div class="text-end">
                <button type="button" class="btn btn-primary btn-sm" id="add-resep"
                    data-pasienid="<?= $pasienId['id_pasien'] ?>" data-rekmedid="<?= $rekmedId ?>">
                    <i class="bi bi-plus"></i> Tambah Resep</button>
            </div>
        </div>
        <div class="mb-3 fs-6" id="resep-racikan-data">
            <p class="fw-semibold mb-2 fs-6">Resep Racikan</p>

            <div class="d-flex gap-2 align-items-center mb-1">
                <p class="mb-0" style="width: 40%;">Nama Obat</p>
                <p class="mb-0" style="width: 15%;">Satuan</p>
                <p class="mb-0" style="width: 15%;">Signa</p>
                <p class="mb-0" style="width: 15%;">Keterangan</p>
                <p class="mb-0" style="width: 15%;">Jumlah Resep</p>
                <p class="mb-0" style="width: 10%;">Aksi</p>
            </div>

            <?php foreach($obatRacikans as $index => $obatRacikan) : ?>
            <div class="d-flex gap-2 align-items-center mb-1 resep-racikan-<?= $obatRacikan['id'] ?>"
                id="obat-racikan-<?= $obatRacikan['id'] ?>">
                <select class="form-select-sm id-obat" data-width="40%" data-placeholder="Pilih Obat" multiple disabled>
                    <?php foreach($obats as $obat) : ?>

                    <?php 
                        $selected = '';
                        if (isset($obatRacikan['detail_obat'])) {
                            foreach ($obatRacikan['detail_obat'] as $item) {
                                if ($item['id'] == $obat['id']) {
                                    $selected = 'selected';
                                    break;
                                }
                            }
                        }
                        ?>

                    <option value="<?= $obat['id'] ?>" class="text-uppercase" <?= $selected ?>>
                        <?= $obat['kode'] ?> -
                        <?= $obat['obat'] ?></option>
                    <?php endforeach; ?>
                </select>
                <input type="text" class="form-control form-control-sm text-capitalize satuan-0" name="satuan"
                    style="width: 15%;" value="<?= esc($obatRacikan['satuan']) ?>">
                <div class="d-flex align-items-center justify-content-center" style="width: 15%;">
                    <input type="number" class="form-control form-control-sm text-capitalize resep-0" name="resep"
                        value="<?= substr($obatRacikan['signa'], 0, 1) ?>">
                    <div class="d-flex align-items-center justify-content-center" style="width: 20%;">
                        <i class="bi bi-x fs-4"></i>
                    </div>
                    <input type="number" class="form-control form-control-sm text-capitalize resep2-0" name="resep2"
                        value="<?= substr($obatRacikan['signa'], 4, 1) ?>">
                </div>
                <input type="text" class="form-control form-control-sm text-capitalize ket-0" name="ket"
                    style="width: 15%;" value="<?= esc($obatRacikan['ket']) ?>">
                <input type="number" class="form-control form-control-sm text-capitalize jml-resep-0" name="jml_resep"
                    style="width: 15%;" value="<?= esc($obatRacikan['jml_resep']) ?>">
                <div style="width: 10%;" class="text-center">
                    <button type="submit" class="btn btn-primary btn-sm fs-6 add-racikan-0" disabled><i
                            class="bi bi-plus"></i></button>
                    <button type="button" class="btn btn-danger btn-sm fs-6 delete-resep-racikan"
                        data-id="<?= $obatRacikan['id'] ?>"><i class="bi bi-trash"></i></button>
                </div>
            </div>
            <?php endforeach ?>

            <form method="POST" data-pasien-id="<?= $pasienId['id_pasien'] ?>" data-rekmed-id="<?= $rekmedId ?>"
                data-col="0" class="obat-racikan" id="obat-racikan-0">
                <div class="d-flex gap-2 align-items-center mb-1" id="resep-racikan">
                    <?= csrf_field() ?>
                    <select name="obat[]" data-width="40%" data-placeholder="Pilih Obat" name="id_obat"
                        class="form-select-sm id-obat w-100 fs-6 text-capitalize id-obat-0" multiple>
                        <option></option>
                        <?php foreach($obats as $obat) : ?>
                        <option value="<?= $obat['id'] ?>" class="text-uppercase">
                            <?= $obat['kode'] ?> - <?= $obat['obat'] ?>
                        </option>
                        <?php endforeach; ?>
                    </select>
                    <input type="text" class="form-control form-control-sm text-capitalize satuan-0" name="satuan"
                        style="width: 15%;">
                    <div class="d-flex align-items-center justify-content-center" style="width: 15%;">
                        <input type="number" class="form-control form-control-sm text-capitalize resep-0" name="resep">
                        <div class="d-flex align-items-center justify-content-center" style="width: 20%;">
                            <i class="bi bi-x fs-4"></i>
                        </div>
                        <input type="number" class="form-control form-control-sm text-capitalize resep2-0"
                            name="resep2">
                    </div>
                    <input type="text" class="form-control form-control-sm text-capitalize ket-0" name="ket"
                        style="width: 15%;">
                    <input type="number" class="form-control form-control-sm text-capitalize jml-resep-0"
                        name="jml_resep" style="width: 15%;">
                    <div style="width: 10%;" class="text-center btns">
                        <button type="submit" class="btn btn-primary btn-sm fs-6 add-racikan-0"><i
                                class="bi bi-plus"></i></button>
                        <button type="button" class="btn btn-danger btn-sm fs-6 remove-racikan remove-racikan-0"
                            data-col="0"><i class="bi bi-trash"></i></button>
                    </div>
                </div>
            </form>
        </div>
        <div class="text-end mb-5">
            <button type="button" class="btn btn-primary btn-sm" id="add-resep-racikan-form"><i class="bi bi-plus"></i>
                Tambah Resep
                Racikan</button>
        </div>

        <div class="mb-5 fs-6 d-flex align-items-center gap-5">
            <p class="fw-semibold mb-0 w-75 text-end">TOTAL BIAYA</p>
            <input type="text" readonly class="form-control form-control-sm w-25 fw-semibold" id="total-harga"
                value="<?= esc($total) ?>">
        </div>

        <div>
            <a href="/apotek/<?= $kunjunganId ?>" class="btn btn-secondary btn-sm">Kembali</a>

            <?php if($rekmed['status'] != 'selesai') : ?>
            <button type="button" class="btn btn-primary btn-sm" id="kunjungan-selesai">Simpan</button>
            <?php endif ?>
        </div>
    </div>
</div>

<?= $this->endsection() ?>

<?= $this->section('script'); ?>
<script type="module">
$(document).ready(function() {
    $('#kunjungan-selesai').on('click', function() {
        $.ajax({
            url: '/apotek/kunjungan/update/<?= $kunjunganId ?>/<?= $rekmedId ?>',
            method: 'post',
            success: function(data) {
                window.location.href = '/apotek/<?= $kunjunganId ?>'
            }
        })
    })

    $('#resep-data').on('submit', 'form.submit', function(event) {
        event.preventDefault();

        let form = $(this);
        let id = form.data('id');
        let id_obat = $(`.id_obat-${id}`).val();
        let id_rekmed = $(`.id_rekmed-${id}`).val();
        let jml_diberikan = $(`.qty-${id}`).val();

        $.ajax({
            url: `/apotek/obat/update/${id}`,
            method: 'post',
            data: {
                obatId: id_obat,
                rekmedId: id_rekmed,
                jml_diberikan: jml_diberikan
            },
            success: function(data) {
                console.log(data);
                $('#total-harga').val(data.total);
                $(`.add-${id}`).prop('disabled', true);
            },
            error: function(xhr, status, error) {
                console.log(xhr.responseText);
            }
        })
    })

    function select2Style() {
        $('.id-obat').select2({
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

    function addNewResep() {
        $(document).on('click', '.submit-new-data', function(event) {
            event.preventDefault();

            let rowId = $(this).data('row-id');
            let id_pasien = $(this).data('pasien-id');
            let id_rekmed = $(this).data('rekmed-id');
            let id_obat = $(`.id-obat-${rowId}`).val();
            let signa = $(`.resep-${rowId}`).val() + ' x ' + $(`.resep2-${rowId}`).val();
            let ket = $(`.ket-${rowId}`).val();
            let jml_resep = $(`.jml_resep-${rowId}`).val();
            let jml_diberikan = $(`.jml_diberikan-${rowId}`).val();

            $.ajax({
                url: '/apotek/obat/add',
                method: 'post',
                data: {
                    id_pasien: id_pasien,
                    id_rekmed: id_rekmed,
                    id_obat: id_obat,
                    signa: signa,
                    ket: ket,
                    jml_resep: jml_resep,
                    jml_diberikan: jml_diberikan,
                },
                success: function(data) {
                    $(`#${rowId} .btn-primary`).prop('disabled', true);
                    $(`#${rowId}`).addClass(`resep-obat-${data.data.id}`);
                    $(`#${rowId} .btn-delete`).html(`
                        <button type="button" class="btn btn-danger btn-sm delete delete-${data.data.id}"
                            data-id-obatpasien="${data.data.id}" data-id-obat="${data.data.id_obat}"
                            data-jml="${data.data.jml_diberikan}"
                            data-id-rekmed="${data.data.id_rekmed}">
                            <i class="bi bi-trash"></i>
                        </button>
                    `);
                    $('#total-harga').val(data.total);
                    $(`#${rowId} .remove`).remove();
                },
                error: function(xhr, status, error) {
                    alert('Terjadi kesalahan saat menyimpan data.');
                }
            });
        });
    }

    addNewResep();

    $('#add-resep-racikan-form').on('click', function() {
        const rowId = $('#resep-racikan-data form').length + 1;

        let newForm = `
            <form method="POST" data-pasien-id="<?= $pasienId['id_pasien'] ?>" data-rekmed-id="<?= $rekmedId ?>"
                data-col="${rowId}" class="obat-racikan" id="obat-racikan-${rowId}">
                <div class="d-flex gap-2 align-items-center mb-1" id="resep-racikan">
                    <?= csrf_field() ?>
                    <select name="obat[]" data-width="40%" data-placeholder="Pilih Obat" name="id_obat"
                        class="form-select-sm id-obat w-100 fs-6 text-capitalize id-obat-${rowId}" multiple>
                        <option></option>
                        <?php foreach($obats as $obat) : ?>
                        <option value="<?= $obat['id'] ?>" class="text-uppercase">
                            <?= $obat['kode'] ?> - <?= $obat['obat'] ?>
                        </option>
                        <?php endforeach; ?>
                    </select>
                    <input type="text" class="form-control form-control-sm text-capitalize satuan-${rowId}" name="satuan"
                        style="width: 15%;">
                    <div class="d-flex align-items-center justify-content-center" style="width: 15%;">
                        <input type="number" class="form-control form-control-sm text-capitalize resep-${rowId}" name="resep">
                        <div class="d-flex align-items-center justify-content-center" style="width: 20%;">
                            <i class="bi bi-x fs-4"></i>
                        </div>
                        <input type="number" class="form-control form-control-sm text-capitalize resep2-${rowId}"
                            name="resep2">
                    </div>
                    <input type="text" class="form-control form-control-sm text-capitalize ket-${rowId}" name="ket"
                        style="width: 15%;">
                    <input type="number" class="form-control form-control-sm text-capitalize jml-resep-${rowId}"
                        name="jml_resep" style="width: 15%;">
                    <div style="width: 10%;" class="text-center btns">
                        <button type="submit" class="btn btn-primary btn-sm fs-6 add-racikan-${rowId}"><i
                                class="bi bi-plus"></i></button>
                        <button type="button" class="btn btn-danger btn-sm fs-6 remove-racikan remove-racikan-${rowId}" data-col="${rowId}"><i
                                class="bi bi-trash"></i></button>
                    </div>
                </div>
            </form>
        `;

        $('#resep-racikan-data').append(newForm);
        select2Style();
    });

    $('#add-resep').on('click', function() {
        const button = $(this);
        const id_pasien = button.data('pasienid');
        const id_rekmed = button.data('rekmedid');
        const rowId = `row-${$('#resep-data tr').length + 1}`;

        let newRow = `
            <tr class="text-center align-middle" id="${rowId}">
                <form method="POST" class="add-resep-obat" data-row-id="${rowId}" data-pasien-id="${id_pasien}" data-rekmed-id="${id_rekmed}">
                    <td>
                        <select name="obat[]" data-width="100%" data-placeholder="Pilih Obat"
                            class="form-select-sm id-obat id-obat-${rowId} w-100 fs-6 text-capitalize" data-row-id="${rowId}">
                            <option></option>
                            <?php foreach($obats as $obat) : ?>
                                <option value="<?= $obat['id'] ?>" class="text-uppercase">
                                    <?= $obat['kode'] ?> - <?= $obat['obat'] ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </td>
                    <td>
                        <input type="text" class="form-control form-control-sm satuan satuan-${rowId} text-capitalize"
                            name="satuan" readonly>
                    </td>
                    <td>
                        <input type="text" class="form-control form-control-sm ket-${rowId} text-capitalize"
                            name="ket">
                    </td>
                    <td class="d-flex align-items-center gap-1">
                        <input type="number" class="form-control form-control-sm resep-${rowId}"
                            name="resep">
                        <div class="d-flex align-items-center justify-content-center" style="width: 20%;">
                            <i class="bi bi-x fs-4"></i>
                        </div>
                        <input type="number" class="form-control form-control-sm resep2-${rowId}"
                            name="resep2">
                    </td>
                    <td>
                        <input type="number" class="form-control form-control-sm jml_resep-${rowId}"
                            name="jml_resep">
                    </td>
                    <td>
                        <input type="number" class="form-control form-control-sm jml_diberikan-${rowId}"
                            name="jml_diberikan">
                    </td>
                    <td>
                        <button type="submit" class="btn btn-primary btn-sm submit-new-data"  data-row-id="${rowId}" data-pasien-id="${id_pasien}" data-rekmed-id="${id_rekmed}">
                            <i class="bi bi-plus"></i>
                        </button>
                        <button type="button" class="btn btn-danger btn-sm remove" data-id="${rowId}">
                            <i class="bi bi-trash"></i>
                        </button>
                        </form>

                        <div class="btn-delete"></div>
                    </td>
            </tr>
        `;

        $('#resep-data').append(newRow);
        select2Style();
    });

    $(document).on('submit', 'form.obat-racikan', function(event) {
        event.preventDefault();

        let form = $(this);
        let col = form.data('col');
        console.log(col);
        let id_pasien = form.data('pasien-id');
        let id_rekmed = form.data('rekmed-id');
        let id_obat = form.find(`.id-obat-${col}`).val();
        let satuan = form.find(`.satuan-${col}`).val();
        let signa = form.find(`.resep-${col}`).val() + ' x ' + form.find(`.resep2-${col}`).val();
        let ket = form.find(`.ket-${col}`).val();
        let jml_resep = form.find(`.jml-resep-${col}`).val();

        if (id_obat, satuan, signa, ket, jml_resep) {
            $.ajax({
                url: '/apotek/obatracikan/add',
                method: 'post',
                data: {
                    id_pasien: id_pasien,
                    id_rekmed: id_rekmed,
                    id_obat: id_obat,
                    satuan: satuan,
                    signa: signa,
                    ket: ket,
                    jml_resep: jml_resep,
                },
                success: function(data) {
                    $('#total-harga').val(data.total);
                    form.find('button.btn-primary').prop('disabled', true);
                    form.find('button.remove-racikan').remove();
                    form.addClass(`resep-racikan-${data.id}`)
                    form.find('select').prop('disabled', true);
                    form.find('.btns').append(`<button type="button" class="btn btn-danger btn-sm fs-6 delete-resep-racikan" data-id="${data.id}"><i
                                class="bi bi-trash"></i></button>`);
                },
                error: function(xhr, status, error) {
                    console.log(xhr, status, error);
                }
            });
        }
    });

    $(document).on('click', 'button.remove-racikan', function() {
        const rowId = $(this).data('col');
        $(`#obat-racikan-${rowId}`).remove();
    });

    $(document).on('click', 'button.delete-resep-racikan', function() {
        const id = $(this).data('id');

        $.ajax({
            url: `/apotek/obatracikan/delete/${id}`,
            method: 'post',
            success: function(data) {
                console.log(data);
                $('#total-harga').val(data.total);
                $(`.resep-racikan-${id}`).remove();
            },
            error: function(xhr, status, error) {
                console.log(xhr, status, error);
            }
        })
    })

    $(document).on('click', 'button.remove', function() {
        const rowId = $(this).data('id');
        $(`#${rowId}`).remove();
    });

    $('#resep-data').on('change', '.id-obat', function() {
        let obatId = $(this).val();
        let rowId = $(this).data('row-id');

        if (obatId) {
            $.ajax({
                url: `/obat/${obatId}`,
                method: 'get',
                success: function(data) {
                    $(`#${rowId} .satuan`).val(data.jenis);
                },
                error: function(xhr, status, error) {
                    console.error('Terjadi kesalahan saat mengambil data obat:', error);
                }
            });
        }
    });

    $('#resep-data').on('click', '.delete', function() {
        let id = $(this).data('id-obatpasien');
        let id_obat = $(this).data('id-obat');
        let id_rekmed = $(this).data('id-rekmed');
        let jml = $(this).data('jml');
        $.ajax({
            url: '/apotek/obat/delete/' + id,
            method: 'post',
            data: {
                id_obat: id_obat,
                id_rekmed: id_rekmed,
                jml: jml
            },
            success: function(data) {
                $(`.resep-obat-${id}`).remove();
                $('#total-harga').val(data.total);
            },
            error: function(xhr, status, error) {
                console.log(xhr, status, error);
            }
        });
    });
});
</script>

<?= $this->endsection() ?>