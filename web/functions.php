<?php
function getBidangInstansi($conn, $limit = NULL) {
    // Query dasar dengan pengurutan berdasarkan create_date terbaru
    $sql = "SELECT tb_bidang.*, tb_instansi.*, tb_bidang.create_date AS bidang_create_date, tb_bidang.change_date AS bidang_change_date 
            FROM tb_bidang, tb_instansi 
            WHERE tb_bidang.status_active = '1' AND tb_bidang.kuota_bidang != 0 
            AND tb_bidang.id_instansi = tb_instansi.id_instansi AND tb_bidang.status_active = '1' AND tb_instansi.status_active = '1'
            ORDER BY tb_bidang.create_date DESC"; // DESC untuk urutan terbaru ke terlama
    
    // Jika parameter limit diberikan, tambahkan LIMIT ke query
    if ($limit) {
        $sql .= " LIMIT $limit";
    }

    return mysqli_query($conn, $sql);
}


// Pemagang aktif dari 1 instansi tiap bidang
function getPemagangAktif1($conn, $id_instansi, $id_bidang) {
    $sql = "SELECT SUM(jumlah_pelamar) as total_pemagang FROM tb_pengajuan WHERE status_pengajuan = '4' AND id_instansi = '$id_instansi' 
            AND id_bidang = '$id_bidang'";

    $result = mysqli_query($conn, $sql);
    $count1 = mysqli_fetch_assoc($result); // Ambil hasil COUNT(*)
    $pemagangAktif = $count1['total_pemagang'];
    
    if ($pemagangAktif){
        return $pemagangAktif;
    }else{
        return 0;
    }
}

// Jumlah total pemagang aktif dari 1 instansi
function getPemagangAktif2($conn, $id_instansi) {
    $sql = "SELECT SUM(jumlah_pelamar) as total_pemagang FROM tb_pengajuan WHERE status_pengajuan = '4' AND id_instansi = '$id_instansi'";

    $result = mysqli_query($conn, $sql);
    $count1 = mysqli_fetch_assoc($result); // Ambil hasil COUNT(*)
    $pemagangAktif = $count1['total_pemagang'];
    if ($pemagangAktif){
        return $pemagangAktif;
    }else{
        return 0;
    }

}

function formatTanggalIndonesia($tanggal) {
    $bulan = [
        "Januari", "Februari", "Maret", "April", "Mei", "Juni", 
        "Juli", "Agustus", "September", "Oktober", "November", "Desember"
    ];
    $dateObj = DateTime::createFromFormat('Y-m-d', substr($tanggal, 0, 10));
    return $dateObj ? $dateObj->format('d') . ' ' . $bulan[(int)$dateObj->format('m') - 1] . ' ' . $dateObj->format('Y') : "Format Tidak Valid";
}
