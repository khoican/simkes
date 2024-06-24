<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div class='d-flex gap-3 mt-5 border rounded-3 bg-white p-3'>
    <div class="col-3">
        <?= view_cell('PasienDataCell', ['id' => $pasienId]) ?>
    </div>

    <div class="w-100">
        <?php foreach($rekmeds as $rekmed) : 
            if($rekmed['status'] != 'tanpa obat') : ?>
        <div
            class="w-100 fs-6 <?php if($rekmed['status'] == 'selesai') : ?>bg-outline-primary<?php else : ?>bg-primary text-white<?php endif ?> d-flex align-items-center  justify-content-between p-3 rounded-3 border border-primary mb-1">
            <div>
                <p class="mb-0"><?= format_date($rekmed['created_at']) ?></p>
            </div>

            <div>
                <a href="<?= $kunjunganId ?>/detail/<?= $rekmed['id'] ?>" class="btn btn-light btn-sm fs-6"><i
                        class="bi bi-eye-fill"></i>
                    Lihat
                    Detail</a>
            </div>
        </div>
        <div id="rekmed-<?= $rekmed['id'] ?>"></div>
        <?php endif; endforeach; ?>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('script') ?>
<script type="module">
$(document).ready(function() {
    function submit(id, harga, rowId) {
        let qty = Number($(`#qty-${id}`).val());
        let obatId = $(`#obat-${id}`).val();

        $.ajax({
            url: `/apotek/obat/update/${id}`,
            method: 'post',
            data: {
                qty: qty,
                obatId: obatId,
                rekmedId: rowId,
            },
            success: function(data) {
                $(`.${id}`).addClass('disabled');
                $(`#total-${rowId}`).text(data.total);
            },
        });
    }

    function submitSelesai() {
        let path = window.location.pathname.split('/');
        let kunjunganId = path[path.length - 1];
        let rekmedId = $('.selesai').data('rekmed-id');

        $.ajax({
            url: `/apotek/kunjungan/update/${kunjunganId}/${rekmedId}`,
            method: 'post',
            success: function(data) {
                window.location.href = '/apotek/';
            },
        });
    }

    $('.btn').on('click', function() {
        let id = $(this).data('id');

    });

    $(document).on('click', '.submit', function(e) {
        e.preventDefault();
        let id = $(this).data('id');
        let harga = $(this).data('harga');
        let rowId = $(this).data('row-id');
        submit(id, harga, rowId);
    });

    $(document).on('click', '.selesai', function() {
        submitSelesai();
    });
})
</script>
<?= $this->endSection() ?>