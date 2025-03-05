<?php
include "../koneksi.php"; 
include "../layout/sidebarUser.php"; 
include "functions.php"; 

if ($level != 3){
    echo "<script> alert('Maaf Anda tidak ada hak akses di halaman ini'); window.location.href='dashboard.php?id_user=$id_user'; </script>";
}

// Query untuk mengambil daftar pengajuan berdasarkan id_user
$sql = "SELECT * 
        FROM tb_pengajuan
        LEFT JOIN tb_instansi ON tb_pengajuan.id_instansi = tb_instansi.id_instansi
        LEFT JOIN tb_bidang ON tb_pengajuan.id_bidang = tb_bidang.id_bidang
        WHERE tb_pengajuan.id_user = '$id_user'";
$query = mysqli_query($conn, $sql); 

// Cek apakah ada pengajuan dengan status 1, 2, atau 4
$sembunyikan_tombol = false;
while ($row_check = mysqli_fetch_assoc($query)) {
    if (in_array($row_check['status_pengajuan'], [1, 2, 4])) {
        $sembunyikan_tombol = true;
        break;
    }
}

// Jalankan ulang query karena mysqli_fetch_assoc sudah digunakan sebelumnya
$query = mysqli_query($conn, $sql);
?>

<div class="main-content p-4">
    <div class="container-fluid">
        <!-- Heading Dashboard -->
        <h1 class="mb-4">Daftar Pengajuan</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active">Tabel Histori Pengajuan</li>
        </ol>
        <div class="mb-4 dropdown-divider"></div>

        <!-- Tombol Tambah Pengajuan (Hanya muncul jika tidak ada status 1, 2, atau 4) -->
        <?php if (!$sembunyikan_tombol): ?>
            <div class="d-flex justify-content-end mb-4">
                <a href="pengajuan.php" class="btn btn-primary">Tambah Pengajuan</a>
            </div>
        <?php endif; ?>

        <!-- Tabel -->
        <div class="bungkus">
            <table class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th class="text-center">No</th>
                        <th class="text-center">Perusahaan</th>
                        <th class="text-center">Bidang</th>
                        <th class="text-center">Jenis Pengajuan</th>
                        <th class="text-center">Status Lamaran</th>
                        <th class="text-center">Durasi</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $no = 1;
                    if (mysqli_num_rows($query) > 0): 
                        while($row = mysqli_fetch_assoc($query)): 
                    ?> 
                    <tr>
                        <td class="text-center"><?= $no++; ?></td>
                        <td><?= isset($row['nama_panjang']) ? $row['nama_panjang'] : 'Data tidak tersedia'; ?></td> 
                        <td><?= isset($row['nama_bidang']) ? $row['nama_bidang'] : 'Data tidak tersedia'; ?></td> 
                        <td><?= isset($row['jenis_pengajuan']) ? $row['jenis_pengajuan'] : 'Data tidak tersedia'; ?></td> 
                        <td><?= getStatusText($row['status_pengajuan']) ?></td>
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
                            <a href="detail_status.php?id_pengajuan=<?= isset($row['id_pengajuan']) ? $row['id_pengajuan'] : '' ?>" 
                                class="text-decoration-none" title="Lihat Detail">
                                <i class="bi bi-eye" style="font-size: 20px;"></i>
                            </a>
                        </td>
                    </tr>
                    <?php 
                        endwhile;
                    else: ?>
                        <tr>
                            <td colspan="7" class="text-center">Tidak ada status pengajuan.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php include "../layout/footerDashboard.php"; ?>
