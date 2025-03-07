<?php
include "../koneksi.php"; 
include "../layout/sidebarUser.php";
include "functions.php";  

// Pastikan id_pengajuan tersedia di URL
if (!isset($_GET['id_pengajuan'])) {
    echo "<script>alert('ID Pengajuan tidak ditemukan!'); window.location.href='status_pengajuan.php';</script>";
    exit;
}

$id_pengajuan = $_GET['id_pengajuan'];

// Query untuk mengambil detail pengajuan berdasarkan id_pengajuan
$sql = "SELECT *
        FROM tb_pengajuan
        JOIN tb_profile_user ON tb_profile_user.id_user = '$id_user' 
        JOIN tb_user ON tb_profile_user.id_user = tb_user.id_user
        JOIN tb_instansi ON tb_pengajuan.id_instansi = tb_instansi.id_instansi
        JOIN tb_bidang ON tb_pengajuan.id_bidang = tb_bidang.id_bidang
        WHERE tb_pengajuan.id_pengajuan = '$id_pengajuan'";

$query = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($query);

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
            <a href="status_pengajuan.php" class="btn btn-danger">
                <i class="bi bi-arrow-left-circle me-1"></i> Kembali
            </a>
        </div>
        
        <div class="container mt-5 mb-5">
            <div class="card mx-auto position-relative" style="max-width: 600px;">
                <div class="card-body text-center">
                    <img src="../assets/img/user/<?= !empty($row['gambar_user']) ? $row['gambar_user'] : 'avatar.png' ?>" 
                         class="rounded-circle mb-3" 
                         alt="Profile Picture" 
                         style="width: 100px; height: 100px;">
                    <h4 class="card-title"><?= isset($row['nama_user']) ? $row['nama_user'] : 'Tidak Diketahui' ?></h4>
                    <p class="text-muted"><?= isset($row['email']) ? $row['email'] : 'Tidak Ada Email' ?></p>

                    <hr>
                    <table class="table">
                        <tbody class="text-start">
                            <tr>
                                <td><i class="bi bi-building"></i> <strong>Perusahaan</strong></td>
                                <td><?= isset($row['nama_panjang']) ? $row['nama_panjang'] : 'Data tidak tersedia'; ?></td> 
                            </tr>
                            <tr>
                                <td><i class="bi bi-shield-lock"></i> <strong>Bidang</strong></td>
                                <td><?= isset($row['nama_bidang']) ? $row['nama_bidang'] : 'Data tidak tersedia'; ?></td> 
                            </tr>
                            <tr>
                                <td><i class="bi bi-check-circle"></i> <strong>Status Lamaran</strong></td>
                                <td><?= getStatusText($row['status_pengajuan']) ?></td>
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
                    <br>
                    
                    <?php 
                    $status_pengajuan = $row['status_pengajuan'];

                    $disable_all = ($status_pengajuan == 3) ? 'btn-secondary disabled' : 'btn-primary';
                    $disable_upload = ($status_pengajuan != 2) ? 'btn-secondary disabled' : 'btn-primary';
                    $disable_edit = ($status_pengajuan == 2 || $status_pengajuan == 3 || $status_pengajuan == 4 || $status_pengajuan == 5) ? 'btn-secondary disabled' : 'btn-primary';
                    $disable_anggota = ($status_pengajuan == 2 || $status_pengajuan == 3 || $status_pengajuan == 5) ? 'btn-secondary disabled' : 'btn-primary';
                    ?>

                    <a href="persyaratan_daftar.php?id_pengajuan=<?= $id_pengajuan ?>" class="btn btn-sm <?= $disable_upload ?> position-absolute" style="bottom: 10px; left: 10px;">
                        <i class="bi bi-upload"></i> Lengkapi Dokumen
                    </a>

                    <a href="pengajuan_edit.php?id_pengajuan=<?= $id_pengajuan ?>&id_user=<?= $id_user ?>" class="btn btn-sm <?= $disable_edit ?> position-absolute" style="bottom: 10px; left: 200px;">
                        <i class="bi bi-pencil-square"></i> Edit Pengajuan
                    </a>

                    <a href="detail_anggota.php?id_pengajuan=<?= $id_pengajuan ?>" class="btn btn-sm <?= $disable_anggota ?> position-absolute" style="bottom: 10px; left: 360px;">
                        <i class="bi bi-people"></i> Anggota
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include "../layout/footerDashboard.php"; ?>
