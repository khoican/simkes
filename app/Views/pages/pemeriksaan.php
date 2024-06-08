<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div class="bg-white p-4 border rounded-3 mt-5">
    <div class="w-100 fs-6">
        <div class="text-end">
            <button class="btn btn-sm btn-primary status" data-status="antrian">Antrian Aktif</button>
            <button class="btn btn-sm btn-outline-primary status" data-status="all">Semua Kujungan</button>
        </div>
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

        <div class="d-flex justify-content-center gap-3">
            <?php foreach ($polis as $poli) : ?>
            <?php if (isset($kunjungans[$poli['id']])) : ?>
            <div class="text-center btn poli-card kunjungan" data-id="<?= $poli['id'] ?>">
                <p class="mb-0 fw-medium fs-6 text-capitalize">poli <?= esc($kunjungans[$poli['id']]['nama']) ?></p>
                <div>
                    <h1 class="mb-0 fw-bold"><?= esc($kunjungans[$poli['id']]['no_antrian']) ?></h1>
                </div>
            </div>
            <?php endif; ?>
            <?php endforeach; ?>
        </div>

    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('script') ?>
<script type="module">
$(document).ready(function() {
    function initializeDataTable(url) {
        $('#antrian').DataTable({
            destroy: true,
            ordering: true,
            order: [0, 'asc'],
            ajax: {
                url: url,
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
                        return row.kelurahan + ', ' + row.kecamatan;
                    }
                },
                {
                    data: '',
                    render: function(data, type, row) {
                        let bg = [
                            'btn-success',
                            'btn-warning',
                            'btn-info',
                            'btn-danger',
                            'btn-primary',
                            'btn-secondary',
                        ];
                        return `
                            <div class="text-capitalize btn btn-sm ${bg[row.id_poli - 1]}" data-id="${row.id_poli}">poli ${row.nama}</div>
                        `;
                    }
                },
                {
                    data: '',
                    render: function(data, type, row) {
                        console.log(data);
                        if (url == '/kunjungan/antrian') {
                            return `
                                <div class="d-flex gap-1 w-100">
                                    <form action="/kunjungan/panggil/${row.id_kunjungan}" method="POST">
                                        <input type="hidden" name="no_antrian" value="${row.no_antrian}">
                                        <input type="hidden" name="id_poli" value="${row.id_poli}">
                                        <input type="hidden" name="status" value="pemeriksaan">
                                        <button type="submit" class="btn rounded-pill ${row.panggil == 1 ? 'btn-outline-primary disabled' : 'btn-primary'} btn-sm">Panggil</button>
                                    </form>
                                    <form action="/pemeriksaan/${row.id_kunjungan}" method="POST">
                                        <button type="submit" class="btn rounded-pill ${row.panggil == 1 ? 'btn-primary' : 'btn-outline-primary disabled'} btn-sm">Periksa</button>
                                    </form>
                                    </div>
                                `;
                        } else {
                            return `
                                <a href="/rekmed/${row.id_pasien}" class="btn rounded-pill btn-primary btn-sm">Lihat</a>
                            `
                        }
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
                $('td', row).eq(3).addClass('text-uppercase');
                $('td', row).eq(4).addClass('text-uppercase');
                $('td', row).eq(5).addClass('text-center fw-semibold text-uppercase');
            },
            columnDefs: [{
                targets: [0],
                className: 'dt-head-center'
            }]
        });
    }

    // Initialize DataTable on page load
    initializeDataTable(`/kunjungan/antrian`);

    // Re-initialize DataTable on status change
    $('.status').on('click', function() {
        let status = $(this).data('status');
        initializeDataTable(`/kunjungan/${status}`);
    });

    function kunjunganColor() {
        $('.kunjungan').each(function() {
            let bg = [
                'btn-success',
                'btn-warning',
                'btn-info',
                'btn-danger',
                'btn-primary',
                'btn-secondary',
            ];
            let id = $(this).data('id')
            $(this).addClass(bg[id - 1])
        })
    }
    kunjunganColor()
});
</script>

<?= $this->endSection() ?>