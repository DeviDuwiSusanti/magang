<?php
function generateIdPengajuan($conn) {
    // Ambil tanggal saat ini dalam format YYYYMMDD
    $tanggal = date("Ymd");

    // Ambil jumlah pengajuan yang sudah ada untuk hari ini
    $query = "SELECT COUNT(*) AS total FROM tb_pengajuan WHERE id_pengajuan LIKE '$tanggal%'";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);
    $totalPengajuanHariIni = $row['total'] + 1; // Urutan berikutnya

    // Format XX menjadi dua digit (01, 02, 03, ...)
    $nomorUrut = str_pad($totalPengajuanHariIni, 2, "0", STR_PAD_LEFT);

    // Gabungkan untuk mendapatkan id_pengajuan
    return $tanggal . $nomorUrut;
}

function generateIdDokumen($conn, $id_pengajuan) {
    // Ambil jumlah dokumen yang sudah ada untuk pengajuan ini
    $query = "SELECT COUNT(*) AS total FROM tb_dokumen WHERE id_dokumen LIKE '$id_pengajuan%'";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);
    $totalDokumen = $row['total'] + 1; // Urutan berikutnya

    // Format XX menjadi dua digit (01, 02, 03, ...)
    $nomorUrut = str_pad($totalDokumen, 2, "0", STR_PAD_LEFT);

    // Gabungkan untuk mendapatkan id_dokumen
    return $id_pengajuan . $nomorUrut;
}

function generateIdUser4($conn, $id_user) {
    // Ambil jumlah ID yang sudah ada untuk pengguna ini
    $query = "SELECT COUNT(*) AS total FROM tb_user WHERE id_user LIKE '$id_user%'";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);
    $totalCount = $row['total'] + 1; // Urutan berikutnya

    // Format menjadi dua digit (01, 02, 03, ...)
    $counter = str_pad($totalCount, 2, "0", STR_PAD_LEFT);

    // Gabungkan untuk mendapatkan id_user4
    return $id_user . $counter;
}


function uploadFile($file) {
    $target_dir = "../assets/doc/";  // Update path here
    $target_file = $target_dir . basename($file["name"]);
    
    // Pindahkan file ke folder tujuan
    move_uploaded_file($file["tmp_name"], $target_file);
    
    // Mengembalikan array dengan path dan nama file
    return [
        'path' => $target_file,
        'name' => basename($file["name"])
    ];
}
