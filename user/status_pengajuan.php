<?php
include "../koneksi.php"; 
include "../layout/sidebarUser.php"; 

// Query untuk mengambil daftar pengajuan magang yang masih aktif berdasarkan id_user
$sql = "SELECT * 
        FROM tb_pengajuan, tb_profile_user, tb_pendidikan, tb_instansi, tb_bidang 
        WHERE tb_pengajuan.id_user = tb_profile_user.id_user 
        AND tb_profile_user.id_pendidikan = tb_pendidikan.id_pendidikan
        AND tb_pengajuan.id_instansi = tb_instansi.id_instansi
        AND tb_pengajuan.id_bidang = tb_bidang.id_bidang
        AND tb_pengajuan.status_active = 'Y' 
        AND tb_pengajuan.id_user = '$id_user'";  

$query = mysqli_query($conn, $sql); 
$no = 1; 
?>

<div class="main-content p-4">
    <div class="container-fluid">
        <!-- Heading Dashboard -->
        <h1 class="mb-4">Daftar Pengajuan</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active">Tabel Histori Pengajuan</li>
        </ol>
        <div class="mb-4 dropdown-divider"></div>

        <!-- Tombol Tambah Pengajuan -->
        <div class="d-flex justify-content-end mb-4">
            <a href="pengajuan.php" class="btn btn-primary">Tambah Pengajuan</a>
        </div>

        <!-- Tabel -->
        <div class="bungkus">
            <table class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th class="text-center">No</th>
                        <th class="text-center">Perusahaan</th>
                        <th class="text-center">Bidang</th>
                        <th class="text-center">Status Lamaran</th>
                        <th class="text-center">Durasi</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while($row = mysqli_fetch_assoc($query)): ?> 
                    <tr>
                        <td class="text-center"><?= $no++; ?></td>
                        <td><?= isset($row['nama_panjang']) ? $row['nama_panjang'] : 'Data tidak tersedia'; ?></td> 
                        <td><?= isset($row['nama_bidang']) ? $row['nama_bidang'] : 'Data tidak tersedia'; ?></td> 
                        <td><?= isset($row['status_pengajuan']) ? $row['status_pengajuan'] : 'Status tidak diketahui'; ?></td>
                        <td class="text-center">
                            <?php 
                                // Hitung durasi magang dalam bulan
                                if (!empty($row['tanggal_mulai']) && !empty($row['tanggal_selesai'])) {
                                    $start_date = new DateTime($row['tanggal_mulai']);
                                    $end_date = new DateTime($row['tanggal_selesai']);
                                    $interval = $start_date->diff($end_date);
                                    echo $interval->m + ($interval->y * 12) . " Bulan";
                                } else {
                                    echo "Durasi Tidak Diketahui";
                                }
                            ?>
                        </td>
                        <td class="text-center">
                            <a href="detail_status.php" class="text-decoration-none" title="Lihat Detail">
                                <i class="bi bi-eye" style="font-size: 20px;"></i>
                            </a>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php include "../layout/footerDashboard.php"; ?>