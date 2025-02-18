<?php
include "../layout/sidebarUser.php";
include '../koneksi.php';

$id_user = $_SESSION['id_user'];  // Ambil ID user dari session

// Query untuk mendapatkan daftar dokumen dengan jenis 'persyaratan' yang sudah diunggah
$sql = "SELECT * FROM tb_dokumen WHERE id_user = '$id_user' AND jenis_dokumen = 'prasyarat'";
$result = mysqli_query($conn, $sql);

// Query untuk mendapatkan id_pengajuan
$query_pengajuan = "SELECT id_pengajuan FROM tb_pengajuan WHERE id_user = '$id_user' LIMIT 1";
$pengajuan_result = mysqli_query($conn, $query_pengajuan);
$pengajuan_row = mysqli_fetch_assoc($pengajuan_result);
$id_pengajuan = $pengajuan_row['id_pengajuan'];
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
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 1;
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo "<tr>
                                    <td>{$no}</td>
                                    <td><a href='{$row['file_path']}' target='_blank'>{$row['nama_dokumen']}</a></td>
                                    <td>{$row['jenis_dokumen']}</td>
                                    <td>{$row['create_date']}</td>
                                  </tr>";
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