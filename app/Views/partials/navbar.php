<nav class="navbar bg-primary shadow">
    <div class="container py-1 w-100">
        <a class="navbar-brand" href="/" style="width: 19%;">
            <img src="<?=base_url('images/pemkab.png');?>" alt="Logo PEMKAB Jember" width="40" loading="lazy">
        </a>

        <h1 class="fs-4 fw-bold text-white text-center" style="width: 60%;">REKMED ELEKTRONIK</h1>

        <div style="width: 19%;" class="d-flex justify-content-end">
            <div class="btn-group">
                <button type="button" class="w-100 btn btn-sm btn-outline-light dropdown-toggle text-capitalize"
                    data-bs-toggle="dropdown" data-bs-display="static" aria-expanded="false">
                    <i class="bi bi-person-fill"></i> <?= session()->get('name'); ?>
                </button>
                <ul class="dropdown-menu dropdown-menu-sm-end fs-6">

                    <?php if(session()->get('role') == 'rekmed') : ?>
                    <li><a class="dropdown-item" href="/user"><i class="bi bi-person-fill"></i> Pengguna</a></li>
                    <li><a class="dropdown-item" href="/poli"><i class="bi bi-hospital-fill"></i> Data Poli</a>
                    <li><a class="dropdown-item" href="/diagnosa"><i class="bi bi-heart-pulse-fill"></i> Data
                            Penyakit</a>
                    </li>
                    <li><a class="dropdown-item" href="/tindakan"><i class="bi bi-bandaid-fill"></i> Data Tindakan</a>
                    </li>
                    <li><a class="dropdown-item" href="/obat"><i class="bi bi-capsule"></i> Data Obat</a></li>

                    <?php elseif(session()->get('role') == 'apotek') : ?>
                    <li><a class="dropdown-item" href="/obat"><i class="bi bi-capsule"></i> Data Obat</a></li>
                    <?php endif; ?>

                    <li>
                        <div class="dropdown-item">
                            <form action="/user/logout" method="POST">
                                <?php csrf_field(); ?>
                                <button type="submit" class=" btn btn-sm btn-danger w-100">
                                    <i class="bi bi-box-arrow-left"></i> Logout
                                </button>
                            </form>
                        </div>
                    </li>
                </ul>
            </div>
        </div>

    </div>
</nav>