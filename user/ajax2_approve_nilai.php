<?php

include '../functions.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['id_nilai'])) {
    $id_nilai = $_POST['id_nilai'];
    $tanda_tangan_admin = $_POST['tanda_tangan_admin'];
    $id_admin = $_POST['id_admin'];
    
    $query = "UPDATE tb_nilai SET 
                tanda_tangan_admin = '$tanda_tangan_admin',
                id_admin_approve = '$id_admin',
                tanggal_approve = NOW(),
                status_approve = '1'
                WHERE id_nilai = '$id_nilai'";
    
    if (mysqli_query($conn, $query)) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'error' => mysqli_error($conn)]);
    }
} else {
    echo json_encode(['success' => false, 'error' => 'Invalid request']);
}
?>