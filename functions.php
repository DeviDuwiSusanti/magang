<?php

use Dom\Mysql;

include "koneksi.php";

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
    $baseId = date("ymdH");
    $query = "SELECT id_user FROM tb_user WHERE LEFT(id_user, 8) = '$baseId' ORDER BY id_user DESC LIMIT 1";
    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $lastId = mysqli_fetch_assoc($result)['id_user'];
        // Ambil counter 2 digit setelah baseId (posisi ke-9 dan 10)
        $lastCounter = intval(substr($lastId, 8, 2));
        $newCounter = str_pad($lastCounter + 1, 2, "0", STR_PAD_LEFT);
    } else {
        $newCounter = "01";
    }

    $newId = $baseId . $newCounter . "00"; // Tambah 00 di akhir
    return $newId;
}



function generate_user_id_level_1_2($conn)
{
    $baseId = date("ymdH");
    $query = "SELECT id_user FROM tb_user WHERE LEFT(id_user, 8) = '$baseId' ORDER BY id_user DESC LIMIT 1";
    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $lastId = mysqli_fetch_assoc($result)['id_user'];
        $lastCounter = intval(substr($lastId, 8, 2)); // Ambil 2 digit setelah 8
        $newCounter = str_pad($lastCounter + 1, 2, "0", STR_PAD_LEFT);
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
        throw new Exception("Hanya file JPEG, JPG, PNG, atau GIF yang diizinkan.");
    }

    $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
    $randomName = uniqid() . "." . $extension;
    $uploadPath = $directory . $randomName;

    if (!move_uploaded_file($file['tmp_name'], $uploadPath)) {
        throw new Exception("Gagal mengupload file.");
    }
    return $randomName;
}


function checking($conn, $table, $column, $value)
{
    $column = mysqli_real_escape_string($conn, $column);
    $value = mysqli_real_escape_string($conn, $value);
    $query = "SELECT $column FROM $table WHERE $column = '$value'";
    $result = mysqli_query($conn, $query);
    return mysqli_num_rows($result) > 0;
}



function register($POST)
{
    global $conn;

    $id_user = generateUserId($conn);
    $nama = $POST["nama_user"];
    $email = $POST["email"];
    $nik = $POST["nik"];
    $pendidikan = $POST["id_pendidikan"];
    $jenis_kelamin = $POST["jenis_kelamin"];
    $tempat_lahir = $POST["tempat_lahir"];
    $tanggal_lahir = $POST["tanggal_lahir"];
    $alamat = $POST["alamat_user"];
    $telepone = $POST["telepone_user"];
    $level = $POST["level"];
    $gambar = uploadImage($_FILES["gambar_user"], "avatar.png", "assets/img/user/");

    if (strlen($pendidikan) === 7) {
        $nim = $POST['nim'];
        $nisn = NULL;
    } else {
        $nisn = $POST['nisn'];
        $nim = NULL;
    }
    // Cek email
    $check_email = mysqli_query($conn, "SELECT id_user FROM tb_user WHERE email = '$email'");

    if (mysqli_num_rows($check_email) > 0) {
        $existing = mysqli_fetch_assoc($check_email);
        $existing_id_user = $existing['id_user'];

        // Jika anggota ingin mendaftar ulang
        if (!isKetua($existing_id_user)) {
            header("Location: register.php?confirm=gunakan_data_lama&id_user_lama=$existing_id_user");
            exit;
        } else {
            header("Location: register.php?error=email_terdaftar");
            exit;
        }
    }

    // Validasi duplikat NIK dan NISN
    if (checking($conn, 'tb_profile_user', 'nik', $nik)) {
        header("Location: register.php?error=nik_terdaftar");
        exit;
    }
    if (!empty($nisn) && checking($conn, 'tb_profile_user', 'nisn', $nisn)) {
        header("Location: register.php?error=nisn_terdaftar");
        exit;
    }

    // Simpan data user baru
    $query_user = mysqli_query($conn, "INSERT INTO tb_user (id_user, email, level, create_by) VALUES ('$id_user', '$email', '$level', '$id_user')");
    $query_profile = mysqli_query($conn, "INSERT INTO tb_profile_user (id_user, nama_user, nik, nisn, nim, jenis_kelamin, tempat_lahir, tanggal_lahir, alamat_user, gambar_user, id_pendidikan, create_by, telepone_user)
        VALUES ('$id_user', '$nama', '$nik', '$nisn', '$nim', '$jenis_kelamin', '$tempat_lahir', '$tanggal_lahir', '$alamat', '$gambar', '$pendidikan', '$id_user', '$telepone')");

    return ($query_user && $query_profile) ? mysqli_affected_rows($conn) : 0;
}

function isKetua($id_user)
{
    return substr($id_user, -2) === "00";
}





// =========================================================== SUPER ADMIN LEVEL (1) ========================================================

function generateIdPendidikan_universitas($nama_pendidikan, $fakultas, $jurusan)
{
    global $conn;

    // 1. Cek apakah kombinasi sudah ada (untuk universitas saja)
    $query = "SELECT id_pendidikan, status_active FROM tb_pendidikan 
              WHERE nama_pendidikan = '$nama_pendidikan' 
              AND fakultas = '$fakultas' 
              AND jurusan = '$jurusan'
              AND LENGTH(id_pendidikan) = 7";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        return ($row["status_active"] == 0) ? 0 : 1;
    }

    // 2. Tentukan kode nama_pendidikan (3 digit pertama) khusus untuk universitas
    $query_nama = "SELECT DISTINCT LEFT(id_pendidikan, 3) as kode 
                   FROM tb_pendidikan 
                   WHERE nama_pendidikan = '$nama_pendidikan' 
                   AND LENGTH(id_pendidikan) = 7 
                   LIMIT 1";
    $result_nama = mysqli_query($conn, $query_nama);

    if (mysqli_num_rows($result_nama) > 0) {
        // Sudah ada universitas dengan nama ini → pakai kode yang sama
        $row = mysqli_fetch_assoc($result_nama);
        $kode_nama = $row['kode'];
    } else {
        // Cari kode baru khusus universitas (abaikan sekolah)
        $query_used = "SELECT DISTINCT LEFT(id_pendidikan, 3) as kode 
                       FROM tb_pendidikan 
                       WHERE LENGTH(id_pendidikan) = 7";
        $result_used = mysqli_query($conn, $query_used);

        $used_kode_set = [];
        while ($row = mysqli_fetch_assoc($result_used)) {
            $used_kode_set[] = $row['kode'];
        }

        // Cari kode 001–999 yang belum dipakai
        for ($i = 1; $i <= 999; $i++) {
            $kode_coba = str_pad($i, 3, '0', STR_PAD_LEFT);
            if (!in_array($kode_coba, $used_kode_set)) {
                $kode_nama = $kode_coba;
                break;
            }
        }

        if (!isset($kode_nama)) {
            $kode_nama = '999'; // fallback terakhir
        }
    }

    // 3. Tentukan kode fakultas (2 digit)
    $query_fakultas = "SELECT DISTINCT SUBSTRING(id_pendidikan, 4, 2) as kode 
                       FROM tb_pendidikan 
                       WHERE LEFT(id_pendidikan, 3) = '$kode_nama' 
                       AND fakultas = '$fakultas'
                       AND LENGTH(id_pendidikan) = 7
                       LIMIT 1";
    $result_fakultas = mysqli_query($conn, $query_fakultas);

    if (mysqli_num_rows($result_fakultas) > 0) {
        $row_fak = mysqli_fetch_assoc($result_fakultas);
        $kode_fakultas = $row_fak['kode'];
    } else {
        $query_max_fak = "SELECT MAX(CAST(SUBSTRING(id_pendidikan, 4, 2) AS UNSIGNED)) as max_kode 
                          FROM tb_pendidikan 
                          WHERE LEFT(id_pendidikan, 3) = '$kode_nama'
                          AND LENGTH(id_pendidikan) = 7";
        $result_max_fak = mysqli_query($conn, $query_max_fak);
        $row_max_fak = mysqli_fetch_assoc($result_max_fak);
        $next_kode_fak = ($row_max_fak['max_kode'] ?? 0) + 1;
        $kode_fakultas = str_pad($next_kode_fak, 2, '0', STR_PAD_LEFT);
    }

    // 4. Tentukan kode jurusan (2 digit terakhir)
    $query_jurusan = "SELECT MAX(CAST(RIGHT(id_pendidikan, 2) AS UNSIGNED)) as max_kode 
                      FROM tb_pendidikan 
                      WHERE LEFT(id_pendidikan, 5) = '$kode_nama$kode_fakultas'
                      AND LENGTH(id_pendidikan) = 7";
    $result_jurusan = mysqli_query($conn, $query_jurusan);
    $row_jurusan = mysqli_fetch_assoc($result_jurusan);
    $next_kode_jur = ($row_jurusan['max_kode'] ?? 0) + 1;
    $kode_jurusan = str_pad($next_kode_jur, 2, '0', STR_PAD_LEFT);

    return $kode_nama . $kode_fakultas . $kode_jurusan;
}



