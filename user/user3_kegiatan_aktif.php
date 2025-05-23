<?php
include "../koneksi.php"; 
include "../layout/sidebarUser.php";
include "functions.php";

// Ambil daftar pengajuan magang berdasarkan id_user
if ($_SESSION['ketua']) { // Ketua kelompok level (3)
    $sql = "SELECT * 
            FROM tb_pengajuan 
            LEFT JOIN tb_instansi ON tb_pengajuan.id_instansi = tb_instansi.id_instansi 
            LEFT JOIN tb_bidang ON tb_pengajuan.id_bidang = tb_bidang.id_bidang
            WHERE tb_pengajuan.status_pengajuan = '4' AND tb_pengajuan.id_user = '$id_user'";
} else if ($_SESSION['anggota']) { // Anggota kelompok level (4)
    $sql = "SELECT p.*, i.nama_panjang, b.nama_bidang
            FROM tb_profile_user pu
            JOIN tb_user u ON pu.id_user = u.id_user
            JOIN tb_pengajuan p ON pu.id_pengajuan = p.id_pengajuan
            JOIN tb_bidang b ON p.id_bidang = b.id_bidang
            JOIN tb_instansi i ON p.id_instansi = i.id_instansi
            WHERE pu.id_user = '$id_user' 
            AND p.status_pengajuan = '4'";
}

$query = mysqli_query($conn, $sql);
$no = 1;
?>

<div class="main-content p-4">
    <div class="container-fluid">
        <h1 class="mb-4">Daftar Kegiatan Aktif</h1>
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
                <?php while ($data = mysqli_fetch_assoc($query)) { 
                    // Query Detail Pengajuan untuk Modal
                    $id_pengajuan = $data['id_pengajuan'];
                    $sql1 = "SELECT * FROM tb_pengajuan 
                             JOIN tb_instansi ON tb_pengajuan.id_instansi = tb_instansi.id_instansi 
                             JOIN tb_bidang ON tb_pengajuan.id_bidang = tb_bidang.id_bidang
                             WHERE tb_pengajuan.id_pengajuan = '$id_pengajuan'";
                    $query1 = mysqli_query($conn, $sql1);
                    $detail = mysqli_fetch_assoc($query1);

                    // Query Detail Profile User
                    $sql2 = "SELECT * FROM tb_profile_user pu 
                             INNER JOIN tb_user u ON pu.id_user = u.id_user 
                             INNER JOIN tb_pendidikan p ON pu.id_pendidikan = p.id_pendidikan
                             WHERE pu.id_user = '$id_user'";
                    $query2 = mysqli_query($conn, $sql2);
                    $profile = mysqli_fetch_assoc($query2);
                ?>
                    <tr>
                        <td class="text-center"><?= $no++ ?></td>
                        <td><?= htmlspecialchars($data['nama_panjang']) ?></td>
                        <td><?= htmlspecialchars($data['nama_bidang']) ?></td>
                        <td><?= hitungDurasi($data['tanggal_mulai'], $data['tanggal_selesai']) ?></td>
                        <td><?= formatPeriode($data['tanggal_mulai'], $data['tanggal_selesai']) ?></td>                        
                        <td class="text-center">
                            <a href="#" class="btn btn-sm btn-primary" title="Lihat Detail" data-bs-toggle="modal" data-bs-target="#modalDetail<?= $row['id_pengajuan']; ?>">
                                <i class="bi bi-eye"></i>
                            </a>
                        </td>
                    </tr>
                    
                    <!-- Modal Detail -->
                    <div class="modal fade" id="modalDetail<?= $data['id_pengajuan']; ?>" tabindex="-1" aria-labelledby="modalDetailLabel<?= $data['id_pengajuan']; ?>" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="modalDetailLabel<?= $data['id_pengajuan']; ?>">Detail Kegiatan Aktif</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                <img src="../assets/img/logo_kab_sidoarjo.png" 
                                    class="mb-3" 
                                    alt="Profile Picture" 
                                    style="width: 100px; height: 100px;">
                                    <h4 class="card-title"><?= isset($detail['nama_panjang']) ? $detail['nama_panjang'] : 'Tidak Diketahui' ?></h4>
                                    <hr>
                                    <p><strong>Instansi:</strong> <?= htmlspecialchars($detail['nama_panjang'] ?? "Tidak Diketahui") ?></p>
                                    <p><strong>Bidang:</strong> <?= htmlspecialchars($detail['nama_bidang'] ?? "Tidak Diketahui") ?></p>
                                    <p><strong>Jenis Pengajuan:</strong> <?= htmlspecialchars($detail['jenis_pengajuan'] ?? "Tidak Diketahui") ?></p>
                                    <p><strong>Status Lamaran:</strong> <?= isset($detail['status_pengajuan']) ? getStatusText($detail['status_pengajuan']) : "Tidak Diketahui" ?></p>
                                    <p><strong>Durasi:</strong> <?= isset($detail['tanggal_mulai'], $detail['tanggal_selesai']) ? hitungDurasi($detail['tanggal_mulai'], $detail['tanggal_selesai']) : "Tidak Diketahui" ?></p>
                                    <p><strong>Periode Magang:</strong> <?= isset($detail['tanggal_mulai'], $detail['tanggal_selesai']) ? formatPeriode($detail['tanggal_mulai'], $detail['tanggal_selesai']) : "Tidak Diketahui" ?></p>
                                </div>

                                <!-- Tombol Aksi dalam Modal -->
                                <div class="modal-footer flex-column align-items-start">
                                    <div class="d-flex justify-content-end w-100 mt-2">
                                        <button type="button" class="btn btn-danger btn-sm px-3" data-bs-dismiss="modal">Tutup</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php } ?>
                <?php if (mysqli_num_rows($query) == 0): ?>
                    <tr>
                        <td colspan="6" class="text-center">Tidak ada histori kegiatan.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
            </table>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<?php include "../layout/footerDashboard.php"; ?>
