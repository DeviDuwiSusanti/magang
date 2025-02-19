<?php
include "../koneksi.php"; 
include "../layout/sidebarUser.php"; 

// Ambil id_user dari session atau parameter URL
$id_user = isset($_SESSION['id_user']) ? $_SESSION['id_user'] : (isset($_GET['id_user']) ? $_GET['id_user'] : null);

// Query untuk mengambil data pengajuan yang masih aktif berdasarkan ID user
$sql = "SELECT * 
        FROM tb_pengajuan, tb_profile_user, tb_user, tb_instansi, tb_bidang, tb_pendidikan 
        WHERE tb_pengajuan.id_user = tb_profile_user.id_user
        AND tb_profile_user.id_user = tb_user.id_user
        AND tb_profile_user.id_pendidikan = tb_pendidikan.id_pendidikan
        AND tb_pengajuan.id_instansi = tb_instansi.id_instansi
        AND tb_pengajuan.id_bidang = tb_bidang.id_bidang
        AND tb_pengajuan.status_pengajuan = 'Diterima'
        AND tb_pengajuan.id_user = '$id_user'";
if ($level == 4) {
    // Hanya ambil pengajuan yang ID-nya ada di profile user (untuk user level 4)
    $sql .= " AND tb_pengajuan.id_pengajuan IN (
                    SELECT id_pengajuan FROM tb_profile_user WHERE id_user = '$id_user'
                )";
} else {
    // Jika level 3 atau lainnya, ambil semua data yang sesuai
    $sql .= " AND tb_pengajuan.id_user = '$id_user'";
}
$query = mysqli_query($conn, $sql); 
$row = mysqli_fetch_assoc($query); 

?>

<div class="main-content p-4">
    <div class="container-fluid">
        <h1 class="mb-4">Kegiatan Aktif</h1>
        <ol class="breadcrumb mb-3">
            <li class="breadcrumb-item active">Kegiatan Aktif</li>
        </ol>
        <div class="dropdown-divider"></div>
        <div class="mb-4 text-end">
            <a href="kegiatan_aktif.php" class="btn btn-danger">
                <i class="bi bi-arrow-left-circle me-1"></i>
                Kembali
            </a>
        </div>

        <!-- Menampilkan informasi user -->
        <div class="container mt-5 mb-5">
            <div class="card mx-auto" style="max-width: 600px;">
                <div class="card-body top text-center">
                    <!-- Foto profil -->
                    <img src="../assets/img/user/<?= $row['gambar_user'] ?? 'default.png' ?>" class="rounded-circle mb-3" alt="Profile Picture" style="width: 100px; height: 100px;">
                    <h4 class="card-title"><?= $row['nama_user'] ?? 'Tidak Diketahui' ?></h4>
                    <p class="text-muted"><?= $row['email'] ?? 'Tidak Ada Email' ?></p>

                    <hr>
                    <div class="card-body">
                        <!-- Tabel informasi pengguna -->
                        <table class="table">
                            <tbody class="text-start">
                                <tr>
                                    <td><i class="bi bi-person"></i> <strong>Nama</strong></td>
                                    <td><?= $row['nama_user'] ?? 'Tidak Diketahui' ?></td>
                                </tr>
                                <tr>
                                    <td><i class="bi bi-mortarboard"></i> <strong>Universitas</strong></td>
                                    <td><?= $row['nama_pendidikan'] ?? 'Tidak Diketahui' ?></td>
                                </tr>
                                <tr>
                                    <td><i class="bi bi-building"></i> <strong>Perusahaan</strong></td>
                                    <td><?= $row['nama_panjang'] ?? 'Tidak Diketahui' ?></td>
                                </tr>
                                <tr>
                                    <td><i class="bi bi-shield-lock"></i> <strong>Bidang</strong></td>
                                    <td><?= $row['nama_bidang'] ?? 'Tidak Diketahui' ?></td>
                                </tr>
                                <tr>
                                    <td><i class="bi bi-hourglass-split"></i> <strong>Durasi</strong></td>
                                    <td>
                                        <?php 
                                            if (!empty($row['tanggal_mulai']) && !empty($row['tanggal_selesai'])) {
                                                $start_date = new DateTime($row['tanggal_mulai']);
                                                $end_date = new DateTime($row['tanggal_selesai']);
                                                $interval = $start_date->diff($end_date);
                                                echo ($interval->m + ($interval->y * 12)) . " Bulan";
                                            } else {
                                                echo "Durasi Tidak Diketahui";
                                            }
                                        ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td><i class="bi bi-calendar-event"></i> <strong>Periode</strong></td>
                                    <td>
                                        <?php 
                                            if (!empty($row['tanggal_mulai']) && !empty($row['tanggal_selesai'])) {
                                                echo date('d F Y', strtotime($row['tanggal_mulai'])) . ' - ' . date('d F Y', strtotime($row['tanggal_selesai']));
                                            } else {
                                                echo "Periode Tidak Diketahui";
                                            }
                                        ?>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <!-- Tombol untuk unggah logbook dan laporan akhir -->
                    <div class="mb-3">
                        <?php if (!empty($row['id_pengajuan'])) { ?>
                            <a href="logbook_unggah.php?id_pengajuan=<?= $row['id_pengajuan'] ?>&id_user=<?= $id_user ?>" class="btn btn-primary btn-sm me-2">
                                <i class="bi bi-file-earmark-text me-1"></i> Unggah Logbook
                            </a>
                            <a href="laprak_unggah.php?id_pengajuan=<?= $row['id_pengajuan'] ?>&id_user=<?= $id_user ?>" class="btn btn-success btn-sm">
                                <i class="bi bi-file-earmark-check me-1"></i> Unggah Laporan Akhir
                            </a>
                        <?php } else { ?>
                            <p class="text-danger">Data pengajuan tidak ditemukan.</p>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include "../layout/footerDashboard.php";?>