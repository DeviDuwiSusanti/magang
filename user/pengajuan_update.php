<?php
// UPDATE
if (ISSET($_POST['update_pengajuan'])){
    // Hapus dari tb_profile_user berdasarkan id_pengajuan dan level = 4
    $hapus_anggota = "DELETE tb_user, tb_profile_user FROM tb_user
    INNER JOIN tb_profile_user ON tb_user.id_user = tb_profile_user.id_user
    WHERE tb_profile_user.id_pengajuan = '$id_pengajuan' AND tb_user.level = '4'";
    mysqli_query($conn, $hapus_anggota);


    $id_instansi = $_POST['id_instansi'];
    $id_bidang = $_POST['id_bidang'];
    $jenis_pengajuan = $_POST['jenis_pengajuan'];
    $tanggal_mulai = $_POST['tanggal_mulai'];
    $tanggal_selesai = $_POST['tanggal_selesai'];
    $jumlahAnggota = $_POST['jumlah_anggota'];
    $ktp = $_FILES['ktp'];
    $cv = $_FILES['cv'];

    // MASUKKAN ANGGOTA YANG BARU
    if (ISSET($_POST['anggota_nama'])){
        // Mengambil data anggota dari form Step 2
       $anggota_nama = $_POST['anggota_nama'];
       $anggota_email = $_POST['anggota_email'];
       $anggota_nik = $_POST['anggota_nik'];
       $anggota_nim = $_POST['anggota_nim'];

       foreach ($anggota_nama as $index => $nama) {
           $email = $anggota_email[$index];
           $nik = $anggota_nik[$index];
           $nim = $anggota_nim[$index];
           $id_user4 = generateIdUser4($conn, $id_user);

           $pendidikan = "SELECT id_pendidikan FROM tb_profile_user WHERE id_user = '$id_user'";
           $result = mysqli_query($conn, $pendidikan);
           $id_pendidikan = mysqli_fetch_assoc($result)['id_pendidikan'];
       
           $sql_anggota1 = "INSERT INTO tb_profile_user (id_user, nama_user, nik_user, nisn, nim, id_pengajuan, id_pendidikan, create_by) VALUES ('$id_user4', '$nama', '$nik', '$nim', '$nim', '$id_pengajuan', '$id_pendidikan', '$id_user')";
           $query_anggota1 = mysqli_query($conn, $sql_anggota1);
           
           $sql_anggota2 = "INSERT INTO tb_user (id_user, email, level, create_by) VALUES ('$id_user4', '$email', 4, '$id_user')";
           $query_anggota2 = mysqli_query($conn, $sql_anggota2);
       }
   }

// UPDATE PENGAJUAN
    $sql_update1 = "UPDATE tb_pengajuan SET 
    id_instansi = '$id_instansi',
    id_bidang = '$id_bidang',
    jenis_pengajuan = '$jenis_pengajuan',
    tanggal_mulai = '$tanggal_mulai',
    tanggal_selesai = '$tanggal_selesai',
    jumlah_pelamar = '$jumlahAnggota' WHERE id_pengajuan = '$id_pengajuan' AND id_user = '$id_user'";
    $query_update1 = mysqli_query($conn, $sql_update1);


    // Proses update KTP
    if (!empty($_FILES['ktp']['name'])) {
        deleteOldDocument($conn, $jenis_pengajuan, $id_user, 'identitas');
        $ktpData = uploadFile($_FILES['ktp']);
        if ($ktpData) {
            $sql_updateKTP = "UPDATE tb_dokumen SET file_path = '$ktpData[path]' WHERE nama_dokumen = 'ktp' AND id_pengajuan = '$id_pengajuan'";
            $updateKTP = mysqli_query($conn, $sql_updateKTP);
        }
    }

    // Proses update CV
    if (!empty($_FILES['cv']['name'])) {
        deleteOldDocument($conn, $jenis_pengajuan, $id_user, 'identitas');
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