function generateIdPendidikan_sekolah($nama_pendidikan, $jurusan)
{
    global $conn;

    $query_check = "SELECT id_pendidikan, status_active FROM tb_pendidikan 
                    WHERE nama_pendidikan = '$nama_pendidikan' 
                    AND jurusan = '$jurusan' 
                    AND fakultas IS NULL 
                    AND LENGTH(id_pendidikan) = 5";
    $result_check = mysqli_query($conn, $query_check);
    if (mysqli_num_rows($result_check) > 0) {
        $row = mysqli_fetch_assoc($result_check);
        if ($row["status_active"] == 0) {
            return 0;
        } else {
            return 1;
        }
    }

    // 2. Cek apakah nama_pendidikan sudah pernah ada
    $query_nama = "SELECT LEFT(id_pendidikan, 3) as kode 
                    FROM tb_pendidikan 
                    WHERE nama_pendidikan = '$nama_pendidikan' 
                    AND LENGTH(id_pendidikan) = 5 
                    LIMIT 1";
    $result_nama = mysqli_query($conn, $query_nama);

    if (mysqli_num_rows($result_nama) > 0) {
        $kode_nama = mysqli_fetch_assoc($result_nama)['kode'];
    } else {
        $query_max = "SELECT MAX(CAST(LEFT(id_pendidikan, 3) AS UNSIGNED)) as max_kode 
                        FROM tb_pendidikan 
                        WHERE LENGTH(id_pendidikan) = 5";
        $result_max = mysqli_query($conn, $query_max);
        $row_max = mysqli_fetch_assoc($result_max);
        $next_kode = ($row_max['max_kode'] ?? 0) + 1;
        $kode_nama = str_pad($next_kode, 3, '0', STR_PAD_LEFT);
    }

    // 3. Cari kode jurusan terakhir
    $query_jurusan = "SELECT MAX(CAST(RIGHT(id_pendidikan, 2) AS UNSIGNED)) as max_kode 
                        FROM tb_pendidikan 
                        WHERE LEFT(id_pendidikan, 3) = '$kode_nama' 
                        AND LENGTH(id_pendidikan) = 5";
    $result_jurusan = mysqli_query($conn, $query_jurusan);
    $row_jurusan = mysqli_fetch_assoc($result_jurusan);
    $next_kode_jur = ($row_jurusan['max_kode'] ?? 0) + 1;
    $kode_jurusan = str_pad($next_kode_jur, 2, '0', STR_PAD_LEFT);

    $new_id = $kode_nama . $kode_jurusan;
    return $new_id;
}



function tambah_data_sekolah($POST)
{
    global $conn;
    $id_user = $POST["id_user"];
    $alamat_pendidikan = $POST["alamat_pendidikan"];
    $nama_sekolah = $POST["nama_sekolah_hidden"];
    $jurusan_sekolah = $POST["jurusan_sekolah_hidden"];
    $id_pendidikan = generateIdPendidikan_sekolah($nama_sekolah, $jurusan_sekolah);
    if ($id_pendidikan == 0) {
        return 404;
    }
    if ($id_pendidikan == 1) {
        return 405;
    }

    $query = "INSERT INTO tb_pendidikan (id_pendidikan, nama_pendidikan, fakultas, jurusan, alamat_pendidikan, create_by) VALUES ('$id_pendidikan', '$nama_sekolah', NULL, '$jurusan_sekolah', '$alamat_pendidikan', '$id_user')";
    if (mysqli_query($conn, $query)) {
        return mysqli_affected_rows($conn);
    } else {
        return 0;
    }
}



function tambah_data_universitas($POST)
{
    global $conn;
    $id_user = $POST["id_user"];
    $nama_universitas = $POST["nama_universitas_hidden"];
    $fakultas_universitas = $POST["fakultas_universitas_hidden"];
    $jurusan_universitas = $POST["jurusan_universitas_hidden"];
    $alamat_pendidikan = $POST["alamat_pendidikan"];
    $id_pendidikan = generateIdPendidikan_universitas($nama_universitas, $fakultas_universitas, $jurusan_universitas);
    if ($id_pendidikan == 0) {
        return 404;
    }
    if ($id_pendidikan == 1) {
        return 405;
    }

    $query = "INSERT INTO tb_pendidikan (id_pendidikan, nama_pendidikan, fakultas, jurusan, alamat_pendidikan, create_by) VALUES ('$id_pendidikan', '$nama_universitas', '$fakultas_universitas', '$jurusan_universitas', '$alamat_pendidikan', '$id_user')";
    if (mysqli_query($conn, $query)) {
        return mysqli_affected_rows($conn);
    } else {
        return 0;
    }
}


