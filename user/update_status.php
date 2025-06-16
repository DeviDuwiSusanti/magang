<?php
include '../koneksi.php';
date_default_timezone_set("Asia/Jakarta");
$tanggal_sekarang = date("Y-m-d");

// === 1. Ubah status dari 'Diterima' (2) ke 'Berlangsung' (4) ===
$query_mulai = "UPDATE tb_pengajuan 
                SET status_pengajuan = 4 
                WHERE status_pengajuan = 2 
                AND tanggal_mulai <= ?";
$stmt = mysqli_prepare($conn, $query_mulai);
mysqli_stmt_bind_param($stmt, "s", $tanggal_sekarang);
if (!mysqli_stmt_execute($stmt)) {
    die("Gagal update status ke 'Berlangsung': " . mysqli_error($conn));
}
mysqli_stmt_close($stmt);

// === 2. Ubah status 'Berlangsung' (4) ke 'Selesai' (5) ===
$query_selesai = "UPDATE tb_pengajuan 
                  SET status_pengajuan = 5 
                  WHERE status_pengajuan = 4 
                  AND COALESCE(tanggal_extend, tanggal_selesai) < ?";
$stmt2 = mysqli_prepare($conn, $query_selesai);
mysqli_stmt_bind_param($stmt2, "s", $tanggal_sekarang);
if (!mysqli_stmt_execute($stmt2)) {
    die("Gagal update status ke 'Selesai': " . mysqli_error($conn));
}
mysqli_stmt_close($stmt2);

// === 3. Pengurangan kuota jika belum dikurangi ===
$query_data = "SELECT id_pengajuan, id_bidang, jumlah_pelamar 
               FROM tb_pengajuan 
               WHERE status_pengajuan = 4 
               AND tanggal_mulai <= '$tanggal_sekarang' 
               AND kuota_dikurangi = 0";

$result = mysqli_query($conn, $query_data);
if (!$result) {
    die("Gagal ambil data pengajuan: " . mysqli_error($conn));
}

while ($row = mysqli_fetch_assoc($result)) {
    $id_pengajuan = $row['id_pengajuan'];
    $id_bidang = $row['id_bidang'];
    $jumlah = (int) $row['jumlah_pelamar'];

    mysqli_begin_transaction($conn); // Mulai transaksi

    try {
        // 3a. Kurangi kuota bidang
        $update_kuota = "UPDATE tb_bidang 
                         SET kuota_bidang = kuota_bidang - ? 
                         WHERE id_bidang = ? 
                         AND kuota_bidang >= ?";
        $stmt_kuota = mysqli_prepare($conn, $update_kuota);
        mysqli_stmt_bind_param($stmt_kuota, "isi", $jumlah, $id_bidang, $jumlah);
        mysqli_stmt_execute($stmt_kuota);
        if (mysqli_stmt_affected_rows($stmt_kuota) === 0) {
            throw new Exception("Kuota tidak mencukupi untuk bidang $id_bidang");
        }
        mysqli_stmt_close($stmt_kuota);

        // 3b. Update flag kuota_dikurangi
        $update_flag = "UPDATE tb_pengajuan 
                        SET kuota_dikurangi = 1 
                        WHERE id_pengajuan = ?";
        $stmt_flag = mysqli_prepare($conn, $update_flag);
        mysqli_stmt_bind_param($stmt_flag, "i", $id_pengajuan);
        mysqli_stmt_execute($stmt_flag);
        mysqli_stmt_close($stmt_flag);

        mysqli_commit($conn); // Commit jika semua sukses
        echo "Berhasil update pengajuan ID $id_pengajuan dan kurangi kuota bidang $id_bidang<br>";

    } catch (Exception $e) {
        mysqli_rollback($conn); // Rollback jika gagal
        echo "Gagal proses pengajuan ID $id_pengajuan: " . $e->getMessage() . "<br>";
    }
}

mysqli_close($conn);
?>
