<?php 
include "sidebar.php";

if(isset($_GET["id_instansi"])) {
    $id_instansi = $_GET["id_instansi"];
    
    if(hapus_instansi($id_instansi, $id_user)) { 
        echo "<script>hapus_instansi_super_admin_success()</script>";
    } else { 
        echo "<script>hapus_instansi_super_admin_gagal()</script>";
    }
} else {
    echo "<script>alert('ID Instansi tidak ditemukan!'); window.location.href='instansi_view.php';</script>";
}
?>