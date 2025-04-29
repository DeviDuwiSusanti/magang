<?php
include "../koneksi.php";

$id_pengajuan = $_GET['id_pengajuan'];

$query = "SELECT 
            pp.id_pembimbing, 
            pu.nama_user AS nama_pembimbing
          FROM tb_persetujuan_pembimbing pp
          JOIN tb_profile_user pu ON pp.id_pembimbing = pu.id_user
          WHERE pp.id_pengajuan = ?
          AND pp.status_persetujuan = 1";

$stmt = $conn->prepare($query);
$stmt->bind_param("i", $id_pengajuan);
$stmt->execute();
$result = $stmt->get_result();

$data = [];
while ($row = $result->fetch_assoc()) {
    $data[] = $row;
}

header('Content-Type: application/json');
echo json_encode($data);
?>