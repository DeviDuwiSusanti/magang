<?php
include "../koneksi.php"; 
include "../layout/sidebarUser.php"; 
 

// Query untuk mengambil data pengajuan magang yang masih aktif dan sesuai dengan id_user yang login
$sql = "SELECT * 
        FROM tb_pengajuan, tb_profile_user, tb_instansi, tb_bidang, tb_pendidikan 
        WHERE tb_pengajuan.id_user = tb_profile_user.id_user
        AND tb_profile_user.id_pendidikan = tb_pendidikan.id_pendidikan
        AND tb_pengajuan.id_instansi = tb_instansi.id_instansi
        AND tb_pengajuan.id_bidang = tb_bidang.id_bidang
        AND tb_pengajuan.status_pengajuan = 'Diterima'
        AND tb_pengajuan.id_user = '$id_user'";  // Menambahkan filter berdasarkan id_user
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
                        <th class="text-center">Periode Magang</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                <?php while ($row = mysqli_fetch_assoc($query)): ?> 
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
                            <a href="detail_aktif.php?id_pengajuan=<?= $row['id_pengajuan'] ?>&id_user=<?= $id_user ?>" class="text-decoration-none" title="Lihat Detail">
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