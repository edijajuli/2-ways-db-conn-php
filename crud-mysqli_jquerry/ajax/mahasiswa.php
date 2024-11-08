<?php
usleep(500000);
require '../functions.php';
$keyword = $_GET["keyword"];
$query = "SELECT * FROM mahasiswa WHERE
name LIKE '%$keyword%' OR
nrp LIKE '%$keyword%' OR
jurusan LIKE '%$keyword%'";
$mahasiswa = query($query);

?>

<table border="1" cellpadding="10" cellspacing="0">
    <tr>
        <th>No.</th>
        <th>Aksi</th>
        <th>Gambar</th>
        <th>NRP</th>
        <th>Nama</th>
        <th>Jurusan</th>
    </tr>
    <?php $no = 1; ?>
    <?php foreach ($mahasiswa as $m) : ?>
        <tr>
            <td><?= $no; ?></td>
            <td>
                <a href="ubah.php?id=<?= $m['id']; ?>">ubah</a>
                <a href="hapus.php?id=<?= $m['id']; ?>"
                    onclick="return confirm('Apakah anda yakin ingin menghapus data ini?')">hapus</a>
            </td>
            <td><img src="img/<?= $m['gambar']; ?>" width="50"></td>
            <td><?= $m['nrp']; ?></td>
            <td><?= $m['name']; ?></td>
            <td><?= $m['jurusan']; ?></td>
        </tr>
        <?php $no++; ?>
    <?php endforeach; ?>
</table>