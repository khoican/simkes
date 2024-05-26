<nav class="navbar bg-primary shadow">
    <div class="container py-1">
        <a class="navbar-brand" href="/">
            <img src="<?=base_url('images/pemkab.png');?>" alt="Logo PEMKAB Jember" width="40">
        </a>

        <h1 class="fs-4 fw-bold text-white">REKMED ELEKTRONIK</h1>

        <div class="btn-group">
            <button type="button" class="btn btn-sm btn-outline-light dropdown-toggle" data-bs-toggle="dropdown"
                data-bs-display="static" aria-expanded="false">
                <i class="bi bi-person-fill"></i> User
            </button>
            <ul class="dropdown-menu dropdown-menu-sm-end fs-6">
                <li><a class="dropdown-item" href="/user"><i class="bi bi-person-fill"></i> Pengguna</a></li>
                <li><a class="dropdown-item" href="/poli"><i class="bi bi-hospital-fill"></i> Data Poli</a>
                <li><a class="dropdown-item" href="/diagnosa"><i class="bi bi-heart-pulse-fill"></i> Data Penyakit</a>
                </li>
                <li><a class="dropdown-item" href="/tindakan"><i class="bi bi-bandaid-fill"></i> Data Tindakan</a></li>
                <li><a class="dropdown-item" href="/obat"><i class="bi bi-capsule"></i> Data Obat</a></li>
                <li><a class="dropdown-item" href="#">
                        <button class=" btn btn-sm btn-danger w-100">
                            <i class="bi bi-box-arrow-left"></i> Logout
                        </button>
                    </a></li>
            </ul>
        </div>

    </div>
</nav>