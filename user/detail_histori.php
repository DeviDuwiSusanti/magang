<?php
include "../koneksi.php"; 
include "../layout/sidebarUser.php";
include "functions.php";  

$id_pengajuan = $_GET['id_pengajuan'];
// Query untuk mengambil detail pengajuan berdasarkan id_pengajuan
$sql = "SELECT *
        FROM tb_pengajuan JOIN tb_instansi ON tb_pengajuan.id_instansi = tb_instansi.id_instansi JOIN tb_bidang ON tb_pengajuan.id_bidang = tb_bidang.id_bidang
        WHERE tb_pengajuan.id_pengajuan = '$id_pengajuan'";

$query = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($query);

$sql2 = "SELECT * 
         FROM tb_profile_user pu INNER JOIN tb_user u ON pu.id_user = u.id_user INNER JOIN tb_pendidikan p ON pu.id_pendidikan = p.id_pendidikan
         WHERE pu.id_user = '$id_user' AND u.id_user = '$id_user'";
$query2 = mysqli_query($conn, $sql2);
$row2 = mysqli_fetch_assoc($query2);

// Jika pengajuan tidak ditemukan, redirect kembali
if (!$row) {
    echo "<script>alert('Data pengajuan tidak ditemukan!'); window.location.href='status_pengajuan.php';</script>";
    exit;
}
?>

<div class="main-content p-4">
    <div class="container-fluid">
        <h1 class="mb-4">Lengkapi Dokumen</h1>
        <ol class="breadcrumb mb-3">
            <li class="breadcrumb-item active">Lengkapi Dokumen Persyaratan</li>
        </ol>

        <div class="dropdown-divider"></div>
        <div class="mb-4 text-end">
            <a href="histori.php" class="btn btn-danger">
                <i class="bi bi-arrow-left-circle me-1"></i> Kembali
            </a>
        </div>
        
        <div class="container mt-5 mb-5">
        <div class="card mx-auto position-relative" style="max-width: 600px;">
        <div class="card-body text-center">
            <img src="../assets/img/user/<?= !empty($row2['gambar_user']) ? $row2['gambar_user'] : 'avatar.png' ?>" 
                 class="rounded-circle mb-3" 
                 alt="Profile Picture" 
                 style="width: 100px; height: 100px;">
            <h4 class="card-title"><?= isset($row2['nama_user']) ? $row2['nama_user'] : 'Tidak Diketahui' ?></h4>
            <p class="text-muted"><?= isset($row2['email']) ? $row2['email'] : 'Tidak Ada Email' ?></p>

            <hr>
            <div class="card-body">
                        <!-- Tabel informasi pengguna -->
                        <table class="table">
                            <tbody class="text-start">
                                <tr>
                                    <td><i class="bi bi-person"></i> <strong>Nama</strong></td>
                                    <td><?= isset($row2['nama_user']) ? $row2['nama_user'] : 'Tidak Diketahui' ?></td>
                                </tr>
                                <tr>
                                    <td><i class="bi bi-mortarboard"></i> <strong>Universitas</strong></td>
                                    <td><?= isset($row2['nama_pendidikan']) ? $row2['nama_pendidikan'] : 'Tidak Diketahui' ?></td>
                                </tr>
                                <tr>
                                    <td><i class="bi bi-building"></i> <strong>Perusahaan</strong></td>
                                    <td><?= isset($row['nama_panjang']) ? $row['nama_panjang'] : 'Tidak Diketahui' ?></td>
                                </tr>
                                <tr>
                                    <td><i class="bi bi-shield-lock"></i> <strong>Bidang</strong></td>
                                    <td><?= isset($row['nama_bidang']) ? $row['nama_bidang'] : 'Tidak Diketahui' ?></td>
                                </tr>
                                <tr>
                                    <td><i class="bi bi-hourglass-split"></i> <strong>Durasi</strong></td>
                                    <td>
                                    <?= hitungDurasi($row['tanggal_mulai'], $row['tanggal_selesai']) ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td><i class="bi bi-calendar-event"></i> <strong>Periode Magang</strong></td>
                                        <td>
                                            <?= formatPeriode($row['tanggal_mulai'], $row['tanggal_selesai']) ?>
                                        </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <!-- Tombol untuk unggah logbook dan laporan akhir -->
                    <div class="d-flex justify-content-center gap-2 mt-4">
                    <a href="path/to/sertifikat.pdf" class="btn btn-outline-primary btn-sm px-3" download>
                        <i class="bi bi-printer"></i> Sertifikat & Nilai
                    </a>
                    <a href="laprak_daftar.php?id_pengajuan=<?= $row['id_pengajuan'] ?>&id_user=<?= $id_user ?>" class="btn btn-outline-info btn-sm px-3">
                        <i class="bi bi-book"></i> Laporan
                    </a>
                    <a href="logbook_daftar.php?id_pengajuan=<?= $row['id_pengajuan'] ?>&id_user=<?= $id_user ?>" class="btn btn-outline-info btn-sm px-3">
                        <i class="bi bi-book"></i> Logbook
                    </a>
                </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include "../layout/footerDashboard.php";?>