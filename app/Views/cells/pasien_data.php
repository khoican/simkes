<div class="w-100 bg-primary rounded-3 shadow p-3">
    <div class="d-flex flex-column justify-content-center align-items-center mt-5">
        <div class="p-2 bg-white rounded-circle d-flex justify-content-center align-items-center"
            style="width: 5rem; height: 5rem;">
            <i class="bi bi-person-fill text-primary" style="font-size: 3.5rem;"></i>
        </div>

        <div class="mt-3 text-center w-100 bg-white rounded-pill p-2">
            <h1 class="fw-semibold fs-5 mb-0 text-capitalize"><?= esc($pasienData['nama_pasien']) ?></h1>
            </h1>
            <p class="mb-0 fw-medium" style="font-size: 0.7rem">No. RM <?= esc($pasienData['no_rekam_medis']) ?></p>
        </div>
    </div>

    <div class="mt-4 bg-white overflow-hidden rounded-3">
        <table class="table text-center">
            <tr>
                <td colspan="2">
                    <p class="mb-0" style="font-size: 0.6rem">No. Identitas / KTP</p>
                    <p class="mb-0 fs-6 fw-medium"><?= esc($pasienData['nik']) ?></p>
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <p class="mb-0" style="font-size: 0.6rem">No. BPJS</p>
                    <p class="mb-0 fs-6 fw-medium"><?php if ($pasienData['no_bpjs'] == null) : ?> -
                        <?php else : ?><?= esc($pasienData['no_bpjs']) ?><?php endif; ?></p>
                </td>
            </tr>
            <tr>
                <td>
                    <p class="mb-0" style="font-size: 0.6rem">Tanggal Lahir</p>
                    <p class="mb-0 fs-6 fw-medium"><?= format_date($pasienData['tgl_lahir']) ?></p>
                </td>
                <td>
                    <p class="mb-0" style="font-size: 0.6rem">Umur</p>
                    <p class="mb-0 fs-6 fw-medium"><?= esc($pasienData['usia']) ?></p>
                </td>
            </tr>
            <tr>
                <td>
                    <p class="mb-0" style="font-size: 0.6rem">Agama</p>
                    <p class="mb-0 fs-6 fw-medium text-uppercase"><?= esc($pasienData['agama']) ?></p>
                </td>
                <td>
                    <p class="mb-0" style="font-size: 0.6rem">Golongan Darah</p>
                    <p class="mb-0 fs-6 fw-medium text-uppercase"><?= esc($pasienData['gol_darah']) ?></p>
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <p class="mb-0" style="font-size: 0.6rem">Tanggal Kunjungan</p>
                    <p class="mb-0 fs-6 fw-medium"><?= format_date($pasienData['created_at']) ?></p>
                </td>
            </tr>
            <tr>
                <td>
                    <p class="mb-0" style="font-size: 0.6rem">Status Kunjungan</p>
                    <p class="mb-0 fs-6 fw-medium text-uppercase"><?= str_replace('-', ' ',$pasienData['status']) ?></p>
                </td>
                <td>
                    <p class="mb-0" style="font-size: 0.6rem">Tujuan Poli</p>
                    <p class="mb-0 fs-6 fw-medium text-uppercase"><?= esc($pasienData['nama_poli']) ?></p>
                </td>
            </tr>
        </table>
    </div>
</div>

<button class="btn btn-primary w-100 mt-3" data-bs-toggle="modal" data-bs-target="#consent">
    General Consent
</button>

<div class="modal fade" id="consent" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content fs-6">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">General Consent</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label for="nama" class="col-form-label">Nama Wali</label>
                    <input type="text" class="form-control form-control-sm" readonly id="nama" name="nama"
                        value="<?= esc($generalConsent['nama']) ?>">
                </div>
                <div class="mb-3">
                    <label for="umur" class="col-form-label">Umur Wali</label>
                    <input type="number" class="form-control form-control-sm" readonly id="umur" name="umur"
                        value="<?= esc($generalConsent['umur']) ?>">
                </div>
                <div class="mb-3">
                    <label for="alamat" class="col-form-label">Alamat Wali</label>
                    <input type="text" class="form-control form-control-sm" readonly id="alamat" name="alamat"
                        value="<?= esc($generalConsent['alamat']) ?>">
                </div>
                <div class="mb-3">
                    <label for="no_telp" class="col-form-label">No Telepon Wali</label>
                    <input type="number" class="form-control form-control-sm" readonly id="no_telp" name="no_telp"
                        value="<?= esc($generalConsent['no_telp']) ?>">
                </div>
                <div class="mb-3">
                    <label for="status" class="col-form-label">Status Hubungan</label>
                    <select class="form-select form-select-sm" aria-label="Small select example" id="status"
                        name="status" disabled>
                        <option value="<?= esc($generalConsent['status']) ?>"><?= esc($generalConsent['status']) ?>
                        </option>
                    </select>
                </div>
            </div>
        </div>
    </div>
</div>