<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<main>
    <div class="d-flex flex-wrap justify-content-between align-items-center mt-5 gap-3">
        <div class="border border-success rounded-3 text-success p-3 d-flex justify-content-between shadow-sm"
            style="width: 49%;">
            <i class="bi bi-people-fill fs-1"></i>
            <div class="text-end">
                <p class="mb-0 text-secondary" style="font-size: 12px;">Kunjungan Hari ini</p>
                <p class="mb-0 fs-2 fw-bold"><?= $countKunjungan ?></p>
            </div>
        </div>
        <div class="border border-primary rounded-3 text-primary p-3 d-flex justify-content-between shadow-sm"
            style="width: 49%;">
            <i class="bi bi-person-plus-fill fs-1"></i>
            <div class="text-end">
                <p class="mb-0 text-secondary" style="font-size: 12px;">Pasien Baru</p>
                <p class="mb-0 fs-2 fw-bold text-capitalize"><?= $countPasien ?></p>
            </div>
        </div>
    </div>

    <div class=" mt-5 fs-6 p-4 bg-white rounded-3">
        <div class="d-flex justify-content-between mb-4">
            <h5 class="fw-semibold fs-4">Grafik Pengunjung</h5>

            <div class="w-25 d-flex gap-2">
                <select name="year" id="year" class="form-select form-select-sm w-50 text-capitalize">
                    <option>Pilih Tahun</option>
                </select>
                <select name="month" id="month" class="form-select form-select-sm w-50 text-capitalize">
                    <option>Pilih Bulan</option>
                </select>
            </div>
        </div>

        <canvas id="chart" width="400" height="100"></canvas>
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
})
</script>
<?= $this->endSection() ?>