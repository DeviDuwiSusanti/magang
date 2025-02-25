<?php
include "../koneksi.php"; 
include "../layout/sidebarUser.php"; 

// Query untuk mengambil daftar pengajuan magang yang masih aktif berdasarkan id_user
$sql = "SELECT *
        FROM tb_pengajuan, tb_profile_user, tb_user, tb_instansi, tb_bidang
        WHERE tb_pengajuan.id_user = tb_profile_user.id_user
        AND tb_profile_user.id_user = tb_user.id_user
        AND tb_pengajuan.id_instansi = tb_instansi.id_instansi
        AND tb_pengajuan.id_bidang = tb_bidang.id_bidang
        AND tb_pengajuan.status_active = 'Y' 
        AND tb_pengajuan.id_user = '$id_user'";

$query = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($query);
?>

<div class="main-content p-4">
    <div class="container-fluid">
        <!-- Heading Dashboard -->
        <h1 class="mb-4">Lengkapi Dokumen</h1>
        <ol class="breadcrumb mb-3">
            <li class="breadcrumb-item active">Lengkapi Dokumen Persyaratan</li>
        </ol>

        <!-- Tombol Kembali -->
        <div class="dropdown-divider"></div>
        <div class="mb-4 text-end">
            <a href="status_pengajuan.php" class="btn btn-danger">
                <i class="bi bi-arrow-left-circle me-1"></i> Kembali
            </a>
        </div>
        
        <div class="container mt-5 mb-5">
            <div class="card mx-auto position-relative" style="max-width: 600px;">
                <div class="card-body top text-center">
                <img src="../assets/img/user/<?= !empty($row['gambar_user']) ? $row['gambar_user'] : 'avatar.png' ?>" 
                class="rounded-circle mb-3" 
                alt="Profile Picture" 
                style="width: 100px; height: 100px;">
                <h4 class="card-title"><?= isset($row['nama_user']) ? $row['nama_user'] : 'Tidak Diketahui' ?></h4>
                    <p class="text-muted"><?= isset($row['email']) ? $row['email'] : 'Tidak Ada Email' ?></p>

                    <hr>
                    <div class="card-body">
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
                                    <td><?= isset($row['status_pengajuan']) ? $row['status_pengajuan'] : 'Status tidak diketahui'; ?></td>
                                </tr>
                                <tr>
                                    <td><i class="bi bi-hourglass-split"></i> <strong>Durasi</strong></td>
                                    <td>
                                        <?php 
                                            if (!empty($row['tanggal_mulai']) && !empty($row['tanggal_selesai'])) {
                                                $start_date = new DateTime($row['tanggal_mulai']);
                                                $end_date = new DateTime($row['tanggal_selesai']);
                                                $interval = $start_date->diff($end_date);
                                                
                                                $months = $interval->m + ($interval->y * 12);
                                                $days = $interval->d;
                                                
                                                echo "$months Bulan" . ($days > 0 ? " $days Hari" : "");
                                            } else {
                                                echo "Durasi Tidak Diketahui";
                                            } 
                                        ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td><i class="bi bi-calendar-event"></i> <strong>Periode</strong></td>
                                    <td>
                                        <?php 
                                            if (!empty($row['tanggal_mulai']) && !empty($row['tanggal_selesai'])) {
                                                echo date('d F Y', strtotime($row['tanggal_mulai'])) . ' - ' . date('d F Y', strtotime($row['tanggal_selesai']));
                                            } else {
                                                echo "Periode Tidak Diketahui";
                                            }
                                        ?>
                                    </td>
                                </tr>
                            </tbody>
                        </table>

                        <!-- Tombol kecil di pojok kanan bawah -->
                        <a href="persyaratan_unggah.php?id_pengajuan=<?= $row['id_pengajuan'] ?>&id_user=<?= $id_user ?>" class="btn btn-sm btn-primary position-absolute" style="bottom: 10px; left: 10px;">
                            <i class="bi bi-upload"></i> Lengkapi Dokumen
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include "../layout/footerDashboard.php"; ?>