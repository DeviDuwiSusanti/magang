<?php 
include "../layout/sidebarUser.php"; 
include "functions.php";  // Pastikan untuk meng-include file functions.php

define('MAX_FILE_SIZE', 5 * 1024 * 1024); // Maksimum ukuran file 5MB

if (!empty($_GET['id_user']) && !empty($_GET['id_pengajuan'])) {
    $id_user = $_GET['id_user'];
    $id_pengajuan = $_GET['id_pengajuan'];
} else {
    echo "<script>alert('ID User atau ID Pengajuan tidak ditemukan.'); window.history.back();</script>";
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES['laporan_akhir'])) {
    $fileType = pathinfo($_FILES['laporan_akhir']['name'], PATHINFO_EXTENSION);
    $fileSize = $_FILES['laporan_akhir']['size'];

    if ($fileType !== 'pdf') {
        echo "<script>alert('Hanya file PDF yang diperbolehkan!'); window.history.back();</script>";
        exit;
    }

    if ($fileSize > MAX_FILE_SIZE) {
        echo "<script>alert('Ukuran file terlalu besar! Maksimum 5MB.'); window.history.back();</script>";
        exit;
    }

    if ($fileSize > 0) { // Pastikan file dipilih
        $laporan_akhir = uploadFile($_FILES['laporan_akhir']); 

        if (!isset($laporan_akhir['error'])) {
            $laporan_name = $laporan_akhir['name'];
            $laporan_path = $laporan_akhir['path'];
            $id_dokumen_laporan = generateIdDokumen($conn, $id_user); 

            $sql = "INSERT INTO tb_dokumen (id_dokumen, nama_dokumen, jenis_dokumen, file_path, id_pengajuan, id_user, create_by, status_active, create_date, change_date) 
                    VALUES ('$id_dokumen_laporan', '$laporan_name', '3', '$laporan_path', '$id_pengajuan', '$id_user', '$id_user', '1', NOW(), NOW())";

            if (mysqli_query($conn, $sql)) {
                showAlert('Berhasil!', 'Laporan Akhir Berhasil Diunggah', 'success', "laprak_daftar.php?id_pengajuan={$id_pengajuan}&id_user={$id_user}");
                exit();
            } else {
                showAlert('Gagal!', 'Laporan Akhir gagal diunggah. Silakan coba lagi.', 'error');
            }    
        } else {
            echo "<script>alert('".$laporan_akhir['error']."');</script>";
        }
    } else {
        echo "<script>alert('Silakan pilih file laporan sebelum mengunggah.');</script>";
    }
}
?>

<div class="main-content p-4">
    <div class="container-fluid">
        <h1 class="mb-4">Unggah Laporan Akhir</h1>
        <ol class="breadcrumb mb-4 d-flex justify-content-between align-items-center">
            <li class="breadcrumb-item active">Unggah Laporan Kegiatan</li>
            <a href="laprak_daftar.php?id_user=<?= $id_user ?>" class="btn btn-secondary">Lihat Daftar Laporan Akhir</a>
        </ol>
        <div class="dropdown-divider"></div><br><br>

        <form action="" class="form-profile" method="POST" enctype="multipart/form-data" onsubmit="return validateForm()">
            <div class="mb-3">
                <label for="laporan_akhir" class="form-label">Unggah Laporan Akhir (PDF, Maks 5MB)</label>
                <input type="file" class="form-control" id="laporan_akhir" name="laporan_akhir">
                <small class="text-danger font-weight-bold">
                Gunakan format nama file: <strong>Nama_Bidang_Instansi_LaporanAkhir.pdf</strong>
                </small>
            </div>
            <button type="submit" name="submit_laporan" class="btn btn-primary">Unggah Laporan</button>
        </form>
    </div>
</div>

<script>
function validateForm() {
    let fileInput = document.getElementById('laporan_akhir');
    
    if (fileInput.files.length === 0) {
        alert('Silakan pilih file laporan sebelum mengunggah.');
        return false;
    }
    
    let file = fileInput.files[0];
    let allowedExtensions = /\.pdf$/i;
    let maxSize = 5 * 1024 * 1024; // 5MB

    if (!allowedExtensions.exec(file.name)) {
        alert("Hanya file PDF yang diperbolehkan!");
        return false;
    }

    if (file.size > maxSize) {
        alert("Ukuran file terlalu besar! Maksimum 5MB.");
        return false;
    }

    return true;
}
</script>

<?php include "../layout/footerDashboard.php"; ?>
