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
                <p class="mb-0 fs-2 fw-bold text-capitalize"><?= $mostDiagnosa[0]['diagnosa'] ?></p>
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
                <p class="mb-0 fs-2 fw-bold text-capitalize"><?= $mostTindakan[0]['tindakan'] ?></p>
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

    <div class=" mt-5 fs-6">
        <h5 class="fw-semibold fs-4">Grafik Pengunjung</h5>

        <canvas id="chart" width="400" height="200"></canvas>
    </div>
</main>

<script>

</script>
<?= $this->endSection() ?>