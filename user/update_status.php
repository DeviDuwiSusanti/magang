<?php
// Ambil tanggal hari ini
$tanggal_sekarang = date('Y-m-d');

// 1. Ubah status dari 'Diterima' (2) ke 'Berlangsung' (4) jika tanggal mulai <= hari ini
$query_mulai = "UPDATE tb_pengajuan 
                SET status_pengajuan = 4 
                WHERE status_pengajuan = 2 
                AND tanggal_mulai <= '$tanggal_sekarang'";

mysqli_query($conn, $query_mulai);

// 2. Ubah status_pengajuan dari 'Berlangsung' (4) ke 'Selesai' (5) jika tanggal selesai <= hari ini
$query_selesai = "UPDATE tb_pengajuan 
                  SET status_pengajuan = 5 
                  WHERE status_pengajuan = 4 
                  AND tanggal_selesai <= '$tanggal_sekarang'";

mysqli_query($conn, $query_selesai);
?>
