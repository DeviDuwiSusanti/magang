<?php 
include "../layout/sidebarUser.php"; 
include "functions.php";  // Pastikan untuk meng-include file functions.php

// Pastikan koneksi ke database sudah ada, misalnya:
$conn = mysqli_connect("localhost", "root", "", "magang_database");
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

if (isset($_POST['submit_laporan'])) {
    // Mengambil id_user dari query string atau session
    if (isset($_GET['id_user'])) {
        $id_user = $_GET['id_user'];
    } elseif (isset($_SESSION['id_user'])) {
        $id_user = $_SESSION['id_user'];
    } else {
        echo "<script>alert('id_user tidak ditemukan.');</script>";
        exit;  // Jika id_user tidak ada, hentikan proses
    }

    // Mengambil id_pengajuan dari session
    if (isset($_SESSION['id_pengajuan'])) {
        $id_pengajuan = $_SESSION['id_pengajuan'];
    } else {
        echo "<script>alert('ID Pengajuan tidak ditemukan.');</script>";
        exit;  // Hentikan eksekusi jika id_pengajuan tidak ditemukan
    }
    

    // Validasi file PDF
    if (isset($_FILES['laporan_akhir']) && $_FILES['laporan_akhir']['error'] == 0) {
        $laporan_akhir = uploadFile($_FILES['laporan_akhir']); // Fungsi upload file yang ada di functions.php

        // Dapatkan nama dan path file yang ter-upload
        $laporan_name = $laporan_akhir['name'];
        $laporan_path = $laporan_akhir['path'];

        // Generate ID dokumen berdasarkan id_pengajuan atau id_user
        $id_dokumen_laporan = generateIdDokumen($conn, $id_user); 

        // Simpan informasi dokumen di database, termasuk change_date
        $sql = "INSERT INTO tb_dokumen (id_dokumen, nama_dokumen, jenis_dokumen, file_path, id_pengajuan, id_user, create_by, status_active, create_date, change_date) 
                VALUES ('$id_dokumen_laporan', '$laporan_name', 'laporan', '$laporan_path', $id_pengajuan, '$id_user', '$id_user', 'Y', NOW(), NOW())";

        $query = mysqli_query($conn, $sql);

        if ($query) {
            echo "<script>alert('Laporan berhasil diunggah'); window.location.href='laprak_daftar.php?id_user=$id_user';</script>";
        } else {
            echo "<script>alert('Gagal mengunggah laporan');</script>";
        }
    } else {
        echo "<script>alert('Pilih file laporan terlebih dahulu');</script>";
    }
}
?>

<div class="main-content p-4">
    <div class="container-fluid">
        <!-- Heading Dashboard -->
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
            <!-- Submit Button -->
            <button type="submit" name="submit_laporan" class="btn btn-primary">Unggah Laporan</button>
        </form>
    </div>
</div>

<?php include "../layout/footerDashboard.php"; ?>