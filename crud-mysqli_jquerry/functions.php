<?php
// Koneksi ke database
$conn = mysqli_connect('localhost', 'edi', 'edi123', 'belajar_mysql');

// Function query
function query($query)
{
    global $conn;
    $result = mysqli_query($conn, $query);
    $rows = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }
    return $rows;
};

// Function tambah
function tambah($data)
{
    global $conn;
    $nrp = htmlspecialchars($data["nrp"]);
    $name = htmlspecialchars($data["name"]);
    $jurusan = htmlspecialchars($data["jurusan"]);

    // Validasi input data
    if (empty($nrp) || empty($name) || empty($jurusan)) {
        echo "<script>
                alert('Data tidak boleh ada yang kosong!');
                document.location.href = 'tambah.php';
            </script>";
        exit;
    };


    // Upload gambar
    $gambar = upload();
    if (!$gambar) {
        return false;
    }

    // Query insert
    $query = "INSERT INTO mahasiswa (nrp, name, jurusan, gambar) VALUES ('$nrp', '$name', '$jurusan', '$gambar')";
    mysqli_query($conn, $query);
    return mysqli_affected_rows($conn);
};

// Function upload file gambar
function upload()
{
    $namaFile = $_FILES['gambar']['name'];
    $ukuranFile = $_FILES['gambar']['size'];
    $error = $_FILES['gambar']['error'];
    $tmpName = $_FILES['gambar']['tmp_name'];

    // Cek apakah tidak ada gambar yang diupload
    if ($error === 4) {
        echo "<script>
                alert('Pilih gambar terlebih dahulu!');
            </script>";
        return false;
    }

    // Cek apakah yang diupload adalah gambar
    $ekstensiGambarValid = ['jpg', 'jpeg', 'png'];
    $ekstensiGambar = explode('.', $namaFile);
    $ekstensiGambar = strtolower(end($ekstensiGambar));
    if (!in_array($ekstensiGambar, $ekstensiGambarValid)) {
        echo "<script>
                alert('Yang anda upload bukan gambar!');    
            </script>";
        return false;
    }

    // Cek jika ukurannya terlalu besar
    if ($ukuranFile > 1000000) {
        echo "<script>        
                alert('Ukuran gambar terlalu besar!');
            </script>";
        return false;
    }

    // Lolos pengecekan, gambar siap diupload
    // Generate nama gambar baru
    $namaFileBaru = uniqid();
    $namaFileBaru .= '.';
    $namaFileBaru .= $ekstensiGambar;

    // Upload gambar        
    move_uploaded_file($tmpName, 'img/' . $namaFileBaru);
    return $namaFileBaru;
}



// Function hapus
function hapus($id)
{
    global $conn;
    mysqli_query($conn, "DELETE FROM mahasiswa WHERE id = $id");
    return mysqli_affected_rows($conn);
};

// Function ubah
function ubah($data)
{
    global $conn;
    $id = $data["id"];
    $nrp = htmlspecialchars($data["nrp"]);
    $name = htmlspecialchars($data["name"]);
    $jurusan = htmlspecialchars($data["jurusan"]);
    $gambarLama = htmlspecialchars($data["gambarLama"]);

    // Cek apakah user pilih gambar baru atau tidak
    if ($_FILES['gambar']['error'] === 4) {
        $gambar = $gambarLama;
    } else {
        $gambar = upload();
    }


    $query = "UPDATE mahasiswa SET nrp = '$nrp', name = '$name', jurusan = '$jurusan', gambar = '$gambar' WHERE id = $id";
    mysqli_query($conn, $query);
    return mysqli_affected_rows($conn);
}

// Function cari
function cari($keyword)
{
    $query = "SELECT * FROM mahasiswa WHERE name LIKE '%$keyword%' OR nrp LIKE '%$keyword%' OR jurusan LIKE '%$keyword%'";
    return query($query);
}

// Function registrasi
function registrasi($data)
{
    global $conn;
    $username = strtolower(stripslashes($data["username"]));
    $password = mysqli_real_escape_string($conn, $data["password"]);
    $password2 = mysqli_real_escape_string($conn, $data["password2"]);

    // Cek username sudah ada atau belum
    $result = mysqli_query($conn, "SELECT username FROM users WHERE username = '$username'");
    if (mysqli_fetch_assoc($result)) {
        echo "<script>
                alert('username sudah terdaftar!');
            </script>";
        return false;
    }

    // Cek konfirmasi password
    if ($password !== $password2) {
        echo "<script>
                alert('konfirmasi password tidak sesuai!');
            </script>";
        return false;
    }

    // Enkripsi password
    $password = password_hash($password, PASSWORD_DEFAULT);

    // Tambahkan userbaru ke database
    mysqli_query($conn, "INSERT INTO users (username, password) VALUES('$username', '$password')");
    return mysqli_affected_rows($conn);
}