<?php 
include "../layout/sidebarUser.php"; 
include "functions.php";  // Pastikan untuk meng-include file functions.php

if (ISSET($_GET['id_user']) && ISSET($_GET['id_pengajuan'])){
    $id_user = $_GET['id_user'];
    $id_pengajuan = $_GET['id_pengajuan'];
}else{
    echo "<script>alert('ID User atau ID Pengajuan tidak ditemukan.'); window.history.back();</script>";

}
    
    // Validasi file PDF
    if (isset($_FILES['laporan_akhir']) && $_FILES['laporan_akhir']['error'] == 0) {
        $laporan_akhir = uploadFile($_FILES['laporan_akhir']); // Fungsi upload file yang ada di functions.php

        // Dapatkan nama dan path file yang ter-upload
        $laporan_name = $laporan_akhir['name'];
        $laporan_path = $laporan_akhir['path'];

        // Generate ID dokumen berdasarkan id_user
        $id_dokumen_laporan = generateIdDokumen($conn, $id_user); 

        // Simpan informasi dokumen di database
        $sql = "INSERT INTO tb_dokumen (id_dokumen, nama_dokumen, jenis_dokumen, file_path, id_pengajuan, id_user, create_by, status_active, create_date, change_date) 
                VALUES ('$id_dokumen_laporan', '$laporan_name', 'laporan', '$laporan_path', '$id_pengajuan', '$id_user', '$id_user', '1', NOW(), NOW())";

        $query = mysqli_query($conn, $sql);

        if ($query) {
            echo "<script>alert('Laporan berhasil diunggah'); window.location.href='laprak_daftar.php?id_user=$id_user';</script>";
        } else {
            echo "<script>alert('Gagal mengunggah laporan');</script>";
        }
    } else {
        echo "<script>alert('Pilih file laporan terlebih dahulu');</script>";
    }
?>

<div class="main-content p-4">
    <div class="container-fluid">
        <h1 class="mb-4">Unggah laporan akhir</h1>
        <ol class="breadcrumb mb-4 d-flex justify-content-between align-items-center">
            <li class="breadcrumb-item active">Unggah laprak Kegiatan</li>
            <a href="laprak_daftar.php?id_user=<?= $id_user ?>" class="btn btn-secondary">Lihat Daftar laporan akhir</a>
        </ol>
        <div class="dropdown-divider"></div><br><br>

        <!-- Form Unggah Laporan -->
        <form action="" class="form-profile" method="POST" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="laporan_akhir" class="form-label">Unggah laporan akhir (PDF)</label>
                <input type="file" class="form-control" id="laporan_akhir" name="laporan_akhir" accept=".pdf" required>
                <small class="text-muted">Pilih file laporan akhir (PDF)</small>
            </div>
            <button type="submit" name="submit_laporan" class="btn btn-primary">Unggah Laporan</button>
        </form>
    </div>
</div>

<?php include "../layout/footerDashboard.php"; ?>
