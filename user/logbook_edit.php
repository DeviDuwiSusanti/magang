<?php include "../layout/sidebarUser.php"; 
if (ISSET($_GET['id_logbook'])){
    $id_logbook = $_GET['id_logbook'];
    $id_pengajuan = $_GET['id_pengajuan'];
    
    $sql = "SELECT * FROM tb_logbook WHERE id_logbook = '$id_logbook'";
    $query = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($query);
}

if (ISSET($_POST['update_logbook'])){
    $sql2 = "UPDATE tb_logbook SET 
    tanggal_logbook = '$_POST[tanggal]',
    kegiatan_logbook = '$_POST[kegiatan]',
    keterangan_logbook = '$_POST[keterangan]' WHERE id_logbook = '$id_logbook'";

    $query2 = mysqli_query($conn, $sql2);
    if ($query2){
        echo "<script> alert('Logbook Berhasil DiUpdate'); window.location.href='logbook_daftar.php?id_pengajuan={$id_pengajuan}&id_user={$id_user}'; </script>";
    }
}
?>


<div class="main-content p-4">
    <div class="container-fluid">
        <!-- Heading Dashboard -->
        <h1 class="mb-4">Edit Logbook</h1>
        <ol class="breadcrumb mb-4 d-flex justify-content-between align-items-center">
            <li class="breadcrumb-item active">Edit Logbook Harian</li>
        </ol>
        <div class="dropdown-divider mb-3"></div>
        
        <form action="" class="form-profile" method="POST" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="tanggal" class="form-label">Tanggal</label>
                <input type="date" class="form-control" id="tanggal" name="tanggal" value="<?= $row['tanggal_logbook'] ?>">
            </div>
            
            <div class="mb-3">
                <label for="kegiatan" class="form-label">Kegiatan</label>
                <input type="text" class="form-control" id="kegiatan" name="kegiatan" value="<?= $row['kegiatan_logbook'] ?>">
            </div>
            
            <div class="mb-3">
                <label for="keterangan" class="form-label">Keterangan</label>
                <textarea class="form-control" id="keterangan" name="keterangan" rows="3"><?= $row['keterangan_logbook'] ?></textarea>
            </div>
    
            <!-- Tombol Submit -->
            <button type="submit" name="update_logbook" class="btn btn-primary edit"><i class="bi bi-floppy me-1"></i>Simpan</button>
        </form>
    </div>
</div>

<?php include "../layout/footerDashboard.php" ?>