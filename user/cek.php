<?php
include '../koneksi.php'; // pastikan koneksi ke database

if (isset($_POST['email'])) {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $id_userEdit = isset($_POST['id_userEdit']) ? mysqli_real_escape_string($conn, $_POST['id_userEdit']) : '';

    // Cek email, abaikan jika itu email user yang sedang diedit
    $query = "SELECT id_user FROM tb_user WHERE email = '$email'";
    if (!empty($id_userEdit)) {
        $query .= " AND id_user != '$id_userEdit'"; // abaikan email user yang sedang diedit
    }

    $result = mysqli_query($conn, $query);
    echo (mysqli_num_rows($result) > 0) ? "exists" : "available";
}

// Cek Tanggal Logbook (Tambah & Edit)
if (isset($_POST['tanggal']) && isset($_POST['id_user']) && isset($_POST['id_pengajuan'])) {
    $tanggal = mysqli_real_escape_string($conn, $_POST['tanggal']);
    $id_user = mysqli_real_escape_string($conn, $_POST['id_user']);
    $id_pengajuan = mysqli_real_escape_string($conn, $_POST['id_pengajuan']);
    $tanggal_lama = isset($_POST['tanggal_lama']) ? mysqli_real_escape_string($conn, $_POST['tanggal_lama']) : '';

    $query = "SELECT 1 FROM tb_logbook WHERE tanggal_logbook = '$tanggal' AND id_user = '$id_user' AND id_pengajuan = '$id_pengajuan'";

    if (!empty($tanggal_lama)) {
        $query .= " AND tanggal_logbook != '$tanggal_lama'";
    }

    $result = mysqli_query($conn, $query);
    $response = ['exists' => mysqli_num_rows($result) > 0];

    echo json_encode($response);
}


?>
