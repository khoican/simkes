<!DOCTYPE html>
<html lang="en">

<body>
    <div class="">
        <h1 class=""><?php echo $title; ?></h1>
        <table class="">
            <thead>
                <tr>
                    <th>Kode</th>
                    <th>Diagnosa Penyakit</th>
                    <th>Jumlah</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if(count($data) == 0) {
                    echo '<tr><td colspan="3">Tidak ada data</td></tr>';
                }
                foreach ($data as $row): ?>
                <tr>
                    <td><?= $row['kode']; ?></td>
                    <td><?= $row['diagnosa']; ?></td>
                    <td><?= $row['total']; ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>

</html>