<?php
include "../koneksi.php"; 
include "../layout/sidebarUser.php";
include "functions.php";

// Initialize user ID from session
$id_user = $_SESSION['id_user'];

//Untuk cetak nilai
if (isset($_GET['cetak'])) {
    $id_pengajuan_cetak = $_GET['cetak'];
    // cetakSertifikat($conn, $id_pengajuan_cetak);
}

// Ambil daftar pengajuan magang berdasarkan id_user
if ($_SESSION['ketua']) { // Ketua kelompok level (3)
    $sql = "SELECT * 
            FROM tb_pengajuan 
            LEFT JOIN tb_instansi ON tb_pengajuan.id_instansi = tb_instansi.id_instansi 
            LEFT JOIN tb_bidang ON tb_pengajuan.id_bidang = tb_bidang.id_bidang
            WHERE tb_pengajuan.status_pengajuan = '5' 
            AND tb_pengajuan.status_active = '1'
            AND tb_pengajuan.id_user = '{$_SESSION['id_user']}'";
} else if ($_SESSION['anggota']) { // Anggota kelompok level (4)
    $sql = "SELECT p.*, i.nama_panjang, b.nama_bidang
            FROM tb_profile_user pu
            JOIN tb_user u ON pu.id_user = u.id_user
            JOIN tb_pengajuan p ON pu.id_pengajuan = p.id_pengajuan
            JOIN tb_bidang b ON p.id_bidang = b.id_bidang
            JOIN tb_instansi i ON p.id_instansi = i.id_instansi
            WHERE pu.id_user = '{$_SESSION['id_user']}' 
            AND p.status_pengajuan = '5'
            AND p.status_active = '1'";
}

$query = mysqli_query($conn, $sql);
$no = 1;
?>

