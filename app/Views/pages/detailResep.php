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
                <button class="btn btn-light" data-id="<?= $rekmed['id'] ?>"><i class="bi bi-eye-fill"></i></button>
            </div>
        </div>
        <div id="rekmed-<?= $rekmed['id'] ?>"></div>
        <?php endif; endforeach; ?>
    </div>
</div>

<script>
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
                rekmedId: rowId
            },
            success: function(data) {
                $(`.${id}`).addClass('disabled');
                $(`#total-${rowId}`).text(data.total)
            }
        })
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
            }
        })
    }

    $('.btn').on('click', function() {
        let id = $(this).data('id');
        let rekmed = $(`#rekmed-${id}`)

        if ($(this).hasClass('active')) {
            rekmed.html('');
            $(this).html('<i class="bi bi-eye-fill"></i>');
            $(this).removeClass('active');
        } else {
            $(this).html('<i class="bi bi-eye-slash-fill"></i>');
            $(this).addClass('active');

            $.ajax({
                url: `/apotek/obat/${id}`,
                method: 'get',
                success: function(data) {
                    let obatForm =
                        ' <div class="p-2 mt-2 mb-2 border rounded-3">'
                    data.data.forEach(function(obat) {
                        let status = obat.status == 'sudah' ? 'disabled' : '';
                        obatForm += `
                            <div class="input-group mb-1 d-flex gap-2">
                                <input type="hidden" value="${obat.id_obat}" id="obat-${obat.id}">
                                <input type="text" class="form-control form-control-sm" style="width: 70%;"
                                    value="${obat.obat}" readonly>
                                <input type="text" class="form-control form-control-sm text-center" style="width: 20%;"
                                    value="${obat.note}" id="qty-${obat.id}" readonly>
                                <button class="submit ${obat.id} btn btn-sm ${Number(obat.qty) > Number(obat.stok) ? 'btn-secondary disabled' : 'btn-primary'} ${status}" data-id="${obat.id}" data-harga="${obat.harga}" data-row-id="${id}"><i class="bi bi-plus"></i></button>
                            </div>
                        `
                    })

                    obatForm += `
                        <div class="d-flex gap-2 w-100">
                            <div class="fw-medium fs-5 text-danger text-end text-uppercase" style="width: 60%;">Total</div>
                            <div class="fw-medium fs-5 text-center" style="width: 30%;" id="total-${id}">${data.total}</div>

                            <div>
                                <button class="${data.status == 'selesai' && 'd-none'} selesai btn btn-sm btn-primary rounded-pill fs-6 d-flex align-items-center gap-2" data-id="${id}" data-rekmed-id="${data.rekmedId}"><i class="bi bi-plus fs-6"></i> Selesai</button>
                            </div>
                        </div>
                    </div>`

                    rekmed.html(obatForm);
                }
            })
        }
    });

    $(document).on('click', '.submit', function(e) {
        e.preventDefault();
        let id = $(this).data('id');
        let harga = $(this).data('harga')
        let rowId = $(this).data('row-id');
        submit(id, harga, rowId);
    });

    $(document).on('click', '.selesai', function() {
        submitSelesai();
    });
})
</script>

<?= $this->endSection() ?>