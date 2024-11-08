<?php
session_start();
require 'functions.php';
if (!isset($_SESSION['login'])) {
    header("Location: login.php");
    exit;
}
// Ambil data dari table mahasiswa
$mahasiswa = query('SELECT * FROM mahasiswa ');

// Ketika tombol cari ditekan
if (isset($_POST["cari"])) {
    $mahasiswa = cari($_POST["keyword"]);
}

// Ambil data mahasiswa dari object result
// mysqli_fetch_row() // Mengembalikan array numerik
// $mhs = mysqli_fetch_row($result);
// var_dump($mhs);


// mysqli_fetch_array() // Mengembalikan array numerik dan associative
// $mhs = mysqli_fetch_array($result);
// var_dump($mhs);

// mysqli_fetch_object() // Mengembalikan object
// $mhs = mysqli_fetch_object($result);
// var_dump($mhs);

// mysqli_fetch_assoc() // Mengembalikan array associative
// $mhs = mysqli_fetch_all($result, MYSQLI_ASSOC);
// var_dump($mhs);

// mysqli_fetch_assoc() // Mengembalikan array associative
// $mhs = mysqli_fetch_assoc($result);
// var_dump($mhs);

// while ($mhs = mysqli_fetch_assoc($result)) {
//     var_dump($mhs);
// };

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Belajar mysql</title>
    <style>
        .loader {
            width: 100px;
            position: absolute;
            top: 120px;
            left: 330px;
            z-index: -1;
            display: none;
        }
    </style>
</head>

<body>
    <a href="logout.php">Logout</a> | <a href="cetak.php" target="_blank">Cetak</a>
    <h1>Daftar Mahasiswa</h1>
    <a href="tambah.php">Tamabah data mahasiswa</a>
    <br><br>

    <form action="" method="post">
        <input type="text" name="keyword" size="40" autofocus="Masukkan keyword pencarian..." autocomplete="off"
            id="keyword">
        <button type="submit" name="cari" id="tombol-cari">Cari</button>

        <img src="img/loader.gif" class="loader">
    </form>
    <br> <br>

    <div id="container">
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
    </div>

    <script src="js/jquery-3.7.1.min.js"></script>
    <script src="js/script.js"></script>
</body>


</html>