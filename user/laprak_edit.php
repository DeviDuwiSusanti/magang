<?php
include '../koneksi.php'; 
include '../layout/sidebarUser.php';


if (isset($_GET['id_dokumen'])) {
    $id_dokumen = $_GET['id_dokumen'];
    
    // ngambil data laporan berdasarkan id_dokumen
    $query = "SELECT * FROM tb_dokumen WHERE id_dokumen = '$id_dokumen'";
    $result = mysqli_query($conn, $query);
    $data = mysqli_fetch_assoc($result);
    
    if (!$data) {
        echo "<script>alert('Data tidak ditemukan!'); window.location.href='laprak_daftar.php';</script>";
        exit;
    }
} else {
    echo "<script>alert('ID tidak ditemukan!'); window.location.href='laprak_daftar.php';</script>";
    exit;
}

// Jika form disubmit
if (isset($_POST['update'])) {
    $nama_dokumen = $_POST['nama_dokumen'];
    $jenis_dokumen = $_POST['jenis_dokumen'];
    
    $updateQuery = "UPDATE tb_dokumen SET nama_dokumen='$nama_dokumen', jenis_dokumen='$jenis_dokumen' WHERE id_dokumen='$id_dokumen'";
    
    if (mysqli_query($conn, $updateQuery)) {
        echo "<script>alert('Data berhasil diperbarui!'); window.location.href='laprak_daftar.php';</script>";
    } else {
        echo "<script>alert('Terjadi kesalahan!');</script>";
    }
}
?>

<div class="main-content p-3">
    <div class="container-fluid">
        <h1 class="mb-4">Edit Laporan Akhir</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active">Perbarui Laporan Akhir</li>
        </ol>
        <div class="mb-4 dropdown-divider"></div>
        <form method="POST">
            <div class="mb-3">
                <label for="nama_dokumen" class="form-label">Nama Dokumen</label>
                <input type="text" class="form-control" id="nama_dokumen" name="nama_dokumen" value="<?php echo $data['nama_dokumen']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="jenis_dokumen" class="form-label">Jenis Dokumen</label>
                <input type="text" class="form-control" id="jenis_dokumen" name="jenis_dokumen" value="<?php echo $data['jenis_dokumen']; ?>" required>
            </div>
            <button type="submit" name="update" class="btn btn-primary">Update</button>
            <a href="laprak_daftar.php" class="btn btn-secondary">Batal</a>
        </form>
    </div>
</div>

<?php include "../layout/footerDashboard.php"; ?>