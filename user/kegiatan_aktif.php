<?php
include "../koneksi.php"; 
include "../layout/sidebarUser.php"; 
include "functions.php"; 

// Pastikan session telah dimulai jika $id_user berasal dari session
$id_user = $_SESSION['id_user'] ?? null;

if (!$id_user) {
    echo "<script>alert('Silakan login terlebih dahulu'); window.location.href='login.php';</script>";
    exit;
}

// Query untuk mengambil data pengajuan magang yang masih aktif sesuai dengan id_user yang login
$sql = "SELECT * 
        FROM tb_pengajuan 
        LEFT JOIN tb_profile_user ON tb_pengajuan.id_pengajuan = tb_profile_user.id_pengajuan 
        LEFT JOIN tb_pendidikan ON tb_profile_user.id_pendidikan = tb_pendidikan.id_pendidikan 
        LEFT JOIN tb_user ON tb_pengajuan.id_user = tb_user.id_user 
        LEFT JOIN tb_instansi ON tb_pengajuan.id_instansi = tb_instansi.id_instansi 
        LEFT JOIN tb_bidang ON tb_pengajuan.id_bidang = tb_bidang.id_bidang 
        WHERE tb_pengajuan.status_pengajuan = '4' AND tb_profile_user.id_user = '$id_user'";

$query = mysqli_query($conn, $sql);
$no = 1;
?>

<div class="main-content p-4">
    <div class="container-fluid">
        <h1 class="mb-4">Daftar Kegiatan</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active">Tabel Kegiatan Aktif</li>
        </ol>
        <div class="mb-4 dropdown-divider"></div>

        <div class="bungkus">
            <table class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th class="text-center">No</th>
                        <th class="text-center">Nama</th>
                        <th class="text-center">Pendidikan</th>
                        <th class="text-center">Perusahaan</th>
                        <th class="text-center">Bidang</th>
                        <th class="text-center">Durasi</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                <?php if (mysqli_num_rows($query) > 0): ?>
                    <?php while ($row = mysqli_fetch_assoc($query)): ?> 
                        <tr>
                            <td class="text-center"><?= $no++; ?></td> 
                            <td><?= htmlspecialchars($row['nama_user'] ?? 'Data tidak tersedia') ?></td> 
                            <td><?= htmlspecialchars($row['nama_pendidikan'] ?? 'Data tidak tersedia') ?></td> 
                            <td><?= htmlspecialchars($row['nama_panjang'] ?? 'Data tidak tersedia') ?></td> 
                            <td><?= htmlspecialchars($row['nama_bidang'] ?? 'Data tidak tersedia') ?></td> 
                            <td class="text-center">
                                <?php 
                                    if (!empty($row['tanggal_mulai']) && !empty($row['tanggal_selesai'])) {
                                        $start_date = DateTime::createFromFormat('Y-m-d', $row['tanggal_mulai']);
                                        $end_date = DateTime::createFromFormat('Y-m-d', $row['tanggal_selesai']);

                                        if ($start_date && $end_date) {
                                            $interval = $start_date->diff($end_date);
                                            $months = $interval->m + ($interval->y * 12);
                                            $days = $interval->d;
                                            echo "$months Bulan" . ($days > 0 ? " $days Hari" : "");
                                        } else {
                                            echo "Format Tanggal Tidak Valid";
                                        }
                                    } else {
                                        echo "Durasi Tidak Diketahui";
                                    } 
                                ?>
                            </td>
                            <td class="text-center">
                                <a href="detail_histori.php?id_pengajuan=<?= $data['id_pengajuan'] ?>" class="text-decoration-none" title="Lihat Detail">
                                    <i class="bi bi-eye" style="font-size: 20px;"></i>
                                </a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="8" class="text-center">Tidak ada kegiatan yang aktif.</td>
                    </tr>
                <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php include "../layout/footerDashboard.php"; ?>