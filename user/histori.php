<?php
include "../koneksi.php"; 
include "../layout/sidebarUser.php"; 

// Query untuk mengambil daftar pengajuan magang yang masih aktif berdasarkan id_user
$sql = "SELECT * FROM tb_pengajuan, tb_profile_user, tb_pendidikan, tb_user, tb_instansi, tb_bidang 
        WHERE tb_pengajuan.id_pengajuan = tb_profile_user.id_pengajuan 
        AND tb_profile_user.id_pendidikan = tb_pendidikan.id_pendidikan 
        AND tb_pengajuan.id_instansi = tb_instansi.id_instansi 
        AND tb_pengajuan.id_bidang = tb_bidang.id_bidang 
        AND tb_pengajuan.status_pengajuan = 'Selesai' 
        AND tb_profile_user.id_user = '$id_user'
        AND tb_user.id_user = '$id_user'";  // Menambahkan filter berdasarkan id_user
 

$query = mysqli_query($conn, $sql);
$no = 1;
?>

<div class="main-content p-4">
    <div class="container-fluid">
        <!-- Heading Dashboard -->
        <h1 class="mb-4">Daftar Histori Kegiatan</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active">Tabel Histori Kegiatan</li>
        </ol>
        <div class="mb-4 dropdown-divider"></div>

        <!-- Tabel -->
        <div class="bungkus">
            <table class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th class="text-center">No</th>
                        <th class="text-center">Nama</th>
                        <th class="text-center">Instansi</th>
                        <th class="text-center">Bidang</th>
                        <th class="text-center">Durasi</th>
                        <th class="text-center">Periode Magang</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($data = mysqli_fetch_assoc($query)) { ?>
                        <tr>
                            <td class="text-center"><?= $no++ ?></td>
                            <td><?= $data['nama_user'] ?></td>
                            <td><?= $data['nama_panjang'] ?></td>
                            <td><?= $data['nama_bidang'] ?></td>
                            <td class="text-center">
                                <?php 
                                    $start_date = new DateTime($data['tanggal_mulai']);
                                    $end_date = new DateTime($data['tanggal_selesai']);
                                    $interval = $start_date->diff($end_date);
                                    echo $interval->m + ($interval->y * 12) . " Bulan";
                                ?>
                            </td>   
                            <td><?= date('d F Y', strtotime($data['tanggal_mulai'])) . ' - ' . date('d F Y', strtotime($data['tanggal_selesai'])) ?></td>                       
                            <td class="text-center">
                                <a href="detail_histori.php?id_pengajuan=<?= $data['id_pengajuan'] ?>" class="text-decoration-none" title="Lihat Detail">
                                    <i class="bi bi-eye" style="font-size: 20px;"></i>
                                </a>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php include "../layout/footerDashboard.php"; ?>