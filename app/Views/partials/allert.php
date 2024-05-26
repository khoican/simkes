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