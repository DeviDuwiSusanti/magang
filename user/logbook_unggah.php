<?php include "../layout/sidebarUser.php"; 

if (ISSET($_GET['id_pengajuan'])){
    $id_pengajuan = $_GET['id_pengajuan'];
}

if (isset($_POST['unggah_logbook'])) {
    $tanggal = $_POST['tanggal'];
    $kegiatan = $_POST['kegiatan'];
    $keterangan = $_POST['keterangan'];

    // Query INSERT, id_logbook tidak perlu dimasukkan karena auto-increment
    $sql = "INSERT INTO tb_logbook (`tanggal_logbook`, `kegiatan_logbook`, `keterangan_logbook`, `id_pengajuan`, `id_user`) VALUES ('$tanggal', '$kegiatan', '$keterangan', '$id_pengajuan', '$id_user')";
    
    $query = mysqli_query($conn, $sql);

    // Cek apakah data berhasil diinput
    if ($query) {
        echo "<script>
        alert('Logbook Berhasil Diunggah');
        window.location.href='logbook_daftar.php?id_pengajuan={$id_pengajuan}&id_user={$id_user}';
        </script>";
        exit();
    } else {
        echo "<script> alert('Gagal') </script>";
    }
}


?>

<div class="main-content p-4">
    <div class="container-fluid">
        <!-- Heading Dashboard -->
        <h1 class="mb-4">Unggah Logbook</h1>
        <ol class="breadcrumb mb-4 d-flex justify-content-between align-items-center">
            <li class="breadcrumb-item active">Unggah Logbook Harian</li>
            <a href="logbook_daftar.php?id_pengajuan=<?= $id_pengajuan ?>" class="btn btn-secondary">Lihat Daftar Logbook</a>
        </ol>
        <div class="dropdown-divider"></div><br><br>
        
         <form action="" class="form-profile" method="POST" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="tanggal" class="form-label">Tanggal</label>
                <input type="date" class="form-control" id="tanggal" name="tanggal">
            </div>
            
            <div class="mb-3">
                <label for="kegiatan" class="form-label">Kegiatan</label>
                <input type="text" class="form-control" id="kegiatan" name="kegiatan" required>
            </div>
            
            <div class="mb-3">
                <label for="keterangan" class="form-label">Keterangan</label>
                <textarea class="form-control" id="keterangan" name="keterangan" rows="3" required></textarea>
            </div>
    
            <!-- Tombol Submit -->
            <button type="submit" name="unggah_logbook" class="btn btn-primary edit"><i class="bi bi-floppy me-1"></i>Simpan</button>
        </form>
    </div>
</div>

<?php include "../layout/footerDashboard.php" ?>