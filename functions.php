<?php 
    $conn = mysqli_connect("localhost", "root", "", "magang_database");

    function query($query) {
        global $conn;
        $rows = [];
        $result = mysqli_query($conn, $query);
        while ($row = mysqli_fetch_assoc($result)) {
            $rows[] = $row;
        } 
        return $rows;
    }

    function generateUserId($conn) {
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


    function uploadImage($file) {
        // Jika file tidak diupload, kembalikan avatar default
        if ($file['error'] === 4) { // Error code 4 = No file uploaded
            return "avatar1.png";
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

    function register($POST) {
        global $conn;
        $id_user = generateUserId($conn);
        $nama = $POST["nama"];
        $email = $POST["email"];
        $nik = $POST["nik"];
        $nim = $POST["nim"];
        $nisn = $POST["nisn"];
        $pendidikan = $POST["pendidikan"];
        $jenis_kelamin = $POST["jenis_kelamin"];
        $tempat_lahir = $POST["tempat_lahir"];
        $tanggal_lahir = $POST["tanggal_lahir"];
        $alamat = $POST["alamat"];
        $telepone = $POST["telepone"];
        $level = $POST["level"];
        $gambar = uploadImage($_FILES["gambar"]);

        $query1 = "INSERT INTO tb_user (id_user, email, level, create_by) VALUES ('$id_user', '$email', '$level', '$id_user')";
        $query2 = "INSERT INTO tb_profile_user (id_user, nama, nik, nisn, nim, jenis_kelamin, tempat_lahir, tanggal_lahir, alamat, gambar,  id_pendidikan, create_by, telepone)
                    VALUES ('$id_user', '$nama', '$nik', '$nisn', '$nim', '$jenis_kelamin', '$tempat_lahir', '$tanggal_lahir', '$alamat', '$gambar', '$pendidikan', '$id_user', '$telepone')";

        mysqli_query($conn, $query1);
        mysqli_query($conn, $query2);
        return mysqli_affected_rows($conn);
    }
?>