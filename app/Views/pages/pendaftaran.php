<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div class="bg-white p-4 border rounded-3 mt-5">
    <div class="w-100 d-flex justify-content-between">
        <div class="col-9 fs-6">
            <div class="mb-4 d-flex flex-column align-items-end">
                <div class="w-25">
                    <p class="mb-1 fs-6 fw-medium">Cari Data Pasien</p>
                    <div class="d-flex flex-column gap-3">
                        <input type="text" id="primarySearch" class="form-control form-control-sm"
                            placeholder="Cari data">
                        <input type="text" id="secondarySearch" class="form-control form-control-sm"
                            placeholder="Cari data lebih spesifik" style="display:none">
                    </div>
                </div>
            </div>

            <table class="table table-hover fs-6 border" id="dataTable">
                <thead class="table-primary text-center">
                    <tr>
                        <th scope="col" style="width: 0%;">Created At</th>
                        <th scope="col" style="width: 15%;">No. RM</th>
                        <th scope="col" style="width: 15%;">No. KTP</th>
                        <th scope="col" style="width: 33%;">Nama Lengkap</th>
                        <th scope="col" style="width: 20%;">Alamat</th>
                        <th scope="col" style="width: 12%;">Opsi</th>
                    </tr>
                </thead>
                <tbody id="tbody"></tbody>
            </table>
        </div>
        <div class="col-3 d-flex flex-column pt-5 align-items-center">
            <button type="button" data-bs-toggle="modal" data-bs-target="#exampleModal"
                class="btn d-flex align-items-center justify-content-center bg-primary rounded-circle"
                style="width: 50px; height: 50px;" id="add-pasien">
                <i class="bi bi-plus fs-2 text-white mb-0"></i>
            </button>
            <p class="mt-2 fs-6 font-light">Tambah Pasien Baru</p>
        </div>
    </div>
</div>

<?= $this->include('partials/modalPasien') ?>
<?= $this->include('partials/modalAntrian') ?>

<?= $this->endSection() ?>

<?= $this->section('script') ?>
<script type="module">
$(document).ready(function() {
    var table = $('#dataTable').DataTable({
        processing: true,
        serverSide: true,
        order: [
            [0, 'desc']
        ],
        searching: false,
        ajax: {
            url: '/pendaftaran/get-pasien',
            type: 'POST',
            data: function(d) {
                d.primarySearch = $('#primarySearch').val();
                d.secondarySearch = $('#secondarySearch').val();
            },
            dataSrc: function(json) {
                if ($('#primarySearch').val() === '') {
                    $('#secondarySearch').hide();
                    $('#secondarySearch').val('');
                } else {
                    $('#secondarySearch').show();
                }
                return json.data;
            },
        },
        columns: [{
                data: 'created_at',
                visible: false
            },
            {
                data: 'no_rekam_medis'
            },
            {
                data: 'nik'
            },
            {
                data: 'nama'
            },
            {
                data: null,
                render: function(data, type, row) {
                    return row.kelurahan + ', ' + row.kecamatan;
                },
            },
            {
                data: null,
                render: function(data, type, row) {
                    return `
                        <button type="button" class="edit-pasien btn btn-warning" data-bs-toggle="modal" data-bs-target="#exampleModal" data-id="${row.id}"><i class="bi bi-pencil-square"></i></button>
                        <button type="button" class="add-antrian btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalAntrian" data-id="${row.id}"><i class="bi bi-plus text-white"></i></button>
                    `;
                },
            },
        ],
        createdRow: function(row, data, dataIndex) {
            $('td', row).eq(0).addClass('text-start');
            $('td', row).eq(1).addClass('text-start');
            $('td', row).eq(2).addClass('text-uppercase');
            $('td', row).eq(3).addClass('text-uppercase');
        },
        paging: true,
        pageLength: 10
    });

    $('#primarySearch').on('keyup', function() {
        table.draw();
    });

    $('#secondarySearch').on('keyup', function() {
        table.draw();
    });
});
</script>

<?= $this->endSection() ?>