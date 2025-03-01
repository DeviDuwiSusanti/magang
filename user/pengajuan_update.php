<?php
include "../koneksi.php";
include "functions.php";
// UPDATE
if (ISSET($_POST['update_pengajuan'])){

    $id_user = $_POST['id_user'];
    $id_pengajuan = $_POST['id_pengajuan'];
    $id_user = $_POST['id_user'];
    $id_instansi = $_POST['id_instansi'];
    $id_bidang = $_POST['id_bidang'];
    $jenis_pengajuan = $_POST['jenis_pengajuan'];
    $tanggal_mulai = $_POST['tanggal_mulai'];
    $tanggal_selesai = $_POST['tanggal_selesai'];
    $ktp = $_FILES['ktp'];
    $cv = $_FILES['cv'];

// UPDATE PENGAJUAN
    $sql_update1 = "UPDATE tb_pengajuan SET 
    id_instansi = '$id_instansi',
    id_bidang = '$id_bidang',
    jenis_pengajuan = '$jenis_pengajuan',
    tanggal_mulai = '$tanggal_mulai',
    tanggal_selesai = '$tanggal_selesai'
    WHERE id_pengajuan = '$id_pengajuan'";
    $query_update1 = mysqli_query($conn, $sql_update1);


    // Proses update KTP
    if (!empty($_FILES['ktp']['name'])) {
        deleteOldDocument($conn, $jenis_pengajuan, $id_user, '1');
        $ktpData = uploadFile($_FILES['ktp']);
        if ($ktpData) {
            $sql_updateKTP = "UPDATE tb_dokumen SET file_path = '$ktpData[path]' WHERE nama_dokumen = 'ktp' AND id_pengajuan = '$id_pengajuan'";
            $updateKTP = mysqli_query($conn, $sql_updateKTP);
        }
    }

    // Proses update CV
    if (!empty($_FILES['cv']['name'])) {
        deleteOldDocument($conn, $jenis_pengajuan, $id_user, '1');
        $cvData = uploadFile($_FILES['cv']);
        if ($cvData) {
            $id_dokumen = generateIdDokumen($conn, $jenis_pengajuan);
            $sql_updateCV = "UPDATE tb_dokumen SET file_path = '$cvData[path]' WHERE nama_dokumen = 'cv' AND id_pengajuan = '$id_pengajuan'";
            $updateCV = mysqli_query($conn, $sql_updateCV);
        }
    } 

    if ($query_update1){
        echo "<script> alert('Pengajuan Berhasil DiUpdate')</script>";
        echo "<script> window.location.href='status_pengajuan.php' </script>";
     }else{
         echo "<script> alert('Update Pengajuan Gagal') </script>";
     }
}