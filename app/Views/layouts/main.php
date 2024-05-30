<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIMKES</title>

    <link rel="stylesheet" href="<?= base_url('assets/app.css') ?>">
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

    <script src="<?= base_url('assets/app.js') ?>" type="module"></script>
    <?= $this->renderSection('script') ?>
</body>

</html>