<?php
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
        $nik = $POST["nik_user"];
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
        if (checking($conn, 'tb_profile_user', 'nik_user', $nik)) {
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
        $query2 = "INSERT INTO tb_profile_user (id_user, nama_user, nik_user, nisn, nim, jenis_kelamin, tempat_lahir, tanggal_lahir, alamat_user, gambar_user, id_pendidikan, create_by, telepone_user)
                            VALUES ('$id_user', '$nama', '$nik', '$nisn', '$nim', '$jenis_kelamin', '$tempat_lahir', '$tanggal_lahir', '$alamat', '$gambar', '$pendidikan', '$id_user', '$telepone')";
        mysqli_query($conn, $query1);
        mysqli_query($conn, $query2);
        return mysqli_affected_rows($conn);
    }
















// =========================================================== SUPER ADMIN LEVEL (1) ========================================================

// ================================ PROFILE SUPER ADMIN ================================
    function edit_profile_1($POST_edit) {
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
        mysqli_query($conn, $query);
        return mysqli_affected_rows($conn);
    }


// ================================ INSTANSI SUPER ADMIN =================================
    function tambah_instansi($POST) {
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
        mysqli_query($conn, $query);
        return mysqli_affected_rows($conn);
    }



    function hapus_instansi($id_instansi, $id_user) {
        global $conn;
        $query = "UPDATE tb_instansi SET 
                    status_active = '0',
                    change_by = '$id_user'
                    WHERE id_instansi = $id_instansi
                    ";
        mysqli_query($conn, $query);
        return mysqli_affected_rows($conn);
    }




    function edit_instansi_super($POST) {
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




    function generate_admin_instansi($POST) {
        global $conn;
        $id_super_admin = $POST["id_super_admin"];
        $id_user = $POST["id_user"];
        $id_instansi = $POST["id_instansi"];
        mysqli_query($conn, "UPDATE tb_profile_user SET id_instansi = '$id_instansi', change_by = '$id_super_admin' WHERE id_user = '$id_user'");
        return mysqli_affected_rows($conn);
    }
    
    
    
    function tambah_admin_instansi($POST) {
        global $conn;
        $create_by = $POST["id_user"];
        $id_user = generateUserId($conn);
        $nama_user = $POST["nama_user"];
        $nik_user = $POST["nik_user"];
        $gender = $POST["jenis_kelamin"];
        $email = $POST["email"];
        $tempat_lahir = $POST["tempat_lahir"];
        $tanggal_lahir = $POST["tanggal_lahir"];
        $telepone_user = $POST["telepone_user"];
        $alamat_user = $POST["alamat_user"];
        $gambar_user = uploadImage($_FILES["gambar_instansi"], "avatar.png", "../assets/img/user/");
    
        mysqli_query($conn, "INSERT INTO tb_user(id_user, email, level, create_by) VALUES ('$id_user', '$email', '2', '$create_by') ");
        mysqli_query($conn, "INSERT INTO tb_profile_user(id_user, nama_user, nik_user, jenis_kelamin, tempat_lahir, tanggal_lahir, alamat_user, telepone_user, gambar_user, create_by) 
                            VALUES ('$id_user', '$nama_user', '$nik_user', '$gender', '$tempat_lahir', '$tanggal_lahir', '$alamat_user', '$telepone_user', '$gambar_user', '$create_by')");
        return mysqli_affected_rows($conn);
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
        mysqli_query($conn, "UPDATE tb_profile_user SET
                            nama_user = '$nama_user',
                            jenis_kelamin = '$jenis_kelamin',
                            tempat_lahir = '$tempat_lahir',
                            tanggal_lahir = '$tanggal_lahir',
                            alamat_user = '$alamat_user',
                            telepone_user = '$telepone_user',
                            gambar_user = '$gambar_user'
                            WHERE id_user = '$id_user'");
        return mysqli_affected_rows($conn);
    }
    
    
    function super_admin_hapus_user($id_user, $change_by) {
        global $conn;
        mysqli_query($conn, "UPDATE tb_user SET status_active = '0', change_by = '$change_by' WHERE id_user = '$id_user'");
        mysqli_query($conn, "UPDATE tb_profile_user SET status_active = '0', change_by = '$change_by' WHERE id_user = '$id_user'");
        return mysqli_affected_rows($conn);
    }



// ====================================== END OF SUPER ADMIN LEVEL (1) ============================================================














// ========================================= ADMIN INSTANSI LEVEL(2) ================================================

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
        $id_user = $POST["id_user"];
        $nama_pembimbing = $POST["nama_pembimbing"];
        $nik_pembimbing = $POST["nik_pembimbing"];
        $nip = $POST["nip"];
        $jabatan = $POST["jabatan"];
        $telepone_pembimbing = $POST["telepone_pembimbing"];
        $id_bidang = $POST["id_bidang"];

        $query = "INSERT INTO tb_pembimbing
                (id_pembimbing, nama_pembimbing, nik_pembimbing, nip, jabatan, telepone_pembimbing, id_bidang, create_by)
                VALUES ('', '$nama_pembimbing', '$nik_pembimbing', '$nip', '$jabatan', '$telepone_pembimbing', '$id_bidang', '$id_user')";
        mysqli_query($conn, $query);
        return mysqli_affected_rows($conn);
    }



    function edit_pembimbing($POST) {
        global $conn;

        // Ambil data dari form
        $id_user = $POST["id_user"]; // Untuk mencatat siapa yang mengedit data
        $id_pembimbing = $POST["id_pembimbing"];
        $nama_pembimbing = $POST["nama_pembimbing"];
        $nik_pembimbing = $POST["nik_pembimbing"];
        $nip = $POST["nip"];
        $jabatan = $POST["jabatan"];
        $telepone_pembimbing = $POST["telepone_pembimbing"];
        $id_bidang = $POST["id_bidang"];

        // Query untuk update data pembimbing
        $query = "UPDATE tb_pembimbing
                SET nama_pembimbing = '$nama_pembimbing',
                    nik_pembimbing = '$nik_pembimbing',
                    nip = '$nip',
                    jabatan = '$jabatan',
                    telepone_pembimbing = '$telepone_pembimbing',
                    id_bidang = '$id_bidang',
                    change_by = '$id_user'
                WHERE id_pembimbing = '$id_pembimbing'";

        // Eksekusi query
        mysqli_query($conn, $query);

        // Kembalikan jumlah baris yang terpengaruh
        return mysqli_affected_rows($conn);
    }




    function hapus_pembimbing($id, $id_user) {
        global $conn;
        $query = "UPDATE tb_pembimbing SET
                    status_pengajuan = 'N',
                    change_by = '$id_user'
                    WHERE id_pembimbing = '$id'";
        mysqli_query($conn, $query);
        return mysqli_affected_rows($conn);
    }




