<?php
require '../koneksi.php'; // Koneksi ke database

if (!isset($_GET['id_pengajuan']) || empty($_GET['id_pengajuan'])) {
    echo json_encode(['error' => 'ID pengajuan tidak ditemukan']);
    exit;
}

$id_pengajuan = $_GET['id_pengajuan']; // Ambil ID pengajuan dari AJAX

$sql = "SELECT status_pengajuan FROM tb_pengajuan WHERE id_pengajuan = '$id_pengajuan'";
$result = mysqli_query($conn, $sql);

if ($row = mysqli_fetch_assoc($result)) {
    echo json_encode(['status' => $row['status_pengajuan']]);
} else {
    echo json_encode(['error' => 'Data tidak ditemukan']);
}
?>
