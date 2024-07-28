<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<main>
    <div class="d-flex flex-wrap justify-content-between align-items-center mt-5 gap-3">
        <div class="border border-success rounded-3 text-success p-3 d-flex justify-content-between shadow-sm"
            style="width: 32%">
            <i class="bi bi-people-fill fs-1"></i>
            <div class="text-end">
                <p class="mb-0 text-secondary" style="font-size: 12px;">Kunjungan Hari ini</p>
                <p class="mb-0 fs-2 fw-bold"><?= $countKunjungan ?></p>
            </div>
        </div>
        <div class=" border border-danger rounded-3 text-danger p-3 d-flex justify-content-between shadow-sm"
            style="width: 32%">
            <i class="bi bi-heart-pulse-fill fs-1"></i>
            <div class="text-end">
                <p class="mb-0 text-secondary" style="font-size: 12px;">Penyakit Terbanyak</p>
                <p class="mb-0 fs-2 fw-bold text-capitalize">
                    <?= $mostDiagnosa ? $mostDiagnosa[0]['diagnosa'] : 'Data Tidak Tersedia' ?></p>
            </div>
        </div>
        <div class=" border border-info rounded-3 text-info p-3 d-flex justify-content-between shadow-sm"
            style="width: 32%">
            <i class="bi bi-capsule-pill fs-1"></i>
            <div class="text-end">
                <p class="mb-0 text-secondary" style="font-size: 12px;">Stok Obat Masuk</p>
                <p class="mb-0 fs-2 fw-bold text-capitalize"><?= $countObatMasuk ?></p>
            </div>
        </div>
        <div class="border border-primary rounded-3 text-primary p-3 d-flex justify-content-between shadow-sm"
            style="width: 32%">
            <i class="bi bi-person-plus-fill fs-1"></i>
            <div class="text-end">
                <p class="mb-0 text-secondary" style="font-size: 12px;">Pasien Baru</p>
                <p class="mb-0 fs-2 fw-bold text-capitalize"><?= $countPasien ?></p>
            </div>
        </div>
        <div class="border border-warning rounded-3 text-warning p-3 d-flex justify-content-between shadow-sm"
            style="width: 32%">
            <i class="bi bi-bandaid-fill fs-1"></i>
            <div class="text-end">
                <p class="mb-0 text-secondary" style="font-size: 12px;">Tindakan Terbanyak</p>
                <p class="mb-0 fs-2 fw-bold text-capitalize">
                    <?= $mostTindakan ? $mostTindakan[0]['tindakan'] : 'Data Tidak Tersedia' ?>
                </p>
            </div>
        </div>
        <div class="border border-secondary rounded-3 text-secondary p-3 d-flex justify-content-between shadow-sm"
            style="width: 32%">
            <i class="bi bi-capsule fs-1"></i>
            <div class="text-end">
                <p class="mb-0 text-secondary" style="font-size: 12px;">Stok Obat Keluar</p>
                <p class="mb-0 fs-2 fw-bold text-capitalize"><?= $countObatKeluar ?></p>
            </div>
        </div>
    </div>

    <div class="mt-3 text-end">
        <a href="<?= site_url('pdfviewer'); ?>" target="_blank" class="btn btn-primary"><i
                class="bi bi-file-earmark-ruled"></i>
            Laporan</a>
    </div>

    <div class=" mt-5 fs-6 p-4 bg-white rounded-3 d-flex gap-5">
        <div class="w-50">
            <div class="d-flex justify-content-between mb-4">
                <h5 class="fw-semibold fs-4">Grafik Pengunjung</h5>

                <div class="w-50 d-flex gap-2">
                    <select name="year" id="year" class="form-select form-select-sm w-50 text-capitalize">
                        <option>Pilih Tahun</option>
                    </select>
                    <select name="month" id="month" class="form-select form-select-sm w-50 text-capitalize">
                        <option>Pilih Bulan</option>
                    </select>
                </div>
            </div>

            <div style="height: 400px; width: 100%">
                <canvas id="chart" width="200" height="400"></canvas>
            </div>
        </div>

        <div class="w-50">
            <div class="d-flex justify-content-between mb-4">
                <h5 class="fw-semibold fs-4">Rata-Rata Waktu Pemeriksaan</h5>
            </div>

            <div style="height: 400px; width: 100%">
                <canvas id="pie" height="400"></canvas>
            </div>
        </div>
    </div>
    <div class=" mt-5 fs-6">
        <div class="d-flex gap-3 mb-4">
            <div class="w-50 p-4 bg-white rounded-3">
                <h5 class="fw-semibold fs-4">Penyakit Terbanyak</h5>

                <table class="mt-3 table table-hover border">
                    <thead class="table-primary">
                        <tr>
                            <th style="width: 10%;">No</th>
                            <th style="width: 90%;">Diagnosa Penyakit</th>
                            <th style="width: 20%;" class="text-center">Jumlah</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        if (count($mostDiagnosa) > 0) :
                        foreach($mostDiagnosa as $key => $value) : ?>
                        <tr>
                            <td class="text-center fw-medium"><?= $key + 1 ?></td>
                            <td class="text-capitalize fw-medium"><?= $value['diagnosa'] ?></td>
                            <td class="text-capitalize fw-medium text-center"><?= $value['total'] ?></td>
                        </tr>
                        <?php endforeach; ?>
                        <?php else : ?>
                        <tr>
                            <td class="text-center fw-medium" colspan="2">Data Tidak Tersedia</td>
                        </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
            <div class="w-50 p-4 bg-white rounded-3">
                <h5 class="fw-semibold fs-4">Tindakan Terbanyak</h5>

                <table class="mt-3 table table-hover border">
                    <thead class="table-primary">
                        <tr>
                            <th style="width: 10%;">No</th>
                            <th style="width: 90%;">Jenis Tindakan</th>
                            <th style="width: 20%;" class="text-center">Jumlah</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        if (count($mostTindakan) > 0) :
                        foreach($mostTindakan as $key => $value) : ?>
                        <tr>
                            <td class="text-center fw-medium"><?= $key + 1 ?></td>
                            <td class="text-capitalize fw-medium"><?= $value['tindakan'] ?></td>
                            <td class="text-capitalize fw-medium text-center"><?= $value['total'] ?></td>
                        </tr>
                        <?php endforeach; ?>
                        <?php else : ?>
                        <tr>
                            <td class="text-center fw-medium" colspan="2">Data Tidak Tersedia</td>
                        </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="mt-5 fs-6 p-4 bg-white rounded-3">
        <h5 class="fw-semibold fs-4">History Stok Obat</h5>

        <table class="mt-3 table table-hover border">
            <thead class="table-primary">
                <tr class="text-center">
                    <th style="width: 10%;">No</th>
                    <th style="width: 60%;">Obat</th>
                    <th style="width: 10%;">Obat Masuk</th>
                    <th style="width: 10%;">Obat Keluar</th>
                    <th style="width: 10%;">Stok</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                if (count($historyObat) > 0) :
                foreach($historyObat as $key => $value) : ?>
                <tr>
                    <td class="text-center fw-medium"><?= $key + 1 ?></td>
                    <td class="text-capitalize fw-medium"><?= $value['obat'] ?></td>
                    <td class="text-capitalize text-center">
                        <?php if($value['masuk'] != null) { echo $value['masuk']; } else { echo '0'; } ?></td>
                    <td class="text-capitalize text-center">
                        <?php if($value['keluar'] != null) { echo $value['keluar']; } else { echo '0'; } ?></td>
                    <td class="text-capitalize text-center"><?= $value['stok'] ?></td>
                </tr>
                <?php endforeach; ?>
                <?php else : ?>
                <tr>
                    <td class="text-center fw-medium" colspan="5">Data Tidak Tersedia</td>
                </tr>
                <?php endif; ?>
        </table>
    </div>
