<?php
include "../koneksi.php";

include "../layout/sidebarUser.php";

// Query hanya menampilkan data pengajuan magang berdasarkan id_user dari sesi
$sql = "SELECT * FROM tb_pengajuan 
        JOIN tb_profile_user ON tb_pengajuan.id_user = tb_profile_user.id_user
        JOIN tb_pendidikan ON tb_profile_user.id_pendidikan = tb_pendidikan.id_pendidikan
        JOIN tb_instansi ON tb_pengajuan.id_instansi = tb_instansi.id_instansi
        JOIN tb_bidang ON tb_pengajuan.id_bidang = tb_bidang.id_bidang
        WHERE tb_pengajuan.status_active = 'Y' 
        AND tb_pengajuan.id_user = '$id_user'";  // Menampilkan hanya data user yang sedang login
$query = mysqli_query($conn, $sql);
$no = 1;
?>

<div class="main-content p-4">
    <div class="container-fluid">
        <!-- Heading Dashboard -->
        <h1 class="mb-4">Daftar Kegiatan</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active">Tabel Kegiatan Aktif</li>
        </ol>
        <div class="mb-4 dropdown-divider"></div>

        <!-- Tabel -->
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
                        <th class="text-center">Periode Magang</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                <?php while($row = mysqli_fetch_assoc($query)): ?> 
                    <tr>
                        <td class="text-center"><?= $no++; ?></td> 
                        <td><?= $row['nama_user'] ?></td> 
                        <td><?= $row['nama_pendidikan'] ?></td> 
                        <td><?= $row['nama_panjang'] ?></td> 
                        <td><?= $row['nama_bidang'] ?></td> 
                        <td class="text-center">
                            <?php 
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
                        <td>
                            <?= date('d F Y', strtotime($row['tanggal_mulai'])) . ' - ' . date('d F Y', strtotime($row['tanggal_selesai'])) ?>
                        </td>
                        <td class="text-center">
                            <a href="detail_aktif.php" class="text-decoration-none" title="Lihat Detail">
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
