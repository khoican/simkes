<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div class="bg-white p-4 border rounded-3 mt-5">
    <div class="w-100 fs-6">
        <div class="d-flex justify-content-end">
            <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal"
                data-bs-target="#exampleModal"><i class="bi bi-plus"></i> Tambah Data</button>
        </div>
        <table class="table table-hover fs-6 border mb-0 w-100" id="obat-table">
            <thead class="table-primary text-center">
                <tr>
                    <th style="width: 5%;">No</th>
                    <th style="width: 10%;">Kode</th>
                    <th style="width: 25%;">Obat</th>
                    <th style="width: 12%;">Jenis</th>
                    <th style="width: 15%;">Bentuk</th>
                    <th style="width: 10%;">Stok</th>
                    <th style="width: 10%;">Harga</th>
                    <th style="width: 13%;">Aksi</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
</div>
<div class="modal .modal-sm fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog  modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Tambah Data</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="/obat/store" method="POST" class="fs-6" id="diagnosaForm">
                <div class="modal-body">
                    <?php csrf_field() ?>
                    <div class="w-100 mb-3">
                        <label for="obat" class="form-label mb-1">Nama Obat</label>
                        <input type="text" class="form-control form-control-sm" id="obat" name="obat" required>
                    </div>
                    <div class="w-100 mb-3">
                        <label for="jenis" class="form-label mb-1">Jenis Obat</label>
                        <input type="text" class="form-control form-control-sm" id="jenis" name="jenis" required>
                    </div>
                    <div class="w-100 mb-3">
                        <label for="bentuk" class="form-label mb-1">Bentuk Obat</label>
                        <input type="text" class="form-control form-control-sm" id="bentuk" name="bentuk" required>
                    </div>
                    <div class="w-100 mb-3" id="stok-item">
                        <label for="stok" class="form-label mb-1">Stok Obat</label>
                        <input type="number" class="form-control form-control-sm" id="stok" name="stok" required>
                    </div>
                    <div class="w-100 mb-3">
                        <label for="harga" class="form-label mb-1">Harga Obat</label>
                        <input type="number" class="form-control form-control-sm" id="harga" name="harga" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-sm btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal .modal-sm fade" id="stokObat" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-labelledby="stokObatLabel" aria-hidden="true">
    <div class="modal-dialog  modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5 text-capitalize" id="stokObatLabel">Nama Obat</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="/obat/updateStok" method="POST" class="fs-6" id="stokObatForm">
                <div class="modal-body">
                    <?php csrf_field() ?>
                    <div class="w-100 mb-2">
                        <label for="qty-masuk" class="form-label mb-1">Jumlah Obat Masuk</label>
                        <input type="number" class="form-control form-control-sm" id="qty-masuk" name="qty-masuk"
                            required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-sm btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('script') ?>
<script type="module">
$(document).ready(function() {
    $(document).on('click', '.update-stok', function() {
        let nama = $(this).data('nama')
        let id = $(this).data('id')
        console.log(nama, id);
        $('#stokObatLabel').text(nama)
        $('#stokObatForm').attr('action', '/obat/updateStok/' + id)
    })

    $(document).on('click', '.edit', function() {
        let id = $(this).data('id')
        $('#exampleModalLabel').text('Edit Data');
        $('#diagnosaForm').attr('action', '/obat/update/' + id)
        $('#stok-item').remove()

        $.ajax({
            url: '/obat/' + id,
            method: 'GET',
            success: function(data) {
                $('#obat').val(data.obat)
                $('#jenis').val(data.jenis)
                $('#bentuk').val(data.bentuk)
                $('#harga').val(data.harga)
            }
        })
    })

    $('#obat-table').DataTable({
        ordering: true,
        order: [0, 'asc'],
        ajax: {
            url: '/obat/all',
            dataSrc: ''
        },
        columns: [{
                data: '',
                render: function(data, type, row, meta) {
                    return meta.row + meta.settings._iDisplayStart + 1
                }
            },
            {
                data: 'kode'
            },
            {
                data: 'obat'
            },
            {
                data: 'jenis'
            },
            {
                data: 'bentuk'
            },
            {
                data: 'stok'
            },
            {
                data: '',
                render: function(data, type, row) {
                    return `Rp. ${Number(row.harga).toLocaleString('id')}`
                }
            },
            {
                data: '',
                render: function(data, type, row) {
                    return `
                    <button class="btn btn-sm btn-primary update-stok" data-id="${row.id}" data-nama="${row.obat}" data-bs-toggle="modal"
                data-bs-target="#stokObat"><i class="bi bi-plus"></i></button>

                    <button class="btn btn-sm btn-warning edit" data-id="${row.id}" data-bs-toggle="modal"
                data-bs-target="#exampleModal"><i class="bi bi-pencil-square"></i></button>

                    <form action="/obat/delete/${row.id}" method="POST" class="d-inline">
                    <button type="submit" class="btn btn-sm btn-danger" data-id="${row.id}"><i class="bi bi-trash-fill"></i></button>
                    </form>
                    `
                }
            }
        ],
        createdRow: function(row, data, dataIndex) {
            $('td', row).eq(0).addClass('text-center fw-semibold');
            $('td', row).eq(2).addClass('text-uppercase');
            $('td', row).eq(3).addClass('text-uppercase');
            $('td', row).eq(4).addClass('text-uppercase');
            $('td', row).eq(5).addClass('text-center');
            $('td', row).eq(6).addClass('text-center');
            $('td', row).eq(7).addClass('text-center');
        },
    })
})
</script>

<?= $this->endSection() ?>