function hapus_pendidikan_super_admin($id_pendidikan, $id_user)
{
    global $conn;
    $query = mysqli_query($conn, "UPDATE tb_pendidikan SET status_active = '0', change_by = '$id_user' WHERE id_pendidikan = '$id_pendidikan'");
    if ($query) {
        return mysqli_affected_rows($conn);
    } else {
        return 0;
    }
}



function edit_pendidikan($POST)
{
    global $conn;
    $id_pendidikan = mysqli_real_escape_string($conn, $POST["id_pendidikan"]);
    $id_user = mysqli_real_escape_string($conn, $POST["id_user"]);
    $nama_pendidikan = mysqli_real_escape_string($conn, $POST["nama_pendidikan"]);
    $fakultas_edit = trim($POST["fakultas"]);
    $jurusan = mysqli_real_escape_string($conn, $POST["jurusan"]);
    $alamat_pendidikan = mysqli_real_escape_string($conn, $POST["alamat_pendidikan"]);

    if ($fakultas_edit === "") {
        $fakultas_sql = "NULL";
    } else {
        $fakultas_sql = "'" . mysqli_real_escape_string($conn, $fakultas_edit) . "'";
    }

    $query = mysqli_query($conn, "UPDATE tb_pendidikan 
        SET nama_pendidikan = '$nama_pendidikan', 
            fakultas = $fakultas_sql, 
            jurusan = '$jurusan', 
            alamat_pendidikan = '$alamat_pendidikan', 
            change_by = '$id_user' 
        WHERE id_pendidikan = '$id_pendidikan'");

    if ($query) {
        return mysqli_affected_rows($conn);
    } else {
        return 0;
    }
}

// ============================== END OF PENDIDIKAN IN SUPER ADMIN ================================






// ================================ INSTANSI SUPER ADMIN =================================
function uploadGambarInstansi($file, $old_img, $directory, $id_instansi)
{
    if ($file["error"] === 4) {
        return $old_img;
    }

    $maxSize = 1 * 1024 * 1024; // 1 MB
    if ($file['size'] > $maxSize) {
        throw new Exception("Ukuran file melebihi 1 MB.");
    }

    $allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/jpg'];
    if (!in_array($file['type'], $allowedTypes)) {
        throw new Exception("Hanya file JPEG, JPG, PNG, atau GIF yang diizinkan.");
    }

    $extension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
    $newFileName = $id_instansi . "_" . uniqid() . "." . $extension;

    $uploadPath = $directory . $newFileName;

    if ($old_img && $old_img !== '' && file_exists($old_img)) {
        unlink($old_img);
    }

    if (!move_uploaded_file($file['tmp_name'], $uploadPath)) {
        throw new Exception("Gagal mengupload file.");
    }

    return $newFileName;
}


function tambah_instansi_super_admin($POST)
{
    global $conn;
    $id_user = mysqli_real_escape_string($conn, $POST["id_user"]);
    $id_instansi = mysqli_real_escape_string($conn, $POST["id_instansi"]);
    $nama_pendek = mysqli_real_escape_string($conn, $POST["nama_pendek"]);
    $nama_panjang = mysqli_real_escape_string($conn, $POST["nama_panjang"]);
    $group_instansi = mysqli_real_escape_string($conn, $POST["group_instansi"]);
    $alamat_instansi = mysqli_real_escape_string($conn, $POST["alamat_instansi"]);
    $deskripsi_instansi = mysqli_real_escape_string($conn, $POST["deskripsi_instansi"]);
    $lokasi_instansi = mysqli_real_escape_string($conn, $POST["lokasi_instansi"]);
    $telepone_instansi = mysqli_real_escape_string($conn, $POST["telepone_instansi"]);
    $website_resmi_instansi = mysqli_real_escape_string($conn, $POST["website_resmi_instansi"]);
    $gambar_instansi = uploadImage($_FILES["gambar_instansi"], "logo_kab_sidoarjo.png", "../assets/img/instansi/");

    if (checking($conn, 'tb_instansi', 'id_instansi', $id_instansi)) {
        return 404;
    }

    $query = "INSERT INTO tb_instansi (id_instansi, nama_pendek, nama_panjang, group_instansi, alamat_instansi, lokasi_instansi, telepone_instansi, deskripsi_instansi, gambar_instansi, website_resmi_instansi, create_by) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, 'sssssssssss', $id_instansi, $nama_pendek, $nama_panjang, $group_instansi, $alamat_instansi, $lokasi_instansi, $telepone_instansi, $deskripsi_instansi, $gambar_instansi, $website_resmi_instansi, $id_user);

    if (mysqli_stmt_execute($stmt)) {
        return mysqli_stmt_affected_rows($stmt);
    } else {
        error_log("Error: " . mysqli_error($conn));
        return 0;
    }
}


function hapus_instansi($id_instansi, $id_user)
{
    global $conn;
    $query = "UPDATE tb_instansi SET 
                    status_active = '0',
                    change_by = '$id_user'
                    WHERE id_instansi = $id_instansi
                    ";
    if (mysqli_query($conn, $query)) {
        return mysqli_affected_rows($conn);
    } else {
        return 0;
    }
}

function edit_instansi_super_admin($POST)
{
    global $conn;
    $id_user = mysqli_real_escape_string($conn, $POST["id_user"]);
    $id_instansi = mysqli_real_escape_string($conn, $POST["id_instansi"]);
    $nama_pendek = mysqli_real_escape_string($conn, $POST["nama_pendek"]);
    $nama_panjang = mysqli_real_escape_string($conn, $POST["nama_panjang"]);
    $group_instansi = mysqli_real_escape_string($conn, $POST["group_instansi"]);
    $alamat_instansi = mysqli_real_escape_string($conn, $POST["alamat_instansi"]);
    $deskripsi_instansi = mysqli_real_escape_string($conn, $POST["deskripsi_instansi"]);
    $lokasi_instansi = mysqli_real_escape_string($conn, $POST["lokasi_instansi"]);
    $telepone_instansi = mysqli_real_escape_string($conn, $POST["telepone_instansi"]);
    $gambar_lama = mysqli_real_escape_string($conn, $POST["gambar_instansi_lama"]);
    $website_resmi_instansi = mysqli_real_escape_string($conn, $POST["website_resmi_instansi"]);


    // Upload gambar baru dengan id_instansi sebagai prefix
    try {
        $gambar_instansi = uploadGambarInstansi($_FILES["gambar_instansi"], $gambar_lama, "../assets/img/instansi/", $id_instansi);
    } catch (Exception $e) {
        error_log("Upload Error: " . $e->getMessage());
        return -1;
    }

    $query = "UPDATE tb_instansi SET
                nama_pendek = ?,
                nama_panjang = ?,
                group_instansi = ?,
                alamat_instansi = ?,
                lokasi_instansi = ?,
                deskripsi_instansi = ?,
                telepone_instansi = ?,
                gambar_instansi = ?,
                website_resmi_instansi = ?,
                change_by = ?
                WHERE id_instansi = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, 'ssssssssssi', $nama_pendek, $nama_panjang, $group_instansi, $alamat_instansi, $lokasi_instansi, $deskripsi_instansi, $telepone_instansi, $gambar_instansi, $website_resmi_instansi, $id_user, $id_instansi);

    if (mysqli_stmt_execute($stmt)) {
        return mysqli_stmt_affected_rows($stmt);
    } else {
        error_log("Error: " . mysqli_error($conn));
        return 0;
    }
}
// =========================================== END OF INSTANSI IN SUPER ADMIN ==============================




