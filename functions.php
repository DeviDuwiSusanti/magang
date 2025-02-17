<?php
$conn = mysqli_connect("localhost", "root", "", "magang_database");


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
    $date = date("ymd");
    $hour = date("H");
    $baseId = $date . $hour;

    // Query untuk mencari ID terakhir dengan format yang sama
    $query = "SELECT id_user FROM tb_user WHERE id_user LIKE '$baseId%' ORDER BY id_user DESC LIMIT 1";
    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $lastId = mysqli_fetch_assoc($result)['id_user'];
        $lastCounter = intval(substr($lastId, -2));
        $newCounter = $lastCounter + 1;
        $newCounter = str_pad($newCounter, 2, "0", STR_PAD_LEFT);
    } else {
        $newCounter = "01";
    }
    $newId = $baseId . $newCounter;
    return $newId;
}



function uploadImage($file, $old_img, $directory)
{
    if ($file["error"] === 4) {
        return $old_img;
    }

    $maxSize = 1 * 1024 * 1024;
    if ($file['size'] > $maxSize) {
        throw new Exception("Ukuran file melebihi 1 MB.");
    }

    $allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/jpg'];
    if (!in_array($file['type'], $allowedTypes)) {
        throw new Exception("Hanya file JPEG, PNG, atau GIF yang diizinkan.");
    }

    $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
    $randomName = uniqid() . "." . $extension;

    $uploadPath = $directory . $randomName;
    if (!move_uploaded_file($file['tmp_name'], $uploadPath)) {
        throw new Exception("Gagal mengupload file.");
    }
    return $randomName;
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
    $result = mysqli_query($conn, "SELECT nik_user FROM tb_profile_user WHERE nik_user = '$nik'");
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
    $nim = $POST["nim"];
    $gambar = uploadImage($_FILES["gambar"], "avatar.png", "assets/img/user/");

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

    $query1 = "INSERT INTO tb_user (id_user, email, level, create_by) VALUES ('$id_user', '$email', '$level', '$id_user')";
    $query2 = "INSERT INTO tb_profile_user (id_user, nama_user, nik_user, nisn, nim, jenis_kelamin, tempat_lahir, tanggal_lahir, alamat_user, gambar_user, id_pendidikan, create_by, telepone)
                        VALUES ('$id_user', '$nama', '$nik', '$nisn', '$nim', '$jenis_kelamin', '$tempat_lahir', '$tanggal_lahir', '$alamat', '$gambar', '$pendidikan', '$id_user', '$telepone')";
    mysqli_query($conn, $query1);
    mysqli_query($conn, $query2);
    return mysqli_affected_rows($conn);
}

// =========================================================== SUPER ADMIN ========================================================
// ================================ PROFILE SUPER ADMIN ================================
function edit_profile_1($POST_edit)
{
    global $conn;
    $id_user = $POST_edit["id_user"];
    $nama_user = $POST_edit["nama_user"];
    $tempat_lahir = $POST_edit["tempat_lahir"];
    $tanggal_lahir = $POST_edit["tanggal_lahir"];
    $telepone = $POST_edit["telepone"];
    $alamat_user = $POST_edit["alamat_user"];
    $jenis_kelamin = $POST_edit["jenis_kelamin"];
    $gambar_lama = $POST_edit["gambar_lama"];
    $gambar = uploadImage($_FILES["gambar"], $gambar_lama, "../assets/img/user/");

    $query = "UPDATE tb_profile_user SET 
                nama_user = '$nama_user',
                tempat_lahir = '$tempat_lahir',
                tanggal_lahir = '$tanggal_lahir',
                telepone = '$telepone',
                jenis_kelamin = '$jenis_kelamin',
                alamat_user = '$alamat_user',
                gambar_user = '$gambar',
                change_by = '$id_user'
                WHERE id_user = '$id_user'
        ";
    mysqli_query($conn, $query);
    return mysqli_affected_rows($conn);
}


