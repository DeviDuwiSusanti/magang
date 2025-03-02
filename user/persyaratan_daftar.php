<?php
include "../layout/sidebarUser.php";
include '../koneksi.php';
include "functions.php";

$id_pengajuan = $_GET['id_pengajuan'];

// Query untuk mendapatkan daftar dokumen dengan jenis 'persyaratan' yang sudah diunggah
$sql = "SELECT * FROM tb_dokumen WHERE id_user = '$id_user' AND jenis_dokumen = '2' AND id_pengajuan = '$id_pengajuan'";
$result = mysqli_query($conn, $sql);

// HAPUS PERSYARATAN
if (ISSET($_GET['id_dokumen'])){
    $id_dokumen = $_GET['id_dokumen'];
    $sqlHapus = "DELETE FROM tb_dokumen WHERE id_pengajuan = '$id_pengajuan' AND id_dokumen = '$id_dokumen'";
    // menghapus dokumen fisiknya
    deleteOldDocument($conn, $id_pengajuan, $id_user, '3');

    if (mysqli_query($conn, $sqlHapus)) {
        showAlert('Berhasil!', 'Persyaratan Berhasil Dihapus', 'success', "persyaratan_daftar.php?id_pengajuan={$id_pengajuan}");
        exit();
    } else {
        showAlert('Gagal!', 'Persayaratan gagal dihapus. Silakan coba lagi.', 'error');
    }    
}
?>

<div class="main-content p-3">
    <div class="container-fluid">
        <h1 class="mb-4">Daftar Persyaratan yang Telah Diunggah</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active">Daftar Dokumen Persyaratan</li>
        </ol>
        <div class="mb-4 dropdown-divider"></div>

        <!-- Tombol Unggah Persyaratan Baru -->
        <div class="mb-4 text-end">
            <a href="persyaratan_unggah.php?id_pengajuan=<?= $id_pengajuan ?>&id_user=<?= $id_user ?>" class="btn btn-primary">
                <i class="bi bi-upload me-1"></i> Unggah Persyaratan Baru
            </a>
        </div>

        <div class="table-responsive-sm">
            <div class="bungkus-2">
                <table id="myTable" class="table table-striped table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Dokumen</th>
                            <th>Jenis Dokumen</th>
                            <th>Tanggal Unggah</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 1;
                        while ($row = mysqli_fetch_assoc($result)) {?>
                            <tr>
                                <td><?= $no ?></td>
                                <td><a href="<?= $row['file_path'] ?>" target="_blank"> <?= $row['nama_dokumen'] ?></a></td>
                                <td>Persyaratan</td>
                                <td><?= $row['create_date'] ?></td>
                                <td><a href="?id_dokumen=<?= $row['id_dokumen'] ?>&id_pengajuan=<?= $id_pengajuan ?>" 
                                    onclick="return confirm('Anda yakin akan menghapus Persyaratan ini?')"
                                    class="btn btn-danger btn-sm">
                                        <i class="bi bi-trash"></i> Hapus
                                </a>
                            </tr>
                        <?php
                            $no++;
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php include "../layout/footerDashboard.php"; ?>