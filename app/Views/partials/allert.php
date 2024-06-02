<?php if(session()->getFlashdata('pesan')) : ?>
<div class="position-absolute end-0 me-5 alert alert-success alert-dismissible fade show" role="alert">
    <?= session()->getFlashdata('pesan') ?>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
<?php endif; ?>

<?php if(session()->getFlashdata('error')) : ?>
<div class="position-absolute end-0 me-5 alert alert-danger alert-dismissible fade show" role="alert">
    <?= session()->getFlashdata('error') ?>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
<?php endif; ?>

<?= $this->section('script') ?>

<script type="module">
$(document).ready(function() {
    $('.alert').fadeTo(2000, 0).slideUp(500, function() {
        $('.alert').remove();
    })
})
</script>

<?= $this->endSection() ?>