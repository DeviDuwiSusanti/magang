<?php
include '../koneksi.php'; // pastikan koneksi ke database

if (isset($_POST['email'])) {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $id_userEdit = isset($_POST['id_userEdit']) ? mysqli_real_escape_string($conn, $_POST['id_userEdit']) : '';

    // Cek email, abaikan jika itu email user yang sedang diedit
    $query = "SELECT id_user FROM tb_user WHERE email = '$email' AND status_active = '1'";
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

if (isset($_POST["id_instansi"])) {
    $id_instansi = mysqli_real_escape_string($conn, $_POST["id_instansi"]);

    $sql = "SELECT id_bidang, nama_bidang, kuota_bidang FROM tb_bidang 
            WHERE id_instansi = '$id_instansi' AND kuota_bidang > 0 
            ORDER BY nama_bidang ASC";
    $result = mysqli_query($conn, $sql);

    $options = "";
    while ($row = mysqli_fetch_assoc($result)) {
        $options .= '<option value="'.$row['id_bidang'].'" data-kuota="'.$row['kuota_bidang'].'">'.$row['nama_bidang'].' (Kuota: '.$row['kuota_bidang'].')</option>';
    }

    echo $options ?: '<option value="" disabled>Bidang tidak tersedia</option>';
}

if (isset($_POST["id_bidang"])) {
    $id_bidang = mysqli_real_escape_string($conn, $_POST["id_bidang"]);

    $sql = "SELECT nama_bidang, deskripsi_bidang, kriteria_bidang, dokumen_prasyarat, kuota_bidang 
            FROM tb_bidang 
            WHERE id_bidang = '$id_bidang'";
    $result = mysqli_query($conn, $sql);

    if ($result && mysqli_num_rows($result) > 0) {
        echo json_encode(mysqli_fetch_assoc($result));
    } else {
        echo json_encode(["error" => "Data bidang tidak ditemukan."]);
    }
}
?>
