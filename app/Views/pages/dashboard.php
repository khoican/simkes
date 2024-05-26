<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<!-- <h1 class="fs-5 fw-medium">Laporan</h1> -->

<div class="d-flex justify-content-between align-items-center mt-5">
    <div class="border border-success rounded-3 text-success p-3 d-flex justify-content-between shadow-sm"
        style="width: 32%">
        <i class="bi bi-people-fill fs-1"></i>
        <div class="text-end">
            <p class="mb-0 text-secondary" style="font-size: 12px;">Kunjungan Hari ini</p>
            <p class="mb-0 fs-2 fw-bold"><?= $countKunjungan ?></p>
        </div>
    </div>
    <div class="border border-warning rounded-3 text-warning p-3 d-flex justify-content-between shadow-sm"
        style="width: 32%">
        <i class="bi bi-heart-pulse-fill fs-1"></i>
        <div class="text-end">
            <p class="mb-0 text-secondary" style="font-size: 12px;">Penyakit Terbanyak</p>
            <p class="mb-0 fs-2 fw-bold">Influenza</p>
        </div>
    </div>
    <div class="border border-danger rounded-3 text-danger p-3 d-flex justify-content-between shadow-sm"
        style="width: 32%">
        <i class="bi bi-bandaid-fill fs-1"></i>
        <div class="text-end">
            <p class="mb-0 text-secondary" style="font-size: 12px;">Tindakan Terbanyak</p>
            <p class="mb-0 fs-2 fw-bold">Rawat Inap</p>
        </div>
    </div>
</div>

<?= $this->endSection() ?>