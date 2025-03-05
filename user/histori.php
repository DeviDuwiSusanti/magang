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
            FROM tb_pengajuan 
            LEFT JOIN tb_profile_user pu ON tb_pengajuan.id_user = pu.id_user 
            LEFT JOIN tb_user u ON tb_pengajuan.id_user = u.id_user
            LEFT JOIN tb_bidang b ON tb_pengajuan.id_bidang = b.id_bidang 
            LEFT JOIN tb_instansi i ON tb_pengajuan.id_instansi = i.id_instansi 
            WHERE tb_pengajuan.status_pengajuan = '5' AND pu.id_user = '$id_user'";
}
$query = mysqli_query($conn, $sql);
$no = 1;

// Fungsi untuk format tanggal ke format Indonesia tanpa tahun
function formatTanggalIndonesia($tanggal) {
    $bulan = [
        "Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"
    ];
    if (!empty($tanggal)) {
        $dateObj = DateTime::createFromFormat('Y-m-d', $tanggal);
        return $dateObj ? $dateObj->format('d') . ' ' . $bulan[(int)$dateObj->format('m') - 1] : "Format Tidak Valid";
    }
    return "Tanggal Tidak Diketahui";
}

// Fungsi untuk format periode (contoh: "1 Januari - 10 Desember 2024" atau "1 Desember 2023 - 10 Januari 2024")
function formatPeriode($tanggal_mulai, $tanggal_selesai) {
    if (empty($tanggal_mulai) || empty($tanggal_selesai)) {
        return "Periode Tidak Diketahui";
    }

    $start_date = DateTime::createFromFormat('Y-m-d', $tanggal_mulai);
    $end_date = DateTime::createFromFormat('Y-m-d', $tanggal_selesai);

    if (!$start_date || !$end_date) {
        return "Periode Tidak Valid";
    }

    if ($start_date->format('Y') === $end_date->format('Y')) {
        return formatTanggalIndonesia($tanggal_mulai) . ' - ' . formatTanggalIndonesia($tanggal_selesai) . ' ' . $start_date->format('Y');
    } else {
        return formatTanggalIndonesia($tanggal_mulai) . ' ' . $start_date->format('Y') . ' - ' . formatTanggalIndonesia($tanggal_selesai) . ' ' . $end_date->format('Y');
    }
}
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
                        <td><?= htmlspecialchars($data['nama_panjang']) ?></td>
                        <td><?= htmlspecialchars($data['nama_bidang']) ?></td>
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
                        <td>
                            <?php 
                            if (!empty($data['tanggal_mulai']) && !empty($data['tanggal_selesai'])) {
                                echo formatPeriode($data['tanggal_mulai'], $data['tanggal_selesai']);
                            } else {
                                echo "<span style='color:red; font-weight:bold;'>Periode Tidak Diketahui</span>";
                            }
                            ?>
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