// ======================================= GENERATE ADMIN INSTANSI AND PENGAJUAN =====================================
function generate_admin_instansi($POST)
{
    global $conn;
    $id_super_admin = $POST["id_super_admin"];
    $id_user = $POST["id_user"];
    $id_instansi = $POST["id_instansi"];
    $query_profile = mysqli_query($conn, "UPDATE tb_profile_user SET id_instansi = '$id_instansi', change_by = '$id_super_admin' WHERE id_user = '$id_user'");
    if ($query_profile) {
        return mysqli_affected_rows($conn);
    } else {
        return 0;
    }
}


function hapus_pengajuan_by_super_admin($id_pengajuan, $change_by)
{
    global $conn;
    $query = mysqli_query($conn, "UPDATE tb_pengajuan SET status_active = '0', change_by = '$change_by' WHERE id_pengajuan = '$id_pengajuan'");
    if ($query) {
        return mysqli_affected_rows($conn);
    } else {
        return 0;
    }
}
// ============================== END OF GENERATE ADMIN INSTASNI IN SUPER ADMIN =========================




// ============================== START OF CRUD USER IN SUPER ADMIN ==============================================
function tambah_user_by_super_admin($POST)
{
    global $conn;
    $create_by = $POST["id_user"];
    $id_user = generate_user_id_level_1_2($conn);
    $nama_user = $POST["nama_user"];
    $nik = $POST["nik"];
    $nip = $POST["nip"];
    $gender = $POST["jenis_kelamin"];
    $email = $POST["email"];
    $level = $POST["level"];
    $tempat_lahir = $POST["tempat_lahir"];
    $tanggal_lahir = $POST["tanggal_lahir"];
    $telepone_user = $POST["telepone_user"];
    $alamat_user = $POST["alamat_user"];
    $gambar_user = uploadImage($_FILES["gambar_user"], "avatar.png", "../assets/img/user/");

    if (checking($conn, 'tb_user', 'email', $email)) {
        return 404;
    }
    if (checking($conn, 'tb_profile_user', 'nik', $nik)) {
        return 405;
    }
    if (checking($conn, 'tb_profile_user', 'nip', $nip)) {
        return 406;
    }

    $query_user = mysqli_query($conn, "INSERT INTO tb_user(id_user, email, level, create_by) VALUES ('$id_user', '$email', '$level', '$create_by') ");
    $query_profile = mysqli_query($conn, "INSERT INTO tb_profile_user(id_user, nama_user, nik, nip, jenis_kelamin, tempat_lahir, tanggal_lahir, alamat_user, telepone_user, gambar_user, create_by) 
                            VALUES ('$id_user', '$nama_user', '$nik', '$nip', '$gender', '$tempat_lahir', '$tanggal_lahir', '$alamat_user', '$telepone_user', '$gambar_user', '$create_by')");
    if ($query_user && $query_profile) {
        return mysqli_affected_rows($conn);
    } else {
        return 0;
    }
}



function super_admin_edit($POST)
{
    global $conn;

    $id_user = mysqli_real_escape_string($conn, $POST["id_user"]);
    $nama_user = mysqli_real_escape_string($conn, $POST["nama_user"]);
    $tanggal_lahir = mysqli_real_escape_string($conn, $POST["tanggal_lahir"]);
    $tempat_lahir = mysqli_real_escape_string($conn, $POST["tempat_lahir"]);
    $telepone_user = mysqli_real_escape_string($conn, $POST["telepone_user"]);
    $alamat_user = mysqli_real_escape_string($conn, $POST["alamat_user"]);
    $jenis_kelamin = mysqli_real_escape_string($conn, $POST["jenis_kelamin"]);
    $gambar_lama = mysqli_real_escape_string($conn, $POST["gambar_lama"]);
    $nik = mysqli_real_escape_string($conn, $POST["nik"]);
    $nip = mysqli_real_escape_string($conn, $POST["nip"]);

    // Upload gambar
    $gambar_user = uploadImage($_FILES["gambar_user"], $gambar_lama, "../assets/img/user/");

    // Update data
    $query = mysqli_query($conn, "UPDATE tb_profile_user SET
                            nama_user = '$nama_user',
                            jenis_kelamin = '$jenis_kelamin',
                            tempat_lahir = '$tempat_lahir',
                            tanggal_lahir = '$tanggal_lahir',
                            alamat_user = '$alamat_user',
                            telepone_user = '$telepone_user',
                            nik = '$nik',
                            nip = '$nip',
                            gambar_user = '$gambar_user'
                            WHERE id_user = '$id_user'");

    if ($query) {
        return mysqli_affected_rows($conn);
    } else {
        return 0;
    }
}



function hapus_user_super_admin($id_user, $change_by)
{
    global $conn;
    $query_user = mysqli_query($conn, "UPDATE tb_user SET status_active = '0', change_by = '$change_by' WHERE id_user = '$id_user'");
    $query_profile = mysqli_query($conn, "UPDATE tb_profile_user SET status_active = '0', change_by = '$change_by' WHERE id_user = '$id_user'");
    if ($query_user && $query_profile) {
        return mysqli_affected_rows($conn);
    } else {
        return 0;
    }
}
// ====================================== END OF CRUD USER IN SUPER ADMIN ===================================




// =================================== START SETTING  =================================
function edit_email_user($POST)
{
    global $conn;
    $email_baru = mysqli_real_escape_string($conn, $POST["email_baru"]); // Hindari SQL injection
    $id_user = mysqli_real_escape_string($conn, $POST["id_user"]); // Hindari SQL injection

    if (checking($conn, 'tb_user', 'email', $email_baru)) {
        return 404;
    }
    $query = "UPDATE tb_user SET email = '$email_baru', change_by = '$id_user' WHERE id_user = '$id_user'";
    if (mysqli_query($conn, $query)) {
        return mysqli_affected_rows($conn);
    } else {
        return 0;
    }
}

function generate_super_admin($POST)
{
    global $conn;
    $change_by = $POST["change_by"];
    $calon = $POST["calon"];

    $query = "UPDATE tb_user SET level = '1', change_by = '$change_by' WHERE id_user = '$calon'";
    if (mysqli_query($conn, $query)) {
        return mysqli_affected_rows($conn);
    } else {
        return 0;
    }
}
// ============================ END OF SETTINGS IN SUPER ADMIN =================================
// ====================================== END OF SUPER ADMIN LEVEL (1) ============================================================














// ========================================= ADMIN INSTANSI LEVEL(2) ================================================

// =============================== BIDANG ADMIN INSTANSI =================================
function to_nullable($value)
{
    return !empty($value) ? "'" . mysqli_real_escape_string($GLOBALS['conn'], $value) . "'" : 'NULL';
}

function generateIdBidang($conn, $id_instansi)
{
    $query_bidang = "SELECT id_bidang FROM tb_bidang WHERE id_bidang LIKE '$id_instansi%' ORDER BY id_bidang DESC LIMIT 1";
    $result_bidang = mysqli_query($conn, $query_bidang);
    $row_bidang = mysqli_fetch_assoc($result_bidang);

    if ($row_bidang) {
        $last_counter = intval(substr($row_bidang['id_bidang'], -3));
        $new_counter = $last_counter + 1;
    } else {
        $new_counter = 1;
    }

    // Format nomor urut menjadi 3 digit (001, 002, 003, ...)
    $nomorUrut = str_pad($new_counter, 3, "0", STR_PAD_LEFT);

    return $id_instansi . $nomorUrut;
}

function generateIdPembimbing($conn, $id_bidang)
{
    $query_pembimbing = "SELECT id_user FROM tb_profile_user WHERE id_user LIKE '$id_bidang%' ORDER BY id_user DESC LIMIT 1";
    $result_pembimbing = mysqli_query($conn, $query_pembimbing);
    $row_pembimbing = mysqli_fetch_assoc($result_pembimbing);

    if ($row_pembimbing) {
        $last_counter = intval(substr($row_pembimbing['id_user'], -2));
        $new_counter = $last_counter + 1;
    } else {
        $new_counter = 1;
    }

    // Format nomor urut menjadi dua digit (01, 02, 03, ...)
    $nomorUrut = str_pad($new_counter, 2, "0", STR_PAD_LEFT);

    return $id_bidang . $nomorUrut;
}

function rekam_ulang_bidang($conn, $postData, $id_user_editor)
{
    // Ambil id_bidang_lama dari POST
    $id_bidang_lama = $postData['id_bidang'] ?? null;

    if (!$id_bidang_lama) {
        return ['status' => 'error', 'message' => 'ID Bidang tidak ditemukan'];
    }

    // 1. Ambil data bidang lama untuk ambil instansi
    $query = "SELECT * FROM tb_bidang WHERE id_bidang = '$id_bidang_lama'";
    $result = mysqli_query($conn, $query);

    if (!$row = mysqli_fetch_assoc($result)) {
        return ['status' => 'error', 'message' => 'Bidang tidak ditemukan'];
    }

    // 2. Dapatkan ID Instansi dari ID Bidang Lama
    $id_instansi = substr($id_bidang_lama, 0, strlen($id_bidang_lama) - 3); // INST001 → INST

    // 3. Generate ID Bidang Baru
    $id_bidang_baru = generateIdBidang($conn, $id_instansi);

    // 4. Ambil data dari $_POST untuk di-insert
    $nama_bidang = mysqli_real_escape_string($conn, $postData['nama_bidang']);
    $nama_pejabat = to_nullable($postData['edit_nama_pejabat']);
    $pangkat = to_nullable($postData['edit_pangkat']);
    $nip = to_nullable($postData['edit_nip']);
    $deskripsi_bidang = mysqli_real_escape_string($conn, $postData['deskripsi']);
    $kriteria_bidang = mysqli_real_escape_string($conn, $postData['kriteria']);
    $kuota_bidang = mysqli_real_escape_string($conn, $postData['kuota']);
    $id_instansi = mysqli_real_escape_string($conn, $postData['edit_id_instansi']);
    $dokumen_persyaratan = mysqli_real_escape_string($conn, $postData['dokumen']);

    // 5. Insert Ulang Bidang dengan data dari form + status_active = 1
    $insert_query = "INSERT INTO tb_bidang (
                        id_bidang, nama_bidang, nama_pejabat, pangkat_pejabat, nip_pejabat, deskripsi_bidang, kriteria_bidang,
                        kuota_bidang, id_instansi, dokumen_persyaratan, change_by, change_date, status_active
                    ) VALUES (
                        '$id_bidang_baru',
                        '$nama_bidang',
                        $nama_pejabat,
                        $pangkat,
                        $nip,
                        '$deskripsi_bidang',
                        '$kriteria_bidang',
                        '$kuota_bidang',
                        '$id_instansi',
                        '$dokumen_persyaratan',
                        '$id_user_editor',
                        NOW(),
                        1
                    )";

    if (!mysqli_query($conn, $insert_query)) {
        return ['status' => 'error', 'message' => 'Gagal insert bidang baru: ' . mysqli_error($conn)];
    }

    // 6. Update tb_pengajuan agar menggunakan id_bidang_baru jika masih pakai id_bidang_lama
    $update_pengajuan = "UPDATE tb_pengajuan SET 
                        id_bidang = '$id_bidang_baru'
                      WHERE id_bidang = '$id_bidang_lama'";
    if (!mysqli_query($conn, $update_pengajuan)) {
        return ['status' => 'warning', 'message' => 'Bidang baru dibuat, tapi gagal update referensi di tb_pengajuan'];
    }

    // 7. Ambil semua pembimbing lama
    $pembimbing_query = "SELECT * FROM tb_profile_user WHERE id_bidang = '$id_bidang_lama'";
    $pembimbing_result = mysqli_query($conn, $pembimbing_query);

    while ($pembimbing = mysqli_fetch_assoc($pembimbing_result)) {
        // Generate ID Pembimbing Baru berdasarkan id_bidang_baru
        $id_pembimbing_baru = generateIdPembimbing($conn, $id_bidang_baru);

        // Update tb_profile_user
        $update_profile = "UPDATE tb_profile_user SET 
                            id_user = '$id_pembimbing_baru',
                            id_bidang = '$id_bidang_baru'
                            WHERE id_user = '" . $pembimbing['id_user'] . "' AND status_active = 1";
        if (!mysqli_query($conn, $update_profile)) {
            return ['status' => 'warning', 'message' => 'Gagal update profile user: ' . mysqli_error($conn)];
        }

        // Update tb_user
        $update_user = "UPDATE tb_user SET id_user = '$id_pembimbing_baru' WHERE id_user = '" . $pembimbing['id_user'] . "' AND status_active = 1";
        if (!mysqli_query($conn, $update_user)) {
            return ['status' => 'warning', 'message' => 'Gagal update tb_user: ' . mysqli_error($conn)];
        }

        // Update tb_pengajuan
        $update_pengajuan = "UPDATE tb_pengajuan SET id_pembimbing = '$id_pembimbing_baru' WHERE id_pembimbing = '" . $pembimbing['id_user'] . "'";
        if (!mysqli_query($conn, $update_pengajuan)) {
            return ['status' => 'warning', 'message' => 'Gagal update tb_pengajuan: ' . mysqli_error($conn)];
        }

        // Update tb_persetujuan_pembimbing
        $update_persetujuan = "UPDATE tb_persetujuan_pembimbing SET id_pembimbing = '$id_pembimbing_baru' WHERE id_pembimbing = '" . $pembimbing['id_user'] . "'";
        if (!mysqli_query($conn, $update_persetujuan)) {
            return ['status' => 'warning', 'message' => 'Gagal update tb_persetujuan_pembimbing: ' . mysqli_error($conn)];
        }
    }

    // 8. Nonaktifkan bidang lama
    $deactivate_query = "UPDATE tb_bidang SET status_active = 0, change_by = '$id_user_editor' WHERE id_bidang = '$id_bidang_lama'";
    if (!mysqli_query($conn, $deactivate_query)) {
        return ['status' => 'warning', 'message' => 'Bidang baru dibuat, tapi gagal nonaktifkan versi lama'];
    }

    return ['status' => 'success', 'new_id' => $id_bidang_baru];
}

// function edit_instansi_admin_instansi($POST)
// {
//     global $conn;

//     $id_user = mysqli_real_escape_string($conn, $POST["id_user"]);
//     $id_instansi = mysqli_real_escape_string($conn, $POST["id_instansi"]);
//     $nama_pendek = mysqli_real_escape_string($conn, $POST["nama_pendek"]);
//     $nama_panjang = mysqli_real_escape_string($conn, $POST["nama_panjang"]);
//     $group_instansi = mysqli_real_escape_string($conn, $POST["group_instansi"]);
//     $alamat_instansi = mysqli_real_escape_string($conn, $POST["alamat_instansi"]);
//     $deskripsi_instansi = mysqli_real_escape_string($conn, $POST["deskripsi_instansi"]);
//     $lokasi_instansi = mysqli_real_escape_string($conn, $POST["lokasi_instansi"]);
//     $telepone_instansi = mysqli_real_escape_string($conn, $POST["telepone_instansi"]);
//     $gambar_lama = mysqli_real_escape_string($conn, $POST["gambar_instansi_lama"]);

//     // Upload gambar baru dengan id_instansi sebagai prefix
//     try {
//         $gambar_instansi = uploadGambar($_FILES["gambar_instansi"], $gambar_lama, "../assets/img/instansi/", $id_instansi);
//     } catch (Exception $e) {
//         error_log("Upload Error: " . $e->getMessage());
//         return -1;
//     }

//     // Update data instansi
//     $query = "UPDATE tb_instansi SET
//                 nama_pendek = ?,
//                 nama_panjang = ?,
//                 group_instansi = ?,
//                 alamat_instansi = ?,
//                 lokasi_instansi = ?,
//                 deskripsi_instansi = ?,
//                 telepone_instansi = ?,
//                 gambar_instansi = ?,
//                 change_by = ?
//               WHERE id_instansi = ?";

//     $stmt = mysqli_prepare($conn, $query);
//     mysqli_stmt_bind_param(
//         $stmt,
//         'sssssssssi',
//         $nama_pendek,
//         $nama_panjang,
//         $group_instansi,
//         $alamat_instansi,
//         $lokasi_instansi,
//         $deskripsi_instansi,
//         $telepone_instansi,
//         $gambar_instansi,
//         $id_user,
//         $id_instansi
//     );

//     if (mysqli_stmt_execute($stmt)) {
//         return mysqli_stmt_affected_rows($stmt);
//     } else {
//         error_log("Error updating record: " . mysqli_error($conn));
//         return 0;
//     }
// }

function tambah_bidang($POST)
{
    global $conn;
    $id_bidang = generateIdBidang($conn, $POST["id_instansi"]);
    $id_user = $POST["id_user"];
    $id_instansi = $POST["id_instansi"];
    $nama_bidang = $POST["nama_bidang"];
    $nama_pejabat = to_nullable($POST["nama_pejabat"]);
    $pangkat = to_nullable($POST["pangkat"]);
    $nip_pejabat = to_nullable($POST["nip"]);
    $deskripsi_bidang = $POST["deskripsi"];
    $kriteria = $POST["kriteria"];
    $kuota = to_nullable($POST["kuota"]);
    $dokumen_prasyarat = $POST["dokumen"];

    $query = "INSERT INTO tb_bidang (id_bidang, nama_bidang, nama_pejabat, pangkat_pejabat, nip_pejabat, deskripsi_bidang, kriteria_bidang, kuota_bidang, id_instansi, dokumen_persyaratan, create_by)
            VALUES ('$id_bidang','$nama_bidang', $nama_pejabat, $pangkat, $nip_pejabat, '$deskripsi_bidang', '$kriteria', $kuota, '$id_instansi', '$dokumen_prasyarat', '$id_user')";
    mysqli_query($conn, $query);
    return mysqli_affected_rows($conn);
}

function hapus_bidang($id, $id_user)
{
    global $conn;
    $query = "UPDATE tb_bidang SET
                    status_active = '0',
                    change_by = '$id_user'
                    WHERE id_bidang = '$id'";
    mysqli_query($conn, $query);
    return mysqli_affected_rows($conn);
}

function tambah_pembimbing($POST)
{
    global $conn;
    $id_pembimbing = generateIdPembimbing($conn, $POST["id_bidang"]);
    $id_user = $POST["id_user"];
    $nama_pembimbing = $POST["nama_pembimbing"];
    $email = $POST["email"];
    $nik_pembimbing = $POST["nik_pembimbing"] ?? null;
    $nip = $POST["nip"] ?? null;
    $jabatan = $POST["jabatan"] ?? null;
    $jenis_kelamin = $POST["jenis_kelamin"];
    $telepone_pembimbing = $POST["telepone_pembimbing"] ?? null;
    $id_bidang = $POST["id_bidang"];

    $query_pembimbing_1 = "INSERT INTO tb_user (id_user, email, level, create_by) VALUES ('$id_pembimbing', '$email', '4', '$id_user')";
    $query_pembimbing_2 = "INSERT INTO tb_profile_user
                (id_user, nama_user, nik, nip, jabatan, jenis_kelamin, telepone_user, id_bidang, create_by)
                VALUES ('$id_pembimbing', '$nama_pembimbing', '$nik_pembimbing', '$nip', '$jabatan', '$jenis_kelamin', '$telepone_pembimbing', '$id_bidang', '$id_user')";
    mysqli_query($conn, $query_pembimbing_1);
    mysqli_query($conn, $query_pembimbing_2);
    return mysqli_affected_rows($conn);
}

function edit_pembimbing($POST)
{
    global $conn;

    // Ambil data dari form
    $id_user                = $POST["edit_id_user"];
    $id_pembimbing          = $POST["edit_id_pembimbing"];
    $nama_pembimbing        = $POST["edit_nama_pembimbing"];
    $email                  = $POST["edit_email"];
    $nik_pembimbing         = $POST["edit_nik_pembimbing"];
    $nip                    = $POST["edit_nip"];
    $jabatan                = $POST["edit_jabatan"];
    $telepone_pembimbing    = $POST["edit_telepone_pembimbing"];
    $id_bidang_baru         = $POST["id_bidang"] ?? null;

    // Cek bidang lama dari database
    $query_bidang_lama = "SELECT id_bidang FROM tb_profile_user WHERE id_user = '$id_pembimbing'";
    $result = mysqli_query($conn, $query_bidang_lama);
    $row = mysqli_fetch_assoc($result);
    $id_bidang_lama = $row['id_bidang'];

    if ($id_bidang_baru === null || $id_bidang_baru === '') {
        $id_bidang_baru = $id_bidang_lama;
    }

    $total_affected = 0;

    // Jika bidang berubah, buat ID pembimbing baru
    if ($id_bidang_lama != $id_bidang_baru) {
        $query_check_bidang = "SELECT id_bidang FROM tb_bidang WHERE id_bidang = '$id_bidang_baru'";
        mysqli_query($conn, $query_check_bidang);

        // Hitung jumlah pembimbing di bidang baru untuk menentukan counter
        $query_count_pembimbing = "SELECT COUNT(*) as jumlah FROM tb_profile_user WHERE id_bidang = '$id_bidang_baru'";
        $result_count = mysqli_query($conn, $query_count_pembimbing);
        $row_count = mysqli_fetch_assoc($result_count);
        $counter = str_pad($row_count['jumlah'] + 1, 2, '0', STR_PAD_LEFT);

        $id_user_baru = $id_bidang_baru . $counter;

        // Update id_user di tb_profile_user
        $query_update_profile = "UPDATE tb_profile_user 
                                SET id_user = '$id_user_baru',
                                    nama_user = '$nama_pembimbing',
                                    nik = '$nik_pembimbing',
                                    nip = '$nip',
                                    jabatan = '$jabatan',
                                    telepone_user = '$telepone_pembimbing',
                                    id_bidang = '$id_bidang_baru',
                                    change_by = '$id_user' 
                                WHERE id_user = '$id_pembimbing'";

        // Update id_user di tb_user
        $query_update_user = "UPDATE tb_user 
                             SET id_user = '$id_user_baru', 
                                 email = '$email', 
                                 change_by = '$id_user' 
                             WHERE id_user = '$id_pembimbing'";

        // Eksekusi query dan akumulasi affected rows
        mysqli_query($conn, $query_update_profile);
        $total_affected += mysqli_affected_rows($conn);

        mysqli_query($conn, $query_update_user);
        $total_affected += mysqli_affected_rows($conn);
    } else {
        $query_update_profile = "UPDATE tb_profile_user
                                SET nama_user = '$nama_pembimbing',
                                    nik = '$nik_pembimbing',
                                    nip = '$nip',
                                    jabatan = '$jabatan',
                                    telepone_user = '$telepone_pembimbing',
                                    change_by = '$id_user'
                                WHERE id_user = '$id_pembimbing'";

        // Query untuk tb_user
        $query_update_user = "UPDATE tb_user 
                             SET email = '$email', 
                                 change_by = '$id_user' 
                             WHERE id_user = '$id_pembimbing'";

        // Eksekusi query dan akumulasi affected rows
        mysqli_query($conn, $query_update_profile);
        $total_affected += mysqli_affected_rows($conn);

        mysqli_query($conn, $query_update_user);
        $total_affected += mysqli_affected_rows($conn);
    }

    // Return total affected rows dari semua query
    return $total_affected > 0 ? 1 : 0;
}


function hapus_pembimbing($id, $id_user)
{
    global $conn;
    $query_update_1 = "UPDATE tb_user SET
                    status_active = '0',
                    change_by = '$id_user'
                    WHERE id_user = '$id'";
    $query_update_2 = "UPDATE tb_profile_user SET
                    status_active = '0',
                    change_by = '$id_user'
                    WHERE id_user = '$id'";
    mysqli_query($conn, $query_update_1);
    mysqli_query($conn, $query_update_2);
    return mysqli_affected_rows($conn);
}

function cek_edit_pembimbing($conn, $data_baru)
{
    $id_pembimbing = $data_baru["id_pembimbing"];

    // Ambil data lama dari database
    $query_check = "SELECT * FROM tb_profile_user WHERE id_user = '$id_pembimbing'";
    $result_check = mysqli_query($conn, $query_check);
    $data_lama = mysqli_fetch_assoc($result_check);

    // Jika data lama tidak ditemukan, anggap perubahan terjadi
    if (!$data_lama) {
        return false;
    }

    // Bandingkan data lama dengan data baru
    return $data_lama['nama_user'] == $data_baru["nama_pembimbing"] &&
        $data_lama['nik'] == $data_baru["nik_pembimbing"] &&
        $data_lama['nip'] == $data_baru["nip"] &&
        $data_lama['jabatan'] == $data_baru["jabatan"] &&
        $data_lama['telepone_user'] == $data_baru["telepone_pembimbing"] &&
        $data_lama['id_bidang'] == $data_baru["id_bidang"];
}

function cek_edit_instansi($conn, $data_baru)
{
    $id_instansi = mysqli_real_escape_string($conn, $data_baru["id_instansi"]);

    // Ambil data lama dari database
    $query_check = "SELECT * FROM tb_instansi WHERE id_instansi = '$id_instansi'";
    $result_check = mysqli_query($conn, $query_check);
    
    if (!$result_check || mysqli_num_rows($result_check) === 0) {
        return false;
    }

    $data_lama = mysqli_fetch_assoc($result_check);

    // Cek apakah ada upload gambar baru
    $ada_upload_gambar_baru = !empty($_FILES["gambar_instansi"]["name"]);

    // Bandingkan semua field kecuali gambar_instansi dulu
    $is_sama = 
        $data_lama['nama_pendek'] === $data_baru["nama_pendek"] &&
        $data_lama['nama_panjang'] === $data_baru["nama_panjang"] &&
        $data_lama['group_instansi'] === $data_baru["group_instansi"] &&
        $data_lama['alamat_instansi'] === $data_baru["alamat_instansi"] &&
        $data_lama['lokasi_instansi'] === $data_baru["lokasi_instansi"] &&
        $data_lama['deskripsi_instansi'] === $data_baru["deskripsi_instansi"] &&
        $data_lama['telepone_instansi'] === $data_baru["telepone_instansi"] &&
        $data_lama['website_resmi_instansi'] === $data_baru["website_resmi_instansi"];

    // Jika semua field selain gambar sama...
    if ($is_sama) {
        if (!$ada_upload_gambar_baru) {
            return true; 
        } else {
            return false;
        }
    }

    return false;
}

function cek_tambah_pembimbing($conn, $POST)
{
    $email = $POST["email"];
    $nik_pembimbing = $POST["nik_pembimbing"];
    $nip = $POST["nip"];
    $telepone_pembimbing = $POST["telepone_pembimbing"];

    // Cek apakah email sudah terdaftar
    $query_email = "SELECT * FROM tb_user WHERE email = '$email'";
    $result_email = mysqli_query($conn, $query_email);
    if (mysqli_num_rows($result_email) > 0) {
        return "Email sudah terdaftar!";
    }

    // Cek apakah NIK sudah ada
    $query_nik = "SELECT * FROM tb_profile_user WHERE nik = '$nik_pembimbing'";
    $result_nik = mysqli_query($conn, $query_nik);
    if (mysqli_num_rows($result_nik) > 0) {
        return "NIK sudah terdaftar!";
    }

    // Cek apakah NIP sudah ada (jika diisi)
    if (!empty($nip)) {
        $query_nip = "SELECT * FROM tb_profile_user WHERE nip = '$nip'";
        $result_nip = mysqli_query($conn, $query_nip);
        if (mysqli_num_rows($result_nip) > 0) {
            return "NIP sudah terdaftar!";
        }
    }

    // Cek apakah nomor telepon sudah ada
    $query_telepone = "SELECT * FROM tb_profile_user WHERE telepone_user = '$telepone_pembimbing'";
    $result_telepone = mysqli_query($conn, $query_telepone);
    if (mysqli_num_rows($result_telepone) > 0) {
        return "Nomor telepon sudah digunakan!";
    }

    return "OK"; // Tidak ada duplikasi, bisa lanjut menambahkan
}


use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// === Fungsi Kirim OTP via Email ===
function kirimOTP($email_penerima, $otp)
{
    $email_pengirim = 'moneyuang25@gmail.com';
    $nama_pengirim = 'Diskominfo Sidoarjo';
    $subject = 'OTP Verification';

    $message = '
    <html>
    <head>
        <style>
            body { font-family: Arial, sans-serif; color: #333; }
            .container { max-width: 600px; margin: 0 auto; padding: 20px; border: 1px solid #ddd; border-radius: 8px; }
            .otp { font-size: 24px; font-weight: bold; color: #007BFF; }
            .footer { margin-top: 20px; font-size: 14px; color: #666; }
        </style>
    </head>
    <body>
        <div class="container">
            <h2>Verifikasi OTP</h2>
            <p>Halo,</p>
            <p>Terima kasih telah menggunakan layanan kami. Berikut adalah kode OTP (One Time Password) untuk verifikasi akun Anda:</p>
            <p class="otp">' . $otp . '</p>
            <p>Kode ini hanya berlaku selama 2 menit. Jangan bagikan kode ini kepada siapa pun.</p>
            <div class="footer">
                Hormat kami,<br><br>
                <strong>Diskominfo Sidoarjo</strong><br>
                Kota Sidoarjo, Jawa Timur
            </div>
        </div>
    </body>
    </html>
    ';

    $mail = new PHPMailer();
    $mail->isSMTP();

    $mail->Host = 'smtp.gmail.com';
    $mail->Username = $email_pengirim;
    $mail->Password = 'leeufuyyxfovbqtb'; // Gunakan App Password jika Gmail
    $mail->Port = 465;
    $mail->SMTPAuth = true;
    $mail->SMTPSecure = 'ssl';

    $mail->setFrom($email_pengirim, $nama_pengirim);
    $mail->addAddress($email_penerima);
    $mail->isHTML(true);
    $mail->Subject = $subject;
    $mail->Body = $message;

    return $mail->send(); // Mengembalikan true jika sukses
}

function show_alert($title, $text, $icon, $redirect = null)
{
    echo "
    <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                title: '$title',
                text: '$text',
                icon: '$icon'"
        . ($redirect ? ", timer: 2000, showConfirmButton: false}).then(() => { window.location.href = '$redirect'; });" : "});")
        . "
        });
    </script>";
}


// ================================= APPROVE PENILAIAN =================================
function approve_nilai($POST)
{
    global $conn;
    $id_nilai = $POST["id_nilai"];
    // $tanda_tangan_admin = $POST["tanda_tangan_admin"];
    $id_admin = $POST["id_admin_approve"];

    $query = "UPDATE tb_nilai SET 
                    id_admin_approve = '$id_admin',
                    tanggal_approve = NOW(),
                    status_approve = '1'
                    WHERE id_nilai = '$id_nilai'";
    if (mysqli_query($conn, $query)) {
        return mysqli_affected_rows($conn);
    } else {
        return 0;
    }
}



function generateIdBackground($id_instansi)
{
    $query = "SELECT MAX(RIGHT(id_background, 2)) as max_counter 
                    FROM tb_sertifikat_background 
                    WHERE LEFT(id_background, 9) = '$id_instansi'";
    $result = query($query);

    if ($result[0]['max_counter']) {
        $newCounter = (int)$result[0]['max_counter'] + 1;
    } else {
        $newCounter = 1;
    }

    $counterFormatted = str_pad($newCounter, 2, '0', STR_PAD_LEFT);
    return $id_instansi . $counterFormatted;
}
