<?php
function getBidangInstansi($conn) {
    $sql = "SELECT tb_bidang.*, tb_instansi.*, tb_bidang.change_date AS bidang_change_date FROM tb_bidang, tb_instansi 
            WHERE tb_bidang.status_active = 'Y' 
            AND tb_bidang.id_instansi = tb_instansi.id_instansi";
    return mysqli_query($conn, $sql);
}

// Pemagang aktif dari 1 instansi tiap bidang
function getPemagangAktif1($conn, $id_instansi, $id_bidang) {
    $sql = "SELECT COUNT(*) FROM tb_pengajuan WHERE status_active = 'Y' AND status_pengajuan = 'Diterima' AND id_instansi = '$id_instansi' 
            AND id_bidang = '$id_bidang'";

    $result = mysqli_query($conn, $sql);
    $count1 = mysqli_fetch_array($result)[0]; // Ambil hasil COUNT(*)

    return $count1;
}

// Jumlah total pemagang aktif dari 1 instansi
function getPemagangAktif2($conn, $id_instansi) {
    $sql = "SELECT COUNT(*) FROM tb_pengajuan WHERE status_active = 'Y' AND status_pengajuan = 'Diterima' AND id_instansi = '$id_instansi'";

    $result = mysqli_query($conn, $sql);
    $count2 = mysqli_fetch_array($result)[0]; // Ambil hasil COUNT(*)

    return $count2;
}