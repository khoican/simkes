<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div class="mt-5">
    <section class="bg-white border rounded-3 p-4" style="width: 35%;">
        <form action="<?= $status ?>" class="fs-6" id="laporanForm" method="post">
            <?= csrf_field() ?>
            <h6 class="mb-4">Cetak Laporan</h6>
            <select class="form-select form-select-sm" aria-label="Small select example" name="status" id="lokasi_nyeri"
                disabled>
                <option value="kunjungan" <?php if (isset($status) && $status == 'kunjungan') echo 'selected'; ?>>
                    Laporan Kunjungan</option>
                <option value="diagnosa" <?php if (isset($status) && $status == 'diagnosa') echo 'selected'; ?>>
                    laporan Diagnosa Penyakit</option>
                <option value="tindakan" <?php if (isset($status) && $status == 'tindakan') echo 'selected'; ?>>
                    Laporan Tindakan</option>
                <option value="obat" <?php if (isset($status) && $status == 'obat') echo 'selected'; ?>>
                    Laporan Stok Obat</option>
            </select>
            <div>
                <label for="tgl_awal" class="form-label mt-3">Dari</label>
                <input type="date" class="form-control form-control-sm w-100" id="tgl_awal" name="dari" required>
            </div>
            <div>
                <label for="tgl_akhir" class="form-label mt-3">Hingga</label>
                <input type="date" class="form-control form-control-sm w-100" id="tgl_akhir" name="sampai" required>
            </div>

            <button type="submit" class="btn btn-sm btn-primary mt-3">Cetak PDF</button>
        </form>
    </section>
</div>

<?= $this->endSection() ?>

<?= $this->section('script') ?>
<script type="module">
$(document).ready(function() {

})
</script>
<?= $this->endSection() ?>