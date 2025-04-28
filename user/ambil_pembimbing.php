<?php
include '../koneksi.php'; // kalau perlu

$pengajuan_id = (int) $_POST['pengajuan_id'];

// Cari id_bidang dari pengajuan
$query_pengajuan = "SELECT id_bidang FROM tb_pengajuan WHERE id_pengajuan = $pengajuan_id";
$result_pengajuan = mysqli_query($conn, $query_pengajuan);
$data_pengajuan = mysqli_fetch_assoc($result_pengajuan);
$id_bidang_diajukan = $data_pengajuan['id_bidang'];

// Cari pembimbing sesuai bidang
$query_pembimbing = "SELECT pu.id_user, pu.nama_user, b.nama_bidang
                     FROM tb_user u
                     JOIN tb_profile_user pu ON u.id_user = pu.id_user
                     JOIN tb_bidang b ON pu.id_bidang = b.id_bidang
                     WHERE u.level = 4
                       AND pu.id_bidang = $id_bidang_diajukan
                     ORDER BY pu.nama_user";

$result_pembimbing = mysqli_query($conn, $query_pembimbing);

// Outputkan semua pembimbing sebagai <option>
while ($row = mysqli_fetch_assoc($result_pembimbing)) {
  $nama_user = htmlspecialchars($row['nama_user']);
  $nama_bidang = htmlspecialchars($row['nama_bidang']);
  echo '<option value="'.$row['id_user'].'" data-nama-bidang="'.$nama_bidang.'">'.$nama_user.' - '.$nama_bidang.'</option>';
}

?>
