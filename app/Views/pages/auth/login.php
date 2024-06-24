<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>

    <link rel="stylesheet" href="<?= base_url('assets/app.css') ?>">

    <style>
    input {
        text-transform: none;
    }
    </style>

</head>

<body class="overflow-hidden">
    <div class="container-fluid h-100">
        <div class="row h-100">
            <div class="col-md-4 d-flex justify-content-center align-items-center relative">
                <div class="w-75">
                    <div class="d-flex gap-2 mb-5 justify-content-center align-items-center">
                        <img src="<?= base_url('images/pemkab.png') ?>" style="width: 50px; height: 100%;" alt="">
                        <div>
                            <h5 class="mb-0 fw-medium fs-4">REKAM MEDIS ELEKTRONIK</h5>
                            <h4 class="mb-0 fw-semibold fs-3">SUMBERSARI</h4>
                        </div>
                    </div>

                    <?php if(session()->getFlashdata('error')) : ?>
                    <p class="text-danger fw-semibold fs-6" role="alert">
                        <?= session()->getFlashdata('error') ?> !
                    </p>
                    <?php endif; ?>

                    <div>
                        <h3 class="mb-1 fw-semibold fs-4">Login</h3>
                        <p class="fw-light fs-6">Silahkan masukkan username dan password yang sudah terdaftar</p>
                    </div>

                    <form class="fs-6" action="/user/login" method="post">
                        <?= csrf_field() ?>
                        <div class="mb-3">
                            <label for="username" class="form-label">Username</label>
                            <input type="text" class="form-control form-control-sm" name="username" id="username"
                                aria-describedby="emailHelp">
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control form-control-sm" name="password" id="password">
                            <p class="text-danger fs-6" id="passwordError"></p>
                        </div>
                        <div class="mb-3 form-check">
                            <input type="checkbox" class="form-check-input" id="exampleCheck1">
                            <label class="form-check-label" for="exampleCheck1">Check me out</label>
                        </div>
                        <button type="submit" class="btn btn-primary btn-sm d-flex gap-2 align-items-center">Login <i
                                class="bi bi-arrow-right"></i></button>
                    </form>
                </div>
            </div>
            <div class="col-md-8 p-0">
                <img src="<?= base_url('images/hero.jpg') ?>" class="vh-100" alt="">
            </div>
        </div>
    </div>

    <script src="<?= base_url('assets/app.js') ?>" type="module"></script>
    <script type="module">
    $(document).ready(function() {
        $('#username').on('input', function() {
            if ($(this).val.length > 0) {
                $('#passwordError').html(`<span class="fw-semibold">*</span> Password harus diisi`);
            } else {
                $('#passwordError').text('');
            }
        })
    })
    </script>
</body>

</html>