<div class="main-content p-4">
    <div class="container-fluid">
        <h1 class="mb-4">Daftar Histori Kegiatan</h1>
        <div class="mb-4 dropdown-divider"></div>

        <div class="bungkus">
            <table class="table table-bordered table-hover">
            <thead>
                <tr>
                    <th class="text-center">No</th>
                    <th class="text-center">Instansi</th>
                    <th class="text-center">Bidang</th>
                    <th class="text-center">Durasi</th>
                    <th class="text-center">Aksi</th>
                    <th class="text-center">Laporan & Logbook</th>
                </tr>
            </thead>
                <tbody>
                <?php while ($data = mysqli_fetch_assoc($query)) { 
                    $id_pengajuan = $data['id_pengajuan'];

                    // Query Detail Pengajuan untuk Modal
                    $sql1 = "SELECT * FROM tb_pengajuan 
                             JOIN tb_instansi ON tb_pengajuan.id_instansi = tb_instansi.id_instansi 
                             JOIN tb_bidang ON tb_pengajuan.id_bidang = tb_bidang.id_bidang
                             WHERE tb_pengajuan.id_pengajuan = '$id_pengajuan'";
                    $query1 = mysqli_query($conn, $sql1);
                    $detail = mysqli_fetch_assoc($query1);

                    // Query Detail Profile User - perbaikan
                    $sql2 = "SELECT * FROM tb_profile_user pu 
                            INNER JOIN tb_user u ON pu.id_user = u.id_user 
                            INNER JOIN tb_pendidikan p ON pu.id_pendidikan = p.id_pendidikan
                            WHERE pu.id_user = '$id_user'";
                    $query2 = mysqli_query($conn, $sql2);
                    $profile = mysqli_fetch_assoc($query2);

                    // Cek apakah ada nilai untuk pengajuan ini dan sudah diapprove
                    $check_nilai = query("SELECT * FROM tb_nilai 
                                        WHERE id_pengajuan = '$id_pengajuan' 
                                        AND id_user = '$id_user' 
                                        AND status_active = '1'
                                        AND status_approve = '1'");
                    $nilai_approved = !empty($check_nilai);
                ?>
                    <tr>
                        <td class="text-center"><?= $no++ ?></td>
                        <td><?= htmlspecialchars($data['nama_panjang']) ?></td>
                        <td><?= htmlspecialchars($data['nama_bidang']) ?></td>
                        <td><?= hitungDurasi($data['tanggal_mulai'], $data['tanggal_selesai']) ?></td> 
                        <!-- Kolom Aksi -->
                        <td class="text-center">
                            <div class="d-flex gap-1 justify-content-center flex-wrap">
                                <!-- Tombol Detail -->
                                <a href="#" class="btn btn-sm btn-primary" title="Lihat Detail" 
                                data-bs-toggle="modal" data-bs-target="#modalDetail<?= $data['id_pengajuan']; ?>">
                                <i class="bi bi-eye"></i>
                                </a>

                                <?php if($nilai_approved) : ?>
                                    <!-- Tombol Cetak Nilai dan Sertifikat -->
                                    <button type="button" class="btn btn-primary btn-sm px-3" title="Cetak Nilai & Sertifikat" data-bs-toggle="modal" data-bs-target="#printOptions<?= $data['id_pengajuan'] ?>">
                                        <i class="bi bi-printer"></i>
                                    </button>

                                    <!-- Modal Cetak -->
                                    <div class="modal fade" id="printOptions<?= $data['id_pengajuan'] ?>" tabindex="-1" aria-labelledby="printOptionsLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="printOptionsLabel">Pilihan Cetak</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body text-center">
                                                    <!-- Tombol Cetak Sertifikat -->
                                                    <a href="user3_cetak_sertifikat.php?id_user_ini=<?= $id_user ?>&id_pengajuan=<?= $data['id_pengajuan'] ?>" class="btn btn-primary m-2" target="_blank">
                                                        <i class="bi bi-file-earmark-text me-2"></i>Cetak Sertifikat
                                                    </a>
                                                    
                                                    <!-- Tombol Cetak Nilai -->
                                                    <a href="user3_cetak_nilai.php?id_user_ini=<?= $id_user ?>&id_pengajuan=<?= $data['id_pengajuan'] ?>" class="btn btn-success m-2" target="_blank">
                                                        <i class="bi bi-file-text me-2"></i>Cetak Nilai
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php else : ?>
                                    <!-- Cek apakah nilai ada tapi belum diapprove -->
                                    <?php 
                                    $check_nilai_exists = query("SELECT * FROM tb_nilai 
                                                               WHERE id_pengajuan = '$id_pengajuan' 
                                                               AND id_user = '$id_user' 
                                                               AND status_active = '1'");
                                    $nilai_exists = !empty($check_nilai_exists);
                                    ?>
                                    
                                    <?php if($nilai_exists) : ?>
                                        <button class="btn btn-secondary btn-sm px-3" disabled title="Menunggu persetujuan admin">
                                            <i class="bi bi-hourglass"></i>
                                        </button>
                                    <?php else : ?>
                                        <button class="btn btn-secondary btn-sm px-3" disabled title="Belum ada nilai">
                                            <i class="bi bi-file-earmark-excel"></i>
                                        </button>
                                    <?php endif; ?>
                                <?php endif; ?>
                            </div>
                        </td>

                        <!-- Kolom Logbook & Laporan -->
                        <td class="text-center">
                            <div class="d-flex gap-1 justify-content-center flex-wrap">
                                <!-- Tombol Laporan -->
                                <a href="user3_logbook.php?id_pengajuan=<?= $data['id_pengajuan'] ?>" class="btn btn-info btn-sm px-3" title="Laporan">
                                    <i class="bi bi-journal-text"></i>
                                </a>

                                <!-- Tombol Logbook -->
                                <a href="user3_logbook.php?id_pengajuan=<?= $data['id_pengajuan'] ?>" class="btn btn-info btn-sm px-3" title="Logbook">
                                    <i class="bi bi-journal-bookmark"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                    
                    <!-- Modal Detail -->
                    <div class="modal fade" id="modalDetail<?= $data['id_pengajuan']; ?>" tabindex="-1" 
                         aria-labelledby="modalDetailLabel<?= $data['id_pengajuan']; ?>" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="modalDetailLabel<?= $data['id_pengajuan']; ?>">Detail Histori</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                <img src="../assets/img/user/<?= !empty($detail['gambar_instansi']) ? $detail['gambar_instansi'] : 'avatar.png' ?>" 
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