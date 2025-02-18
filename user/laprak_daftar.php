<?php 
include "../layout/sidebarUser.php";
include '../koneksi.php';  // Pastikan file koneksi ke database sudah benar

$id_user = $_SESSION['id_user'];  // Ambil ID user dari session

// Query untuk mengambil data laporan dari database
$sql = "SELECT * FROM tb_dokumen WHERE id_user = '$id_user' AND jenis_dokumen = 'laprak'";
$result = mysqli_query($conn, $sql);
?>

<div class="main-content p-3">
    <div class="container-fluid">
        <h1 class="mb-4">Daftar Laporan Akhir</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active">Daftar Laporan Akhir Kegiatan Anda</li>
        </ol>
        <div class="mb-4 dropdown-divider"></div>
        <div class="mb-4 text-end">
            <a href="laprak_unggah.php?id_user=<?= $id_user ?>" class="btn btn-primary">
                <i class="bi bi-plus-circle me-1"></i>
                Tambah Laporan Akhir
            </a>
        </div>
        <div class="table-responsive-sm">
            <div class="bungkus-2">
                <table id="myTable" class="table table-striped table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Tanggal</th>
                            <th>Nama Dokumen</th>
                            <th>Jenis Dokumen</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if (mysqli_num_rows($result) > 0) {
                            $no = 1;
                            while ($row = mysqli_fetch_assoc($result)) {
                                echo "<tr>";
                                echo "<td>" . $no++ . "</td>";
                                echo "<td>" . date('d/m/Y', strtotime($row['create_date'])) . "</td>"; 
                                
                                // Menampilkan nama file sebagai link
                                echo "<td><a href='" . $row['file_path'] . "' target='_blank'>" . $row['nama_dokumen'] . "</a></td>";

                                echo "<td>" . $row['jenis_dokumen'] . "</td>"; 
                                echo "<td>
                                        <a href='laprak_edit.php?id_dokumen=" . $row['id_dokumen'] . "' class='btn btn-warning btn-sm'>
                                            <i class='bi bi-pencil'></i> Edit
                                        </a>
                                        <a href='laprak_hapus.php?id_dokumen=" . $row['id_dokumen'] . "' onclick='return confirm(\"Anda yakin akan menghapus laporan ini?\")' class='btn btn-danger btn-sm'>
                                            <i class='bi bi-trash'></i> Hapus
                                        </a>
                                      </td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='5' class='text-center'>Tidak ada laporan yang tersedia.</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php include "../layout/footerDashboard.php"; ?>