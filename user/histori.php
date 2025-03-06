<?php
include "../koneksi.php"; 
include "../layout/sidebarUser.php"; 
include "functions.php"; 

// Query untuk mengambil daftar pengajuan magang yang masih aktif berdasarkan id_user
if ($level == '3'){
    $sql = "SELECT * 
            FROM tb_pengajuan 
            LEFT JOIN tb_instansi ON tb_pengajuan.id_instansi = tb_instansi.id_instansi 
            LEFT JOIN tb_bidang ON tb_pengajuan.id_bidang = tb_bidang.id_bidang
            WHERE tb_pengajuan.status_pengajuan = '5' AND tb_pengajuan.id_user = '$id_user'";
} else if ($level == '4'){
    $sql = "SELECT * 
    FROM tb_profile_user pu, tb_user u, tb_pengajuan p, tb_bidang b, tb_instansi i 
    WHERE pu.id_user = '$id_user' 
    AND u.id_user = '$id_user' 
    AND pu.id_pengajuan = p.id_pengajuan 
    AND p.id_bidang = b.id_bidang 
    AND p.id_instansi = i.id_instansi 
    AND p.status_pengajuan = '5'";
}

$query = mysqli_query($conn, $sql);
$no = 1;
?>

<div class="main-content p-4">
    <div class="container-fluid">
        <h1 class="mb-4">Daftar Histori Kegiatan</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active">Tabel Histori Kegiatan</li>
        </ol>
        <div class="mb-4 dropdown-divider"></div>

        <div class="bungkus">
            <table class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th class="text-center">No</th>
                        <th class="text-center">Perusahaan</th>
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
                        <td><?= htmlspecialchars($data['nama_panjang']) ?></td>
                        <td><?= htmlspecialchars($data['nama_bidang']) ?></td>
                        <td>
                             <?= hitungDurasi($row['tanggal_mulai'], $row['tanggal_selesai']) ?>
                        </td> 
                        <td>
                            <?= formatPeriode($row['tanggal_mulai'], $row['tanggal_selesai']) ?>
                        </td>                       
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
