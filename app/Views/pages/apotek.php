<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div class="bg-white p-4 border rounded-3 mt-5">
    <div class="w-100 fs-6">
        <table class="table table-hover fs-6 border mb-0 w-100" id="antrian">
            <thead class="table-primary text-center">
                <tr>
                    <th>No. Antrian</th>
                    <th>No. Rekam Medis</th>
                    <th>No. KTP</th>
                    <th>Nama Lengkap</th>
                    <th>Alamat</th>
                    <th>Poli Tujuan</th>
                    <th>Opsi</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
</div>

<script>
$(document).ready(function() {
    $('#antrian').DataTable({
        ordering: true,
        order: [0, 'asc'],
        ajax: {
            url: '/kunjungan/antrian-obat',
            dataSrc: ''
        },
        columns: [{
                data: 'no_antrian'
            },
            {
                data: 'no_rekam_medis'
            },
            {
                data: 'nik'
            },
            {
                data: 'nama_pasien'
            },
            {
                data: '',
                render: function(data, type, row) {
                    return row.kelurahan + ', ' + row.kecamatan
                }
            },
            {
                data: 'nama',
            },
            {
                data: '',
                render: function(data, type, row) {
                    return `
                    <div class="d-flex gap-1 w-100">
                        <form action="/kunjungan/panggil/${row.id_kunjungan}" method="POST">
                            <button type="submit" class="btn rounded-pill ${row.panggil == 1 ? 'btn-outline-primary disabled' : 'btn-primary'} btn-sm">Panggil</button>
                        </form>
                        
                        <form action="/apotek/${row.id_kunjungan}" method="POST">
                            <button type="submit" class="btn rounded-pill ${row.panggil == 1 ? 'btn-primary' : 'btn-outline-primary disabled'} btn-sm">Lihat Obat</button>
                        </form>
                    </div>
                        `;
                }
            }
        ],
        paging: true,
        pageLength: 5,
        lengthMenu: [
            [5, 10, 25, 50, -1],
            [5, 10, 25, 50, "All"]
        ],
        createdRow: function(row, data, dataIndex) {
            $('td', row).eq(0).addClass('text-center fw-semibold');
            $('td', row).eq(1).addClass('text-start');
            $('td', row).eq(2).addClass('text-start');
            $('td', row).eq(5).addClass('text-center fw-semibold');
        },
        columnDefs: [{
            targets: [0],
            className: 'dt-head-center'
        }]
    })
})
</script>

<?= $this->endSection() ?>