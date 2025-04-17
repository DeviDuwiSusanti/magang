<?php 
include "../layout/sidebarUser.php";
include '../koneksi.php';
include "functions.php";

define('MAX_FILE_SIZE', 5 * 1024 * 1024); // Maksimum ukuran file 5MB

// Ambil ID User & ID Pengajuan
if (!isset($_SESSION['id_user']) || !isset($_SESSION['id_pengajuan'])) {
    echo "<script>alert('Session tidak ditemukan, silakan login kembali.'); window.location.href='../login.php';</script>";
    exit;
}

$id_user = $_SESSION['id_user'];
$id_pengajuan = $_SESSION['id_pengajuan'];

// Ambil level user
$sql_user = "SELECT level FROM tb_user WHERE id_user = '$id_user'";
$query_user = mysqli_query($conn, $sql_user);
$user_data = mysqli_fetch_assoc($query_user);
$level_user = $user_data['level'] ?? null;

// Cek apakah user ketua atau anggota
$ketua = isset($_SESSION['ketua']) && $_SESSION['ketua'];
$anggota = isset($_SESSION['anggota']) && $_SESSION['anggota'];

// Ambil daftar laporan akhir
$sql = "SELECT d.*, p.nama_user FROM tb_dokumen d 
        JOIN tb_profile_user p ON d.id_user = p.id_user
        WHERE d.jenis_dokumen = '3' 
        AND d.id_pengajuan = '$id_pengajuan' 
        AND d.status_active = 1";

// Jika user adalah anggota, hanya bisa melihat laporannya sendiri
if ($anggota) {
    $sql .= " AND d.id_user = '$id_user'";
}
$result = mysqli_query($conn, $sql);

// Cek apakah user sudah unggah laporan
$sql_cek_laporan = "SELECT COUNT(*) as jumlah FROM tb_dokumen 
                    WHERE id_user = '$id_user' 
                    AND id_pengajuan = '$id_pengajuan'
                    AND jenis_dokumen = '3'
                    AND status_active = 1";
$result_cek_laporan = mysqli_query($conn, $sql_cek_laporan);
$data_cek = mysqli_fetch_assoc($result_cek_laporan);
$laporan_terunggah = $data_cek['jumlah'] > 0;

// Handle Upload Laporan
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES['laporan_akhir'])) {
    $fileType = pathinfo($_FILES['laporan_akhir']['name'], PATHINFO_EXTENSION);
    $fileSize = $_FILES['laporan_akhir']['size'];

    switch (true) {
        case empty($_FILES['laporan_akhir']['name']):
            $msg = "Silakan pilih file terlebih dahulu!";
            $icon = "warning";
            break;
        case $fileType !== 'pdf':
            $msg = "Hanya file PDF yang diperbolehkan!";
            $icon = "error";
            break;
        case $fileSize > MAX_FILE_SIZE:
            $msg = "Ukuran file terlalu besar! Maksimum 5MB.";
            $icon = "error";
            break;
        default:
            // Panggil fungsi uploadFileUser
            $laporan_akhir = uploadFileUser($_FILES['laporan_akhir'], $id_pengajuan);
            if (!isset($laporan_akhir['error'])) {
                $laporan_name = $laporan_akhir['name'];
                $laporan_path = $laporan_akhir['path'];
                $id_dokumen_laporan = generateIdDokumen($conn, $id_pengajuan);
                
                $sql_upload = "INSERT INTO tb_dokumen (id_dokumen, nama_dokumen, jenis_dokumen, file_path, id_pengajuan, id_user, create_by, status_active, create_date, change_date) 
                               VALUES ('$id_dokumen_laporan', '$laporan_name', '3', '$laporan_path', '$id_pengajuan', '$id_user', '$id_user', '1', NOW(), NOW())";

                if (mysqli_query($conn, $sql_upload)) {
                    $msg = "Laporan Akhir Berhasil Diunggah!";
                    $icon = "success";
                } else {
                    $msg = "Laporan Akhir gagal diunggah. Silakan coba lagi.";
                    $icon = "error";
                }
            } else {
                $msg = $laporan_akhir['error'];
                $icon = "error";
            }
    }

    echo "<script>
        Swal.fire({
            icon: '$icon',
            title: '$msg',
        }).then(() => { window.location.href = 'laprak_daftar.php'; });
    </script>";
    exit;
}


