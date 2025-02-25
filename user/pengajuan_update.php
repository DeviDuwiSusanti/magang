<?php
// UPDATE
if (ISSET($_POST['update_pengajuan'])){
    $id_instansi = $_POST['id_instansi'];
    $id_bidang = $_POST['id_bidang'];
    $jenis_pengajuan = $_POST['jenis_pengajuan'];
    $tanggal_mulai = $_POST['tanggal_mulai'];
    $tanggal_selesai = $_POST['tanggal_selesai'];
    $jumlahAnggota = $_POST['jumlah_anggota'];
    $ktp = $_FILES['ktp'];
    $cv = $_FILES['cv'];

    $sql_update1 = "UPDATE tb_pengajuan SET 
    id_instansi = '$id_instansi',
    id_bidang = '$id_bidang',
    jenis_pengajuan = '$jenis_pengajuan',
    tanggal_mulai = '$tanggal_mulai',
    tanggal_selesai = '$tanggal_selesai',
    jumlah_pelamar = '$jumlah_anggota' WHERE id_pengajuan = '$id_pengajuan' AND id_user = '$id_user'";
    $query_update1 = mysqli_query($conn, $sql_update1);

    if ($query_update1){
       echo "<script> alert('Pengajuan Berhasil DiUpdate'); window.location.href='status_pengajuan.php </script>";
    }else{
        echo "<script> alert('Update Pengajuan Gagal') </script>";
    }
    // Proses update KTP
    if (!empty($_FILES['ktp']['name'])) {
        deleteOldDocument($conn, $jenis_pengajuan, $id_user, 'identitas');
        $ktpData = uploadFile($_FILES['ktp']);
        if ($ktpData) {
            $id_dokumen = generateIdDokumen($conn, $jenis_pengajuan);
            $sql_insert_ktp = "INSERT INTO tb_dokumen (id_dokumen, id_pengajuan, id_user, nama_dokumen, file_path, jenis_dokumen)
                                VALUES ('$id_dokumen', '$jenis_pengajuan', '$id_user', '{$ktpData['name']}', '{$ktpData['path']}', 'identitas')";
            mysqli_query($conn, $sql_insert_ktp);
        }
    }

    // Proses update CV
    if (!empty($_FILES['cv']['name'])) {
        deleteOldDocument($conn, $jenis_pengajuan, $id_user, 'identitas');
        $cvData = uploadFile($_FILES['cv']);
        if ($cvData) {
            $id_dokumen = generateIdDokumen($conn, $jenis_pengajuan);
            $sql_insert_cv = "INSERT INTO tb_dokumen (id_dokumen, id_pengajuan, id_user, nama_dokumen, file_path, jenis_dokumen)
                              VALUES ('$id_dokumen', '$jenis_pengajuan', '$id_user', '{$cvData['name']}', '{$cvData['path']}', 'identitas')";
            mysqli_query($conn, $sql_insert_cv);
        }
    } 
}