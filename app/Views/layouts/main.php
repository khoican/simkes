<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIMKES</title>

    <link rel="stylesheet" href="<?=base_url('css/bootstrap.css')?>">
    <link rel="stylesheet" href="<?=base_url('css/bootstrap-icons.css')?>">
    <link rel="stylesheet" href="<?=base_url('css/index.css')?>">
    <link rel="stylesheet" href="<?=base_url('css/datatables.min.css') ?>">
    <link rel="stylesheet" href="<?=base_url('css/select2-bootstrap-5-theme.min.css') ?>">
    <link rel="stylesheet" href="<?=base_url('css/select2.min.css') ?>">
    <script src="<?=base_url('js/jquery.js')?>"></script>
    <script src="<?=base_url('js/datatables.min.js') ?>"></script>
    <script src="<?=base_url('js/bootstrap.js')?>"></script>
    <script src="<?=base_url('js/moment.js')?>"></script>
    <script src="<?=base_url('js/select2.full.min.js') ?>"></script>
</head>

<body class="bg-light">
    <?= $this->include('partials/navbar') ?>

    <?= $this->include('partials/allert') ?>
    <section class="px-5">
        <?= $this->include('partials/menu') ?>


        <main class="container-fluid mt-4">
            <?= $this->renderSection('content') ?>
        </main>
    </section>


</body>

</html>