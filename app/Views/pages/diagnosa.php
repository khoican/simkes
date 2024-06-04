<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div class="bg-white p-4 border rounded-3 mt-5">
    <div class="w-100 fs-6">
        <div class="d-flex justify-content-end">
            <button type="button" id="add" class="btn btn-sm btn-primary" data-bs-toggle="modal"
                data-bs-target="#exampleModal"><i class="bi bi-plus"></i> Tambah Data</button>
        </div>
        <table class="table table-hover fs-6 border mb-0 w-100" id="diagnosa-table">
            <thead class="table-primary text-center">
                <tr>
                    <th style="width: 5%;">No</th>
                    <th style="width: 25%;">Kode</th>
                    <th style="width: 60%;">Diagnosa</th>
                    <th style="width: 10%;">Aksi</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
</div>
<div class="modal .modal-sm fade" id="exampleModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog  modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Tambah Data</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="/diagnosa/store" method="POST" class="fs-6" id="diagnosaForm">
                <div class="modal-body">
                    <?php csrf_field() ?>
                    <div class="w-100 mb-3">
                        <label for="kode" class="form-label">Kode Diagnosa</label>
                        <input type="text" class="form-control form-control-sm" id="kode" name="kode" required>
                    </div>
                    <div class="w-100">
                        <label for="diagnosa" class="form-label">Diagnosa</label>
                        <input type="text" class="form-control form-control-sm" id="diagnosa" name="diagnosa" required>
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
    $('#add').on('shown.bs.modal', function() {
        $('#diagnosa').focus();
    });

    $(document).on('click', '.edit', function() {
        let id = $(this).data('id');
        $('#exampleModalLabel').text('Edit Data');
        $('#diagnosaForm').attr('action', '/diagnosa/update/' + id);
        $('#diagnosa').focus();

        $.ajax({
            url: '/diagnosa/' + id,
            method: 'GET',
            success: function(data) {
                $('#kode').val(data.kode);
                $('#diagnosa').val(data.diagnosa);
            },
        });
    });

    $('#diagnosa-table').DataTable({
        ordering: true,
        order: [0, 'asc'],
        ajax: {
            url: '/diagnosa/all',
            dataSrc: '',
        },
        columns: [{
                data: '',
                render: function(data, type, row, meta) {
                    return meta.row + meta.settings._iDisplayStart + 1;
                },
            },
            {
                data: 'kode',
            },
            {
                data: 'diagnosa',
            },
            {
                data: '',
                render: function(data, type, row) {
                    return `
                            <button class="btn btn-sm btn-warning edit" data-id="${row.id}" data-bs-toggle="modal"
                        data-bs-target="#exampleModal"><i class="bi bi-pencil-square"></i></button>
        
                            <form action="/diagnosa/delete/${row.id}" method="POST" class="d-inline">
                            <button type="submit" class="btn btn-sm btn-danger" data-id="${row.id}"><i class="bi bi-trash-fill"></i></button>
                            </form>
                            `;
                },
            },
        ],
        createdRow: function(row, data, dataIndex) {
            $('td', row).eq(0).addClass('text-center fw-semibold');
            $('td', row).eq(2).addClass('text-uppercase');
        },
    });
})
</script>

<?= $this->endSection() ?>