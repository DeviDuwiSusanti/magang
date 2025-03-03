<?php
include "../koneksi.php"; 
include "../layout/sidebarUser.php"; 
include "functions.php"; 

// Query untuk mengambil daftar pengajuan magang yang masih aktif berdasarkan id_user
if ($level == '3'){
    $sql = "SELECT * 
            FROM tb_pengajuan LEFT JOIN tb_instansi ON tb_pengajuan.id_instansi = tb_instansi.id_instansi LEFT JOIN tb_bidang ON tb_pengajuan.id_bidang = tb_bidang.id_bidang
            WHERE tb_pengajuan.status_pengajuan = '5' AND tb_pengajuan.id_user = '$id_user'";
}else if ($level == '4'){
    $sql = "SELECT * FROM tb_pengajuan, tb_profile_user pu, tb_user u, tb_pengajuan p, tb_bidang b, tb_instansi i 
            WHERE tb_pengajuan.status_pengajuan = '5' AND pu.id_user = '$id_user' AND u.id_user = '$id_user' AND pu.id_pengajuan = p.id_pengajuan AND p.id_bidang = b.id_bidang AND p.id_instansi = i.id_instansi";
}
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
                        <td><?= $data['nama_panjang'] ?></td>
                        <td><?= $data['nama_bidang'] ?></td>
                        <td class="text-center">
                            <?php 
                                if (!empty($data['tanggal_mulai']) && !empty($data['tanggal_selesai'])) {
                                    $start_date = new DateTime($data['tanggal_mulai']);
                                    $end_date = new DateTime($data['tanggal_selesai']);
                                    $interval = $start_date->diff($end_date);
                                    
                                    $months = $interval->m + ($interval->y * 12);
                                    $days = $interval->d;
                                    
                                    echo "$months Bulan" . ($days > 0 ? " $days Hari" : "");
                                } else {
                                    echo "Durasi Tidak Diketahui";
                                } 
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
                <?php if (mysqli_num_rows($query) == 0): ?>
                    <tr>
                        <td colspan="7" class="text-center">Tidak ada histori kegiatan.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
            </table>
        </div>
    </div>
</div>
<?php include "../layout/footerDashboard.php"; ?>