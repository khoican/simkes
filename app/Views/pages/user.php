<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div class="bg-white p-4 border rounded-3 mt-5">
    <div class="w-100 fs-6">
        <div class="d-flex justify-content-end">
            <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal"
                data-bs-target="#exampleModal"><i class="bi bi-plus"></i> Tambah Data</button>
        </div>
        <table class="table table-hover fs-6 border mb-0 w-100" id="tindakan-table">
            <thead class="table-primary text-center">
                <tr>
                    <th style="width: 5%;">No</th>
                    <th style="width: 30%;">Nama</th>
                    <th style="width: 30%;">Username</th>
                    <th style="width: 25%;">Role</th>
                    <th style="width: 10%;">Aksi</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
</div>

<div class="modal .modal-sm fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog  modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Registrasi Pengguna</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="/user/store" method="POST" class="fs-6" id="userForm">
                <div class="modal-body">
                    <?php csrf_field() ?>
                    <div class="w-100 mb-2">
                        <label for="nama" class="form-label mb-1">Nama</label>
                        <input type="text" class="form-control form-control-sm" id="nama" name="nama"
                            style="text-transform: none;" required>
                    </div>
                    <div class="w-100 mb-2">
                        <label for="username" class="form-label mb-1">Username</label>
                        <input type="text" class="form-control form-control-sm" id="username" name="username" required
                            style="text-transform: none;">
                    </div>
                    <div class="w-100 mb-2" id="passwordInput">
                        <label for="password" class="form-label mb-1">Password</label>
                        <input type="password" class="form-control form-control-sm" id="password" name="password"
                            style="text-transform: none;" required>
                    </div>
                    <div class="w-100 mb-2">
                        <p class="form-label mb-1">Role</p>
                        <select class="form-select form-select-sm" aria-label="Small select example" name="role"
                            id="role" required>
                            <option selected>Pilih Role</option>
                            <option value="loket">Loket Pendaftaran</option>
                            <option value="dokter">Dokter</option>
                            <option value="apotek">Apoteker</option>
                            <option value="rekmed">Rekam Medis</option>
                            <option value="kepala">Kepala Puskesmas</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-sm btn-primary" id="simpan">Daftar</button>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal .modal-sm fade" id="changePasswordModal" tabindex="-1" aria-labelledby="changePasswordModalLabel"
    aria-hidden="true">
    <div class="modal-dialog  modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="changePasswordModalLabel">Registrasi Pengguna</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="" method="POST" class="fs-6" id="changePasswordForm">
                <div class="modal-body">
                    <?php csrf_field() ?>
                    <div class="w-100 mb-4">
                        <label for="oldPassword" class="form-label mb-1">Password Lama</label>
                        <input type="password" class="form-control form-control-sm" id="oldPassword"
                            style="text-transform: none;" name="oldPassword" required>
                    </div>
                    <div class="w-100 mb-2">
                        <label for="newPassword" class="form-label mb-1">Password Baru</label>
                        <input type="password" class="form-control form-control-sm" id="newPassword"
                            style="text-transform: none;" name="newPassword" required>
                    </div>
                    <div class="w-100 mb-2">
                        <label for="confirmPassword" class="form-label mb-1">Konfirmasi Password</label>
                        <input type="password" class="form-control form-control-sm" id="confirmPassword"
                            style="text-transform: none;" name="confirmPassword" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-sm btn-primary" id="ubahPassword">Daftar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('script') ?>
<script type="module">
$(document).ready(function() {
    $('#nama').on('input', function() {
        let value = $(this).val()
        value = value.toLowerCase().replace(/\s+/g, '')

        $('#username').val(value)
    })

    $(document).on('click', '.edit', function() {
        let id = $(this).data('id')
        $('#exampleModalLabel').text('Edit Data Pengguna');
        $('#userForm').attr('action', '/user/update/' + id)
        $('#simpan').text('Ubah Data')
        $('#passwordInput').remove()

        $.ajax({
            url: '/user/' + id,
            method: 'GET',
            success: function(data) {
                $('#nama').val(data.nama)
                $('#username').val(data.username)
                $('#role').val(data.role)
            }
        })
    })

    $(document).on('click', '.ubah-password', function() {
        let id = $(this).data('id')
        $('#changePasswordForm').attr('action', '/user/changepassword/' + id)
        $('#changePasswordModalLabel').text('Ubah Password Pengguna')
        $('#ubahPassword').text('Ubah Password')
    })

    $('#tindakan-table').DataTable({
        ordering: true,
        order: [0, 'asc'],
        ajax: {
            url: '/user/all',
            dataSrc: ''
        },
        columns: [{
                data: '',
                render: function(data, type, row, meta) {
                    return meta.row + meta.settings._iDisplayStart + 1
                }
            },
            {
                data: 'nama'
            },
            {
                data: 'username'
            },
            {
                data: '',
                render: function(data, type, row) {
                    if (row.role == 'loket') {
                        return 'Loket Pendaftaran'
                    } else if (row.role == 'dokter') {
                        return 'Dokter'
                    } else if (row.role == 'apotek') {
                        return 'Apoteker'
                    } else if (row.role == 'rekmed') {
                        return 'Rekam Medis'
                    } else if (row.role == 'kepala') {
                        return 'Kepala Puskesmas'
                    }
                }
            },
            {
                data: '',
                render: function(data, type, row) {
                    return `
                    <button class="btn btn-sm btn-warning edit" data-id="${row.id}" data-bs-toggle="modal"
                data-bs-target="#exampleModal"><i class="bi bi-pencil-square"></i></button>
                    <button class="btn btn-sm btn-primary ubah-password" data-id="${row.id}" data-bs-toggle="modal"
                data-bs-target="#changePasswordModal"><i class="bi bi-key"></i></button>

                    <form action="/user/delete/${row.id}" method="POST" class="d-inline">
                    <button type="submit" class="btn btn-sm btn-danger" data-id="${row.id}"><i class="bi bi-trash-fill"></i></button>
                    </form>
                    `
                }
            }
        ],
        createdRow: function(row, data, dataIndex) {
            $('td', row).eq(0).addClass('text-center fw-semibold');
            $('td', row).eq(1).addClass('text-uppercase');
        },
    })
})
</script>

<?= $this->endSection() ?>