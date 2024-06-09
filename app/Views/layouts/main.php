<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="Ibnu Khoirul Prasetyo">
    <meta name="author" content="Rullstudio">
    <meta name="copyright" content="Ibnu Khoirul Prasetyo">
    <meta name="robots" content="index, follow">
    <meta name="description"
        content="Website Sistem Informasi Kesehatan ini adalah sebuah sistem untuk menunjang proses pendataan pasien, rekam medis, dan hal lainnya yang berkaitan langsung dengan instansi kesehatan menjadi elektronik sehingga mampu untuk mengurangi penggunaan kertas yang berlebih">

    <title>SIMKES</title>

    <link rel="stylesheet" href="<?= base_url('assets/app.css') ?>">
    <script type="application/ld+json">
    {
        "@context": "http://schema.org",
        "@type": "WebPage",
        "mainEntity": {
            "@type": "Person",
            "name": "Ibnu Khoirul Prasetyo",
            "sameAs": [
                "https://www.linkedin.com/in/ibnu-khoirul-7922412a4",
                "https://github.com/khoican"
                "https://instagram.com/ibnukh__"
            ]
        }
    }
    </script>
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