</main>
<?= $this->endSection() ?>

<?= $this->section('script') ?>
<script type="module">
$(document).ready(function() {
    let getYear = moment().year();
    let getMonth = moment().month() + 1;
    let chartInstance = null;

    function selectYear() {
        let months = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September',
            'Oktober', 'November', 'Desember'
        ];

        for (let i = 0; i <= 20; i++) {
            $('#year').append(`<option value="${getYear - i}">${getYear - i}</option>`);
        }

        $('#year').on('input', function() {
            if (this.value == getYear) {
                for (let i = 0; i < getMonth; i++) {
                    $('#month').append(`<option value="${i + 1}">${months[i]}</option>`);
                }
            } else {
                for (let i = 0; i < months.length; i++) {
                    $('#month').append(`<option value="${i + 1}">${months[i]}</option>`);
                }
            }

            loadData(this.value, $('#month').val());
        })

        $('#month').on('input', function() {
            loadData($('#year').val(), this.value);
        })
    }
    selectYear()

    function loadData(year, month) {
        $.ajax({
            url: `/dashboard/kunjungan/total/${year}/${month == 'Pilih Bulan' ? 'all' : month}`,
            method: 'get',
            success: function(data) {
                const labels = data.map(item => item.date);
                const counts = data.map(item => item.count);

                if (chartInstance) {
                    chartInstance.destroy();
                }

                const ctx = $('#chart')[0].getContext('2d');
                chartInstance = new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: labels,
                        datasets: [{
                            data: counts,
                            backgroundColor: 'rgba(0, 0, 0, 0)',
                            borderColor: 'rgb(0, 0, 139)',
                            borderWidth: 2
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        scales: {
                            x: {
                                grid: {
                                    display: false
                                },
                                beginAtZero: true,
                            },
                            y: {
                                grid: {
                                    display: false
                                },
                                beginAtZero: true
                            }
                        },
                        elements: {
                            point: {
                                radius: 0
                            }
                        },
                        plugins: {
                            legend: {
                                display: false
                            },
                            tooltip: {
                                enabled: true
                            }
                        }
                    }
                });
            }
        })
    }

    loadData(getYear, getMonth);

    function pieChart() {
        const ctx = $('#pie')[0].getContext('2d');

        const pieChartLabels = ['Dibawah 1 jam', 'Lebih dari 1 jam'];
        const pieChartData = [<?= $serviceTime['under'] ?>, <?= $serviceTime['over'] ?>];

        new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: pieChartLabels,
                datasets: [{
                    label: '',
                    data: pieChartData,
                    backgroundColor: [
                        'rgb(54, 162, 235)',
                        'rgb(255, 99, 132)',
                    ],
                    hoverOffset: 4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
            }
        })
    }
    pieChart()

})
</script>
<?= $this->endSection() ?>