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
?>
