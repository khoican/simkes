<div class="modal fade" id="modalAntrian" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body p-4">
                <h5 class="text-center fs-5">Tambah Antrian</h5>
                <div class="d-flex gap-1 justify-content-center mt-4 flex-wrap" id="antrian">
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->section('script') ?>
<script type="module">
$(document).ready(function() {
    $('#dataTable tbody').on('click', '.add-antrian', function() {
        let pasienId = $(this).data('id');

        $.ajax({
            url: '/kunjungan/generate-antrian',
            type: 'GET',
            success: function(data) {
                let element = $('#antrian');
                let bg = [
                    'btn-success',
                    'btn-warning',
                    'btn-info',
                    'btn-danger',
                    'btn-primary',
                    'btn-secondary',
                ];
                element.empty();

                data.forEach(function(item, index) {
                    element.append(`
                            <form id="antrianForm" class="flex-grow-1" action="/kunjungan/store" method="POST">
                                <input name="id_pasien" value="${pasienId}" hidden>
                                <input name="id_poli" value="${item.id}" hidden>
                                <input name="no_antrian" value="${item.antrian}" hidden>
                                <button type="submit" class="btn ${bg[index]} text-uppercase shadow w-100 h-100"  id="add-antrian">
                                    <p class="mb-0">poli ${item.nama}</p>
                                    <h1>${item.antrian}</h1>
                                </button>
                            </form>
                            `);
                });
            },
            error: function() {
                console.log('error');
            },
        });
    });

    $('#modalAntrian').on('hidden.bs.modal', function() {
        resetForm();
    });

    function resetForm() {
        $('#antrianForm')[0].reset();
    }
})
</script>
<?= $this->endSection() ?>