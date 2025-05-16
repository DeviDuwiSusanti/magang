<?php
include '../koneksi.php';
// Ambil tanggal hari ini
$tanggal_sekarang = date('Y-m-d');

// 1. Ubah status dari 'Diterima' (2) ke 'Berlangsung' (4) jika tanggal mulai <= hari ini
$query_mulai = "UPDATE tb_pengajuan 
                SET status_pengajuan = 4 
                WHERE status_pengajuan = 2 
                AND tanggal_mulai <= '$tanggal_sekarang'";

mysqli_query($conn, $query_mulai);

// 2. Ubah status_pengajuan dari 'Berlangsung' (4) ke 'Selesai' (5) jika tanggal selesai <= hari ini
// Menggunakan COALESCE() untuk mempertimbangkan tanggal_extend jika ada
$query_selesai = "UPDATE tb_pengajuan 
                  SET status_pengajuan = 5 
                  WHERE status_pengajuan = 4 
                  AND COALESCE(tanggal_extend, tanggal_selesai) <= '$tanggal_sekarang'";

mysqli_query($conn, $query_selesai);

// Ambil pengajuan yang berubah jadi 'Berlangsung' dan belum dikurangi kuotanya
$query_data = "SELECT id_pengajuan, id_bidang, jumlah_pelamar 
               FROM tb_pengajuan 
               WHERE status_pengajuan = 4 
               AND tanggal_mulai <= '$tanggal_sekarang'
               AND kuota_dikurangi = 0";

$result = mysqli_query($conn, $query_data);
while ($row = mysqli_fetch_assoc($result)) {
    $id_pengajuan = $row['id_pengajuan'];
    $id_bidang = $row['id_bidang'];
    $jumlah = (int) $row['jumlah_pelamar'];

    // Kurangi kuota bidang
    $update_kuota = "UPDATE tb_bidang 
                     SET kuota_bidang = kuota_bidang - $jumlah 
                     WHERE id_bidang = '$id_bidang' 
                     AND kuota_bidang >= $jumlah";
    mysqli_query($conn, $update_kuota);

    // Tandai bahwa kuota sudah dikurangi
    $update_flag = "UPDATE tb_pengajuan 
                    SET kuota_dikurangi = 1 
                    WHERE id_pengajuan = '$id_pengajuan'";
    mysqli_query($conn, $update_flag);
}
?>