// Tambahkan skrip hapus file
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['hapus_laporan'])) {
    $id_dokumen = $_POST['id_dokumen'];

    // Ambil data file berdasarkan id_dokumen
    $sql_get_file = "SELECT file_path, id_user FROM tb_dokumen WHERE id_dokumen = '$id_dokumen'";
    $result_get_file = mysqli_query($conn, $sql_get_file);
    $file_data = mysqli_fetch_assoc($result_get_file);

    // Cek apakah data ditemukan
    if ($file_data) {
        $file_path = $file_data['file_path'];

        // Pastikan hanya user yang mengunggah bisa menghapus
        if ($file_data['id_user'] == $id_user) {
            // Hapus file jika ada
            if (file_exists($file_path) && is_file($file_path)) {
                unlink($file_path);
            }

            // Update status di database
            $sql_update = "UPDATE tb_dokumen SET status_active = 0 WHERE id_dokumen = '$id_dokumen'";
            if (mysqli_query($conn, $sql_update)) {
                echo "<script>
                    Swal.fire({
                        icon: 'success',
                        title: 'Laporan berhasil dihapus!',
                    }).then(() => { window.location.href = 'laprak_daftar.php'; });
                </script>";
            } else {
                echo "<script>
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal menghapus laporan!',
                    });
                </script>";
            }
        } else {
            echo "<script>
                Swal.fire({
                    icon: 'error',
                    title: 'Anda tidak memiliki izin untuk menghapus laporan ini!',
                });
            </script>";
        }
    } else {
        echo "<script>
            Swal.fire({
                icon: 'error',
                title: 'Laporan tidak ditemukan!',
            });
        </script>";
    }
}
?>

<div class="main-content p-3">
    <div class="container-fluid">
        <h1 class="mb-4">Daftar Laporan Akhir Kegiatan Anda</h1>
        <div class="mb-4 dropdown-divider"></div>

        <div class="mb-4 text-end">
        <?php if (!$laporan_terunggah): ?>
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#uploadModal">
                <i class="bi bi-plus-circle me-1"></i>
                Tambah Laporan Akhir
            </button>
        <?php endif; ?>
        </div>

        <div class="table-responsive-sm">
        <div class="bungkus">
            <table class="table table-striped table-bordered table-hover">
                <thead>
                    <tr>
                        <th class="text-center">No</th>
                        <th class="text-center">Tanggal</th>
                        <th class="text-center">Nama Dokumen</th>
                        <th class="text-center">Pemilik Laporan</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (mysqli_num_rows($result) > 0): 
                        $no = 1;
                        while ($row2 = mysqli_fetch_assoc($result)): ?>
                            <tr>
                                <td class="text-center"><?= $no++ ?></td>
                                <td class="text-center"><?= isset($row2['create_date']) ? date('d/m/Y', strtotime($row2['create_date'])) : '-' ?></td>
                                <td>
                                    <a href="<?= $row2['file_path'] ?? '#' ?>" target="_blank">
                                        <?= htmlspecialchars($row2['nama_dokumen'] ?? 'Tidak diketahui') ?>
                                    </a>
                                </td>
                                <td class="text-center"><?= htmlspecialchars($row2['nama_user'] ?? 'Tidak diketahui') ?></td>
                                <td class="text-center">
                                    <?php if ($row2['id_user'] == $id_user): ?>
                                        <form method="POST" action="" onsubmit="return konfirmasiHapus(event, this);">
                                            <input type="hidden" name="id_dokumen" value="<?= $row2['id_dokumen'] ?>">
                                            <input type="hidden" name="hapus_laporan" value="1"> <!-- Tambahkan input hidden -->
                                            <button type="submit" class="btn btn-danger btn-sm">
                                                <i class="bi bi-trash"></i> Hapus
                                            </button>
                                        </form>
                                    <!-- Tambahkan SweetAlert -->
                                    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
                                    <script>
                                        function konfirmasiHapus(event, form) {
                                            event.preventDefault(); // Mencegah submit langsung
                                            Swal.fire({
                                                title: "Apakah Anda yakin?",
                                                text: "Laporan yang dihapus tidak dapat dikembalikan!",
                                                icon: "warning",
                                                showCancelButton: true,
                                                confirmButtonColor: "#d33",
                                                cancelButtonColor: "#3085d6",
                                                confirmButtonText: "Ya, hapus!",
                                                cancelButtonText: "Batal"
                                            }).then((result) => {
                                                if (result.isConfirmed) {
                                                    form.submit(); // Submit form setelah konfirmasi
                                                }
                                            });
                                        }
                                    </script>
                                    <?php else: ?>
                                        <button class="btn btn-secondary btn-sm" disabled>
                                            <i class="bi bi-trash"></i> Hapus
                                        </button>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endwhile; 
                    else: ?>
                        <tr><td colspan="5" class="text-center">Tidak ada laporan akhir.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        </div>
    </div>
</div>

<!-- Modal Upload -->
<div class="modal fade" id="uploadModal" tabindex="-1" aria-labelledby="uploadModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="uploadForm" action="" method="POST" enctype="multipart/form-data">
                <div class="modal-header">
                    <h5 class="modal-title">Unggah Laporan Akhir</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="file" class="form-control" name="laporan_akhir" id="fileInput">
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Unggah</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function () {
    document.getElementById("uploadForm").addEventListener("submit", function (e) {
        if (!document.getElementById("fileInput").value) {
            e.preventDefault();
            Swal.fire({
                icon: 'warning',
                title: 'Silakan pilih file terlebih dahulu!',
            });
        }
    });
});
</script>

<?php include "../layout/footerDashboard.php"; ?>