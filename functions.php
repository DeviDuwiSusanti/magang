<?php
$conn = mysqli_connect("localhost", "root", "", "db_magang");

function query($query)
{
    global $conn;
    $rows = [];
    $result = mysqli_query($conn, $query);
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }
    return $rows;
}

function generateUserId($conn)
{
    // Ambil tanggal dan jam saat ini
    $date = date("ymd"); // Format: YYMMDD
    $hour = date("H");   // Format: HH (24 jam)
    $baseId = $date . $hour;

    // Query untuk mencari ID terakhir dengan format yang sama
    $query = "SELECT id_user FROM tb_user WHERE id_user LIKE '$baseId%' ORDER BY id_user DESC LIMIT 1";
    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) > 0) {

        $lastId = mysqli_fetch_assoc($result)['id_user'];
        $lastCounter = intval(substr($lastId, -2)); // Convert ke integer
        $newCounter = $lastCounter + 1;

        // Format counter menjadi 2 digit (misal: 01, 02, ..., 10, 11)
        $newCounter = str_pad($newCounter, 2, "0", STR_PAD_LEFT);
    } else {
        $newCounter = "01";
    }
    $newId = $baseId . $newCounter;
    return $newId;
}


function uploadImage($file)
{
    // Jika file tidak diupload, kembalikan avatar default
    if ($file['error'] === 4) { // Error code 4 = No file uploaded
        return "avatar.png";
    }

    // Validasi ukuran file (max 1 MB)
    $maxSize = 1 * 1024 * 1024; // 1 MB dalam bytes
    if ($file['size'] > $maxSize) {
        throw new Exception("Ukuran file melebihi 1 MB.");
    }

    // Validasi tipe file (hanya gambar)
    $allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/jpg'];
    if (!in_array($file['type'], $allowedTypes)) {
        throw new Exception("Hanya file JPEG, PNG, atau GIF yang diizinkan.");
    }

    // Generate nama file random
    $extension = pathinfo($file['name'], PATHINFO_EXTENSION); // Ambil ekstensi file
    $randomName = uniqid() . "." . $extension; // Nama file random + ekstensi

    // Lokasi penyimpanan file
    $uploadDir = "assets/img/user/";
    $uploadPath = $uploadDir . $randomName;

    // Pindahkan file ke folder tujuan
    if (!move_uploaded_file($file['tmp_name'], $uploadPath)) {
        throw new Exception("Gagal mengupload file.");
    }

    return $randomName; // Kembalikan nama file yang diupload
}


function isEmailRegistered($conn, $email)
{
    $email = mysqli_real_escape_string($conn, $email);
    $result = mysqli_query($conn, "SELECT email FROM tb_user WHERE email = '$email'");
    return mysqli_num_rows($result) > 0;
}

function isNIKRegistered($conn, $nik)
{
    $nik = mysqli_real_escape_string($conn, $nik);
    $result = mysqli_query($conn, "SELECT nik FROM tb_profile_user WHERE nik = '$nik'");
    return mysqli_num_rows($result) > 0;
}

function isNISNRegistered($conn, $nisn)
{
    $nisn = mysqli_real_escape_string($conn, $nisn);
    $result = mysqli_query($conn, "SELECT nisn FROM tb_profile_user WHERE nisn = '$nisn'");
    return mysqli_num_rows($result) > 0;
}


function register($POST)
{
    global $conn;

    $id_user = generateUserId($conn);
    $nama = $POST["nama"];
    $email = $POST["email"];
    $nik = $POST["nik"];
    $nisn = $POST["nisn"];
    $pendidikan = $POST["pendidikan"];
    $jenis_kelamin = $POST["jenis_kelamin"];
    $tempat_lahir = $POST["tempat_lahir"];
    $tanggal_lahir = $POST["tanggal_lahir"];
    $alamat = $POST["alamat"];
    $telepone = $POST["telepone"];
    $level = $POST["level"];
    $gambar = uploadImage($_FILES["gambar"]);
    $nim = $POST["nim"];



    if (isEmailRegistered($conn, $email)) {
        header("Location: register.php?error=email_terdaftar");
        exit;
    }
    if (isNIKRegistered($conn, $nik)) {
        header("Location: register.php?error=nik_terdaftar");
        exit;
    }
    if (isNISNRegistered($conn, $nisn)) {
        header("Location: register.php?error=nisn_terdaftar");
        exit;
    }

    // Query untuk tb_user
    $query1 = "INSERT INTO tb_user (id_user, email, level, create_by) VALUES ('$id_user', '$email', '$level', '$id_user')";

    // Query untuk tb_profile_user (gunakan NULL jika NIM tidak ada)
    $query2 = "INSERT INTO tb_profile_user (id_user, nama_user, nik, nisn, nim, jenis_kelamin, tempat_lahir, tanggal_lahir, alamat_user, gambar, id_pendidikan, create_by, telepone)
                    VALUES ('$id_user', '$nama', '$nik', '$nisn', '$nim', '$jenis_kelamin', '$tempat_lahir', '$tanggal_lahir', '$alamat', '$gambar', '$pendidikan', '$id_user', '$telepone')";

    mysqli_query($conn, $query1);
    mysqli_query($conn, $query2);
    return mysqli_affected_rows($conn);
}

?>
>>>>>>> 593718b1c40eb7cb177c93c7aef827ade5d0f463