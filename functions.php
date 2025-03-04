<?php

use Dom\Mysql;

    include "koneksi.php";

    function query($query) {
        global $conn;
        $rows = [];
        $result = mysqli_query($conn, $query);
        while ($row = mysqli_fetch_assoc($result)) {
            $rows[] = $row;
        } return $rows;
    }



    function generateUserId($conn) {
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




    function uploadImage($file, $old_img, $directory) {
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



    function checking($conn, $table, $column, $value) {
        $column = mysqli_real_escape_string($conn, $column);
        $value = mysqli_real_escape_string($conn, $value);

        $query = "SELECT $column FROM $table WHERE $column = '$value'";
        $result = mysqli_query($conn, $query);
        return mysqli_num_rows($result) > 0;
    }


    function register($POST){
        global $conn;
        $id_user = generateUserId($conn);
        $nama = $POST["nama_user"];
        $email = $POST["email"];
        $nik = $POST["nik"];
        $nisn = $POST["nisn"];
        $pendidikan = $POST["id_pendidikan"];
        $jenis_kelamin = $POST["jenis_kelamin"];
        $tempat_lahir = $POST["tempat_lahir"];
        $tanggal_lahir = $POST["tanggal_lahir"];
        $alamat = $POST["alamat_user"];
        $telepone = $POST["telepone_user"];
        $level = $POST["level"];
        $nim = $POST["nim"];
        $gambar = uploadImage($_FILES["gambar_user"], "avatar.png", "assets/img/user/");

        if (checking($conn, 'tb_user', 'email', $email)) {
            header("Location: register.php?error=email_terdaftar");
            exit;
        }
        if (checking($conn, 'tb_profile_user', 'nik', $nik)) {
            header("Location: register.php?error=nik_terdaftar");
            exit;
        }
        if (checking($conn, 'tb_profile_user', 'nisn', $nisn)) {
            header("Location: register.php?error=nisn_terdaftar");
            exit;
        }

        if (empty($nik) || strlen($nik) !== 16 || !ctype_digit($nik)) {
            header("Location: register.php?error=nik_tidak_sesuai");
            exit;
        }
        if (empty($nisn) || strlen($nisn) !== 10 || !ctype_digit($nisn)) {
            header("Location: register.php?error=nisn_tidak_sesuai");
            exit;
        }

        $query1 = "INSERT INTO tb_user (id_user, email, level, create_by) VALUES ('$id_user', '$email', '$level', '$id_user')";
        $query2 = "INSERT INTO tb_profile_user (id_user, nama_user, nik, nisn, nim, jenis_kelamin, tempat_lahir, tanggal_lahir, alamat_user, gambar_user, id_pendidikan, create_by, telepone_user)
                            VALUES ('$id_user', '$nama', '$nik', '$nisn', '$nim', '$jenis_kelamin', '$tempat_lahir', '$tanggal_lahir', '$alamat', '$gambar', '$pendidikan', '$id_user', '$telepone')";
        $query_user = mysqli_query($conn, $query1);
        $query_profile = mysqli_query($conn, $query2);
        if($query_user && $query_profile) {
            return mysqli_affected_rows($conn);
        } else {
            return 0;
        }
    }
















// =========================================================== SUPER ADMIN LEVEL (1) ========================================================

// ================================ PROFILE SUPER ADMIN ================================
    function edit_profile_super_admin($POST_edit) {
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
                    telepone_user = '$telepone',
                    jenis_kelamin = '$jenis_kelamin',
                    alamat_user = '$alamat_user',
                    gambar_user = '$gambar',
                    change_by = '$id_user'
                    WHERE id_user = '$id_user'
            ";
        if(mysqli_query($conn, $query)) {
            return mysqli_affected_rows($conn);
        } else {
            return 0;
        }
    }


// ================================ INSTANSI SUPER ADMIN =================================
    function tambah_instansi_super_admin($POST) {
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

        if (checking($conn, 'tb_instansi', 'id_instansi', $id_instansi)) {
            header("Location: instansi_tambah.php?error=id_instansi_terdaftar");
            exit;
        }
        $query = "INSERT INTO tb_instansi (id_instansi, nama_pendek, nama_panjang, group_instansi, alamat_instansi, lokasi_instansi, telepone_instansi, deskripsi_instansi, gambar_instansi, create_by) 
            VALUES ('$id_instansi', '$nama_pendek', '$nama_panjang', '$group_instansi', '$alamat_instansi', '$lokasi_instansi', '$telepone_instansi', '$deskripsi_instansi', '$gambar_instansi', '$id_user')";
        if(mysqli_query($conn, $query)) {
            return mysqli_affected_rows($conn);
        } else {
            return 0;
        }
    }



    function edit_instansi($POST) {
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
    
    if(mysqli_query($conn, $query)) {
        return mysqli_affected_rows($conn);
    } else {
        return 0;
    }
    }



    function hapus_instansi($id_instansi, $id_user) {
        global $conn;
        $query = "UPDATE tb_instansi SET 
                    status_active = '0',
                    change_by = '$id_user'
                    WHERE id_instansi = $id_instansi
                    ";
        if(mysqli_query($conn, $query)) {
            return mysqli_affected_rows($conn);
        } else {
            return 0;
        }
    }




    function edit_instansi_super_admin($POST) {
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
        if(mysqli_query($conn, $query)) {
            return mysqli_affected_rows($conn);
        } else {
            return 0;
        }
    }




    function generate_admin_instansi($POST) {
        global $conn;
        $id_super_admin = $POST["id_super_admin"];
        $id_user = $POST["id_user"];
        $id_instansi = $POST["id_instansi"];
        $query_profile = mysqli_query($conn, "UPDATE tb_profile_user SET id_instansi = '$id_instansi', change_by = '$id_super_admin' WHERE id_user = '$id_user'");
        if($query_profile) {
            return mysqli_affected_rows($conn);
        } else {
            return 0;
        }
    }
    
    
    
    function tambah_admin_instansi($POST) {
        global $conn;
        $create_by = $POST["id_user"];
        $id_user = generateUserId($conn);
        $nama_user = $POST["nama_user"];
        $nik = $POST["nik"];
        $nip = $POST["nip"];
        $gender = $POST["jenis_kelamin"];
        $email = $POST["email"];
        $tempat_lahir = $POST["tempat_lahir"];
        $tanggal_lahir = $POST["tanggal_lahir"];
        $telepone_user = $POST["telepone_user"];
        $alamat_user = $POST["alamat_user"];
        $gambar_user = uploadImage($_FILES["gambar_instansi"], "avatar.png", "../assets/img/user/");
    
        $query_user = mysqli_query($conn, "INSERT INTO tb_user(id_user, email, level, create_by) VALUES ('$id_user', '$email', '2', '$create_by') ");
        $query_profile= mysqli_query($conn, "INSERT INTO tb_profile_user(id_user, nama_user, nik, nip, jenis_kelamin, tempat_lahir, tanggal_lahir, alamat_user, telepone_user, gambar_user, create_by) 
                            VALUES ('$id_user', '$nama_user', '$nik', '$nip', '$gender', '$tempat_lahir', '$tanggal_lahir', '$alamat_user', '$telepone_user', '$gambar_user', '$create_by')");
        if($query_user && $query_profile) {
            return mysqli_affected_rows($conn);
        } else {
            return 0;
        }
    }
    
    
    


    function super_admin_edit($POST) {
        global $conn;
        $id_user = $POST["id_user"];
        $nama_user = $POST["nama_user"];
        $tanggal_lahir = $POST["tanggal_lahir"];
        $tempat_lahir = $POST["tempat_lahir"];
        $telepone_user = $POST["telepone_user"];
        $alamat_user = $POST["alamat_user"];
        $jenis_kelamin = $POST["jenis_kelamin"];
        $gambar_lama = $POST["gambar_lama"];
        $gambar_user = uploadImage($_FILES["gambar_user"], $gambar_lama, "../assets/img/user/");
        $query = mysqli_query($conn, "UPDATE tb_profile_user SET
                            nama_user = '$nama_user',
                            jenis_kelamin = '$jenis_kelamin',
                            tempat_lahir = '$tempat_lahir',
                            tanggal_lahir = '$tanggal_lahir',
                            alamat_user = '$alamat_user',
                            telepone_user = '$telepone_user',
                            gambar_user = '$gambar_user'
                            WHERE id_user = '$id_user'");
        if($query) {
            return mysqli_affected_rows($conn);
        } else {
            return 0;
        }
    }
    
    
    function hapus_user_super_admin($id_user, $change_by) {
        global $conn;
        $query_user = mysqli_query($conn, "UPDATE tb_user SET status_active = '0', change_by = '$change_by' WHERE id_user = '$id_user'");
        $query_profile = mysqli_query($conn, "UPDATE tb_profile_user SET status_active = '0', change_by = '$change_by' WHERE id_user = '$id_user'");
        if($query_user && $query_profile) {
            return mysqli_affected_rows($conn);
        } else {
            return 0;
        }
    }


    function hapus_pengajuan_by_super_admin($id_pengajuan, $change_by) {
        global $conn;
        $query = mysqli_query($conn, "UPDATE tb_pengajuan SET status_active = '0', change_by = '$change_by' WHERE id_pengajuan = '$id_pengajuan'");
        if($query) {
            return mysqli_affected_rows($conn);
        } else {
            return 0;
        }
    }



    function hapus_pendidikan_super_admin($id_pendidikan, $id_user) {
        global $conn;
        $query = mysqli_query($conn, "UPDATE tb_pendidikan SET status_active = '0', change_by = '$id_user' WHERE id_pendidikan = '$id_pendidikan'");
        if ($query) {
            return mysqli_affected_rows($conn);
        } else {
            return 0;
        }
    }






    function edit_email_super_admin($POST) {
        global $conn;
        $email_baru = mysqli_real_escape_string($conn, $POST["email_baru"]); // Hindari SQL injection
        $id_user = mysqli_real_escape_string($conn, $POST["id_user"]); // Hindari SQL injection
    
        $query = "UPDATE tb_user SET email = '$email_baru', change_by = '$id_user' WHERE id_user = '$id_user'";
    
        if (mysqli_query($conn, $query)) {
            return mysqli_affected_rows($conn); // Kembalikan jumlah baris yang terpengaruh
        } else {
            die("Error: " . mysqli_error($conn)); // Debugging error MySQL
        }
    }    






// ====================================== END OF SUPER ADMIN LEVEL (1) ============================================================














// ========================================= ADMIN INSTANSI LEVEL(2) ================================================

// =============================== BIDANG ADMIN INSTANSI =================================

    function generateIdBidang($conn, $id_instansi) {
        // Cari bidang terakhir dalam instansi tersebut
        $query_bidang = "SELECT id_bidang FROM tb_bidang WHERE id_bidang LIKE '$id_instansi%' ORDER BY id_bidang DESC LIMIT 1";
        $result_bidang = mysqli_query($conn, $query_bidang);
        $row_bidang = mysqli_fetch_assoc($result_bidang);

        if ($row_bidang) {
            // Ambil 2 digit terakhir dari ID Bidang terakhir
            $last_counter = intval(substr($row_bidang['id_bidang'], -2));
            $new_counter = $last_counter + 1; // Tambah 1
        } else {
            $new_counter = 1; // Jika belum ada bidang, mulai dari 01
        }

        // Format nomor urut menjadi dua digit (01, 02, 03, ...)
        $nomorUrut = str_pad($new_counter, 2, "0", STR_PAD_LEFT);

        // Gabungkan ID Instansi dengan nomor urut baru
        return $id_instansi . $nomorUrut;
    }
    
    function generateIdPembimbing($conn, $id_bidang) {
        // Cari pembimbing terakhir dalam bidang tersebut
        $query_pembimbing = "SELECT id_user FROM tb_profile_user WHERE id_user LIKE '$id_bidang%' ORDER BY id_user DESC LIMIT 1";
        $result_pembimbing = mysqli_query($conn, $query_pembimbing);
        $row_pembimbing = mysqli_fetch_assoc($result_pembimbing);
    
        if ($row_pembimbing) {
            // Ambil 2 digit terakhir dari ID Pembimbing terakhir
            $last_counter = intval(substr($row_pembimbing['id_user'], -2));
            $new_counter = $last_counter + 1; // Tambah 1
        } else {
            $new_counter = 1; // Jika belum ada pembimbing, mulai dari 01
        }
    
        // Format nomor urut menjadi dua digit (01, 02, 03, ...)
        $nomorUrut = str_pad($new_counter, 2, "0", STR_PAD_LEFT);
    
        // Gabungkan ID Bidang dengan nomor urut baru
        return $id_bidang . $nomorUrut;
    }

    function edit_profile($POST_edit) {
        global $conn;
        $id_user = mysqli_real_escape_string($conn, $POST_edit["id_user"]);
        $nama_user = mysqli_real_escape_string($conn, $POST_edit["nama_user"]);
        $tempat_lahir = mysqli_real_escape_string($conn, $POST_edit["tempat_lahir"]);
        $tanggal_lahir = mysqli_real_escape_string($conn, $POST_edit["tanggal_lahir"]);
        $telepone = mysqli_real_escape_string($conn, $POST_edit["telepone"]);
        $alamat_user = mysqli_real_escape_string($conn, $POST_edit["alamat_user"]);
        $jenis_kelamin = mysqli_real_escape_string($conn, $POST_edit["jenis_kelamin"]);
        $gambar_lama = mysqli_real_escape_string($conn, $POST_edit["gambar_lama"]);
        $gambar = uploadImage($_FILES["gambar"], $gambar_lama, "../assets/img/user/");

        $query = "UPDATE tb_profile_user SET 
                    nama_user = '$nama_user',
                    tempat_lahir = '$tempat_lahir',
                    tanggal_lahir = '$tanggal_lahir',
                    telepone_user = '$telepone',
                    jenis_kelamin = '$jenis_kelamin',
                    alamat_user = '$alamat_user',
                    gambar_user = '$gambar',
                    change_by = '$id_user'
                    WHERE id_user = '$id_user'
            ";
        mysqli_query($conn, $query);
        return mysqli_affected_rows($conn);
    }

    function cek_edit_profile($conn, $data_baru) {
        $id_user = $data_baru["id_user"];
    
        // Ambil data lama dari database
        $query_check = "SELECT * FROM tb_profile_user WHERE id_user = '$id_user'";
        $result_check = mysqli_query($conn, $query_check);
        $data_lama = mysqli_fetch_assoc($result_check);
    
        // Jika data lama tidak ditemukan, anggap perubahan terjadi
        if (!$data_lama) {
            return false;
        }
    
        // Cek apakah ada gambar baru yang diunggah
        $gambar_baru = !empty($_FILES["gambar"]["name"]) ? $_FILES["gambar"]["name"] : $data_baru["gambar_lama"];

        // Bandingkan data lama dengan data baru
        return $data_lama['nama_user'] == $data_baru["nama_user"] &&
            $data_lama['tempat_lahir'] == $data_baru["tempat_lahir"] &&
            $data_lama['tanggal_lahir'] == $data_baru["tanggal_lahir"] &&
            $data_lama['telepone_user'] == $data_baru["telepone"] &&
            $data_lama['jenis_kelamin'] == $data_baru["jenis_kelamin"] &&
            $data_lama['alamat_user'] == $data_baru["alamat_user"] &&
            $data_lama['gambar_user'] == $gambar_baru;
    }    
    
    function tambah_bidang($POST) {
        global $conn;
        $id_bidang = generateIdBidang($conn, $POST["id_instansi"]);
        $id_user = $POST["id_user"];
        $id_instansi = $POST["id_instansi"];
        $nama_bidang = $POST["nama_bidang"];
        $deskripsi_bidang = $POST["deskripsi"];
        $kriteria = $POST["kriteria"];
        $kuota = $POST["kuota"];
        $dokumen_prasyarat = $POST["dokumen"];

        $query = "INSERT INTO tb_bidang (id_bidang, nama_bidang, deskripsi_bidang, kriteria_bidang, kuota_bidang, id_instansi, dokumen_prasyarat, create_by)
            VALUES ('$id_bidang','$nama_bidang', '$deskripsi_bidang', '$kriteria', '$kuota', '$id_instansi', '$dokumen_prasyarat', '$id_user')";
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
                    kriteria_bidang = '$kriteria',
                    kuota_bidang = '$kuota',
                    dokumen_prasyarat = '$dokumen_prasyarat',
                    change_by = '$id_user'
                    WHERE id_bidang = '$id_bidang'";
        mysqli_query($conn, $query);
        return mysqli_affected_rows($conn);
    }

    function hapus_bidang($id, $id_user) {
        global $conn;
        $query = "UPDATE tb_bidang SET
                    status_active = '0',
                    change_by = '$id_user'
                    WHERE id_bidang = '$id'";
        mysqli_query($conn, $query);
        return mysqli_affected_rows($conn);
    }

    function tambah_pembimbing($POST) {
        global $conn;
        $id_pembimbing = generateIdPembimbing($conn, $POST["id_bidang"]);
        $id_user = $POST["id_user"];
        $nama_pembimbing = $POST["nama_pembimbing"];
        $email = $POST["email"];
        $nik_pembimbing = $POST["nik_pembimbing"];
        $nip = $POST["nip"];
        $jabatan = $POST["jabatan"];
        $jenis_kelamin = $POST["jenis_kelamin"];
        $telepone_pembimbing = $POST["telepone_pembimbing"];
        $id_bidang = $POST["id_bidang"];

        $query_pembimbing_1 = "INSERT INTO tb_user (id_user, email, level, create_by) VALUES ('$id_pembimbing', '$email', '5', '$id_user')";
        $query_pembimbing_2 = "INSERT INTO tb_profile_user
                (id_user, nama_user, nik, nip, jabatan, jenis_kelamin, telepone_user, id_bidang, create_by)
                VALUES ('$id_pembimbing', '$nama_pembimbing', '$nik_pembimbing', '$nip', '$jabatan', '$jenis_kelamin', '$telepone_pembimbing', '$id_bidang', '$id_user')";
        mysqli_query($conn, $query_pembimbing_1);
        mysqli_query($conn, $query_pembimbing_2);
        return mysqli_affected_rows($conn);
    }

    function edit_pembimbing($POST) {
        global $conn;
    
        // Ambil data dari form
        $id_user                = $POST["id_user"];
        $id_pembimbing          = $POST["id_pembimbing"];
        $nama_pembimbing        = $POST["nama_pembimbing"];
        $nik_pembimbing         = $POST["nik_pembimbing"];
        $nip                    = $POST["nip"];
        $jabatan                = $POST["jabatan"];
        $telepone_pembimbing    = $POST["telepone_pembimbing"];
        $id_bidang_baru         = $POST["id_bidang"];
    
        // Cek bidang lama dari database
        $query_bidang_lama = "SELECT id_bidang FROM tb_profile_user WHERE id_user = '$id_pembimbing'";
        $result = mysqli_query($conn, $query_bidang_lama);
        $row = mysqli_fetch_assoc($result);
        $id_bidang_lama = $row['id_bidang'];
    
        // Jika bidang berubah, buat ID pembimbing baru
        if ($id_bidang_lama != $id_bidang_baru) {
            $query_check_bidang = "SELECT id_bidang FROM tb_bidang WHERE id_bidang = '$id_bidang_baru'";
            mysqli_query($conn, $query_check_bidang);
    
            // Hitung jumlah pembimbing di bidang baru untuk menentukan counter
            $query_count_pembimbing = "SELECT COUNT(*) as jumlah FROM tb_profile_user WHERE id_bidang = '$id_bidang_baru'";
            $result_count = mysqli_query($conn, $query_count_pembimbing);
            $row_count = mysqli_fetch_assoc($result_count);
            $counter = str_pad($row_count['jumlah'] + 1, 2, '0', STR_PAD_LEFT);
    
            // Generate id_user baru: {id_bidang}{counter}
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
            $query_update_user = "UPDATE tb_user SET id_user = '$id_user_baru' WHERE id_user = '$id_pembimbing'";
    
            mysqli_query($conn, $query_update_profile);
            mysqli_query($conn, $query_update_user);
        } else {
            // Jika bidang tidak berubah, update data saja tanpa mengganti id_user
            $query_update = "UPDATE tb_profile_user
                            SET nama_user = '$nama_pembimbing',
                                nik = '$nik_pembimbing',
                                nip = '$nip',
                                jabatan = '$jabatan',
                                telepone_user = '$telepone_pembimbing',
                                change_by = '$id_user'
                            WHERE id_user = '$id_pembimbing'";
    
            mysqli_query($conn, $query_update);
        }
    
        return mysqli_affected_rows($conn);
    }

    function hapus_pembimbing($id, $id_user) {
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

    function cek_edit_pembimbing($conn, $data_baru) {
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
    
    function cek_edit_instansi($conn, $data_baru) {
        $id_instansi = $data_baru["id_instansi"];
    
        // Ambil data lama dari database
        $query_check = "SELECT * FROM tb_instansi WHERE id_instansi = '$id_instansi'";
        $result_check = mysqli_query($conn, $query_check);
        $data_lama = mysqli_fetch_assoc($result_check);
    
        // Jika data lama tidak ditemukan, anggap perubahan terjadi
        if (!$data_lama) {
            return false;
        }
    
        // Cek apakah ada gambar baru yang diunggah
        $gambar_baru = !empty($_FILES["gambar_instansi"]["name"]) ? $_FILES["gambar_instansi"]["name"] : $data_baru["gambar_instansi"];
    
        // Bandingkan data lama dengan data baru
        return $data_lama['nama_pendek'] == $data_baru["nama_pendek"] &&
               $data_lama['nama_panjang'] == $data_baru["nama_panjang"] &&
               $data_lama['group_instansi'] == $data_baru["group_instansi"] &&
               $data_lama['alamat_instansi'] == $data_baru["alamat_instansi"] &&
               $data_lama['lokasi_instansi'] == $data_baru["lokasi_instansi"] &&
               $data_lama['deskripsi_instansi'] == $data_baru["deskripsi_instansi"] &&
               $data_lama['telepone_instansi'] == $data_baru["telepone_instansi"] &&
               $data_lama['gambar_instansi'] == $gambar_baru;
    }
    
    function cek_tambah_pembimbing($conn, $POST) {
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
    