// ================================ INSTANSI SUPER ADMIN =================================
function tambah_instansi($POST)
{
    global $conn;
    $id_user = $POST["id_user"];
    $id_instansi = $POST["id_instansi"];
    $nama_pendek = $POST["nama_pendek"];
    $nama_panjang = $POST["nama_panjang"];
    $group_instansi = $POST["group_instansi"];
    $alamat_instansi = $POST["alamat_instansi"];
    $deskripsi_instansi = $POST["deskripsi_instansi"];
    $lokasi_instansi = $POST["lokasi_instansi"];
    $telepone_instansi = $POST["telepone_instansi"];
    $gambar_instansi = uploadImage($_FILES["gambar_instansi"], "logo_kab_sidoarjo.png", "../assets/img/instansi/");

    $query = "INSERT INTO tb_instansi (id_instansi, nama_pendek, nama_panjang, group_instansi, alamat_instansi, lokasi_instansi, telepone_instansi, deskripsi_instansi, gambar_instansi, create_by) 
        VALUES ('$id_instansi', '$nama_pendek', '$nama_panjang', '$group_instansi', '$alamat_instansi', '$lokasi_instansi', '$telepone_instansi', '$deskripsi_instansi', '$gambar_instansi', '$id_user')";
    mysqli_query($conn, $query);
    return mysqli_affected_rows($conn);
}

function edit_instansi($POST)
{
    global $conn;
    $id_user = $POST["id_user"];
    $id_instansi = $POST["id_instansi"];
    $nama_pendek = $POST["nama_pendek"];
    $nama_panjang = $POST["nama_panjang"];
    $group_instansi = $POST["group_instansi"];
    $alamat_instansi = $POST["alamat_instansi"];
    $deskripsi_instansi = $POST["deskripsi_instansi"];
    $lokasi_instansi = $POST["lokasi_instansi"];
    $telepone_instansi = $POST["telepone_instansi"];
    $gambar_lama = $POST["gambar_instansi"];
    $gambar_instansi = uploadImage($_FILES["gambar_instansi"], $gambar_lama, "../assets/img/instansi/");

    $query = "UPDATE tb_instansi SET
                id_instansi = '$id_instansi',
                nama_pendek = '$nama_pendek',
                nama_panjang = '$nama_panjang',
                group_instansi = '$group_instansi',
                alamat_instansi = '$alamat_instansi',
                lokasi_instansi = '$lokasi_instansi',
                deskripsi_instansi = '$deskripsi_instansi',
                telepone_instansi = '$telepone_instansi',
                gambar_instansi = '$gambar_instansi',
                change_by = '$id_user'
                WHERE id_instansi = '$id_instansi' ";
    mysqli_query($conn, $query);
    return mysqli_affected_rows($conn);
}

function hapus_instansi($id_instansi, $id_user)
{
    global $conn;
    $query = "UPDATE tb_instansi SET 
                status_active = 'N',
                change_by = '$id_user'
                WHERE id_instansi = $id_instansi
                ";
    mysqli_query($conn, $query);
    return mysqli_affected_rows($conn);
}

// =============================== BIDANG ADMIN INSTANSI =================================
function tambah_bidang($POST) {
    global $conn;
    $id_user = $POST["id_user"];
    $nama_bidang = $POST["nama_bidang"];
    $deskripsi_bidang = $POST["deskripsi"];
    $kriteria = $POST["kriteria"];
    $kuota = $POST["kuota"];
    $dokumen_prasyarat = $POST["dokumen"];

    $query = "INSERT INTO tb_bidang (id_bidang, nama_bidang, deskripsi_bidang, kriteria, kuota, dokumen_prasyarat, create_by)
        VALUES ('','$nama_bidang', '$deskripsi_bidang', '$kriteria', '$kuota', '$dokumen_prasyarat', '$id_user')";
    mysqli_query($conn, $query);
    return mysqli_affected_rows($conn);
}

function edit_bidang($POST) {
    global $conn;
    $id_user = $POST["id_user"];
    $id_bidang = $POST["id_bidang"];
    $nama_bidang = $POST["nama_bidang"];
    $deskripsi = $POST["deskripsi"];
    $kriteria = $POST["kriteria"];
    $kuota = $POST["kuota"];
    $dokumen_prasyarat = $POST["dokumen"];

    $query = "UPDATE tb_bidang SET
                id_bidang = '$id_bidang',
                nama_bidang = '$nama_bidang',
                deskripsi_bidang = '$deskripsi',
                kriteria = '$kriteria',
                kuota = '$kuota',
                dokumen_prasyarat = '$dokumen_prasyarat',
                change_by = '$id_user'
                WHERE id_bidang = '$id_bidang'";
    mysqli_query($conn, $query);
    return mysqli_affected_rows($conn);
}

function hapus_bidang($id_bidang, $id_user) {
    global $conn;
    $query = "UPDATE tb_bidang SET
                status_active = 'N',
                change_by = '$id_user'
                WHERE id_bidang = '$id_bidang'";
    mysqli_query($conn, $query);
    return mysqli_affected_rows($conn);
}


